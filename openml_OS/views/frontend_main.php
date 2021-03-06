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
        <link rel="shortcut icon" href="img/favicon.ico">

        <link rel="stylesheet" href="css/pygments-manni.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/material-fullpalette.min.css">
        <link rel="stylesheet" href="css/expdb.css">
        <link rel="stylesheet" href="css/prettify.css">
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css"/>
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
      	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=RobotoDraft:400,500,700,400italic" rel="stylesheet" type="text/css">
        <?php if( isset( $this->load_css ) ): foreach( $this->load_css as $j ): ?>
        <link rel="stylesheet" href="<?php echo $j; ?>"/>
        <?php endforeach; endif;?>

        <?php $this->endjs = ""; ?>
    </head>
    <body>
  <?php
      $section = "OpenML";
      $materialcolor = "blue";
      $href = "";
      $url = explode('/', $_SERVER['REQUEST_URI']);
      $ch = $url[1];
      $req = array_slice($url, 1);
      if(sizeof($url)>2){
        if($url[1] == 'OpenML'){
          $ch = $url[2];
          $req = array_slice($url, 2);}
        }
      if($ch == "")
        $ch = "home";
      $ch = explode('?',$ch)[0];
      $req = explode('?',implode('/',$req))[0];
      if(strpos($ch, 'search') === 0){
        if(isset($this->filtertype) and $this->filtertype){
            $section = str_replace('_',' ',ucfirst($this->filtertype));
            if($section=='User')
              $section = 'People';
            $href = "search?type=".$this->filtertype;
          }
        else{
          $section = 'Search';
          $materialcolor = "blue";
        }
      }
      if($ch=='r' or $section=='Run'){
            $section = 'Run';
            $href = 'search?type=run';
            $materialcolor = "red";
          }
      elseif($ch=='d' or $section=='Data'){
            $section = 'Data';
            $href = 'search?type=data';
            $materialcolor = "green";
          }
      elseif($ch=='f' or $section=='Flow'){
            $section = 'Flow';
            $href = 'search?type=flow';
            $materialcolor = "blue";
          }
      elseif($ch=='t' or $section=='Task'){
            $section = 'Task';
            $href = 'search?type=task';
            $materialcolor = "orange-600";
          }
      elseif($ch=='tt' or $section=='Task type'){
            $section = 'Task type';
            $href = 'search?type=tasktype';
            $materialcolor = "deep-orange";
          }
      elseif($ch=='u' or $section=='People'){
            $section = 'People';
            $href = 'search?type=user';
            $materialcolor = "light-blue";
          }
      elseif($ch=='a' or $section=='Measure'){
            $section = 'Measure';
            $href = $ch;
            $materialcolor = "blue-grey";
          }
      elseif($ch=='s' or $section=='Study'){
            $section = 'Study';
            $href = 'search?type=study';
            $materialcolor = "deep-purple";
          }
      elseif(substr( $ch, 0, 5 ) === "guide"){
            $section = 'Guide';
            $href = $ch;
            $materialcolor = "green";
          }
      elseif($ch=='discuss' || $ch=='discuss_new'){
            $section = 'Discuss';
            $href = $ch;
            $materialcolor = "purple";
          }
      elseif($ch=='backend'){
            $section = 'Backend';
            $href = $ch;
            $materialcolor = "red";
          }
      elseif($ch=='query'){
            $section = 'Query';
            $href = $ch;
            $materialcolor = "blue";
          }
      elseif($ch=='register' or $ch=='profile' or $ch=='frontend' or $ch=='login' or $ch=='password_forgot'){
            $section = 'OpenML';
            $href = $ch;
            $materialcolor = "blue";
          }

    $this->materialcolor = $materialcolor;
    $this->user = $this->ion_auth->user()->row();
    $this->image = array(
    	'name' => 'image',
    	'id' => 'image',
    	'type' => 'file',
    );
  ?>
        <div class="navbar navbar-static-top navbar-fixed-top navbar-material-<?php echo $materialcolor;?>" id="openmlheader" style="margin-bottom: 0px;">
            <div class="navbar-inner">
              <div class="col-xs-5 col-sm-3 col-md-3">
              <div class="nav pull-left">
                <a class="navbar-brand" id="menubutton"><i class="fa fa-bars fa-lg"></i></a>
              </div>
              <a class="navbar-brand" id="section-brand" href="<?php echo $href; ?>"><?php echo $section;?></a>
            </div>
            <a class="openmlsoc openmlsocicon col-xs-2 hidden-sm hidden-md hidden-lg pull-left searchicon" onclick="showsearch()"><i class="fa fa-search fa-2x"></i></a>

       <div class="menuicons">
			<?php if ($this->ion_auth->logged_in()) { ?>
        <div class="nav pull-right openmlsocicons">
          <a href="#" class="dropdown-toggle openmlsoc openmlsocicon" data-toggle="dropdown" style="padding-top:12px;">
            <img src="<?php echo htmlentities( authorImage( $this->user->image ) ); ?>" width="35" height="35" class="img-circle" alt="<?php echo $this->user->first_name . ' ' . $this->user->last_name; ?>" /></a>
          <ul class="dropdown-menu">
              <li><a href="u/<?php echo $this->user->id;?>"><?php echo user_display_text(); ?></a></li>
              <li class="divider"></li>
              <li><a href="frontend/logout">Sign off</a></li>
          </ul>
        </div>

  			<div class="nav pull-right openmlsocicons">
  			  <a href="#" class="dropdown-toggle openmlsoc openmlsocicon" data-toggle="dropdown"><i class="fa fa-plus fa-2x"></i></a>
  			  <ul class="dropdown-menu newmenu">
  			    <li><a href="new/data" class="icongreen"><i class="fa fa-fw fa-lg fa-database"></i> New data</a></li>
  		            <li class="divider"></li>
  			    <li><a href="new/task" class="iconyellow"><i class="fa fa-fw fa-lg fa-trophy"></i> New task</a></li>
  		            <li class="divider"></li>
  			    <li><a href="new/flow" class="iconblue"><i class="fa fa-fw fa-lg fa-cogs"></i> New flow</a></li>
  		            <li class="divider"></li>
  			    <li><a href="new/run" class="iconred"><i class="fa fa-fw fa-lg fa-star"></i> New run</a></li>
              <!--    <li class="divider"></li>
            <li><a href="new/study" class="iconpurple"><i class="fa fa-fw fa-lg fa-flask"></i> New study</a></li>-->
  			  </ul>
  			</div>

        <div class="nav pull-right openmlsocicons">
          <a href="guide" class="openmlsoc openmlsocicon"><i class="fa fa-leanpub fa-2x"></i></a>
        </div>
        <script>var logged_in = true;</script>
			<?php } else { ?>
        <script>var logged_in = false;</script>
			<div class="nav pull-right openmlsocicons">
                  <a href="guide" class="btn btn-material-<?php echo $materialcolor;?>">Guide</a>
                  <a class="btn btn-material-<?php echo $materialcolor;?>" data-toggle="modal" data-target="#login-dialog">Sign in</a>
      </div>
			<?php } ?>
      </div>


      <div class="hidden-xs col-sm-6 col-md-6" id="menusearchframe">
<form class="navbar-form" method="get" id="searchform" action="search">
  <input type="text" class="form-control col-lg-8" id="openmlsearch" name="q" placeholder="Search" onfocus="this.placeholder = 'Search datasets, flows, tasks, people,... (leave empty to see all)'" value="<?php if( isset( $this->terms ) ) echo htmlentities($this->terms); ?>" />
  <input type="hidden" name="type" value="<?php if(array_key_exists("type",$_GET)) echo safe($_GET["type"]);
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/d')) echo 'data';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/t')) echo 'task';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/f')) echo 'flow';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/r')) echo 'run';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/a')) echo 'measure';
    ?>">
<!-- <button class="btn btn-primary btn-small" type="submit" style="height: 30px; vertical-align:top; font-size: 8pt;"><i class="fa fa-search fa-lg"></i></button>-->
</form>
 </div>


                    <!--/.nav-collapse -->
            </div>
        </div>

        <?php
          loadpage('login', true, 'pre');
          loadpage('login', true, 'body');
        ?>

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
          <?php endif; ?>
          <div class="searchbarcontainer">
          <div class="searchbar" id="mainmenu">
            <ul class="sidenav nav topchapter">
              <?php if (!$this->ion_auth->logged_in()){ ?>
                  <li <?php echo ($section == '' ?  'class="topactive"' : '');?>><a href="register" class="icongrayish"><i class="fa fa-fw fa-lg fa-child"></i> Join OpenML</a></li>
              <?php } else { ?>
                  <li <?php echo ($section == '' ?  'class="topactive"' : '');?>><a href="u/<?php echo $this->user->id; ?>"><img src="<?php echo htmlentities( authorImage( $this->user->image ) ); ?>" width="25" height="25" class="img-circle" alt="<?php echo $this->user->first_name . ' ' . $this->user->last_name; ?>" /> <?php echo user_display_text(); ?></a></li>
              <?php } ?>
                  <li <?php echo ($section == 'Data' ?  'class="topactive"' : '');?>><a href="search?type=data<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="icongreen"><i class="fa fa-fw fa-lg fa-database"></i> Data<span id="datacounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Task' ?  'class="topactive"' : '');?>><a href="search?type=task<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconyellow"><i class="fa fa-fw fa-lg fa-trophy"></i> Tasks<span id="taskcounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Flow' ?  'class="topactive"' : '');?>><a href="search?type=flow<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconblue"><i class="fa fa-fw fa-lg fa-cogs"></i> Flows<span id="flowcounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Run' ?  'class="topactive"' : '');?>><a href="search?type=run<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconred"><i class="fa fa-fw fa-lg fa-star"></i> Runs<span id="runcounter" class="counter"></span></a></li>
                  <!--<li <?php echo ($section == 'Study' ?  'class="topactive"' : '');?>><a href="search?type=study<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconpurple"><i class="fa fa-fw fa-lg fa-flask"></i> Studies<span id="studycounter" class="counter"></span></a></li>-->
                  <li <?php echo ($section == 'Task type' ?  'class="topactive"' : '');?>><a href="search?type=task_type<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconorange"><i class="fa fa-fw fa-lg fa-flag-o"></i> Task Types<span id="task_typecounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Measure' ?  'class="topactive"' : '');?>><a href="search?type=measure<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconbluegray"><i class="fa fa-fw fa-lg fa-bar-chart-o"></i> Measures<span id="measurecounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'People' ?  'class="topactive"' : '');?>><a href="search?type=user<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconblueacc"><i class="fa fa-fw fa-lg fa-users"></i> People<span id="usercounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Guide' ?  'class="topactive"' : '');?>><a href="guide" class="icongreenacc"><i class="fa fa-fw fa-lg fa-leanpub"></i> Guide</a></li>
                  <li <?php echo ($section == 'Discussions' ?  'class="topactive"' : '');?>><a href="discuss" class="iconpurple"><i class="fa fa-fw fa-lg fa-comments"></i> Discuss</a></li>
                  <li <?php echo ($section == 'Blog' ?  'class="topactive"' : '');?>><a href="https://medium.com/open-machine-learning" class="iconredacc"><i class="fa fa-fw fa-lg fa-heartbeat"></i> Blog</a></li>
                  <!--<li <?php echo ($section == 'Search' ?  'class="topactive"' : '');?>><a href="search" class="icongray"><i class="fa fa-fw fa-lg fa-search"></i> Search</a></li>-->
            </ul>
            <?php if($ch != "home"){ ?>
            <div class="menuaction"><a onclick="scrollMenuTop()"><i class="fa fa-lg fa-angle-up"></i><i class="fa fa-lg fa-fw fa-navicon"></i></a></div>
            <?php } ?>
            <div class="submenubar">
            <div id="submenucontainer"></div>
            <ul class="sidenav nav">
            <li class="guidechapter-contact">
             <a>Ask us a question...</a>
             <ul class="openml-contact-menu">
               <li><a href="mailto:openmachinelearning@gmail.com" target="_blank"><i class="fa fa-envelope-o fa-fw fa-lg"></i></a></li>
               <li><a href="https://groups.google.com/forum/#!forum/openml" target="_blank"><i class="fa fa-users fa-fw fa-lg"></i></a></li>
               <li><a href="https://plus.google.com/communities/105075769838900568763" target="_blank"><i class="fa fa-google-plus fa-fw fa-lg"></i></a></li>
               <li><a href="https://www.facebook.com/openml" target="_blank"><i class="fa fa-facebook fa-fw fa-lg"></i></a></li>
               <li><a href="https://twitter.com/intent/tweet?screen_name=joavanschoren&text=%23openml.org" data-related="joavanschoren"><i class="fa fa-twitter fa-fw fa-lg"></i></a></li>
               <li><a href="https://github.com/openml/OpenML/issues?q=is%3Aopen"><i class="fa fa-github fa-fw fa-lg"></i></a></li>
             </ul>
            </li>
            </ul>
          </div>
        </div>
        </div>

          <?php echo body(); ?>

        </div>
        <script type="text/javascript">
          function downloadJSAtOnload() {
          var element3= document.createElement("script");
          element3.src = "js/libs/jquery.sharrre.js";
          document.body.appendChild(element3);
          }

          !function(e,t,r){function n(){for(;d[0]&&"loaded"==d[0][f];)c=d.shift(),c[o]=!i.parentNode.insertBefore(c,i)}for(var s,a,c,d=[],i=e.scripts[0],o="onreadystatechange",f="readyState";s=r.shift();)a=e.createElement(t),"async"in i?(a.async=!1,e.head.appendChild(a)):i[f]?(d.push(a),a[o]=n):e.write("<"+t+' src="'+s+'" defer></'+t+">"),a.src=s}(document,"script",[
              '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
              'js/libs/modernizr-2.5.3-respond-1.1.0.min.js',
              '//code.jquery.com/ui/1.10.4/jquery-ui.min.js',
              'js/libs/elasticsearch.jquery.min.js',
              'js/libs/bootstrap.min.js',
              'js/libs/bootstrap-select.js',
              'js/material.min.js',
              'js/libs/jquery.form.js',
              'js/openml.js',
              <?php if( isset( $this->load_javascript ) ): foreach( $this->load_javascript as $j ):
                echo "'".$j."',"; endforeach; endif; ?>
              <?php if( isset( $this->id)){
                echo "'frontend/js/".$req."',";
              } elseif( $ch != 'backend') {?>
              'frontend/js/<?php echo $ch;?>', <?php } ?>
              'js/openmlafter.js'
            ])

          //download js that does not affect DOM and can be loaded after page is rendered
          if (window.addEventListener)
          window.addEventListener("load", downloadJSAtOnload, false);
          else if (window.attachEvent)
          window.attachEvent("onload", downloadJSAtOnload);
          else window.onload = downloadJSAtOnload;
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
