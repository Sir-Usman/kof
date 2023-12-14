<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
    ];
}
