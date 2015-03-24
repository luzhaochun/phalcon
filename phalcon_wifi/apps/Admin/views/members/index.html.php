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
	<script type="text/javascript">
		$(function(){
			$('#test').tableBgColor();
			$("input[type='checkbox']").selectCheckBox();
		});
		
		function changeUserStatus(mid) {
			var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Ajax','action'=>'changeUserStatus'));?>";
			$.ajax({
				url : ""+src+"mid/" + mid,
				data : { isAjax:true},
				success : function(result) {
					result = jQuery.parseJSON(result);
					alert(result.msg);
					location.reload()
				}
			});
		}
		
		function changeUserDel(mid) {
			var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Ajax','action'=>'changeUserDel'));?>";
			$.ajax({
				url : ""+src+"mid/" + mid,
				data : { isAjax:true},
				success : function(result) {
					result = jQuery.parseJSON(result);
					alert(result.msg);
					location.reload()
				}
			});
		}
		
		function mulDelete() {
			var arr = new Array();
			$("input[type='checkbox']:checked").each(function(index){
				if($(this).val() != "on") {
					arr[index] = $(this).val();
				}
			});
			mids = arr.join(",");
			var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Ajax','action'=>'mulUserDel'));?>";
			$.ajax({
				url : ""+src+"mids/" + mids,
				data : { isAjax:true},
				success : function(result) {
					result = jQuery.parseJSON(result);
					alert(result.msg);
					location.reload()
				}
			});
		}
	</script>
<body>
<div class="inner_box">
	<div class="page_title">
		<div class="title_list"><div style="padding-left:13px;">员工管理-<span>员工列表</span></div></div>
	</div>
	<div class="list_query">
		<div class="list_feature clearfix">
			<ul>
				<li><a href="<?php echo $this->url->get(array('for'=>'common','controller'=>'Members','action'=>'add'));?>"><i class="icon-add"></i></a></li>
				<li><i onclick="mulDelete();" class="icon-trash"></i></li>
			</ul>
			<div class="fr"><button class="sel_drow"></button></div>
		</div>
		<hr style="border:0;background-color:#DADADA;height:1px;"/>
		<form name="form-search" method="get" action="<?php echo $this->url->get(array('for'=>'common','controller'=>'Members','action'=>'index'));?>">
			<div class="list-search">
				&nbsp;&nbsp;<span>用户名：</span><input name="keyword" type="text" class=""/>
				&nbsp;&nbsp;<span>类型：</span>
				<select class="search-opt" name="mchild">
					<option value="0">所有</option>
					<option value="1">管理员</option>
					<option value="2">品牌商</option>
					<option value="3">代理商</option>
					<option value="3">商户</option>
				</select>
				&nbsp;&nbsp;<button class="search-btn" type="submit" name="search"></button>
			</div>
		</form>
	</div>
	<div class="list_table">
		<div class="data-list">
			<div class="wrapper">
			<table style="table-layout: auto;" id="test">
				<thead>
					<tr>
						<th name="" class="hover enable"><input type="checkbox"/></th>
						<th name="number" class="hover enable">编号</th>
						<th name="name" class="hover enable">用户名</th>
						<th name="user" class="hover enable">邮箱</th>
						<th name="company" class="hover enable">注册日期</th>
						<th name="Moblie" class="hover enable">联系电话</th>
						<th name="depart" class="hover enable">登陆次数</th>
						<th name="date" class="hover enable">上次登录ip</th>
						<th name="status" class="hover enable">用户状态</th>
						<th name="status" class="hover enable">是否删除</th>
						<th name="operate" class="hover enable">操作</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($members["data"] as $item) { ?>
					<tr>
						<td><div><input name="mid[]" value="<?php echo $item["mid"];?>" type="checkbox"/></div></td>
						<td><div><?php echo $item["mid"];?></div></td>
						<td><div><?php echo $item["mname"];?></div></td>
						<td><div><?php echo $item["email"];?></div></td>
						<td><div><?php echo date("Y-m-d H:i:s", $item["reg_time"]);?></div></td>
						<td><div><?php echo $item["mobile"];?></div></td>
						<td><div><?php echo $item["login_counts"];?></div></td>
						<td><div><?php echo $item["last_login_ip"];?></div></td>
						<td>
							<?php echo $item["status"] == "true" ? "<div class=\"green\">正常</div>" : "<div class=\"red\">禁用</div>";?>
						</td>
						<td>
							<?php echo $item["del"] == "true" ? "<div class=\"red\">是</div>" : "<div class=\"green\">否</div>";?>
						</td>
						<td><div> 
							<span><a href="<?php echo $this->url->get(array('for'=>'common','controller'=>'Members','action'=>'update', 'params' => 'mid/' . $item['mid']));?>">修改</a></span> 
							<span><a href="javascript:changeUserStatus(<?php echo $item['mid'];?>);">
								<?php echo $item["status"] == "true" ? "冻结" : "解冻";?>
							</a></span> 
							<span><a href="javascript:changeUserDel(<?php echo $item['mid'];?>);">
								<?php echo $item["del"] == "true" ? "恢复" : "删除";?>
							</a></span> 
						</div></td>
					</tr>
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
</body>
</html>

