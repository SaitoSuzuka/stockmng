<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index (Request $request){

        //$sessionにrequestのgetSession昨日を入れて扱いやすくしている
        $session = $request->getSession();

        //ログインコードが取れてなかったらまたログイン画面に遷移
        if(!$session->exists('login_shain_code')){ //exists
            return  redirect('/');
        }

        $kengen = $session->get('login_kengen_code');



        //kengen_code='001'だったら menu_code=001/002/003/004
        //kengen_code='002'だったら menu_code=001/002/003
        $rs = DB::table("mst_menu_kengen as mmk");
        $rs->join("mst_menu as mm" , "mmk.menu_code" , "=" , "mm.menu_code");
        $rs->select("mm.*");
        $rs ->where("mmk.kengen_code", $kengen);
        $menu = $rs->get();


        return  view('menu',["menu"=>$menu]);
    }
}
