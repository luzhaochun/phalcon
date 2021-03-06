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
	<div class="title_list"><div style="padding-left:13px;">员工管理-<span>添加员工</span></div></div>
</div>
<script type="text/javascript">
$(function() {
});

//修改用户
function addUser() {
	var mname = $("#mname").val();
	var email = $("#email").val();
	var mobile = $("#mobile").val();
	var mchild = $("#mchild").val();
	
	if (mname == "" || mname == undefined) {
		alert("缺少参数 : mname");
		return false;
	}
	if (email == "" || email == undefined) {
		alert("缺少参数 : email");
		return false;
	}
	if (mobile == "" || mobile == undefined) {
		alert("缺少参数 : mobile");
		return false;
	}
	if (mchild == "" || mchild == undefined) {
		alert("缺少参数 : mchild");
		return false;
	}
	var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Ajax','action'=>'addUser'));?>";
	$.ajax({
		url : ""+src+"mname/" + mname + "/email/" + email + "/mobile/" + mobile + "/mchild/" + mchild,
		data : { isAjax:true},
		success : function(result) {
			result = jQuery.parseJSON(result);
			alert(result.msg);
			location.reload()
		}
	});
}
</script>
<div class="user_manage">
	
	<div class="user_lists">
	<div class="user_list show">
		<form name="form-search" method="get">
			<div class="wrapper">
				<table style="table-layout: auto;">
				<tbody>
					<tr>
						<td><label>用户名：</label></td>
						<td>
							<input type="text" class="" name="mname" id="mname" style="width:240px;" value=""/>
						</td>
					</tr>
					<tr>
						<td><label>邮箱：</label></td>
						<td>
							<input type="text" class="" name="email" id="email" style="width:240px;" value=""/>
					</tr>
					<tr>
						<td><label>联系电话：</label></td>
						<td>
							<input type="text" class="" id="mobile" name="mobile" value=""/>
					</tr>
					<tr>
						<td><label>类型：</label></td>
						<td>
						<select class="search-opt" name="mchild" id="mchild">
							<?php foreach($mchilds as $key => $item) { ?>
								<option value="<?php echo $key;?>" >
									<?php echo $item;?>
								</option>
							<?php } ?>
						</select>
						</td>
					</tr>
				</tbody>
				</table>
			</div>
		</form>
		<div style="height:50px; line-height:50px;padding-left:21%;">
			<button onclick="addUser();" class="add-btn" id="submit" type="button">提交</button>
		</div>
	</div>
	</div>
</div>
</div>
</body>
</html>

