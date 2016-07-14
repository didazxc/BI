          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{count($alerts)}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">近七日共 {{$alerts_num}} 条预警</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($alerts as $alert)
                  <li>
                    <a href="#">
                      <i class="fa fa-{{$alert->faicon or 'warning'}} text-{{$alert->color}}"></i> {{$alert->alert_desc}}
                    </a>
                  </li>
                  @endforeach
                
                </ul>
              </li>
              <li class="footer"><a href="#">查看所有</a></li>
            </ul>
          </li>