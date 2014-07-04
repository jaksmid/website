<!doctype html>
<!--[if lt IE 7]> 
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en">
<![endif]-->
<!--[if IE 7]>    
<html class="no-js lt-ie9 lt-ie8" lang="en">
<![endif]-->
<!--[if IE 8]>    
<html class="no-js lt-ie9" lang="en">
<![endif]-->
<!--[if gt IE 8]><!--> 

<html class="no-js" lang="en" xmlns:og="http://ogp.me/ns#">
    <!--<![endif]-->
    <head>
        <base href="<?php echo BASE_URL; ?>" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
        <title>OpenML</title>
        <meta name="description" content="OpenML: exploring machine learning better, together. An open science platform for machine learning.">
	<link href="http://www.openml.org/img/expdblogo2.png" rel="image_src" />
        <meta name="author" content="Joaquin Vanschoren">
        <meta property="og:title" content="OpenML"/>
        <meta property="og:url" content="http://www.openml.org"/>
        <meta property="og:image" content="http://www.openml.org/img/expdblogo2.png"/>
        <meta property="og:site_name" content="OpenML: exploring machine learning better, together."/>
        <meta property="og:description" content="OpenML: exploring machine learning better, together. An open science platform for machine learning."/>
        <meta property="og:type" content="Science"/>
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/expdb.css">
        <link rel="stylesheet" href="css/share.css">
        <link rel="stylesheet" href="css/docs.css">
        <link rel="stylesheet" href="css/pygments-manni.css">
        <link rel="stylesheet" href="css/prettify.css">
        <link rel="stylesheet" href="css/codemirror.css">
        <link rel="stylesheet" href="css/eclipse.css">
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css"/>
        <link rel="stylesheet" href="css/datatables_custom.css" type="text/css"/>
        <link rel="stylesheet" href="css/TableTools.css" type="text/css"/>
        <link rel="stylesheet" href="css/datatables.bootstrap.css" type="text/css"/>
        <link rel="stylesheet" href="css/MyFontsWebfontsKit.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/bootstrap-slider.css">
        <link rel="shortcut icon" href="img/favicon.ico">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/libs/jquery.validate.js"></script>	
        <script type="text/javascript" src="js/libs/modernizr-2.5.3-respond-1.1.0.min.js" ></script>
        <script type="text/javascript" src="js/libs/processing.js" ></script>
        <script type="text/javascript" src="js/libs/dat.gui.min.js" ></script>
        <script type="text/javascript" src="js/libs/codemirror.js" ></script>
        <script type="text/javascript" src="js/libs/mysql.js" ></script>
        <!-- <script type="text/javascript" src="js/libs/highcharts.js"></script> -->
        <script type="text/javascript" src="js/libs/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/libs/jquery.dataTables.TableTools.min.js"></script>
        <script type="text/javascript" src="js/libs/jquery.dataTables.bootstrap.js"></script>
        <script type="text/javascript" src="js/libs/jquery.form.js"></script>
        <script type="text/javascript" src="js/libs/jquery.sharrre.js"></script>
        <script type="text/javascript" src="js/libs/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/libs/bootstrap-slider.js" ></script>
        <script type="text/javascript" src="js/libs/rainbowvis.js"></script>
        <script type="text/javascript" src="js/libs/elasticsearch.jquery.min.js"></script>
        <script type="text/javascript" src="js/openml.js"></script>
        <?php if( isset( $this->load_javascript ) ): foreach( $this->load_javascript as $j ): ?>
        <script type="text/javascript" src="<?php echo $j; ?>"></script>
        <?php endforeach; endif; ?>

        <!-- page dependent javascript code -->
        <script type="text/javascript"><?php echo script();?></script>
    </head>
    <body onresize="try{updateCanvasDimensions()}catch(err){}">
        <!--[if lt IE 7]>
        <p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
        <![endif]-->

        <div class="navbar navbar-static-top" style="margin-bottom: 0px;">
            <div class="navbar-inner">
	    <?php if(false === strpos(BASE_URL, $_SERVER['REQUEST_URI'])) { ?>
		<a class="sectionheader sectionlogo" href="#"><img src="img/openmlicon.png"></a>
	    <?php } ?>
	      <div class="searchheader">
		<form class="form-inline" method="get" id="searchform" action="search">
		  <input type="hidden" name="type" value="<?php if(array_key_exists("type",$_GET)) echo safe($_GET["type"]);
				elseif(false !== strpos($_SERVER['REQUEST_URI'],'/d')) echo 'data';
				elseif(false !== strpos($_SERVER['REQUEST_URI'],'/t')) echo 'task';
				elseif(false !== strpos($_SERVER['REQUEST_URI'],'/f')) echo 'flow';
				elseif(false !== strpos($_SERVER['REQUEST_URI'],'/r')) echo 'run';
				elseif(false !== strpos($_SERVER['REQUEST_URI'],'/a')) echo 'measure';				
		  	  ?>"> 
		  <input type="text" class="form-control" id="openmlsearch" name="q" placeholder="Search" onfocus="this.placeholder = 'Search datasets, flows, tasks, people,... (leave empty to see all)'" value="<?php if( isset( $this->terms ) ) echo htmlentities($this->terms); ?>" />
		 <!-- <button class="btn btn-primary btn-small" type="submit" style="height: 30px; vertical-align:top; font-size: 8pt;"><i class="fa fa-search fa-lg"></i></button>-->
		</form>
	       </div>
                    <a class="nav pull-right socialshare socialshareicon" id="popover">
                     <i class="fa fa-th fa-2x"></i>
                    </a>
                    <a class="nav pull-right socialshare socialshareicon" id="popover2">
                     <i class="fa fa-paper-plane fa-lg"></i>
                    </a>
			<div class="nav pull-right">
			  <a href="#" class="dropdown-toggle socialshare socialshareicon" data-toggle="dropdown"><i class="fa fa-plus fa-2x"></i></a>
			  <ul class="dropdown-menu newmenu">
			    <li><a href="new/data"><i class="fa fa-fw fa-database"></i> New data</a></li>
		            <li class="divider"></li>
			    <li><a href="new/flow"><i class="fa fa-fw fa-cogs"></i> New flow</a></li>
		            <li class="divider"></li>
			    <li><a href="new/run"><i class="fa fa-fw fa-star"></i> New run</a></li>
		            <li class="divider"></li>
			    <li><a href="new/task"><i class="fa fa-fw fa-trophy"></i> New task</a></li>
		            <li class="divider"></li>
			    <li><a href="new/tasktype"><i class="fa fa-fw fa-flag"></i> New task type</a></li>
			  </ul>
			</div>

                    <!-- <a class="brand" href="" style="float:left">OpenML</a> -->
			<div class="nav pull-right">
                                <a href="#" class="dropdown-toggle socialshare socialshareicon" data-toggle="dropdown"><?php if ($this->ion_auth->logged_in()) echo '<i class="fa fa-graduation-cap fa-2x" style="color:green;"></i>'; else echo '<i class="fa fa-user fa-2x"></i>' ?></a>
                                <ul class="dropdown-menu">
                                    <?php if (!$this->ion_auth->logged_in()): ?>
                                    <li><a href="login">Sign in</a></li>
                                    <li class="divider"></li>  
                                    <li><a href="register">Register</a></li>
                                    <?php else: ?>
		                                <?php if ($this->ion_auth->user()->row()->external_source == false ): ?>
		                                <li><a href="profile"><?php echo user_display_text(); ?></a></li>
		                                <li class="divider"></li>
		                                <li><a href="overview_runs">My runs</a></li>
		                                <li class="divider"></li>
		                                <?php endif; ?>
                                    <li><a href="frontend/logout">Sign off</a></li>
                                    <?php endif; ?>
                                </ul>
                        </div>
                    <!--/.nav-collapse -->
            </div>
        </div>
	<div id="openmllinks">
	  <div class="iconrow">
	  <a href="d"><div class="iconcell icongreen"><i class="fa fa-database fa-3x"></i><br><span>data</span></div></a>
	  <a href="t"><div class="iconcell iconyellow"><i class="fa fa-trophy fa-3x"></i><br><span>tasks</span></div></a>
	  <a href="f"><div class="iconcell iconblue"><i class="fa fa-cogs fa-3x"></i><br><span>flows</span></div></a>
	  <a href="r"><div class="iconcell iconred"><i class="fa fa-star fa-3x"></i><br><span>runs</span></div></a>
	  </div><div class="iconrow">
	  <a href="a"><div class="iconcell icongray"><i class="fa fa-bar-chart-o fa-3x"></i><br><span>analytics</span></div></a>
	  <a href="plugins"><div class="iconcell icongray"><i class="fa fa-wrench fa-3x"></i><br><span>tools</span></div></a>
	  <a href="developers"><div class="iconcell icongray"><i class="fa fa-users fa-3x"></i><br><span>developers</span></div></a>
	  <a href="community"><div class="iconcell icongray"><i class="fa fa-comments fa-3x"></i><br><span>forum</span></div></a>
	  </div>
	</div>
	<div id="sociallinks">
		<div class="socialcontainer">
		<div class="sharetitle">Spread the word</div>
		<div id="social-bar">
		  <div id="twitter" data-url="http://openml.org" data-text="Check out #OpenML at openml.org" data-title="twitter"></div>
		  <div id="facebook" data-url="http://openml.org" data-text="Check out OpenML at openml.org" data-title="facebook"></div>
		  <div id="googleplus" data-url="openml.org" data-text="Check out OpenML at openml.org" data-title="google-plus"></div>
		  <div id="linkedin" data-url="http://openml.org" data-text="Check out OpenML at openml.org" data-title="linkedin"></div>
		  <!--<div id="pinterest" data-url="http://openml.org" data-text="Check out OpenML at openml.org" data-title="pinterest"></div>-->
        	  <script type="text/javascript" src="js/share.js"></script>
		</div>
		</div>
		<div class="socialcontainer">
		<div class="sharetitle">Follow us</div>
		<div id="social-bar">
                <a href="https://twitter.com/open_ml" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/openml" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="https://plus.google.com/communities/105075769838900568763" target="_blank">
                    <i class="fa fa-google-plus"></i>
                </a>
                <a href="https://github.com/openml" target="_blank">
                    <i class="fa fa-github"></i>
                </a>
            	</div>
		</div>
              </div>
	</div><!-- /.sociallinks -->
        <script>
            $(document).ready(function(){ 
            	$("#loginForm").validate({ }); 
            	$('#loginModal').on('shown', function () {
            		$("#inputEmail").focus();
            	})
            });
        </script>

        <div id="wrap">
            <!-- USER MESSAGE -->
            <noscript>
                <div class="alert alert-error" style="text-align:center;">
                    JavaScript is required to properly view the contents of this page!
                </div>
            </noscript>
            <?php if($this->message!==false and strlen($this->message) > 0): ?>
            <div class="alert alert-info" style="text-align:center;margin-bottom:0px">
                <?php echo $this->message; ?>
            </div>
            <?php endif; echo body(); ?>
        </div>

	<div class="openmlfooter">
		<div class="container-fluid corrected">
		<div class="row">

		  <div class="col-xs-12 col-sm-6 col-md-6 pull-right-lg">
                    <ul class="openml-contact">
                        <li><a href="mailto:openmachinelearning@gmail.com" target="_blank"><i class="fa fa-edit fa-2x"></i><br />email</a></li>
                        <li><a href="https://twitter.com/intent/tweet?screen_name=joavanschoren&text=%23openml.org" data-related="joavanschoren"><i class="fa fa-twitter fa-2x"></i><br />tweet</a></li>
			<li><a href="https://www.facebook.com/openml" target="_blank"><i class="fa fa-facebook fa-2x"></i><br />comment</a></li>
                        <li><a href="https://plus.google.com/communities/105075769838900568763" target="_blank"><i class="fa fa-google-plus fa-2x"></i><br />comment</a></li>
                        <li><a href="community"><i class="fa fa-comments-o fa-2x"></i><br />forum</a></li>
			<li><a href="https://github.com/openml/OpenML/issues?state=open" target="_blank"><i class="fa fa-github fa-2x"></i><br />issues</a></li>
                    </ul>
		  </div>

		  <div class="col-xs-6 col-sm-3 col-md-2 pull-left-lg">
                    <ul class="openml-footer">
                        <li>Hosted by</li>
                        <li><a href="http://dtai.cs.kuleuven.be" target="_blank">University of Leuven</a></li>
                        <li><a href="http://datamining.liacs.nl" target="_blank">Leiden University</a></li>
                        <li><a href="http://www.tue.nl/universiteit/faculteiten/faculteit-w-i/onderzoek/de-onderzoeksinstituten/data-science-center-eindhoven-dsce/" target="_blank">Eindhoven University of Technology</a></li>
                    </ul>
		  </div>

		  <div class="col-xs-6 col-sm-3 col-md-2 pull-left-lg">
                    <ul class="openml-footer">
 			<li>Funded by</li>
                        <li><a href="http://www.nwo.nl/" target="_blank">NWO</a></li>
                        <li><a href="http://www.pascal-network.org/" target="_blank">PASCAL Network</a></li>
                    </ul>
     	    	  </div>

		</div>
		</div>


	</div>


        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/application.js"></script>
	<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
        <script type="text/javascript" src="js/libs/modules/exporting.js"></script>
	<script type="text/javascript">$('.tip').tooltip();</script>
        <script>
			$(document).ready(function(){
				$('#popover').popover({
				    trigger: 'click',
				    placement: 'bottom',
				    html: true,
				    container: 'body',
				    animation: 'false',
				    content: function() { return $('#openmllinks').html(); }
				}); 
				$('#popover2').popover({
				    trigger: 'click',
				    placement: 'bottom',
				    html: true,
				    container: 'body',
				    animation: 'false',
				    content: $('#sociallinks')
				}); 
				$('#popover').on('shown.bs.popover', function () {
 					 $('.popover').css('left','inherit')
 					 $('.popover').css('right','10px')
 					 $('.arrow').css('left','inherit')
 					 $('.arrow').css('right','10px')
				})
				$('#popover2').on('shown.bs.popover', function () {
 					 $('.popover').css('left','inherit')
 					 $('.popover').css('right','10px')
 					 $('.arrow').css('left','inherit')
 					 $('.arrow').css('right','55px')
					 $('#sociallinks').css('display','block')
				})
				$('#popover2').on('hide.bs.popover', function () {
					 $('body').append($('#sociallinks'))
					 $('#sociallinks').css('display','none')
				})
			});
			$(document).click(function (e) {
			    $('#popover').each(function () {
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				    if ($(this).data('bs.popover').tip().hasClass('in')) {
					$(this).popover('toggle');
				    }
				    return;
				}
			    });
			    $('#popover2').each(function () {
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				    if ($(this).data('bs.popover').tip().hasClass('in')) {
					$(this).popover('toggle');
				    }
				    return;
				}
			    });
			});
			$('body').on('hidden.bs.modal', '.modal', function () {
			  $(this).removeData('bs.modal');
			});
        </script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
	    ga('require', 'linkid', 'linkid.js');
            ga('create', 'UA-40902346-1', 'openml.org');
            ga('send', 'pageview');
        </script>


    </body>
</html>

