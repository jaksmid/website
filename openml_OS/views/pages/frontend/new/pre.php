<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


if (!$this->ion_auth->logged_in()) {
	header('Location: ' . BASE_URL . 'login');
}

$this->task_ids = array();
$this->new_text = '';

$ttid_sel = $this->input->post( 'ttid' );
$this->task_types = $this->Task_type->get( );
for( $i = 0; $i < count($this->task_types); ++$i ) {
  $clause = '`io` = "input" AND `io` = "input" AND ' .
            '`ttid` = "'.$this->task_types[$i]->ttid.'"';
  $this->task_types[$i]->in = $this->Task_type_inout->getWhere( $clause, '`order` ASC' );
  $this->task_types[$i]->selected = ($ttid_sel == $this->task_types[$i]->ttid) ? 'selected="selected"' : '';
}

$this->responsetype = '';
$this->response = '';

?>
