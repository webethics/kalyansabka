<tr data-intimation-id="{{ $intimation->id }}" class="user_row_{{$intimation->id}}" >
	<td id="sno_{{$intimation->id}}">{{(($page_number-1) * 10)+$sno}} 
		<input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$intimation->id}}"/>
		<input type="hidden" name="sno" value="{{$sno}}" id="s_number_{{$intimation->id}}"/>
	</td>
	<td id="name_{{$intimation->id}}">{{$intimation->claim_request_id}}</td>
	<td id="name_{{$intimation->id}}">{{viewDateFormat($intimation->created_at)}}</td>
	
	<td id="business_url_{{$intimation->id}}">{{$intimation->policy_number}}</td>
	<td id="business_url_{{$intimation->id}}">{{$intimation->initimation_aadhar_number}}</td>
	<td id="business_url_{{$intimation->id}}">{{$intimation->initimation_mobile_number}}</td>
	<td id="email_{{$intimation->id}}">
		@if ($intimation->status == "0") {{ 'Pending' }} @endif
		@if ($intimation->status == "1") {{ 'Disapproved' }} @endif
		@if ($intimation->status == "2") {{ 'Approved' }} @endif
		
	</td>
	
	<td id="email_{{$intimation->id}}">
		@if(check_role_access('claim_intimation_edit'))
			<a class="action editClaimRequest" href="javascript:void(0)" data-claim_id="{{ $intimation->id }}" title="Edit Policy Cancellation Request"><i class="simple-icon-note"></i> </a>
		@endif
	</td>
</tr>