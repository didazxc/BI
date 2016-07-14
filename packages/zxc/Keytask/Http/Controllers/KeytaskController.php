<?php
namespace Zxc\Keytask\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Zxc\Keytask\KeyTask;
use Zxc\Keytask\KeyTaskHour;
use Auth;
use Route;
use Redirect;
use Validator;


class KeytaskController extends BaseController
{
    public function index()
    {
        return view('keytask::home.home');
    }
    
    //以下为需求方操作模块
    public function getDemandList(Request $request)
    {
        $startdate=$request->input('startdate',date('Y-m-d',strtotime('-7 day')));
        $enddate=$request->input('enddate',date('Y-m-d'));
        $tasklist=KeyTask::whereBetween('created_at',[$startdate,date('Y-m-d',strtotime($enddate.' +1 day'))])
            ->where('from_user_name',Auth::user()->name)
            ->orderBy('created_at','desc')
            ->get();
        return view('keytask::demand.demandlist',compact('startdate','enddate','tasklist'));
    }
    public function getDemandEdit(Request $request)
    {
        $task_id=$request->input('id',0);
        $task=$task_id?KeyTask::find($task_id):new KeyTask();
        $userlist=\App\Role::where('name',config('keytask.permission_task_role'))->first()->users()->lists('name','id');
        return view('keytask::demand.demandedit',compact('task','userlist'));
    }
    public function postDemandEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
        ], [
            'name.required' => '请填写名称',
            'desc.required' => '请填写描述',
        ]);
        if ($validator->fails()) {
            return ['errors'=>$validator->errors()->all()];
        }
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            if($task->status!='wait'){
                return ['errors'=>'非等待状态的需求无法编辑'];
            }
        }else{
            $task=new KeyTask();
        }
        
        $task->status='wait';
        $task->name=$request->input('name');
        $task->from_user_name=Auth::user()->name;
        if($request->input('to_user_name')){
            $task->to_user_name=$request->input('to_user_name');
        }
        $task->deadline=$request->input('deadline');
        $task->desc=$request->input('desc');
        $task->save();
        return 1;
    }
    public function postDemandDelete(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            if($task->status=='wait'){
                $task->delete();
                return 1;
            }
        }
        return 0;
    }
    public function postDemandCancel(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            if($task->status=='doing'){
                $task->status='canceling';
                $task->save();
                return 1;
            }
        }
        return 0;
    }
    //以下为分析师操作模块
    public function getTaskList(Request $request)
    {
        $startdate=$request->input('startdate',date('Y-m-d',strtotime('-7 day')));
        $enddate=$request->input('enddate',date('Y-m-d'));
        $tasklist=KeyTask::whereBetween('created_at',[$startdate,date('Y-m-d',strtotime($enddate.' +1 day'))])->orderBy('updated_at','desc')->get();
        return view('keytask::task.tasklist',compact('startdate','enddate','tasklist'));
    }
    public function getTaskEdit(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            $taskhours=KeyTaskHour::where('task_id',$task_id)->orderBy('created_at','desc')->get();
        }
        return view('keytask::task.taskedit',compact('task','taskhours'));
    }
    public function postTaskEdit(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            $task->result=$request->input('result','');
            $task->save();
            return 1;
        }
        return 0;
    }
    public function postTaskCancel(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            if($task->status!='canceling'){
                return 0;
            }
            if($request->has('reject')){
                $task->status='doing';
                $task->save();
                return ['progress'=>$task->progress];
            }else{
                $task->status='cancel';
                $task->save();
                return 1;
            }

        }
        return 0;
    }
    
    public function postTaskReceive(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            if($task->status!='wait'){
                return 0;
            }
            $task->estimate=$request->input('estimate');
            $task->status='doing';
            $task->starttime=date('Y-m-d H:i:s');
            $task->to_user_name=Auth::user()->name;
            $task->save();
            return 1;
        }
        return 0;
    }
    
    public function postTaskHour(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consumed' => 'required',
            'left' => 'required',
            'desc' => 'required',
        ], [
            'consumed.required' => '请填写消耗时间',
            'left.required' => '请填写预计剩余时间',
            'desc.required' => '请填写描述',
        ]);
        if ($validator->fails()) {
            return ['errors'=>$validator->errors()->all()];
        }
        
        $task_id=$request->input('id',0);
        if($task_id<=0){
            return 0;
        }
        $task=KeyTask::find($task_id);
        if($task->status!='doing'){
            return 0;
        }
        
        $keyhour=new KeyTaskHour();
        $keyhour->task_id=$task_id;
        $keyhour->user_name=Auth::user()->name;
        $keyhour->logtime=$request->input('logtime');
        $keyhour->operation='taskhour-set';
        $keyhour->consumed=$request->input('consumed');
        $keyhour->left=$request->input('left');
        $keyhour->desc=$request->input('desc');
        $keyhour->save();
        
        $task->left=$request->input('left');
        $task->consumed=KeyTaskHour::where('task_id',$task_id)->sum('consumed');
        $task->save();
        
        if($request->has('hour')){
            return compact('keyhour');
        }
        
        return $task->progress;
    }
    public function postTaskHourDelete(Request $request)
    {
        $id=$request->input('id',0);
        if($id){
            KeyTaskHour::find($id)->delete();
            return 1;
        }
        return 0;
    }

    public function postTaskDone(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            $task->status='done';
            $task->endtime=date('Y-m-d H:i:s');
            $task->save();
            return 1;
        }
        return 0;
    }
    
    public function getTaskInfo(Request $request)
    {
        $task_id=$request->input('id',0);
        if($task_id){
            $task=KeyTask::find($task_id);
            $taskhours=KeyTaskHour::where('task_id',$task_id)->orderBy('created_at','desc')->get();
            return view('keytask::task.info',compact('task','taskhours'));
        }
        return Redirect::route('demandlist') ;
    }
}
