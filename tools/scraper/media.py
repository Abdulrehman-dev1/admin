import os
import re
import time
import hashlib
import pathlib
from urllib.parse import urlparse

import requests
from dotenv import load_dotenv


load_dotenv()


def _unique_name_from_url(url: str) -> str:
    parsed = urlparse(url)
    basename = os.path.basename(parsed.path) or "image"
    ext = os.path.splitext(basename)[1] or ".jpg"
    h = hashlib.sha1(url.encode("utf-8")).hexdigest()[:12]
    ts = str(int(time.time()))
    safe = re.sub(r"[^A-Za-z0-9_.-]", "_", os.path.splitext(basename)[0])
    return f"{ts}_{h}_{safe}{ext}"


def download_images(urls: list[str]) -> tuple[str | None, list[str]]:
    """
    Downloads images into ADMIN_PUBLIC_DIR/assets/images/auction and returns
    (cover_relative_path, album_array_of_relative_paths)
    """
    admin_public = os.getenv("ADMIN_PUBLIC_DIR")
    if not admin_public:
        raise RuntimeError("ADMIN_PUBLIC_DIR not set in environment")

    dest_dir = os.path.join(admin_public, "assets", "images", "auction")
    pathlib.Path(dest_dir).mkdir(parents=True, exist_ok=True)

    saved_rel: list[str] = []
    for u in urls:
        try:
            resp = requests.get(u, timeout=20)
            resp.raise_for_status()
            fname = _unique_name_from_url(u)
            abs_path = os.path.join(dest_dir, fname)
            with open(abs_path, "wb") as f:
                f.write(resp.content)
            # relative path for DB should start with /assets/images/auction/...
            rel_path = f"/assets/images/auction/{fname}"
            saved_rel.append(rel_path)
        except Exception:
            continue

    cover = saved_rel[0] if saved_rel else None
    return cover, saved_rel


