<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="{{ url('update-company/') }}/{{ $complaint->id }}" method="POST" id="updateComplaint" >
	 @csrf
		
	
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Ticket ID<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="ticketId" class="form-control" placeholder="Ticket ID" readonly="readonly" value="{{strtoupper($complaint->ticket_id)}}">									
			</div>	
			<div class="subject_error errors"></div>	
		</div>
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Subject<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="subject" class="form-control" placeholder="Subject" value="{{$complaint->subject}}">									
			</div>	
			<div class="subject_error errors"></div>	
		</div>
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Message<em>*</em></label>
			<div class="d-flex control-group">
				<textarea type="text" name="message" value="" class="form-control" placeholder="Message">{{$complaint->message}}</textarea>								
			</div>	
			<div class="message_error errors"></div>	
		</div>
		
		<div class="form-group form-row-parent">
			<label class="col-form-label"><b>Status : 
				
				@if ($complaint->status == "0") {{ 'New' }} @endif
				@if ($complaint->status == "1") {{ 'In Progress' }} @endif
				@if ($complaint->status == "2") {{ 'Completed' }} @endif
												
			</b></label>
			
		</div>
		@if(isset($getreplies) && !empty($getreplies))
			<a href="javascript:void(0)" id="view" class="chat_links">View Replies</a>
		@endif
		@if($complaint->status != 2)
			<a  class="chat_links" href="javascript:void(0)" id="post">Post A Reply</a>
		@endif
		
		
		<br/>
		<br/>
		
		@if(isset($getreplies) && !empty($getreplies))
		<div class="form-group form-row-parent" id="replies" style="display:none">
			<h5  class="withdrawal">All Replies</h5>
			@foreach($getreplies as $reply)
				 <b>{{$reply->user->first_name}} :</b>
				<div class="d-flex control-group">
					{{$reply->reply}}
					<hr>
				</div>	
			@endforeach
			<div class="message_error errors"></div>	
		</div>
		
		@endif
		
		<div class="form-group form-row-parent"  id="post_a_reply"  style="display:none">
			<h5  class="withdrawal">Post A Reply</h5>
			<div class="d-flex control-group">
				<textarea type="text" name="reply" value="" class="form-control" placeholder="Post a Reply">{{$complaint->reply}}</textarea>								
			</div>	
			<div class="reply_error errors"></div>	
		</div>
		
		
		
		<div class="form-row mt-4">
		<div class="col-md-12">
		<input id ="user_id" class="form-check-input" type="hidden" value="{{$complaint->id}}">
		<button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">{{ trans('global.submit') }}</button>
		<div class="spinner-border text-primary request_loader" style="display:none"></div>
		</div>
		</div>
		
		</form>

				</div>
			</div>
		</div>