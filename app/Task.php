<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // 保存できるカラムのホワイトリスト（例外：saveメソッド）
    protected $fillable = ['content', 'user_id', 'status_name'];

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}

//test