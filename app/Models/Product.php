<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'subcategory_id',
        'image'
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class,'product_id');
    }
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }
    public function stocks()
    {
        return $this->hasOne(Stock::class);
    }
    public function all_stocks()
    {
        return $this->hasMany(Stock::class);
    }

    
}
