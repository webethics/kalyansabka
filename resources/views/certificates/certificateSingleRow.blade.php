<tr data-certificate-id="{{ $certificate->id }}" class="user_row_{{$certificate->id}}" >
	<td id="sno_{{$certificate->id}}">{{($page_number * 10)+$sno}}
		<input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$certificate->id}}"/>
		<input type="hidden" name="sno" value="{{$sno}}" id="s_number_{{$certificate->id}}"/>
	</td>
	<td id="name_{{$certificate->id}}">{{ \Carbon\Carbon::parse($certificate->created_at)->format('d F Y') }}</td>
	<td id="mobile_number_{{$certificate->id}}">{{$certificate->full_name}}</td>
	<td id="business_url_{{$certificate->id}}">{{$certificate->email}}</td>
	<td id="business_url_{{$certificate->id}}">{{$certificate->address}}</td>
	<td id="business_url_{{$certificate->id}}">
		@if($certificate->certificate_status == 1)
			Sent
		@else
			Pending
		@endif
	</td>
	<td id="business_url_{{$certificate->id}}">
		
		@if(check_role_access('certificate_request_edit'))
			<a class="action editCertitificateRequest" href="javascript:void(0)" data-user_id="{{ $certificate->id }}" title="Edit Request"><i class="simple-icon-note"></i> </a>
		@endif
		@if(check_role_access('certificate_download'))
			<a class="action"  href="javascript:void(0)" title="Download Certificate"><i class="simple-icon-cloud-download"></i> </a> 
		@endif
	</td>
</tr>