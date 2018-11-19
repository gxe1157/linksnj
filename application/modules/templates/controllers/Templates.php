<?php
class Templates extends MX_Controller
{


function __construct()
{
    parent::__construct();
//    echo uri_string();
}


function public_main( $data = array() )
{
    $data['title']       = $data['page_title'];
    $data['contents']    = $data['page_url']  ? :'main';

    if( !isset($data['view_module']) ){
        $data['view_module']= $this->uri->segment(2) =='' ?
                         'partials' : $this->uri->segment(1);
    }
    // checkArray($data,0);
    $this->load->view('public_main/html_master_view', $data);
}


function admin( $data = array() )
{
    if( !isset( $data['view_module'] ) )
        $data['view_module']= $this->uri->segment(1);

    $data['admin_user'] = $this->ion_auth->user()->row();
    
    $this->load->view('admin/admin', $data);
}



} // end Templates
