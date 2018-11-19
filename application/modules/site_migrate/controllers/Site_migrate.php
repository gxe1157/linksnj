<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Site_migrate extends MX_controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }

  public function up($table_name, $field_list)
  {
    $fields = $this->build_obj($field_list);

    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('id',TRUE);
    $this->dbforge->create_table($table_name,TRUE); 

      // Alter columns for photo and geo_codes
      $modify_fields = [];
      // lat DECIMAL(10, 8) NOT NULL, lng DECIMAL(11, 8) NOT NULL
      if( isset($fields['latX']) ){
          $modify_fields['latX'] =
           array('name' => 'latX', 'type' => 'decimal', 'constraint' => '10,8', 'unsigned' => FALSE);
      }

      if( isset($fields['longY']) ){
          $modify_fields['longY'] =
           array( 'name' => 'longY', 'type' => 'decimal', 'constraint' => '11,8', 'unsigned' => FALSE);
      }
      if( isset($fields['photos']) ){
          $modify_fields['photos'] = array( 'name' => 'photos', 'type' => 'TEXT' );
      }
      if( count($modify_fields) > 0 )
        $this->dbforge->modify_column($table_name, $modify_fields);
  }
 
  public function down($table_name)
  {
    $this->dbforge->drop_table($table_name, TRUE);
  }



/* ========================================
   Private functions
   ======================================== */
  private function build_obj($field_names)
  {
    $output_obj['id'] = array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
    );
    // $output_obj['source'] = array(
    //     'type' => 'VARCHAR',
    //     'constraint' => 30,
    //     'unsigned' => FALSE
    // );
    $output_obj['county_list'] = array(
        'type' => 'text',
        'constraint' => null,
        'unsigned' => FALSE
    );

    foreach ( $field_names as $key => $value ) {
      // echo $key." => ".$value."<br>";
      list($type, $constraint)  = $this->what_type($value);     
      $output_obj[ $value ] = array(
          'type' => $type,
          'constraint' => $constraint,
          'unsigned' => is_numeric($value) ? TRUE : FALSE
        );
    }
    return $output_obj;
  }

  private function what_type( $value ){
    if( is_numeric($value) ) {
        $type = is_float($value) ?  'DECIMAL' : 'INT';  
        $constraint =  is_float($value) ?  '10,2' : '11';    
    } else {
        $type = strlen($value) > 250 ?  'TEXT' : 'VARCHAR'; 

        $str_length = strlen ( $value );
        if( $str_length <50 ) { $constraint = 50; }
        elseif( $str_length >=50 and $str_length<100 ) { $constraint = 100; }
        elseif( $str_length >=100 and $str_length<250 ){ $constraint = 250; }
        else {$constraint = null; }
    }
    return [ $type, $constraint];
  }

}


// INSERT INTO `table2` (`field_name2`) SELECT `field_name` FROM `table1`

// INSERT INTO `table1` (`C`,`D`,`E`,`G`,`J`) VALUES
//      (SELECT `C`,`D`,`E`,`G`,`J` FROM `table2` WHERE 
//      `table1`.`A` = `table2`.`A`);