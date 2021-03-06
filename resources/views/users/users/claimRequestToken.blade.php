<div class="col-12 col-md-8 col-lg-10 mx-auto my-auto">
    <div class="card auth-card">
        <div class="form-side">
            <span class="logo_image d-block mb-3"><a href="{{url('/')}}"><img src="{{asset('img/Kalyansabka.svg')}}"></a></span>
                               
            @if(isset($claimData) && $claimData['claim_request_id'] != "")

              <div class="form-group row text-center">
                <label class="col-lg-12 col-xl-12 col-form-label">
                  Your claim request is successfully sent to admin, it will take around 48-72 hours to respond you.
                </label>
              </div>
              <div class="form-group row text-center">
                <label class="col-lg-12 col-xl-12 col-form-label">Following is your claim Track id:</label>
              </div>

              <div class="form-group row text-center">
                <label class="col-lg-12 col-xl-12 col-form-label"><h2>{{$claimData['claim_request_id']}}</h2></label>
                <label class="d-flex justify-content-center col-lg-12 col-xl-12">
                  <button onclick="window.print()" type="button" class="btn btn-primary default btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">Print</button>
                </label>
              </div>
            @endif
        </div>
      </div>
 </div>