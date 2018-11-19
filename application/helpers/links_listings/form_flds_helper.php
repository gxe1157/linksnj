<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* site_user.php */

if ( ! function_exists('get_fields'))
{
  function get_fields( )
  {

      $site_user_rules = array(
            array(
              'field' => 'agent_id',
              'label' => 'Agent Assigned',
              'rules' => 'required',
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'select'
            ),
            array(
              'field' => 'listingid',
              'label' => 'Property ID',
              'rules' => 'required|is_natural|is_unique[links_listings.listingid]',
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'date_listed',
              'label' => 'Date Listed',
              'rules' =>'required',
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' => 'dates'
            ),
            array(
              'field' => 'address',
              'label' => 'Address',
              'rules' =>'required|min_length[3]|max_length[100]',
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'city',
              'label' => 'City',
              'rules' =>'required',
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'state',
              'label' => 'State',
              'rules' =>'required',
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'zip',
              'label' => 'Zip Code',
              'rules' =>'required|is_natural|min_length[5]|max_length[5]',
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'price',
              'label' => 'Price',
              'rules' => 'required|is_natural',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'year_built',
              'label' => 'Year Built',
              'rules' => 'required|is_natural',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'rooms',
              'label' => 'Total Rooms',
              'rules' => 'required|is_natural',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'bedrooms',
              'label' => 'Bed Rooms',
              'rules' => 'required|is_natural',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'bathrooms',
              'label' => 'Bath Rooms',
              'rules' => 'required|is_natural',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'description',
              'label' => 'Description',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'textarea'),
            array(
              'field' => 'garage',
              'label' => 'Garage',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'Detached, Attached, Garage Opener, 1 car, 2 car',
              'input_type' =>'textarea'),
            array(
              'field' => 'exterior',
              'label' => 'Exterior',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'Vinyl, Brick, Stucco',
              'input_type' =>'text'),
            array(
              'field' => 'basement',
              'label' => 'Basement',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'Full, Crawl Space, Finished, Baths',
              'input_type' =>'text'),
            array(
              'field' => 'fireplace',
              'label' => 'Fireplace',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'heat',
              'label' => 'Heat',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'laundry',
              'label' => 'Laundry',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'pets',
              'label' => 'Pets',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'For Rentals, Communities',
              'input_type' =>'text'),
            // array(
            //   'field' => 'virtual_tours',
            //   'label' => 'Virtual Tours',
            //   'rules' => 'required',    
            //   'icon'  => 'list-alt',
            //   'placeholder'=>'',
            //   'input_type' =>'text'),
            // array(
            //   'field' => 'floor_plan',
            //   'label' => 'Floor Plan',
            //   'rules' => 'required',    
            //   'icon'  => 'list-alt',
            //   'placeholder'=>'',
            //   'input_type' =>'text'),                          
            array(
              'field' => 'flood_plain',
              'label' => 'Flood Plain',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),
            array(
              'field' => 'association',
              'label' => 'Association',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'',
              'input_type' =>'text'),                          
            array(
              'field' => 'lifestyle',
              'label' => 'Life Style',
              'rules' => 'required',    
              'icon'  => 'list-alt',
              'placeholder'=>'Close To School, Close To Shopping, Close TO Transportation, Close To Worship',
              'input_type' =>'textarea'),
            array(
              'field' => 'youtube',
              'label' => 'YouTube',
              'rules' => 'max_length[100]',    
              'icon'  => 'list-alt',
              'placeholder'=>'Close To School, Close To Shopping, Close TO Transportation, Close To Worship',
              'input_type' =>'textarea'),
      );

    return $site_user_rules;

  }// get_fields

 // Property ID
 // Agent - Dropdown
 // Date Listed
 // Address
 // Price
 // Year Built
 // Total Rooms
 // Bedrooms
 // Bathrooms
 // Description
 // Garage - Detached, Attached, Garage Opener, 1 car, 2 car
 // Exterior - Vinyl, Brick, Stucco
 // Basement - Full, Crawl Space, Finished, Baths
 // Fireplace
 // Heat
 // Laundry
 // Pets (For Rentals, Communities)
 // Virtual Tour - Upload Button
 // Floor Plan - Upload Button
 // Flood Plain
 // Associaltion
 // Lifestyle - Close To School, Close To Shopping, Close TO Transportation, Close To Worship

} // endif

