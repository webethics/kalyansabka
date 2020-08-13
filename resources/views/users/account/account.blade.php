@extends('layouts.admin')
@section('content')
@section('profilepageJsCss')


<script src="{{ asset('js/module/jquery.account.js')}}"></script>
<script src="{{ asset('js/module/account_form.js')}}"></script>
<script src="{{ asset('js/module/jquery.customer_1.js')}}"></script>
@stop

<div class="row">
	<div class="col-12">
		<h1>{{trans('global.account_fields')}}</h1>
		<div class="separator mb-5"></div>
	</div>
</div>
<div class="row">
	<div class="col-12 mb-4">			
		<div class="card mb-4">
			<div class="row">
				<div class="col-md-3">
					<div class="card-header tabs-header">
						<ul class="nav nav-tabs vertical-tabs flex-column card-header-tabs " role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
									aria-controls="first" aria-selected="true">{{trans('global.basic')}}</a>
							</li>
							@if(current_user_role_id()==3 || current_user_role_id()== 4 || current_user_role_id()== 5)
							<li class="nav-item">
								<a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
									aria-controls="second" aria-selected="true">{{trans('global.nominee')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab"
									aria-controls="third" aria-selected="true">{{trans('global.documents')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab"
									aria-controls="fourth" aria-selected="true">{{trans('global.bank_details')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="six-tab" data-toggle="tab" href="#six" role="tab"
									aria-controls="six" aria-selected="true">{{trans('global.plans')}}</a>
							</li>
							@endif
							@if(check_role_access('account_reset_password'))
								<li class="nav-item">
									<a class="nav-link" id="fifth-tab" data-toggle="tab" href="#fifth" role="tab"
										aria-controls="fifth" aria-selected="false">{{trans('global.reset_password')}}</a>
								</li>
							@endif
						</ul>
					</div>				  
				</div>	
				<div class="col-md-9">						
					<div class="card-body">
						<div class="tab-content">
							<div id="msg" class="alert hide"></div>
							<div class="tab-pane fade show active" id="first" role="tabpanel"  aria-labelledby="first-tab">
								@include('users.account.basic_info')
							</div>	

							@if(current_user_role_id()!=1)
								<div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
									@include('users.account.nominee_info')
								</div>
								
								<div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
									@include('users.account.document_info')
									
								</div>
								<div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
									@include('users.account.bank_info')
								</div>

								<div class="tab-pane fade" id="six" role="tabpanel" aria-labelledby="six-tab">
									@include('users.account.policy_plan')
								</div>
							@endif
							<div class="tab-pane fade" id="fifth" role="tabpanel" aria-labelledby="fifth-tab">
								<form name="reset_pass" id="reset_pass" data-id="{{$user->id}}">
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.old_password')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="password" name="old_password" id="old_password" class="form-control">
										</div>
										<div class="old_password_error errors"></div>
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.new_password')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="password" name="password" id="password" class="form-control">
										</div>
										<div class="password_error errors"></div>
										</div>
										
									</div>								
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.confirm_password')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
										</div>
										<div class="password_confirmation_error errors"></div>
										</div>
										
									</div>
									
									
									<div class="form-row mt-4">
										<label class="col-lg-3 col-xl-2 col-form-label"></label>
										<div class="col-lg-9 col-xl-10">
											<button type="button" id="reset" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
										</div>
									</div>
								</form>
							</div>
							
							
							
							
							
						</div>			
					</div>			
				</div>			
			</div>			
		</div>				

	</div>
</div>
@section('cancelsubscriptionJsAccountBlade')


<script>

jQuery('#basic_info').click(function(){
	jQuery('#first_account_info').hide('slow');
	jQuery('#accountinfo').show('slow');
});

jQuery('#nominee_info').click(function(){
	jQuery('#nomminee_pass_info').hide('slow');
	jQuery('#nomminee_pass').show('slow');
	

});

jQuery('#bank_info').click(function(){
	jQuery('#bank_info_show').hide('slow');
	jQuery('#bank_info_edit').show('slow');	
});

jQuery('#document_info').click(function(){
	jQuery('#site_customer_settings_info').hide('slow');
	jQuery('#site_customer_settings').show('slow');	
});


jQuery('#basic_info_cancel').click(function(){
	jQuery('#first_account_info').show('slow');
	jQuery('#accountinfo').hide('slow');
});

jQuery('#nominee_info_cancel').click(function(){
	jQuery('#nomminee_pass_info').show('slow');
	jQuery('#nomminee_pass').hide('slow');
	

});

jQuery('#bank_info_cancel').click(function(){
	jQuery('#bank_info_show').show('slow');
	jQuery('#bank_info_edit').hide('slow');	
});

jQuery('#document_info_cancel').click(function(){
	jQuery('#site_customer_settings_info').show('slow');
	jQuery('#site_customer_settings').hide('slow');	
});

jQuery('.nav-link').click(function(){
	jQuery('#first_account_info').show('slow');
	jQuery('#nomminee_pass_info').show('slow');
	jQuery('#bank_info_show').show('slow');
	jQuery('#site_customer_settings_info').show('slow');
	
	
	jQuery('#site_customer_settings').hide('');	
	jQuery('#bank_info_edit').hide('');	
	jQuery('#nomminee_pass').hide('');	
	jQuery('#accountinfo').hide('');	
});
	
	
	
	
$(document).ready(function(){
	
	 $('#update-basic-request').prop('disabled', true);
	 
     $('form#accountinfo input[type="text"]').keyup(function() {
        if($(this).val() != '' && $('#submit_button').val() == 0) {
           $('#update-basic-request').prop('disabled', false);
        }
     });
	 
	$('form#accountinfo select').change(function() {
        if($(this).val() != '' && $('#submit_button').val() == 0) {
           $('#update-basic-request').prop('disabled', false);
        }
     });
	 
	 
	$(".box").hide();
	var  state = $('#state').val();
	if(state != ''){
		getCityDropDown(state);
	}
	var nominee_number = 	$('#nominee_number').val();
	if(nominee_number){
		showDiv('div',nominee_number);
	}
});

function getCityDropDown(state_id){
	 
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: "POST",
			//dataType: 'json',
			url: base_url+'/user/cityDropdown',
			data: {_token:csrf_token,state_id:state_id},
			success: function(data) {
				 $("#district").empty().html(data); 
			},
			error :function( data ) {}
		});
}
$('#state').change(function(){
	var state_id = $(this).val();
	getCityDropDown(state_id);
});
</script>
@stop			

@endsection
	