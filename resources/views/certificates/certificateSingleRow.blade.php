<tr data-certificate-id="{{ $certificate->id }}" class="user_row_{{$certificate->id}}" >
	<td id="sno_{{$certificate->id}}">{{(($page_number-1) * 10)+$sno}}
		<input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$certificate->id}}"/>
		<input type="hidden" name="sno" value="{{$sno}}" id="s_number_{{$certificate->id}}"/>
	</td>
	<td id="registration_date_{{$certificate->id}}">{{viewDateFormat($certificate->created_at)}}</td>
	<td id="name_{{$certificate->id}}">{{$certificate->full_name}}</td>
	<td id="email_{{$certificate->id}}">{{$certificate->email}}</td>
	<td id="address_{{$certificate->id}}">{{$certificate->address}}</td>
	<td id="status_{{$certificate->id}}">
		@if($certificate->certificate_status == 1)
			Sent
		@else
			Pending
		@endif
	</td>
	<td id="action_data_{{$certificate->id}}">
		
		@if(check_role_access('certificate_request_edit'))
			<a class="action editCertitificateRequest" href="javascript:void(0)" data-user_id="{{ $certificate->id }}" title="Edit Request"><i class="simple-icon-note"></i> </a>
		@endif
		@if(check_role_access('certificate_download'))
			<a class="action"  href="{{url('download-certificate')}}/{{ $certificate->id }}" title="Download Certificate"><i class="simple-icon-cloud-download"></i> </a> 
		@endif
	</td>
</tr>