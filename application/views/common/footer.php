<div>Footer</div>	

	<? if (isset($js)) { ?>
		<? foreach ($js as $js_file) { ?>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/<?php echo $js_file;?>"></script>
		<? } ?>	
	<? } ?>

	</body>
</html>
