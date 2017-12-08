<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
class LoginController extends Controller
{
    //public $r = new Request();
    public function __construct(){
        //echo "adsfasdfasdfasdf";
        return view('login/index');
        exit();
        // if($_POST["_token"] != $r->session()->get("_token")){
        //
        // }else{
        //     //验证失败跳转到登录页面
        //
        // }

    }
    public function index(){
        return view("login/index");
    }
    public function login(Request $request){
        $name = Input::get("username");
        $password = Input::get("password");
        if(($request->session()->get("_token") == $_POST["_token"]) and $name=="hejianxin" and $password == "Hejianxin88"){
            //登录成功
            session(["user"=>$name]);
            return redirect("admin");
        }else{
            //登录失败
            return redirect()->back()->with('message','登录失败');
        }
    }
}
?>
