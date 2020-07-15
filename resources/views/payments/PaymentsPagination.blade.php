<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Date</th>
		<th scope="col">Reference ID</th>
		<th scope="col">Name</th>
		<th scope="col">Email</th>
		<th scope="col">Deposit</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($payments ?? '') && !empty($payments ?? '') && $payments ?? ''->count())
	  @foreach($payments ?? '' as $key => $payment)
		<tr data-payment-id="{{ $payment->id }}" class="user_row_{{$payment->id}}" >
			<td id="business_name_{{$payment->id}}">{{$payment->id}}</td>
			<td id="name_{{$payment->id}}">10 July 2020</td>
			<td id="email_{{$payment->id}}">RSDTOKIJEL254</td>
			<td id="mobile_number_{{$payment->id}}">Path Coder</td>
			<td id="business_url_{{$payment->id}}">pathcodertest@gmail.com</td>
			<td id="business_url_{{$payment->id}}">INR 2500</td>
		</tr>
		
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