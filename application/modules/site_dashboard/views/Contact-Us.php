
<style>
 #success_message{
     display: none;
 }

</style>

<div  class="col-md-12 this_page">
  <div style="text-align: center;">
      <h5><b>Company</b></h5>
      <p style="margin-top: -8px; margin-bottm: 5px;">195 Some Street, City St Zip<br />
       Phone: 973-111-111&nbsp;&nbsp;&nbsp;&nbsp; Fax: 973-222-222
      </p>
  </div>

  <form class="form-horizontal" action="<?= base_url() ?>site_dashboard/contactus_ajaxPost" method="POST" id="contact_form">
    <fieldset>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label">First Name</label>
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-user fa-lg" aria-hidden="true"></i></span>
      <input  name="first_name" placeholder="First Name" class="form-control"  type="text">
        </div>
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" >Last Name</label>
        <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-user fa-lg" aria-hidden="true"></i></i></span>
      <input name="last_name" placeholder="Last Name" class="form-control"  type="text">
        </div>
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label">Phone #</label>
        <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></span>
      <input name="phone" placeholder="(845)555-1212" class="form-control" type="text">
        </div>
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label">E-Mail</label>
      <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></span>
          <input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
        </div>
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label">Confirm E-Mail</label>
        <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></span>
            <input name="confirmEmail" placeholder="Confirm E-Mail Address" class="form-control"  type="text">
        </div>
      </div>
    </div>

    <!-- Text area -->

    <div class="form-group">
      <label class="col-md-4 control-label">Message</label>
        <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil fa-2x"></i></span>
            	<textarea class="form-control" name="comment" placeholder="Enter Message.....  "></textarea>
      </div>
      </div>
    </div>

    <!-- Success message -->
    <div class="col-md-4" >&nbsp;</div>
    <div class="col-md-4 alert alert-success" role="alert" id="success_message"> Success 
    <i class="glyphicon glyphicon-thumbs-up"></i><br>Thanks for contacting us, we will get back to you shortly.</div>

    <!-- Button -->
    <div class="form-group">
      <label class="col-md-4 control-label"></label>
      <div class="col-md-4"><button type="submit" class="btn btn-warning btn-block" id="submission">Send 
            <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>

      </div>
    </div>

    </fieldset>
  </form>
  </div>
</div><!-- /.container -->
