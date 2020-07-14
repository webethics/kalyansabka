@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Certificate</h1>
			<div class="separator mb-5"></div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			<div class="card">
				<div class="card-body">
				
					 <embed src="{{asset('Files/FullPlan.pdf')}}" width="100%" height="1000px" />
					 <div class="form-group text-center">
						<a href="javascript:void(0)" class="btn btn-lg btn-primary mt-4">Download Certificate</a>
					</div>	
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade modal-right userEditModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-top confirmBoxCompleteModal"  tabindex="-1" role="dialog"  aria-hidden="true"></div>
@section('userJs')
<script src="{{ asset('js/module/user.js')}}"></script>	
@stop
@endsection