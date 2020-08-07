<div class="" id="nomminee_pass_info">
	<div class="col-xl-1 fl_right"><a class="fl_right edit_link action" title="Edit" id="nominee_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
	<div class="clearfix"></div>
	
	<div id="showNomineeDetails" style="display:none">
		<div class="form-group row" id="show_1" style="display:none">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_1"></label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_1"></label>
			<hr>
		</div>
		
		<div class="form-group row"id="show_2" style="display:none">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_2"></label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_2"></label>
			<hr>
		</div>
		
		<div class="form-group row" id="show_3" style="display:none">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_3"></label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_3"></label>
			<hr>
		</div>
		
		<div class="form-group row" id="show_4" style="display:none">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_4"></label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_4"></label>
			<hr>
		</div>
		
	</div>
	<div id="showOnLoadOnly">
		@if(isset($nominee_details[0]) && $nominee_details[0]['name'] != "")
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_11">{{$nominee_details[0]['name']??'Not Added yet'}}</label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_11">{{$nominee_details[0]['relation']??'Not Added yet'}}</label>
			
		</div>
		<hr>
		@endif
		@if(isset($nominee_details[1]) && $nominee_details[1]['name'] != "")
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_21">{{$nominee_details[1]['name']??'Not Added yet'}}</label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_21">{{$nominee_details[1]['relation']??'Not Added yet'}}</label>
		</div>
		<hr>
		@endif
		@if(isset($nominee_details[2]) && $nominee_details[2]['name'] != "")
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_31">{{$nominee_details[2]['name']??'Not Added yet'}}</label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_31">{{$nominee_details[2]['relation']??'Not Added yet'}}</label>
		</div>
		<hr>
		@endif
		@if(isset($nominee_details[3]) && $nominee_details[3]['name'] != "")
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_name_41">{{$nominee_details[3]['name']??'Not Added yet'}}</label>
			
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<label class="col-lg-9 col-xl-10 col-form-label" id="nom_relation_41">{{$nominee_details[3]['relation']??'Not Added yet'}}</label>
		</div>
		<hr>
		@endif
		@if(!$nominee_details)
			<div class="form-group row">
				Nominees are not added yet. Add them Now!
			</div>
		@endif
	</div>
</div>	

<form name="nomminee_pass" id="nomminee_pass" data-id="{{$user->id}}" style="display:none">
	<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="nominee_info_cancel" href="javascript:void(0)"><i class="simple-icon-close"></i></a></div>
	
	<div class="clearfix"></div>
	{{ csrf_field() }}
	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_number')}}</label>
		<div class="col-lg-9 col-xl-10">
		<div class="d-flex control-group">
			<select name="nominee_number" id="nominee_number" onchange="showDiv('div',this.value)" class="form-control select2">
				<option value="">Select Number of Nominee</option>
				<option value="1" @if (old('nominee_number') == "1" || $user->nominee_number == 1)  {{ 'selected' }} @endif>1</option>
				<option value="2" @if (old('nominee_number') == "2" || $user->nominee_number == 2) {{ 'selected' }} @endif>2</option>
				<option value="3" @if (old('nominee_number') == "3" || $user->nominee_number == 3) {{ 'selected' }} @endif>3</option>
				<option value="4" @if (old('nominee_number') == "4" || $user->nominee_number == 4) {{ 'selected' }} @endif>4</option>
			</select>
		</div>
		<div class="nominee_number_error errors"></div>
		</div>
		
	</div>
	
	<div class="box nominee_number_1" id="div1">
		<div class="form-group row" >
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<input type="text" name="nominee_name_1" id="nominee_name_1" class="form-control" value="{{old('nominee_name_1')??$nominee_details[0]['name']??''}}">
			</div>
			<div class="nominee_name_1_error errors"></div>
			</div>
			
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<select name="nominee_relation_1" id="nominee_relation_1" class="form-control select2">
					<option value="">Select Relations</option>
					@foreach(relationsArray() as $key=>$value)
						<option value="{{$key}}" @if (old('nominee_relation_1') == "$key" || (isset($nominee_details[0]) && $nominee_details[0]['relation'] == "$key")) {{ 'selected' }} @endif>{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="nominee_relation_1_error errors"></div>
			</div>
			
		</div>
		<hr>
	</div>
	<div class="box nominee_number_2"  id="div2">
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<input type="text" name="nominee_name_2" id="nominee_name_2" class="form-control" value="{{old('nominee_name_2')??$nominee_details[1]['name']??''}}">
			</div>
			<div class="nominee_name_2_error errors"></div>
			</div>
			
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<select name="nominee_relation_2" id="nominee_relation_2" class="form-control select2">
					<option value="">Select Relations</option>
					@foreach(relationsArray() as $key=>$value)
						<option value="{{$key}}" @if (old('nominee_relation_2') == "$key" || (isset($nominee_details[1]) && $nominee_details[1]['relation'] == "$key")) {{ 'selected' }} @endif>{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="nominee_relation_2_error errors"></div>
			</div>
			
		</div>
		<hr>
	</div>
	<div class="box nominee_number_3"  id="div3">
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<input type="text" name="nominee_name_3" id="nominee_name_3" class="form-control" value="{{old('nominee_name_3')??$nominee_details[2]['name']??''}}">
			</div>
			<div class="nominee_name_3_error errors"></div>
			</div>
			
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<select name="nominee_relation_3" id="nominee_relation_3"  class="form-control select2">
					<option value="">Select Relations</option>
					@foreach(relationsArray() as $key=>$value)
						<option value="{{$key}}" @if (old('nominee_relation_3') == "$key" || (isset($nominee_details[2]) && $nominee_details[2]['relation'] == "$key")) {{ 'selected' }} @endif>{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="nominee_relation_3_error errors"></div>
			</div>
			
		</div>
		<hr>
	</div>
	<div class="box nominee_number_4"  id="div4">
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_name')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<input type="text" name="nominee_name_4" id="nominee_name_4" class="form-control" value="{{old('nominee_name_4')??$nominee_details[3]['name']??''}}">
			</div>
			<div class="nominee_name_4_error errors"></div>
			</div>
			
		</div>
		
		<div class="form-group row">
			<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.nominee_relation')}}</label>
			<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
				<select name="nominee_relation_4" id="nominee_relation_4" class="form-control select2">
					<option value="">Select Relations</option>
					@foreach(relationsArray() as $key=>$value)
						<option value="{{$key}}" @if (old('nominee_relation_4') == "$key" || (isset($nominee_details[3]) && $nominee_details[3]['relation'] == "$key")) {{ 'selected' }} @endif>{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="nominee_relation_4_error errors"></div>
			</div>
			
		</div>
	</div>									
	
	<div class="form-row mt-4">
		<label class="col-lg-3 col-xl-2 col-form-label"></label>
		<div class="col-lg-9 col-xl-10">
			<button type="submit" id="reset" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
			
		</div>
	</div>
</form>