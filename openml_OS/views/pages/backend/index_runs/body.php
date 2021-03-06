<div class="container-fluid topborder endless guidecontainer openmlsectioninfo">
  <div class="col-xs-12 col-md-10 col-md-offset-1 guidesection" id="mainpanel">

	<?php if($this->messages) { ?>
	<div class="alert alert-success" role="alert">
	<?php foreach( $this->messages as $m ):
                  echo $m.' <br>';
              endforeach; ?><br />
	</div>
	<?php } ?>
<div class="col-lg-12">
	<h1>Elasticsearch indexer</h1>
	Status: <?php if($this->elasticsearch->test()) echo 'Connection successful. Happy indexing!'; else echo 'Connection failed. Likely, Elasticsearch is not running.'; ?>
</div>
<div class="col-sm-6">
	<h2>Rebuild indices</h2>
	<form method="post" action="">
	<?php foreach( $this->types as $t ): ?>
                  <input type="checkbox" class="check_setups" name="types[]" value="<?php echo $t; ?>" <?php if(in_array($t,$this->index_types)) echo 'checked="yes";'?>/>&nbsp;<?php echo $t; ?><br>
        <?php endforeach; ?><br />
	<input class="btn btn-primary" type="submit" value="Rebuild indexes"/>
        </form>
</div>
<div class="col-sm-6">
	<h2>Reinitialize indices</h2>
	<form method="post" action="">
	<?php foreach( $this->default_types as $t ): ?>
                  <input type="checkbox" class="check_setups" name="inittypes[]" value="<?php echo $t; ?>" <?php if(in_array($t,$this->init_types)) echo 'checked="yes";'?>/>&nbsp;<?php echo $t; ?><br>
        <?php endforeach; ?><br />
	<input class="btn btn-primary" type="submit" value="Reinitialize indexes"/>
        </form>
</div>
<div class="col-sm-12">
	<h3>Add document</h2>
	<form method="post" action="">
	Type:
	<?php foreach( $this->default_types as $t ): ?>
                  <input type="radio" class="check_setups" name="type" value="<?php echo $t; ?>"/>&nbsp;<?php echo $t; ?>
        <?php endforeach; ?><br />
	ID: <input type="text" name="doc_id"/>
	<input class="btn btn-primary" type="submit" value="index"/>
        </form>
</div>

<div class="submenu">
  <ul class="sidenav nav" id="accordeon">
    <li class="panel guidechapter">
      <a data-toggle="collapse" data-parent="#accordeon"  data-target="#pagelist"><i class="fa fa-wrench fa-fw fa-lg"></i> <b>Tools</b></a>
      <ul class="sidenav nav collapse in" id="pagelist">
        <?php foreach( $this->directories as $d ): ?>
          <li><a href="backend/page/<?php echo $d; ?>"><?php echo text_neat_ucwords($d); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </li>
  </ul>
</div>
  </div>
</div>
