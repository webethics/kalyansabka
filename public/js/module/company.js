

/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editCompany' , function() {
	
	var company_id = $(this).data('company_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/companies/edit/'+company_id,
        data: {_token:csrf_token,company_id:company_id},
        success: function(data) {
			if(data.success){
			
				$('.companyEditModal').html(data.data);
				$('.companyEditModal').modal('show');
				$('.errors').html('');
			}else{
				
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
	

	
$(document).on('click', '.delete_company' , function() {
	var company_id = $(this).data('id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/companies/delete_company/'+company_id,
        data: {_token:csrf_token,company_id:company_id},
        success: function(data) {
			if(data.success){
				notification('Success','Company deleted Successfully','top-right','success',2000);
				$('.user_row_'+company_id).hide();
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
$(document).on('submit','#updateCompany', function(e) {
    e.preventDefault(); 
	var user_id = $('#user_id').val();
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/update-company/'+user_id,
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','User Updated Successfully','top-right','success',2000);
				$('#name_'+user_id).text(data.name);
				
				setTimeout(function(){ $('.customerEditModal').modal('hide'); }, 2000);
				if(data.state_head == 'updated'){
					setTimeout(function(){window.location.href = base_url+'/customers'; }, 2500);
				}
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
$(document).on('submit','#createNewCompany', function(e) {
	e.preventDefault(); 
	$('.request_loader').css('display','inline-block');
    $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/create-new-company',
        data: $(this).serialize(),
        success: function(data) {
			//alert(data)
			$('.errors').html('');
			$('.request_loader').css('display','none');
			// If data inserted into DB
			 if(data.success){
				 
				notification('Success','Company Created Successfully','top-right','success',2000);
				setTimeout(function(){ $('.userCreateModal').modal('hide'); }, 2000);
				setTimeout(function(){window.location.href = base_url+'/companies'; }, 2500);
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
$(document).on('click', '#create_company' , function() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "GET",
		dataType: 'json',
        url: base_url+'/companies/create/',
        data: {},
        success: function(data) {
			if(data.success){
			
				$('.companyCreateModal').html(data.data);
				$('.companyCreateModal').modal('show');
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
