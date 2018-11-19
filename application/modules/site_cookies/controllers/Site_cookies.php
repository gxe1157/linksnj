<?php
class Site_cookies extends MX_Controller 
{

function __construct() {
parent::__construct();
}

function test()
{
    echo anchor('site_cookies/test_set', 'Set The Cookie');
    echo "<hr>";
    echo anchor('site_cookies/test_destroy', 'Destroy The Cookie');

    $user_id = $this->_attempt_get_user_id();

    if (is_numeric($user_id)) {
        echo "<h1>You are user $user_id</h1>";
    }
}

function test_set()
{
    $user_id = 88;
    $this->_set_cookie($user_id);
    echo "The cookie has now been set.<br>";

    echo anchor('site_cookies/test', 'Get The Cookie');
    echo "<hr>";
    echo anchor('site_cookies/test_destroy', 'Destroy The Cookie');
}

function test_destroy()
{
    $this->_destroy_cookie();
    echo "The cookie has been destroyed<br>";

    echo anchor('site_cookies/test', 'Attempt to get the cookie');
    echo "<hr>";
    echo anchor('site_cookies/test_set', 'Set The Cookie');
}

function _set_cookie($user_id)
{
    $this->load->module('site_security');
    $this->load->module('site_settings');

    $nowtime = time();
    $one_day = 86400;
    $two_weeks = $one_day*14;
    $two_weeks_ahead = $nowtime+$two_weeks;

    $data['cookie_code'] = $this->site_security->generate_random_string(128);
    $data['user_id'] = $user_id;
    $data['expiry_date'] = $two_weeks_ahead;
    $this->model_name->insert($data);

    $cookie_name = $this->site_settings->_get_cookie_name();
    setcookie($cookie_name, $data['cookie_code'], $data['expiry_date']);
    $this->_auto_delete_old();
}

function _attempt_get_user_id()
{
    //check to see if the user has a valid cookie and if so, figure out the user_id from the cookie
    $this->load->module('site_settings');
    $cookie_name = $this->site_settings->_get_cookie_name();

    //check for cookie
    if (isset($_COOKIE[$cookie_name])) {
        $cookie_code = $_COOKIE[$cookie_name];

        //the have the cookie but is it still on the table?
        $query = $this->model_name->get_where_custom('cookie_code', $cookie_code);
        $num_rows = $query->num_rows();

            if ($num_rows<1) {
                $user_id = '';
            }

        foreach($query->result() as $row) {
            $user_id = $row->user_id;
        }
    } else {
        $user_id = '';
    }

    return $user_id;
}

function _destroy_cookie()
{
    $this->load->module('site_settings');
    $cookie_name = $this->site_settings->_get_cookie_name();

    if (isset($_COOKIE[$cookie_name])) {
        $cookie_code = $_COOKIE[$cookie_name];
        $mysql_query = "delete from site_cookies where cookie_code=?";
        $this->db->query($mysql_query, array($cookie_code));
    }

    setcookie($cookie_name, '', time() - 3600);
}

function _auto_delete_old()
{
    $nowtime = time();
    $mysql_query = "delete from site_cookies where expiry_date<$nowtime";
    $query = $this->model_name->custom_query($mysql_query);
}

}