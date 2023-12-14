<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_detail extends Model
{
    use HasFactory;

    protected $table = 'product_detail';

    protected $fillable = [
        'button',
        'sub_categories',
        'product_identification',
        'technical_data',
        'your_desired_price',
        'contact',
        'images',
        'user_id',
        // Add other fields here if needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
