<?= \Phalcon\Tag::getDoctype() ?>
<html>
	<head>
		<title>Wifi营销精灵--后台管理</title>	
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
	    	$('#list_table').on('click','#batch_del',function(){
	    		var config_checked_length = $('#config_content').find('input[type="checkbox"]:checked').length;
	    		if(config_checked_length<=0){
	    			alert('请选择所要删除内容！');
	    			return;
	    		}
	    		if(confirm('确认删除吗？')){
	    			$('#frm_batch').prop('action','<?php echo $this->url->get(array('for'=>'common','controller'=>'Config','action'=>'batchDelete'));?>');
	    			$('#frm_batch').submit();
	    		}
	    	});
	    	$('#list_table').on('click','.config_del',function(){
	    		var $_id = $(this).attr('data-id');
	    		if(typeof($_id) == 'undefined' || $_id==0 || !$_id) alert('网络错误，请重新刷新页面！');
	    		if(confirm('确认删除吗？')){
	    			var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Config','action'=>'delete'));?>";
		    		$.ajax({
		    			url:""+src+"",
		    			data:{id:$_id},
		    			success:function(result){
		    				var rtn = jQuery.parseJSON(result);
		    				alert(rtn.msg);
		    				location.reload();
		    			}
		    		});
	    		}
	    		
	    	})
	    })
	</script>
<body>
<div class="inner_box">
<div class="page_title">
	<div class="title_list"><div style="padding-left:13px;">系统配置-<span>配置更新</span></div></div>
</div>
<script type="text/javascript">
$(function(){
	$("#tab li").each(
		function(i){
			$(this).click(function(){
				if(!$(this).hasClass("hover")){
					$("#tab li").removeClass("hover");
					$(this).addClass("hover")
					$(".user_list").removeClass("show");
					$(".user_list").eq(i).addClass("show");
				}
			});
		})
			
	$("#user_submit").click(function(){
		if(!$("#name").val()){
			//$(".tip_name").text("*姓名不能为空！").css('color','#f94a69').fadeOut(10000);
			$("#name").parent().children('span').addClass(".tip_name").text("*姓名不能为空！").css('color','#f94a69');
			$("#name").addClass("focus");
			return;
			}
		if(!$("#user_name").val()){
			$(".tip_user").text("*用户名不能为空！").css('color','#f94a69');
			$("#user_name").addClass("focus");
			return;
		}	
		if(!$("#firm").val()){
			$(".tip_firm").text("*公司不能为空！").css('color','#f94a69');
			$("#firm").addClass("focus");
			return;
		}
		if(!$("#phone").val() || !$("#phone").val().match(/^1[3|4|5|6|8][0-9]\d{4,8}$/)){
			$(".tip_phone").text("*号码格式有误，请填写正确号码！").css('color','#f94a69');
			$("#phone").addClass("focus");
			return;
		}
	});
})
</script>
<div class="user_manage">
	<ul class="tab" id="tab">
		<li class="hover">邮件配置</li>
		<li>图片上传配置</li>
		<li>短信网关配置</li>
		<li>路由器配置</li>
		<li>系统配置</li>
	</ul>
	<div class="user_lists">
	<div class="user_list show">
		<form name="form-search" method="get">
			<div class="wrapper">
				<table style="table-layout: auto;">
				  <tbody>
					<tr>
						<td><label>姓名：</label></td>
						<td><input type="text" id="name" class=""/>&nbsp;&nbsp;<span class="tip_name blue">* 必填</span></td>
					</tr>
					<tr>
						<td><label>用户名：</label></td>
						<td><input type="text" id="user_name" class=""/>&nbsp;&nbsp;<span class="tip_user blue">* 必填</span></td>
					</tr>
					<tr>
						<td><label>选择省市：</label></td>
						<td>
						<select class="search-opt">
							<option>江苏省</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						<select class="search-opt">
							<option>南京市</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><label>公司名称：</label></td>
						<td><input type="text" class="" id="firm" style="width:280px;"/>&nbsp;&nbsp;<span class="tip_firm blue">* 必填</span></td>
					</tr>
					<tr>
						<td><label>详细地址：</label></td>
						<td><input type="text" class="" style="width:280px;"/></td>
					</tr>
					<tr>
						<td><label>部门：</label></td>
						<td>
						<select class="search-opt">
							<option>行政部</option>
							<option>宣传部</option>
							<option>技术部</option>
							<option>销售部</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><label>联系电话：</label></td>
						<td><input type="text" class="" id="phone" style="width:240px;"/>&nbsp;&nbsp;<span class="tip_phone blue">* 请输入正确的11位手机号码</span></td>
					</tr>
					<tr>
						<td><label>注册日期：</label></td>
						<td><input type="text" class="date-title" name="time" id="time" onClick="WdatePicker()" placeholder="2014-12-24"  ></td>
					</tr>
					<tr>
						<td><label>备注：</label></td>
						<td><textarea rows="8" cols="50" style="margin-top:5px;"></textarea></td>
					</tr>
				  </tbody>
				</table>
			</div>
		</form>
		<div style="height:50px; line-height:50px;padding-left:21%;"><button class="add-btn" id="user_submit" type="submit">提交</button></div>
	</div>
	<div class="user_list">
		<form name="form-search" method="get">
			<div class="wrapper">
				<table style="table-layout: auto;">
				  <tbody>
					
					<tr>
						<td><label>姓名：</label></td>
						<td><input type="text" class=""/></td>
					</tr>
					<tr>
						<td><label>用户名：</label></td>
						<td><input type="text" class="" id=""/></td>
					</tr>
					<tr>
						<td><label>选择省市：</label></td>
						<td>
						<select class="search-opt">
							<option>江苏省</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						<select class="search-opt">
							<option>南京市</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><label>详细地址：</label></td>
						<td><input type="text" class="" style="width:280px;"/></td>
					</tr>					
					<tr>
						<td><label>部门：</label></td>
						<td>
						<select class="search-opt">
							<option>技术部</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="height:50px; line-height:50px;">
						<button class="add-btn" type="submit" name="search">提交</button>
						<button class="off-btn" type="submit" name="search">取消</button>
						</td>
					</tr>
				  </tbody>
				</table>
			</div>
		</form>
	</div>
	<div class="user_list">
		<form name="form-search" method="get">
			<div class="wrapper">
				<table style="table-layout: auto;">
				  <tbody>
					<tr>
						<td><label>姓名：</label></td>
						<td><input type="text" class=""/></td>
					</tr>
					<tr>
						<td><label>用户名：</label></td>
						<td><input type="text" class="" /></td>
					</tr>
					<tr>
						<td><label>邮箱：</label></td>
						<td><input type="text" class="" /></td>
					</tr>
					<tr>
						<td><label>选择省市：</label></td>
						<td>
						<select class="search-opt">
							<option>江苏省</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						<select class="search-opt">
							<option>南京市</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><label>详细地址：</label></td>
						<td><input type="text" class="" style="width:280px;"/></td>
					</tr>
					<tr>
						<td><label>隶属部门：</label></td>
						<td>
						<select class="search-opt">
							<option>技术部</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="height:50px; line-height:50px;">
						<button class="add-btn" type="submit" name="search">提交</button>
						<button class="off-btn" type="submit" name="search">取消</button>
						</td>
					</tr>
				  </tbody>
				</table>
			</div>
		</form>
	</div>
	<div class="user_list">
		<form name="form-search" method="get">
			<div class="wrapper">
				<table style="table-layout: auto;">
				  <tbody>
					<tr>
						<td><label>姓名：</label></td>
						<td><input type="text" class=""/></td>
					</tr>
					<tr>
						<td><label>用户名：</label></td>
						<td><input type="text" class="" id=""/></td>
					</tr>
					<tr>
						<td><label>电话：</label></td>
						<td><input type="text" class="" id=""/></td>
					</tr>
					<tr>
						<td><label>选择省市：</label></td>
						<td>
						<select class="search-opt">
							<option>江苏省</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						<select class="search-opt">
							<option>南京市</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><label>详细地址：</label></td>
						<td><input type="text" class="" style="width:280px;"/></td>
					</tr>					
					<tr>
						<td><label>隶属部门：</label></td>
						<td>
						<select class="search-opt">
							<option>技术部</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="height:50px; line-height:50px;">
						<button class="add-btn" type="submit" name="search">提交</button>
						<button class="off-btn" type="submit" name="search">取消</button>
						</td>
					</tr>
				  </tbody>
				</table>
			</div>
		</form>
	</div>
	<div class="user_list">
		<form name="form-search" method="get">
			<div class="wrapper">
				<table style="table-layout: auto;">
				  <tbody>
					<tr>
						<td><label>姓名：</label></td>
						<td><input type="text" class=""/></td>
					</tr>
					<tr>
						<td><label>用户名：</label></td>
						<td><input type="text" class="" id=""/></td>
					</tr>
					<tr>
						<td><label>手机号码：</label></td>
						<td><input type="text" class="" id=""/></td>
					</tr>
					<tr>
						<td><label>选择省市：</label></td>
						<td>
						<select class="search-opt">
							<option>江苏省</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						<select class="search-opt">
							<option>南京市</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><label>详细地址：</label></td>
						<td><input type="text" class="" style="width:280px;"/></td>
					</tr>					
					<tr>
						<td><label>隶属部门：</label></td>
						<td>
						<select class="search-opt">
							<option>技术部</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="height:50px; line-height:50px;">
						<button class="add-btn" type="submit" name="search">提交</button>
						<button class="off-btn" type="submit" name="search">取消</button>
						</td>
					</tr>
				  </tbody>
				</table>
			</div>
		</form>
	</div>
	<div class="user_list">
		<form name="form-search" method="get">
			<div class="wrapper">
				<table style="table-layout: auto;">
				  <tbody>
					<tr>
						<td><label>姓名：</label></td>
						<td><input type="text" class=""/></td>
					</tr>
					<tr>
						<td><label>用户名：</label></td>
						<td><input type="text" class="" id=""/></td>
					</tr>
					<tr>
						<td><label>选择省市：</label></td>
						<td>
						<select class="search-opt">
							<option>江苏省</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						<select class="search-opt">
							<option>南京市</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><label>详细地址：</label></td>
						<td><input type="text" class="" style="width:280px;"/></td>
					</tr>					
					<tr>
						<td><label>隶属部门：</label></td>
						<td>
						<select class="search-opt">
							<option>技术部</option>
							<option>select2</option>
							<option>select3</option>
							<option>select4</option>
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="height:50px; line-height:50px;">
						<button class="add-btn" type="submit" name="search">提交</button>
						<button class="off-btn" type="submit" name="search">取消</button>
						</td>
					</tr>
				  </tbody>
				</table>
			</div>
		</form>
	</div>
	</div>
</div>
</div>

</body>
</html>