<?php

namespace App\Http\Controllers;

use App\Shain;
use App\Torihikisaki;
use Illuminate\Http\Request;
use function Illuminate\Foundation\Testing\Concerns\report;

class LoginController extends Controller
{
    //フィールド
    //連想配列
    private $login_data = array(
        'tenpo_data' => '', //左辺はkey
        'shain_code' => '',
        'password' => '',
        'tenpo_code' => '',
        'tenpo_name' => '',
        'shain_name' => '',
        'kengen_code' => '',
        'kengen_name' => '',
        'msg' =>''
    );

    //店舗リストを持ってきて送る。
    public function index(){
        $this->login_data['tenpo_data'] = Torihikisaki::where('torihikisaki_kbn', '2')->get();

        //↓なぜかできない7/2
        //\Debugbar::info('$login_date'.$this->login_data);

        return view('login', $this -> login_data); //　->＝　.と一緒　thisのなかのlogin_data　
    }

    public function putLogin(Request $request){
        //SelectBoxに値を保持させる
        //$requestが画面から受け取った値 -> id
        $this->login_data['shain_code'] = $request->shain_code;
        $this->login_data['password'] = $request->password;
        $this->login_data['tenpo_code'] = $request->tenpo_code;
        $this->login_data['tenpo_data'] = Torihikisaki::where('torihikisaki_kbn' , '2')->get();

        //存在チェック
        //この１つの組み合わせが一致すれば
        $shain_info = Shain::where('shain_code', $request->shain_code)->where('password', $request->password)->first();
        //fistメソッドは必ず検索結果の場合に単一レコードを取得

        if($shain_info == null){
            $this->login_data['msg'] = "社員コードまたはパスワードが間違っています。";
            return view('login' , $this->login_data);
        }

        //関連チェック：店舗権限は店舗選択が必須
        //$shain_infoには結合したフィールドの値がすべて入っている
        if($shain_info->kengen_code == '002' and $this->login_data['tenpo_code'] == ''){
            $this->login_data['msg'] = "店舗権限者は店舗の選択が必須です。";
            return view('login' , $this->login_data);
        }

        //空のフィールドにDB空の値をとってきている(ブラウザからは取得できないから)
        //$Shain_info には単一レコードのみ入っているので↓のフィールドには一つずつ値が入っている。
        $this->login_data['shain_name'] = $shain_info->shain_name;
        $this->login_data['kengen_code'] = $shain_info->kengen_code;
        $this->login_data['kengen_name'] = $shain_info->kengen_name;

        //店舗者情報取得
        if($this->login_data['kengen_code'] == '001'){
            $this->login_data['tenpo_code'] = '';
            $this->login_data['tenpo_name'] = '事務局';
        } else {
            $tenpo_info = Torihikisaki::find($this->login_data['tenpo_code']);
            $this->login_data['tenpo_name'] = $tenpo_info->torihikisaki_name;
        }

        //sessionに記憶
        $request->session()->regenerate();
        $request->session()->put("login_shain_code", $this->login_data['shain_code']);
        $request->session()->put("login_shain_name", $this->login_data['shain_name']);
        $request->session()->put("login_tenpo_code", $this->login_data['tenpo_code']);
        $request->session()->put("login_tenpo_name", $this->login_data['tenpo_name']);
        $request->session()->put("login_kengen_code", $this->login_data['kengen_code']);
        $request->session()->put("login_kengen_name", $this->login_data['kengen_name']);

        //redirectはget送信
        return redirect('/menu');



    }
}
