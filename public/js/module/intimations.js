
/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editClaimRequest' , function() {
	var claim_id = $(this).data('claim_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/claim-request/edit/'+claim_id,
        data: {_token:csrf_token,claim_id:claim_id},
        success: function(data) {
			if(data.success){
				
				
				$('.claimRequestEditModal').html(data.data);
				$('.claimRequestEditModal').modal('show');
				
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
/*Approve request*/
$(document).on('click','#updateClaimRequest .request_approve',function(e){
	event.preventDefault();
	$this = $(this);
	if(!$('#updateClaimRequest .reason-area').hasClass("d-none")){
		$('#updateClaimRequest .reason-area').addClass("d-none");
		$('#updateClaimRequest .reason-area .reason_description').val("");
	}
	var ajax_url = $this.parents('#updateClaimRequest').attr('action');
	var method = $this.parents('#updateClaimRequest').attr('method');
	var status = 'approve';
	edit_request_update(ajax_url,method,status);
});


/*Disapprove request*/
$(document).on('click','#updateClaimRequest .request_disapprove',function(e){
	event.preventDefault();
	$this = $(this);
	/*check reason textarea visible or not, if no then first visible it, So that admin add reason for disapprove*/
	if($('#updateClaimRequest .reason-area').hasClass("d-none")){
		$('#updateClaimRequest .reason-area').removeClass("d-none")
	}else{
		var ajax_url = $this.parents('#updateClaimRequest').attr('action');
		var method = $this.parents('#updateClaimRequest').attr('method');
		var status = 'disapprove';
		//check reason available or not
		var reason = $.trim($("#updateClaimRequest .reason_description").val());
		if(reason != ""){
			edit_request_update(ajax_url,method,status);
		}else{
			$("#updateClaimRequest .description_error").html('Please mention reason for '+status);
		}
	}
});


/*Send Edit request to user*/
function edit_request_update(ajax_action,method,status){
	$("#updateClaimRequest .description_error").html();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	/*show loader*/
	$('#updateClaimRequest').find('.request_loader').show();
	var formData = $('#updateClaimRequest').serializeArray();

	formData.push({ name: "status", value: status });
	formData.push({ name: "_token", value: csrf_token });

	$.ajax({
        type: method,
        url: ajax_action,
        data:formData,
        success: function(data) {
        	$('#updateClaimRequest').find('.request_loader').hide();
        	if(data=='date_error'){
				notification('Error','Start date not greater than end date.','top-right','error',4000);	
			}else if(data=='error'){
				notification('Error','Something went wrong, please try later.','top-right','error',4000);
			}else{
             // Set search result
			// $("#tag_container").empty().html(data); 
				notification('Success','Successfully Update Cancellation Request.','top-right','success',4000);
				setTimeout(function(){ $('.claimRequestEditModal').modal('hide'); }, 500);
				setTimeout(function(){ window.location.href = base_url+'/claim-intimations'; }, 1000);
			}
			/*if(response.success){
				$("#tag_container").empty().html(data); 
				setTimeout(function(){ $('.viewDetailModal').modal('hide'); }, 500);
			}else{
				if(typeof (response.message) != 'undefined' && response.message != null && response.message != "")
					notification('Error',response.message,'top-right','error',3000);
				else
				notification('Error','Something went wrong.','top-right','error',3000);
			}*/	
        },
        error:function(response){
	       	$('#updateClaimRequest').find('.request_loader').hide();
	       	console.log('error');
	    }
    });
	

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