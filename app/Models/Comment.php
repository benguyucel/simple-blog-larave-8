<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table="comments";
    protected $primaryKey='id';
    use HasFactory;
    public function getArticle(){
        return $this->hasOne('App\Models\Article','articlesId','articleId');
    }
}
