<oml:implementation_licences xmlns:oml="http://openml.org/openml">
	<oml:licences>
		<?php foreach( $licences as $licence ): ?>
			<oml:licence><?php echo $licence; ?></oml:licence>
		<?php endforeach; ?>
	</oml:licences>
</oml:implementation_licences>
