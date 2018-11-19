
<?php
  $form_location = base_url()."enquiries/create/".$update_id;
  if( isset( $default['flash']) ) {
      echo $this->session->flashdata('item');
      unset($_SESSION['item']);
  }
?>

<div class="well  well-sm">
  <h2 style="margin-top: 0px;"><small> <?= $headline ?></small></h2>    
</div>  

<div class="row">
  <div class="col-md-12">
      <form id="myForm" class="form-horizontal" method="post" action="<?= $form_location ?>" >
        <fieldset>          
        <div class="col-md-12 ">
          <?php
            $disable_submit = '';
            for($i = 0; $i < count($columns); $i++ ) {
              $data['input_type'] = $columns[$i]['input_type'];           
              $data['label'] = $columns[$i]['label'];
              $data['field_name'] = $columns[$i]['field'];
              $data['placeholder'] = $columns[$i]['placeholder'];           
              $data['value'] = $columns[$i]['value'];
              $data['icon'] = $columns[$i]['icon'];

              switch ($data['input_type']) {
                  case "search":
                    if( $reply_to ) {
                        $data['value'] = $reply_to;
                        // $data['disabled'] = 'disabled';                        
                        $this->load->view( 'default_module/partial_text', $data);   
                    } else {
                        $this->load->view( 'default_module/partial_search', $data);   
                    }

                  break;

                  case "select":
                    $data['options'] = $options;
                    $this->load->view( 'default_module/partial_dropdown', $data);   
                      break;

                  case "textarea":
                  $this->load->view( 'default_module/partial_textarea', $data);   
                  break;

                  default:
                    $this->load->view( 'default_module/partial_text', $data);
              }
              $data['disabled'] = '';              
            } 
          ?>      
          </div>          

          <div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-3">
                    <ul class="list-inline">
                      <li><button type="submit" class="btn btn-primary"
                            name="submit" value="Submit">Submit</button></li>                                                              
                      <li><button type="submit" class="btn" 
                            name="submit" value="Cancel">Cancel</button></li>
                  </ul>
                </div>  


        </fieldset>
      </form>   
  </div><!--/span-->

</div><!--/row-->