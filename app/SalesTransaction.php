<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["cart_id", "transaction_id", "card_details", "status"];
}
