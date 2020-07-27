<tr data-request-id="{{ $request->id }}" class="user_row_{{$request->id}}" >
	<td id="sno_{{$request->id}}">{{(($page_number-1) * 10)+$sno}}
		<input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$request->id}}"/>
		<input type="hidden" name="sno" value="{{$sno}}" id="s_number_{{$request->id}}"/>
	</td>
	<td id="request_date_{{$request->id}}">{{ \Carbon\Carbon::parse($request->created_at)->format('d F Y') }}</td>
	<td id="name_{{$request->id}}">{{$request->full_name}}</td>
	<td id="email_{{$request->id}}">{{$request->email}}</td>
	<td id="address_{{$request->id}}">{{$request->address}}</td>
	<td id="status_{{$request->id}}">
		@if($request->status == 1)
			Approve
		@elseif($request->status == 2)
			Decline
		@else
			Pending
		@endif
	</td>
	<td id="action_data_{{$request->id}}">
		@if(check_role_access('request_new_detail'))
			<a class="action viewDetail"  href="javascript:void(0)" data-user_id="{{ $request->id }}" title="New Details"><i class="simple-icon-eye"></i> </a>
		@endif
		@if(check_role_access('request_document_download'))			
			<a class="action"  href="{{url('download-user-document')}}/{{ $request->user_id }}" title="Download Documents"><i class="simple-icon-cloud-download"></i> </a> 
		@endif
	</td>
</tr>