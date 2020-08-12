<div id="showOnLoadOnly" class="policy_plans">
	@if(isset($currentPlanInfo) && $currentPlanInfo['name'] != "")
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.active_plan')}}</label>
		<label class="col-lg-7 col-xl-7 col-form-label" id="current_plan">INR {{$currentPlanInfo->cost}} - {{$currentPlanInfo->description}}</label>
		<label class="col-lg-2 col-xl-3 col-form-label" id="current_plan_certificate">
			<a class="action viewCustomer" href="{{ url('customer-certificate') }}" data-user_id="{{ $user->id }}" title="View and Download Certificate"><i class="simple-icon-eye"></i> </a>
		</label>
	</div>
	<div class="row cancel_policy_scenerio">
		@include('users.account.cancel_policy')
	</div>
	<hr>
	@endif

	@if(isset($upgradeRequestPolicy) && isset($upgradeRequestPolicy['name']) && $upgradeRequestPolicy['name'] != "")
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Upgrade plan request</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="upgrade_plan">INR {{$upgradeRequestPolicy->cost}} - {{$upgradeRequestPolicy->description}}</label>
		{{--<label class="col-lg-2 col-xl-3 col-form-label" id="upgradet_plan_certificate">
			<a class="action viewCustomer" href="{{ url('upgrade-customer-certificate') }}" data-user_id="{{ $user->id }}" title="View Certificate"><i class="simple-icon-cloud-download"></i> </a>
		</label>--}}
	</div>

	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Amount to pay</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="remaing_amount">INR {{$remainingAmount}}</label>
	</div>

	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Request Expired On</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="request_expired">{{$tempUpgradePendingRequest->expired_view_format}}</label>
	</div>

	<div class="form-row mt-4">
		
		<div class="col-lg-9 col-xl-10">
			<form method="POST" action="{{ url('upgrade_plan_request') }}/{{$user->id}}" class="frm_class" id="upgrade_plan_form" data-id="{{$user->id}}">
				{{ csrf_field() }}
				<input type="hidden" name="upgrade_id" value="{{$tempUpgradePendingRequest->id}}">
				<input type="hidden" name="plan" value="{{$tempUpgradePendingRequest->plan_id}}">
				<input type="hidden" name="cost" value="{{$tempUpgradePendingRequest->upgrade_tax_id}}">
				<input type="hidden" name="amount" value="{{$tempUpgradePendingRequest->amount}}">
				<button type="button" id="pay_now" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto" data-payment="paid">{{trans('global.pay_now')}}</button>
				<div class="spinner-border text-primary search_upgrade_spinloder" style="display:none"></div>
			</form>
		</div>
		<label class="col-lg-3 col-xl-2 col-form-label"></label>
	</div>
	<hr>
	@endif



	@if(isset($upgradePlan) && $upgradePlan->count() > 0 && empty($upgradeRequestPolicy))
	<h5 class="mb-4">Upgrade your Plan</h5>

	<form method="POST" action="{{ url('upgrade_plan_request') }}/{{$user->id}}" class="frm_class" id="upgrade_plan_form" data-id="{{$user->id}}">
		{{ csrf_field() }}
									
		<div class="form-row upgrade_plan">
			<div class="col-md-12">
				<div class="input-group mb-3">
					
					@foreach($upgradePlan as $plandata)
						<div class="radio">
							<label class=" ml-3"><input type="radio" name="plan" id="plan" data-cost="{{$plandata->cost}}"  class="plan_checkbox" value="{{$plandata->id}}" @if (old('plan') == "$plandata->id") {{ 'checked' }} @endif /> <span>INR {{$plandata->cost}} - {{$plandata->description}}</span></label>
						</div>
					@endforeach
					
				</div>
				<div class="error_margin"><span class="error plan_error" > </span></div>
			
			</div>
		</div>

		@if(isset($upgradeAdditionalCost) && $upgradeAdditionalCost->count() > 0)
		<h5 class="mb-4">Additional Charges for part payment</h5>

		<div class="form-row additional-cost">
			<div class="col-md-12">
				<div class="input-group mb-3">
					
					@foreach($upgradeAdditionalCost as $ckey=>$additional)
						@php $payNowText = ''; $payNowStatus = 0;@endphp
						@if($ckey == 0)
							@php $payNowText = 'Pay Now or'; $payNowStatus = 1; @endphp
						@endif
						<div class="radio">
							<label class=" ml-3"><input type="radio" name="cost" id="cost" data-paystatus="{{$payNowStatus}}" data-cost="{{$additional->cost}}"  class="cost_checkbox" value="{{$additional->id}}" @if (old('cost') == "$additional->id") {{ 'checked' }} @endif /> <span>{{$payNowText}} Pay within {{$additional->name}}</span></label>
						</div>
					@endforeach
					
				</div>
				<div class="error_margin"><span class="error cost_error" > </span></div>
			
			</div>
		</div>
		@endif


		<div class="policy-amount">
			<div class="spinner-border text-primary search_amount_spinloder" style="display:none"></div>
			@include('users.account.policy_amount')
		</div>

		<div class="row">
			<div class="form-group">
				<button type="submit" id="pay_now" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto disabled" disabled="true" data-payment="paid">{{trans('global.pay_now')}}</button>
				<button type="button" id="pay_later" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto disabled" disabled="true" data-payment="later">Pay later</button>
				<div class="spinner-border text-primary search_upgrade_spinloder" style="display:none"></div>
			</div>	
		</div>
	</form>
	@endif	
</div>