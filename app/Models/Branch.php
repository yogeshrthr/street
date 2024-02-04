<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table='branches';
    protected $fillable = [
        'id',
		'branch_name',
        'email',
        'password',
        'location',
        'mobile',
        'dated'
    ];
	public $timestamps=false;

}
