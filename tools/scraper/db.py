import os
import mysql.connector
from dotenv import load_dotenv


load_dotenv()


def get_connection():
    return mysql.connector.connect(
        host=os.getenv("DB_HOST", "127.0.0.1"),
        port=int(os.getenv("DB_PORT", "3306")),
        database=os.getenv("DB_NAME"),
        user=os.getenv("DB_USER"),
        password=os.getenv("DB_PASS"),
        autocommit=False,
    )


def get_category_id_by_name(cursor, name: str):
    cursor.execute(
        "SELECT id FROM auction_categories WHERE name = %s LIMIT 1",
        (name,),
    )
    row = cursor.fetchone()
    return row[0] if row else None


def find_existing_auction(cursor, title: str, developer: str | None, reserve_price: float | None):
    sql = (
        "SELECT id FROM auctions WHERE title = %s"
        " AND (developer = %s OR (developer IS NULL AND %s IS NULL))"
        " AND (reserve_price = %s OR %s IS NULL)"
        " LIMIT 1"
    )
    cursor.execute(sql, (title, developer, developer, reserve_price, reserve_price))
    row = cursor.fetchone()
    return row[0] if row else None


def insert_auction(cursor, data: dict) -> int:
    cols = [
        'title','slug','user_id','category_id','sub_category_id','child_category_id',
        'start_date','end_date','image','album','reserve_price','minimum_bid',
        'description','developer','location_url','status','featured_name','views',
        'payment_plan','nearby_location','amenities','facilities','product_year','product_location',
    ]
    placeholders = ",".join(["%s"] * len(cols))
    sql = f"INSERT INTO auctions ({','.join(cols)}) VALUES ({placeholders})"
    values = [data.get(c) for c in cols]
    cursor.execute(sql, values)
    return cursor.lastrowid


