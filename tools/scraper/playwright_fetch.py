import asyncio
import contextlib
import os
import re
from typing import Any, Dict, List, Optional

from playwright.sync_api import sync_playwright


def fetch_pf_structured(url: str, headless: bool = True, debug: bool = False) -> Dict[str, Any]:
    # Get HTML sections AND images
    data: Dict[str, Any] = {
        "html": "",
        "images_property": [],
    }

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=headless)
        page = browser.new_page(user_agent=(
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
            "(KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36"
        ))
        page.set_default_timeout(30000)

        if debug:
            print(f"Navigating to {url}...")
        page.goto(url, wait_until="domcontentloaded", timeout=8000)
        page.wait_for_timeout(500)  # Let page fully render
        
        # attempt to accept cookies if present
        with contextlib.suppress(Exception):
            page.get_by_role("button", name=("Accept" or "I agree"), exact=False).click()

        if debug:
            print("Page loaded, extracting sections and images...")

        # Click "See full description" to open modal
        with contextlib.suppress(Exception):
            desc_btn = page.locator('button[data-testid="button--secondary"]').first
            if desc_btn.count() > 0:
                if debug:
                    print("Clicking 'See full description'...")
                desc_btn.click()
                page.wait_for_timeout(500)
        
        # Click "See all amenities" to open modal
        with contextlib.suppress(Exception):
            amen_btn = page.get_by_text("See all amenities", exact=False).first
            if amen_btn.count() > 0:
                if debug:
                    print("Clicking 'See all amenities'...")
                amen_btn.click()
                page.wait_for_timeout(500)

        # Click gallery button to open image modal
        with contextlib.suppress(Exception):
            gallery_btn = page.locator('[data-testid="plp-gallery-button"], [data-testid="gallery-image-button"]').first
            if gallery_btn.count() > 0:
                if debug:
                    print("Clicking gallery button...")
                gallery_btn.click()
                page.wait_for_timeout(500)  # Wait for modal to load

        # Extract images using SPECIFIC user-provided selectors
        try:
            if debug:
                print("Extracting images with specific selectors...")
            
            # User wants these EXACT selectors:
            # 1. div.styles_desktop_image--big__wnpkg img.styles_desktop_responsive-image__GLmXD
            # 2. button img.styles_desktop_responsive-image__GLmXD
            urls = page.evaluate("""
                () => {
                    const out = [];
                    const seen = new Set();
                    
                    // Main images: div.styles_desktop_image--big__wnpkg img.styles_desktop_responsive-image__GLmXD
                    const mainImgs = document.querySelectorAll('div.styles_desktop_image--big__wnpkg img.styles_desktop_responsive-image__GLmXD');
                    mainImgs.forEach(img => {
                        const src = img.src || img.currentSrc || img.getAttribute('data-src') || '';
                        if (src && !seen.has(src)) {
                            seen.add(src);
                            out.push(src);
                        }
                    });
                    
                    // Button images: button img.styles_desktop_responsive-image__GLmXD
                    const buttonImgs = document.querySelectorAll('button img.styles_desktop_responsive-image__GLmXD');
                    buttonImgs.forEach(img => {
                        const src = img.src || img.currentSrc || img.getAttribute('data-src') || '';
                        if (src && !seen.has(src)) {
                            seen.add(src);
                            out.push(src);
                        }
                    });
                    
                    // Also try general gallery images on page
                    const galleryImgs = document.querySelectorAll('[data-testid*="gallery"] img, [class*="gallery"] img');
                    galleryImgs.forEach(img => {
                        const src = img.src || img.currentSrc || img.getAttribute('data-src') || '';
                        if (src && (src.includes('propertyfinder.ae') || src.includes('pf-graph-images')) && !seen.has(src)) {
                            seen.add(src);
                            out.push(src);
                        }
                    });
                    
                    // Gallery modal images - all images from the modal including thumbnails
                    const modalImgs = document.querySelectorAll('div.styles-module_gallery-full-screen__container__xk5eH img');
                    modalImgs.forEach(img => {
                        const src = img.src || img.currentSrc || img.getAttribute('data-src') || '';
                        if (src && (src.includes('propertyfinder.ae') || src.includes('pf-graph-images')) && !seen.has(src)) {
                            seen.add(src);
                            out.push(src);
                        }
                    });
                    
                    return out;
                }
            """)
            
            if debug:
                print(f"Found {len(urls)} images via selectors")
                for idx, u in enumerate(urls):
                    print(f"  {idx}: {u}")
            
            data["images_property"] = urls if urls else []
            if debug:
                print(f"Extracted {len(urls)} images using specific selectors")
        except Exception as e:
            if debug:
                print(f"Error in image extraction: {e}")
            pass

        # Extract structured data (title, price, description, property_type, location, amenities)
        try:
            if debug:
                print("Extracting structured data...")
            
            structured = page.evaluate("""
                () => {
                    const result = {
                        title: null,
                        price_aed: null,
                        description: null,
                        property_type: null,
                        location_text: null,
                        amenities: []
                    };
                    
                    // Title
                    const h1 = document.querySelector('h1');
                    if (h1) result.title = h1.textContent.trim();
                    
                    // Price - try span first (newer format), then div
                    let priceEl = document.querySelector('span[data-testid="property-price-value"]');
                    if (!priceEl) {
                        priceEl = document.querySelector('div[data-testid="property-price-value"]');
                    }
                    if (priceEl) {
                        const txt = priceEl.textContent.replace(/[^0-9,]/g, '').replace(/,/g, '');
                        if (txt && txt.length <= 15) {
                            result.price_aed = parseFloat(txt);
                        }
                    }
                    
                    // Description - try modal first, then section
                    let descEl = document.querySelector('div[role="dialog"][aria-modal="true"][aria-labelledby="modal-title"] [data-testid="dynamic-sanitize-html"]');
                    if (!descEl) {
                        descEl = document.querySelector('div#description.styles_desktop_navigable-section__Zqa_u [data-testid="dynamic-sanitize-html"]');
                    }
                    if (!descEl) {
                        descEl = document.querySelector('div#description.styles_desktop_navigable-section__Zqa_u');
                    }
                    if (descEl) result.description = descEl.textContent.trim();
                    
                    // Property type
                    const typeEl = document.querySelector('[data-testid="property-details-type"]');
                    if (typeEl) {
                        result.property_type = typeEl.textContent.trim();
                    } else {
                        // Fallback: look for "Property type" label
                        const labels = Array.from(document.querySelectorAll('*')).filter(el => el.textContent && el.textContent.includes('Property type'));
                        if (labels.length > 0) {
                            const parent = labels[0].closest('div');
                            if (parent) {
                                const value = parent.querySelector('div:last-child, span:last-child');
                                if (value) result.property_type = value.textContent.trim();
                            }
                        }
                    }
                    
                    // Location from map section
                    const mapTitle = document.querySelector('p.styles-module_map__title__M2mBC');
                    if (mapTitle) result.location_text = mapTitle.textContent.trim();
                    
                    // Amenities - from modal or section
                    let amenEls = [];
                    const amenModal = document.querySelector('div[data-testid="modal-body"].styles_modal__rRL_U');
                    if (amenModal && amenModal.textContent.includes('Amenities')) {
                        amenEls = Array.from(amenModal.querySelectorAll('li, [data-testid*="amenity"]'));
                    } else {
                        const amenSection = document.querySelector('section#amenities[data-testid="amenities-section"]');
                        if (amenSection) {
                            amenEls = Array.from(amenSection.querySelectorAll('li, [data-testid*="amenity"]'));
                        }
                    }
                    result.amenities = amenEls.map(el => el.textContent.trim()).filter(t => t);
                    
                    return result;
                }
            """)
            
            data.update(structured)
            if debug:
                print(f"Extracted structured data: title={structured.get('title')}, price={structured.get('price_aed')}, property_type={structured.get('property_type')}")
        except Exception as e:
            if debug:
                print(f"Error in structured data extraction: {e}")
            pass

        # Skip HTML extraction for speed - we already have structured data
        data["html"] = ""

        browser.close()
    return data


