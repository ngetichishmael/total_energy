<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Region;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class customers extends Model
{
    use searchable;
    protected $searchable = [
        'Area.name',
        'customer_name',
        'phone_number',
        'address',
        'Area.Subregion.name',
        'Area.Subregion.Region.name',
    ];
    protected $table = 'customers';
    protected $guarded = [''];

    public function scopeFilterCustomers($query)
    {
        $user = Auth::user();

        if (Auth::check()) {
            if ($user->account_type == 'Admin') {
                return $query;
            } else {
                $userAreaIds = Area::whereHas('subregion', function ($query) use ($user) {
                    $query->whereIn('region_id', function ($query) use ($user) {
                        return $query->select('region_id')
                            ->from('assigned_regions')
                            ->where('user_code', $user->user_code);
                    });
                })->pluck('id');

                return $query->whereIn('route_code', $userAreaIds);
            }
        }
    }

    public function newQuery()
    {
        if (Route::current() && in_array('web', Route::current()->middleware())) {
            return parent::newQuery()->filterCustomers();
        }

        return parent::newQuery();
    }

    /**
     * Get the Region that owns the customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    /**
     * Get the Creator associated with the customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    /**
     * Get the Area that owns the customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'route_code', 'id');
    }
    /**
     * Get the Subregion that owns the customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Subregion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subregion_id', 'id');
    }
    /**
     * Get all of the Orders for the customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Orders(): HasMany
    {
        return $this->hasMany(Orders::class, 'customerID', 'id');
    }

    /**
     * Get the latest order for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestOrder(): HasOne
    {
        return $this->hasOne(Order::class, 'customerID', 'id')
            ->latest();
    }

    /**
     * Get the Wallet associated with the customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Wallet(): HasOne
    {
        return $this->hasOne(EWallet::class, 'customer_id', 'id');
    }

}
