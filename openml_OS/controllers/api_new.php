<?php
class Api_new extends CI_Controller {

  private $version;

  function __construct() {
    parent::__construct();

    $this->controller = strtolower(get_class ($this));
    $this->page = 'xml';
    $this->active = 'learn';
    $this->message = $this->session->flashdata('message'); // can be overridden

    $this->load->model('api/v1/Api_data');
    $this->load->model('api/v1/Api_task');
    $this->load->model('api/v1/Api_tasktype');
    $this->load->model('api/v1/Api_flow');
    $this->load->model('api/v1/Api_run');
    $this->load->model('api/v1/Api_setup');
    $this->load->model('api/v1/Api_estimationprocedure');
    $this->load->model('api/v1/Api_evaluationmeasure');
    $this->load->model('api/v1/Api_file');
    $this->load->model('api/v1/Api_job');
    $this->load->model('api/v1/Api_user');

    $this->load->model('Log');
    $this->load->model('Api_session');
    $this->load->model('Author');

    // helper
    $this->load->helper('api');

    // paths
    $this->data_folders = array(
      'dataset'        => 'dataset/api/',
      'implementation' => 'implementation/',
      'run'            => 'run/',
      'misc'           => 'misc/'
    );

    $this->load->library('elasticSearch');
    $this->load->library('wiki');
    
    $this->groups_upload_rights = array(1,2); // must be part of this group to upload stuff
    
    // XML maintainance
    $this->xml_fields_dataset = $this->config->item('xml_fields_dataset');
    $this->xml_fields_dataset_update = $this->config->item('xml_fields_dataset_update');
    $this->xml_fields_implementation = $this->config->item('xml_fields_implementation');
    $this->xml_fields_run = $this->config->item('xml_fields_run');

    $this->data_controller = $this->config->item('data_controller');

    // some user authentication things.
    $this->provided_hash = $this->input->get_post('api_key') != false;
    $this->provided_valid_hash = $this->Author->getWhere( 'session_hash = "' . $this->input->get_post('api_key') . '"' ); // TODO: and add date?
    $this->authenticated = $this->provided_valid_hash || $this->ion_auth->logged_in();
    $this->user_id = false;
    if($this->provided_valid_hash) {
      $this->user_id = $this->provided_valid_hash[0]->id;
    } elseif($this->ion_auth->logged_in()) {
      $this->user_id = $this->ion_auth->user()->row()->id;
    }

  }

  public function index() {
    $this->_show_webpage();
  }

  public function v1($type) {
    $this->bootstrap('1');
  }

  private function bootstrap($version) {
    loadpage('v1/'.$this->page,false,'pre');
    $segs = $this->uri->segment_array();

    $controller = array_shift($segs);
    $this->version = array_shift($segs);
    $type = array_shift($segs);
    $request_type = strtolower($_SERVER['REQUEST_METHOD']);

    if ($this->authenticated == false) {
      if ($this->provided_hash) {
        $this->_returnError( 103 );
      } else {
        $this->_returnError( 102 );
      }
    } else if (file_exists(APPPATH.'models/api/' . $this->version . '/api_' . $type . '.php') == false && $type != 'xsd') {
       $this->_returnError( 100 );
    } else if($type == 'xsd') {
      $this->xsd($segs[0], 'v1');
    } else {
      $this->{'Api_'.$type}->bootstrap($segs, $request_type, $this->user_id);
    }
  }

  public function xsd($filename,$version) {
    if(is_safe($filename) && file_exists(xsd($filename,$this->controller,$version))) {
      header('Content-type: text/xml; charset=utf-8');
      echo file_get_contents(xsd($filename,$this->controller,$version));
    } else {
      $this->error404();
    }
  }

  public function error404() {
    header("Status: 404 Not Found");
    $this->load->view('404');
  }


  /************************************* DISPLAY *************************************/

  private function _show_webpage() {
    $this->page = 'api_docs';
    if(!loadpage($this->page,true,'pre'))
      $this->page_body = '<div class="baseNormalContent">Pagina niet gevonden.
                <a href="'.home().'">Klik hier</a> om terug te keren naar de hoofdpagina.</div>';
    $this->load->view('frontend_main');
  }

  private function _returnError( $code, $httpErrorCode = 450, $additionalInfo = null ) {
    $this->Log->api_error( 'error', $_SERVER['REMOTE_ADDR'], $code, $_SERVER['QUERY_STRING'], $this->load->apiErrors[$code][0] . (($additionalInfo == null)?'':$additionalInfo) );
    $error['code'] = $code;
    $error['message'] = htmlentities( $this->load->apiErrors[$code][0] );
    $error['additional'] = htmlentities( $additionalInfo );

    $httpHeaders = array( 'HTTP/1.0 ' . $httpErrorCode );
    $this->_xmlContents( 'error-message', $error, $httpHeaders );
  }

  private function _xmlContents( $xmlFile, $source, $httpHeaders = array() ) {
    $view = 'pages/'.$this->controller.'/' . $this->version . '/' . $this->page.'/'.$xmlFile.'.tpl.php';
    $data = $this->load->view( $view, $source, true );
    header('Content-length: ' . strlen($data) );
    header('Content-type: text/xml; charset=utf-8');
    foreach( $httpHeaders as $header ) {
      header( $header );
    }
    echo $data;
  }
}
?>
