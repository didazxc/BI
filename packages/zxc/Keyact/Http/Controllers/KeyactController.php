<?php
namespace Zxc\Keyact\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Zxc\Keyact\KeyAct;
use Auth;
use Route;
use Redirect;


class KeyactController extends BaseController
{
	use ValidatesRequests;
    public function index()
    {
        return view('keyact::home.home');
    }

	public function getEdit(Request $request)
	{
		$act=$request->input('id')?KeyAct::find($request->input('id')):new KeyAct();
		return view('keyact::home.edit',['act'=>$act]);
	}
	
	public function postEdit(Request $request)
	{
		$this->validate($request, [
			'act_name' => 'required|max:255',
			'goal' => 'required',
			'online_time' => 'required|date',
			'offline_time' => 'required|date',
		],[
            'act_name.required' => '名称未填写.',
            'online_time.required' => '上线时间未填写.',
            'online_time.date' => '上线时间请填写日期.',
            'offline_time.required' => '下线时间未填写.',
            'offline_time.date' => '下线时间填写日期.',
        ]);
		$act=$request->input('id')?KeyAct::find($request->input('id')):new KeyAct();
		$act->username=Auth::user()->name;
		$act->pattern=$request->input('pattern');
		$act->act_name=$request->input('act_name');
		$act->goal=$request->input('goal');
		$act->online_time=$request->input('online_time');
		$act->offline_time=$request->input('offline_time');
		$act->online_intro=$request->input('online_intro');
		$act->offline_intro=$request->input('offline_intro');
		$act->save();
		return Redirect::route('actList');
	}
	
	public function getList(Request $request)
	{
		$startdate=$request->input('startdate',date('Y-m-d',strtotime('-14 day')));
		$enddate=$request->input('enddate',date('Y-m-d',strtotime('+14 day')));
		$list=KeyAct::whereBetween('online_time',[$startdate,$enddate])->get();
        return view('keyact::home.list',compact('list','startdate','enddate'));
	}
	
	public function getInfo(Request $request)
	{
		if($request->input('id',0)){
			$act=KeyAct::find($request->input('id'));
			return view('keyact::home.info',compact('act'));
		}else{
			return Redirect::route('actList');
		}
	}
	
	public function postDel(Request $request)
	{
		if($request->input('id',0)){
			KeyAct::find($request->input('id'))->delete();
		}
		return 1;
	}
	
}
