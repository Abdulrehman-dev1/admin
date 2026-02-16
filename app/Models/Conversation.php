<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\User;
use App\Models\Auction;

class Conversation extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id', 'product_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function product()
    {
        return $this->belongsTo(Auction::class, 'product_id');
    }
}
