import requests
from bs4 import BeautifulSoup


def fetch_section(url: str) -> dict:
    """Fetch ONLY the styles_desktop_top-section__ielYe section, attributes, AND gallery modal"""
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
    }
    
    resp = requests.get(url, headers=headers, timeout=30)
    resp.raise_for_status()
    
    soup = BeautifulSoup(resp.text, 'lxml')
    
    # Find the section
    section = soup.find('section', class_='styles_desktop_top-section__ielYe')
    
    # Find the gallery modal
    gallery_modal = soup.find('div', class_='styles-module_gallery-full-screen__container__xk5eH')
    
    # Find the attributes section - check both class combinations
    attributes_section = soup.find('div', class_='styles_attributes__t5SLf styles_desktop_attributes__n1C_4')
    if not attributes_section:
        attributes_section = soup.find('div', class_='styles_attributes__t5SLf')
    
    # Find the description section
    description_section = soup.find('div', id='description', class_='styles_desktop_navigable-section__Zqa_u')
    
    # Find the description modal
    description_modal = soup.find('div', role='dialog', attrs={'aria-modal': 'true', 'aria-labelledby': 'modal-title'})
    
    html_parts = []
    # Only attributes, description, modals - NO top section with breadcrumbs
    if attributes_section:
        html_parts.append(str(attributes_section))
    if description_section:
        html_parts.append(str(description_section))
    if description_modal:
        html_parts.append(str(description_modal))
    if gallery_modal:
        html_parts.append(str(gallery_modal))
    
    combined_html = "\n".join(html_parts)
    
    # Get all images from the ENTIRE page that match property images
    images = []
    
    # Get ALL images from the page
    all_images = soup.find_all('img')
    
    for img in all_images:
        src = img.get('src') or img.get('data-src')
        if src and 'propertyfinder.ae/property/' in src:
            # Filter to only property images (not logos, icons, etc)
            if not any(skip in src.lower() for skip in ['logo', 'icon', 'avatar', 'profile', 'mortgage', 'whatsapp', 'placeholder', 'agent', 'brand']):
                images.append(src)
    
    # Remove duplicates while preserving order
    seen = set()
    unique_images = []
    for img in images:
        if img not in seen:
            seen.add(img)
            unique_images.append(img)
    
    return {
        "html": combined_html,
        "images": unique_images
    }

