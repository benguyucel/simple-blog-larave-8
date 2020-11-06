<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $table = 'articles';
    protected $primaryKey = 'articlesId';
    use HasFactory;
    public function getCategory()
    {
        return $this->hasOne('App\Models\Category', 'categoryId', 'categoryId');
    }
    public function getComments()
    {
        return $this->hasMany('App\Models\Comment', 'articleId', 'articleId');
    }
}
