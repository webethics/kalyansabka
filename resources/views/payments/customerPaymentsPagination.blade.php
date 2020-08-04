<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Date</th>
		<th scope="col">Narration</th>
		<th scope="col">Deposit</th>
		<th scope="col">Withdrawl</th>
		<th scope="col">Admin Charges</th>
		<th scope="col">TDS Deduction</th>
		<th scope="col">Deposit To Bank</th>
		
		</tr>
	</thead>
	<tbody>
	 @if(is_object($payments ?? '') && !empty($payments ?? '') && $payments ?? ''->count())
		  @php $sno = 1;  @endphp
	  @foreach($payments ?? '' as $key => $payment)
		<tr data-payment-id="{{ $payment->id }}" class="user_row_{{$payment->id}}" >
			<td id="business_name_{{$payment->id}}">{{(($page_number-1) * 10)+$sno}} <input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$payment->id}}"/></td>
			<td id="name_{{$payment->id}}">{{ date('d-m-Y', strtotime($payment->created_at))  ?? '' }}</td>
			<td id="mobile_number_{{$payment->id}}">
				@if($payment->mode == 2)
					Debited
				@endif
				@if($payment->mode == 1)
					Credited
				@endif
			</td>
			<td id="payment_mode1_{{$payment->id}}">@if($payment->mode == 1) INR {{$payment->amount}} @else {{'-'}} @endif</td>
			<td id="payment_mode2_{{$payment->id}}">@if($payment->mode == 2) INR {{$payment->amount}} @else {{'-'}} @endif</td>
			<td id="admin_charges_{{$payment->id}}">@if($payment->mode == 2 && isset($payment->request_changes->admin_charges)) INR {{$payment->request_changes->admin_charges}} @else {{'-'}} @endif</td>
			<td id="tds_deduction_{{$payment->id}}">@if($payment->mode == 2 && isset($payment->request_changes->tds_deduction)) INR {{$payment->request_changes->tds_deduction}} @else {{'-'}} @endif</td>
			<td id="deposit_to_bank_{{$payment->id}}">@if($payment->mode == 2 && isset($payment->request_changes->deposit_to_bank)) INR {{$payment->request_changes->deposit_to_bank}} @else {{'-'}} @endif</td>
			
		</tr>
		@php $sno++ @endphp
	 @endforeach
 @else
<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
 @endif	
		
	</tbody>
</table> 
	<!------------ Pagination -------------->
		@if(is_object($payments ?? '') && !empty($payments ?? '') && $payments ?? ''->count()) 
		 {!! $payments ?? ''->render() !!}  
		 @endif	