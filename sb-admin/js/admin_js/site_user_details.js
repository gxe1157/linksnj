/* Build obj to be used by model_js */
var model_js_mess = {
        'delete' : '<h3>Delete this account?</h3>',
        'suspend': '<h3>Suspend this account?</h3>',
        'reset_pswrd' : '<h3>Reset Password?</h3>',
        'submit_option' : null
}


function activaTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};

function save_changes_ajax( id ){
    let update_flds = {};
    let formData = new FormData();
    let div_id = id.split('-');

    let jdata = div_id[1]; // This is the id of the div we want data from.
    let getData = $('#'+jdata).find(':input').serializeArray();

    formData.append( 'fld_group', div_id[1] );              
    formData.append( 'id', div_id[2]);                            
    $.each(getData, function(i, field){
        formData.append( field.name, field.value);  
        update_flds[field.name] = field.value; 
    });

    $.ajax({
      url: dir_path+'site_users/save_changes_ajax', 
      method:"POST",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,
      success:function(data)
      {
        $(".clear_error_mess").html('');            

        let response = JSON.parse(data);
        if( response['success'] == 1 ) {
            let message = response['flash_type'];
            myAlert( jsUcfirst(message)+' ! ',response["flash_message"], message );

            if( update_flds['first_name'] || update_flds['last_name'] )
               $('#fullname').html( update_flds['first_name']+' '+update_flds['last_name']);

            change_occurred = false;
            // console.log('update_flds',update_flds);

        } else {
          // console.log('response',response);
          myAlert('Error!',response["flash_message"], 'danger');

          let error_message = response['errors_array'];
          for ( var key in error_message ) {
            if (error_message.hasOwnProperty(key)){
              if( key !== 'contains' ) {
                $('.'+key).html(error_message[key]);               
              }
            }
          }
        } //data

      }// success

    })  
 
}

$(document).ready(function() {
    $('.view_property').on('click', function(){
        let idData = (this.id).split('|');

        let formData = new FormData();
        formData.append('rowId', idData[0]);

        $.ajax({
          url: dir_path+'site_users/modal_fetch_ajax/'+idData[1],
          method:"POST",
          data: formData,
          contentType: false,
          cache: false,
          processData:false,      
          success : function(data){
            // console.log( 'Return Data:......  ', data);
            let response = JSON.parse( data );
            // console.log( 'Return Data:......  ', response);

            if( response['success'] == 1 ){
              let columns = response['mysqlRows'];

              /* assign values to modal */
              $('#rowId').val(columns['id']);
              $('#show_rowId').val(columns['id']);          
              for ( var key in columns ) {
                if (columns.hasOwnProperty(key)){
                  if( key !== 'contains' ) {
                     $('#'+key).val(columns[key]);
                     if(key == 'photos'){
                        $('#propertyImg').attr('src', columns['photos']);
                     }  
                  }
                }
              } //foreach
              setTimeout(function() {
                  $("#viewPropertyModal").modal('toggle');
              }, 500);

            } else {
              $('#caption').val('');
              myAlert('Error!','<b>'+response['flash_message']+'</b>');
              console.log('Error: Record failed to be added to database.');            
            } 
          }

        });

        // $('#viewPropertyModal').modal();
    });


    if( $('#cnt_errors').val() > 0 ) {
      let error_mess =  $('#error_mess').val();
      error_mess = error_mess.split("|");
      myAlert( jsUcfirst('Error')+' ! ', error_mess, 'danger' );
    }

    if( $('#show_panel').val() ) {
        $('#show_copy').html( $('textarea#job_description').val() );
    }

    $('#job_description').on('change', function(){
        $('#show_copy').html( $('textarea#job_description').val() );
        console.log( $('textarea#job_description').val() );
    });

    /* update show_panel hidden field */
    if( $('#show_panel').val() ) {
        let val = $('#show_panel').val();
        activaTab(val);            
    }

    $("a").click(function (e) {
      let href = $(this).attr('href').substr(1); 
      $('#show_panel').val(href);
  
      $(".alert").slideUp(800, function() {
        $(this).remove();
      });
    });

    /* Phone, date formating */
    $('input[name="dob"], input[name="ad_start_date"], input[name="ad_end_date"], input[name="hire_date"], input[name="termination_date"]').on('keydown', function(event) {
        formatData(this,event,'DOWN','date');
    })

    $('input[name="dob"], input[name="ad_start_date"], input[name="ad_end_date"], input[name="hire_date"], input[name="termination_date"]').on('keyup', function(event) {
        formatData(this,event,'UP','date');        
    })

    $('#phone, #cell_phone, #fax').on('keydown', function(event) {
        formatData(this,event,'DOWN','phone');
    })

    $('#phone, #cell_phone, #fax').on('keyup', function(event) {
        formatData(this,event,'UP','phone');        
    })

    /* detect any input change */
    let change_occurred = false;    
    $('#myForm :input').change(function(e){
      // console.log($(e.target).attr('id'));
      change_occurred = true;
    });

    $('#myForm #submit_btn').on('click', function() {
        let error_mess = '<b>No changes have occurred to this record.</b>';
         if( change_occurred == false ){
            myAlert( jsUcfirst('Alert'), error_mess, 'warning' );                  
            return false;
        }
    });

    /* Auto complete off */
    $('#users_admin').on( 'focus', ':input', function(){
        $(this).attr( 'autocomplete', 'off' );
    });

    /* Save and continue */
    $('#users_admin :input').change(function(e){
        //console.log($(e.target).attr('id'));
        change_occurred = true;
    });


  /* --------------------------------------------
      Upload Avatar 
     -------------------------------------------*/    

  function noPreview_avatar(){
    let user_avatar = document.getElementById('user_avatar').value;
    $( 'input[type="file"]').val('');
    $( '#pre_upload' ).css("display", "block");
    $( '#previewImg').attr('src', set_CI3_path()+'upload/'+user_avatar );
    $( '#confirm_upload').css("display", "none");
  }

  $("#cancelImg").click(function (e) {
      noPreview_avatar();
  });

  function selectImage_avatar(e) {
    $( '#previewImg').attr('src', e.target.result).css("height","150").css("width","200");
    $( '#confirm_upload' ).css("display", "block");
    $( '#pre_upload' ).css("display", "none");
  }

  var maxsize = 1024 * 1024; // 500 KB
  $('#max-size').html((maxsize/1024).toFixed(2));

  $('#remove_avatar').on('click', function( ) {
    var messText  = "Do you want to remove avatar image ?";
    ezBSAlert({
      type: "confirm",
      messageText: messText,
      alertType: 'danger'
    }).done(function (e) {
      if( e ) {
        let target_url = set_CI3_path()+'site_upload/users_upload/ajax_remove_avatar';
        upload_ajax_avatar( target_url, null );
      }
    });
  });

  /* evelio on submit */
  $('#upload-image-avatar').on('submit', function(e) {
    $( '#upload-button').prop("disabled",true);
    $( '#cancelImg').prop("disabled",true);

    e.preventDefault();
    let target_url = set_CI3_path()+'site_upload/users_upload/ajax_upload_one';
    let File1 = document.getElementById('avatar').files[0];
    let id = document.getElementById('update').value;

    let formData = new FormData();
    formData.append( 'file', File1);
    formData.append( 'update_id', id);    

    // console.log('Upload submits');
    upload_ajax_avatar( target_url, formData );
  });


  function upload_ajax_avatar(target_url, formData) {
    // formData.append('id', _(obj.id).value );
    // console.log('upload_ajax_avatar', target_url);

    $.ajax({
      url: target_url,
      method:"POST",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,
      success:function(data)
      {
        var imgData = JSON.parse( data );
        // console.log( 'Return Data:......  ', imgData, imgData['file_name'] );
        document.getElementById('user_avatar').value = imgData['file_name'];

        $( '#upload-button').prop("disabled",false);
        $( '#cancelImg').prop("disabled",false);
        $( '#confirm_upload').css("display", "none");
        $( '#pre_upload').css("display", "block");

       if( imgData['file_name'] == 'annon_user.png' ) noPreview_avatar();

      }

    });
  }

  /* On change */
  $('#upload-image-avatar').on('change','#avatar', function() {
    /* assign to value to img obj */
    var img_id = this.id;
    $('#message').empty();

    /* check for file attributes */
    var file = this.files[0];
    var match = ["image/jpeg", "image/png", "image/jpg"];
    if ( !( (file.type == match[0]) || (file.type == match[1]) || (file.type == match[2]) ) ) {
      noPreview_avatar();
      $('#message').html('<div class="alert alert-warning error_messages" role="alert">Unvalid image format. Allowed formats: JPG, JPEG, PNG.</div>');
      return false;
    }

    if ( file.size > maxsize ) {
      noPreview_avatar();
      $('#message').html('<div class=\"alert alert-danger error_messages\" role=\"alert\">The size of image you are attempting to upload is ' + (file.size/1024).toFixed(2) + ' KB, maximum size allowed is ' + (maxsize/1024).toFixed(2) + ' KB</div>');
      return false;
    }
    console.log('Upload Image');

    /* preview selected image */
    var reader = new FileReader();
    reader.onload = selectImage_avatar;
    reader.readAsDataURL(this.files[0]);

  });


});