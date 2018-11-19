/* manage users table control  */

if( model_js_mess && model_js_mess !== undefined ) {
    var model_js_mess = {
            'delete' : '<h3>Delete this account?</h3>',
            'suspend': '<h3>Suspend this account?</h3>',
            'reset_pswrd' : '<h3>Reset Password?</h3>'
        }
}

$(document).ready(function() {
    console.log('Ready');

    $('#users').DataTable();

    $('.btn-manage.btn-danger, .btn-manage-sub.btn-danger').on('click', function( ) {
		mess1='You are about to delete a record.\n\nPress Ok to Continue.';  
		x = confirm(mess1);   
		if (x == false ) {  
			return false;
		}   
    });

} );
