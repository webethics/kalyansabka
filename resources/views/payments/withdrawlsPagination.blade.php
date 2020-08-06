<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Date</th>
		<th scope="col">Name</th>
		<th scope="col">Email</th>
		<th scope="col">Amount</th>
		<th scope="col">Status</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($payments) && !empty($payments) && $payments->count())
		  @php $sno = 1;$sno_new = 0  @endphp
	  @foreach($payments as $key => $payment)
		<tr data-payment-id="{{ $payment->id }}" class="user_row_{{$payment->id}}" >
			<td id="sno_{{$payment->id}}">{{(($page_number-1) * 10)+$sno}} <input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$payment->id}}"/></td>
			<td id="name_{{$payment->id}}">{{viewDateFormat($payment->created_at)}}</td>
			<td id="mobile_number_{{$payment->id}}">{{$payment->user->first_name}} {{$payment->user->last_name}}</td>
			<td id="business_url_{{$payment->id}}">{{$payment->user->email}}</td>
			<td id="business_url_{{$payment->id}}">INR {{$payment->amount_requested}}</td>
			<td id="email_{{$payment->id}}">
				@if($payment->status ==0) {{"Pending"}} 
				@elseif($payment->status == 1) {{"Approve"}} 
				@elseif($payment->status == 2) {{"Decline"}} @endif </td>
			<td id="email_{{$payment->id}}">
				@if(check_role_access('withdrawl_edit'))
					<a class="action editPayment" href="javascript:void(0)" data-payment_id="{{ $payment->id }}" title="Edit Withdrawl Request"><i class="simple-icon-note"></i> </a>
				@endif
			</td>
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