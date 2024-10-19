<?php

namespace App\Models;

use App\Traits\GeneratesCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\Category $category
 */
class Product extends Model
{
    use HasFactory, GeneratesCode;

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getImageAttribute($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        return asset('storage/' . $value);
    }
}
