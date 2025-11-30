<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'image_url',
        'size',
        'price',
        'short_description',
    ];

    // Relationships to cart/loans could go here
}
