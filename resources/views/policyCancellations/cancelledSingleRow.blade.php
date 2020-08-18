<tr data-cancelledRequest-id="{{ $cancelledRequest->id }}" class="user_row_{{$cancelledRequest->id}}" >
	<td id="sno_{{$cancelledRequest->id}}">{{(($page_number-1) * 10)+$sno}} 
		<input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$cancelledRequest->id}}"/>
		<input type="hidden" name="sno" value="{{$sno}}" id="s_number_{{$cancelledRequest->id}}"/>
	</td>
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
		@if(check_role_access('policy_cancellation_edit'))
			<a class="action editPolicyRequest" href="javascript:void(0)" data-payment_id="{{ $cancelledRequest->id }}" title="Edit Policy Cancellation Request"><i class="simple-icon-note"></i> </a>
		@endif
	</td>
</tr>