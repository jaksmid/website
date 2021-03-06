<?php
class Api_evaluationmeasure extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    // load models
    $this->load->model('Math_function');
  }
  
  function bootstrap($segments, $request_type, $user_id) {
    $getpost = array('get','post');
    
    if (count($segments) == 1 && $segments[0] == 'list') {
      $this->evaluationmeasure_list();
      return;
    }
    
    
    $this->returnError( 100, $this->version );
  }
  
  
  private function evaluationmeasure_list() {
    $data->measures = $this->Math_function->getWhere( 'functionType = "EvaluationFunction"' );
    $this->xmlContents( 'evaluation-measures', $this->version, $data );
  }
}
?>
