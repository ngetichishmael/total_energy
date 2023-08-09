<?php

namespace App\Models;

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
                return $query->where('route_code', $user->route_code);
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
        return $this->belongsTo(Region::class, 'route_code', 'id');
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
        return $this->belongsTo(Area::class, 'unit_id', 'id');
    }
    /**
     * Get all of the Orders for the customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Orders(): HasMany
    {
        return $this->hasMany(Orders::class, 'id', 'customerID');
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
