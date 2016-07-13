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
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">查看所有</a></li>
            </ul>
          </li>