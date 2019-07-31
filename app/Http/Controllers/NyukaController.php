<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Torihikisaki;

class NyukaController extends Controller
{
    //nyukaBeanのフォールドと同じ。
    private $nyuka_list = array(
        "tenpo_data" => "",
        "tenpo_code" => "",
        "kengen_code" => "",
        "yakuhin_kbn" => "",
        "y_kbn_code" => array('1','2','4'),
        "y_kbn_name" => array('薬品','OTC','特材'),
        "date_from" =>"",
        "date_to" =>"",
        "yakuhin" => "",
        "torihikisaki" => "",
        "nyuka_list" =>array(),
        "page"=>"1"
        );


    //入荷一覧の初期表示
    function index(Request $request) {
        $session = $request->getSession();

        if(!$session->exists("login_shain_code")){
            return redirect('/');
        }

        $this->nyuka_list['tenpo_data'] = Torihikisaki::where('torihikisaki_kbn','2')->get();
        $this->nyuka_list['tenpo_code'] = $session->get('login_tenpo_code');
        $this->nyuka_list['kengen_code'] = $session->get('login_kengen_code');

        //session.setAtributeと同じ　上で作ったnyuka_listの配列を"nyuka_list"に入れてViewに渡せるようにしている
        $session->put("nyuka_list",$this->nyuka_list);
        return view('nyuka',$this->nyuka_list); //privateはthis使わないといけない
    }

    //検索ボタン押下
    function putKensaku(Request $request) {
        $session = $request->getSession();

        if(!empty($_GET['page'])){
            $this->nyuka_list = $session->get("nyuka_list");
            $this->nyuka_list['page'] = $_GET['page'];
            $session->put('nyuka_list' , $this->nyuka_list);
        } else {
            $this->nyuka_list = $session->get("nyuka_list");
            //$this->nyuka_list['tenpo_data'] = Torihikisaki::where('torihikisaki_kbn' , '2')->get();
            $this->nyuka_list['yakuhin_kbn'] = $request->get('yakuhin_kbn');
            $this->nyuka_list['tenpo_code'] = $request->get('tenpo_code');
            $this->nyuka_list['date_from'] = $request->get('date_from');
            $this->nyuka_list['date_to'] = $request->get('date_to');
            $this->nyuka_list['yakuhin'] = $request->get('yakuhin');
            $this->nyuka_list['torihikisaki'] = $request->get('torihikisaki');
            $session->put('nyuka_list',$this->nyuka_list);
        }


        $query = DB::table('nyuka as n');
        $query->join('mst_shohin as ms' , 'n.jan_code' , '=' , 'ms.jan_code');
        $query->join('mst_torihikisaki as mt' , 'n.tenpo_code' , '=' , 'mt.torihikisaki_code');
        $query->join('mst_torihikisaki as mt2' , 'n.torihikisaki_code' , '=' , 'mt2.torihikisaki_code');
        $query->select('n.nyuka_seq' , 'mt.torihikisaki_name as tenpo_name','mt2.torihikisaki_name');
        $query->addSelect('n.yakuhin_kbn', 'n.jan_code' , 'ms.hanbai_name' , 'n.nyuka_su', 'n.nyuka_date');
        //薬品区分 ↓選択されていれば
        if($this->nyuka_list['yakuhin_kbn'] != ""){
            $query->where('n.yakuhin_kbn' , '=' ,$this->nyuka_list['yakuhin_kbn']);
        }
        //店舗
        if($this->nyuka_list['tenpo_code'] !=""){
            $query->where('n.tenpo_code' , '=' , $this->nyuka_list['tenpo_code']);
        }
        //date_from
        if($this->nyuka_list['date_from'] !=""){
            $query->where('n.nyuka_date' , '>=' , $this->nyuka_list['date_from'] . " 00:00:00");
        }
        //dete_to
        if($this->nyuka_list['date_to'] !=""){
            $query->where('n.nyuka_date' , '<=' , $this->nyuka_list['date_to'] . " 23:59:59");
        }
        //yakuhin
        if($this->nyuka_list['yakuhin'] !=""){
            $query->where(function($query){
                $query->orwhere('n.jan_code' , '=' , $this->nyuka_list['yakuhin']);
                $query->orwhere('ms.hanbai_name' , 'like' , '%' . $this->nyuka_list['yakuhin'] . '%');
            });
        }
        //torihikisaki
        if($this->nyuka_list['torihikisaki'] !=""){
            $query->where(function($query){
                $query->orwhere('n.torihikisaki_code' , '=' , $this->nyuka_list['torihikisaki']);
                $query->orwhere('mt2.torihikisaki_name' , 'like' , '%' . $this->nyuka_list['torihikisaki'] . '%');
            });
        }
        //order by
        $query->orderBy('n.created_on' , 'desc');
        //ページネーション
        $this->nyuka_list['nyuka_list'] = $query->paginate(25);
        //$session->put($this->nyuka_list);
        return view('nyuka',$this->nyuka_list);

    }
}
