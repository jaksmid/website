<?php

if(false === strpos($_SERVER['REQUEST_URI'],'/f/')) {
  header('Location: search?type=flow');
  die();
}

//$this->load_javascript = array('js/libs/highcharts.js','js/libs/highcharts-more.js','js/libs/modules/exporting.js','js/libs/jquery.dataTables.min.js','js/libs/dataTables.tableTools.min.js','js/libs/dataTables.scroller.min.js','js/libs/dataTables.responsive.min.js','js/libs/dataTables.colVis.min.js');
$this->load_javascript = array('js/libs/mousetrap.min.js','js/libs/gollum.js','js/libs/highcharts.js','js/libs/jquery.dataTables.min.js','js/libs/rainbowvis.js');
$this->load_css = array('css/gollum.css','css/jquery.dataTables.min.css','css/dataTables.colvis.min.css','css/dataTables.colvis.jqueryui.css','css/dataTables.responsive.min.css','css/dataTables.scroller.min.css','css/dataTables.tableTools.min.css');

/// SEARCH
$this->filtertype = 'flow';
$this->sort = 'runs';
if($this->input->get('sort'))
	$this->sort = safe($this->input->get('sort'));

/// DETAIL

// Making sure we know who is editing
$this->editor = 'Anonymous';
$this->is_owner = false;
$this->editing = false;
if(false !== strpos($_SERVER['REQUEST_URI'],'/edit')){
  if (!$this->ion_auth->logged_in()) {
  header('Location: ' . BASE_URL . 'login');
  }
  else{
  $user = $this->Author->getById($this->ion_auth->user()->row()->id);
  $this->editor = $user->first_name . ' ' . $user->last_name;
  $this->editing = true;
  }
}
$this->user_id = -1;
if ($this->ion_auth->logged_in()) {
  $this->user_id = $this->ion_auth->user()->row()->id;
}

$this->type = 'implementation';
$this->record = false;
$this->displayName = false;
$this->allmeasures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
$this->current_measure = 'predictive_accuracy';
$this->current_task = 1;


if(false !== strpos($_SERVER['REQUEST_URI'],'/f/')) {
	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->id = explode('?',$info[array_search('f',$info)+1])[0];

	$this->record = $this->Implementation->getByID($this->id);
  $bfilerecord = $this->File->getById( $this->record->binary_file_id );
  if($bfilerecord)
    $this->flow_binary_url =  BASE_URL . 'data/download/' . $bfilerecord->id . '/'. $this->record->fullName;
  $sfilerecord = $this->File->getById( $this->record->source_file_id );
  if($sfilerecord)
    $this->flow_source_url = BASE_URL . 'data/download/' . $sfilerecord->id . '/'. $this->record->fullName;

	// Get data from ES
	$this->p = array();
	$this->p['index'] = 'openml';
	$this->p['type'] = 'flow';
	$this->p['id'] = $this->id;
	try{
		$this->flow = $this->searchclient->get($this->p)['_source'];
	} catch (Exception $e) {}

	$this->displayName = $this->flow['name'];
	$this->versions = $this->Implementation->getAssociativeArray('id', 'version', 'name = "'.$this->displayName.'"');
	ksort($this->versions);

  //wiki import
  $this->wikipage = str_replace('_','-','flow-'.$this->flow['name'].'-'.$this->flow['version']);
  $this->wikipage = str_replace('.','-dot-',$this->wikipage);
  $this->wikipage = str_replace('(','-',$this->wikipage);
  $this->wikipage = str_replace(')','-',$this->wikipage);
  $this->wikipage = str_replace(',','-',$this->wikipage);
  $this->wikipage = str_replace('--','-',$this->wikipage);

  $url = $this->wikipage;
  $this->show_history = true;

  $preamble = '';
  if(end($info) == 'edit')
    $url = 'edit/'.$this->wikipage;
  elseif(end($info) == 'history')
    $url = 'history/'.$this->wikipage;
  elseif(in_array('compare',$info)){
    $p = $this->input->post('versions');
    $url = 'compare/'.$this->wikipage.'/'.$p[0].'...'.$p[1];}
  elseif(in_array('view',$info)){
    $url = $this->wikipage.'/'.end($info);
    $preamble = '<span class="label label-danger" style="font-weight:200">You are viewing version: '.end($info).'</span><br><br>';}
  elseif(end($info) == 'preview')
    $url = 'preview';
  else
    $this->show_history = false;

  $this->wiki_ok = true;
  $html = @file_get_contents('http://localhost:4567/'.$url);

  if($html){ //check if Gollum working and not trying to create new page
    preg_match('/<body>(.*)<\/body>/s',$html,$content_arr);
    $this->wikiwrapper = $preamble . str_replace('body>','div>',$content_arr[0]);
    $this->wikiwrapper = str_replace('action="/edit/'.$this->wikipage.'"','',$this->wikiwrapper);
  } else { //failsafe
    $this->wikiwrapper = '<div class="rawtext">'.$this->flow['description'].'</div>';
    $this->wiki_ok = false;
  }

  //crop long descriptions
  $this->hidedescription = false;
  if(strlen($this->wikiwrapper)>400 and $url==$this->wikipage and strlen($preamble)==0)
    $this->hidedescription = true;

	$this->dt_main['columns'] 		= array('r.rid','rid','sid','name','value');
	$this->dt_main['column_widths']		= array(1,1,0,60,30);
	$this->dt_main['column_content']	= array('<a data-toggle="modal" href="r/[CONTENT]/html" data-target="#runModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="d/[CONTENT1]">[CONTENT2]</a>',null);
	$this->dt_main['column_source'] 	= array('wrapper','db','db','doublewrapper','db');
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(d.did, "~", d.name) as name, round(e.value,4) as value '.
										'FROM algorithm_setup l, evaluation e, run r, input_data rd, dataset d '.
										'WHERE r.setup=l.sid  '.
										'AND l.implementation_id="'.$this->id.'"  '.
										'AND l.isDefault="true"' .
										'AND r.rid=rd.data  '.
                    'AND rd.data = d.did ' .
										'AND e.source=r.rid  ';

	$this->dt_main_all['columns'] 		= array('r.rid','rid','sid','name','value');
	$this->dt_main_all['column_widths']		= array(1,1,0,60,30);
	$this->dt_main_all['column_content']	= array('<a data-toggle="modal" href="r/[CONTENT]/html" data-target="#runModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="d/[CONTENT1]">[CONTENT2]</a>',null);
	$this->dt_main_all['column_source'] 	= array('wrapper','db','db','doublewrapper','db');

	$this->dt_main_all['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(d.did, "~", d.name) as name, round(e.value,4) as value '.
										'FROM algorithm_setup l, evaluation e, run r, input_data rd, dataset d  '.
										'WHERE r.setup=l.sid  '.
										'AND l.implementation_id="'.$this->id.'"  '.
										'AND r.rid=rd.data  '.
                    'AND rd.data = d.did ' .
										'AND e.source=r.rid  ';

	$this->dt_params = array();
	$this->dt_params['columns'] 		= array('name', 'generalName', 'defaultValue', 'min', 'max');
	$this->dt_params['column_widths']	= array(10,20,30,10,10,10,10);
	$this->dt_params['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_params['columns']) . '` FROM input WHERE implementation_id ="'.$this->id.'" ';

	$this->dt_qualities = array();
	$this->dt_qualities['columns'] 		= array('name','description','value');
	$this->dt_qualities['column_widths']= array(25,50,25);
	$this->dt_qualities['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `algorithm_quality`,`quality` WHERE `algorithm_quality`.`quality` = `quality`.`name` AND `algorithm_quality`.`implementation_id`="'.$this->id.'"';



}

function cleanName($string){
	return $safe = preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)));
}

?>
