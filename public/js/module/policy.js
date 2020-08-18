
/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editPolicyRequest' , function() {
	var payment_id = $(this).data('payment_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/cancel-policy-request/edit/'+payment_id,
        data: {_token:csrf_token,payment_id:payment_id},
        success: function(data) {
			if(data.success){
				
				
				$('.policyRequestEditModal').html(data.data);
				$('.policyRequestEditModal').modal('show');
				
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
/*Approve request*/
$(document).on('click','#updatePolicyRequest .request_approve',function(e){
	event.preventDefault();
	$this = $(this);
	if(!$('#updatePolicyRequest .reason-area').hasClass("d-none")){
		$('#updatePolicyRequest .reason-area').addClass("d-none");
		$('#updatePolicyRequest .reason-area .reason_description').val("");
	}
	var ajax_url = $this.parents('#updatePolicyRequest').attr('action');
	var method = $this.parents('#updatePolicyRequest').attr('method');
	var status = 'approve';
	edit_request_update(ajax_url,method,status);
});


/*Disapprove request*/
$(document).on('click','#updatePolicyRequest .request_disapprove',function(e){
	event.preventDefault();
	$this = $(this);
	/*check reason textarea visible or not, if no then first visible it, So that admin add reason for disapprove*/
	if($('#updatePolicyRequest .reason-area').hasClass("d-none")){
		$('#updatePolicyRequest .reason-area').removeClass("d-none")
	}else{
		var ajax_url = $this.parents('#updatePolicyRequest').attr('action');
		var method = $this.parents('#updatePolicyRequest').attr('method');
		var status = 'disapprove';
		//check reason available or not
		var reason = $.trim($("#updatePolicyRequest .reason_description").val());
		if(reason != ""){
			edit_request_update(ajax_url,method,status);
		}else{
			$("#updatePolicyRequest .description_error").html('Please mention reason for '+status);
		}
	}
});


/*Send Edit request to user*/
function edit_request_update(ajax_action,method,status){
	$("#updatePolicyRequest .description_error").html('');
	//var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var formData = $('#updatePolicyRequest').serializeArray();
	var $policy_id = $('#updatePolicyRequest').find('#policy_id').val();

	if($policy_id != ''){

		var parentRow = $("#tag_container table").find('tr.user_row_'+$policy_id);
		var page_number = parentRow.find('td#sno_'+$policy_id).find('#page_number_'+$policy_id).val();
		var s_number = parentRow.find('td#sno_'+$policy_id).find('#s_number_'+$policy_id).val();

		formData.push({ name: "status", value: status });
		formData.push({ name: "page_number", value: page_number });
		formData.push({ name: "sno", value: s_number });
		//formData.push({ name: "_token", value: csrf_token });
		/*show loader*/
	$('#updatePolicyRequest').find('.request_loader').show();

		$.ajax({
	        type: method,
	        url: ajax_action,
	        data:formData,
	        success: function(data) {
	        	$('#updatePolicyRequest').find('.request_loader').hide();
	        	if(data=='date_error'){
					notification('Error','Start date not greater than end date.','top-right','error',4000);	
				}else if(data=='error'){
					notification('Error','Something went wrong, please try later.','top-right','error',4000);
				}else if(data.success){
	            	if(typeof (data.view) != 'undefined' && data.view != null && typeof (data.class) != 'undefined'  && data.class != null && data.view != '' && data.class != ''){ 
						notification('Success','Successfully Update Cancellation Request.','top-right','success',4000);
						setTimeout(function(){ 
							$('.policyRequestEditModal').modal('hide');
							$('.'+data.class).replaceWith(data.view);
						}, 500);
					}
				}else{
					if(typeof (data.message) != 'undefined' && data.message != null && data.message != "")
						notification('Error',data.message,'top-right','error',3000);
					else
					notification('Error','Something went wrong.','top-right','error',3000);
				}
	        },
	        error:function(response){
		       	$('#updatePolicyRequest').find('.request_loader').hide();
		       	console.log('error');
		       	notification('Error','Something went wrong.','top-right','error',3000);
		    }
	    });
	}else{
		notification('Error','Something went wrong.','top-right','error',3000);
	}
}



/*==============================================
	SEARCH FILTER FORM 
============================================*/
$(document).on('submit','#searchForm', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/policies-requests',
        data: $(this).serialize(),
        success: function(data) {
			 $('.search_spinloder').css('display','none');
             //start date and end date error 
			if(data=='date_error'){
				notification('Error','Start date not greater than end date.','top-right','error',4000);	
			}else if(data=='age_error'){
				notification('Error','Start age not greater than end age.','top-right','error',4000);	
			}else{
             // Set search result
			 $("#tag_container").empty().html(data); 
			}	
        },
		error :function( data ) {}
    });
});