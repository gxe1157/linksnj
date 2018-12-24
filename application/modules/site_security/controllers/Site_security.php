<?php
class Site_security extends MX_Controller 
{

function __construct() {
parent::__construct();
}

function index(){
    quit('site_security');

}

function _user_logged_in()
{
    $user = $this->ion_auth->user()->row();
    return $user->id;    
}

function not_allowed() 
{
    echo "You are not allowed to be here.";
}

function generate_random_string($length) {
    $characters = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function _hash_string($str)
{
    $hashed_string = password_hash($str, PASSWORD_BCRYPT, array(
        'cost' => 11
    ));
    return $hashed_string;
}

function _verify_hash($plain_text_str, $hashed_string)
{
    $result = password_verify($plain_text_str, $hashed_string);
    return $result; //TRUE or FALSE
}

function _encrypt_string($str)
{
    $this->load->library('encryption');
    $encrypted_string = $this->encryption->encrypt($str);
    return $encrypted_string;
}

function _decrypt_string($str)
{
    $this->load->library('encryption');
    $decrypted_string = $this->encryption->decrypt($str);
    return $decrypted_string;
}


}