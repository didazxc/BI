<nav class="navbar" id="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">{{config('keytask.brand')}}</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <ul class="nav navbar-nav">
      @foreach(config('keytask.nav_array') as $k1=>$v1)
        @if(array_key_exists('children',$v1))
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa {{$v1['fa'] or ''}}">&nbsp;</span>{{$k1}} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              @foreach($v1['children'] as $k2=>$v2)
                @if(strlen(trim($v2['permission']))==0 || Auth::user()->can($v2['permission']))
                <li><a href="{{$v2['url'] or '#'}}"><span class="fa {{$v2['fa'] or ''}}">&nbsp;</span>{{$k2}}</a></li>
                @endif
              @endforeach
            </ul>
          </li>
        @else
        <li><a href="{{$v1['url'] or '#'}}">{{$k1}}<span class="fa {{$v1['fa'] or ''}}"></span></a></li>
        @endif
      @endforeach
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" >{{Auth::user()->name}} <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
    		<li><a href="/auth/logout">登出</a></li>
    	  </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>