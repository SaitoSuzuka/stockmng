<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nyuka extends Model
{
    protected $table = "nyuka";
    protected $primaryKey = "nyuka_seq";
    public $incrementing = false;
    public $timestamps = false;
}
