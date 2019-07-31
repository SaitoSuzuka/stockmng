<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Torihikisaki;
use App\Yakuhin;

class SanshoController extends Controller
{
    private $torihikisaki;
    private $torihikisaki_kbn;
    private $yakuhin;
    private $yakuhin_kbn;

    public function dispToriSansho(){
        $sansho_list = array();
        return view("toriSansho" , ["sansho_list"=>$sansho_list]);
    }

    public function toriKensaku(Request $request){
        $result = Torihikisaki::where("delete_flg" , "0");
        $this->torihikisaki = $request->get("torihikisaki");
        $this->torihikisaki_kbn = $request->get("torihikisaki_kbn");
        if ($this->torihikisaki !="") {
            $result->where(function($result){
                $result->orwhere("torihikisaki_code", $this->torihikisaki)
                ->orwhere("torihikisaki_name" , "like" , "%" . $this->torihikisaki . "%");
            });
        }
        if($this->torihikisaki_kbn !=""){
            $result->where("torihikisaki_kbn",$this->torihikisaki_kbn);
         }
        $sansho_list = $result->paginate(25);
        return view("toriSansho" , ["sansho_list" => $sansho_list]);
    }

    public function toriSentaku(Request $request){
        $session = $request->getSession();
        $this->ntoroku_list = $session->get('ntoroku_list');
        $this->ntoroku_list['torihikisaki_code'] = $request->get('torihikisaki_code');
        $this->ntoroku_list['torihikisaki_name'] = $request->get('torihikisaki_name');
        return view('nyukaToroku' , $this->ntoroku_list);
    }

    public function yakuKensaku(Request $request){
        $result = Yakuhin::where("delete_flg" , "0");
        $this->yakuhin = $request->get("yakuhin");
        $this->yakuhin_kbn = $request->get("yakuhin_kbn");
        if ($this->yakuhin !="") {
            $result->where(function($result){
                $result->orwhere("jan_code", $this->yakuhin)
                ->orwhere("hanbai_name" , "like" , "%" . $this->yakuhin . "%");
            });
        }
        if($this->yakuhin_kbn !=""){
            $result->where("yakuhin_kbn",$this->yakuhin_kbn);
        }
        $sansho_list = $result->paginate(25);
        return view("yakuSansho" , ["sansho_list" => $sansho_list]);
    }


}
