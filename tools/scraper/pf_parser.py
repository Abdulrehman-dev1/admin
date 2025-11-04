from bs4 import BeautifulSoup
from typing import Any


def parse_propertyfinder_html(html: str) -> dict[str, Any]:
    soup = BeautifulSoup(html, "lxml")

    # title
    title = None
    h1 = soup.find("h1")
    if h1 and h1.get_text(strip=True):
        title = h1.get_text(strip=True)

    # price - PF often shows like "AED 1,400,000" in strong spans
    # Be very strict: only look at elements with specific testids
    price_aed = None
    # Try span first (newer format), then div
    price_el = soup.find("span", {"data-testid": "property-price-value"}) or soup.find("div", {"data-testid": "property-price-value"})
    if price_el:
        txt = price_el.get_text(" ", strip=True)
        # Extract only digits and commas, ensure reasonable length
        price_str = ''.join(ch for ch in txt if ch.isdigit() or ch == ',')
        # Clean and validate
        if price_str:
            # Remove commas
            price_str = price_str.replace(',', '')
            # Only proceed if it looks like a reasonable price (not HTML noise)
            if len(price_str) > 0 and len(price_str) <= 15:  # Max 15 digits
                try:
                    price_aed = float(price_str)
                except Exception:
                    price_aed = None

    # developer name
    developer = None
    dev_labels = soup.find_all(string=lambda s: s and "Developer" in s)
    for lbl in dev_labels:
        val = getattr(lbl.parent, 'find_next', lambda *a, **k: None)("*", string=False)
        if val and val.get_text(strip=True):
            developer = val.get_text(strip=True)
            break

    # description block
    description_html = None
    desc_candidates = soup.select("[data-testid='property-description'], .description, .description__text")
    if desc_candidates:
        # keep inner HTML
        description_html = ''.join(str(c) for c in desc_candidates)

    # property type
    property_type = None
    type_labels = soup.find_all(string=lambda s: s and "Property type" in s)
    for lbl in type_labels:
        cell = lbl.find_parent().find_next_sibling()
        if cell:
            property_type = cell.get_text(strip=True)
            break
    if not property_type:
        # fallback from breadcrumb or url hints
        crumb = soup.find("nav")
        if crumb and crumb.get_text():
            txt = crumb.get_text(" ", strip=True).lower()
            for cand in ["apartment","villa","townhouse","plot","office","shop"]:
                if cand in txt:
                    property_type = cand.title()
                    break

    # amenities and facilities – collect list items labelled sections
    amenities: list[str] = []
    facilities: list[str] = []
    for section_title in soup.find_all(["h2","h3","h4" ]):
        st = section_title.get_text(strip=True).lower()
        if any(k in st for k in ["amenities","features"]):
            ul = section_title.find_next("ul")
            if ul:
                for li in ul.find_all("li"):
                    txt = li.get_text(strip=True)
                    if txt:
                        amenities.append(txt)
        if any(k in st for k in ["facilities"]):
            ul = section_title.find_next("ul")
            if ul:
                for li in ul.find_all("li"):
                    txt = li.get_text(strip=True)
                    if txt:
                        facilities.append(txt)

    # location text
    location_text = None
    
    # Try map section title first (better source)
    map_title = soup.find('p', class_='styles-module_map__title__M2mBC')
    if map_title:
        location_text = map_title.get_text(" ", strip=True)
    
    # Fallback to address
    if not location_text:
        address = soup.find(attrs={"itemprop":"address"}) or soup.find("address")
        if address:
            location_text = address.get_text(" ", strip=True)

    # payment plan (if exists as table or section)
    payment_plan_html = None
    pay_hdr = soup.find(string=lambda s: s and "Payment Plan" in s)
    if pay_hdr:
        cont = pay_hdr.find_parent()
        if cont:
            next_block = cont.find_next(["table","div","section"])
            if next_block:
                payment_plan_html = str(next_block)

    # images – og:image + gallery imgs
    # DISABLED: Playwright handles images via specific selectors
    # This parser is used as fallback for non-Playwright mode
    image_urls: list[str] = []
    final_imgs = []

    return {
        "title": title,
        "price_aed": price_aed,
        "developer": developer,
        "description_html": description_html,
        "property_type": property_type,
        "amenities": amenities,
        "facilities": facilities,
        "location_text": location_text,
        "payment_plan_html": payment_plan_html,
        "images": final_imgs,
    }


