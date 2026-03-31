<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //------------- start attributes

    public function getImageUrlAttribute()
    {
        return $this->imageUrl();
    }

    public function imageUrl()
    {
        return $this->image ? asset($this->image) : asset('/back/app-assets/images/portrait/small/default.jpg');
    }

    public function getFullnameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('back/app-assets/images/portrait/small/default.jpg');
    }

    //------------- end attributes

    //------------- start relations

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function views()
    {
        return $this->hasMany(Viewer::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function referral()
    {
        return $this->belongsTo(User::class, 'referral_id', 'id');
    }

    //------------- end relations

    public function hasBought(Price $price)
    {
        $orders = $this->orders()->where('status', 'paid')->pluck('id');

        $bought = DB::table('order_items')->whereIn('order_id', $orders)->where('price_id', $price->id)->exists();

        return $bought;
    }

    public function hasBoughtProduct(Product $product)
    {
        $orders = $this->orders()->where('status', 'paid')->pluck('id');

        return DB::table('order_items')->whereIn('order_id', $orders)->where('product_id', $product->id)->exists();
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return $role->intersect($this->roles)->count();
    }

    public function isAdmin()
    {
        return $this->level == 'admin' || $this->level == 'creator';
    }

    public function isCreator()
    {
        return $this->level == 'creator';
    }

    public function getCart()
    {
        return $this->cart()->firstOrCreate();
    }

    public function getWallet()
    {
        return $this->wallet()->firstOrCreate(
            [],
            [
                'balance'   => 0,
                'is_active' => true
            ]
        );
    }

    //------------- start scopes

    public function scopeFilter($query, $request)
    {
        if ($fullname = $request->input('query.fullname')) {
            $query->WhereRaw("concat(first_name, ' ', last_name) like '%{$fullname}%' ");
        }

        if ($email = $request->input('query.email')) {
            $query->where('email', 'like', '%' . $email . '%');
        }

        if ($username = $request->input('query.username')) {
            $query->where('username', 'like', '%' . $username . '%');
        }

        if ($level = $request->input('query.level')) {
            switch ($level) {
                case "admin": {
                        $query->where('level', 'admin');
                        break;
                    }
                case "user": {
                        $query->where('level', 'user');
                        break;
                    }
            }
        }

        if ($request->sort && $request->input('sort.field')) {
            switch ($request->sort['field']) {
                case 'fullname': {
                        $query->orderBy('first_name', $request->sort['sort'])->orderBy('last_name', $request->sort['sort']);
                        break;
                    }
                default: {
                        if ($this->getConnection()->getSchemaBuilder()->hasColumn($this->getTable(), $request->sort['field'])) {
                            $query->orderBy($request->sort['field'], $request->sort['sort']);
                        }
                    }
            }
        }

        return $query;
    }

    public function scopeCustomPaginate($query, $request)
    {
        $paginate = $request->paginate;
        $paginate = ($paginate && is_numeric($paginate)) ? $paginate : 10;

        if ($request->paginate == 'all') {
            $paginate = $query->count();
        }

        return $query->paginate($paginate);
    }

    public function scopeExcludeCreator($query)
    {
        return $query->where('level', '!=', 'creator');
    }

    //------------- end scopes

    public static function cacheKeys()
    {
        return [
            'admin.users_count'
        ];
    }

    /**
     * The discounts that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }
}
