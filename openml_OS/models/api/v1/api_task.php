<?php
class Api_task extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    // load models
    $this->load->model('Task');
    $this->load->model('Task_tag');
    $this->load->model('Task_inputs');
    $this->load->model('Task_type');
    $this->load->model('Task_type_inout');
    $this->load->model('Data_quality');
    $this->load->model('Run');
  }
  
  function bootstrap($segments, $request_type, $user_id) {
    $getpost = array('get','post');
    
    if (count($segments) == 1 && $segments[0] == 'list') {
      $this->task_list();
      return;
    }
    
    if (count($segments) == 1 && is_numeric($segments[0]) && in_array($request_type, $getpost)) {
      $this->task($segments[0]);
      return;
    }
    
    if (count($segments) == 1 && is_numeric($segments[0]) && $request_type == 'delete') {
      $this->task_delete($segments[0]);
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'tag' && $request_type == 'post') {
      $this->task_tag($this->input->post('task_id'),$this->input->post('tag'));
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'untag' && $request_type == 'post') {
      $this->task_tag($this->input->post('task_id'),$this->input->post('tag'));
      return;
    }
    
    $this->returnError( 100, $this->version );
  }
  
  
  private function task_list() {
    // TODO: add tag / active
    //$task_type_id = $this->input->get( 'task_type_id' );
    //if( $task_type_id == false ) {
    //  $this->_returnError( 480 );
    //  return;
    //}
    //$active = $this->input->get('active_only') ? ' AND d.status = "active" ' : '';
    $tasks_res = $this->Task->query( 
      'SELECT t.task_id, tt.name, source.value as did, d.status, d.name AS dataset_name '.
      'FROM `task` `t`, `task_inputs` `source`, `dataset` `d`, `task_type` `tt` '.
      'WHERE `source`.`input` = "source_data" AND `source`.`task_id` = `t`.`task_id` AND `source`.`value` = `d`.`did` AND `tt`.`ttid` = `t`.`ttid` ' .
       //'AND `t`.`ttid` = "'.$task_type_id.'" ' . 
       //$active . 
       ' ORDER BY task_id; ' );
    if( is_array( $tasks_res ) == false || count( $tasks_res ) == 0 ) {
      $this->returnError( 481, $this->version );
      return;
    }
    // make associative array from it
    $dids = array();
    $tasks = array();
    foreach( $tasks_res as $task ) {
      $tasks[$task->task_id] = $task;
      $tasks[$task->task_id]->qualities = array();
      $tasks[$task->task_id]->inputs = array();
    }

    $dq = $this->Data_quality->query('SELECT t.task_id, q.data, q.quality, q.value FROM data_quality q, task_inputs t WHERE t.input = "source_data" AND t.value = q.data AND t.task_id IN (' . implode(',', array_keys($tasks)) . ') AND quality IN ("' .  implode('","', $this->config->item('basic_qualities') ) . '") ORDER BY t.task_id');
    $ti = $this->Task_inputs->getWhere( 'task_id IN (' . implode(',', array_keys($tasks) ) . ')', '`task_id`' );

    for( $i = 0; $i < count($dq); ++$i ) { $tasks[$dq[$i]->task_id]->qualities[$dq[$i]->quality] = $dq[$i]->value; }
    for( $i = 0; $i < count($ti); ++$i ) { $tasks[$ti[$i]->task_id]->inputs[$ti[$i]->input] = $ti[$i]->value; }

    $this->xmlContents( 'tasks', $this->version, array( 'tasks' => $tasks ) );
  }
  
  
  private function task($task_id) {
    if( $task_id == false ) {
      $this->returnError( 150, $this->version );
      return;
    }

    $task = $this->Task->getById( $task_id );
    if( $task === false ) {
      $this->returnError( 151, $this->version );
      return;
    }

    $task_type = $this->Task_type->getById( $task->ttid );
    if( $task_type === false ) {
      $this->returnError( 151, $this->version );
      return;
    }

    $parsed_io = $this->Task_type_inout->getParsed( $task_id );
    $tags = $this->Task_tag->getColumnWhere( 'tag', 'id = ' . $task_id );
    $this->xmlContents( 'task-get', $this->version, array( 'task' => $task, 'task_type' => $task_type, 'parsed_io' => $parsed_io, 'tags' => $tags ) );
  }
  
  
  private function task_delete($task_id) {

    $task = $this->Task->getById( $task_id );
    if( $task == false ) {
      $this->returnError( 452, $this->version );
      return;
    }

    $runs = $this->Run->getWhere( 'task_id = "' . $task->task_id . '"' );

    if( $runs ) {
      $this->returnError( 454, $this->version );
      return;
    }


    $result = true;
    $result = $result && $this->Task_inputs->deleteWhere('task_id = ' . $task->task_id );

    if( $result ) {
      $result = $this->Task->delete( $task->task_id );
    }

    if( $result == false ) {
      $this->returnError( 455, $this->version );
      return;
    }

    $this->xmlContents( 'task-delete', $this->version, array( 'task' => $task ) );
  }

  private function task_tag() {
    $id = $this->input->post( 'task_id' );
    $tag = $this->input->post( 'tag' );

    $error = -1;
    $result = tag_item( 'task', $id, $tag, $this->user_id, $error );


    //update index
    $this->elasticsearch->index('task', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-tag', $this->version, array( 'id' => $id, 'type' => 'task' ) );
    }
  }

  private function task_untag() {
    $id = $this->input->post( 'task_id' );
    $tag = $this->input->post( 'tag' );

    $error = -1;
    $result = untag_item( 'task', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('task', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-untag', $this->version, array( 'id' => $id, 'type' => 'task' ) );
    }
  }
}
?>
