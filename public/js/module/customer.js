
/*==============================================
	ENABLE/DISABLE USER ACCOUNT 
============================================*/
$(document).on('click','input[type="checkbox"]', function(e) {
	
	if($(this).is(":checked")){
		var user_status = 1;
	}
	else if($(this).is(":not(:checked)")){
		var user_status = 0;
	}
	var user_id = $(this).attr('data-user_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/user/enable-disable',
        data: {status:user_status,user_id:user_id,_token:csrf_token},
        success: function(data) {
             // IF TRUE THEN SHOW SUCCESS MESSAGE  
			 if(data.success){
				notification('Success','Account has been enabled.','top-right','success',4000);
				
			}else{
             notification('Error','Account has been disabled.','top-right','error',4000);
			}	
			
        },
		error :function( data ) {}
    });
	
})

	
/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editCustomer' , function() {
	
	var user_id = $(this).data('user_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/customer/edit/'+user_id,
        data: {_token:csrf_token,user_id:user_id},
        success: function(data) {
			if(data.success){
			
				$('.customerEditModal').html(data.data);
				$('.customerEditModal').modal('show');
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
        url: base_url+'/update-customer/'+user_id,
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','User Updated Successfully','top-right','success',2000);
				$('#full_name_'+user_id).text(data.full_name);
				setTimeout(function(){ $('.customerEditModal').modal('hide'); }, 2000);
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
$(document).on('submit','#createNewCustomer', function(e) {
	e.preventDefault(); 
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/create-new-customer',
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','User Updated Successfully','top-right','success',2000);
				setTimeout(function(){ $('.userCreateModal').modal('hide'); }, 2000);
				setTimeout(function(){window.location.href = base_url+'/customers'; }, 2500);
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
$(document).on('click', '#create_user' , function() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "GET",
		dataType: 'json',
        url: base_url+'/customer/create/',
        data: {},
        success: function(data) {
			if(data.success){
			
				$('.userCreateModal').html(data.data);
				$('.userCreateModal').modal('show');
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})

/*==============================================
	SEARCH FILTER FORM 
============================================*/
$(document).on('submit','#searchForm', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/customers',
        data: $(this).serialize(),
        success: function(data) {
			 $('.search_spinloder').css('display','none');
             //start date and end date error 
			 if(data=='date_error'){
				notification('Error','Start date not greater than end date.','top-right','error',4000);	
			}else{
             // Set search result
			 $("#tag_container").empty().html(data); 
			}	
        },
		error :function( data ) {}
    });
});