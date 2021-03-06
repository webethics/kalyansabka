<div class="menu">
	<div class="main-menu">
		<div class="scroll">
		
		
		 @php    
			$roleArray = Config::get('constant.role_id');
			$dashboardactive='';  $custactive='';	 $payactive='';	$withdrawlactive=''; $certactive=''; $ccertactive=''; $editactive=''; $configactive='';  	$custpayactive='';	$roleactive=''; $commissionactive=''; $complaintsactive=''; $listcomplaintsactive=''; $policyactive='';	   $intmationactive='';	$emailactive=''; $companyactive='';  $referralactive=''; 
			
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
		 
		 @if(collect(request()->segments())->last()=='companies')
		 @php
	      $companyactive ='active'
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
		 @if(collect(request()->segments())->last()=='roles')
		 @php
	      $roleactive ='active'
	     @endphp
		 @endif
		 @if(collect(request()->segments())->last()=='complaints')
		 @php
	      $complaintsactive ='active'
	     @endphp
		 @endif
		 @if(collect(request()->segments())->last()=='list-complaints')
		 @php
	      $listcomplaintsactive ='active'
	     @endphp
		 @endif
		 @if(collect(request()->segments())->last()=='policies-requests')
		 @php
	      $policyactive ='active'
	     @endphp
		 @endif

		 @if(collect(request()->segments())->last()=='commission')
		 @php
	      $commissionactive ='active'
	     @endphp
		 @endif
		 @if(collect(request()->segments())->last()=='claim-intimations')
		 @php
	      $intmationactive ='active'
	     @endphp
		 @endif
		 
			<ul class="list-unstyled">
				
					@if(check_role_access('dashboard_listing'))
					<li class="{{$dashboardactive}}">
						<a href="{{url('/dashboard')}}">
							<i class="simple-icon-home"></i>
							<span>Dashbaord</span>
						</a>
					</li>
					@endif
					@if(check_role_access('customer_listing'))
						<li class="{{$custactive}}">
							<a href="{{url('/customers')}}">
								<i class="simple-icon-user"></i>
								<span>Customers</span>
							</a>
						</li>
					@endif
					@if(check_role_access('payment_listing'))
					<li class="{{$payactive}}">
						<a href="{{url('/payments')}}">
							<i class="simple-icon-paypal"></i>
							<span>Payments</span>
						</a>
					</li>
					@endif
					@if(check_role_access('withdrawl_listing'))
					<li class="{{$withdrawlactive}}">
						<a href="{{url('/withdrawls')}}">
							<i class="iconsminds-dollar"></i>
							<span>Withdrawal Requests</span>
						</a>
					</li>
					@endif
					@if(check_role_access('certificate_listing'))
					<li class="{{$certactive}}">
						<a href="{{url('/certificates')}}">
							<i class="simple-icon-doc"></i>
							<span>Certificate Requests</span>
						</a>
					</li>
					@endif
					@if(check_role_access('edit_request_listing'))
					<li class="{{$editactive}}">
						<a href="{{url('/requests')}}">
							<i class="iconsminds-digital-drawing"></i>
							<span>Edit Requests</span>
						</a>
					</li>
					@endif
					@if(check_role_access('commission_listing'))
					<li class="{{$commissionactive}}">
						<a href="{{url('/commissions')}}">
							<i class="iconsminds-coins"></i>
							<span>Commission</span>
						</a>
					</li>
					@endif
					@if(check_role_access('email_listing'))
					<li class="{{$emailactive}}">
						<a href="{{url('/emails')}}">
							<i class="iconsminds-mail"></i>
							<span>Email</span>
						</a>
					</li>
					@endif
					@if(check_role_access('config_listing'))
					<li class="{{$configactive}}">
						<a href="{{url('/settings')}}">
							<i class="simple-icon-settings"></i>
							<span>Config</span>
						</a>
					</li>
					@endif
					@if(check_role_access('roles_listing'))
					<li class="{{$roleactive}}">
						<a href="{{url('/roles')}}">
							<i class="simple-icon-organization"></i>
							<span>Roles</span>
						</a>
					</li>
					@endif
					
					@if(check_role_access('companies_listing'))
					<li class="{{$companyactive}}">
						<a href="{{url('/companies')}}">
							<i class="simple-icon-chart"></i>
							<span>Companies</span>
						</a>
					</li>
					@endif
					@if(check_role_access('complaints_listing'))
					<li class="{{$listcomplaintsactive}}">
						<a href="{{url('/list-complaints')}}">
							<i class="simple-icon-support"></i>
							<span>Complaints</span>
						</a>
					</li>
					@endif
					@if(check_role_access('policy_cancellation_listing'))
					<li class="{{$policyactive}}">
						<a href="{{url('/policies-requests')}}">
							<i class="simple-icon-doc"></i>
							<span>Policy Cancellation Requests</span>
						</a>
					</li>
					@endif
					@if(check_role_access('claim_intimation_listing'))
					<li class="{{$intmationactive}}">
						<a href="{{url('/claim-intimations')}}">
							<i class="simple-icon-exclamation"></i>
							<span>Claim Intimations</span>
						</a>
					</li>
					@endif
				
				 
				@if(current_user_role_id() != 1 && current_user_role_id() != 2)
					
					
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
					<li class="{{$complaintsactive}}">
						<a href="{{url('/complaints')}}">
							<i class="iconsminds-support"></i>
							<span>Complaints</span>
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
					@if(check_role_access('india_head_customers'))
					<li class="{{$custactive}}">
						<a href="/customers">
							<i class="iconsminds-digital-drawing"></i>
							<span>Customers</span>
						</a>
					</li>
					@endif
					 @if(check_role_access('india_head_payments'))
						<li class="{{$custpayactive}}">
							<a href="{{url('/customer-payments')}}">
								<i class="simple-icon-paypal"></i>
								<span>Payments</span>
							</a>
						</li>
					@endif
					
					
				
				@endif
				 
			</ul>
		</div>
	</div>    
</div>