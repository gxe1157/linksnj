<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_session
{
        public function __construct()
        {
                
        }

        public function __get($property)
        {
                if ( ! property_exists(get_instance(), $property))
                {
                        show_error('property: <strong>' .$property . '</strong> not exist.');
                }
                return get_instance()->$property;
        }
        
        public function validate()
        {
               if (in_array($this->router->class, array("auth"))) // login controller
                {
                    // quit('validate .....');
                    return;
                }
                if ( ! $this->ion_auth->logged_in())
                {
                    //redirect in login
                    redirect('auth/login', 'refresh');
                }
        }



}