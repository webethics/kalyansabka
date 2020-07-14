<div class="menu">
	<div class="main-menu">
		<div class="scroll">
		 @php    
			$roleArray = Config::get('constant.role_id');
			$dashboardactive='';  $custactive='';	 $payactive='';	$withdrawlactive=''; $certactive=''; $ccertactive=''; $editactive=''; $configactive=''; $custpayactive='';
			$emailactive=''; 
			$referralactive=''; 
			
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
		  @if(collect(request()->segments())->last()=='dashboard')
		 @php
	      $dashboardactive ='active'
	     @endphp
		 @endif
		  @if(collect(request()->segments())->last()=='payments')
		 @php
	      $payactive ='active'
	     @endphp
		 @endif

		 @if(collect(request()->segments())->last()=='customer-payments')
		 @php
	      $custpayactive ='active'
	     @endphp
		 @endif
		  @if(collect(request()->segments())->last()=='requests')
		 @php
	      $editactive ='active'
	     @endphp
		 @endif
		  @if(collect(request()->segments())->last()=='withdrawls')
		 @php
	      $withdrawlactive ='active'
	     @endphp
		 @endif
		  @if(collect(request()->segments())->last()=='customers')
		 @php
	      $custactive ='active'
	     @endphp
		 @endif
		  @if(collect(request()->segments())->last()=='certificates')
		 @php
	      $certactive ='active'
	     @endphp
		 @endif
		 
		  @if(collect(request()->segments())->last()=='customer-certificate')
		 @php
	      $ccertactive ='active'
	     @endphp
		 @endif
		 
		  @if(collect(request()->segments())->last()=='emails')
		 @php
	      $emailactive ='active'
	     @endphp
		 @endif
		  @if(collect(request()->segments())->last()=='referrals')
		 @php
	      $referralactive ='active'
	     @endphp
		 @endif
		 
			<ul class="list-unstyled">
				@if(current_user_role_id()==$roleArray['SUPER_ADMIN'])
					<li class="{{$dashboardactive}}">
						<a href="{{url('/dashboard')}}">
							<i class="simple-icon-home"></i>
							<span>Dashbaord</span>
						</a>
					</li>
					<li class="{{$custactive}}">
						<a href="{{url('/customers')}}">
							<i class="simple-icon-user"></i>
							<span>Customers</span>
						</a>
					</li>
					<li class="{{$payactive}}">
						<a href="{{url('/payments')}}">
							<i class="simple-icon-paypal"></i>
							<span>Payments</span>
						</a>
					</li>
					<li class="{{$withdrawlactive}}">
						<a href="{{url('/withdrawls')}}">
							<i class="iconsminds-dollar"></i>
							<span>Withdrawls</span>
						</a>
					</li>
					<li class="{{$certactive}}">
						<a href="{{url('/certificates')}}">
							<i class="simple-icon-doc"></i>
							<span>Certificates</span>
						</a>
					</li>
					<li class="{{$editactive}}">
						<a href="{{url('/requests')}}">
							<i class="iconsminds-digital-drawing"></i>
							<span>Edit Requests</span>
						</a>
					</li>
					<li class="{{$emailactive}}">
						<a href="{{url('/emails')}}">
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
					<li class="{{$custpayactive}}">
						<a href="{{url('/customer-payments')}}">
							<i class="simple-icon-paypal"></i>
							<span>Payments</span>
						</a>
					</li>
					<li class="{{$ccertactive}}">
						<a href="{{url('/customer-certificate')}}">
							<i class="simple-icon-doc"></i>
							<span>Certificates</span>
						</a>
					</li>	
					<li class="{{$referralactive}}">
						<a href="{{url('/referrals')}}">
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