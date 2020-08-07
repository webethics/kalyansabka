<div class="fl_right text-right">
	<span class=" balance">Total Payment Deposit : INR {{$payment_deposited??0}}</span><br>
	<span class=" balance"> Total Payment Withdrawal: INR {{$payment_withdrawaled??0}}</span>
</div>
<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Date</th>
			<th scope="col">Narration</th>
			<th scope="col">Deposit</th>
			<th scope="col">Withdrawal</th>
			<th scope="col">Status</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($payments) && !empty($payments) && $payments->count())
		  @php $sno = 1;  @endphp
	  @foreach($payments ?? '' as $key => $payment)
		<tr data-payment-id="{{ $payment->id }}" class="user_row_{{$payment->id}}" >
			<td id="business_name_{{$payment->id}}">{{(($page_number-1) * 10)+$sno}} <input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$payment->id}}"/></td>
			<td id="name_{{$payment->id}}">{{viewDateFormat($payment->created_at)}}</td>
			<td id="mobile_number_{{$payment->id}}">
				@if($payment->mode == 2)
					{{$payment->comment}}
				@endif
				@if($payment->mode == 1 )
					Credited - Referral Commission for <b>{{$payment->user->full_name }}</b>
				@endif
			</td>
			<td id="payment_mode1_{{$payment->id}}">@if($payment->mode == 1) INR {{$payment->amount}} @else {{'-'}} @endif</td>
			<td id="payment_mode2_{{$payment->id}}">@if($payment->mode == 2) INR {{$payment->amount}} @else {{'-'}} @endif</td>
			<td id="payment_mode2_{{$payment->id}}">@if($payment->status == 0) Pending @elseif ($payment->status == 1) Completed @endif</td>
		</tr>
		@php $sno++ @endphp
	 @endforeach
 @else
<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
 @endif	
		
	</tbody>
</table> 
	<!------------ Pagination -------------->
		@if(is_object($payments) && !empty($payments) && $payments->count()) 
		 {!! $payments->render() !!}  
		 @endif	