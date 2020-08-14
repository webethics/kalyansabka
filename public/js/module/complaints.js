

/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editComplaint' , function() {
	
	var complaint_id = $(this).data('complaint_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/complaint/edit/'+complaint_id,
        data: {_token:csrf_token,complaint_id:complaint_id},
        success: function(data) {
			if(data.success){
			
				$('.complaintEditModal').html(data.data);
				$('.complaintEditModal').modal('show');
				$('.errors').html('');
			}else{
				
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
	
$(document).on('click', '.changeComplaint' , function() {
	
	var complaint_id = $(this).data('complaint_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/list-complaint/edit/'+complaint_id,
        data: {_token:csrf_token,complaint_id:complaint_id},
        success: function(data) {
			if(data.success){
			
				$('.listComplaintEditModal').html(data.data);
				$('.listComplaintEditModal').modal('show');
				$('.errors').html('');
			}else{
				
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
	

	
$(document).on('click', '.delete_complaint' , function() {
	var complaint_id = $(this).data('id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/complaints/delete_complaint/'+complaint_id,
        data: {_token:csrf_token,complaint_id:complaint_id},
        success: function(data) {
			if(data.success){
				notification('Success','Company deleted Successfully','top-right','success',2000);
				$('.user_row_'+complaint_id).hide();
			}else if(data.message){
				notification('Error',data.message,'top-right','error',4000);
			}else{	
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})

/*==============================================
	UPDATE REQUEST FORM 
============================================*/
$(document).on('submit','#updateComplaint', function(e) {
    e.preventDefault(); 
	var user_id = $('#user_id').val();
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/update-complaint/'+user_id,
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','Complaint Updated Successfully','top-right','success',2000);
				$('#subject_'+user_id).text(data.subject);
				setTimeout(function(){ $('.complaintEditModal').modal('hide'); }, 2000);
				$('input[name="reply"]').val('');
			}else{
				$('.mark_as_head_error').show().append(data.message);
				//notification('Error',data.message,'top-right','error',3000);
			}	 
        },
		error :function( data ) {
         if( data.status === 422 ) {
			$('.request_loader').css('display','none');
			$('.errors').html('');
			//notification('Error','Please fill all the fields.','top-right','error',4000);
            var errors = $.parseJSON(data.responseText);
            $.each(errors, function (key, value) {
                // console.log(key+ " " +value);
                if($.isPlainObject(value)) {
                    $.each(value, function (key, value) {                       
                        //console.log(key+ " " +value);	
					  var key = key.replace('.','_');
					  $('.'+key+'_error').show().append(value);
                    });
                }else{
                // $('#response').show().append(value+"<br/>"); //this is my div with messages
                }
            }); 
          }
		}

    });
});


/*==============================================
	UPDATE REQUEST FORM 
============================================*/
$(document).on('submit','#updateAdminComplaint', function(e) {
    e.preventDefault(); 
	var complaint_id = $('#complaint_id').val();
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/update-complaint-admin/'+complaint_id,
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','Complaint Updated Successfully','top-right','success',2000);
				$('#subject_'+complaint_id).text(data.subject);
				$('#status_'+complaint_id).text(data.status);
				setTimeout(function(){ $('.listComplaintEditModal').modal('hide'); }, 2000);
				$('input[name="reply"]').val('');
			}else{
				$('.mark_as_head_error').show().append(data.message);
				//notification('Error',data.message,'top-right','error',3000);
			}	 
        },
		error :function( data ) {
         if( data.status === 422 ) {
			$('.request_loader').css('display','none');
			$('.errors').html('');
			//notification('Error','Please fill all the fields.','top-right','error',4000);
            var errors = $.parseJSON(data.responseText);
            $.each(errors, function (key, value) {
                // console.log(key+ " " +value);
                if($.isPlainObject(value)) {
                    $.each(value, function (key, value) {                       
                        //console.log(key+ " " +value);	
					  var key = key.replace('.','_');
					  $('.'+key+'_error').show().append(value);
                    });
                }else{
                // $('#response').show().append(value+"<br/>"); //this is my div with messages
                }
            }); 
          }
		}

    });
});

/*==============================================
	UPDATE REQUEST FORM 
============================================*/
$(document).on('submit','#createNewComplaint', function(e) {
	e.preventDefault(); 
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/create-new-complaint',
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','Complaint submitted Successfully','top-right','success',2000);
				setTimeout(function(){ $('.complaintCreateModal').modal('hide'); }, 2000);
				setTimeout(function(){window.location.href = base_url+'/complaints'; }, 2500);
			}	 
        },
		error :function( data ) {
         if( data.status === 422 ) {
			$('.request_loader').css('display','none');
			$('.errors').html('');
			//notification('Error','Please fill all the fields.','top-right','error',4000);
            var errors = $.parseJSON(data.responseText);
            $.each(errors, function (key, value) {
                // console.log(key+ " " +value);
                if($.isPlainObject(value)) {
                    $.each(value, function (key, value) {                       
                        //console.log(key+ " " +value);	
					  var key = key.replace('.','_');
					  $('.'+key+'_error').show().append(value);
                    });
                }else{
                // $('#response').show().append(value+"<br/>"); //this is my div with messages
                }
            }); 
          }
		}

    });
});
	
/*==============================================
	SHOW Create Customer FORM 
============================================*/
$(document).on('click', '#create_complaint' , function() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "GET",
		dataType: 'json',
        url: base_url+'/complaint/create/',
        data: {},
        success: function(data) {
			if(data.success){
			
				$('.complaintCreateModal').html(data.data);
				$('.complaintCreateModal').modal('show');
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
});

/*==============================================
	SEARCH FILTER FORM 
============================================*/
$(document).on('submit','#searchForm', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/list-complaints',
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

$(document).on('click','#view', function(e) {
	$('#post_a_reply').hide('slow');
	$('#replies').show('slow');
	
});

$(document).on('click','#post', function(e) {
	$('#post_a_reply').show('slow');
	$('#replies').hide('slow');
	
});