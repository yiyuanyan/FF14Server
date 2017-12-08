<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
	public $content = null;
    public function login(){
        $data = [
            ['title'=>'管理页面',"content"=>'啥也管理不了'],

        ];
        return view('admin/login',compact('data'));
    }
    public function checkuser(){
        if(empty(session("user"))){
            return redirect()->route("login.index");
			exit();
        }
    }
    public function index(){
	    $this->checkuser();
        $list = DB::table('dungeons')->orderBy('id','ASC')->paginate(15);
        //return $list;
	    return view("admin.index",['list'=>$list,'title'=>'副本列表']);
    }
    public function boss(){
        $this->checkuser();
        $list = DB::table('boss')->orderBy('id','ASC')->paginate(15);
        return view("admin.boss",['list'=>$list,'title'=>'BOSS列表']);
    }
    public function gooditems(){
        $this->checkuser();
        $list = DB::table('goods_items')->orderBy('id','ASC')->paginate(20);
        return view("admin.gooditems",["list"=>$list,'title'=>"物品列表"]);
    }

    //第一步：抓取BOSS的掉落物品 参数为副本名称
    public function getBossItems($name){

        $url = "https://ff14.huijiwiki.com/wiki/".urlencode($name);
        $ch = curl_init();
	    	$timeout = 5;
	    	curl_setopt ($ch, CURLOPT_URL, $url);
	    	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	    	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    	$file_contents = curl_exec($ch);
	    	curl_close($ch);
	     	$a1 = '/title="物品:(.*?)">/i';
	     	$rs = $file_contents;
	    	$arr=array();
	    	preg_match_all($a1,$rs,$arr);
	    	//过滤重复数据
	    	$arrays = $this->m_ArrayUnique($arr[1],false);
	    	//获取到的所有物品
	    	foreach($arrays as $key=>$a){
	            $this->gethttp($a);
        }
    }
    //第二步：
    private function gethttp($name){
        $this->content = null;
            //单个物品连接
            //$url = 'https://ff14.huijiwiki.com/wiki/%E7%89%A9%E5%93%81:%E9%AC%BC%E8%88%B9%E6%B2%BB%E6%84%88%E8%85%B0%E5%B8%A6';
        $url = "https://ff14.huijiwiki.com/wiki/".urlencode("物品:".$name);
            //图片
            $a2 = "/\.png\" src=\"(.*)\" width=\"128\" height=\"128\"/";
                $data["image"] = $this->getinfo($url,$a2);
                //名称
                $a3 = "/<div class=\"infobox-item--name-title infobox-title rarity-uncommon\">(.*)<\/div><div class=\"infobox-item--name-category\">/";
                $data["name"] = $this->getinfo($url, $a3);
                //部位
                $a4 = "/<div class=\"infobox-item--name-category\">(.*)<\/div><\/div><\/div><div class=\"infobox-item--base-stat-row\" style=\"text-align:right;\">/";
                $data["parts"] = $this->getinfo($url, $a4);
                //物理防护
                $a5 = "/<div class=\"stat-value-bg\"><\/div><div class=\"stat-value only-value\">(.*)<\/div><\/div><div class=\"infobox-item--base-stat-item\">/";
                $data["physics"] = $this->getinfo($url, $a5);
                //魔法防护值
                $a6 = "/魔法防御力<\/div><div class=\"stat-value-bg\"><\/div><div class=\"stat-value only-value\">(.*)<\/div><\/div><\/div><div class=\"infobox-item--level\">/";
                $data["magic"] = $this->getinfo($url, $a6);
                //品级
                $a7 = "/<\/div><\/div><\/div><div class=\"infobox-item--level\">品级 (.*)<\/div><div class=\"infobox-item--require\"><div class=\"infobox-item--job\">/";
                $data["grade"] = $this->getinfo($url, $a7);
                //可用职业
                $a8 = "/<\/div><div class=\"infobox-item--require\"><div class=\"infobox-item--job\">(.*)<\/div><div class=\"infobox-item--equiplevel\">/";
                $data["profession"] = $this->getinfo($url, $a8);
                //耐力 substr(‘abcdef', 0, 4);
                $a9 = "/<li><span>耐力<\/span> \+(.*)<\/li>/";
                $data["endurance"] = (int)substr($this->getinfo($url, $a9),0,4);
                //力量
                $a10 = "/<li><span>力量<\/span> \+(.*)<\/li>/";
                $data["power"] = (int)substr($this->getinfo($url, $a10),0,4);
                //暴击
                $a11 = "/<li><span>暴击<\/span> \+(.*)<\/li>/";
                $data["crit"] = (int)substr($this->getinfo($url, $a11),0,4);
                //直击
                $a11_1 = "/<li><span>直击<\/span> \+(.*)<\/li>/";
                $data["watch"] = (int)substr($this->getinfo($url, $a11_1),0,4);
                //信仰
                $a12 = "/<li><span>信仰<\/span> \+(.*)<\/li>/";
                $data["belief"] = (int)substr($this->getinfo($url, $a12),0,4);
                //精神
                $a13 = "/<li><span>精神<\/span> \+(.*)<\/li>/";
                $data["spirit"] = (int)substr($this->getinfo($url, $a13),0,4);
                //信仰
                $a14 = "/<li><span>信仰<\/span> \+(.*)<\/li>/";
        $data["faith"] = (int)substr($this->getinfo($url, $a14),0,4);
                //修理等级
                $a15 = "/<span>修理等级<\/span><\/li><li>(.*)<\/li><li><span>修理材料/";
                $data["repair_grade"] = $this->getinfo($url, $a15);
                //修理材料
                $a16 = "/<span>修理材料<\/span><\/li><li>(.*)<\/li><li><span>镶嵌魔晶石等级/";
                $data["repair_material"] = $this->getinfo($url, $a16);
                //魔晶石
                $a17 = "/<ul class=\"infobox-item--info-socket\"><li>&#(.*);<\/li><\/ul><\/div><div class=\"ff14-content-box-block\"><div class=\"ff14-content-box-block--title\">制作/";
                $dimensity = $this->getinfo($url,$a17);
                $dimensity_count = substr_count($dimensity,'160');
                $data["dimensity"] = $dimensity_count;
                $or = $this->getsource($url);
                $data["origin"] = $or["boss"];
                $data["origin_fuben"] = $or["fuben"];
/*
                $M = M("goods_items");
                $rs = $M->where("name='".$data["name"]."'")->find();
*/
                $rs = Db::table("goods_items")->where("name",$data["name"])->first();

                if($rs){
                        return;
                }
                $this->itemsSave($data);
    }
    private function getsource($url){
                        $ch = curl_init();
                        $timeout = 5;
                        curl_setopt ($ch, CURLOPT_URL, $url);
                        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                        $file_contents = curl_exec($ch);
                        curl_close($ch);
                        $a1 = "/<div class=\"instance-list--title link-block\"><div class=\"instance-type instance-type-2\"><\/div>(.*)<\/small><\/div><\/div><\/div><\/div><\/div><div class=\"item-quick-fact/";
                        $rs = $file_contents;
                        $arr=array();
                        preg_match_all($a1,$rs,$arr);
                        if(empty($arr[1][0])){
                                return;
                        }
                        $str1 = $arr[1][0];
                $returnArray = array();
                $returnArray1 = array();
                $ta = "/title\=\"(.*)\"/U";
                $sta = '/<a href=\"\/wiki\/.*\">(.*)<\/a>/';
                preg_match_all($ta,$str1,$returnArray);
                preg_match_all($sta,$str1,$returnArray1);
                $bbb = array();
                if(!empty($returnArray[1][0])){
                        $bbb["fuben"] = $returnArray[1][0];
                }
                if(!empty($returnArray1[1][0])){
                        $bbb["boss"] = $returnArray1[1][0];
                }
                return $bbb;
        }
            public function getinfo($url, $string){
                if(empty($this->content)){
                        $ch = curl_init();
                        $timeout = 5;
                        curl_setopt ($ch, CURLOPT_URL, $url);
                        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                        $file_contents = curl_exec($ch);
                        curl_close($ch);
                        $a1 = "/<div class=\"infobox-item\ ff14-content-box\">(.*)<h2><span class=\"mw-headline\" id=\"/";
                        $rs = $file_contents;
                        $arr=array();
                        preg_match_all($a1,$rs,$arr);
                        if(empty($arr[1][0])){
                                return;
                        }
                        $this->content = $arr[1][0];

                }
                $returnArray = array();
                preg_match_all($string,$this->content,$returnArray);
                if($returnArray[1]){
                        return $returnArray[1][0];
                }else{
                        return null;
                }


        }
           //第三步：将获取的物品进行数据库存储
        private function itemsSave($data){
			if(!empty($data["name"]) and !empty($data["image"])){
				$rs = DB::table("goods_items")->insert($data);
			}
        }
             /**
         * 给数组排重
         * 与array_unique函数的区别：它要求val是字符串，而这个可以是数组/对象
         *
         * @param unknown_type $arr 要排重的数组
         * @param unknown_type $reserveKey 是否保留原来的Key
         * @return unknown
         */
        private function m_ArrayUnique($arr, $reserveKey = false)
        {
            if (is_array($arr) && !empty($arr))
            {
                foreach ($arr as $key => $value)
                {
                    $tmpArr[$key] = serialize($value) . '';
                }
                $tmpArr = array_unique($tmpArr);
                $arr = array();
                foreach ($tmpArr as $key => $value)
                {
                    if ($reserveKey)
                    {
                        $arr[$key] = unserialize($value);
                    }
                    else
                    {
                        $arr[] = unserialize($value);
                    }
                }
            }
            return $arr;
        }

}
?>
