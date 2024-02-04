<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'designation',
        'photo',
        'ratings',
        'comments'
    ];

     public $timestamps=false;
}
