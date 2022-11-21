<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'orders';

    protected $fillable = [
        'email',

    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
