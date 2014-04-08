<?php
class Run extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'run';
    $this->id_column = 'rid';
    
    $this->load->model('Algorithm');
    $this->load->model('Cvrun');
    $this->load->model('Task');
    $this->load->model('Dataset');
    $this->load->model('Evaluation');
    $this->load->model('Evaluation_fold');
    $this->load->model('Evaluation_sample');
    $this->load->model('Implementation');
    $this->load->model('Math_function');
    $this->load->model('Runfile');
  }
  
  function inputData( $run, $data, $table ) {
    if( !is_numeric($run) || !is_numeric($data) ) return false;
    $sql = 'INSERT INTO `input_data`(`run`,`data`,`name`) VALUES("'.$run.'","'.$data.'","'.$table.'"); ';
    return $this->db->query( $sql );
  }
  
  function outputData( $run, $data, $table, $field = NULL ) {
    if( !is_numeric($run) || !is_numeric($data) ) return false;
    $field = ( $field != NULL ) ? $field = '"' . $field . '"' : 'NULL';
    $sql = 'INSERT INTO `output_data`(`run`,`data`,`name`,`field`) VALUES("'.$run.'","'.$data.'","'.$table.'",'.$field.'); ';
    return $this->db->query( $sql );
  }
  
  function getInputData( $runId ) {
    if( !is_numeric($runId) ) return false;
    $sql = 'SELECT dataset.* FROM input_data, dataset WHERE input_data.data = dataset.did AND input_data.run = ' . $runId;
    $result = $this->db->query( $sql )->result();
    if(count($result)) 
      return $result;
    else
      return false;
  }
  
  function getOutputData( $runId ) {
    if( !is_numeric($runId) ) return false;
    $datasets = $this->Dataset->getWhere(array( 'source' => $runId ));
    $runfiles = $this->Runfile->getWhere(array( 'source' => $runId ));
    $evaluations = $this->Evaluation->getWhere(array( 'source' => $runId ));
    
    $result = array();
    if(is_array($datasets)) $result['dataset'] = $datasets;
    if(is_array($evaluations)) $result['evaluations'] = $evaluations;
    if(is_array($runfiles)) $result['runfile'] = $runfiles;
    
    if(count($result)) 
      return $result;
    else
      return false;
  }
  
  function process( $run_id, &$errorCode, &$errorMessage ) {
    $run = $this->getById( $run_id );
    $task = $this->Task->getById( $run->task_id );
    
    $success = false;
    if( in_array( $task->ttid, array( 1, 2, 3, 4 ) ) ) {
      $success = $this->insertSupervisedClassificationRun( $run, $errorCode, $errorMessage ); 
      
      if( $success ) {
        $update = array( 'processed' => now(), 'error' => NULL );
      } else {
        $update = array( 'processed' => now(), 'error' => $errorMessage );
      }
      $this->Run->update( $run_id, $update );
    }
    
    return $success;
  }
  
  /*
   *  Does all the specialized things needed for registering a Supervised Classification Run.
   *  @pre: There must be a run record
   *
   */
  function insertSupervisedClassificationRun( $runRecord, &$errorCode, &$errorMessage ) {
    $taskRecord = $this->Task->getByIdForEvaluation( $runRecord->task_id );
    
    $predictionsUrl = fileRecordToUrl( $this->Runfile->fileFromRun( $runRecord->rid, 'predictions' ) );
    $descriptionUrl = fileRecordToUrl( $this->Runfile->fileFromRun( $runRecord->rid, 'description' ) );
    
    $description = file_get_contents( $descriptionUrl );
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string( $description );
    
    if( $xml == false ) {
      foreach(libxml_get_errors() as $error) $errorMessage .= $error . '. ';
      $errorCode = 219;
      return false;
    }
    
    $output_data = array();
    if( $xml->children('oml', true)->{'output_data'} != false ) {
      foreach( $xml->children('oml', true)->{'output_data'}->children('oml', true) as $out ) {
        $output_data[] = xml2object( $out, true );
      }
    }
    
    // create shortcut record, after check whether it doesn't exists
    if( $this->Cvrun->getById( $runRecord->rid ) === false ) {
      $cvRunData = array(
        'rid' => $runRecord->rid,
        'uploader' => $runRecord->uploader,
        'task_id' => $taskRecord->id,
        'inputData' => $taskRecord->did,
        'learner' => $runRecord->setup,
        'runType' => 'classification',
        'nrFolds' => property_exists( $taskRecord, 'folds' ) ? $taskRecord->folds : 1,
        'nrIterations' => property_exists( $taskRecord, 'repeats' ) ? $taskRecord->repeats : 1
      );
      
      $cvrunId = $this->Cvrun->insert( $cvRunData );
      if( $cvrunId === false ) {
        $errorCode = 209;
        return false;
      }
    }
    $inputData = $this->Dataset->getById( $taskRecord->did );
    
    // and now evaluate the run
    $splitsUrl = property_exists( $taskRecord, 'splits_url' ) ? $taskRecord->splits_url : false;
    $results = $this->evaluateRun( 
      $runRecord->rid, $taskRecord, 
      $inputData->url, $splitsUrl, $predictionsUrl, 
      $taskRecord->target_feature, 
      $output_data, $errorCode, $errorMessage );
      
    return $results;
  }
  
  private function evaluateRun( $runId, $taskRecord, $datasetUrl, $splitsUrl, $predictionsUrl, $targetFeature, $userSpecifiedMetrices, &$errorCode, &$errorMessage ) {
    $eval = APPPATH . 'third_party/OpenML/Java/evaluate.jar';
    $res = array();
    $code = 0;
    $javaFunction = "evaluate_predictions";
    if( $taskRecord->ttid == 4 ) { // data stream classification
      $javaFunction = "evaluate_stream_predictions";
    }
    $command = "java -jar $eval -f $javaFunction -d \"$datasetUrl\" -s \"$splitsUrl\" -p \"$predictionsUrl\" -c \"$targetFeature\"";
    $this->Log->cmd( 'REST API::openml.run.upload', $command ); 
  
    if(function_enabled('exec') === false ) {
      $errorCode = 'failed to start evaluation engine.';
      return false;
    }
    
    $this->Log->cmd( 'Evaluate Run', $command ); 
    exec( CMD_PREFIX . $command, $res, $code );
  
    $json = json_decode( implode( "\n", $res ) );
    
    if( $code != 0 || $json === null ) {
      $errorMessage = implode( '; ', $res );
      $errorCode = 215;
      return false;
    }
    if( property_exists( $json, 'error' ) ) {
      $errorMessage = $json->error;
      $errorCode = 215;
      return false;
    }
    
    // it seems we have a legal result from the evaluation engine. Let's add it to the database. 
    $res = array();
    
    // global metrics:
    $did_global = $this->Dataset->getHighestIndex( $this->data_tables, 'did' );
    $this->Run->outputData( $runId, $did_global, 'evaluation' );
    $inconsistentMeasures = array();
    
    // TODO: the code blocks for global metrices, fold metrices and sample metrices are highly similar. 
    // collapse into one block once. 
    if( property_exists( $json, 'global_metrices' ) ) {
      foreach( $json->global_metrices as $metric ) {
        if( in_array( $metric->name, $this->supportedMetrics ) ) {
          $stored = $this->storeEvaluationMeasure( $metric, $did_global, $runId );
          if( property_exists($metric, 'value') ) {
            $res[$metric->name] = $metric->value;
          } elseif( property_exists($metric, 'array_data') ) {
            $res[$metric->name] = arr2string($metric->array_data);
          }
        }
      }
    }
    
    // user defined global metrics:
    foreach( $userSpecifiedMetrices as $metric ) {
      if( property_exists($metric, 'fold') || property_exists($metric, 'repeat') || property_exists($metric, 'sample' ) ) {
        continue;
      } else {
        $evalEngine = $this->getEvalEngineMeasureByName( $metric->name, $json->global_metrices );
        if( $evalEngine === false ) {
          $stored = $this->storeEvaluationMeasure( $metric, $did_global, $runId );
          if( $stored ) {
            if( property_exists($metric, 'value') ) {
              $res[$metric->name] = $metric->value;
            } elseif( property_exists($metric, 'array_data') ) {
              $res[$metric->name] = arr2string($metric->array_data);
            }
          }
        } else {
          if( $this->measureConsistent( $metric, $evalEngine ) == false ) { // TODO: test
            $inconsistentMeasures[] = $evalEngine->name . ' (global)';
          }
        } 
      }
    }
    
    // fold metrics
    if( property_exists( $json, 'fold_metrices' ) ) {
      for( $repeat = 0; $repeat < count($json->fold_metrices); ++$repeat ) {
        for( $fold = 0; $fold < count($json->fold_metrices[$repeat]); ++$fold ) {
          $did = $this->Dataset->getHighestIndex( $this->data_tables, 'did' );
          $this->Run->outputData( $runId, $did, 'evaluation_fold' );
          foreach( $json->fold_metrices[$repeat][$fold] as $metric ) {
            $stored = $this->storeEvaluationMeasure( $metric, $did, $runId, $did_global, $repeat, $fold );
          }
          foreach( $userSpecifiedMetrices as $metric ) {
            if( property_exists($metric, 'fold') && property_exists($metric, 'repeat') && !property_exists($metric, 'sample' ) ) {
              
              if( $metric->repeat == $repeat && $metric->fold == $fold ) {
                $evalEngine = $this->getEvalEngineMeasureByName( $metric->name, $json->fold_metrices[$repeat][$fold] );
                if( $evalEngine === false ) {
                  $stored = $this->storeEvaluationMeasure( $metric, $did, $runId, $did_global, $repeat, $fold );
                } else {
                  if( $this->measureConsistent( $metric, $evalEngine ) == false ) { 
                    $inconsistentMeasures[] = $evalEngine->name . " (repeat $repeat, fold $fold)";
                  }
                }
              }
            }
          }
        }
      }
    }
    
    // sample metrics
    if( property_exists( $json, 'sample_metrices' ) ) {
      for( $repeat = 0; $repeat < count($json->sample_metrices); ++$repeat ) {
        for( $fold = 0; $fold < count($json->sample_metrices[$repeat]); ++$fold ) {
          for( $sample = 0; $sample < count($json->sample_metrices[$repeat][$fold]); ++$sample ) {
            $did = $this->Dataset->getHighestIndex( $this->data_tables, 'did' );
            $this->Run->outputData( $runId, $did, 'evaluation_sample' );
            foreach( $json->sample_metrices[$repeat][$fold][$sample] as $metric ) {
              $stored = $this->storeEvaluationMeasure( $metric, $did, $runId, $did_global, $repeat, $fold, $sample );
            }
            foreach( $userSpecifiedMetrices as $metric ) {
              if( property_exists($metric, 'fold') && property_exists($metric, 'repeat') && property_exists($metric, 'sample' ) ) {
                if( $metric->repeat == $repeat && $metric->fold == $fold && $metric->sample == $sample ) {
                  $evalEngine = $this->getEvalEngineMeasureByName( $metric->name, $json->sample_metrices[$repeat][$fold][$sample] );
                  if( $evalEngine === false ) {
                    $stored = $this->storeEvaluationMeasure( $metric, $did, $runId, $did_global, $repeat, $fold, $sample );
                  } else {
                    //echo 'should check sample metric ' . $evalEngine->name . '->'. $repeat . ',' . $fold . ',' . $sample . '<br/>';
                    if( $this->measureConsistent( $metric, $evalEngine ) == false ) { // TODO: test
                      $inconsistentMeasures[] = $evalEngine->name . " (repeat $repeat, fold $fold, sample $sample)";
                    }
                  }
                } 
              }
            }
          }
        }
      }
    }
    
    // check if there were any inconsistent measures:
    if($inconsistentMeasures) {
      $errorCode = 217;
      $errorMessage = 'Inconsistent evaluation measures provided by uploader: ' . implode( '; ', $inconsistentMeasures);
      return false;
    }
    return $res;
  }
  
  private function storeEvaluationMeasure( $metric, $did, $runId, $did_global = false, $repeat = false, $fold = false, $sample = false ) {
    if( in_array( $metric->name, $this->supportedMetrics ) ) {
      // TODO: smarter way to deal with this :)
      $implementation_record = $this->Implementation->getByFullName($metric->implementation);
      if( $implementation_record == false ) {
        $this->Log->mapping( __FILE__, __LINE__, 'Implementation ' . $metric->implementation . ' not found in database. ' );
        return false;
      }
      
      $data = array(
        'did' => $did,
        'source' => $runId,
        'function' => ''.$metric->name,
        'implementation_id' => $implementation_record->id );
      if( $did_global !== false )
        $data['parent'] = $did_global;
      
      if( property_exists($metric, 'stdev') ) $data['stdev'] = ''.$metric->stdev;
      if( property_exists($metric, 'sample_size') ) $data['sample_size'] = ''.$metric->sample_size;
      if( property_exists($metric, 'label') ) $data['label'] = ''.$metric->label;
      if( property_exists($metric, 'value') ) $data['value'] = ''.$metric->value;
      if( property_exists($metric, 'array_data') ) $data['array_data'] = arr2string( $metric->array_data );
      
      if( $repeat !== false && $fold !== false && $sample !== false ) {
        $data['repeat'] = $repeat;
        $data['fold'] = $fold;
        $data['sample'] = $sample;
        $this->Evaluation_sample->insert( $data );
        return true;
      } else if( $repeat !== false && $fold !== false ) {
        $data['repeat'] = $repeat;
        $data['fold'] = $fold;
        $this->Evaluation_fold->insert( $data );
        return true;
      } else if( $repeat === false && $fold === false && $sample === false ) {
        $this->Evaluation->insert( $data );
        return true;
      } else {
        return false;
      }
    }
  }
  
  private function getEvalEngineMeasureByName( $needle, $evalEngineMeasures ) {
    foreach( $evalEngineMeasures as $measure ) {
      if( $measure->name == $needle ) {
        return $measure;
      }
    }
    return false;
  }
  
  private function measureConsistent( $userProvided, $evalEngine ) { 
    if( property_exists( $userProvided, 'value' ) != property_exists( $evalEngine, 'value' ) ) {
      return false;
    }
    if( property_exists( $userProvided, 'value' ) ) {
      if( abs( $userProvided->value - $evalEngine->value ) > $this->config->item('double_epsilon') ) {
        return false;
      }
    }
    return true;
  }
}
?>