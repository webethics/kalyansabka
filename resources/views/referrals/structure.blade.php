@extends('layouts.admin')
@section('additionalCss')
<style>
.tree ul {
    padding-top: 20px; position: relative;
    
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

.tree li {
    float: left; text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;
    
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
    content: '';
    position: absolute; top: 0; right: 50%;
    border-top: 1px solid #ccc;
    width: 50%; height: 20px;
}
.tree li::after{
    right: auto; left: 50%;
    border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
    display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
    border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
    border-right: 1px solid #ccc;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
    border-radius: 5px 0 0 0;
    -webkit-border-radius: 5px 0 0 0;
    -moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
    content: '';
    position: absolute; top: 0; left: 50%;
    border-left: 1px solid #ccc;
    width: 0; height: 20px;
}

.tree li a{
    border: 1px solid #ccc;
    padding: 5px 10px;
    text-decoration: none;
    color: #666;
    font-family: arial, verdana, tahoma;
    font-size: 11px;
    display: inline-block;
    
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
    background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
    border-color:  #94a0b4;
}
</style>
@stop
@section('content')
    @if(isset($userInfo) && !empty($userInfo))
    <div class="tree">
        <ul>
            <li>
                {{--Root User --}}
                <a href="#" data-id="{{$userInfo['user_id']}}">{{$userInfo['name']}}</a>
                @if(isset($level) && !empty($level) && count($level) > 0)
                    @if(isset($level['level1']) && !empty($level['level1']) && count($level['level1']) > 0)
                    {{--Level 1 User--}}
                    <ul>
                        @foreach($level['level1'] as $key => $lev1)
                            @php $level_user_id1 = $lev1['user_id']; @endphp
                        <li>
                            <a href="#" data-id="{{$lev1['user_id']}}">{{$lev1['name']}}</a>
                            {{--Level 2 User --}}
                            @php $next_level = 2; $i = 2; @endphp
                            @if($next_level<=$tree_level)
                                @php $k=$next_level-1; @endphp
                                @if(isset($level["level$i"]) && !empty($level["level$i"]) && count($level["level$i"]) > 0)
                                    @if(isset($level["level$i"][${"level_user_id$k"}]) && !empty($level["level$i"][${"level_user_id$k"}]) && count($level["level$i"][${"level_user_id$k"}]) > 0)
                                        <ul>
                                            @foreach($level["level$i"][${"level_user_id$k"}] as $key => ${"lev$i"})
                                                @php ${"level_user_id$i"} = ${"lev$i"}['user_id']; @endphp
                                                <li>
                                                    <a href="#" data-id="{{${"lev$i"}['user_id']}}">{{${"lev$i"}['name']}}</a>
                                                    {{--Level 3 User--}}
                                                    @php $next_level3 = 3; $i3 = 3; @endphp
                                                    @if($next_level3<=$tree_level)
                                                        @php $k3=$next_level3-1; @endphp
                                                        @if(isset($level["level$i3"]) && !empty($level["level$i3"]) && count($level["level$i3"]) > 0)
                                                            @if(isset($level["level$i3"][${"level_user_id$k3"}]) && !empty($level["level$i3"][${"level_user_id$k3"}]) && count($level["level$i3"][${"level_user_id$k3"}]) > 0)
                                                                <ul>
                                                                    @foreach($level["level$i3"][${"level_user_id$k3"}] as $key => ${"lev$i3"})
                                                                        @php ${"level_user_id$i3"} = ${"lev$i3"}['user_id'];  @endphp
                                                                        <li>
                                                                            <a href="#" data-id="{{${"lev$i3"}['user_id']}}">{{${"lev$i3"}['name']}}</a>
                                                                            {{-- Level4 Users --}}
                                                                            @php $next_level4 = 4; $i4 = 4; @endphp
                                                                            @if($next_level4<=$tree_level)
                                                                                @php $k4=$next_level4-1; @endphp
                                                                                @if(isset($level["level$i4"]) && !empty($level["level$i4"]) && count($level["level$i4"]) > 0)
                                                                                    @if(isset($level["level$i4"][${"level_user_id$k4"}]) && !empty($level["level$i4"][${"level_user_id$k4"}]) && count($level["level$i4"][${"level_user_id$k4"}]) > 0)
                                                                                        <ul>
                                                                                            @foreach($level["level$i4"][${"level_user_id$k4"}] as $key => ${"lev$i4"})
                                                                                                @php ${"level_user_id$i4"} = ${"lev$i4"}['user_id']; @endphp
                                                                                                <li>
                                                                                                    <a href="#" data-id="{{${"lev$i4"}['user_id']}}">{{${"lev$i4"}['name']}}</a>
                                                                                                    {{-- Level5 Users --}}
                                                                                                    @php $next_level5 = 5; $i5 = 5; @endphp
                                                                                                    @if($next_level5<=$tree_level)
                                                                                                        @php $k5=$next_level5-1; @endphp
                                                                                                        @if(isset($level["level$i5"]) && !empty($level["level$i5"]) && count($level["level$i5"]) > 0)
                                                                                                            @if(isset($level["level$i5"][${"level_user_id$k5"}]) && !empty($level["level$i5"][${"level_user_id$k5"}]) && count($level["level$i5"][${"level_user_id$k5"}]) > 0)
                                                                                                                <ul>
                                                                                                                    @foreach($level["level$i5"][${"level_user_id$k5"}] as $key => ${"lev$i5"})
                                                                                                                        @php ${"level_user_id$i5"} = ${"lev$i5"}['user_id']; @endphp
                                                                                                                        <li>
                                                                                                                            <a href="#" data-id="{{${"lev$i5"}['user_id']}}">{{${"lev$i5"}['name']}}</a>
                                                                                                                        </li>
                                                                                                                    @endforeach
                                                                                                                </ul>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @endif
                                                                                                    {{-- Level5 End --}}
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                            {{-- Level4 End --}}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    {{-- Level3 User End --}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                            @endif
                            {{-- Level2 User End --}}
                        </li>
                        <!--<li>
                            <a href="#">3</a>
                            <ul>
                                <li>
                                    <a href="#">3.1</a>
                                    <ul>
                                        <li>
                                            <a href="#">3.1.1</a>
                                        </li>
                                        <li>
                                            <a href="#">3.1.2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">3.2</a>
                                </li>
                                <li>
                                    <a href="#">3.3</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">4</a>
                        </li>-->
                    
                        @endforeach
                    </ul>
                    {{--Level1 User End --}}
                    @endif
                @endif
            </li>
        </ul>
    </div>
    @endif
    <!--<div class="card previous-level">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <a href="javascript:void(0);" class="btn btn-warning default btn-xl mb-2 previous">Back</a>
                    <a href="javascript:void(0);" class="btn btn-warning default btn-xl mb-2 reset-root">Reset</a>
                </div>
            </div>                      
        </div>
    </div>-->
@endsection
@section('userJs')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>
@stop