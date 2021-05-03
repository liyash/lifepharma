<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['created_by', 'status', 'processed'];
    /**
     * Get the user that owns the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get the user that owns the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderdetails()
    {
        return $this->hasMany(OrderDetail::class, 'cart_id', 'id');
    }
    public function transactiondetails()
    {
        return $this->hasMany(SalesTransaction::class, 'cart_id', 'id');
    }
}
