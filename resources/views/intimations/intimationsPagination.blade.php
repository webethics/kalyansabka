<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Date</th>
		<th scope="col">Policy Number</th>
		<th scope="col">Intimation Aadhaar Number</th>
		<th scope="col">Intimation Mobile Number</th>
		<th scope="col">Status</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($intimations) && !empty($intimations) && $intimations->count())
		  @php $sno = 1;$sno_new = 0  @endphp
	  @foreach($intimations as $key => $intimation)
		<tr data-intimation-id="{{ $intimation->id }}" class="user_row_{{$intimation->id}}" >
			<td id="sno_{{$intimation->id}}">{{(($page_number-1) * 10)+$sno}} <input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$intimation->id}}"/></td>
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
		@php $sno++ @endphp
	 @endforeach
 @else
<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
 @endif	
		
	</tbody>
</table> 
	<!------------ Pagination -------------->
		@if(is_object($intimations) && !empty($intimations) && $intimations->count()) 
		 {!! $intimations->render() !!}  
		 @endif	