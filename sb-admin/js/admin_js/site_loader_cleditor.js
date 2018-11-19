
/* manage users table control  */

var model_js_mess = {
        'delete' : '<h3>Delete this record?</h3>',
    }

$(document).ready(function() {
	/* ---------- Text editor ---------- */
  	$(".cleditor").cleditor(
  		    {
				width: 500, // width not including margins, borders or padding
                height: 250, // height not including margins, borders or padding
                controls: // controls to add to the toolbar
                    "bold italic underline strikethrough subscript superscript | font size " +
                    "style | color highlight removeformat | bullets numbering | outdent " +
                    "indent | alignleft center alignright justify",            }
  		);
} );
