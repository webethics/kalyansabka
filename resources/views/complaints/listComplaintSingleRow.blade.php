<tr data-customer-id="{{ $complaint->id }}" class="user_row_{{$complaint->id}}" >
			
	<td id="sno_{{$complaint->id}}">{{(($page_number-1) * 10)+$sno}} 
		<input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$complaint->id}}"/>
		<input type="hidden" name="sno" value="{{$sno}}" id="s_number_{{$complaint->id}}"/>
	</td>
	<td id="ticket_{{$complaint->id}}">{{strtoupper($complaint->ticket_id)}}</td>
	<td id="name_{{$complaint->id}}">{{$complaint->user->full_name}}</td>
	<td id="name_{{$complaint->id}}">{{$complaint->user->email}}</td>
	<td id="subject_{{$complaint->id}}">{{$complaint->subject}}</td>
	<td id="status_{{$complaint->id}}">
			@if ($complaint->status == "0") {{ 'New' }} @endif
			@if ($complaint->status == "1") {{ 'In Progress' }} @endif
			@if ($complaint->status == "2") {{ 'Completed' }} @endif
	</td>
	
	<td id="action_{{$complaint->id}}">
		
			@if(check_role_access('complaints_edit'))
				<a class="action changeComplaint" href="javascript:void(0)" data-complaint_id="{{ $complaint->id }}" title="Edit Complaint"><i class="simple-icon-note"></i> </a> 
			@endif
			
			@if(check_role_access('complaints_edit'))
				<a title="Delete Complaint"  data-id="{{ $complaint->id }}" data-confirm_type="complete" data-confirm_message ="Are you sure you want to delete the Complaint?"  data-left_button_name ="Yes" data-left_button_id ="delete_complaint" data-left_button_cls="btn-primary" class="open_confirmBox action deleteComplaint"  href="javascript:void(0)" data-complaint_id="{{ $complaint->id }}"><i class="simple-icon-trash"></i></a>
			@endif
		
	</td>	
</tr>