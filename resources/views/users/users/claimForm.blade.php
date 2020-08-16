<form method="POST" action="{{ url('create-claim') }}" class="frm_class" id="claim-form" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<h5 class="mb-4 register_title">{{ trans('global.intimation_detail') }}</h5>

		<div id="intimation_part">

			<div class="form-row">
				<div class="col-md-6">
					<label class="has-float-label form-group mb-3">
						<input name="policy_number" id="policy_number" type="text" value="{{ old('policy_number')}}" class="form-control">
						<span>{{ trans('global.policy_number') }}</span>
						<div class="error_margin">
							<span class="error policy_number_error">  {{ $errors->first('policy_number')  }} </span>
						</div>
					</label>
				</div>

				<div class="col-md-1">
					<label class="has-float-label form-group mb-3">
						<span>Or</span>
					</label>
				</div>
				
				<div class="col-md-5">
					<label class="has-float-label form-group mb-3">
						<input data-type="adhaar-number" maxLength="14" minLength="14" name="initimation_aadhar_number" id="initimation_aadhar_number" type="text" value="{{ old('initimation_aadhar_number')}}" class="form-control">
						<span>{{ trans('global.aadhar_number') }}</span>
						<div class="error_margin"><span class="error initimation_aadhar_number_error">  {{ $errors->first('initimation_aadhar_number')  }} </span></div>
					</label>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<label class="has-float-label form-group mb-3">
						<input name="initimation_mobile_number" id="initimation_mobile_number" type="text" value="{{ old('initimation_mobile_number')}}" onkeypress="return onlyNumberKey(event)" maxLength="10" class="form-control">
						<span>{{ trans('global.mobile_number') }}<span style="color:red;">*</span></span>
						<div class="error_margin">
							<span class="error initimation_mobile_number_error">  {{ $errors->first('initimation_mobile_number')  }} </span>
						</div>
					</label>
				</div>
			</div>

		</div>

		
	<h5 class="mb-4 register_title">{{ trans('global.nominee_person_info') }}</h5>
	
	<div id="first_part">
		<div class="form-row">
			<div class="col-md-6">
				<label class="has-float-label form-group mb-3 ">
					<input name="name" id="name"  type="text" value="{{ old('name')}}" class="form-control">
					<span>{{ trans('global.name') }}<span style="color:red;">*</span></span>
					<div class="error_margin"><span class="error name_error" >  {{ $errors->first('name')  }} </span></div>
				</label>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-6">
				<label class="has-float-label form-group mb-3">
					<input name="mobile_number" id="mobile_number" onkeypress="return onlyNumberKey(event)" maxLength="10" type="text" value="{{ old('mobile_number')}}" class="form-control">
					<span>Mobile <span style="color:red;">*</span></span>
					<div class="error_margin"><span class="error mobile_number_error" >  {{ $errors->first('mobile_number')  }} </span></div>
				</label>
			</div>
			<div class="col-md-6">
				<label class="has-float-label form-group mb-3">
					<input data-type="adhaar-number" name="aadhar_number" maxLength="14" minLength="14"  id="aadhar_number" type="text" value="{{ old('aadhar_number')}}" class="form-control">
					<span>Aadhaar<span style="color:red;">*</span></span>
					<div class="error_margin"><span class="error aadhar_number_error" >  {{ $errors->first('aadhar_number')  }} </span></div>
				</label>
			</div>
		</div>

		<div class="form-group">
			<label class="col-form-label">Upload Aadhaar</label>
		
			<div id="image-1-10-1" dropzone_Required = "true" class="dropzone drop_here_logo"></div>
			<div class="dropzoneError errors"></div>

			<input type="hidden" name="document" value="" id="document">
			<div class="error_margin"><span class="error document_error" >  {{ $errors->first('document')  }} </span></div>
		</div>
	
		
		 <div class="d-flex justify-content-between align-items-center">
			<input type="submit" class="btn btn-primary btn-lg btn-shadow uppercase_button" id="claimSubmit" value="{{ trans('global.submit') }}">
			<div class="spinner-border text-primary claim_spinloder" style="display:none"></div>
		</div>
	</div>
	
</form>