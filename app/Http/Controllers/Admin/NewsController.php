<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
class NewsController extends Controller
{
    public function index(){
        $list=News::orderBy('id','desc')->get();
        return view('admin.news.index',['list'=>$list]);
    }
    public function addNews(Request $request){
        if($request->getMethod()=="POST"){
            $request->validate([
                'title'=>'required',
                'description'=>'required'
            ]);
            $news=new News();
            $news->title=$request->title;
            $news->description=$request->description;
            $news->Save();
            return redirect()->route('admin.news')->with('message','News Added Sucessfully');
        }else{
            return view('admin.news.add');
        }
    }

    public function edit(Request $request,News $news){
        if($request->getMethod()=="POST"){
            $request->validate([
                'title'=>'required',
                'description'=>'required'
            ]);
           
            $news->title=$request->title;
            $news->description=$request->description;
            $news->Save();
            return redirect()->route('admin.news')->with('message','News Updated Sucessfully');
        }else{
            return view('admin.news.edit',['news'=>$news]);
        }
    }

    public function del(News $news){
        $news->delete();
        return redirect()->route('admin.news')->with('message','News Deleted Sucessfully');

    }
}
