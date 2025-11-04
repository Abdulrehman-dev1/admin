import argparse
import json
import re
import sys

from playwright_fetch import fetch_pf_structured
from pf_parser import parse_propertyfinder_html


def get_first_line(text: str) -> str:
    """Get first line of text (or first 50 chars if no newlines)"""
    if not text:
        return ""
    lines = text.strip().split('\n')
    first_line = lines[0].strip() if lines else ""
    # If it's too long (more than 50 chars), truncate to first 50 chars
    if len(first_line) > 50:
        first_line = first_line[:47] + "..."
    return first_line


def normalize_property_type(prop_type: str) -> str:
    """Normalize property type for mapping"""
    if not prop_type:
        return ""
    prop_type_lower = prop_type.lower().strip()
    # Common variations
    if 'apartment' in prop_type_lower:
        return 'Apartment'
    elif 'villa' in prop_type_lower:
        return 'Villa'
    elif 'townhouse' in prop_type_lower or 'town house' in prop_type_lower:
        return 'Townhouse'
    elif 'plot' in prop_type_lower or 'land' in prop_type_lower:
        return 'Plot'
    elif 'office' in prop_type_lower:
        return 'Office'
    elif 'shop' in prop_type_lower or 'retail' in prop_type_lower:
        return 'Shop'
    return prop_type.strip()


def main():
    parser = argparse.ArgumentParser(description="Scrape PropertyFinder listing")
    parser.add_argument("url", help="PropertyFinder listing URL")
    parser.add_argument("--dry-run", action="store_true", help="Parse only; no DB")
    args = parser.parse_args()

    try:
        # Fetch using Playwright to get modals and structured data
        print("Starting fetch...", file=sys.stderr)
        result = fetch_pf_structured(args.url, headless=True, debug=False)
        print("Fetch completed", file=sys.stderr)
    except Exception as e:
        print(json.dumps({"error": f"Failed to fetch: {str(e)}"}, indent=2))
        return
    
    # Parse HTML with BeautifulSoup as fallback
    try:
        parsed = parse_propertyfinder_html(result.get("html", ""))
    except Exception as e:
        parsed = {}
    
    # Merge data: Playwright data takes precedence
    title = result.get("title") or parsed.get("title")
    price_aed = result.get("price_aed") or parsed.get("price_aed")
    description = result.get("description") or parsed.get("description_html") or ""
    property_type = result.get("property_type") or parsed.get("property_type") or ""
    location_text = result.get("location_text") or parsed.get("location_text") or ""
    amenities = result.get("amenities") or parsed.get("amenities") or []
    images = result.get("images_property") or []
    
    # Clean description HTML if needed
    if description and "<" in description:
        from bs4 import BeautifulSoup
        soup = BeautifulSoup(description, "lxml")
        description = soup.get_text(separator="\n", strip=True)
    
    # Transform data according to user requirements
    # Title: first line of description
    output_title = get_first_line(description) if description else (title or "No title")
    
    # Description: full description
    output_description = description or ""
    
    # Images: all images
    output_images = images if images else []
    
    # Price: use for both minimum_bid and reserve_price
    output_price = float(price_aed) if price_aed else 0.0
    
    # Property type normalization
    normalized_property_type = normalize_property_type(property_type)
    
    # Output JSON with all fields for preview
    output = {
        "title": output_title,
        "description": output_description,
        "images": output_images,
        "image_count": len(output_images),
        "minimum_bid": output_price,
        "reserve_price": output_price,
        "property_type": normalized_property_type,
        "property_type_raw": property_type,
        "location_text": location_text,
        "amenities": amenities,
        "amenities_count": len(amenities),
        "category": "property",  # Will be mapped to category_id later
        "sub_category": "for sale",  # Will be mapped to sub_category_id later
        "child_category": normalized_property_type,  # Will be mapped to child_category_id later
        "price_aed": output_price,
        "html": result.get("html", ""),  # Keep for debugging
    }
    
    print(json.dumps(output, indent=2))


if __name__ == "__main__":
    main()
