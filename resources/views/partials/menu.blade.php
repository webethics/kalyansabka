<div class="menu">
	<div class="main-menu">
		<div class="scroll">
		 @php    
			$roleArray = Config::get('constant.role_id');
			$dashboardactive='';  $custactive='';	 $payactive='';	$withdrawlactive=''; $certactive='';$editactive='';$configactive='';
			$emailactive=''; 
			
			$sactive ='';$emactive ='';$site_sactive ='';$accactive  ='';
		 @endphp
		 
		 @if(collect(request()->segments())->last()=='account')
		 @php
	      $accactive ='active'
	     @endphp
		 @endif
		  @if(collect(request()->segments())->last()=='settings')
		 @php
	      $configactive ='active'
	     @endphp
		 @endif
		 
			<ul class="list-unstyled">
				@if(current_user_role_id()==$roleArray['SUPER_ADMIN'])
					<li class="{{$dashboardactive}}">
						<a href="javascript:void(0)">
							<i class="simple-icon-home"></i>
							<span>Dashbaord</span>
						</a>
					</li>
					<li class="{{$custactive}}">
						<a href="javascript:void(0)">
							<i class="simple-icon-user"></i>
							<span>Customers</span>
						</a>
					</li>
					<li class="{{$payactive}}">
						<a href="{{url('/account')}}">
							<i class="simple-icon-paypal"></i>
							<span>Payments</span>
						</a>
					</li>
					<li class="{{$withdrawlactive}}">
						<a href="{{url('/account')}}">
							<i class="iconsminds-dollar"></i>
							<span>Withdrawls</span>
						</a>
					</li>
					<li class="{{$certactive}}">
						<a href="{{url('/account')}}">
							<i class="simple-icon-doc"></i>
							<span>Certificates</span>
						</a>
					</li>
					<li class="{{$editactive}}">
						<a href="{{url('/account')}}">
							<i class="iconsminds-digital-drawing"></i>
							<span>Edit Requests</span>
						</a>
					</li>
					<li class="{{$emailactive}}">
						<a href="{{url('/account')}}">
							<i class="iconsminds-mail"></i>
							<span>Email</span>
						</a>
					</li>
					<li class="{{$configactive}}">
						<a href="{{url('/settings')}}">
							<i class="simple-icon-settings"></i>
							<span>Config</span>
						</a>
					</li>
				
				
				 @endif
				 
				@if(current_user_role_id()==$roleArray['NORMAL_USER'])
					<li class="{{$accactive}}">
						<a href="{{url('/account')}}">
							<i class="iconsminds-user"></i> 
							<span>Account</span>
						</a>
					</li>
					<li class="{{$payactive}}">
						<a href="{{url('/account')}}">
							<i class="simple-icon-paypal"></i>
							<span>Payments</span>
						</a>
					</li>
					<li class="{{$certactive}}">
						<a href="{{url('/account')}}">
							<i class="simple-icon-doc"></i>
							<span>Certificates</span>
						</a>
					</li>	
					<li class="{{$certactive}}">
						<a href="{{url('/account')}}">
							<i class="iconsminds-affiliate"></i>
							<span>Referrals</span>
						</a>
					</li>
				@endif
				 
				@if(current_user_role_id()==$roleArray['INDIA_HEAD'])
					<li class="{{$accactive}}">
						<a href="{{url('/account')}}">
							<i class="iconsminds-user"></i> 
							<span>Account</span>
						</a>
					</li>
					<li class="{{$custactive}}">
						<a href="javascript:void(0)">
							<i class="iconsminds-digital-drawing"></i>
							<span>Customers</span>
						</a>
					</li>
					<li class="{{$payactive}}">
						<a href="{{url('/account')}}">
							<i class="simple-icon-paypal"></i>
							<span>Payments</span>
						</a>
					</li>
					
				
				@endif
				 
			</ul>
		</div>
	</div>    
</div>