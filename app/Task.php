<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // 保存できるカラムのホワイトリスト（例外：saveメソッド）
    protected $fillable = ['content'];

    public function user()
    {

    return $this->belongsTo(User::class);
}

//test