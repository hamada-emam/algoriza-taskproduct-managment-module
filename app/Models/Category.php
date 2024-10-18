<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $parents
 * @method static \Illuminate\Database\Eloquent\Builder active()
 * @method static \Illuminate\Database\Eloquent\Builder parent()
 * @method static \Illuminate\Database\Eloquent\Builder ordered()
 */
class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parents()
    {
        return $this->belongsToMany(Category::class, 'parent_id');
    }

    function scopeActive($query)
    {
        return $query->where('active', true);
    }

    function scopeParent($query, $parent = true)
    {
        return $parent ? $query->whereNotNull('parent_id') : $query->whereNull('parent_id');
    }

    function scopeOrdered($query)
    {
        return $query->orderBy('name', 'ASC');
    }
}
