<?= \Phalcon\Tag::getDoctype() ?>
<html>
	<head>
		<title>Wifi营销精灵--<?php echo $title; ?></title>	
		<?php echo $this->tag->stylesheetLink('css/global.css'); ?>	
<?php echo $this->tag->stylesheetLink('css/main.css'); ?>	
<?php echo $this->tag->javascriptInclude('js/jquery-1.11.0.min.js'); ?>
<?php echo $this->tag->javascriptInclude('js/jquery-validation/dist/jquery.validate.min.js'); ?>
<?php echo $this->tag->javascriptInclude('js/DD_belatedPNG.js'); ?>
<?php echo $this->tag->javascriptInclude('js/My97DatePicker/WdatePicker.js'); ?>
<?php echo $this->tag->javascriptInclude('js/jquery.circliful.js'); ?>
<?php echo $this->tag->javascriptInclude('js/highcharts/highcharts.js'); ?>
<?php echo $this->tag->javascriptInclude('js/highcharts/exporting.js'); ?>
<?php echo $this->tag->javascriptInclude('js/main.js'); ?>
<script>
		DD_belatedPNG.fix('*');
</script>
		<script>
		function dataBackup() {
			var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Ajax','action'=>'dataBackup'));?>";
			$.ajax({
				url : ""+src+"",
				data : { isAjax:true},
				success : function(result) {
					result = jQuery.parseJSON(result);
					alert(result.msg);
					location.reload()
				}
			});
		}
		
		function dataRecovery(fileName) {
			var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Ajax','action'=>'dataRecovery'));?>fileName/" + fileName;
			$.ajax({
				url : ""+src+"",
				data : { isAjax:true},
				success : function(result) {
					result = jQuery.parseJSON(result);
					alert(result.msg);
					location.reload()
				}
			});
		}
		
		function dataDelete(fileName) {
			var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Ajax','action'=>'dataDelete'));?>fileName/" + fileName;
			$.ajax({
				url : ""+src+"",
				data : { isAjax:true},
				success : function(result) {
					result = jQuery.parseJSON(result);
					alert(result.msg);
					location.reload()
				}
			});
		}
		</script>
	</head>
<body>
<div class="inner_box">
	<div class="page_title">
		<div class="title_list"><div style="padding-left:13px;">数据备份-<span>备份还原</span></div></div>
	</div>
	<div class="user_date fl">
		<div class="list_feature clearfix">
			<ul>
				<li><i class="icon-add" onclick="dataBackup()"></i></li>
			</ul>
			<div class="fr"><button class="sel_drow"></button></div>
		</div>
		<div class="date">
			<div class="date03 clearfix">
				<h3>可还原数据库文件</h3>
				<div class="stable">
					<table style="table-layout: auto;">
						<thead>
							<tr>
								<th name="id" class="hover enable">Id</th>
								<th name="name" class="hover enable">文件名</th>
								<th name="operate" class="hover enable">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($files)) {?>
								<?php foreach ($files as $id => $file) { ?>
								<tr>
									<td><div><?php echo $id + 1;?></div></td>
									<td><div><?php echo $file;?></div></td>
									<td>
										<div> 
											<span><a href="javascript:dataRecovery('<?php echo $file;?>');">还原</a></span> 
											<span><a href="javascript:dataDelete('<?php echo $file;?>');">删除</a></span> 
										</div>
									</td>
								</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- html5.js for IE less than 9 --> 
<!--[if lt IE 9]>
	<script src="<?php echo $this->tag->javascriptInclude('js/html5.js'); ?>"></script>
<![endif]--> 

<!-- css3-mediaqueries.js for IE less than 9 --> 
<!--[if lt IE 9]>
	<script	src="<?php echo $this->tag->javascriptInclude('js/html5.js'); ?>./js/css3-mediaqueries.js"></script>
<![endif]-->
</body>
</html>