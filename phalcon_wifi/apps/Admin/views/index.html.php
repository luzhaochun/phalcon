<?= \Phalcon\Tag::getDoctype() ?>
<html>
	<head>
		<title>Wifi营销精灵--<?php echo $title; ?></title>	
		<?php echo $this->tag->stylesheetLink('css/global.css'); ?>	
		<?php echo $this->tag->stylesheetLink('css/main.css'); ?>	
		<?php echo $this->tag->javascriptInclude('js/jquery-1.11.0.min.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/DD_belatedPNG.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/main.js'); ?>
		<script>
		    DD_belatedPNG.fix('*');
		</script>
	</head>
	<body>
		<?php echo $this->getContent(); ?>
	</body>
</html>