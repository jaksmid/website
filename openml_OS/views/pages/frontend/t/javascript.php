/// DETAIL
<?php  
if(false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {
?>

var oTableRunsShowAll = false;
var evaluation_measure = "<?php echo $this->current_measure; ?>";
var latestOnly = true;
var current_task = "<?php echo $this->task_id; ?>";

var oTableRuns = false;

$(document).ready(function() { 
	$('.pop').popover();
	$('.selectpicker').selectpicker();
});



$(document).ready(function() {
    <?php echo simple_datatable('oTableGeneral','#datatable_general'); ?>
    //Initialse DataTables, with no sorting on the 'details' column
    oTableRuns = $('#datatable_main').dataTable( {
		"bServerSide": true,
		"sAjaxSource": "api_query/table_feed",
		"sServerMethod": "POST",
		"fnServerParams": function ( aoData ) {
			if(oTableRunsShowAll) {
				<?php echo array_to_parsed_string($this->dt_main_all, "aoData.push( { 'value': '[VALUE]', 'name' : '[KEY]' } );\n" ); ?>
			} else {
				<?php echo array_to_parsed_string($this->dt_main, "aoData.push( { 'value': '[VALUE]', 'name' : '[KEY]' } );\n" ); ?>
			}
			aoData.push( { 'value': 'AND function = "'+evaluation_measure+'" AND r.task_id = '+current_task, 'name' : 'base_sql_additional' } );
		},
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 0 ] },
            { "bSearchable": false, "bVisible":    false, "aTargets": [ 1, 2 ] }
        ],
		"sDom": "<'row'<'col-md-6'T><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
		"oTableTools": {
			"sSwfPath": "SWF/tableTools/copy_csv_xls_pdf.swf",
			"aButtons": [
				"copy","print","csv", "pdf",
                {
                    "sExtends":    "text",
                    "sButtonText": "Show all/best results",
					"fnClick": function toggleResults(nButton,oConfig,oFlash) {
						oTableRunsShowAll = !oTableRunsShowAll;
						oTableRuns.fnDraw(true);
					}
                }
            ]
		},
        "aaSorting": [[5, 'desc']],
		"aLengthMenu": [[10, 50, 100, 250], [10, 50, 100, 250]],
		"iDisplayLength" : 50,
		"bAutoWidth": false,
		<?php echo column_widths($this->dt_main['column_widths']); ?>
        "bPaginate": true
    });	

    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables, rather it is done here
     */
    $('#datatable_main tbody td img').on('click', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTableRuns.fnIsOpen(nTr) )
        {
            // This row is already open - close it 
            this.src = "img/datatables/details_open.png";
            oTableRuns.fnClose( nTr );
        }
        else
        {
            // Open this row
            this.src = "img/datatables/details_close.png";
            oTableRuns.fnOpen( nTr, fnFetchParams(oTableRuns, nTr, 2), 'details' );
        }
    } );
} );

function updateTableHeader(){
	$("#value").html(evaluation_measure.charAt(0).toUpperCase()+evaluation_measure.slice(1).replace(/_/g,' '));
}

function redrawchart(){
categoryMap = {};
options = {
            chart: {
                renderTo: 'data_result_visualize',
                type: 'scatter',
		pinchType: 'x',
		spacingTop: 40,
                events: {
                    load: function (event) {
                        $('.tip').tooltip();
                    }
                }
            },
	    title: {
	        text: 'Evaluations per flow (multiple parameter settings)'
	    },
	    subtitle: {
	        text: 'every point is a run, click for details'
	    },
	    yAxis: {
                title: {
                    enabled: false,
                    text: 'Flows'
                },
                categories: [],
		labels: {
                  formatter: function() {
		    var lab = this.value.length > 50 ? this.value.substring(0, 25) + '...' +  this.value.substring(this.value.length - 25) : this.value;
                    return '<a class="hccategory tip" href="f/'+ categoryMap[this.value] +'" title="' + this.value + '">'+ lab +'</a>';
                  },
        	  useHTML: true
		},
                alternateGridColor: '#eeeeff',
                gridLineColor: '#eeeeff',
		reversed: true
            },
            xAxis: {
                title: {
                    text: evaluation_measure.charAt(0).toUpperCase()+evaluation_measure.slice(1).replace(/_/g,' ')
                },
                gridLineWidth: 1
            },
            legend: {
                enabled: false
            },
            credits: {
                 enabled: false
            },
            plotOptions: {
                scatter: {
                    marker: {
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        },
			symbol: 'diamond'
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    }                
		}
            },
            tooltip:{
                followTouchMove: false,
                formatter:function(){
                    return '<div>Flow:<b> '+this.series.yAxis.categories[this.y]+'</b><br>'+ this.series.xAxis.axisTitle.element.textContent + '<b>: ' + this.x+'</b><br>'+ ((typeof this.point.options.z !== 'undefined') ? 'Parameter '+selected_parameter+': <b>'+this.point.options.z+'</b>' : '<i>Click for more info</i>') + '</div>';
                }
            },
            series: [{
		turboThreshold: 0,		
		color: 'rgba(119, 152, 191, .5)',
                data: [],
		point: {
                    events: {
                        click: function(){$('#runModal').modal({remote: 'r/' + this.r + '/html'}); $('#runModal').modal('show');}
                    }
                }
            }]
        };

var theQuery = 'select distinct i.fullname, round(e.value,4) as value, r.rid, i.id from algorithm_setup l, evaluation e, run r, implementation i  where r.setup=l.sid AND l.implementation_id=i.id AND e.source=r.rid AND e.function="'+evaluation_measure+'" AND r.task_id = '+ current_task + ' order by value desc';

var query =  encodeURI("<?php echo BASE_URL; ?>"+"api_query/?q="+theQuery, "UTF-8");
$.getJSON(query,function(jsonData){
        var data = jsonData.data;
	var catcount = 0;
	var map = {};
	var d=[];
	var c=[];
	for(var i=0;i<data.length;i++){
		if (!(data[i][0] in map)){
			map[data[i][0]] = catcount++;
			categoryMap[data[i][0]]= data[i][3]; 
			c.push(data[i][0]);
		}
		d.push({x: parseFloat(data[i][1]), y: map[data[i][0]], r: data[i][2]});
	}

	options.yAxis.categories = c;
	options.series[0].data = d;
	options.chart.height = c.length*18+120;

	coderesultchart = new Highcharts.Chart(options);

}).fail(function(){ console.log('failure', arguments); });
}

function redrawCurves(){
	var options = [];
	var colors = ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'];
			   
        //build options
	options.chart = {};
	options.chart.renderTo='learning_curve_visualize';
	//options.chart.type='line';
	options.chart.width = $('#learning_curve_visualize').width();
	options.chart.height = $('#learning_curve_visualize').width()/2;

	options.credits = {enabled: false};
	options.title = {text: ' '};
	options.xAxis = {};
	options.xAxis.title = 'Sample size';
	options.series = [];
	options.yAxis = {};
	options.legend = {};
		
	options.tooltip = {formatter: function() {return '<b>'+ this.series.name +'</b><br/>'+	this.x +' '+ this.y;}};
	
  var implementationConstraint = '';
  var selectLatest = '';
  if(latestOnly)
	selectLatest = ' AND i.version = (select max(version) from implementation where name = i.name)'
	
  
  var sql = 
    'SELECT `e`.`sample_size`, concat_ws("_",`i`.`name`,`i`.`version`)  AS `name`, `r`.`setup`, avg(`e`.`value`) as `score`, stddev(`e`.`value`) as `stdev` FROM `run` `r`, `evaluation_sample` `e`, `algorithm_setup` `a`, `implementation` `i`, `task` `t` WHERE `e`.`function` = "'+evaluation_measure+'" AND `t`.`ttid` = 3 AND `r`.`rid` = `e`.`source` AND `r`.`setup` = `a`.`sid` AND `a`.`implementation_id` = `i`.`id` AND `r`.`task_id` = `t`.`task_id` AND `t`.`task_id` = '+<?php echo $this->task_id; ?>+selectLatest+' GROUP BY `e`.`sample`, `r`.`setup` ORDER BY `sample`, `name` ASC';
    
var query =  encodeURI("<?php echo BASE_URL; ?>"+"api_query/?q="+sql, "UTF-8");
console.log(query);

$.getJSON(query,function(jsonData){
        var data = jsonData.data;
	var setupcount = 0;
	var map = {}; // setup -> name
	var names = [];
	var ranges = [];
	var averages = [];
	for(var i=0;i<data.length;i++){
		if (!(data[i][2] in map)){
			map[data[i][2]] = setupcount++;
			names.push(data[i][1]);
			ranges.push([]);
			averages.push([]);
			options.series.push({});
			options.series.push({});
		}
		averages[map[data[i][2]]].push([parseFloat(data[i][0]), parseFloat(data[i][3])]);
		ranges[map[data[i][2]]].push([parseFloat(data[i][0]), parseFloat(data[i][3]) - parseFloat(data[i][4]), parseFloat(data[i][3]) + parseFloat(data[i][4])]);
	}
	for(var i=0;i<setupcount;i++){
		options.series[i*2].name = names[i];
		options.series[i*2].data = averages[i];
		options.series[i*2].color = colors[i%9];
		options.series[i*2].zIndex = 1;
		options.series[i*2].marker = {};
		options.series[i*2].marker.lineWidth = 1;
		options.series[i*2].marker.lineColor = colors[i%9];
		options.series[i*2].marker.fillColor = colors[i%9];
		options.series[i*2+1].name = 'range';
		options.series[i*2+1].data = ranges[i];
		options.series[i*2+1].type = 'arearange';
		options.series[i*2+1].linkedTo = ':previous';
		options.series[i*2+1].color = colors[i%9];
		options.series[i*2+1].fillOpacity = 0.3;
		options.series[i*2+1].zIndex = 0;
		options.series[i*2+1].lineWidth = 0;
	}
	coderesultchart = new Highcharts.Chart(options);

}).fail(function(){ console.log('failure', arguments); });

}


$(document).ready(function() {
        <?php if($this->record['type_name'] == 'Learning Curve')
		echo 'redrawCurves();';
	      else
		echo 'redrawchart();';
	?>
});

<?php  
}
?>

