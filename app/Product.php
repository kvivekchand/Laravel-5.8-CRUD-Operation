<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id', 'category_id', 'sub_category_id', 'photo'
    ];

    public function category(){
		return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function subcategory(){
		return $this->belongsTo(SubCategory::class, 'sub_category_id');
	}
}
