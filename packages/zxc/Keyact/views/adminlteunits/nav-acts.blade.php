
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bookmark-o"></i>
              <span class="label label-success">{{$acts_num?count($acts):''}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">今日共 {{$acts_num}} 个事件</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($acts as $act)
                  <li>
                    <a href="{{route('actInfo',$act->id)}}">
                      <i class="fa fa-{{$act->faicon}} text-{{$act->color}}"></i> {{$act->act_name}}
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="footer">
                <a href="{{route('actList')}}">查看所有事件</a>
              </li>
            </ul>
          </li>