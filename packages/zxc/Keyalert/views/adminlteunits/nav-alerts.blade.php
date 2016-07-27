          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{$alerts_num>0?count($alerts):''}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">近七日共 {{$alerts_num}} 条预警</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($alerts as $alert)
                  <li>
                    <a href="{{route('alertlist')}}">
                      <i class="fa fa-{{$alert->script->faicon?$alert->script->faicon:'warning'}} text-{{$alert->color}}"></i> 
                      {{$alert->alert_desc}}
                      <br/>
                      <small class="pull-right"><i class="fa fa-clock-o">&nbsp;</i>{{date('m-d H:i',strtotime($alert->logtime))}}</small>
                    </a>
                  </li>
                  @endforeach
                
                </ul>
              </li>
              <li class="footer"><a href="{{route('alertlist')}}">查看所有预警</a></li>
            </ul>
          </li>