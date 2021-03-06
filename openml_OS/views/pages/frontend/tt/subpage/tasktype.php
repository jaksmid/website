<?php if (isset($this->record['name'])){ ?>

	  <h1><a href="t"><i class="fa fa-flag"></i></a> <?php echo $this->record['name'] ?></h1>

  <div class="panel">
    <?php echo $this->record['description']; ?>
  </div>

		<h2>Inputs</h2>
		<div class='panel table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'input' || $r['requirement'] == 'hidden') continue; ?>
			<tr><td><?php echo $r['name']; ?></td>
			    <td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a></td>
			    <td><?php echo $r['description']; ?></td>
			    <td><?php echo $r['requirement']; ?></td></tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Outputs</h3>
		<div class='panel table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'output' || $r['requirement'] == 'hidden') continue; ?>
			<tr><td><?php echo $r['name']; ?></td>
			    <td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a></td>
			    <td><?php echo $r['description']; ?></td>
			    <td><?php echo $r['requirement']; ?></td></tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Attribution</h3>
		    <div class="panel table-responsive">
		    <table class="table table-striped"><tbody>
		    <tr><td width="40px">Author(s)</td><td><?php echo $this->record['authors'] ?></td></tr>
		    <tr><td width="40px">Contributor(s)</td><td><?php echo $this->record['contributors'] ?></td></tr>
		    </tbody></table></div>

    <h3>Discussions</h3>
    <div class="panel" id="disqus_thread">Loading discussions...</div>
    <script type="text/javascript">
        var disqus_shortname = 'openml'; // forum name
	var disqus_category_id = '3760343'; // Type category
	var disqus_title = '<?php echo $this->record['name']; ?>'; // Type name
	var disqus_url = 'http://www.openml.org/tt/<?php echo $this->id; ?>'; // Data url

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>

    <?php } else { ?>Sorry, this task type is unknown.<?php } ?>
