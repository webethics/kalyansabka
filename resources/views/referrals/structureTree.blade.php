@if(isset($userInfo) && !empty($userInfo))
<div class="tree">
    <ul>
        <li>
            {{--Root User --}}
            <a href="#" data-id="{{$userInfo['user_id']}}" class='member_tree'>
                <div class="member">
                    <div class="person">
                        @if($userInfo['gender'] == 'male')
                            <i class="iconsminds-male-2"></i>
                        @else
                            <i class="iconsminds-female-2"></i>
                        @endif
                        <p class="name">{{$userInfo['name']}}</p>
                    </div>
                    <div class='metaInfo'>
                        <p class='info'>{{$userInfo['name']}}</p>
                        <p class='info'>{{$userInfo['email']}}</p>
                        <p class='info'> Total referral: {{$userInfo['counter']}}</p>
                    </div>
                </div>
            </a>
            @if(isset($level) && !empty($level) && count($level) > 0)
                @if(isset($level['level1']) && !empty($level['level1']) && count($level['level1']) > 0)
                {{--Level 1 User--}}
                <ul>
                    @foreach($level['level1'] as $key => $lev1)
                        @php $level_user_id1 = $lev1['user_id']; @endphp
                    <li>
                        <a href="#" data-id="{{$lev1['user_id']}}" class='member_tree'>
                            <div class="member">
                                <div class="person">
                                    @if($lev1['gender'] == 'male')
                                        <i class="iconsminds-male-2"></i>
                                    @else
                                        <i class="iconsminds-female-2"></i>
                                    @endif
                                    <p class="name">{{$lev1['name']}}</p>
                                </div>
                                <div class='metaInfo'>
                                    <p class='info'>{{$lev1['name']}}</p>
                                    <p class='info'>{{$lev1['email']}}</p>
                                    <p class='info'> Total referral: {{$lev1['counter']}}</p>
                                </div>
                            </div>
                        </a>
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
                                                <a href="#" data-id="{{${"lev$i"}['user_id']}}" class='member_tree'>
                                                    <div class="member">
                                                        <div class="person">
                                                            @if(${"lev$i"}['gender'] == 'male')
                                                                <i class="iconsminds-male-2"></i>
                                                            @else
                                                                <i class="iconsminds-female-2"></i>
                                                            @endif
                                                            <p class="name">{{${"lev$i"}['name']}}</p>
                                                        </div>
                                                        <div class='metaInfo'>
                                                            <p class='info'>{{${"lev$i"}['name']}}</p>
                                                            <p class='info'>{{${"lev$i"}['email']}}</p>
                                                            <p class='info'> Total referral: {{${"lev$i"}['counter']}}</p>
                                                        </div>
                                                    </div>
                                                </a>
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
                                                                        <a href="#" data-id="{{${"lev$i3"}['user_id']}}" class='member_tree'>
                                                                            <div class="member">
                                                                                <div class="person">
                                                                                    @if(${"lev$i3"}['gender'] == 'male')
                                                                                        <i class="iconsminds-male-2"></i>
                                                                                    @else
                                                                                        <i class="iconsminds-female-2"></i>
                                                                                    @endif
                                                                                    <p class="name">{{${"lev$i3"}['name']}}</p>
                                                                                </div>
                                                                                <div class='metaInfo'>
                                                                                    <p class='info'>{{${"lev$i3"}['name']}}</p>
                                                                                    <p class='info'>{{${"lev$i3"}['email']}}</p>
                                                                                    <p class='info'> Total referral: {{${"lev$i3"}['counter']}}</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                        {{-- Level4 Users --}}
                                                                        @php $next_level4 = 4; $i4 = 4; @endphp
                                                                        @if($next_level4<=$tree_level)
                                                                            @php $k4=$next_level4-1; @endphp
                                                                            @if(isset($level["level$i4"]) && !empty($level["level$i4"]) && count($level["level$i4"]) > 0)
                                                                                @if(isset($level["level$i4"][${"level_user_id$k4"}]) && !empty($level["level$i4"][${"level_user_id$k4"}]) && count($level["level$i4"][${"level_user_id$k4"}]) > 0)
                                                                                    @php echo 'count='.count($level["level$i4"][${"level_user_id$k4"}]); @endphp
                                                                                    <ul>
                                                                                        @foreach($level["level$i4"][${"level_user_id$k4"}] as $key => ${"lev$i4"})
                                                                                            @php ${"level_user_id$i4"} = ${"lev$i4"}['user_id']; @endphp
                                                                                            <li>
                                                                                                <a href="#" data-id="{{${"lev$i4"}['user_id']}}" class='member_tree'>
                                                                                                    <div class="member">
                                                                                                        <div class="person">
                                                                                                            @if(${"lev$i4"}['gender'] == 'male')
                                                                                                                <i class="iconsminds-male-2"></i>
                                                                                                            @else
                                                                                                                <i class="iconsminds-female-2"></i>
                                                                                                            @endif
                                                                                                            <p class="name">{{${"lev$i4"}['name']}}</p>
                                                                                                        </div>
                                                                                                        <div class='metaInfo'>
                                                                                                            <p class='info'>{{${"lev$i4"}['name']}}</p>
                                                                                                            <p class='info'>{{${"lev$i4"}['email']}}</p>
                                                                                                            <p class='info'> Total referral: {{${"lev$i4"}['counter']}}</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </a>
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
                                                                                                                        <a href="#" data-id="{{${"lev$i5"}['user_id']}}" class='member_tree'>
                                                                                                                            <div class="member">
                                                                                                                                <div class="person">
                                                                                                                                    @if(${"lev$i5"}['gender'] == 'male')
                                                                                                                                        <i class="iconsminds-male-2"></i>
                                                                                                                                    @else
                                                                                                                                        <i class="iconsminds-female-2"></i>
                                                                                                                                    @endif
                                                                                                                                    <p class="name">{{${"lev$i5"}['name']}}</p>
                                                                                                                                </div>
                                                                                                                                <div class='metaInfo'>
                                                                                                                                    <p class='info'>{{${"lev$i5"}['name']}}</p>
                                                                                                                                    <p class='info'>{{${"lev$i5"}['email']}}</p>
                                                                                                                                    <p class='info'> Total referral: {{${"lev$i5"}['counter']}}</p>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
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
                
                    @endforeach
                </ul>
                {{--Level1 User End --}}
                @endif
            @endif
        </li>
    </ul>
</div>
@endif