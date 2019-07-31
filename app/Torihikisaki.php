<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torihikisaki extends Model
{
    protected $table = "mst_torihikisaki"; //tableの指定
    protected $primaryKey = "torihikisaki_code"; //プライマリーキーの指定　すでにDBで設定になっている

    //ここはオプション　falseにするために今回はしっかり書く。
    public $incrementing = false; //primaryKeyを自動インクリメント 今回はfalseでしない。
    public $timestamps = false; //update at　を自動生成。今回はカラムないのでフォルス。
}
