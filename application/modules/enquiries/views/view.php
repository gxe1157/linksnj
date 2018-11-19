<?php
  $form_location = base_url().'comments/submit';

  if( isset( $default['flash']) ) {
      echo $this->session->flashdata('item');
      unset($_SESSION['item']);
  }

  foreach($query->result() as $row) {
      $view_url = base_url()."enquiries/view/".$row->id;
      $opened = $row->opened;
      if ($opened==1) {
        $icon = '<i class="icon-envelope"></i>';
      } else {
        $icon = '<i class="icon-envelope-alt" style="color: orange;"></i>';
      }

      if ($row->sent_by==0) {
        $sent_by = "Admin";
      } else {
        $sent_by = $username;
      }

      $urgent = $row->urgent;
      $ranking = $row->ranking;
      $date_sent = convert_timestamp($row->date_created, 'full');

      $subject = $row->subject;
      $message = $row->message;
      $ranking = $row->ranking;
  }
?>

<style>

.clearfix {
  clear: both;
}
.showbox {
  border: 2px #000 solid;
}

.clearfix {
  clear: both;
}

select {
  height: 35px;
  /* in ie7, the height of the select element cannot be changed by height, only font-size */

  *margin-top: 4px;
  /* for ie7, add top margin to align select with labels */

  line-height: 30px;
  font-size: 15px;
  font-family: "segoe ui","helvetica neue", arial, helvetica, geneva, sans-serif;
  color: #3c3e43;

  display:-webkit-box;
  display:-moz-box;
  display:box;

  -webkit-border-radius: 3px;
}

.ticketgeneraltitlecontainer {
  padding: 14px 10px 10px;
}

.ticketgeneraltitle {
  color: #3c3e43;
  font-size: 26px;
  padding: 0px 0 0px 0px;
  font-weight: 300;
  line-height: 32px;
}

.ticketratings {
  padding: 6px 8px 5px 10px;
  font-size: 11px;
  color: #3c3e43;
}

.ticketrating {
  display: inline-block;
  margin-right: 12px;
}

.ticketratingtitle {
  display: inline;
  float: left;
  margin-right: 5px;
  color: #666;
  font-size: 14px;
}

.ticketgeneralinfocontainer {
  /* ok */
  padding: 0 10px;
  font-size: 13px;
  color: #666;
}


.ticketpostcontainer {
  background-color: #ededef;
  margin: 0 0 20px 0;
  border: 1px solid #ddd;
  position: relative;
}

.ticketpostbar {
  width: 224px;
  float: left;
  padding: 10px;
}

.ticketpostbarbottom {
  position: absolute;
  bottom: 0px;
  left: 0px;
  width: 240px;
  border-top: 1px solid #ddd;
}

.ticketpostbarname {
  font-size: 21px;
  color: #3c3e43;
  font-weight: 300;
  margin: 6px 0;
}

.ticketpostbardesignation {
  color: #999;
  margin: 6px 0;
  font-size: 14px;
}


.ticketpostclearer {
  clear: both;
}

.ticketpostcontents {
  margin-left: 238px;
  background: #fff;
  height: auto;
  position: relative;
  height: auto;
}

.ticketpostcontentsbar {
  margin-bottom: 5px;
  border-bottom: 1px solid #eee;
  padding: 10px 20px;
}

.ticketpostcontentsbar .ticketbarcontents {
  color: #999;
  font-size: 14px;
}


.ticketpostcontentsdetails {
  padding: 10px 0 0 0;
}

.ticketpostcontentsholder {
  padding: 0 0 5px 20px;
  word-break: break-word;
}

.ticketpostcontentsdetailscontainer {
  font-size: 15px;
  color: #3c3e43;
  margin-bottom: 15px;
  cursor: text;
  line-height: 1.5;
  word-wrap: break-word;
}
</style>    

  <?php
      $data['message_hdr'] = "Post Reply";
      $data['update_id']   = $update_id;
      $data['error_mess']  = validation_errors("<p style='color: red;'>", "</p>");
      $this->load->view('enquiries/message_modal', $data);
  ?>

  <!-- boxcontainer -->
  <div class="row">
    <div class="col-md-12">
    <!-- row -->
    <div class="row"> 
        <div class="col-md-12" style="background-color: #EDEDEF; border: 1px solid #ddd;">
              <div class="ticketgeneraltitlecontainer">
              <div class="ticketgeneraltitle">Can not login into my account</div>
              <div class="ticketgeneralinfocontainer" style="text-align: right;">
                <span>Created: 08 March 2018 10:15 AM</span>
                <span style="margin-left: 10px;"> Updated: 08 March 2018 11:24 AM</span>
              </div>
            </div>
        </div>
        <div class="col-md-12" style="background-color:  #d25a68; padding: 10px; color: #fff;
         ">
          <div class="col-md-4 col-sm-4 col-xs-5">
            <div>MESSAGE</div>
            <div>#KJJ-847-87242 [ <?= $default['page_header'] ?> ]</div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4">
            <div>DEPARTMENT</div>
            <div>Technical Support</div>
          </div>
          <div class="col-md-2">
              <select name="ticketstatusid" style="max-width: 100%;">
                <option value="1">Open</option>
                <option value="2">On Hold</option>
                <option value="3" selected>Awaiting reply</option>
                <option value="4">Closed</option>
              </select>
          </div>
          <div class="col-md-2">
              <select name="ticketpriorityid" style="max-width: 100%;">
                  <option value="1">Low</option>
                  <option value="2">Medium</option>
                  <option value="3" selected>High</option>
              </select>                          
          </div>
        </div>
    </div><!--// row -->

    <div class="row"><!-- ticketpostcontainer -->
        <div style="padding: 10px 0px;">                      
           <!-- Button trigger modal -->
           <button type="button"
                   class="btn btn-primary tab-button"
                   data-toggle="modal"
                   data-target="#replyModal">
              Post Reply
           </button>

          <a href="<?= base_url() ?>enquiries/inbox" >
             <button type="button" class="btn btn-default tab-button">Cancel</button>
           </a>

        </div>

        <div class="ticketpostcontainer">
          <div class="ticketpostbar">
            <div class="ticketpostbarname">Evelio Velez</div>
            <div class="ticketpostbardesignation">Owner</div>
          </div>

          <div class="ticketpostcontents">
            <div class="ticketpostcontentsbar">
              <div class="ticketbarcontents">Posted on: 08 March 2018 10:15 AM</div>
            </div>

            <div class="ticketpostcontentsdetails">
              <div class="ticketpostcontentsholder">
                <div class="ticketpostcontentsdetailscontainer">Hi <br /><Br />
                  I can not log into my email accounts for <a href="http://www.mailers.com" target="_blank">www.mailers.com</a><br />
                  I can not log into my cpanel for <a href="http://www.mailers.com" target="_blank">www.mailers.com</a><br />
                  I can log log into my WHM as root.<br /><br />
                  I am down!<br /><br />
                  userid : root<br />
                  pswrd: EvelioMatt5767<br /><br />
                  Evelio<br />
                </div>  
              </div>
            </div>
          </div>
          <div class="ticketpostclearer"></div>
        </div><!-- // ticketpostcontainer -->

        <div class="ticketpostcontainer">
          <div class="ticketpostbar">
            <div class="ticketpostbarname">Evelio Velez</div>
            <div class="ticketpostbardesignation">Owner</div>
          </div>

          <div class="ticketpostcontents">
            <div class="ticketpostcontentsbar">
              <div class="ticketbarcontents">Posted on: 08 March 2018 10:15 AM</div>
            </div>

            <div class="ticketpostcontentsdetails">
              <div class="ticketpostcontentsholder">
                <div class="ticketpostcontentsdetailscontainer">Hi <br /><Br />
                  I can not log into my email accounts for <a href="http://www.mailers.com" target="_blank">www.mailers.com</a><br /><br />
                  Evelio<br />
                </div>  
              </div>
            </div>
          </div>
          <div class="ticketpostclearer"></div>
        </div><!-- // ticketpostcontainer -->

      </div><!-- // row - ticketpostsholder -->

    </div><!-- // col-md-12 -->      
  </div><!-- // row - boxcontainer -->

<?php
// echo Modules::run('comments/_draw_comments', 'e', $update_id);