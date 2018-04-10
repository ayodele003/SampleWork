<?php defined("BASEPATH") OR exit("No direct script access allowed");

/**
 *
 * Api file
 * @Auther: Manoj Kumar
 *
 */

class Api extends CI_Controller {

  public $request_data;
  public $model;
  public $table;
  public $_code = 200;
  public $_content_type = "application/json";
  public $func = array(

            'list'           => 'get_list',
            'row'            => 'get_row',
            'add'            => 'insert_row',
            'edit'           => 'edit_row',
            'remove'         => 'remove_row',
            'getinfo'        => 'get_info',
            'authentication' => 'authentication',
            'modules'         => 'get_modules'
    );

  public $messages = array(

        "INVALID_REQUEST" => 'Requested data is not valid, please check and try again.',
        "INVALID_MODULE"  => 'Module name is not currect.',
        "MISSING_FIELD"   => 'Invalid Request, Missing field: ',
        "EMAIL_EXIST"     => 'This Email already present in databse, try another email.',
        "ID_ERROR"        => 'Please enter valid id',
        "INVALID_KEY"     => 'Invalid Api Key',
        "REQ_API_KEY"     => 'API Key is required for authentication',
        "NO_TOKEN"        => 'Access Token required',
        "INVALID_TOKEN"   => 'Access Token is not valid Or Expired.',
        "NO_MODULE"       => 'Module is required',
        "DISABLED_API"    => 'API Disabled'
  );


  public $ignore_column = array(
          "user" => array('name', 'var_key')
  );


  function __construct() {
    parent::__construct();

    $this->load->model('api_model', 'api');

    /*$jsonStr = file_get_contents("php://input"); //read the HTTP body.
    $this->request_data = json_decode($jsonStr);*/
    $this->request_data = (object) $_REQUEST;

    if($this->request_data->action != 'authentication') {

      $this->verify_token($this->request_data);
      if($this->request_data->action != 'modules') {

        $this->verify_module($this->request_data);
        $this->model = $this->load_model($this->request_data->module);
        $this->table = $this->request_data->module;
        if($this->request_data->module == 'user') {
          $this->table = 'users';
        }
      }
    }

  }

  
  public function serviceCall() {

    $this->call_func($this->request_data->action);
  }

  public function authentication() {

    if(isset($this->request_data->key) && $this->request_data->key != '') {
      $res = $this->api->authentication($this->request_data->key);
      if($res == 'error') {
        echo $this->create_response('', 'INVALID_KEY', 400);
        exit;
      } else if($res == 'disabled') {
        echo $this->create_response('', 'DISABLED_API', 406);
        exit;
      } else  {
        echo $this->create_response(array('token' => $res), '', 200);
        exit;
      }
    } else {
      echo $this->create_response('', 'REQ_API_KEY', 404);
      exit;
    }
  }

  public function verify_token($request) {

    if(isset($request->token) && $request->token != ''){
      $res = $this->api->verify_token($request->token);
      if($res === 'INVALID_TOKEN') {
        echo $this->create_response('', 'INVALID_TOKEN', 400);
        exit;
      }
    } else {
      echo $this->create_response('', 'NO_TOKEN', 404);
      exit;
    }
  }

  public function get_info() {
    $columns = $this->api->getFields($this->table);
    $k = array_search( $this->table . '_id', $columns );
    unset($columns[$k]);
    $columns = array_values($columns);
    echo $this->create_response($columns, '', 200);
    exit;
    //echo '<pre>'; print_r($columns); die;
  }


  public function get_list() {

    $res = $this->model->get_data_by($this->table);
    //echo '<pre>'; print_r($res); die;
    if($this->request_data->module == 'user'){
      $result = array();
      foreach ($res as $rkey => $rvalue) {
        unset($rvalue->password);
        $result[$rkey] = $rvalue;
      }
    } else {
      $result = $res;
    }
    echo $this->create_response($result, '', 200);
    exit;
  }


  public  function get_row() {

    $res = $this->model->get_data_by($this->table, $this->request_data->id, $this->table.'_id');
    if($this->request_data->module == 'user'){
      $result = array();
      foreach ($res as $rkey => $rvalue) {
        unset($rvalue->password);
        $result[$rkey] = $rvalue;
      }
    }
    echo $this->create_response($result, '', 200);
    exit;
  }


  public function insert_row() {

    if($r_id = $this->model->insertRow($this->table, $this->data_formating())) {
      $result = array('responce' => 'Record Inserted in database successfuly', 'id' => $r_id);
      echo $this->create_response($result, '', 200);
      exit;
    }
    
  }

  public function edit_row() {
    if($this->model->updateRow($this->table, $this->table . '_id', $this->request_data->id, $this->data_formating())){
      $result = array('responce' => 'Record updated successfuly', 'id' => $this->request_data->id);
      echo $this->create_response($result, '', 200);
      exit;
    }
  }


  public function remove_row() {
    if(!isset($this->request_data->id) || $this->request_data->id == '' || !is_numeric($this->request_data->id)) {
      echo $this->create_response('', 'ID_ERROR', 400);
      exit;
    }

    if($this->request_data->module == 'user') {
      $this->model->delete($this->request_data->id);
    } else { 
      $this->model->delete_data($this->request_data->id);
    }
    $result = array('responce' => 'Record removed successfuly', 'id' => $this->request_data->id);
    echo $this->create_response($result, '', 200);
    exit;
  }

  public function get_modules() {
    $m = $this->api->getModule();
    $m = json_decode($m->data, true);
    $m = array_values($m);
    echo $this->create_response($m, '', 200);
    exit;
  }

  /*----------  Load model  ----------*/
  public function load_model($model) {
    $this->load->model( $model . '/' . $model . '_model', 'm_model' );
    return $this->m_model;
  }
  

  /*----------  Call Requested Function  ----------*/
  public function call_func($f) {

    if(isset($this->func[$f]) && $this->func[$f] != '') {
      $this->{$this->func[$f]}();
    } else {
      echo $this->create_response('', 'INVALID_REQUEST', 400);
      exit;
    }
  }


  public function create_response($data = array(), $error, $code) {
    $response            = array();
    $response['result']  = 'error';
    $response['message'] = 'Result Not Found';
    if($error != '') {
      $response['message'] = $this->messages[$error];
      if($error == 'MISSING_FIELD') {
        $response['message'] .= $data;  
      }
    } else if (!empty($data)) {
      $response['result']  = 'success';
      $response['message'] = 'API Called successfully';
      $response['data']    = $data;
    }
    $this->_code = ($code) ? $code: 200;
    $this->set_haeders();
    return json_encode($response);
  }


  public function verify_module($req) {

    if(isset($req->module) && $req->module != '') {
      $m = $this->api->getModule();
      $m = json_decode($m->data, true);
      $m = array_values($m);
      if(!in_array($req->module, $m)){
        echo $this->create_response('', 'INVALID_MODULE', 400);
        exit;
      }
    } else {
      echo $this->create_response('', 'NO_MODULE', 404);
      exit;
    }
  }

  public function data_formating() {
    $request = $this->request_data;
    $columns = $this->api->getFields($this->table);
    $k       = array_search( $this->table . '_id', $columns );
    unset($columns[$k]);
    if(isset($this->ignore_column[$this->request_data->module]) && !empty($this->ignore_column[$this->request_data->module])) {
      foreach($this->ignore_column[$this->request_data->module] as $ik => $iv) {
        $k = array_search( $iv, $columns );
        unset($columns[$k]);
      }
    }
    $columns = array_values($columns);

    $data_array = array();
    if($request->action == 'add'){
      foreach ($columns as $clkey => $clvalue) {
        if(array_key_exists($clvalue, $request->data)){
          $data_array[$clvalue] = $request->data->$clvalue;
          if($request->module == 'user') {
            if( $clvalue == 'email' ) {
              if(!$this->model->check_exists($this->table, $clvalue, $request->data->$clvalue)) {
                echo $this->create_response('', 'EMAIL_EXIST', 406);
                exit;
              }
            }
            if( $clvalue == 'password' ) {
              $data_array[$clvalue] = password_hash($request->data->$clvalue, PASSWORD_DEFAULT);
            }
          } 
        } else {
          echo $this->create_response($clvalue, 'MISSING_FIELD', 404);
          exit;
        }
      }
    } else if($request->action == 'edit') {
      if(!isset($request->id) || $request->id == '' || !is_numeric($request->id)) {
        echo $this->create_response('', 'ID_ERROR', 406);
        exit;
      }
      foreach($request->data as $k => $v){
        if(!in_array($k, $columns)){
          echo $this->create_response('', 'INVALID_REQUEST', 404);
          exit;
        }
        $data_array[$k] = $v;
        if($request->module == 'user') {
          if( $k == 'email' ) {
            if(!$this->model->check_exists($this->table, $k, $request->data->$k, $request->id, $this->table.'_id')) {
              echo $this->create_response('', 'EMAIL_EXIST', 406);
              exit;
            }
          }
          if( $k == 'password' ) {
            $data_array[$k] = password_hash($request->data->$k, PASSWORD_DEFAULT);
          }
        } 
      }
    }
    return $data_array;
    
  }

  public function set_haeders(){
    header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
    header("Content-Type:".$this->_content_type);
  }

  private function get_status_message(){
      $status = array(
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'no content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',  
            500 => 'Internal Server Error',  
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported');
      return ($status[$this->_code])?$status[$this->_code]:$status[500];
  }
}