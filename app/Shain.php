<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shain extends Model
{
    protected $table = "mst_shain";
    protected $primaryKey = "shain_code";
    public $incrementing = false;
    public $timestamp = false;


    //多対１の連結
    function kengen(){
        //子どものほうはbelongToメソッド(場所、つなげるカラム)
        return $this->belongsTo('App/Kengen' , 'kengen_code');
    }

}
