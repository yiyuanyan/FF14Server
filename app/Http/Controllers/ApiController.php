<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ApiController extends Controller
{
	public function getDungeon($id){
		$data = array();
		if(empty($id)){
			$data["status"] = 0;
			$data["msg"] = "没有请求参数";
		}else{
			$rs = DB::table('dungeons')->where('id',$id)->first();
			if($rs){
				$rs->reward = unserialize($rs->reward);
				$rs->boss = unserialize($rs->boss);
				$data["status"] = 1;
				$data["msg"] = "数据返回成功";
				$data["data"] = $rs;
			}else{
				$data["status"] = 1;
				$data["msg"] = "数据返回成功";
				$data["data"] = null;
			}
		}
		return $data;
	}
	//获取副本
	public function getDungeonAll(){
		$data = array();
		$rs = DB::table('dungeons')->get();
		if($rs){
			foreach($rs as $key=>$r){
				$rs[$key]->reward = unserialize($r->reward);
				$rs[$key]->boss = unserialize($r->boss);
			}
			$data["status"] = 1;
			$data["msg"] = "数据返回成功";
			$data["data"] = $rs;
		}else{
			$data["status"] = 0;
			$data["msg"] = "数据返回失败";
			$data["data"] = null;
		}
		$data["category"] = $this->category(1);
		return $data;
	}
	//获取分类TOP的图片
	public function category($id){
		$rs = DB::table('category')->where('id',$id)->get();
		if($rs){
			return $rs[0];
		}else{
			return null;
		}
	}
	//通过BOSS名称获取BOSS信息
	public function getBossInfo($name){
		$data = array();
		//$rs = DB::select("select * from boss where name=?",[$name]);
		$rs = DB::table('boss')->where('name',$name)->first();
		if($rs){
			$di = unserialize($rs->drop_items);
			$rs->drop_items = $di;
			$rs->image = "/uploads/image/".$rs->image;
			foreach($di as $k=>$d){
				$items[] = $this->getGoodItems($d);
			}
			$rs->items = $items;
			// foreach($rs as $key=>$r){
			// 	$di = unserialize($r->drop_items);
			// 	$rs[$key]->drop_items = $di;
			// 	$rs[$key]->image = "/uploads/image/".$r->image;
			// 	foreach($di as $k=>$d){
			// 		$items[] = $this->getGoodItems($d);
			// 	}
			// 	$rs[$key]->items = $items;
			// }
			$data["status"] = 1;
			$data["msg"] = "数据返回成功";
			$data["data"] = $rs;
		}else{
			$data["status"] = 0;
			$data["msg"] = "数据返回失败";
			$data["data"] = null;
		}

		return $data;
	}
	public function getDungeonBoss($dungeon){
		$data = array();
		//$rs = DB::select("select * from boss where name=?",[$name]);
		$rs = DB::table('boss')->where('affiliation',$dungeon)->get();
		if($rs){
			foreach($rs as $key=>$r){
				$di = unserialize($r->drop_items);
				$rs[$key]->drop_items = $di;
				$rs[$key]->image = "/uploads/images/".$r->image;
				foreach($di as $k=>$d){
					$items[] = $this->getGoodItems($d);
				}
				$rs[$key]->items = $items;
			}
			$data["status"] = 1;
			$data["msg"] = "数据返回成功";
			$data["data"] = $rs;
		}else{
			$data["status"] = 0;
			$data["msg"] = "数据返回失败";
			$data["data"] = null;
		}

		return $data;
	}
	//通过BOSS名称获取掉落物品
	public function getbossitems($name){
		$data = array();
		$rs = DB::table('goods_items')->where('origin',$name)->get();
		if($rs){
			$data["status"] = 1;
			$data["msg"] = "数据获取成功";
		}
		$data["data"] = $rs;
		return $data;
	}
	public function getGoodItems($id){
		$rs = DB::table('goods_items')->where('id',$id)->first();
		if($rs){
			$data["status"] = 1;
			$data["msg"] = "获取数据成功";
			$data["data"] = $rs;
		}else{
			$data["status"] = 0;
			$data["msg"] = "获取数据失败";
			$data["data"] = null;
		}
		//$rs = DB::select("select * from goods_items where id=?",[$id]);
		return $data;
	}
}
