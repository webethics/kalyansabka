<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Date</th>
		<th scope="col">Name</th>
		<th scope="col">Email</th>
		<th scope="col">Aadhaar Number</th>
		<th scope="col">Policy Number</th>
		<th scope="col">Status</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($cancelledPolicyRequests) && !empty($cancelledPolicyRequests) && $cancelledPolicyRequests->count())
		  @php $sno = 1;$sno_new = 0  @endphp
	  @foreach($cancelledPolicyRequests as $key => $cancelledRequest)
		<tr data-cancelledRequest-id="{{ $cancelledRequest->id }}" class="user_row_{{$cancelledRequest->id}}" >
			<td id="sno_{{$cancelledRequest->id}}">{{(($page_number-1) * 10)+$sno}} <input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$cancelledRequest->id}}"/></td>
			<td id="name_{{$cancelledRequest->id}}">{{viewDateFormat($cancelledRequest->created_at)}}</td>
			<td id="mobile_number_{{$cancelledRequest->id}}">{{$cancelledRequest->user->first_name}} {{$cancelledRequest->user->last_name}}</td>
			<td id="business_url_{{$cancelledRequest->id}}">{{$cancelledRequest->user->email}}</td>
			<td id="business_url_{{$cancelledRequest->id}}">{{$cancelledRequest->user->aadhar_number}}</td>
			<td id="email_{{$cancelledRequest->id}}">
				KALYANSABKA_25648</td>
			<td id="email_{{$cancelledRequest->id}}">
				@if ($cancelledRequest->request_status == "0") {{ 'Pending' }} @endif
				@if ($cancelledRequest->request_status == "1") {{ 'Declined' }} @endif
				@if ($cancelledRequest->request_status == "2") {{ 'Approved' }} @endif
				
				</td>
			<td id="email_{{$cancelledRequest->id}}">
				@if(check_role_access('withdrawl_edit'))
					<a class="action editPolicyRequest" href="javascript:void(0)" data-payment_id="{{ $cancelledRequest->id }}" title="Edit Policy Cancellation Request"><i class="simple-icon-note"></i> </a>
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
		@if(is_object($cancelledPolicyRequests) && !empty($cancelledPolicyRequests) && $cancelledPolicyRequests->count()) 
		 {!! $cancelledPolicyRequests->render() !!}  
		 @endif	