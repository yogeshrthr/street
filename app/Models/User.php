<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_name',
        'user_email',
        'user_mobile',
        'password',
        'pass'
    ];

    public $timestamps=false;
}
