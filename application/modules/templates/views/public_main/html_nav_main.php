<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>    <!--start header section header v2-->    <header id="header-section" class="header-section-2">      <div class="header-top">        <div class="container w-100">          <div class="row">            <div class="col-sm-3 col-xs-12">              <div class="hidden-sm hidden-xs">                <a href="<?= base_url() ?>">                  <img src="<?= base_url() ?>/public/images/Links-logo.png" alt="logo">                </a>              </div>            </div>            <div class="col-sm-9 col-xs-12">              <div class="header-nav">                <nav class="navi main-nav text-right">                <ul>                    <li>                        <?php                        if ($this->ion_auth->logged_in())                        {                            echo '<a href="'.base_url(). 'profile">';                             // get just username                              $email = $this->session->userdata( 'email' );                                  if( !empty($email)) {                                        $arr = explode("@", $email, 2);                                        echo 'Hi, ' . $arr[0];                                  }                            echo '</a>';                        }                        else                        {                            echo '<a href="'.base_url(). 'signin">Login / Register</a>';                        }                        ?>                        <?php                        if ($this->ion_auth->logged_in()) { ?>                        <ul class="sub-menu">                            <li id="menu-item-1336" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1336 has-child">                                <a href="<?php base_url()?>profile">My Account</a>                            </li>                            <li id="menu-item-1336" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1336 has-child">                        	    <a href="<?php base_url() ?>favorites">Favorited Properties</a>                            </li>                            <li id="menu-item-1336" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1336 has-child">                                <a href="#">Saved Searches</a>                            </li>                        	<li id="menu-item-1336" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1336 has-child">                        	    <a href="#">Settings</a>                            </li>                        	<li id="menu-item-1338" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1338 has-child">                        	    <a href="<?php base_url() ?>signout">Sign out</a>                            </li>                        </ul>                        <?php } ?>                    </li>                </ul>              </nav>                <nav class="navi main-nav text-right">                  <ul>                      <li>                          <a href="                        <?= base_url() ?>buy-a-home">                              Buy                          </a>                      </li>                      <li>                          <a href="                        <?= base_url() ?>rentals">                              Rent                          </a>                      </li>                      <li>                         <a href="                        <?= base_url() ?>contactus">                              Sell                          </a>                      </li>                    <li>                      <a href="                        <?= base_url() ?>agents">Agents                      </a>                    </li>                    <li>                      <a href="                        <?= base_url() ?>blogs">Blog                      </a>                    </li>                    <!-- more  -->                    <li>                      <a href="#" data-transition="ease" href="#" role="button" id="popout-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                        More <i id="menu-button" class="ml-16 fas fa-bars"></i>                      </a>                    </li>                  </ul>                </nav>              </div>            </div>          </div>        </div>      </div>    </header>    <div class="header-mobile visible-sm visible-xs">        <div class="container">            <!--start mobile nav-->            <div class="mobile-nav">                <span class="nav-trigger"><i class="fas fa-bars"></i></span>                <div class="nav-dropdown main-nav-dropdown"></div>            </div>            <!--end mobile nav-->            <div class="header-logo">                <a href="<?= base_url() ?>"><img src="<?= base_url() ?>public/images/links-residential-logo.svg" alt="logo"></a>            </div>        </div>    </div>    <!--end header section header v2-->    <!-- Banner Start -->        <?php $this->load->view('html_search'); ?>    <!-- Banner End -->