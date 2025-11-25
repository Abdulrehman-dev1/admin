#!/usr/bin/env python3
"""
OLX Scraper - Scrapes product data from OLX listings
"""
import argparse
import json
import sys
import os

# Set Playwright browsers path (try multiple locations)
# Priority: 1. Global, 2. Root cache, 3. Temp location, 4. Current user cache
# Force use global location if it exists
if not os.environ.get('PLAYWRIGHT_BROWSERS_PATH'):
    # Try multiple locations in order of preference
    global_cache = '/usr/local/share/playwright'
    root_cache = '/root/.cache/ms-playwright'
    temp_cache = '/tmp/playwright-browsers'
    user_cache = os.path.expanduser('~/.cache/ms-playwright')
    
    # Check if global location exists and has chromium
    if os.path.exists(global_cache) and os.path.exists(os.path.join(global_cache, 'chromium-1140')):
        os.environ['PLAYWRIGHT_BROWSERS_PATH'] = global_cache
    elif os.path.exists(root_cache) and os.path.exists(os.path.join(root_cache, 'chromium-1140')):
        os.environ['PLAYWRIGHT_BROWSERS_PATH'] = root_cache
    elif os.path.exists(temp_cache):
        os.environ['PLAYWRIGHT_BROWSERS_PATH'] = temp_cache
    elif os.path.exists(user_cache):
        os.environ['PLAYWRIGHT_BROWSERS_PATH'] = user_cache

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
            
            # Launch browser with minimal arguments to avoid memory/address space issues
            # Use single-process mode and minimal features
            browser_args = [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--single-process',  # Critical: Use single-process mode to avoid partition_address_space issues
                '--disable-gpu',
                '--disable-software-rasterizer',
                '--disable-extensions',
                '--disable-background-networking',
                '--disable-background-timer-throttling',
                '--disable-backgrounding-occluded-windows',
                '--disable-breakpad',
                '--disable-component-update',
                '--disable-default-apps',
                '--disable-features=TranslateUI,VizDisplayCompositor,BlinkGenPropertyTrees',
                '--disable-ipc-flooding-protection',
                '--disable-renderer-backgrounding',
                '--disable-sync',
                '--metrics-recording-only',
                '--mute-audio',
                '--no-first-run',
                '--safebrowsing-disable-auto-update',
                '--enable-automation',
                '--password-store=basic',
                '--use-mock-keychain',
                '--disable-web-security',
                '--disable-accelerated-2d-canvas',
                '--disable-accelerated-video-decode',
                '--disable-2d-canvas-clip-aa',
                '--disable-2d-canvas-image-chromium',
                '--disable-background-downloads',
                '--disable-client-side-phishing-detection',
                '--disable-component-extensions-with-background-pages',
                '--disable-default-apps',
                '--disable-hang-monitor',
                '--disable-popup-blocking',
                '--disable-prompt-on-repost',
                '--disable-translate',
                '--disable-web-resources',
                '--disable-features=AudioServiceOutOfProcess',
            ]
            
            # Try to launch browser with retry logic
            max_retries = 2
            browser = None
            for attempt in range(max_retries):
                try:
                    if debug:
                        print(f"Browser launch attempt {attempt + 1}...", file=sys.stderr)
                    browser = p.chromium.launch(
                        headless=headless,
                        args=browser_args,
                        timeout=120000  # 120 seconds timeout (increased)
                    )
                    if debug:
                        print("Browser launched successfully", file=sys.stderr)
                    break
                except Exception as e:
                    if debug:
                        print(f"Browser launch attempt {attempt + 1} failed: {e}", file=sys.stderr)
                    if attempt < max_retries - 1:
                        import time
                        time.sleep(3)  # Wait before retry
                    else:
                        raise
            
            # Wait for browser to fully initialize
            import time
            time.sleep(2)
            
            # Verify browser is still alive
            if not browser or not browser.is_connected():
                raise Exception("Browser closed immediately after launch")
            
            if debug:
                print("Creating browser context...", file=sys.stderr)
            context = browser.new_context(
                user_agent="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                viewport={'width': 1920, 'height': 1080},
                locale='en-US',
                timezone_id='Asia/Karachi',
            )
            
            # Wait for context to initialize
            time.sleep(1)
            
            if debug:
                print("Creating new page...", file=sys.stderr)
            
            # Verify browser is still connected before creating page
            if not browser.is_connected():
                raise Exception("Browser disconnected before creating page")
            
            page = context.new_page()
            page.set_default_timeout(120000)  # Increased timeout to 120 seconds
            
            # Wait a bit for page to stabilize
            time.sleep(2)
            
            # Set additional headers to avoid bot detection
            page.set_extra_http_headers({
                'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language': 'en-US,en;q=0.9',
                'Accept-Encoding': 'gzip, deflate, br',
                'Connection': 'keep-alive',
                'Upgrade-Insecure-Requests': '1',
                'Sec-Fetch-Dest': 'document',
                'Sec-Fetch-Mode': 'navigate',
                'Sec-Fetch-Site': 'none',
            })
            
            # Navigate to URL
            if debug:
                print("Navigating to URL...", file=sys.stderr)
            
            # Additional wait and check before navigation
            time.sleep(2)  # Wait before navigation
            
            # Final check before navigation
            if not browser.is_connected():
                raise Exception("Browser disconnected before navigation")
            
            if page.is_closed():
                raise Exception("Page closed before navigation")
            
            # Navigate with retry logic and better error handling
            try:
                if debug:
                    print("Navigating to URL...", file=sys.stderr)
                
                # Check if browser is still alive
                if not browser.is_connected():
                    raise Exception("Browser disconnected before navigation")
                
                # Use shorter timeout and commit wait strategy to avoid browser closing
                page.goto(url, wait_until="commit", timeout=20000)
                
                # Immediately check if browser and page are still alive
                if not browser.is_connected():
                    raise Exception("Browser disconnected immediately after navigation")
                
                if page.is_closed():
                    raise Exception("Page closed immediately after navigation")
                
                # Small wait to let browser stabilize
                time.sleep(1)
                
                # Check again before continuing
                if not browser.is_connected() or page.is_closed():
                    raise Exception("Browser/page closed during stabilization")
                
                # Wait for dynamic content with multiple checks
                for wait_iteration in range(4):
                    time.sleep(1)
                    if not browser.is_connected() or page.is_closed():
                        raise Exception(f"Browser/page closed during wait iteration {wait_iteration + 1}")
                
                # Final check before proceeding
                if not browser.is_connected() or page.is_closed():
                    raise Exception("Browser/page closed after waiting for content")
                
                # Skip wait_for_selector to avoid browser closing
                # Directly proceed to data extraction after navigation
                # The page should be loaded enough after domcontentloaded + wait
                if debug:
                    print("Skipping wait_for_selector to avoid browser stability issues, proceeding to data extraction...", file=sys.stderr)
            except Exception as nav_error:
                if debug:
                    print(f"Navigation error: {nav_error}", file=sys.stderr)
                
                # Check if browser is still alive before retry
                if browser.is_connected():
                    try:
                        # Try again with different wait strategy
                        page.goto(url, wait_until="load", timeout=30000)
                        page.wait_for_timeout(5000)
                    except Exception as retry_error:
                        if debug:
                            print(f"Retry navigation also failed: {retry_error}", file=sys.stderr)
                        raise retry_error
                else:
                    raise Exception("Browser disconnected, cannot retry navigation")
            # Wait a bit more for page to fully stabilize
            time.sleep(3)
            
            # Check if browser and page are still alive before any operations
            if not browser.is_connected():
                raise Exception("Browser disconnected after navigation")
            
            if page.is_closed():
                raise Exception("Page closed after navigation")
            
            # Skip page.title() and page.url() calls as they cause browser to close
            # Use fallback values and proceed directly to data extraction
            page_title = "Unknown"
            current_url = url
            
            if debug:
                print(f"Page loaded, URL: {current_url}", file=sys.stderr)
                print("Skipping page.title() to avoid browser closing, proceeding directly to data extraction...", file=sys.stderr)
            
            if debug:
                print(f"Page title: {page_title}", file=sys.stderr)
            
            # Check for error/not found pages
            if ("error" in current_url.lower() or 
                "not found" in page_title.lower() or 
                "oops" in page_title.lower() or 
                "error" in page_title.lower()):
                if debug:
                    print("WARNING: Page might be an error/not found page!", file=sys.stderr)
                result["error"] = f"OLX page not found or error: {page_title}. URL might be invalid or page removed."
                try:
                    context.close()
                except:
                    pass
                try:
                    browser.close()
                except:
                    pass
                return result
            
            # Extract data using Playwright's evaluate
            # TODO: User will provide specific selectors
            
            # Final check before data extraction
            if not browser.is_connected() or page.is_closed():
                raise Exception("Browser/page closed before data extraction")
            
            # Additional wait before data extraction to let browser stabilize
            time.sleep(2)
            
            # Check again
            if not browser.is_connected() or page.is_closed():
                raise Exception("Browser/page closed during stabilization before data extraction")
            
            if debug:
                print("Extracting data...", file=sys.stderr)
            
            # Extract OLX data - using step-by-step extraction to avoid browser closing
            # Extract each field separately to minimize memory usage
            page_data = {}
            
            try:
                # Step 1: Extract title (simplest, fastest)
                if not browser.is_connected() or page.is_closed():
                    raise Exception("Browser/page closed before title extraction")
                
                title_data = page.evaluate(r"""() => {
                    const titleEl = document.querySelector('h1._75bce902') || document.querySelector('h1');
                    return titleEl ? titleEl.textContent.trim() : null;
                }""")
                page_data["title"] = title_data
                
                # Step 2: Extract price
                if not browser.is_connected() or page.is_closed():
                    raise Exception("Browser/page closed before price extraction")
                
                price_data = page.evaluate(r"""() => {
                    const priceEl = document.querySelector('span._24469da7[aria-label="Price"]') ||
                                   document.querySelector('span._24469da7') ||
                                   document.querySelector('[aria-label="Price"]');
                    if (!priceEl) return null;
                    const priceText = priceEl.textContent.trim();
                    let priceMatch = priceText.match(/Rs\s+([\d.]+)\s*Lac/i);
                    if (priceMatch) {
                        const lacValue = parseFloat(priceMatch[1]);
                        return Math.round(lacValue * 100000).toString();
                    }
                    priceMatch = priceText.match(/Rs\s+([\d,.]+)/i);
                    return priceMatch ? priceMatch[1].replace(/,/g, '') : null;
                }""")
                page_data["price"] = price_data
                
                # Step 3: Extract images (most memory intensive, do last)
                if not browser.is_connected() or page.is_closed():
                    raise Exception("Browser/page closed before image extraction")
                
                images_data = page.evaluate(r"""() => {
                    const images = [];
                    const seenUrls = new Set();
                    const gallerySlides = document.querySelectorAll('.image-gallery-slide');
                    gallerySlides.forEach(slide => {
                        const img = slide.querySelector('picture img');
                        if (img) {
                            const src = img.getAttribute('src');
                            if (src && !seenUrls.has(src) && src.startsWith('http')) {
                                seenUrls.add(src);
                                images.push(src);
                            }
                        }
                    });
                    if (images.length === 0) {
                        const galleryImgs = document.querySelectorAll('.image-gallery img');
                        galleryImgs.forEach(img => {
                            const src = img.getAttribute('src') || img.getAttribute('data-src');
                            if (src && !seenUrls.has(src) && src.startsWith('http') && 
                                src.includes('olx.com.pk') && !src.includes('logo') && !src.includes('icon')) {
                                seenUrls.add(src);
                                images.push(src);
                            }
                        });
                    }
                    return images;
                }""")
                page_data["images"] = images_data
                
                # Step 4: Extract description
                if not browser.is_connected() or page.is_closed():
                    raise Exception("Browser/page closed before description extraction")
                
                desc_data = page.evaluate(r"""() => {
                    const descEl = document.querySelector('div[aria-label="Description"] ._7a99ad24 span') ||
                                   document.querySelector('div._7a99ad24 span');
                    return descEl ? descEl.textContent.trim() : null;
                }""")
                page_data["description"] = desc_data
                
                # Step 5: Extract location
                if not browser.is_connected() or page.is_closed():
                    raise Exception("Browser/page closed before location extraction")
                
                loc_data = page.evaluate(r"""() => {
                    const locEl = document.querySelector('span._8206696c[aria-label="Location"]') ||
                                  document.querySelector('span._8206696c');
                    if (!locEl) return null;
                    const locText = locEl.textContent.trim();
                    return locText.replace(/\s+/g, ' ').trim();
                }""")
                page_data["location_text"] = loc_data
            except Exception as eval_error:
                # Check if browser closed during evaluation
                if not browser.is_connected() or page.is_closed():
                    raise Exception(f"Browser/page closed during data extraction: {eval_error}")
                # Browser is alive but evaluation failed
                raise
            
            if page_data is None:
                raise Exception("Data extraction returned None")
            
            result["title"] = page_data.get("title")
            result["images"] = page_data.get("images", [])
            result["price"] = page_data.get("price")
            result["description"] = page_data.get("description")
            result["location_text"] = page_data.get("location_text")
            
            if debug:
                print(f"Extracted - Title: {result['title']}, Price: {result['price']}, Images: {len(result['images'])}", file=sys.stderr)
            
            # Convert price from PKR to AED
            # PKR to AED conversion rate: 1 PKR = 0.01307 AED (based on Wise.com mid-market rate)
            PKR_TO_AED_RATE = 0.01307
            
            if result["price"]:
                try:
                    # Price is already in PKR (handled in JavaScript for "Lac" format)
                    pkr_price = float(result["price"])
                    aed_price = pkr_price * PKR_TO_AED_RATE
                    result["minimum_bid"] = round(aed_price, 2)
                    result["reserve_price"] = round(aed_price, 2)
                except Exception as e:
                    if debug:
                        print(f"Price conversion error: {e}", file=sys.stderr)
                    pass
            
            # Close browser and context properly
            try:
                context.close()
            except Exception as e:
                if debug:
                    print(f"Error closing context: {e}", file=sys.stderr)
            try:
                browser.close()
            except Exception as e:
                if debug:
                    print(f"Error closing browser: {e}", file=sys.stderr)
            
    except Exception as e:
        if debug:
            print(f"Error in scraping: {e}", file=sys.stderr)
        result["error"] = str(e)
    
    return result


def main():
    parser = argparse.ArgumentParser(description="Scrape OLX listing")
    parser.add_argument("url", help="OLX listing URL")
    parser.add_argument("--dry-run", action="store_true", help="Parse only; no DB")
    parser.add_argument("--headless", action="store_true", default=True, help="Run browser in headless mode (default: True)")
    parser.add_argument("--no-headless", dest="headless", action="store_false", help="Run browser with GUI (for debugging)")
    args = parser.parse_args()

    try:
        # Fetch data
        print("Starting OLX fetch...", file=sys.stderr)
        data = scrape_olx(args.url, headless=args.headless, debug=True)
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