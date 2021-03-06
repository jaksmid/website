// auto-suggest for the filters
function updateUploader(name){
  console.log('Uploader is ' + name);
  $('#uploader').val(name+'');
  updateQuery("uploader");
  $('#searchform').submit();
}

// Update search query upon user actions
function updateQuery(type)
{
  var constr = '';
  if(type == 'source_data.name')
    constr = $("#"+type.replace('.name','')).val().replace(/\s/g,"_");
  else if(type == 'run_task.tasktype.tt_id')
    constr = $("#run_task\\.tasktype\\.tt_id").val();
  else
    constr = $("#"+type.replace('.','\\.')).val().replace(/\s/g,"_");
  var query = $("#openmlsearch").val();
  if(query.indexOf(type+":") > -1){
    var qparts = query.match(/(?:[^\s"]+|"[^"]*")+/g);
    for (i = 0; i < qparts.length; i++) {
      if(qparts[i].indexOf(type+":") > -1){
        attr = qparts[i].split(":");
        attr[1] = constr;
        qparts[i] = attr.join(":");
        query = qparts.join(" ");
      }
    }
  } else {
    query += " "+type+":"+constr;
  }
  if(!constr){
    query = query.replace(" "+type+":",'');
    query = query.replace(type+":",'');
  }
  $("#openmlsearch").val(query);
}


  $(document).ready(function () {


// Reset all search filters
function removeFilters()
{
  var query = $("#openmlsearch").val();
  var newQuery = "";
  if(query.indexOf(":") > -1){
    var qparts = query.match(/(?:[^\s"]+|"[^"]*")+/g);
    for (i = 0; i < qparts.length; i++) {
      if(qparts[i].indexOf(":") == -1){
        newQuery += " "+qparts[i];
      }
    }
  } else {
    newQuery = query;
  }
  $("#openmlsearch").val(newQuery);
}

 function bindInput(elem){
   $('#'+elem.replace(/\./g, '\\.')).keyup(function(event) {
     if (event.keyCode == 13) { $('#searchform').submit();}
     else {updateQuery(elem);}});
 }

    // fetch counts for menu bar
    client.search(<?php echo json_encode($this->alltypes); ?>).then(function (body) {
      var buckets = body.aggregations.type.buckets;
      for (var b in buckets.reverse()){
        $('#'+buckets[b].key+'counter').html(buckets[b].doc_count);
      }
    }, function (error) {
      console.trace(error.message);
    });

    //autocomplete
    $(document).on("change, keyup", "#uploader", function() { updateQuery("uploader"); });

    //normal typing
    bindInput("qualities.NumberOfInstances");
    bindInput("qualities.NumberOfFeatures");
    bindInput("qualities.NumberOfMissingValues");
    bindInput("qualities.NumberOfClasses");
    bindInput("qualities.DefaultAccuracy");
    bindInput("tags.tag");
    bindInput("tasktype.tt_id");
    bindInput("task_id");
    bindInput("estimation_procedure.proc_id");
    bindInput("source_data.name");
    bindInput("run_id");
    bindInput("run_task.task_id");
    bindInput("run_task.tasktype.tt_id");
    bindInput("run_flow.flow_id");
    bindInput("flow_id");
    bindInput("version");
    bindInput("type");
    bindInput("task_id");

    //buttons
    $("#removefilters").click(function() { console.log("click"); removeFilters(); $('#searchform').submit();});
    $('#research').click(function() { $('#searchform').submit();});

    // deleting items
    $(document).on('click', '.delete_action', function(event) {
         var itemName = $(this).data("name");
         var itemID = $(this).data("id");
         var itemType = $(this).data("type");
         swal({title: "Are you sure?",
               text: "You are about to delete "+itemName+". You will not be able to recover this "+itemType+"!",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Yes, delete it!",
               closeOnConfirm: false},
             function(){
               deleteItem( itemType, itemID, itemName );
             });
        return false;
    });

    function deleteItem( type, id, name ) {
    $.ajax({
      type: "DELETE",
      url: "<?php echo BASE_URL; ?>api_new/v1/"+type+"/"+id,
      dataType: "xml"
    }).done( function( resultdata ) {
        id_field = $(resultdata).find("oml\\:id, id");
        if( id_field.length ) {
          swal("Deleted!", name + " has been deleted.", "success");
          location.reload();
        } else {
          code_field = $(resultdata).find("oml\\:code, code");
          message_field = $(resultdata).find("oml\\:message, message");
          swal("Error " + code_field.text(), message_field.text(), "error");
        }
      }).fail( function( resultdata ) {
          console.log(resultdata.responseText);
          code_field = $(resultdata.responseText).find("oml\\:code, code");
          message_field = $(resultdata.responseText).find("oml\\:message, message");
          if(code_field.text() == 102)
            swal("Error", "Your login has expired. Log in and try again.", "error");
          else
            swal("Error " + code_field.text(), message_field.text(), "error");
      });
    }

    <?php
    if($this->table) {
    ?>
      $('#tableview').dataTable( {
    		"responsive": "true",
    		"dom": 'CT<"clear">lfrtip',
    		"aaData": <?php echo json_encode($this->tableview); ?>,
        "scrollY": "600px",
        "scrollCollapse": true,
    		"deferRender": true,
        "paging": false,
    		"processing": true,
    		"bSort" : true,
    		"bInfo": false,
    		"tableTools": {
    						"sSwfPath": "//cdn.datatables.net/tabletools/2.2.3/swf/copy_csv_xls_pdf.swf"
    				},
    		"aaSorting" : [],
    		"aoColumns": [
    	  <?php
          $cnt = sizeOf($this->cols);
    			foreach( $this->tableview[0] as $k => $v ) {
    			$newcol = '{ "mData": "'.$k.'" , "defaultContent": "", ';
    			if(is_numeric($v))
    				$newcol .= '"sType":"numeric", ';
    			if($k == 'name' || $k == 'runs' || $k == 'NumberOfInstances' || $k == 'NumberOfFeatures' || $k == 'NumberOfClasses')
          	$newcol .= '"bVisible":true},';
    			else
    				$newcol .= '"bVisible":false},';
    			if(array_key_exists($k,$this->cols)){
    				$this->cols[$k] = $newcol;
    			} else {
    				//$this->cols[] = $newcol;
    				$cnt++;
    			}
    		  	}
    			foreach( $this->cols as $k => $v ) {
     				echo $v;
    			}?>

    		]
    	    } );

    	$('.topmenu').show();

    function toggleResults( resultgroup ) {
    	var oDatatable = $('#tableview').dataTable(); // is not reinitialisation, see docs.

    	redrawScatterRequest = true;
    	redrawLineRequest = true;
    	for( var i = 1; i < colcount; i++) {
    		if( i > colmax * resultgroup && i <= colmax * (resultgroup+1) )
    			oDatatable.fnSetColumnVis( i, true );
    		else
    			oDatatable.fnSetColumnVis( i, false );
    	}
    }
    <?php } ?>

    if ( $( "#uploader" ).length ) {
    $("#uploader").autocomplete({
      html: true,
      position: {
          my: "left top+13" // Shift 0px to the left, 20px down.
      },
      source: function(request, fresponse) {
        client.suggest({
          index: 'openml',
          type: 'user',
          body: {
            mysuggester: {
              text: request.term,
              completion: {
                field: 'suggest',
                size: 10
              }
            }
          }
        }, function (error, response) {
          fresponse($.map(response['mysuggester'][0]['options'], function(item) {
            console.log(item['text']);
            if(item['payload']['type'] == 'user'){
            return {
              type: item['payload']['type'],
              id: item['payload'][item['payload']['type']+'_id'],
              text: item['text']
            };}
          }));
        });
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
      .append( '<a onclick="updateUploader(\'' + item.text + '\')"><i class="' + icons[item.type] + '"></i> ' + item.text + '</a>' )
      .appendTo( ul );
    }
  }

  });
