<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Site_backup extends MX_Controller
{
    /* model name goes here */
    var $mdl_name = '';
    var $main_controller = 'site_backup';

    function __construct() {
        parent::__construct();

        ini_set('max_execution_time', 300);  // 5 min max        
        ini_set('memory_limit', '1024M'); // or you could use 1G
        //ini_set('memory_limit', '512M'); // or you could use 1G        
    }


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
  ==================================================== */

function do_backup()
{
    $timedate = time();
    $date = date( 'Y\-m\-d', $timedate ); 
    $this->database_backup($date);
    // $this->project_backup($date);

    // send email 

}

function _remove_more_than_five($dir_path, $database)
{
    if ($handle = opendir('mysql_backup/')) {
        $file_names = [];
        while (false !== ($entry = readdir($handle))) {
            $temp_array = [];
            if ($entry != "." && $entry != "..") {
                $pos = strpos($entry,$database);
                if ($pos !== false)
                    array_push($file_names,$entry);
            }
        }
        closedir($handle);

        if(count($file_names)>5)
                array_shift($stack);
        // dd($file_names);
        return $file_names;
    }        
}

function database_backup($date)
{
    $this->benchmark->mark('start');    

    $this->load->helper('file');
    $this->load->dbutil();

    // Backup your entire database and assign it to a variable
    $database = $this->db->database;
    $dir_path = 'mysql_backup/';
    
    $this->_remove_more_than_five($dir_path, $database);

    $table =array(
            'geocodes',
            'rets_mls',
            'rets_res',
            'rets_res_ct',
            'rets_res_sold',
            'rets_res_sold_ct',
            'rets_rnt',
            'rets_rnt_ct',
            'rets_rnt_sold',
            'rets_rnt_sold_ct',
            'country', 
            'enquiries',
            'groups',
            'login_attempts',
            'site_admin_emails',
            'site_admin_terms_conditions',
            'site_counter',
            'site_settings',
            'site_social_media',
            'site_weekly_ads',
            'site_weekly_ads_placed',
            'users',
            'users_data',
            'users_fun_facts',
            'users_groups',
            'webpages'
        );            // Array of tables to backup.

    $prefs =  array(
        'tables'        => array(),            // Array of tables to backup.
        'ignore'        => array(),            // List of tables to omit from the backup
        'format'        => 'zip',              // gzip, zip, txt
        'filename'      => $database.'.sql',   // File name - NEEDED ONLY WITH ZIP FILES
        'add_drop'      => TRUE,               // Whether to add DROP TABLE statements to backup file
        'add_insert'    => TRUE,               // Whether to add INSERT data to backup file
        'newline'       => "\n"                // Newline character used in backup file
    );

    // @ $backup = & $this->dbutil->backup($prefs);
    $backup = & $this->dbutil->backup($prefs);

    $this->benchmark->mark('finish');
    // echo $this->benchmark->elapsed_time('start', 'finish');        

    write_file($dir_path.$database.'_backup_'.$date.'.zip', $backup);

    // Load the download helper and send the file to your desktop
    $this->load->helper('download');
    // force_download( $database.'_backup_'.$date.'.zip', $backup);
}


function project_backup($date)
{
    $this->load->library('zip');
    $this->zip->read_dir(FCPATH, false) ;
    $this->zip->archive('mysql_backup/project_'.$date.'.zip');
    // $this->zip->download('mysql_backup/project_'.$date.'.zip');
}


public function db_backup()
{

    $DBUSER=$this->db->username;
    $DBPASSWD=$this->db->password;
    $DATABASE=$this->db->database;

    $filename = $DATABASE . "-" . date("Y-m-d_H-i-s") . ".sql.gz";
    $mime = "application/x-gzip";

    header( "Content-Type: " . $mime );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

    $cmd = "mysqldump -u $DBUSER --password=$DBPASSWD $DATABASE | gzip > $DATABASE";   
    // $cmd = "mysqldump -u $DBUSER --password=$DBPASSWD --no-create-info --complete-insert $DATABASE | gzip --best";

    passthru( $cmd );

    exit(0);
}

/* ===============================================
    Call backs go here...
  =============================================== */


/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
