<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','name', 'slug', 'image', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
		return $this->belongsTo(User::class);
	}
    public function posts()
    {
		return $this->hasMany(Post::class);
	}
    public function getExcerptAttribute()
    {
        return substr($this->description, 0, 80) ."...";
    }
    public function similar()
    {
        return $this->where('category_id', $this->category_id)
            ->with('user')
            ->take(2)
            ->get();
    }
    
}
