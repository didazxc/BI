<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{$path[count($path)-1]->name}}
        <small>{{$path[count($path)-1]->desc or ''}}</small>
    </h1>
        <ol class="breadcrumb">
            <i class="active fa {{$path[count($path)-1]->fa_icon}}"></i>
            @for($i=0;$i<count($path);++$i)
                <li class="active">
                    @if($path[$i]->href==0 || $i==count($path)-1)
                        {{$path[$i]->name}}
                    @else
                        <a href="{{$path[$i]->href}}">
                            {{$path[$i]->name}}
                        </a>
                    @endif
                </li>
            @endfor
        </ol>
</section>
