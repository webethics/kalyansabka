<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Ticket Id</th>
		<th scope="col">Subject</th>
		<th scope="col">Status</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($complaints) && !empty($complaints) && $complaints->count())
		 @php $sno = 1;$sno_new = 0  @endphp
		
	  @foreach($complaints as $key => $complaint)
		<tr data-customer-id="{{ $complaint->id }}" class="user_row_{{$complaint->id}}" >
			
			<td id="sno_{{$complaint->id}}">{{(($page_number-1) * 10)+$sno}} <input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$complaint->id}}"/></td>
			<td id="ticket_{{$complaint->id}}">RERDRT584</td>
			<td id="name_{{$complaint->id}}">This is the test ticket</td>
			<td id="name_{{$complaint->id}}">Completed</td>
			
			<td id="action_{{$complaint->id}}">
				
				
					<a class="action changeComplaint" href="javascript:void(0)" data-complaint_id="{{ $complaint->id }}" title="Edit Complaint"><i class="simple-icon-note"></i> </a> 
				
					<a title="Delete Complaint"  data-id="{{ $complaint->id }}" data-confirm_type="complete" data-confirm_message ="Are you sure you want to delete the Complaint?"  data-left_button_name ="Yes" data-left_button_id ="delete_complaint" data-left_button_cls="btn-primary" class="open_confirmBox action deleteComplaint"  href="javascript:void(0)" data-complaint_id="{{ $complaint->id }}"><i class="simple-icon-trash"></i></a>
				
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
		@if(is_object($complaints) && !empty($complaints) && $complaints->count()) 
		 {!! $complaints->render() !!}  
		 @endif	