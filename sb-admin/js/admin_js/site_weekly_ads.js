/* global img obj variables */
var img ={};

var model_js_mess = {
    'delete' : '<h3>Remove this document?</h3>',
    'suspend': '<h3>Suspend this user account?</h3>'
}

function noPreview(){
  $( '#imageFile').val('');  
  $( '#preview' ).css("display", "none");  
}

function previewImg(image) {
  // alert('previewImg | '+image);
  $( '#preview' ).css("display", "block");  
  $( '#update_button' ).css("display", "block");    
  $( '#previewImg' ).attr('src', image );
}

function remove( obj ){
    let position =0;
    let img_id = obj.id;    
    let img_name = obj.value;
    let messText  = "Do You want to remove "+img_name+"?";

    ezBSAlert({
      type: "confirm",
      messageText: messText,
      alertType: 'danger'
    }).done(function (e) {
      if( e ) {
        let update_id  = _('update_id').value;            
        let controller = _('module').value;
        let base_url   = dir_path+controller+'/';

        target_url = base_url+'remove_one/'+img_id+'/'+update_id;
        window.location.replace(target_url); 
      }
    });
}

function update_record() {
    let position = 0;    
    let selectedText;

    let formData = new FormData(this);
    formData.append('rowId', _('rowId').value );     
    formData.append('weekly_ad_id', _('update_id').value );     
    formData.append('listing_source', _('listing_source').value );    
    formData.append('caption', _('caption').value );
    formData.append('agents', _('agents').value );
    formData.append('status', _('status').value );
    formData.append('path', _('previewImg').src );    
    formData.append('address', _('address').value);    

    $.ajax({
      url: dir_path+'site_weekly_ads/modal_post_ajax',
      method:"POST",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,      
      success : function(data){
        // console.log( 'Return Data:......  ', data);
        let response = JSON.parse( data );
        console.log( 'Return Data:......  ', response);

        let callback = function () { $("#uploadModal").modal('toggle'); }
        let messText = null;          
        if( response['success'] == 1 ){

          if( response['new_record'] == 0 ) {
            messText = 'Update Successful..';                      
            selectedText = _('status').options[_('status').selectedIndex].text;
            $('#status_update').html(selectedText);

            selectedText = _('agents').options[_('agents').selectedIndex].text;
            $('#agent_name').html(selectedText);
            $('#caption_div').html(_('caption').value);
            $('#property_address').html(_('property_address').value);            
            
            myAlert( 'Attention', messText, 'success', callback );

          }else{
            messText = 'Add New Record Successful..';
            let url = $('#base_url').val();
            let line = $('#update_id').val();
            let target_url = url+'site_weekly_ads/create/'+line+'/upload_files';
            // console.log(target_url);
            window.location.replace(target_url); 
          }
        } else {
          myAlert('Error!',response['flash_message']);
          // console.log('Error: Record failed to be added to database.');            
        } 
      }

    });

}

function edit(obj){
    let error_mess='';
    let idArrayrowId = (obj.id).split('|');   
    let rowId1 = idArrayrowId[0];
    let rowId2 = idArrayrowId[1];
    let mode = isNaN(rowId1) ? 'new_record' : 'update';
    let listing_id = isNaN(rowId1) ? _('caption').value : rowId1 ;

    if( listing_id.length == 0 )
        error_mess += '<br /><b>Property ID is missing.</b>';

    let listing_source = rowId2 != undefined ? rowId2 : _('listing_source').value;
    if(listing_source == '')
        error_mess += '<br /><b>Please select a Listing Source.</b>';

    if( error_mess.length>0){
      myAlert('Error!', error_mess)
      return;
    }

    let formData = new FormData();
    formData.append('listingId', listing_id );
    formData.append('listingSource', listing_source );
    formData.append('mode', mode );

    $.ajax({
      url: dir_path+'site_weekly_ads/modal_fetch_ajax',
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

          if( listing_source == 1 ) {
            $('#rowId').val('');            
            $('#show_rowId').val('');     
            $('#update_button').css("display", 'block');                 
            $('#submit_button').css("display", 'none'); 
            $('#address').val(columns['address']);
            previewImg(columns['photos']);
          } else {
            $("#uploadModal").modal('toggle');          
            /* assign values to modal */
            $('#rowId').val(columns['id']);
            $('#show_rowId').val(columns['id']);          
            for ( var key in columns ) {
              if (columns.hasOwnProperty(key)){
                if( key !== 'contains' ) {
                   $('#'+key).val(columns[key]);
                   if(key == 'path'){
                      previewImg(columns[key]);
                   }  
                }
              }
            } //foreach
          }

        } else {
          $('#caption').val('');
          myAlert('Error!','<b>'+response['flash_message']+'</b>');
          console.log('Error: Record failed to be added to database.');            
        } 
      }

    });
};

/*----- jquery -----*/
$(document).ready(function (e) {
  $('#openUploadModal').on('click', function () {
      noPreview();
      $('#show_rowId').val('');          
      $('#uploadModal').modal();
      _('caption').value = '';
      _('status').value = '';
      _('agents').value = '';
      _('listing_source').value = '';
      // init_buttons('none');
      $( '#submit_button' ).css("display", "block");             
  })


  $('#uploadModal').on('hidden.bs.modal', function () {
      $('#show_rowId').val('');      
      $( '#submit_button' ).css("display", "none");
      $( '#update_button' ).css("display", "none");
  })

  $('#listing_source').on('change', function () {
      if( $('#listing_source').val() == ''){
          myAlert('Error! ','<b>The Listing Source is required. </b>');
          $('#listing_source').val('');
      }    

      if( $('#listing_source').val() == 2){
          myAlert('Coming Soon! ','<b>Links listing is not availble.</b>');
          $('#listing_source').val('');
      }    
  })

});
