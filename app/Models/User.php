<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Auction;
use App\Models\Country;
use App\Models\Wallet;
use App\Models\Address;
use App\Models\IndividualVerification;
use App\Models\NewNotification;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
    'name','username','email','password','phone',
    'role','country_id','city_id','address','status','profile_pic','vat_number',    // add karein
    'company_name','referral_code','api_token',  // add karein
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
  protected $hidden = ['password', 'remember_token', 'api_token'];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
  protected static function booted()
    {
        // wallet create on user creation
        static::created(function ($user) {
            $user->wallet()->create(['balance' => 0]);
        });

        // soft-delete related auctions when user is soft-deleted
        static::deleting(function ($user) {
            $user->auctions()->delete();
        });
    }
    // define auctions relation
     public function auctions()
    {
        return $this->hasMany(Auction::class, 'user_id');
    }
    public function country()
{
    return $this->belongsTo(Country::class, 'country_id');
}
    public function wallet()
{
    return $this->hasOne(Wallet::class);
}

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function notifications()
    {
        return $this->hasOne(Notification::class);
    }

    public function identity_verification()
    {
        return $this->hasOne(IdentityVerification::class);
    }
    public function IndividualVerification()
    {
        return $this->hasOne(IndividualVerification::class);
    }
    public function NewNotification()
{
    return $this->hasMany(NewNotification::class);
}
// In App\Models\User.php

public function sendPasswordResetNotification($token)
{
    // Custom URL jo aapke Next.js reset page ko point karta hai
    $url = env('NEXT_PUBLIC_FRONTEND_URL') . '/reset-password?token=' . $token . '&email=' . urlencode($this->email);

    $this->notify(new \App\Notifications\ResetPasswordNotification($url));
}
public function referrer()
{
    return $this->belongsTo(User::class, 'referred_by');
}

public function referrals()
{
    return $this->hasMany(User::class, 'referred_by');
}


}
