<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Extension extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->lang->load('extension', setting_all('language'));
    $this->load->model('extension_model', 'em');
  }

  /**
   * This function is used to load page view
   * @return Void
   */
  public function index(){
	  $this->load->view("include/header");
    $this->load->view("index");
    $this->load->view("include/footer");
  }

  public function install() {
    if(isset($_FILES['extn_file']) && $_FILES['extn_file']['error'] == 0) {
      $file_path = realpath(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/assets/tmp/';
      @mkdir($file_path, 0777, true);
      $f_name                  = strtolower(str_replace(' ', '_', $_FILES['extn_file']['name']));
      $config['upload_path']   = 'assets/tmp/';
      $config['allowed_types'] = 'rar|zip';
      $config['file_name']     = $f_name;
      $this->load->library('upload', $config);
      if(!$this->upload->do_upload('extn_file')) {
        $art_msg['msg'] = $this->upload->display_errors(); 
        $art_msg['type'] = 'warning'; 
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect( base_url().'extension');
      } else {
        /**** Extract file ****/
        $zip = new ZipArchive;
        $ext = pathinfo($file_path . $f_name, PATHINFO_EXTENSION);
        if ($zip->open($file_path . $f_name, ZipArchive::CREATE) === TRUE) {
          $zip->extractTo($file_path);
          $zip->close();

          /*----------  Check folder exist  ----------*/
          $dir = scandir($file_path, 1);
          foreach ($dir as $value) {
            if(is_dir($file_path . $value)) {
              $dir_in = scandir($file_path . $value, 1);
              $k = array_search('configuration', $dir_in);
              if($k !== '') {
                if(file_exists($file_path . $value . '/configuration/configuration.xml')) {
                  $xml = $this->parse_xml($file_path . $value . '/configuration/configuration.xml');
                  $this->check_installed($xml->name);
                  if($xml->options->databse == 1) {
                    $db_file = $file_path . $value . '/configuration/db/database.sql';
                    $db_operation = $this->import_database($db_file);
                    if($db_operation) {
                      $this->removeDirectory($file_path . $value . '/configuration/');
                      $dst = realpath(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/application/modules/';
                      $this->recurse_copy($file_path . $value ,$dst . '/' . $xml->name);
                      $this->removeDirectory($file_path);
                      $wpb_c_modules_data = array(
                            "menu_name"   => $xml->name,
                            "icon"        => $xml->options->menu_con,
                            "slug"        => $xml->name,
                            "module_name" => $xml->name,
                            "status"      => 1
                      );
                      $this->em->insertRow('wpb_c_modules', $wpb_c_modules_data);

                      $wpb_extension_data = array(
                            "name"      => $xml->name,
                            "db_tables" => $xml->options->databse_tb_name,
                            "status"    => 1,
                            "inst_date" => date('Y-m-d H:i:s')
                      );

                      if(isset($xml->rm_queries) && $xml->rm_queries != '') {
                        $wpb_extension_data['rm_queries'] = $xml->rm_queries;
                      }

                      $this->em->insertRow('wpb_extension', $wpb_extension_data);
                      $this->setPermissions($xml->name);

                      $art_msg['msg'] = lang('extension_installed_successfully'); 
                      $art_msg['type'] = 'success'; 
                      $this->session->set_userdata('alert_msg', $art_msg);
                      redirect( base_url().'extension');             
                    }
                  }
                } else {
                  $this->removeDirectory($file_path);
                  $art_msg['msg'] = lang('configuration_file_not_exist'); 
                  $art_msg['type'] = 'warning'; 
                  $this->session->set_userdata('alert_msg', $art_msg);
                  redirect( base_url().'extension');  
                }
              }
            }
          }
        } else {
          $this->removeDirectory($file_path);
          $art_msg['msg'] = lang('unable_to_extract_file'); 
          $art_msg['type'] = 'warning'; 
          $this->session->set_userdata('alert_msg', $art_msg);
          redirect( base_url().'extension');
        }
      }
    }
  }

  public function setPermissions($name) {
    //$name = 'todo';
    $per = $this->em->get_data_by('permission', '', '');
    if(is_array($per) && !empty($per)) {
      foreach ($per as $perkey => $pervalue) {
        $rec = json_decode($pervalue->data, 1);
        $name = (string) $name;
        $rec[$name] = $name;
        $perdata = array("data" => json_encode($rec));
        $this->em->updateRow('permission', 'id', $pervalue->id, $perdata);
      }
    }
  }

  public function check_installed($name) {
    $res = $this->em->get_data_by('wpb_extension', $name, 'name');
    if(is_array($res) && !empty($res)) {
      $art_msg['msg'] = lang('extention_already_installed'); 
      $art_msg['type'] = 'warning'; 
      $this->session->set_userdata('alert_msg', $art_msg);
      redirect( base_url().'extension');
    }
  }

  public function parse_xml($file) {
    $t = file_get_contents($file);
    $x = @simplexml_load_string( $t );
    if($x) {
      return $x;
    }
  }

  public function import_database( $db_file ) {
    if( file_exists($db_file) === TRUE ) {
        $connTemp = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        if (mysqli_connect_errno()) {
          $art_msg['msg'] = lang('failed_to_connect_to_my_s_q_l') .': .'. mysqli_connect_error(); 
          $art_msg['type'] = 'warning'; 
          $this->session->set_userdata('alert_msg', $art_msg);
          redirect( base_url().'extension');
        }
        $sql = file_get_contents($db_file);
        $res = $connTemp->multi_query($sql);
        mysqli_close($connTemp);
        if($res){
          return true;
        }
    } else {
      $art_msg['msg'] = lang('database_file_not_exist'); 
      $art_msg['type'] = 'warning'; 
      $this->session->set_userdata('alert_msg', $art_msg);
      redirect( base_url().'extension');
    }
  }


  public function removeDirectory($dir){
    if($dir){
      @chmod($dir, 0777);
    }
    $it     = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files  = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
      if ($file->isDir()){
        @chmod($file->getRealPath(), 0777);
        rmdir($file->getRealPath());
      } else {
        unlink($file->getRealPath());
      }
    }
    rmdir($dir);
  }

  public function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst, 0777, true);
    while(false !== ( $file = readdir($dir)) ) {
      if (( $file != '.' ) && ( $file != '..' )) {
        if ( is_dir($src . '/' . $file) ) {
          $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
        }
        else {
          copy($src . '/' . $file,$dst . '/' . $file);
        }
      }
    }
    closedir($dir);
  }

  public function ajx_data(){
    $primaryKey = 'extension_id';
    $table      = 'wpb_extension';
    $joinQuery  =   "FROM `wpb_extension` ";
    $columns  = array(
      array( 'db' => 'wpb_extension.extension_id AS extension_id', 'field' => 'extension_id', 'dt' => 0 ),
      array( 'db' => 'wpb_extension.name AS name', 'field' => 'name', 'dt' => 1 ),
      array( 'db' => 'wpb_extension.status AS status', 'field' => 'status', 'dt' => 2 , 'formatter' => function( $d, $row ) {
        $t = lang('inactive');
        $c = 'red';
        if($d == 1) {
          $t = lang('active');
          $c = 'blue';
        }
        $st = '<span class="label bg-'.$c.'" data-id="'.$row['extension_id'].'" rel="'.$d.'">'.$t.'</span>'; 
        return $st;
      }),
      array( 'db' => 'wpb_extension.extension_id AS extension_id', 'field' => 'extension_id', 'dt' => 3 , 'formatter' => function( $d, $row ) {
        $title = lang('active');
        $icn   = 'check_circle';
        $color = 'green';
        if($row['status'] == 1) {
          $title = lang('inactive');
          $icn   = 'cancel';
          $color = 'orange';
        }

        $act = '<a  class="ch-status" data-id="'.$d.'" rel="'.$row['status'].'" title="'.$title.'"><i class="material-icons col-'.$color.' font-20">'.$icn.'</i></a><a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$d.', \'extension\')"><i class="material-icons col-red font-20">delete</i></a>';
        return $act;
      }),
    );
    $where = '';
    $j = 0;
    if(strpos($joinQuery, 'JOIN') > 0) {
      $j = 1;
    }
    $where = SSP::mkaFilter( $_GET, $columns, $j);
    $where = SSP::column_mka_filter($_GET, $where);
    if($this->input->get('dateRange')) {
      $date = explode(' - ', $this->input->get('dateRange'));
      $and  = 'WHERE ';
      if($where != '') {
        $and = ' AND ';
      }
      $where .= $and."DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
    }
  
    if(CheckPermission($table, "all_read")){}
    else if(CheckPermission($table, "own_read") && CheckPermission($table, "all_read")!=true){
      $and = 'WHERE ';
      if($where != '') {
        $and = ' AND ';
      }
      $where .= $and."`$table`.`user_id`=".$this->user_id." ";
    }

    if(trim($where) == 'WHERE') {
      $where = '';
    }
    $group_by = "";

    $limit = SSP::limit( $_GET, $columns );
    $order = SSP::mkaorder( $_GET, $columns, $j );
    $col   = SSP::pluck($columns, 'db', $j);
    if(trim($where) == 'WHERE' || trim($where) == 'WHERE ()') {
      $where = '';
    }
    $query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$order." ".$limit." ";
    $res          = $this->db->query($query);
    $res          = $res->result_array();
    $recordsTotal = $this->db->select("count('extension_id') AS c")->get('wpb_extension')->row()->c;
    $res          = SSP::mka_data_output($columns, $res, $j);

    $output_arr['draw']            = intval( $_GET['draw'] );
    $output_arr['recordsTotal']    = intval( $recordsTotal );
    $output_arr['recordsFiltered'] = intval( $recordsTotal );
    $output_arr['data']            = $res;
    echo json_encode($output_arr);
    exit;
  }

  public function delete($id) {
    $folderpath = realpath(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/application/modules/';
    $o_extn = $this->em->get_data_by('wpb_extension', $id, 'extension_id');
    foreach ($o_extn as $oekey => $oevalue) {
      $this->em->delete_extn_db_action($oevalue);
      $folderpath = $folderpath . $oevalue->name;
      if(is_dir($folderpath)) {
        $this->removeDirectory($folderpath);
      }
    }
    $art_msg['msg'] = lang('extension_deleted_successfully'); 
    $art_msg['type'] = 'success'; 
    $this->session->set_userdata('alert_msg', $art_msg);
    redirect( base_url().'extension');  
  }

  public function upd_status() {
    $status = 1;
    if($this->input->post('status') == 1) {
      $status = 0;
    }
    $o_extn = $this->em->get_data_by('wpb_extension', $this->input->post('id'), 'extension_id');
    foreach ($o_extn as $ekey => $evalue) {
      $data = array('status' => $status);
      $this->em->updateRow('wpb_extension', 'extension_id', $evalue->extension_id, $data);
      $this->em->updateRow('wpb_c_modules', 'menu_name', $evalue->name, $data);
    }
    echo 1;
    exit;
  }
}
?>