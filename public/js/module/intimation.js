Dropzone.autoDiscover = false;

$('.dropzone').each(function(){
    var options = $(this).attr('id').split('-');
    var dropUrl = 'test' + options[1] + '.php';
    var dropMaxFiles = 2;
    var dropParamName = 'file' + options[1];
    var dropMaxFileSize = '20';
	var dropzoneErrorClass= '.dropzoneError';
	var ajaxRequestErrorClass = '.document_error';
	var dropzoneURL= '/claim-document/';
	var dropzoneFileaccept= ".jpeg,.jpg,.png,.gif";
	var dropzoneExtMsg= "Please select only supported files.";
	var dropzoneSizeMsg= "Image width must be 2000px and height must be 320px.";
	var dropzoneErrorMsg="Upload Document field is required.";
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var documentElement = $('#claim-form').find('#document');

    $(this).dropzone({
		url: base_url+'/claim-document',
        maxFiles: dropMaxFiles,
        paramName: dropParamName,
        maxFilesSize: dropMaxFileSize,
		autoProcessQueue: true,
		addRemoveLinks: false,
		parallelUploads:2,
		uploadMultiple:true,
		headers: {
			'X-CSRF-Token': csrf_token
		},
		accept: function(file, done) {
								
			var _URL = window.URL || window.webkitURL;
			img = new Image();
			var imgwidth = 0;
			var imgheight = 0;
			/* var maxwidth = 2000;
			var maxheight = 320; */

			img.src = _URL.createObjectURL(file);
			
			var ext = (file.name).split('.')[1]; // get extension from file name						
			ext = ext.toUpperCase();
			if ( ext == "JPG" || ext == "JPEG" || ext == "PNG" ||  ext == "GIF" ){
				done();  
				$(dropzoneErrorClass).text('');
			}else { 
				done(dropzoneExtMsg); 
				$(dropzoneErrorClass).text(dropzoneExtMsg);
			}
			
		},
		init: function() {
			this.on('error', function(file, response) { 
				this.removeAllFiles();
				var errorMessage ;
				if(response.errorMessage == undefined) errorMessage = response;
				else  errorMessage = response.errorMessage;
				$(file.previewElement).find('.dz-error-message').text(errorMessage);
				$(dropzoneErrorClass).text(errorMessage);
				
			});
			this.on("maxfilesexceeded",function(file){
				/* Hiding default message of DROPZONE i.e. Drop files here to upload */
				if($(this.previewsContainer.children[1]) != undefined){
					$(this.element.children[0]).hide();
				}
				$(dropzoneErrorClass).text('Sorry, you cannot upload more than 2 files.');
					
			
			});
			this.on("success", function(file, responseText) {
				if(typeof responseText != 'undefined' && responseText != null && typeof (responseText.medias) != 'undefined' && responseText.medias != null){
					var fileIds = responseText.medias;
					var fileNames = responseText.names;
					fileIds.forEach(function (item,key) {
						/*check 2 file uploaded or 1*/
						if(fileIds.length == 2){
							if(key == 0){
								/*modify second last element*/
								$( ".dz-preview:nth-last-child(2)").find('.remove').attr('data-dz-remove', item);
							}
							/*check if name match then replace file id*/
							if(fileNames[key] == file.name)
								file.id = item;

						}else{
							file.id = item;
						}
			            $(".dz-preview:last-child").find('.remove').attr('data-dz-remove', item);
			        });

			        /*add ids to #document element*/

			        var documentIds = documentElement.val();
			        var newDocuments = fileIds.toString();
			        /*check document empty*/
			        if($.trim(documentIds) == ''){
			        	documentElement.val(newDocuments);
			        }else{
			        	newDocuments = documentIds+','+newDocuments;
			        	documentElement.val(newDocuments);
			        }
				}
				$(ajaxRequestErrorClass).html('');
				
			});
			this.on('removedfile', function (file) {
				var fileId = file.id;
				if(fileId != '' && parseInt(fileId) > 0){
					/*Delete file*/
					$.post(base_url+'/delete/claim-document/'+fileId,{'_token': csrf_token,file_name:file.name}, function(data, textStatus) {
						if(data.success){
							//notification('Success',data.msg,'top-right','success',4000);
							/*convert string to array*/
							var fdocumentIds = documentElement.val();
							var documentArr = fdocumentIds.split(',');
							/*Remove particular ids from array*/
							documentArr = jQuery.grep(documentArr, function(value) {
							  return value != fileId;
							});
							//documentArr.splice($.inArray(fileId, documentArr), 1);
							/*check array length*/
							if(fdocumentIds.length == 0){
								documentElement.val('');
							}else{
								var updatedDocuments = documentArr.toString();
								documentElement.val(updatedDocuments);
							}
						}
					}, "json");
				}
				
				$(dropzoneErrorClass).text('');
				$(ajaxRequestErrorClass).html('');
			});
		},
		thumbnailWidth: 160,
		previewTemplate: '<div class="dz-preview dz-file-preview mb-3"><div class="d-flex flex-row"><div class="p-0 w-30 position-relative"><div class="dz-error-mark"><span><i></i></span></div><div class="dz-success-mark"><span><i></i></span></div><div class="preview-container"><img data-dz-thumbnail="" class="img-thumbnail border-0" /><i class="simple-icon-doc preview-icon" ></i>	</div></div><div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative"><div><span data-dz-name=""></span></div><div class="text-primary text-extra-small" data-dz-size=""></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div><div class="dz-error-message"><span data-dz-errormessage=""></span></div></div><a href="#/" class="remove" data-dz-remove=""><i class="glyph-icon simple-icon-trash"></i></a></div></div>',
        // Rest of the configuration equal to all dropzones
    });


});
$('[data-type="adhaar-number"]').keyup(function() {
  var value = $(this).val();
  value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
  $(this).val(value);
});


$('[data-type="adhaar-number"]').on("change, blur", function() {
  var value = $(this).val();
  var maxLength = $(this).attr("maxLength");
  
  if (value.length !=  maxLength) {
		$('.aadhar_number_error').html("Incorrect Aadhar Number");
  } else {
		$('.aadhar_number_error').html("");
  }
});

function onlyNumberKey(evt) { 
    // Only ASCII charactar in that range allowed 
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
        return false; 
    return true; 
}

$(document).on('submit','#claim-form',function(e){
	e.preventDefault();
	$this = $(this);
	//empty error message
	$this.find('.error').html('');
	$('.claim-common-error').html('').addClass('d-none');
	var ajax_url = $this.attr('action');
	var method = $this.attr('method');
	/*show loader*/
	$this.find('.claim_spinloder').show();
	var formData = $('#claim-form').serializeArray();
	$.ajax({
		type:method,
		url:ajax_url,
		data:formData,
		success:function(response){
       		$this.find('.claim_spinloder').hide();
			if(response.success){
				if(typeof (response.view) != 'undefined' && response.view != null){
					$('.claim-intimate-form').html(response.view);
				}
			}else{
				if(typeof (response.message) != 'undefined' && response.message != null && response.message != ""){
					$('.claim-common-error').html(response.message).removeClass('d-none');
					//setTimeout(function(){ $('.claim-common-error').html('').addClass('d-none');}, 5000);
				}
				else{
					$('.claim-common-error').html('Something went wrong.').removeClass('d-none');
					//setTimeout(function(){ $('.claim-common-error').html('').addClass('d-none');}, 5000);
				}
			}
        },
        error:function(data){
       		$this.find('.claim_spinloder').hide();
       	
       		if( data.status === 422 ) {
	            var errors = $.parseJSON(data.responseText);
	            $.each(errors, function (key, value) {
	                if($.isPlainObject(value)) {
	                    $.each(value, function (key, value) {                       
	                        //console.log(key+ " " +value);
	                    	$('.'+key+'_error').html(value);

	                    });
	                }else{
	                	$('.'+key+'_error').html(value);
	                }
	            });

	            //setTimeout(function(){ $('.error').html('');}, 3000);
	        }else{
	        	$('.claim-common-error').html('Something went wrong.').removeClass('d-none');
				//setTimeout(function(){ $('.claim-common-error').html('').addClass('d-none');}, 5000);
	        }
       }

    });
});