<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Torihikisaki;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Nyuka;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Log;



class NtorokuController extends Controller
{
    //java webでいうところのBeanのフィールド

    private $ntoroku_list = array(
        "nyuka_seq" =>"",
        "tenpo_code" =>"",
        "tenpo_data" =>"",
        "kengen_code" =>"",
        "torihikisaki_code" =>"",
        "torihikisaki_name" =>"",
        "hanbai_name" =>"",
        "yakuhin_kbn" =>"",
        "yakuhin_kbn_name" =>"",
        "jan_code" =>"",
        "yj_code" =>"",
        "nyuka_su" =>"",
        "nyuka_date" =>"",
        "biko" =>"",
        "title" =>"",
        "action" =>"",
        "button" =>"",
        "disabled" =>"",
        "msg" =>"",
        "y_kbn_code" => array('1','2','4'),
        "y_kbn_name" => array('薬品','OTC','特材'),
        "date_from" =>"",
        "date_to" =>"",
        "yakuhin" => "",
        "torihikisaki" => "",
        "nyuka_list" =>array(),
        "page"=>"1"
    );

    private $inputList = array(
        "action" =>"",
        "yakuhin_kbn_name" =>"",
        "torihikisaki_name" =>"",
        "hanbai_name" =>"",
        "kengen_code" =>"",
        "nyuka_seq" => "",
        "tenpo_code" => "",
        "torihikisaki_code" =>"",
        "yakuhin_kbn" =>"",
        "jan_code" =>"",
        "yj_code" =>"",
        "nyuka_su" =>"",
        "nyuka_date" =>"",
        "biko" =>"",
        "disabled" =>""


    );

    function dispShinki(Request $request) {
        $session = $request->getSession();
        //echo $request->get('yakuhin_kbn');

        if (!$session->exists("login_shain_code")) {
            return redirect('/');
        }

//         $this->ntoroku_list["tenpo_data"] = Torihikisaki::where("torihikisaki_kbn" , "2")->get();
//         $this->ntoroku_list["title"] = "入荷データ新規作成";
//         $this->ntoroku_list["tenpo_code"] = $session->get("login_tenpo_code");
//         $this->ntoroku_list["kengen_code"] = $session->get("login_kengen_code");
//         $this->ntoroku_list["action"] = "/registShinki";
//         $this->ntoroku_list["button"] = "登録";

//         $this->ntoroku_list['yakuhin_kbn'] = $request->get('yakuhin_kbn');
//         $this->ntoroku_list['tenpo_code'] = $request->get('tenpo_code');
//         $this->ntoroku_list['date_from'] = $request->get('date_from');
//         $this->ntoroku_list['date_to'] = $request->get('date_to');
//         $this->ntoroku_list['yakuhin'] = $request->get('yakuhin');
//         $this->ntoroku_list['torihikisaki'] = $request->get('torihikisaki');

        $this->inputList['tenpo_data'] =Torihikisaki::where("torihikisaki_kbn" , "2")->get();
        $this->inputList['title'] ="入荷データ新規作成";
        $this->inputList['button'] ="入荷";
        $this->inputList['action'] = "/registShinki";
        $session->put('inputList' ,$this->inputList);
        return view("nyukaToroku" , $this->inputList);
    }

    function redispList(Request $request) {
        //echo "call redispList Success.";

        $session = $request->getSession();
        if(!$session->exists("login_shain_code")){
            return Redirect('/');
        }

        $nyuka_list = $session->get("nyuka_list");
        if(empty($nyuka_list['page'])){
            return redirect('/nyuka');
        } else {
            return redirect('/nkensaku?page='.$nyuka_list['page']);
        }
    }

    public function dispToriSansho(Request $request){
       $session = $request->getSession();
        $this->inputList = $session->get('inputList');
        $this->inputList['nyuka_seq'] = $request->get('nyuka_seq');
        $this->inputList['tenpo_code'] = $request->get('tenpo_code');
        $this->inputList['torihikisaki_code'] = $request->get('torihikisaki_code');
        $this->inputList['torihikisaki_name'] = $request->get('torihikisaki_name');
        $this->inputList['hanbai_name'] = $request->get('hanbai_name');
        $this->inputList['yakuhin_kbn'] = $request->get('yakuhin_kbn');
        $this->inputList['yakuhin_kbn_name'] = $request->get('yakuhin_kbn_name');
        $this->inputList['jan_code'] = $request->get('jan_code');
        $this->inputList['yj_code'] = $request->get('yj_code');
        $this->inputList['nyuka_su'] = $request->get('nyuka_su');
        $this->inputList['nyuka_date'] = $request->get('nyuka_date');
        $this->inputList['biko'] = $request->get('biko');
        $session->put('inputList' , $this->inputList);
        $sansho_list = array(); //空の配列を持たせておかないとブレードでエラーが出る->検索ボタン押下で値が入る
        return view("toriSansho" , ["sansho_list" => $sansho_list]);
    }

    public function toriSentaku(Request $request){
        $session = $request->getSession();
        $this->inputList = $session->get('inputList');
        $this->inputList['torihikisaki_code'] = $request->get('torihikisaki_code');
        $this->inputList['torihikisaki_name'] = $request->get('torihikisaki_name');
        $this->inputList['tenpo_data'] =Torihikisaki::where("torihikisaki_kbn" , "2")->get();
        $this->inputList['title'] ="入荷データ新規作成";
        $this->inputList['button'] ="入荷";
        return view('nyukaToroku' , $this->inputList);
    }

    public function dispYakuSansho(Request $request){

        $session = $request->getSession();
        $this->inputList = $session->get('inputList');
        $this->inputList['nyuka_seq'] = $request->get('nyuka_seq');
        $this->inputList['tenpo_code'] = $request->get('tenpo_code');
        $this->inputList['torihikisaki_code'] = $request->get('torihikisaki_code');
        $this->inputList['torihikisaki_name'] = $request->get('torihikisaki_name');
        $this->inputList['hanbai_name'] = $request->get('hanbai_name');
        $this->inputList['yakuhin_kbn'] = $request->get('yakuhin_kbn');
        $this->inputList['yakuhin_kbn_name'] = $request->get('yakuhin_kbn_name');
        $this->inputList['jan_code'] = $request->get('jan_code');
        $this->inputList['yj_code'] = $request->get('yj_code');
        $this->inputList['nyuka_su'] = $request->get('nyuka_su');
        $this->inputList['nyuka_date'] = $request->get('nyuka_date');
        $this->inputList['biko'] = $request->get('biko');
        $session->put('inputList' , $this->inputList);
        $sansho_list = array();
        return view("yakuSansho" , ["sansho_list" => $sansho_list]);
    }

    public function yakuSentaku(Request $request){
        $session = $request->getSession();
        $this->inputList = $session->get('inputList');
        $this->inputList['jan_code'] = $request->get('jan_code');
        $this->inputList['hanbai_name'] = $request->get('hanbai_name');
        $this->inputList['yakuhin_kbn'] = $request->get('yakuhin_kbn');
        $this->inputList['yakuhin_kbn_name'] = $request->get('yakuhin_kbn_name');
        $this->inputList['yj_code'] = $request->get('yj_code');
        $this->inputList['tenpo_data'] =Torihikisaki::where("torihikisaki_kbn" , "2")->get();
        $this->inputList['title'] ="入荷データ新規作成";
        $this->inputList['button'] ="入荷";
        return view('nyukaToroku' , $this->inputList);
    }

    public function closesansho(Request $request){
//         $session = $request->getSession();
//         $this->inputList = $session->get('ntoroku_list');
        $this->ntorinputListoku_list['nyuka_seq'] = $request->get('nyuka_seq');
        $this->inputList['tenpo_code'] = $request->get('tenpo_code');
        $this->inputList['torihikisaki_code'] = $request->get('torihikisaki_code');
        $this->inputList['torihikisaki_name'] = $request->get('torihikisaki_name');
        $this->inputList['hanbai_name'] = $request->get('hanbai_name');
        $this->inputList['yakuhin_kbn'] = $request->get('yakuhin_kbn');
        $this->inputList['yakuhin_kbn_name'] = $request->get('yakuhin_kbn_name');
        $this->inputList['jan_code'] = $request->get('jan_code');
        $this->inputList['yj_code'] = $request->get('yj_code');
        $this->inputList['nyuka_su'] = $request->get('nyuka_su');
        $this->inputList['nyuka_date'] = $request->get('nyuka_date');
        $this->inputList['biko'] = $request->get('biko');
        $this->inputList['title'] = "入荷データ新規作成";
//         $session->put('ntoroku_list' , $this->ntoroku_list);
        return view('nyukaToroku' , $this->inputList);
    }


    /**
     * 新規登録機能
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function registShinki(Request $request){

        //フィールドに値を保持させる
        $this->inputList["nyuka_seq"] = $request->get('nyuka_seq');
        $this->inputList["tenpo_code"] =$request->get('tenpo_code');
        $this->inputList["torihikisaki_code"] =$request->get('torihikisaki_code');
        $this->inputList["yakuhin_kbn"] =$request->get('yakuhin_kbn');
        $this->inputList["jan_code"] =$request->get('jan_code');
        $this->inputList["yj_code"] =$request->get('yj_code');
        $this->inputList["nyuka_su"] =$request->get('nyuka_su');
        $this->inputList["nyuka_date"] =$request->get('nyuka_date');
        $this->inputList["biko"] =$request->get('biko');


//         $this->ntoroku_list["tenpo_data"] = Torihikisaki::where("torihikisaki_kbn" , "2")->get();
//         $this->ntoroku_list["title"] = "入荷データ新規作成";
//         $this->ntoroku_list["button"] = "登録";

        $session = $request->getSession();
//         $this->ntoroku_list = $session->get('ntoroku_list');
//         $this->ntoroku_list['nyuka_seq'] = $request->get('nyuka_seq');
//         $this->ntoroku_list['tenpo_code'] = $request->get('tenpo_code');
//         $this->ntoroku_list['torihikisaki_code'] = $request->get('torihikisaki_code');
//         $this->ntoroku_list['torihikisaki_name'] = $request->get('torihikisaki_name');
//         $this->ntoroku_list['hanbai_name'] = $request->get('hanbai_name');
//         $this->ntoroku_list['yakuhin_kbn'] = $request->get('yakuhin_kbn');
//         $this->ntoroku_list['yakuhin_kbn_name'] = $request->get('yakuhin_kbn_name');
//         $this->ntoroku_list['jan_code'] = $request->get('jan_code');
//         $this->ntoroku_list['yj_code'] = $request->get('yj_code');
//         $this->ntoroku_list['nyuka_su'] = $request->get('nyuka_su');
//         $this->ntoroku_list['nyuka_date'] = $request->get('nyuka_date');
//         $this->ntoroku_list['biko'] = $request->get('biko');

//         $session->put('ntoroku_list' , $this->ntoroku_list);

        //チェック
        $validator = Validator::make($request->all(),
            [
                'yakuhin_kbn' => 'required',
                'tenpo_code' => 'required',
                'torihikisaki_code' => 'required',
                'nyuka_date' => 'required',
                'jan_code'   => 'required',
                'nyuka_su' =>   'required | numeric | min:0.00 | max:9999999999999.99'
            ]
            );
        //チェックに引っかかったらバリデータをもって同じページに遷移
        if($validator->fails()){

            $this->inputList['tenpo_data'] =Torihikisaki::where("torihikisaki_kbn" , "2")->get();
            $this->inputList['title'] ="入荷データ新規作成";
            $this->inputList['button'] ="入荷";
            $this->inputList['action'] = "/putKensaku";
            return view('nyukaToroku' ,$this->inputList)->withErrors($validator);
        }

        //年度の作成
        $nendo = substr($this->inputList['nyuka_date'], 0,4);
        $manth = substr($this->inputList['nyuka_date'], 5,2);
        if($manth < 11){$user = Auth::user(); //<-すべてのカラムが取得された
        $user->id;
            $nendo = $nendo -1;
        }

        //入荷連番生成
        $tenp_seq ="n".$nendo.$this->inputList['tenpo_code'];
        $max_seq = Nyuka::where('nyuka_seq','like',$tenp_seq.'%')->max('nyuka_seq');

        $nyuka_seq = substr($max_seq, 9);


        if($nyuka_seq != null){
            $nyuka_seq++;
            $nyuka_seq=sprintf('%07d', $nyuka_seq);
        } else{
            $nyuka_seq=sprintf('%07d', 1);
        }

        $nyuka_seq ="n".$nendo.$this->inputList['tenpo_code'].$nyuka_seq;

        //insert
        $values = [
            "nyuka_seq"=>$nyuka_seq,
            "nendo"=>$nendo,
            "tenpo_code"=>$this->inputList['tenpo_code'],
            "torihikisaki_code"=>$this->inputList['torihikisaki_code'],
            "yakuhin_kbn"=>$this->inputList['yakuhin_kbn'],
            "jan_code"=>$this->inputList['jan_code'],
            "yj_code"=>$this->inputList['yj_code'],
            "nyuka_su"=>$this->inputList['nyuka_su'],
            "nyuka_date"=>$this->inputList['nyuka_date']." 00:00:00",
            "delete_flg"=>"0",
            "biko"=>$this->inputList['biko'],
            "created_on"=>date("Y-m-d H:i:s"),
            "created_by"=>$session->get("login_shain_code"),
            "updated_on"=>date("Y-m-d H:i:s"),
            "updated_by"=>$session->get("login_shain_code")

        ];
        Log::debug($values);
        Nyuka::insert($values);

        return view('nyuka' ,$session->get('nyuka_list'));

    }


}

