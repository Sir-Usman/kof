<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectsellCategories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function subcategories()
    {
        return $this->hasMany(DirectsellSubCategories::class, 'category_id');
    }
}
