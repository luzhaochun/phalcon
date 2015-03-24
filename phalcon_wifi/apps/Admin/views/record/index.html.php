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
	</head>
<body>
<div class="inner_box">
	<div class="page_title">
		<div class="title_list"><div style="padding-left:13px;">操作日志-<span>列表</span></div></div>
	</div>
	<div class="user_date fl">
		<div class="date">
			<div class="date03 clearfix">
				<h3>操作日志</h3>
				<div class="stable">
					<table style="table-layout: auto;">
						<thead>
							<tr>
								<th name="id" class="hover enable">Id</th>
								<th name="name" class="hover enable">MID</th>
								<th name="name" class="hover enable">操作</th>
								<th name="operate" class="hover enable">时间</th>
								<th name="operate" class="hover enable">IP</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($records["data"])) {?>
								<?php foreach ($records["data"] as $record) { ?>
								<tr>
									<td><div><?php echo $record["id"];?></div></td>
									<td><div><?php echo $record["mid"];?></div></td>
									<td><div><?php echo $record["operation"];?></div></td>
									<td><div><?php echo $record["log_time"];?></div></td>
									<td><div><?php echo $record["loginip"];?></div></td>
								</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="page-list" style="margin-top:30px;">
				<?php if($pager->totalPage > 1) {?>
	<div class="page-bor">
		<span>共<?php echo $pager->total;?>条数据 
			<span><?php echo $pager->currentPage;?></span>/<span><?php echo $pager->totalPage;?></span>页
		</span>
		<?php 
			$start = $pager->start;
			$end = $pager->end;
			$currentPage = $pager->currentPage;
		?>
		<?php $pager->currentPage = $pager->currentPage - 1;?>
		<a href="<?php echo $pager->createUrl();?>" onfocus="this.blur();">上一页</a>
		<?php $pager->currentPage = $pager->currentPage + 2;?>
		<a href="<?php echo $pager->createUrl();?>" >下一页</a>
		<?php for($i = $start; $i <= $end; $i++) { ?>
			<?php $pager->currentPage = $i;?>
			<?php if($i == $currentPage) {?>
				<a href="<?php echo $pager->createUrl();?>" class=" current"><?php echo $i;?></a>
			<?php } else { ?>
				<a href="<?php echo $pager->createUrl();?>"><?php echo $i;?></a>
			<?php } ?>
		<?php } ?>
	</div>
<?php } ?>
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