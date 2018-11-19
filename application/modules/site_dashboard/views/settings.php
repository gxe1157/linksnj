<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  if( isset( $default['flash']) ) {
    echo $this->session->flashdata('item');
    unset($_SESSION['item']);
  }
?>

<style>
    .panel-custom > .panel-heading {
      color: #fff;
      background-color: #578EBE;
      border-color: #d6e9c6;
    }
</style>

<h2 style="margin-top: -5px;"><small><?= $default['page_title'] ?></small></h2>

<div class="row"> <!-- row0 -->
    <div class="col-md-4">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Company Address</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultCompanyAddress')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultCompanyAddress') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_address"
                               value="<?= $company_address ?>"
                               placeholder="Address1">
                    </div>

                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i> 
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_address2"
                               value="<?= $company_address2 ?>"
                               placeholder="Address2">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i> 
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_city"
                               value="<?= $company_city ?>"
                               placeholder="City">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i> 
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_state"
                               value="<?= $company_state ?>"
                               placeholder="State">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i> 
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_zip"
                               value="<?= $company_zip ?>"
                               placeholder="Zip">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-default"
                               name="company_location_info" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Company Contacts Info</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultfooterContacts')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultfooterContacts') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-phone" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_phone"
                               value="<?= $company_phone ?>"
                               placeholder="Phone">
                    </div>

                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-phone" style="position: absolute;top:10px;left:10px;"></i> 
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_fax"
                               value="<?= $company_fax ?>"
                               placeholder="Fax">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i> 
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_email"
                               value="<?= $company_email ?>"
                               placeholder="email">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i> 
                        <input type="text" style="padding-left:30px;"
                               class="form-control"
                               name="company_contact_email"
                               value="<?= $company_contact_email ?>"
                               placeholder="Send email from contact form to">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default"
                               name="company_contacts_info" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Company's Site Top - Footer Logos</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultSiteLogoPublish1')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultSiteLogoPublish') ?></div>
                <?php } ?>
                <img src="<?= base_url('attachments/site_logo/' . $siteLogo1) ?>" alt="Logo Top is deleted. Upload new!" class="img-responsive">
                <hr>
                <form name="logo-top" accept-charset="utf-8" method="post"
                      enctype="multipart/form-data" action="">
                    <input type="file" name="file[]" size="20" />
                    <input type="submit" value="Upload New"
                           name="uploadimage1" class="btn btn-default" />
                </form>
            </div>
        </div>
        <div class="panel panel-custom col-h">
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultSiteLogoPublish2')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultSiteLogoPublish') ?></div>
                <?php } ?>
                <img src="<?= base_url('attachments/site_logo/' . $siteLogo2) ?>" alt="Logo Footer is deleted. Upload new!" class="img-responsive">
                <hr>
                <form name="logo-footer" accept-charset="utf-8" method="post"
                      enctype="multipart/form-data" action="">
                    <input type="file" name="file[]" size="20" />
                    <input type="submit" value="Upload New"
                           name="uploadimage2" class="btn btn-default" />
                </form>
            </div>
        </div>        
    </div>
</div> <!-- //row0 -->

<div class="row"> <!-- row1 -->
    <div class="col-md-4">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Google Maps</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultGoogleMaps')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultGoogleMaps') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input class="form-control" placeholder="Direction: 42.676250, 23.371063" name="google_maps_geo" value="<?= $google_maps_geo ?>" type="text" style="margin-bottom:10px;">
                    <input class="form-control" placeholder="Api key" name="google_api_key" value="<?= $google_api_key ?>" type="text" style="margin-bottom:10px;">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Add google or other JavaScript to site</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('addJs')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('addJs') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <textarea class="form-control" style="margin-bottom:5px;"
                              name="add_javascript"
                              id="add_javascript" rows="4"><?= $add_javascript ?></textarea>
                    <button class="btn btn-default" value="" type="submit">
                        Add the code
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Face Book Pixle</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('addPixels')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('addPixels') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <textarea class="form-control" style="margin-bottom:5px;"
                              name="facebook_pixels"
                              id="facebook_pixels" rows="4"><?= $facebook_pixels ?></textarea>
                    <button class="btn btn-default" value="" type="submit">
                        Add the code
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> <!-- //row1 -->


<div class="row"> <!-- row2 Contact Us -->
    <div class="col-md-6">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Terms and Conditions</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultContactspage')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultContactspage') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <textarea class="form-control" name="terms_and_conditions"
                                  id="terms_and_conditions" rows="6"><?= $terms_and_conditions ?></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default"
                                value=""
                                type="submit">
                            Update <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-custom col-h">
            <div class="panel-heading">Legal Statement</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultfooterContacts')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultfooterContacts') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <textarea class="form-control" name="legal_statement"
                                  id="legal_statement" rows="6"><?= $legal_statement ?></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default"
                                value=""
                                type="submit">
                            Update <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- //row2 -->    
