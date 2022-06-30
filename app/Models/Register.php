<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    protected $fillable = ["coach","price", "malePrice", "femalePrice", "dancers", "taked_hours", "comments", "category"];
}
