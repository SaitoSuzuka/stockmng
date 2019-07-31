<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kengen extends Model
{
    protected $table = "mst_kengen";
    protected $primaryKey = "kengen_code";
    public $incrementing = false;
    public $timestamp = false;

    //多対１の連結
    function shain(){
        //親のほうはhasManyメソッド　※親 = primaryKeyを持つテーブル
        return $this->hasMany('App/Shain');
    }
}
