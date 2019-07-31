<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yakuhin extends Model
{
    protected $table = "mst_shohin"; //tableの指定
    protected $primaryKey = "jan_code"; //プライマリーキーの指定　すでにDBで設定になっている

    //ここはオプション　falseにするために今回はしっかり書く。
    public $incrementing = false; //primaryKeyを自動インクリメント 今回はfalseでしない。
    public $timestamps = false; //update at　を自動生成。今回はカラムないのでフォルス。
}
