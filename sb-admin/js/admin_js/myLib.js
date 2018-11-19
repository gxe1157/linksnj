/* Standard library functions - Evelio Velez Jr.  April 14, 2014 */

	function agreeToTerms(terms) {
		    if( typeof req_flds != "undefined" ){
				if( val_flds() === false ){
					document.getElementById("agree_to_terms").checked = false;
					return;
				}
			}

			var width = 850;
			var height = 600;
			var left = parseInt((screen.availWidth/2) - (width/2));
			var top = parseInt((screen.availHeight/2) - (height/2));
			var windowFeatures = "width=" + width + ",height=" + height +
				",status,resizable,left=" + left + ",top=" + top +
				"screenX=" + left + ",screenY=" + top + ",scrollbars=yes";

			termsWindow = window.open( "./public/js/images/pdf/"+terms+".htm", "Terms and Agreement", windowFeatures, "POS");

			//document.getElementById("mySubmit").disabled = false;
			//document.getElementById("mySubmit").style.color='red';
	}


	function showImage(img, ordrid){
		      window.open( img, "Ad Trans No: "+ordrid,"width=600, height=340,modal=yes");
	}

	function formResetSignup(formName){
		document.getElementById(formName).reset();

		var fldName = '';
		for (var key in req_flds) {
				if (req_flds.hasOwnProperty(key))
						fld_index = key;

				fldName  = req_flds[fld_index];
				fldValue = document.getElementById(fldName).value;
 				document.getElementById(fldName).style.backgroundColor = fldValue == '' ? "#FFFF99" : "#FFF";
		}
	}

	function formReset(formName, screen_mode) {
		console.log(formName+' | '+screen_mode);

		screen_mode != "undefined" ? screen_mode :  null;
		document.getElementById(formName).reset();
		// Reads Obj only

		for (var fldName in req_flds) {
			if (req_flds.hasOwnProperty(fldName))
				fldValue = req_flds[fldName];

			if( document.getElementById(fldName).value =='' ){
				document.getElementById(fldName).style.backgroundColor ="#FFFF99";
			} else {
				document.getElementById(fldName).style.backgroundColor ="#FFF";
			}

			if( screen_mode == 'View_Data'){
				document.getElementById(fldName).style.backgroundColor ="lightgrey";
				document.getElementById(fldName).disabled = true;
			}

		}
	}

	function PreviousPage( opt ){
 		var PrvPage = opt;
		window.location = PrvPage;
		return false;
	}

	function post_saveExit(go_here) {
			document.myForm.method = 'POST';
			document.myForm.action= go_here;
			document.myForm.submit();
	}

	function button_post( go_here ){
	   document.myForm.action= go_here;
	   document.myForm.submit();
	}

	function find_radio_opt( radio_name ){
		x=eval( radio_name+'.length');
		for(var i = 0; i < x; i++){
		  if( eval(radio_name+'[i].checked')==true ){rad_opt=eval(radio_name+'[i].value'); break; }
		}
		return rad_opt.substr(0,1);
	}


	function set_price( qty, amnt, prdname ){
	//	document.getElementById('itemQty').value = qty
		document.getElementById('itemprice').value = amnt;
		document.getElementById('itemname').value = prdname;
	}


	 /* Email Check */
	function movetoNext(current, nextFieldID) {
		document.getElementById(nextFieldID).focus();
		if (current.value.length >= current.maxLength) {
		//	document.getElementById(nextFieldID).focus();
		}
	}

	function isEmailFound(objEmail, table) {
	    var chk_email_value = objEmail.value;
		var hr = new XMLHttpRequest();
		hr.open("POST", "includes/regForm_chk_email.php", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			//alert( "readyState: "+hr.readyState+" status: "+hr.status );
			if(hr.readyState == 4 && hr.status == 200) {
				var d = hr.responseText;
				d = d.replace(/^\s+|\s+$/g,'');
				//alert( 'd: '+d);
				if( d === '1' ){
					var mess = objEmail.value+" is already an active email<br />Please select a different email";
					error_mess(mess);
					objEmail.value ="";
					objEmail.style.backgroundColor ="#FFFF99";
				}
			}// End hr.readyState == 4 && hr.status == 200

			if(hr.readyState == 4 && hr.status == 404) {
					var mess = "A system error has occurred.<br />Please try again later.....";
					error_mess(mess);
					objEmail.value ="";
					objEmail.style.backgroundColor ="#FFFF99";
			}

		}// End hr.onreadystatechange
		hr.send("Email="+chk_email_value+"&table="+table);

	} /* End of ajax_chk_email */

	function emailCheck(obj, table, isActive) {
	    var objEmail = obj;
		var form_name = objEmail.form.name;

        var mess = fldCheck('E', 1, objEmail );
        if( mess !=='ok' ){
			error_mess(mess);
			return;
		}

		if( objEmail.name ==="Email"  ){
		    if( isActive )
				isEmailFound( objEmail, table );
				return;
		}

		if( document.forms[form_name]["Emailconfirm"].value !== document.forms[form_name]["Email"].value ){
			mess = 'Email and Email Confirm do not match...<br>Please Re-enter';
			error_mess(mess);
			objEmail.value ="";
			objEmail.style.backgroundColor ="#FFFF99";
			return false;
		}
	} /* Email Check */


    /*  Check Out */
	function update_payment( base_price, fee, terms ){
		var x = +base_price + +fee;
        if ( document.myForm.amt ) {
			/* If field myForm.amt exist - From member_add.php */
			document.myForm.amt.value = dollarValue(x);

		}else{
			document.getElementById('checkout').innerHTML = "Total Dues: $"+dollarValue(x);
			document.getElementById('itemprice').value = x;
		}
		document.getElementById('terms').value = terms;

	}

	function dollarValue(n){
//		alert( 'dollarValue: '+n);

	   //  var mystring=n.replace(/[\,]/g, "");
       //  var n= mystring;
         if( n<.099 ){ var d = n;  return d; }
         var Bstr = "";
         var b = n * 100;
         var c = Math.round(b);
         var Astr = c.toString();
         var Alength = Astr.length;
         if (Alength <= 2) Bstr = Bstr + ".";
             var dot = Alength - 3;
             var counter = 0;
         while (counter < Alength )
           {
            Bstr = Bstr + Astr.charAt(counter);
            if (counter == dot) Bstr = Bstr + ".";
            counter = counter + 1;
           }
         var d = Bstr;
         return d;
     }


	function pop_expdate( adjust_yy ) {
		var expdate = document.myForm.old_expire.value;
		var exp_yy = eval(expdate.substr(6,4));
		var exp_mm = eval(expdate.substr(0,2));
		var exp_dd = eval(expdate.substr(3,2));

		var mdate = Today_is;
		var eyear = eval(mdate.substr(6,4));
		var emonth = eval(mdate.substr(0,2));
		var edate = eval(mdate.substr(3,2));

		if( exp_yy>eyear  )
		{
		  new_year = exp_yy + +adjust_yy;
		  new_month = exp_mm;
		  new_date = exp_dd;
		}
		else
		{
		  if( exp_yy==eval(eyear) && emonth<exp_mm )
		 {
			 new_year = exp_yy + +adjust_yy;
			 new_month = exp_mm;
			 new_date = exp_dd;
		 }
		else
		 {
		  new_year = eyear + +adjust_yy;
			 new_month = emonth;
			 new_date = edate;
		 }
		}

		m = new_month.toString();
		if(m.length == 1)
		{
		  m = "0" + m;
		}

		d = new_date.toString();
		if(d.length == 1)
		{
		  d = "0" + d;
		}

		y = new_year.toString();

		var new_date;
		new_date = m + "-" + d + "-" + y;
		document.myForm.exp_date.value = new_date;
	}


	function val_flds(){
		// chk required fields
		var mess='';
		var skip = false;

		for (var key in req_flds) {
			if (req_flds.hasOwnProperty(key)){
				fldName = req_flds[key];

				if( key == 'Cell_phone' || key == 'Home_phone' ){
					skip = phoneValid();
				}

				console.log('Here: '+fldName+'  :  '+document.getElementById(fldName).value );
				if( document.getElementById(key).value == "" && !skip ) {
				    if( key !== 'contains' )
						mess += fldName+" is empty <br />";
				}
			}
		}

		if( mess ){
			mess = "<b>Error: Required fields</b><br><br>"+mess;
			error_mess(mess);
			return false;
		}

	}



	function error_mess(mess){
		document.getElementById('error_mess').innerHTML = mess;
		document.getElementById('error_mess').style.display = 'block';
	}


	function clear_error_mess(){
		document.getElementById('error_mess').innerHTML = '';
		document.getElementById('error_mess').style.display = 'none';
	}

	function val_textarea(){
		var content = document.getElementById(id).value;
		if(content.length<1){
			window.alert ("This field can not be empty");
			return true;
		}else{
			return false;
		}
	}


	function val_terms(){
		if( !document.getElementById('agree_to_terms').checked ){
			mess ='<p style="text-align:left; font-weight:bold;">To proceed you must click on the check box to<br />acknowledge you have read and agree with<br />the membership oath and obligation of compliance.</p>';
			error_mess(mess);
			return false;
		}

//		if(termsWindow){
//			termsWindow.close();
//		}

//		document.getElementById('submit-message').innerHTML  = "<span style='background-color: yellow; color: red; font-size: 16px;'>We are processing your Membership Request through Pay Pal......</span><img src='/images/5.GIF' alt='Progress...' width='128' height='128'>";

	}

    function print_form(){
		alert("form to printer not active yet!");
		document.getElementById('submit-message').innerHTML  = "<span style='background-color: yellow; color: red; font-size: 16px;'>This form has been sent to your printer.......";
		return false;
		//window.print();
	}

	/* Field Sanitation */
	function clearPassField(obj){
	    var size = obj.size;
		var newInput = document.createElement('input');

		newInput.setAttribute('type','text');
		newInput.setAttribute('size', size );
		newInput.setAttribute('name', obj.getAttribute('name'));
		obj.parentNode.replaceChild(newInput,obj);
		newInput.focus();
	}

    function upperCase( obj ){
		var fld_name = obj.name;
		var fld_value = obj.value.toUpperCase();
		document.getElementById(fld_name).value = fld_value;
	}

    function phoneValid(){
		var cell = document.getElementById('Cell_phone').value.length;
		var home = document.getElementById('Home_phone').value.length;
		if( cell == 14 || home == 14 ){
            return true;
		}
        return false;
	}

    function checkPhone(){
		if( phoneValid() ){
			document.getElementById('Cell_phone').style.backgroundColor = "#fff";
			document.getElementById('Home_phone').style.backgroundColor = "#fff";
		}else{
			document.getElementById('Cell_phone').style.backgroundColor = "#FFFF99";
			document.getElementById('Home_phone').style.backgroundColor = "#FFFF99";
		}
	}

	function fldCheck(action, req, fldObj ){
		var fld_name = fldObj.name;
		var fld_value = fldObj.value;
		var isValid ='';

 		if( fld_name == "State"){
			// convert state to uppcase
			fld_value = fld_value.toUpperCase();
			document.getElementById(fld_name).value = fld_value;
		}

		isValid = doAction(action, 0, req, fld_name, fld_value );
		updateField( isValid, fldObj );
		return isValid;
	}

    function updateField( isValid, fldObj ){
		if( isValid != 'ok'){
			fldObj.value= '';
			fldObj.style.backgroundColor ="#FFFF99";
			// fldObj.style.borderStyle="solid";
			// fldObj.style.borderColor="red";
	    }else{
			isValid ='';
			fldObj.style.backgroundColor = "#fff";
			//fldObj.style.borderColor="green";
		}
	}


	function doAction(action, len, req, fld_name, fld_value ) {
		// alert( action+"\n"+len+"\n"+req+"\n"+fld_name+"\n"+fld_value);
		fld_value = fld_value.replace(/^\s+|\s+$/g,'');
		var date_regex = /^([0-9]){2}(\/){1}([0-9]){2}(\/)([0-9]){4}$/;   // DD/MM/YYYY
        var ss_regex = /^([0-9]){3}(\-){1}([0-9]){2}(\-)([0-9]){4}$/;   // nnn-nn-nnnn
		var email_regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;  // email address
		var alpha_numeric_regex = /^[\s\w.-]{1,40}$/;  // allowed characters: any word . -, ( \w ) represents any word character (letters, digits, and the underscore _ ), equivalent to [a-zA-Z0-9_]
		var num_regex = /^\d+$/; // numeric digits only
		var phone_regex = /^\(\d{3}\) \d{3}-\d{4}$/;  // (xxx) xxx-xxxx
		var alpha_regex = /^[A-Za-z\s,]{1,40}$/;  // any upper/lowercase characters between 6 to 40 characters in total
		var alpha_state_regex = /^(A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|PA|RI|S[CD]|T[NX]|UT|V[AT]|W[AIVY])$/; // Valid US states only;
		var fld_state = isFld_required();

		function isFld_required(){
		  var str=fld_value.replace(/^\s+|\s+$/g,''); // remove begining and trailing spaces only.
		  if ( (req==1 && fld_value==null ) || (req==1 && fld_value== 0 ) || (req==1 && str=="") ){
			  return true;
		  }else{
			  return false;
		  }
		}

		if( fld_state ){
		   //alert( fld_name+' state: '+fld_state )
		   if( action == 'N' ){
				return  fld_name+' is a required numeric field greater than zero.';
		   }else{
				return  fld_name+' is a required field';
		   }

		}

		var actions = {
			'E': function () {
			   if(!email_regex.test(fld_value) && fld_value ){
				  return fld_name+' [ '+fld_value+' ] is Not a valid e-mail address';
			   }
			   return 'ok';}, //fld_name+' : '+len+' : '+req

			'A': function () {
				//alert( "chk: "+action+"|"+len+"|"+req+" Fld_name: "+fld_name+"\n\nFld_value: "+fld_value )
				if(!alpha_regex.test(fld_value)  && fld_value  ){
				   return fld_name+' [ '+fld_value+' ] is Not a valid ';
				}
			   return 'ok';}, //fld_name+' Alpha: '+len+' : '+req

			'S': function () {
				if(!alpha_state_regex.test(fld_value)  && fld_value  ){
				   return fld_name+' [ '+fld_value+' ] is Not a valid ';
				}
				return 'ok';}, //fld_name+' Alpha: '+len+' : '+req

			'B': function () {
				//alert( "chk: "+action+"|"+len+"|"+req+" Fld_name: "+fld_name+"\n\nFld_value: "+fld_value )
				if(fld_name == 'Social'){
					if(!ss_regex.test(fld_value)  && fld_value  ){
					   return fld_name+' format is not nnn-nn-nnnn ';
					}
				}else{
					if(!alpha_numeric_regex.test(fld_value)  && fld_value ){
					   return fld_name+' [ '+fld_value+' ] is Not a valid: <b>B</b> ';
					}
				}
			    return 'ok';}, //fld_name+' Both: '+len+' : '+req

			'N': function () {
			   if( fld_value=="" ){  fld_value=0;}
			   if(!num_regex.test(fld_value) ){
				   return fld_name+' [ '+fld_value+' ] is Not a number';
			   }
			   return 'ok'; }, //fld_name+' Is_number: '+len+' : '+req

			'P': function () {
			   if(!phone_regex.test(fld_value)  && fld_value ){
					 return fld_name+' [ '+fld_value+' ] invalid phone number ';
			   }
				return 'ok'; }, //fld_name+' Phone: '+len+' : '+req

			'D': function () {
			   if(!date_regex.test(fld_value)  && fld_value ){
					 return fld_name+' [ '+fld_value+' ] invalid date format ';
			   }
			   return 'ok'; }, //fld_name+' Date: '+len+' : '+req

			'X': function () {
			   if( fld_value=="Select" && req==1 ){
				   return fld_name+' [ '+fld_value+' ] is Not valid';
			   }
			   return  'ok'; }, //fld_name+' Select: '+len+' : '+req

			'R': function () {
			   return  'ok'; }, //fld_name+' Radio: '+len+' : '+req

			'C': function () {
			   return 'ok'; }, //fld_name+' CheckBx: '+len+' : '+req


			'Z': function () {
			   return 'ok'; } //fld_name+' Any Z type: '+len+' : '+req
		};

		if (typeof actions[action] !== 'function') { return 'Action Error..'+action+' = '+ fld_name;}
		return actions[action]();

    }/* End of DoAction */



    /* trouble shooting functions */
	function showArray(Obj){
   		var displayArray = 'Array:\n';
		for ( var key in Obj ) {
			if (Obj.hasOwnProperty(key)){
				if( key !== 'contains' )
					displayArray +="\nKey: "+key+" = "+Obj[key];
			}
		}
        	// alert(displayArray);
        	console.log(displayArray);

	}
