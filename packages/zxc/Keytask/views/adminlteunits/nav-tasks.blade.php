
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">{{$tasks_num?count($tasks):''}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">最近共 {{$tasks_num}} 个需求</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($tasks as $task)
                  <li><!-- Task item -->
                    <a href="{{route('taskinfo',['id'=>$task->id])}}">
                      <h3>
                      {{$task->name}}
                        <small class="pull-right">{{$task->progress}}%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-{{$task->color}}" style="width: {{$task->progress}}%" role="progressbar" aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">{{$task->progress}}% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="footer">
                <a href="{{route('demandlist')}}">查看所有需求</a>
              </li>
            </ul>
          </li>