/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
/*$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});*/

$(document).on('click', '.editCertitificateRequest' , function() {
	var user_id = $(this).data('user_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/certificate/edit/'+user_id,
        data: {_token:csrf_token,user_id:user_id},
        success: function(data) {
			if(data.success){
			
				$('.editCertificateRequestModal').html(data.data);
				$('.editCertificateRequestModal').modal('show');
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
});

/*submit update certificate*/
$(document).on('submit', '#updateCertificate' , function(event) {
	event.preventDefault();
	$this = $(this);
	var ajax_url = $this.attr('action');
	var method = $this.attr('method');
	/*fetch page number and sno which used to replace row*/
	var $request_id = $this.find('#user_id').val();
	var formData = $('#updateCertificate').serializeArray();
	if($request_id != ''){
		var parentRow = $("#tag_container table").find('tr.user_row_'+$request_id);
		var page_number = parentRow.find('td#sno_'+$request_id).find('#page_number_'+$request_id).val();
		var s_number = parentRow.find('td#sno_'+$request_id).find('#s_number_'+$request_id).val();

		formData.push({ name: "page_number", value: page_number });
		formData.push({ name: "sno", value: s_number });

		/*show loader*/
		$this.find('.request_loader').show();
		$.ajax({
	       type:method,
	       url:ajax_url,
	       data:formData,
	       success:function(response){
	       		$this.find('.request_loader').hide();
				if(response.success){
					if(typeof (response.view) != 'undefined' && response.view != null && typeof (response.class) != 'undefined'  && response.class != null && response.view != '' && response.class != ''){
						$('.'+response.class).replaceWith(response.view);
						setTimeout(function(){ $('.editCertificateRequestModal').modal('hide'); }, 500);
					}
				}else{
					if(typeof (response.message) != 'undefined' && response.message != null && response.message != "")
						notification('Error',response.message,'top-right','error',3000);
					else
					notification('Error','Something went wrong.','top-right','error',3000);
				}
	        },
	       error:function(response){
				$this.find('.request_loader').hide();
				console.log('error');
				notification('Error','Something went wrong.','top-right','error',3000);
	       }

	    });
	}else{
		notification('Error','Something went wrong.','top-right','error',3000);
	}
});

/*==============================================
	SEARCH FILTER FORM 
============================================*/
$(document).on('submit','#searchCertificateForm', function(e) {
    e.preventDefault(); 
    $this = $(this);
	var ajax_url = $this.attr('action');
	var method = $this.attr('method');
	$('.search_spinloder').show();
    $.ajax({
        type: method,
        url: ajax_url,
        data: $(this).serialize(),
        success: function(data) {
			$('.search_spinloder').hide();
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
		error :function( data ){
			$('.search_spinloder').hide();
			notification('Error','Something went wrong.','top-right','error',3000);
		}
    });
});

/*Export certificate request*/
$(document).on('click','#export_certificate_left', function(e) {
	 e.preventDefault(); 
	$('.search_spinloder').show();
	//var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
		//dataType: 'json',
        url: base_url+'/export_certificate_customers',
        data: $('#searchCertificateForm').serialize(),
        success: function(data) {
			$('.search_spinloder').hide();
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
				downloadLink.download = "Certificate_customer.csv";

				/*
					* Actually download CSV
				*/
				document.body.appendChild(downloadLink);
				downloadLink.click();
				document.body.removeChild(downloadLink);
			}
			
        },
		error :function( data ) {
			$('.search_spinloder').hide();
			notification('Error','Something went wrong.','top-right','error',3000);
		}
    });
});

/*Modify city dropdown on change of state*/
$(document).on('change','#state_id', function(e) {
	var state_id = $(this).val();
	getCityDropDown(state_id);
});

function getCityDropDown(state_id){
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: "POST",
		url: base_url+'/user/cityDropdown',
		data: {_token:csrf_token,state_id:state_id},
		success: function(data) {
			 $("#district_id").empty().html(data); 
		},
		error :function( data ) {}
	});
}
