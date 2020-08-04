<div id="showOnLoadOnly" class="policy_plans">
	@if(isset($currentPlanInfo) && $currentPlanInfo['name'] != "")
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.active_plan')}}</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="current_plan">INR {{$currentPlanInfo->cost}} - {{$currentPlanInfo->description}}</label>
		
	</div>
	<hr>
	@endif

	@if(isset($upgradeRequestPolicy) && isset($upgradeRequestPolicy['name']) && $upgradeRequestPolicy['name'] != "")
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Upgrade plan request</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="upgrade_plan">INR {{$upgradeRequestPolicy->cost}} - {{$upgradeRequestPolicy->description}}</label>
	</div>

	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Amount to pay</label>
		<label class="col-lg-6 col-xl-6 col-form-label" id="remaing_amount">INR {{$remainingAmount}}</label>
		<label class="col-lg-3 col-xl-4 col-form-label" id="remaing_amount_button">
			<form method="POST" action="{{ url('upgrade_plan_request') }}/{{$user->id}}" class="frm_class" id="upgrade_plan_form" data-id="{{$user->id}}">
				{{ csrf_field() }}
				<input type="hidden" name="upgrade_id" value="{{$tempUpgradePendingRequest->id}}">
				<input type="hidden" name="plan" value="{{$tempUpgradePendingRequest->plan_id}}">
				<input type="hidden" name="cost" value="{{$tempUpgradePendingRequest->upgrade_tax_id}}">
				<input type="hidden" name="amount" value="{{$tempUpgradePendingRequest->amount}}">
				<button type="button" id="pay_now" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto" data-payment="paid">{{trans('global.pay_now')}}</button>
			</form>
		</label>

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
		<h5 class="mb-4">Additional Cost</h5>

		<div class="form-row additional-cost">
			<div class="col-md-12">
				<div class="input-group mb-3">
					
					@foreach($upgradeAdditionalCost as $additional)
						<div class="radio">
							<label class=" ml-3"><input type="radio" name="cost" id="cost" data-cost="{{$additional->cost}}"  class="cost_checkbox" value="{{$additional->id}}" @if (old('cost') == "$additional->id") {{ 'checked' }} @endif /> <span>Pay within {{$additional->name}} then pay {{$additional->cost}}% of remaining amount</span></label>
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