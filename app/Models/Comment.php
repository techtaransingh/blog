<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table ='comments';
    protected $fillable = ['comment'];
    protected $guarded = ['post_id','user_id'];
    public function author(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
