<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $primaryKey='categoryId';
    public function getArticles()
    {
        return $this->hasMany('App\Models\Article', 'categoryId', 'categoryId')->where('status',1);
    }
}
