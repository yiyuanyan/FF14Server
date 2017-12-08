<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
	//列表
    public function index(){
		$posts = [
			["title" => 'this is title1'],
			["title" => 'this is title2'],
			["title" => 'this is title3'],
		];
        return view('posts/index',compact('posts'));
    }
    //详情页
    public function show(){
        return view('posts/show');
    }
    //创建
    public function create(){
        return view('posts/create');
    }
    public function store(){
        return ;
    }
    //编辑
    public function edit(){
        return ;
    }
    public function update(){
        return ;
    }
    //删除
    public function delete(){
        return ;
    }
}
