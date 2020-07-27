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
							@if(current_user_role_id()==3 || current_user_role_id()==2)
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
								<div class="" id="first_account_info">
									<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="basic_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
									<div class="clearfix"></div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.first_name')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->first_name}}</label>
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.last_name')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->last_name}}</label>
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.email')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->email}}</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->aadhar_number}}</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Mobile</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->mobile_number}}</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.address')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->address}}</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.state')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->state_id}}</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.district')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">{{$user->district_id}}</label>
									</div>
								</div>	
								<form name="accountinfo" id="accountinfo" data-id="{{$user->id}}" style="display:none">		
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.first_name')}}<em>*</em> </label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
										<input type="text" name="first_name" id="first_name" class="form-control" value="{{$user->first_name}}">
										</div>
										<div class="first_name_error errors"></div>
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.last_name')}}<em>*</em> </label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
										<input type="text" name="last_name" id="last_name" class="form-control" value="{{$user->last_name}}">
										</div>
										<div class="last_name_error errors"></div>
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.email')}}<em>*</em></label>
										<div class="col-lg-9 col-xl-10 d-flex">
											<input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" readonly>
										</div>
									</div>
									
									@if(current_user_role_id()!=1)
										
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Mobile <em>*</em></label>
										
										
										<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											<input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{$user->mobile_number}}">
											</div>
											<div class="mobile_number_error errors"></div>
										</div>
										
									</div>	

									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar<em>*</em></label>
										
										
										<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											<input type="text" name="aadhar_number" id="aadhar_number" class="form-control" value="{{$user->aadhar_number}}">
											</div>
											<div class="aadhar_number_error errors"></div>
										</div>
										
									</div>	

									
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.address')}}<em>*</em></label>
										<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<input type="text" name="address" value="{{$user->address}}" class="form-control" placeholder="{{trans('global.address')}}">
											</div>
											<div class="address_error errors"></div>
										</div>								
									</div>	
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.state')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											
												<select name="state" id="state" class="form-control">
													<option value="">Select State</option>
													@foreach(list_states() as $key=>$value)
														<option value="{{$value->id}}" @if ("$user->state_id" == "$value->id") {{ 'selected' }} @endif >{{$value->state_name}}</option>
													@endforeach
												</select>
												
											</div>
											<div class="state_error errors"></div>
										</div>							
										
									</div>					
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.district')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											
												<select name="district" id="district" class="form-control" >
													<option value="">Select District</option>
												</select>
												
											</div>
											<div class="district_error errors"></div>
										</div>							
										
									</div>					
									@endif
									<div class="form-row mt-4">
										<label class="col-lg-3 col-xl-2 col-form-label"></label>
										<div class="col-lg-9 col-xl-10">
											<!--input type="submit" id="update" value="Submit" class="btn btn-primary default btn-lg mb-1 mr-2"-->
											<button type="button" id="update" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
											<button type="button" id="basic_info_cancel" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.cancel')}}</button>
										
										</div>
									</div>
									
								</form>
							</div>	

							@if(current_user_role_id()!=1)
							<div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
								<div class="" id="nomminee_pass_info">
									<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="nominee_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
									<div class="clearfix"></div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Path</label>
										
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Father</label>
									</div>
									<hr>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Path</label>
										
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Father</label>
									</div>
									<hr>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Path</label>
										
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Father</label>
									</div>
									<hr>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Path</label>
										
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
										<label class="col-lg-9 col-xl-10 col-form-label">Father</label>
									</div>
									<hr>
									
								</div>	
								
								<form name="nomminee_pass" id="nomminee_pass" data-id="{{$user->id}}" style="display:none">
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_number')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<select name="nominee_number" id="nominee_name_1" onchange="showDiv('div',this.value)" class="form-control select2">
												<option value="">Select Number of Nominee</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
											</select>
										</div>
										<div class="nominee_name_1_error errors"></div>
										</div>
										
									</div>
									
									<div class="box nominee_number_1" id="div1">
										<div class="form-group row" >
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<input type="text" name="nominee_name_1" id="nominee_name_1" class="form-control">
											</div>
											<div class="nominee_name_1_error errors"></div>
											</div>
											
										</div>
										<div class="form-group row">
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<select name="nominee_number" id="nominee_name_1" onchange="showDiv('div',this.value)" class="form-control select2">
													<option value="">Select Relations</option>
													<option value="wife">WIFE</option>
													<option value="husband">HUSBAND</option>
													<option value="daughter">DAUGHTER</option>
													<option value="son">SON</option>
													<option value="mother">MOTHER</option>
													<option value="father">FATHER</option>
													<option value="brother">BROTHER</option>
													<option value="sister">SISTER</option>
												</select>
											</div>
											<div class="nominee_name_1_error errors"></div>
											</div>
											
										</div>
										<hr>
									</div>
									<div class="box nominee_number_2"  id="div2">
										<div class="form-group row">
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<input type="text" name="nominee_name_2" id="nominee_name_2" class="form-control">
											</div>
											<div class="nominee_name_2_error errors"></div>
											</div>
											
										</div>
										<div class="form-group row">
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<select name="nominee_number" id="nominee_name_1" onchange="showDiv('div',this.value)" class="form-control select2">
													<option value="">Select Relations</option>
													<option value="wife">WIFE</option>
													<option value="husband">HUSBAND</option>
													<option value="daughter">DAUGHTER</option>
													<option value="son">SON</option>
													<option value="mother">MOTHER</option>
													<option value="father">FATHER</option>
													<option value="brother">BROTHER</option>
													<option value="sister">SISTER</option>
												</select>
											</div>
											<div class="nominee_name_1_error errors"></div>
											</div>
											
										</div>
										<hr>
									</div>
									<div class="box nominee_number_3"  id="div3">
										<div class="form-group row">
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<input type="text" name="nominee_name_3" id="nominee_name_3" class="form-control">
											</div>
											<div class="nominee_name_3_error errors"></div>
											</div>
											
										</div>
										<div class="form-group row">
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<select name="nominee_number" id="nominee_name_1" onchange="showDiv('div',this.value)" class="form-control select2">
													<option value="">Select Relations</option>
													<option value="wife">WIFE</option>
													<option value="husband">HUSBAND</option>
													<option value="daughter">DAUGHTER</option>
													<option value="son">SON</option>
													<option value="mother">MOTHER</option>
													<option value="father">FATHER</option>
													<option value="brother">BROTHER</option>
													<option value="sister">SISTER</option>
												</select>
											</div>
											<div class="nominee_name_1_error errors"></div>
											</div>
											
										</div>
										<hr>
									</div>
									<div class="box nominee_number_4"  id="div4">
										<div class="form-group row">
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<input type="text" name="nominee_name_4" id="nominee_name_4" class="form-control">
											</div>
											<div class="nominee_name_4_error errors"></div>
											</div>
											
										</div>
										
										<div class="form-group row">
											<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<select name="nominee_number" id="nominee_name_1" onchange="showDiv('div',this.value)" class="form-control select2">
													<option value="">Select Relations</option>
													<option value="wife">WIFE</option>
													<option value="husband">HUSBAND</option>
													<option value="daughter">DAUGHTER</option>
													<option value="son">SON</option>
													<option value="mother">MOTHER</option>
													<option value="father">FATHER</option>
													<option value="brother">BROTHER</option>
													<option value="sister">SISTER</option>
												</select>
											</div>
											<div class="nominee_name_1_error errors"></div>
											</div>
											
										</div>
									</div>									
									
									<div class="form-row mt-4">
										<label class="col-lg-3 col-xl-2 col-form-label"></label>
										<div class="col-lg-9 col-xl-10">
											<button type="button" id="reset" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
											<button type="button" id="nominee_info_cancel" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.cancel')}}</button>
										</div>
									</div>
								</form>
							</div>
							
							<div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
								<div class="" id="site_customer_settings_info">
									<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="document_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
									<div class="clearfix"></div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar Front Image</label>
										@if($document_details && $document_details->aadhaar_front)
											<label class="col-lg-9 col-xl-10 col-form-label" id="aadhaar_front_show" ><img src="{{asset('uploads/documents')}}/{{$document_details->aadhaar_front}}"></label>
										@else
											<label class="col-lg-9 col-xl-10 col-form-label" id="empty_aadhaar_front">No Document Uploaded</label>
										@endif
										<label class="col-lg-9 col-xl-10 col-form-label"  style="display:none" id="empty_aadhaar_front1">No Document Uploaded</label>
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar Back Image</label>
										@if($document_details && $document_details->aadhaar_back)
											<label class="col-lg-9 col-xl-10 col-form-label"  id="aadhaar_back_show"><img src="{{asset('uploads/documents')}}/{{$document_details->aadhaar_back}}"></label>
										@else
											<label class="col-lg-9 col-xl-10 col-form-label" id="empty_aadhaar_back">No Document Uploaded</label>
										@endif
										<label class="col-lg-9 col-xl-10 col-form-label" style="display:none" id="empty_aadhaar_back1">No Document Uploaded</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Pan Card Image</label>
										@if($document_details && $document_details->pan_card)
											<label class="col-lg-9 col-xl-10 col-form-label"  id="pan_card_show"><img src="{{asset('uploads/documents')}}/{{$document_details->pan_card}}"></label>
										@else
											<label class="col-lg-9 col-xl-10 col-form-label"  id="empty_pan_card">No Document Uploaded</label>
										@endif
										<label class="col-lg-9 col-xl-10 col-form-label" style="display:none" id="empty_pan_card1">No Document Uploaded</label>
									</div>
								</div>
							
								<form name="documents_upload" id="site_customer_settings" data-id="{{$user->id}}" style="display:none">
									
									<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="document_info_cancel" href="javascript:void(0)"><i class="simple-icon-close"></i></a></div>
									
									<div class="clearfix"></div>
									
									
									<div class="form-group">
										<label class="col-form-label">Upload Aadhaar Front Image</label>
									
										<div id="image-1-10-1" dropzone_Required = "true" data-type="aadhaar_front" data_id = "126" class="dropzone drop_here_logo"></div>
										<div class="dropzoneError errors"></div>
									</div>
									
									<div class="form-group">
										<label class="col-form-label">Upload Aadhaar Back Image</label>
									
										<div id="image-2-20-2" dropzone_Required = "true"  data-type="aadhaar_back"  data_id = "126"  class="dropzone drop_here_logo"></div>
										<div class="dropzoneError errors"></div>
									</div>
									
									<div class="form-group">
										<label class="col-form-label">Upload Pan Card</label>
									
										<div id="image-3-30-3" dropzone_Required = "false"  data-type="pan_card"  data_id = "126"  class="dropzone drop_here_logo"></div>
										<div class="dropzoneError errors"></div>
									</div>
									
									<!--div class="form-row mt-4">
										<div class="col-lg-12 col-xl-12">
											<button type="button" id="uploadDocuments" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
											
										</div>
									</div--->
									
									
								</form>
							</div>
							<div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
								<div class="" id="bank_info_show">
									<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="bank_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
									<div class="clearfix"></div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Account Number</label>
										<label class="col-lg-9 col-xl-10 col-form-label" id="account_number_show">{{$bank_detais && $bank_detais->account_number?$bank_detais->account_number:'Not Added Yet'}}</label>
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Account Name</label>
										<label class="col-lg-9 col-xl-10 col-form-label" id="account_name_show">{{$bank_detais && $bank_detais->account_name?$bank_detais->account_name:'Not Added Yet'}}</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">IFSC Code</label>
										<label class="col-lg-9 col-xl-10 col-form-label" id="ifsc_code_show">{{$bank_detais && $bank_detais->ifsc_code?$bank_detais->ifsc_code:'Not Added Yet'}}</label>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Branch Name</label>
										<label class="col-lg-9 col-xl-10 col-form-label" id="branch_name_show">{{$bank_detais && $bank_detais->bank_name?$bank_detais->bank_name:'Not Added Yet'}}</label>
									</div>
								</div>
								<form name="bank_info_edit" id="bank_info_edit" data-id="{{$user->id}}" style="display:none">
									{{ csrf_field() }}
										<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="bank_info_cancel" href="javascript:void(0)"><i class="simple-icon-close"></i></a></div>
									<div class="clearfix"></div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.account_number')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="text" name="account_number" id="account_number" value="{{$bank_detais && $bank_detais->account_number?$bank_detais->account_number:''}}" class="form-control">
										</div>
										<div class="account_number_error errors"></div>
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.account_name')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="text" name="account_name" value="{{$bank_detais && $bank_detais->account_name?$bank_detais->account_name:''}}" id="account_name" class="form-control">
										</div>
										<div class="account_name_error errors"></div>
										</div>
										
									</div>								
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.ifsc_code')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="text" name="ifsc_code" value="{{$bank_detais && $bank_detais->ifsc_code?$bank_detais->ifsc_code:''}}" id="ifsc_code" class="form-control">
										</div>
										<div class="ifsc_code_error errors"></div>
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.bank_name')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="text" name="bank_name" value="{{$bank_detais && $bank_detais->bank_name?$bank_detais->bank_name:''}}" id="bank_name" class="form-control">
										</div>
										<div class="bank_name_error errors"></div>
										</div>
										
									</div>
									
									
									<div class="form-row mt-4">
										<label class="col-lg-3 col-xl-2 col-form-label"></label>
										<div class="col-lg-9 col-xl-10">
											<button type="submit" id="submitBankInfo" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
											
										</div>
									</div>
								</form>
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
	function showDiv(prefix,chooser) 
	{
		
		for(var i=1;i<=chooser;i++) 
		{
			var div = document.getElementById(prefix+i);
			div.style.display = 'none';
		}

		var selectedOption = chooser;

		if(selectedOption == "1")
		{
			displayDiv(prefix,"1");
			hideDiv(prefix,"2");
			hideDiv(prefix,"3");
			hideDiv(prefix,"4");
			
		}
		if(selectedOption == "2")
		{
			displayDiv(prefix,"1");
			displayDiv(prefix,"2");
			hideDiv(prefix,"3");
			hideDiv(prefix,"4");
			
		}
		if(selectedOption == "3")
		{
			displayDiv(prefix,"1");
			displayDiv(prefix,"2");
			displayDiv(prefix,"3");
			hideDiv(prefix,"4");
		}
		if(selectedOption == "4")
		{
			displayDiv(prefix,"1");
			displayDiv(prefix,"2");
			displayDiv(prefix,"3");
			displayDiv(prefix,"4");
		}
    }

    function displayDiv(prefix,suffix) 
    {
		var div = document.getElementById(prefix+suffix);
		div.style.display = 'block';
    }
	 function hideDiv(prefix,suffix) 
    {
		var div = document.getElementById(prefix+suffix);
		div.style.display = 'none';
    }
	
	
	
$(document).ready(function(){
	$(".box").hide();
	var  state = $('#state').val();
	if(state != ''){
		getCityDropDown(state);
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
	