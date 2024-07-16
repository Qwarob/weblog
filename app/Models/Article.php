<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image', 'category_id', 'is_premium'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . str_replace('public/', '', $this->image));
        }
        // Return a default image URL if no image is set
        return asset('images/default.jpg');
    }

    public function setIsPremiumAttribute($value)
    {
        $this->attributes['is_premium'] = (bool) $value;
    }
}
