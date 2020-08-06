
/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editPayment' , function() {
	var payment_id = $(this).data('payment_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/payment/edit/'+payment_id,
        data: {_token:csrf_token,payment_id:payment_id},
        success: function(data) {
			if(data.success){
				$('.paymentEditModal').html(data.data);
				$('.paymentEditModal').modal('show');
				var selectedVal = $('#selectedVal').val();
				if(selectedVal){
					$("#selected_code option[value="+selectedVal+"]").attr("selected","selected");
				}
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
	
$(document).on('click', '.delete_customer' , function() {
	var user_id = $(this).data('id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/user/delete_customer/'+user_id,
        data: {_token:csrf_token,user_id:user_id},
        success: function(data) {
			if(data.success){
				notification('Success','Customer deleted Successfully','top-right','success',2000);
				$('.user_row_'+user_id).hide();
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})

/*==============================================
	UPDATE REQUEST FORM 
============================================*/
$(document).on('submit','#updateUser', function(e) {
    e.preventDefault(); 
	var user_id = $('#user_id').val();
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/update-profile/'+user_id,
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','User Updated Successfully','top-right','success',2000);
				$('#business_name_'+user_id).text(data.business_name);
				$('#name_'+user_id).text(data.name);
				$('#mobile_number_'+user_id).text(data.mobile_number);
				$('#business_url_'+user_id).text(data.business_url);
				setTimeout(function(){ $('.userEditModal').modal('hide'); }, 2000);
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


$(document).on('click', '.update_bank' , function() {
	window.location = base_url+'/account';
})

$(document).on('click', '.withdrawl_user' , function() {
	var user_id = $(this).data('id');
	var amount = $('#amount').val();
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/payments/withdrawl_request/'+user_id,
        data: {_token:csrf_token,user_id:user_id,amount:amount},
        success: function(data) {
			if(data.success){
				notification('Success','Your withdrawl request has been submitted successfully.','top-right','success',2000);
				setTimeout(function(){window.location.href = base_url+'/customer-payments'; }, 2500);
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})


$(document).on('click','#openPaymentModel', function(e) {
    e.preventDefault(); 
	var amount_requested = $(this).data('amount_requested');
	if(amount_requested > 1000){
		var id = $(this).data('id');
		var confirm_message = $(this).data('confirm_message');
		var confirm_message_1 = $(this).data('confirm_message_1');
		var confirm_message_2 = $(this).data('confirm_message_2');
		var confirm_message_3 = $(this).data('confirm_message_3');
		var leftButtonId = $(this).data('left_button_id');
		var leftButtonId_1 = $(this).data('left_button_id_1');
		var leftButtonName = $(this).data('left_button_name');
		var leftButtonName_1 = $(this).data('left_button_name_1');
		var leftButtonCls = $(this).data('left_button_cls');
		var amount_requested = $(this).data('amount_requested');

		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: "POST",
			url: base_url+'/confirmPaymentModal',
			data:{id:id,confirm_message:confirm_message,confirm_message_1:confirm_message_1,confirm_message_2:confirm_message_2,confirm_message_3:confirm_message_3,leftButtonId:leftButtonId,leftButtonName:leftButtonName,leftButtonId_1:leftButtonId_1,leftButtonName_1:leftButtonName_1,leftButtonCls:leftButtonCls,amount_requested:amount_requested,_token:csrf_token},
			success: function(data) {
				 $('.confirmBoxCompleteModal').html(data)
				 $('.confirmBoxCompleteModal').modal('show')
			}
		}); 
	}else{
		notification('Error','Minimum INR 1000 can be withdrawn','top-right','error',3000);
	}	
});



/*==============================================
	UPDATE REQUEST FORM 
============================================*/
$(document).on('submit','#updateRequest', function(e) {
    e.preventDefault(); 
	var request_id = $('#request_id').val();
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/update-withdrawl-request/'+request_id,
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','Request Updated Successfully','top-right','success',2000);
				setTimeout(function(){ $('.paymentEditModal').modal('hide'); }, 2000);
				setTimeout(function(){window.location.href = base_url+'/withdrawls'; }, 2500);
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


$(document).on('submit','#searchWithdrawlForm', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/withdrawls',
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

$(document).on('submit','#searchPaymentForm', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/payments',
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


$(document).on('submit','#searchCustomerPaymentForm', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/customer-payments',
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


$(document).on('click','#export_withdrawl_data', function(e) {
	 e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/export_withdrawls',
        data: {first_name:$('#first_name').val(),
				last_name:$('#last_name').val(),
				email:$('#email').val(),
				
				mobile_number:$('#mobile_number').val(),
				aadhar_number:$('#aadhar_number').val(),
				start_date:$('#start_date').val(),
				end_date:$('#end_date').val(),
				age_from:$('#age_from').val(),
				age_to:$('#age_to').val(),
				status:$('#status').val(),
				_token:csrf_token},
        success: function(data) {
			
			$('.search_spinloder').css('display','none');
			if(data.success == false){
				notification('Error','No data found.','top-right','error',4000);	
			}else{
				var downloadLink = document.createElement("a");
				var fileData = ['\ufeff'+data];

				var blobObject = new Blob(fileData,{
					type: "text/csv;charset=utf-8;"
				});

				var url = URL.createObjectURL(blobObject);
				downloadLink.href = url;
				downloadLink.download = "withdrawal_requests.csv";

				/*
					* Actually download CSV
				*/
				document.body.appendChild(downloadLink);
				downloadLink.click();
				document.body.removeChild(downloadLink);
			}
			
        },
		error :function( data ) {}
    });
});

$(document).on('click','#export_customer_payments', function(e) {
	 e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/export_customer_payments',
        data: {
				
				start_date:$('#start_date').val(),
				end_date:$('#end_date').val(),
				payment_type:$('#payment_type').val(),
				status:$('#status').val(),
				_token:csrf_token},
        success: function(data) {
			
			$('.search_spinloder').css('display','none');
			if(data.success == false){
				notification('Error','No data found.','top-right','error',4000);	
			}else{
				var downloadLink = document.createElement("a");
				var fileData = ['\ufeff'+data];

				var blobObject = new Blob(fileData,{
					type: "text/csv;charset=utf-8;"
				});

				var url = URL.createObjectURL(blobObject);
				downloadLink.href = url;
				downloadLink.download = "customer_payments.csv";

				/*
					* Actually download CSV
				*/
				document.body.appendChild(downloadLink);
				downloadLink.click();
				document.body.removeChild(downloadLink);
			}
			
        },
		error :function( data ) {}
    });
});


$(document).on('click','#export_payment_data', function(e) {
	 e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/export_payments',
        data: {first_name:$('#first_name').val(),
				last_name:$('#last_name').val(),
				email:$('#email').val(),
				
				mobile_number:$('#mobile_number').val(),
				aadhar_number:$('#aadhar_number').val(),
				start_date:$('#start_date').val(),
				end_date:$('#end_date').val(),
				age_from:$('#age_from').val(),
				age_to:$('#age_to').val(),
				_token:csrf_token},
        success: function(data) {
			
			$('.search_spinloder').css('display','none');
			if(data.success == false){
				notification('Error','No data found.','top-right','error',4000);	
			}else{
				var downloadLink = document.createElement("a");
				var fileData = ['\ufeff'+data];

				var blobObject = new Blob(fileData,{
					type: "text/csv;charset=utf-8;"
				});

				var url = URL.createObjectURL(blobObject);
				downloadLink.href = url;
				downloadLink.download = "Payment_requests.csv";

				/*
					* Actually download CSV
				*/
				document.body.appendChild(downloadLink);
				downloadLink.click();
				document.body.removeChild(downloadLink);
			}
			
        },
		error :function( data ) {}
    });
});

