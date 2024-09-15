<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'age',
        'sex'
    ];
    //return sub categories
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'category_id');
    }
    public function parentCategories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    //this method will get categories that not a sub Category
    public static function getCategories()
    {
        $categories = Category::whereNull('category_id')->get();
        return $categories;
    }

}
