@extends('layouts.admin')
@section('additionalCss')
<style>
	#iframe #outerContainer #mainContainer div.toolbar {
	  display: none !important; /* hide PDF viewer toolbar */
	}
	#iframe #outerContainer #mainContainer #viewerContainer {
	  top: 0 !important; /* move doc up into empty bar space */
	}
</style>
@stop
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