/* global img obj variables */
var img ={};
//var output = {};
// var convert_arr = [];

var client_files = [];
var dupe_found = [];
var model_js_mess = {
        'delete' : '<h3>Remove this document?</h3>',
        'suspend': '<h3>Suspend this user account?</h3>'
}

function assign_id( id ){
    $('.error_messages').empty().css("display", "none");
    img['id'] = id.split('_').pop();
    return  img['id'];
}

function imgFileInfo( imageId ) {
    var file = _(imageId).files[0];
    // console.log(file.name+" | "+file.size+" | "+file.type );
    return file.name;
}

function upload_image( obj ) {
    // Get the button id then submit
    assign_id( obj.id );
}

function noPreview(){
  $( '#previewImg_'+img['id']).attr('src', dir_path+"public/images/list-default-thumb.png" );
  $( '#pre_upload_'+img['id'] ).css("display", "block");
  $( '#confirm_upload_'+img['id'] ).css("display", "none");
  $( '#completed_upload_'+img['id'] ).css("display", "none");
  $( '#imageFile_'+img['id']).val('');
  $( '#removeImg_'+img['id']).val(0);
}

function selectImage(e) {
  // console.log('|'+'#previewImg_'+img['id'], '#pre_upload_'+img['id']);
  $( '#previewImg_'+img['id'] ).attr('src', e.target.result);
  $( '#pre_upload_'+img['id'] ).css("display", "none");
  $( '#confirm_upload_'+img['id'] ).css("display", "block");
}

/* ------- Dedupe functions -------*/
function dedupe(){
    // from client
    var file = imgFileInfo( 'imageFile_'+img["id"] );

    var a = client_files.indexOf(file);
    if( a == -1 ){
      client_files.push(file);
    } else {
    // console.log(client_files, file );
    var prom = ezBSAlert({
                  messageText: file+" has already been selected.<br>Please enter a different image.",
                    alertType: "danger"
                  }).done(function (e) {
                    $("body").append('<div>Callback from alert</div>');
                });
      return false;
    }
}

function cancel( obj ){
  if( obj != undefined )
      assign_id(obj.id);

  // from client
  var file = imgFileInfo( 'imageFile_'+img["id"] );
  client_files_remove(file);
  noPreview();
}

function client_files_remove(fileName){
  // console.log('remove: ',fileName+'...', client_files);
  let index = client_files.indexOf(fileName);
  if (index > -1) {
      client_files.splice(index, 1);
  }
  // console.log('Done.... ', client_files);
}

function getParentId() {
  if( _('role_'+img['id'] ) && _('role_'+img['id']).value !== undefined ){
    let temp = $('#role_'+img['id']).val(); // role is parent_cat on server side      
    let tempArray = temp.split('_');
    return tempArray[1];
  }      
  return '0';
}  

function remove( obj ){
    let controller = _('module').value;
    let position = assign_id( obj.id );
    let img_id   = $('#removeImg_'+position).val();    
    let img_name = $('#image_name_'+position).text();
    let messText = "Do You want to remove "+img_name+"?";    
    // alert( obj.value+' | position| '+position+' img_id| '+img_id+' img_name| '+img_name);

    ezBSAlert({
      type: "confirm",
      messageText: messText,
      alertType: 'danger'
    }).done(function (e) {
      if(e){
        $( '#removeImg_'+position ).prop("disabled",true);
        $('#message_'+position).empty();

        let formData = new FormData();
        formData.append('controller', controller );
        formData.append('img_id', img_id );
        formData.append('required_docs', _('required_docs').value);        
        formData.append('manage_rowid', _('manage_rowid').value );

        $.ajax({
          url: dir_path+controller+'/ajax_remove_one',
          method:"POST",
          data: formData,
          contentType: false,
          cache: false,
          processData:false,
          success:function(data)
          { 
            $( '#removeImg_'+position ).prop("disabled",false);            
            // console.log( 'Return Data:......  ', data);
            let response = JSON.parse( data );
            // console.log( 'Return Data:......  ', response);

             /* Redirect if module/controller exist */
            if(response['success'] == 1 ){
                $('#alert_mess').html(response['alert_mess']);              
                $('#image_name_'+position).html('......');
                $('#image_date_'+position).html('......');
                $('#message_'+position).html('<div class=\"alert alert-info error_messages\" role=\"alert\"> '+ response["remove_name"]+'<br>has been removed.</div>').fadeIn( 300 ).delay( 500 ).fadeOut( 400 );
            } else {

                $('#message_'+position).html('<div class=\"alert alert-danger error_messages\" role=\"alert\"> '+response["error_mess"]+'</div>').fadeIn( 300 ).delay( 500 ).fadeOut( 400 );
            }
            noPreview();
            client_files_remove(response["remove_name"]);            
          }
        })
      }
    })  
} 

function upload_ajax( target_url, formData, position ) {

    $.ajax({
      url: target_url,
      method:"POST",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,
      success:function(data)
      {
          // console.log( 'Return Data:......  ', data);
          let response = JSON.parse( data );
          console.log( 'Return Data:......  ', response);

          $( '#upload-button_'+img['id'] ).prop("disabled", false);
          $( '#cancelImg_'+img['id'] ).prop("disabled", false);
          
          if( response['success'] == '1'){
              $('#alert_mess').html(response['alert_mess']);

              $('#removeImg_'+position).val(response['new_insert_id']);
              $('#confirm_upload_'+position).css("display", "none");
              $('#completed_upload_'+position).css("display", "block");
              $('#pre_upload_'+position).css("display", "none");
              $('#image_name_'+position).html(response['client_name']);
              $('#image_date_'+position).html(response['image_date']);
              $('#message_'+position).html('<div class=\"alert alert-success error_messages\" role=\"alert\"> '+response['client_name']+'<br>has successfuly uploaded.</div>').fadeIn( 300 ).delay( 500 ).fadeOut( 400 );
          }else{
              $('#message_'+position).html('<div class=\"alert alert-danger error_messages\" role=\"alert\"> '+response['error_mess']+'</div>').fadeIn( 300 ).delay( 500 ).fadeOut( 400 );
          }
        } // end success
    });
}

function set_message(image_list, users_images)
{
    let set_mess ='<div class="col-md-12 alert alert-danger">';
    let missing_uploads = image_list - users_images;

    let type = missing_uploads == 0 ? 'success':'info';      
    let message ='<div class="col-md-12 alert alert-'+type+'">';

    let docs = missing_uploads == 1 ? 'document' : 'documents'; 
    message += 'You are required to provide '+image_list+' documents for verification.';

    if(missing_uploads < 1 ) {
      message +=' Our records show we have all '+docs+' .....';  
    } else {
      message +=' Our records show we still need you to send '+missing_uploads+' '+docs;  
    }
    message +='</div>';

    return message;
}

/*----- jquery -----*/
$(document).ready(function (e) {
  // from server
  if( $('#dbf_images').val() !== undefined )
      client_files = $.parseJSON( $('#dbf_images').val() );

  var maxsize = 1024 * 1024; // 500 KB
    /* Save and exit */
    $(".cancel").click(function (e) {
      alert('Cancel Button just pressed not working.... ');
      // window.location.replace('youraccount/welcome');
    });

  /* On submit */
  $('#upload-image-form').on('submit', function(e) {
      $( '#upload-button_'+img['id'] ).prop("disabled",true); // img['id'] = position
      $( '#cancelImg_'+img['id'] ).prop("disabled",true);
      $( '#message_'+img['id']).empty();

      e.preventDefault();
      let target_url = '';
      let controller = '';
      let position = img['id'];
      let parent_cat = getParentId();
      let required_docs = _('required_docs').value;

// console.log( $('#upload-image-form').serializeArray() );

      let formData = new FormData(this);
      formData.append('position', position);
      formData.append('parent_cat', parent_cat );
      formData.append('member_id', _('member_id').value );
      formData.append('manage_rowid', _('manage_rowid').value );
      formData.append('required_docs', required_docs );

      if( _('module') && _('module').value !== undefined ) {
        controller = _('module').value;
        formData.append('controller', controller );
        // formData.append('update_id', _('update_id').value );

        if(  controller == 'business_listings' )
            formData.append('caption', _('caption_'+img['id']).value );

        target_url = dir_path+controller+'/ajax_upload_one';
      } else {
        target_url = dir_path+'site_upload/site_ajax_upload/ajax_upload_one';
        alert('error: should not be here');

      }   

// return;

      upload_ajax( target_url, formData, position );
  });

  /* On change */
  $('input[type="file"]').change(function() {
    /* assign to value to img obj */
    var img_id = this.id;
    if( img_id  == 'avatar') return;

    assign_id(img_id);
    $('#message_'+img['id']).empty();

    /* check for dupes here */
    var proceed = dedupe();
    if( proceed == false ) {
      noPreview();
      return;
    }

    /* check for file attributes */
    var file = this.files[0];
    var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];

    if ( !( (file.type == match[0]) || (file.type == match[1]) || (file.type == match[2]) ) ) {
      noPreview();
      $('#message_'+img['id']).html('<div class="alert alert-warning error_messages" role="alert">Unvalid image format. Allowed formats: JPG, JPEG, PNG.</div>');

      return false;
    }

    if ( file.size > maxsize ) {
      noPreview();
      $('#message_'+img['id']).html('<div class=\"alert alert-danger error_messages\" role=\"alert\">The size of image you are attempting to upload is ' + (file.size/1024).toFixed(2) + ' KB, maximum size allowed is ' + (maxsize/1024).toFixed(2) + ' KB</div>');

      return false;
    }

    /* preview selected image */
    var reader = new FileReader();
    reader.onload = selectImage;
    reader.readAsDataURL(this.files[0]);

  });

});
