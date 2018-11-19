
 function upperFirstletter(str){
 	return str[0].toUpperCase() + str.substring(1);
 }

 function build_form_inputs(){
	let build = '';
	let columns = model_js_mess['fldNames'];

	if (typeof model_js_mess.fldType === "undefined"){
	    alert('Error.... Contact your web designer about this error.'); // print into console
	    return;
	}

	let type = model_js_mess['fldType'];

	build ='<form id="myModel" class="form-horizontal" role="form">'; 	
	build +='<input type="hidden" id="rowId" name="rowId" value="">'; 
	build +='<div id="all_errors"></div>'; 			
	for ( var key in columns ) {
		if (columns.hasOwnProperty(key)){
			if( key !== 'contains' ) {
				if( type[key] == 'text'){
			        build +='<div class="form-group">'+
			                '<label class="col-sm-4 control-label" for="textinput">'+columns[key]+'</label>'+
			                '<div class="col-sm-8">'+
			                '<input type="text" id="'+key+'" name="'+key+'" value="" placeholder="'+columns[key]+'" class="form-control">'+
			            	'<span id="error_'+key+'" style="color:red; font-weight: bold;"></span></div>'+
			          		'</div>';
		        } else {
			        build +='<div class="form-group">'+
			                '<label class="col-sm-4 control-label" for="textinput">'+columns[key]+'</label>'+
			                '<div class="col-sm-8">'+
			                '<textarea id="'+key+'" rows="3" name="'+key+'" value="" placeholder="'+columns[key]+'" class="form-control"></textarea>'+
			            	'<span id="error_'+key+'" style="color:red; font-weight: bold;"></span></div>'+
			          		'</div>';
		        }  		
			}
		}
	}
 	build += '</form>';
    return build;
 }  


/* My custom model */
function myAlert( headerTxt, messTxt, alert_type, callback ){
	alert_type = alert_type || 'danger';
    let prom = ezBSAlert({
	  headerText: headerTxt,    	
      messageText: messTxt,
      alertType: alert_type,
      button_mess: "Submit"                  
    }).done(function (e) {
       if( callback !== undefined )	callback();
    });
}

function formatFields() {
	$('input[name="dob"]').on('keydown', function(event) {
	  formatData(this,event,'DOWN','date');
	})

	$('input[name="dob"]').on('keyup', function(event) {
	  formatData(this,event,'UP','date');        
	})


	$('#phone, #cell_phone').on('keydown', function(event) {
	  formatData(this,event,'DOWN','phone');
	})

	$('#phone, #cell_phone').on('keyup', function(event) {
	  formatData(this,event,'UP','phone');        
	})
};


function ezBSAlert (options) {
	var deferredObject = $.Deferred();
	var defaults = {
		type: "alert", //alert, prompt,confirm 
		modalSize: 'modal-sm', //modal-sm, modal-lg
		okButtonText: 'Ok',
		cancelButtonText: 'Cancel',
		yesButtonText: 'Yes',
		noButtonText: 'No',
		headerText: 'Attention',
		messageText: 'Message',
		alertType: 'default', //default, primary, success, info, warning, danger
		inputFieldType: 'text', //could ask for number,email,etc
		button_mess: options.button_mess,
	}
	$.extend(defaults, options);
  
	var _show = function(){
		var headClass = "navbar-default";
		//console.log('headClass', headClass, ' | ',defaults.alertType);
		switch (defaults.alertType) {
			case "primary":
				headClass = "alert-primary";
				break;
			case "success":
				headClass = "alert-success";
				break;
			case "info":
				headClass = "alert-info";
				break;
			case "warning":
				headClass = "alert-warning";
				break;
			case "danger":
				headClass = "alert-danger";
				break;
        }
		$('BODY').append(
			'<div id="ezAlerts" class="modal fade">' +
			'<div class="modal-dialog" class="' + defaults.modalSize + '">' +
			'<div class="modal-content">' +
			'<div id="ezAlerts-header" class="modal-header ' + headClass + '">' +
			'<button id="close-button" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
			'<h4 id="ezAlerts-title" class="modal-title">Modal title</h4>' +
			'</div>' +
			'<div id="ezAlerts-body" class="modal-body">' +
			'<div id="ezAlerts-message" ></div>' +
			'</div>' +
			'<div id="ezAlerts-footer" class="modal-footer"  style="padding:10px;">' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>'
		);

		$('.modal-header').css({
			'padding': '15px 15px',
			'-webkit-border-top-left-radius': '5px',
			'-webkit-border-top-right-radius': '5px',
			'-moz-border-radius-topleft': '5px',
			'-moz-border-radius-topright': '5px',
			'border-top-left-radius': '5px',
			'border-top-right-radius': '5px'
		});

		/* change model header colors */
		$('.alert-primary').css({
    		'background-color': '#428BCA',
    		'color' : '#fff'
		});

		$('.alert-success').css({
    		'background-color': '#31a57d',
    		'color' : '#fff'
		});

		$('.alert-danger').css({
    		'background-color': ' #d33f3f',
    		'color' : '#fff'
		});
    
		$('#ezAlerts-title').text(defaults.headerText);
		$('#ezAlerts-message').html(defaults.messageText);

		var keyb = "false", backd = "static";
		var calbackParam = "";
		switch (defaults.type) {
			case 'alert':
				keyb = "true";
				backd = "true";
				$('#ezAlerts-footer').html('<button class="btn btn-' + defaults.alertType + '">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
					calbackParam = true;
					$('#ezAlerts').modal('hide');
				});
				break;
			case 'confirm':
				var btnhtml = '<button id="ezok-btn" class="btn btn-primary">' + defaults.yesButtonText + '</button>';
				if (defaults.noButtonText && defaults.noButtonText.length > 0) {
					btnhtml += '<button id="ezclose-btn" class="btn btn-default">' + defaults.noButtonText + '</button>';
				}
				$('#ezAlerts-footer').html(btnhtml).on('click', 'button', function (e) {
						if (e.target.id === 'ezok-btn') {
							calbackParam = true;
							$('#ezAlerts').modal('hide');
						} else if (e.target.id === 'ezclose-btn') {
							calbackParam = false;
							$('#ezAlerts').modal('hide');
						}
					});
				break;

			case 'myForm':
				var btnhtml = '<button id="ezclose-btn" class="btn btn-default"> Cancel </button>';
					btnhtml += '<button id="ezok-btn" class="btn btn-primary"> '+defaults.button_mess+' </button>';

				$('#ezAlerts-footer').html(btnhtml).on('click', 'button', function (e) {
						if (e.target.id === 'ezok-btn') {
							if( defaults.button_mess == 'Submit') {
								// console.log('Submit.......');
								add_data_ajax();

								// calbackParam = true;
								// $('#ezAlerts').modal('hide');
							} else {
								calbackParam = true;
								$('#ezAlerts').modal('hide');
							}	

						} else if (e.target.id === 'ezclose-btn') {
							calbackParam = false;
							$('#ezAlerts').modal('hide');
						}
					});
				break;

			case 'prompt':
				$('#ezAlerts-message').html(defaults.messageText + '<br /><br /><div class="form-group"><input type="' + defaults.inputFieldType + '" class="form-control" id="prompt" /></div>');
				$('#ezAlerts-footer').html('<button class="btn btn-primary">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
					calbackParam = $('#prompt').val();
					$('#ezAlerts').modal('hide');
				});
				break;
		}
   
		$('#ezAlerts').modal({ 
          show: false, 
          backdrop: backd, 
          keyboard: keyb 
        }).on('hidden.bs.modal', function (e) {
			$('#ezAlerts').remove();
			deferredObject.resolve(calbackParam);
		}).on('shown.bs.modal', function (e) {
	        // console.log('Model is visible.............href ');	
			if( typeof fldNames !== undefined )
				formatFields();

			if ($('#prompt').length > 0) {
				$('#prompt').focus();
			}
		}).modal('show');
	}
    
  _show();  
  return deferredObject.promise();    
}

/* My custom model */
$(document).ready(function(){
  $("#btnAlert").on("click", function(){  	
    var prom = ezBSAlert({
      messageText: "hello world",
      alertType: "danger",
      button_mess: "Submit"                  
    }).done(function (e) {
      $("body").append('<div>Callback from alert...</div>');
    });
  });   

  $("#btnPrompt").on("click", function(){  	
    ezBSAlert({
      type: "prompt",
      messageText: "Enter Something",
      alertType: "primary",
      button_mess: "Submit"                  
    }).done(function (e) {
      ezBSAlert({
        messageText: "You entered: " + e,
        alertType: "success",
      	button_mess: "Submit"                    
      });
    });
  });   

// ================================
// similar behavior as an HTTP redirect
// window.location.replace("http://stackoverflow.com");
// similar behavior as clicking on a link
// window.location.href = "http://stackoverflow.com";

  $(".btnRemove").on("click", function(e){ 
	e.preventDefault();
	// console.log( 'Remove this: ',this.id);
    var btnOptions = (this.id).split('-');
   	var messText  = model_js_mess['delete']; 

    ezBSAlert({
      type: "confirm",
      messageText: messText,
      alertType: 'danger',
      button_mess: "Submit"                  
    }).done(function (e) {
	  if( e ) remove( btnOptions[2],btnOptions[3] );	  	
    });

  });   

  $(".btnConfirm").on("click", function(e){ 
	e.preventDefault();
    var btnName = (this.id).split('-');
   	var messText  = model_js_mess[btnName[0]]; 
	var href = $(this).attr('href');

    ezBSAlert({
      type: "confirm",
      messageText: messText,
      alertType: btnName[1],
      button_mess: "Submit"                  
    }).done(function (e) {
      // console.log('href '+href);	
	  if( e ) window.location.replace( href );	  	
    });
  });   

  $(".btnConfirmPDF").on("click", function(e){ 
	e.preventDefault();
	let myHeader = (this.id).split('-');
    let myBuild = '<iframe src="./public/images/pdf/'+myHeader[1]+'.htm" style="width:100%; height:500px;" frameborder="0"></iframe>';
	$( "#agree_terms" ).prop( "checked", false );

    ezBSAlert({
      type: "myForm",
      messageText: myBuild,
      headerText : myHeader[0],
      alertType: "primary",
      button_mess: "I agree to terms and conditions"                  
    }).done(function (e) {
	    /* check or uncheck */  
	 	$( "#agree_terms" ).prop( "checked", e );
        // if( e ) window.location.replace( href );	  	
    });
  });   

  $(".btnSubmitForm").on("click", function(e){ 
	e.preventDefault();

	let myHeader = this.id;
    let myBuild = '';
    myBuild = build_form_inputs();
	var href = $(this).attr('href');    

    // model_js_mess.submit_option = null;

    ezBSAlert({
      type: "myForm",
      messageText: myBuild,
      headerText : myHeader,
      alertType: "primary",
      button_mess: "Submit"            
    }).done(function (e) {
      // console.log('href '+href);	
	  // if( e ) window.location.replace( href );	  	
    });
  });   

  
//==================================

});