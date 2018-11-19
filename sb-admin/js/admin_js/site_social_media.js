/* manage users table control  */

/* Build obj to be used by model_js */
var model_js_mess = {
        'delete' : '<h3>Delete this account?</h3>',
        'suspend': '<h3>Suspend this account?</h3>',
        'reset_pswrd' : '<h3>Reset Password?</h3>',
        'submit_option' : null
    }

var errors_array= [];

var fldNames = {'ss_name':'Social Media Name', 'ss_url' : 'URL' };
var fldType  = {'ss_name':'text', 'ss_url' : 'text' };

model_js_mess.fldNames = fldNames;
model_js_mess.fldType  = fldType;

$('.btn-edit').on('click', function (e) {
    e.preventDefault();

    let myHeader = this.id;
    let editId = myHeader.split('-');
    let rowId = editId[1].split('/');

    let formData = new FormData();
    formData.append('rowId', rowId[0] );
    formData.append('userId', rowId[1] );    

    $.ajax({
      url: dir_path+'site_social_media/modal_fetch_ajax',
      method:"POST",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,      
      success : function(data){
        console.log( 'Return Data:......  ', data);
        let response = JSON.parse( data );
        // console.log( 'Return Data:......  ', response);

        $( ".btnSubmitForm" ).trigger( "click" );

        if( response['success'] == 1 ){
          let columns = response['mysqlRows'];
          /* assign values to modal */
          $('#rowId').val(columns['id']);
          for ( var key in columns ) {
            if (columns.hasOwnProperty(key)){
              if( key !== 'contains' ) {
                 $('#'+key).val(columns[key]);
              }
            }
          } //foreach
          // console.log( 'Data:......  ', columns);        
          // console.log('Successfully added record to database.' );
        } else {
          myAlert('Error!','<b>Record failed to be added to database.</b>');
          console.log('Error: Record failed to be added to database.');            
        } 
      }

    });
});

function add_data_ajax(){
    let user_id = $('#id').val();

    let formData = new FormData();
    let getData = $('#myModel').find(':input').serializeArray();
    $.each(getData, function(i, field){
        formData.append( field.name, field.value);  
        console.log('jdata', field.name, field.value );
    });
    formData.append('user_id', user_id );

    $.ajax({
      url: dir_path +'site_social_media/modal_post_ajax', 
      method:"POST",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,
      success:function(data)
      {
        // console.log( 'Return Data:......  ', data);
        var response = JSON.parse( data );
        // console.log( 'Return Data:......  ', response);

        if( response['success'] == 1 ){
            /* Success */
            let target_url = 'manage_admin';
            let href= dir_path+"site_social_media/"+target_url+'/'+user_id;       
            window.location.replace( href );
        } else if ( response['success'] == 2 ) {
            /* Failed to write t drive */
            myAlert('Error!','<b>Record failed insert/update to database.</b>');
        } else {  
          /* Failed validation */
          errors_array = response['errors_array'];
          for ( var key in errors_array ) {
            if (errors_array.hasOwnProperty(key)){
              if( key !== 'contains' ) {
                $('#error_'+key).html(errors_array[key])
              }
            }
          }
        }	
      }// success

    })  
}

