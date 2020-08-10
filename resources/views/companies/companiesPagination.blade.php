<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Name</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($companies) && !empty($companies) && $companies->count())
		 @php $sno = 1;$sno_new = 0  @endphp
		
	  @foreach($companies as $key => $company)
		<tr data-customer-id="{{ $company->id }}" class="user_row_{{$company->id}}" >
			
			<td id="sno_{{$company->id}}">{{(($page_number-1) * 10)+$sno}} <input type="hidden" name="page_number" value="{{$page_number}}" id="page_number_{{$company->id}}"/></td>
			
			<td id="name_{{$company->id}}">{{$company->name}}</td>
			
			<td id="action_{{$company->id}}">
				
				@if(check_role_access('companies_edit'))
					<a class="action editCompany" href="javascript:void(0)" data-company_id="{{ $company->id }}" title="Edit Company"><i class="simple-icon-note"></i> </a> 
				@endif
				
				
				@if(check_role_access('companies_delete'))
					<a title="Delete Company"  data-id="{{ $company->id }}" data-confirm_type="complete" data-confirm_message ="Are you sure you want to delete the Company?"  data-left_button_name ="Yes" data-left_button_id ="delete_company" data-left_button_cls="btn-primary" class="open_confirmBox action deleteCompany"  href="javascript:void(0)" data-company_id="{{ $company->id }}"><i class="simple-icon-trash"></i></a>
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
		@if(is_object($companies) && !empty($companies) && $companies->count()) 
		 {!! $companies->render() !!}  
		 @endif	