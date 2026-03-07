<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Auction1 extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auctions_1';

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'category_id',
        'sub_category_id',
        'child_category_id',
        'start_date',
        'end_date',
        'image',
        'current_highest_bid',
        'album',
        'product_condition',
        'product_year',
        'product_location',
        'state_id',
        'city_id',
        'live_auction_date',
        'live_auction_start_time',
        'live_auction_end_time',
        'reserve_price',
        'minimum_bid',
        'is_bid_increment',
        'bid_increment',
        'is_buynow',
        'buy_now_price',
        'description',
        'international_shipping',
        'shipping_conditions',
        'shipping_terms',
        'views',
        'status',
        'is_autobidder_on',
        'featured_name',
        'winner_id',
        'list_type',
        'create_category',
        'decline_reason',
        'developer',
        'location_url',
        'delivery_date',
        'sale_starts',
        'payment_plan',
        'number_of_buildings',
        'government_fee',
        'nearby_location',
        'amenities',
        'facilities',
        'is_1_rupee',
        'is_live_auction',
    ];


    protected static function booted()
    {
        static::saving(function ($auction) {
            if (empty($auction->slug) && !empty($auction->title)) {
                $slug = Str::slug($auction->title, '-');
                $auction->slug = Str::limit($slug, 255, '');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(AuctionCategory::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(AuctionCategory::class, 'sub_category_id');
    }

    public function childCategory()
    {
        return $this->belongsTo(AuctionCategory::class, 'child_category_id');
    }

    /**
     * Helper to get the actual end date of the auction.
     */
    public function getEffectiveEndDate()
    {
        if ($this->end_date && $this->end_date !== 'Not set') {
            return \Carbon\Carbon::parse($this->end_date, 'Asia/Karachi');
        }

        if ($this->is_live_auction && $this->live_auction_date && $this->live_auction_end_time) {
            return \Carbon\Carbon::parse($this->live_auction_date . ' ' . $this->live_auction_end_time, 'Asia/Karachi');
        }

        return null;
    }
}

