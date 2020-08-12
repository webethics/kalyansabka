<tr data-commission-id="{{ $commission->id }}" class="user_row_{{$commission->id}}" >
	<td id="sno_{{$commission->id}}">{{(($page_number-1) * 10)+$sno}}
		<input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$commission->id}}"/>
		<input type="hidden" name="sno" value="{{$sno}}" id="s_number_{{$commission->id}}"/>
	</td>
	<td id="name_{{$commission->id}}">{{$commission->name}}</td>
	<td id="slug_{{$commission->id}}">{{$commission->percentage ?? 0}}%</td>
	
	<td id="action_data_{{$commission->id}}">
		@if(check_role_access('commission_edit'))
			<a class="action editCommissionRequest" href="javascript:void(0)" data-comm_id="{{$commission->id}}" title="Edit Commission"><i class="simple-icon-note"></i> </a>
		@endif
		
		
	</td>	
</tr>