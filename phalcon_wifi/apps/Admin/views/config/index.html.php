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
		<div class="title_list"><div style="padding-left:13px;">配置管理-<span>配置列表</span></div></div>
	</div>
	<div class="list_query">
	   <div class="list_feature clearfix">
			<ul>
				<li><a href="<?php echo $this->url->get(array('for'=>'common','controller'=>'Config','action'=>'addConfig'));?>"><i class="icon-nadd"></i></a></li>
			</ul>
			<div class="fr"><button class="sel_drow"></button></div>
		</div>
		<hr style="border:0;background-color:#DADADA;height:1px;"/>
		<?php echo Phalcon\Tag::form(array('Config/index', 'method' => 'get','id' => 'form-search','name'=>'form-search')); ?>
			<div class="list-search">
				&nbsp;&nbsp;<span>分组：</span>
				<select class="search-opt" name="con_group" id="con_group">
					<option value="">所有分组</option>
					<?php foreach($configSetting['group'] as $k => $v){
                        if($con_group == $k){
                            echo "<option value=".$k." selected>$v</option>";
                        }else{
                            echo "<option value=".$k.">$v</option>";
                        }
                        
                    }?>
				</select>
				&nbsp;&nbsp;<span>类型：</span>
				<select class="search-opt" name="con_type" id="con_type">
					<option value="">所有类型</option>
					<?php foreach($configSetting['type'] as $k => $v){
                        if($con_type == $k){
                            echo "<option value=".$k." selected>$v</option>";
                        }else{
                            echo "<option value=".$k.">$v</option>";
                        }
                    }?>
				</select>
				&nbsp;&nbsp;<span>名称/标题：</span>
				<input type="text" class="date-title" name="con_value" id="con_value"  placeholder=""	value="<?php echo $con_value; ?>">
				&nbsp;&nbsp;<button class="search-btn" type="submit" name="search"></button>
			</div>
		</form>
	</div>
	<div class="list_table" id="list_table">
		<div class="data-list">
			<div class="wrapper">
				<?php echo Phalcon\Tag::form(array('', 'method' => 'get','id' => 'frm_batch','name'=>'frm_batch')); ?>
					<table style="table-layout: auto;" id="test">
						<thead>
							<tr>
								<th name="" class="hover enable" width="10%"><input id="check_box" name="check_box" type="checkbox"/></th>
								<th name="number" class="hover enable" width="25%" align="left"><strong style="font-size:15px;">名称</strong></th>
								<th name="name" class="hover enable" width="25%" align="left"><strong style="font-size:15px;">标题</strong></th>
								<th name="user" class="hover enable" width="20%" align="left"><strong style="font-size:15px;">分组</strong></th>
								<th name="company" class="hover enable" width="10%" align="left"><strong style="font-size:15px;">类型</strong></th>
								<th name="operate" class="hover enable" width=""><strong style="font-size:15px;">操作</strong></th>
							</tr>
						</thead>
						<tbody id="config_content">
						    <?php if(sizeof($configList['data'])>0){ foreach ($configList["data"] as $item) { ?>
						    <tr>
						        <td><input type="checkbox" name="cong_id[]" class="sub_checkbox" value="<?php echo $item['id'];?>"></td>
								<td><?php echo $item['variable_name'];?></td>
								<td><?php echo $item['variable_title'];?></td>
								<td><?php echo !empty($configSetting['group'][$item['group']])? $configSetting['group'][$item['group']]:'';?></td>
								<td><?php echo !empty($configSetting['type'][$item['type']]) ? $configSetting['type'][$item['type']]:'';?></td>
								<td>
								    <a href="<?php echo $this->url->get(array('for'=>'common','controller'=>'Config','action'=>'editConfig','params'=>$item['id']));?>"><i class="icon-exit"></i></a>
								    <a href="javascript:;" class="config_del" data-id="<?php echo $item['id'];?>"><i class="icon-del1"></i></a>
								</td>
						    </tr>
						    <?php }}else{ ?>
						       <tr>
						          <td colspan="6" style="text-align: left;padding-left: 20px;">暂时查询数据</td>
						       </tr>
						    <?php } ?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<div class="page-list" style="margin-top:30px;">
		   <?php if(sizeof($configList["data"])>0){ ?>
		   <div style="float:left;"><label for="check_box">全选/取消</label><i id="batch_del"  class="icon-del2"></i></div>
		   <?php } ?>
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