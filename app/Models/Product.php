<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
        'note',
        'picture',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
