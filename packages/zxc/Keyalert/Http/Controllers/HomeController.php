<?php
namespace Zxc\Keyalert\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Zxc\Keyalert\Models\KeyAlert;
use Illuminate\Database\Eloquent\Collection;
use Zxc\Keysql\Models\KeySqlNav;

class HomeController extends BaseController
{
    
    public function getwx(Request $request)
    {
        $res['str']='';
        
        $hour=$request->has('H')?$request->input('H'):'09';
        $min=$request->has('i')?$request->input('i'):'30';
        
        $cycle=$request->has('cycle')?$request->input('cycle'):'daily';
        
        if($cycle=='h' || $cycle=='i' || (date('H')==$hour && intval(date('i'))<$min))
        {
            switch($cycle){
                case 'd':
                case 'day':
                case 'daily':
                    $cron=1;
                    $mintime=date('Y-m-d H:i:00',strtotime('-1 day'));
                    break;
                case 'w':
                case 'week':
                case 'weekly':
                    $cron=2;
                    $mintime=date('Y-m-d H:i:00',strtotime('-1 week'));
                    break;
                case 'm':
                case 'month':
                case 'monthly':
                    $cron=4;
                    $mintime=date('Y-m-d H:i:00',strtotime('-1 month'));
                    break;
                case 'i':
                    $cron=8;
                    $mintime=date('Y-m-d H:i:00',strtotime('-1 minute'));
                    break;
                case 'h':
                default:
                    $cron=16;
                    $mintime=date('Y-m-d H:i:00',strtotime('-1 hour'));
            }
            
            $alerts=KeyAlert::where('logtime','>=',$mintime)->where('cron',$cron)->where('pro','>=','2')->get();
            
            if(count($alerts)){
                $str='【预警】';
                $i=0;
                foreach($alerts as $alert){
                    $i+=1;
                    $str.='<br/><br/>'.$i.'.'.str_replace('  ','<br/>  ',$alert->alert_desc);
                }
                $res['str']=$str;
            }
        }
        return view('keyalert::home.wx',['res'=>(json_encode($res))]);
    }
    
    public function getAlertlist(Request $request){
        view()->composer(
            ['keysql::layouts.sidebar'],
            'Zxc\Keysql\Http\ViewComposers\HomeNavTreeComposer');
        $path=new Collection([
                    new KeySqlNav(['name'=>'home']),
                    new KeySqlNav(['name'=>'预警','desc'=>'预警列表','fa_icon'=>'fa-bell-o'])
                ]);
        $startdate=$request->input('startdate',date('Y-m-d',strtotime('-6 day')));
        $enddate=$request->input('enddate',date('Y-m-d'));
        $alertlist=KeyAlert::where('logtime','>=',$startdate)
            ->where('logtime','<',date('Y-m-d',strtotime($enddate.' +1 day')))
            ->orderBy('logtime','desc')->get();
        return view('keyalert::home.alertlist',compact('path','alertlist','startdate','enddate'));
    }
    
}
