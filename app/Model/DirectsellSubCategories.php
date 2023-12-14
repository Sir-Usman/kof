<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectsellSubCategories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];
}
