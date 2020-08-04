@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Upgrade Certificate</h1>
			<div class="separator mb-5"></div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			<div class="card">
				<div class="card-body">
					<embed id="iframe" src="{{asset('Files/FullPlan.pdf')}}#toolbar=0" width="100%" height="1000px" />
				</div>
			</div>

		</div>
	</div>
@endsection