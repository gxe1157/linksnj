
<!-- This script is based on the javascript code of Roman Feldblum (web.developer@programmer.net) -->
<!-- Original script : http://javascript.internet.com/forms/format-phone-number.html -->
<!-- Original script is revised by Eralper Yilmaz (http://www.eralper.com) -->
<!-- Revised script : http://www.kodyaz.com -->
<!-- Revised script by : Evelio Velez 02-07-2014  gx1157@yahoo.com -->
<!-- Format : "(123) 456-7890" -->

var Gvar = {
    //dataCount: 0,
    keyPress: [9, 37, 38, 39, 40 ],
    dataMaxLength: 0,
    dataPos1: 0,
    dataPos2: 0,
    dataMode: '',
    dataMask: []
}

var Dvar = {
    daysMonth:{
        1:31, 2:29, 3:31, 4:30, 5:31, 6:30, 7:31, 8:31, 9:30, 10:31, 11:30, 12:31
    }
};


function doCheckHours( action, p ) {
    var hrs = parseInt( p.substr(0, 2),0 );
    var min = parseInt( p.substr(2, 2),0 );
	
    var actions = {
     '2': function () {
            if ( hrs <= 12 ) {
                return p.substr(0, 2);
            } else {
                alert('\nError: Re-enter Hours\n\n'+hrs+':'+'__\n');
    			return '';
            }
        },
     '4': function () {
            if ( min < 60 ) {
                return p;
            } else {
                alert('\nError: Re-enter Minutes\n\n'+hrs+':'+min+'\n' );
                return p.substr(0, 2);
            }

         return p.substr(2, 2);
        }
    };

    if (typeof actions[action] !== 'function') {
       return p;
    }
    return actions[action]();

} /* End of doCheckDate */



function doCheckDate( action, p ) {
    var mm = parseInt( p.substr(0, 2),0 );
    var dd = parseInt( p.substr(2, 2),0 );
    var yy = parseInt( p.substr(4, 4),0 );
    var d = new Date();
    var n = d.getFullYear(); 
	
  
    var actions = {
    '2': function () {
            if ( mm <= 12 ) {
                return p.substr(0, 2);
            } else {
                //alert_mess('<p id="error_mess1">Error: Re-enter Month<br /><br />'+mm+'/'+' __/ ____</p>' );
                alert('\nError: Re-enter Month\n\n'+mm+'/'+' __/ ____\n' );
    			return '';
            }
        },
     '4': function () {
            if ( dd <= Dvar.daysMonth[mm] ) {
                return p;
            } else {
                //alert_mess('<br />Error: Re-enter Number of Days: ');
                alert('\nError: Re-enter Days\n\n'+mm+'/ '+dd+'/ ____\n' );
                return p.substr(0, 2);
            }

         return p.substr(2, 2);
        },
     '8': function () {
            var leapYear = ( ((yy % 4 == 0) && (yy % 100 != 0)) || (yy % 400 == 0) );
            console.log('leapyear', leapYear, 'mm', mm, 'dd', dd );
			
            if ( yy <= n ) {
                if( !leapYear && mm == 2 && dd>28 ){ 				
					alert('\nError: This is not a Leap Year:\n'+mm+'/ '+dd+'/ '+yy+'\n\nPlease Re-enter Date..' );
					return ''; //p.substr(0,4);					
				}
                return p;
            } else {
                //alert_mess( '<br />Error: Re-enter Year: ');
                alert('\nError: Re-enter Year\n\n'+mm+'/ '+dd+'/ '+yy+'\n' );
                return p.substr(0,4);
            }
        }
    };

    if (typeof actions[action] !== 'function') {
       return p;
    }
    return actions[action]();

} /* End of doCheckDate */


function CheckEvent(e) {
  // var key = (window.event) ? evt.keyCode : evt.which;
  if(e){
    e = e
  } else {
    e = window.event
  }
  if(e.which){
    var keycode = e.which
  } else {
    var keycode = e.keyCode
  }
  return keycode; 
}

/* object = this, e= event, k=keyup or keydown, f=format_type (ie. date,phone,ss ) */
function formatData(object,e,k,f ){
   var keycode = CheckEvent(e);

   /* Go through once */
   if( !Gvar.dataMode || Gvar.dataMode !== f ){ 
       Gvar.dataMode = f;

      if( f==='hours'){
        Gvar.dataMaxLength = 5;
        Gvar.dataPos1 = 1;
        Gvar.dataPos2 = 3;
        Gvar.dataMask = ['', '', ':', '', ''];
      }
	   
      if( f==='phone'){
        Gvar.dataMaxLength = 14;
        Gvar.dataPos1 = 2;
        Gvar.dataPos2 = 8;
        Gvar.dataMask = ['(', '', '', '', ') ', '', '', '', '-', '', '', '', ''];
      }

      if( f==='date'){
        Gvar.dataMaxLength = 10;
        Gvar.dataPos1 = 1;
        Gvar.dataPos2 = 5;
        Gvar.dataMask = ['', '', '/', '', '', '/', '', '', '', '' ];
      }
 
      if( f==='ss'){
        Gvar.dataMaxLength = 11;
        Gvar.dataPos1 = 2;
        Gvar.dataPos2 = 6;
        Gvar.dataMask = ['', '', '', '-', '', '', '-', '', '', '','' ];
      }
   }/* Go through once */

   
   /* Check Key Strokes for incomplete field info*/
   for( var i=0; i < Gvar.keyPress.length; i++ ){
        if( Gvar.keyPress[i] === keycode &&  object.value.length <Gvar.dataMaxLength){
			object.value ='';
			//e.preventDefault();			
			//return;		   
		}   
   } 
   
    /* tab key */
    if( keycode === 9 && k==='UP'){
  		//e.preventDefault();
  		 
  		// alert( object.name+' | '+object.value.length);		
  		// document.getElementById(object.name).focus();		
  	}
	
   /* Do only on keyup */ 
   if( keycode >= 48 && k==='UP'){
      doFormat( object, f );

   }
   
}

	// Get next field to tab to...
	function getObjPos(Obj, findObjId ){	
		var displayArray = 'Array:\n';
		var i=0
		var nextObjId = 0;
		
		for( var key in Obj ) {
			if(nextObjId) return key;
	
			if (Obj.hasOwnProperty(key)){
				if( key !== 'contains' ){
					displayArray +="\n"+i+" | Key: "+key+" = "+Obj[key];
					nextObjId = key == findObjId ? 1:0;
					i++; 
				}	
			}
		}
		//alert(displayArray);
	}	

function doFormat(object, f ){
   var p = object.value.replace(/([\s+\-\(\)\.\\\/])/g, '');
   p = p.replace(/[^\d]*/gi,"");
  
   if( f==='hours' ){
      p = doCheckHours( p.length, p );
   }

   if( f==='date' ){
     p = doCheckDate( p.length, p );
   }
 
   if ( p.length > Gvar.dataPos1 ) {
    		// var pd = Gvar.dataMask;
    		var pd = Gvar.dataMask.slice(0);
    		var x = 0;
    		for (var i = 0; i < pd.length; i++) {
    			if (pd[i] === '') {
    				pd[i] = p.substr(x, 1);
    				x++;
    			}
    		}
    		
    		if( p.length<Gvar.dataPos2-1 ) { pd[Gvar.dataPos2] = '';  }
    		p = pd.join('');
   }
	
	object.value = p.substring(0, Gvar.dataMaxLength );
}


