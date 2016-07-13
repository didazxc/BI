  <aside class="main-sidebar" id="sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('img/tusiji-mianbao.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="{{route('searchnav')}}" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
<?php
$traverse = function ($categories) use (&$traverse,$path) {
    foreach ($categories as $nav) {
        if(is_array($nav)){
            if(!array_key_exists('children',$nav)){
                $nav['children']=[];
            };
            $nav=(object)$nav;
        }
        if(count($nav->children)>0){
?>
<li class="treeview @if($path->find($nav->id)) active @endif">
    <a href="#">
        <i class="fa {{$nav->fa_icon or 'fa-circle-o'}}"></i> 
        <span>{{$nav->name}}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
<?php
            $traverse($nav->children);
?>
    </ul>
</li>
<?php
        }else{
?>
<li class="@if($path->find($nav->id)) active @endif">
    <a href="{{$nav->href}}">
        <i class="fa {{$nav->fa_icon or 'fa-circle-o'}}"></i>
        <span>{{$nav->name}}</span>
    </a>
</li>
<?php
        }
    }
};
$traverse($nav_tree);
?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>