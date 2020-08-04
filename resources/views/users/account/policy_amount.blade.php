@if(isset($policyAmount) && $policyAmount > 0)
	<hr>

	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Total Amount to pay</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="current_plan">INR {{$policyAmount}}</label>
		<input type="hidden" name="amount" value="{{$policyAmount}}">
		
	</div>

	<hr>
@endif
