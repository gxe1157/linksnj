$(document).ready(function(){
    $('#insertImage').click(function(){

        // =============== Modified by @gieart_dotcom ===========
        $.ajax({
                type : 'GET',
                url : SERVER + 'blogs/assets/browse_assets',
                success : function (images){
                    $('#InsertImage').modal('toggle');
                    $('#imageList').html(images);

                    /* Remove cancel and done buttons and replace with close button by Evelio */
                    $('.modal-footer').html('');
                    $( '<button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>' ).appendTo('.modal-footer');
                }
             });
        // =======================================================
    });
        
	$('.btnShowAssets').click(function(){
		$('#assetsList').html('');
		// =============== Modified by @gieart_dotcom ===========
        $.ajax({
                type : 'GET',
                url : SERVER + 'blogs/assets/browse_assets',
                success : function (images){
                	$('#assetsList').html(images);
                }
             });
        // =======================================================
	})

});


function setFeaturedImage(path){
	var asset_path = path.replace(BASE_URI,"");
   	$('#featured_image').val(asset_path);
   	
   	$('.preview_featured_image').html('<img src="'+path+'" class="img-responsive thumbnail" onclick="removeFeaturedImage()" style="width:150px;height:150px;cursor:pointer"/>');
}

function removeFeaturedImage(){
	$('#featured_image').val('');
	$('.preview_featured_image').html('');
}

browseAsset = function(page){

	$('#assetsList').html('');
	// =============== Modified by @gieart_dotcom ===========
    $.ajax({
            type : 'GET',
            url : SERVER + 'blogs/assets/browse_assets?page='+page,
            success : function (images){
            	$('#assetsList').html(images);
            }
    });
    // =======================================================
}