#!/usr/bin/env python3
"""
OLX Scraper - Scrapes product data from OLX listings
"""
import argparse
import json
import sys
from playwright.sync_api import sync_playwright


def scrape_olx(url: str, headless: bool = True, debug: bool = False) -> dict:
    """
    Scrape OLX product listing
    Returns dictionary with: title, price, description, images, location, etc.
    """
    if debug:
        print(f"Starting OLX scraper for URL: {url}", file=sys.stderr)
    
    result = {
        "title": None,
        "price": None,
        "minimum_bid": 0,
        "reserve_price": 0,
        "description": None,
        "images": [],
        "location_text": None,
        "amenities": []
    }
    
    try:
        with sync_playwright() as p:
            if debug:
                print(f"Launching browser (headless={headless})", file=sys.stderr)
            
            browser = p.chromium.launch(headless=headless)
            page = browser.new_page(user_agent=(
                "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
                "(KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36"
            ))
            page.set_default_timeout(30000)
            
            # Navigate to URL
            if debug:
                print("Navigating to URL...", file=sys.stderr)
            page.goto(url, wait_until="domcontentloaded", timeout=15000)
            page.wait_for_timeout(2000)  # Wait for dynamic content
            if debug:
                print(f"Page loaded, URL: {page.url}", file=sys.stderr)
            
            # Extract data using Playwright's evaluate
            # TODO: User will provide specific selectors
            
            if debug:
                print("Extracting data...", file=sys.stderr)
            
            # Extract OLX data
            page_data = page.evaluate("""
                () => {
                    const result = {
                        title: null,
                        price: null,
                        description: null,
                        images: [],
                        location_text: null
                    };
                    
                    // Title
                    const h1 = document.querySelector('h1');
                    if (h1) result.title = h1.textContent.trim();
                    
                    // Images from image-gallery - prefer JPEG over webp
                    const gallerySlides = document.querySelectorAll('.image-gallery-slide');
                    const seenUrls = new Set();
                    gallerySlides.forEach(slide => {
                        const img = slide.querySelector('picture img');
                        if (img) {
                            const src = img.getAttribute('src');
                            if (src && !seenUrls.has(src)) {
                                seenUrls.add(src);
                                result.images.push(src);
                            }
                        }
                    });
                    
                    // Fallback: if no images found, try source tags
                    if (result.images.length === 0) {
                        const sources = document.querySelectorAll('.image-gallery-slide picture source');
                        sources.forEach(source => {
                            const srcset = source.getAttribute('srcset');
                            if (srcset && !seenUrls.has(srcset)) {
                                seenUrls.add(srcset);
                                result.images.push(srcset);
                            }
                        });
                    }
                    
                    // Price - look for price text
                    const priceMatch = document.body.innerText.match(/Rs\s+([\d,]+)/);
                    if (priceMatch) {
                        result.price = priceMatch[1].replace(/,/g, '');
                    }
                    
                    // Description - look for description section by aria-label
                    const descEl = document.querySelector('div[aria-label="Description"] ._7a99ad24 span');
                    if (descEl) {
                        result.description = descEl.textContent.trim();
                    } else {
                        // Fallback: find any div with text starting with typical description patterns
                        const descElFallback = Array.from(document.querySelectorAll('._7a99ad24 span')).find(el => el.textContent && el.textContent.length > 50);
                        if (descElFallback) {
                            result.description = descElFallback.textContent.trim();
                        }
                    }
                    
                    // Location - look for location text
                    const locMatch = document.body.innerText.match(/Model Colony.*Karachi/);
                    if (locMatch) {
                        result.location_text = locMatch[0];
                    }
                    
                    return result;
                }
            """)
            
            result["title"] = page_data.get("title")
            result["images"] = page_data.get("images", [])
            result["price"] = page_data.get("price")
            result["description"] = page_data.get("description")
            result["location_text"] = page_data.get("location_text")
            
            # Convert price from PKR to AED
            # PKR to AED conversion rate: 1 PKR = 0.01307 AED (based on Wise.com mid-market rate)
            PKR_TO_AED_RATE = 0.01307
            
            if result["price"]:
                try:
                    pkr_price = float(result["price"])
                    aed_price = pkr_price * PKR_TO_AED_RATE
                    result["minimum_bid"] = aed_price
                    result["reserve_price"] = aed_price
                except:
                    pass
            
            browser.close()
            
    except Exception as e:
        if debug:
            print(f"Error in scraping: {e}", file=sys.stderr)
        result["error"] = str(e)
    
    return result


def main():
    parser = argparse.ArgumentParser(description="Scrape OLX listing")
    parser.add_argument("url", help="OLX listing URL")
    parser.add_argument("--dry-run", action="store_true", help="Parse only; no DB")
    args = parser.parse_args()

    try:
        # Fetch data
        print("Starting OLX fetch...", file=sys.stderr)
        data = scrape_olx(args.url, headless=True, debug=False)
        print("Fetch completed", file=sys.stderr)
    except Exception as e:
        print(json.dumps({"error": f"Failed to fetch: {str(e)}"}, indent=2))
        return
    
    # Ensure all required fields
    data["title"] = data.get("title") or "No title"
    data["description"] = data.get("description") or ""
    data["images"] = data.get("images") or []
    data["minimum_bid"] = float(data.get("minimum_bid") or 0)
    data["reserve_price"] = float(data.get("reserve_price") or 0)
    data["image_count"] = len(data.get("images", []))
    
    # Output JSON
    print(json.dumps(data, indent=2))


if __name__ == "__main__":
    main()

