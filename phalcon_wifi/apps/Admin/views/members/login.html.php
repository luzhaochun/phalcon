
<?php echo $this->tag->javascriptInclude('js/jquery-validation/dist/jquery.validate.min.js'); ?>
<div id="background" style="position:fixed; top:0; left:0; bottom:0; right:0; z-index:-1; ">
	<?php echo Phalcon\Tag::image(['images/bg.jpg','width'=>'100%','height'=>'100%','border'=>0]);?>
</div>
<div class="login_main">
	<div class="login_content">
		<div class="login_logo">
		    <?php echo Phalcon\Tag::image('images/login_logo.png');?>
		</div>
		<div class="split">
		    <?php echo Phalcon\Tag::image('images/split.png');?>
		</div>
		<div class="login_frame">
			<div class="frame">
				<?php echo Phalcon\Tag::form(array('Members/confirmLogin', 'method' => 'post','id' => 'login_frm','name'=>'login_frm')); ?>
					<h3>商家后台登陆系统</h3>
					<div>
						<label>用户名 </label>
						<span><input type="text" name="mname" id="mname" class="required" placeholder="请输入用户名"/></span>
						<label id="mname-error" class="error" for="mname"></label>
					</div>
					<div>
						<label>密&nbsp;&nbsp;&nbsp;码</label>
						<span><input type="password" name="mpwd" id="mpwd" class="required" placeholder="请输入密码"/></span>
						<label id="mpwd-error" class="error" for="mpwd"></label>
					</div>
					<div>
						<label>验证码</label>
						<span>
							<input type="text" name="code" id="code" class="required" placeholder="验证码" style="width:90px;"/>
							<span class="code-pic">
								<img id="codePic" src="<?php echo $this->url->get(array('for'=>'common','controller'=>'Index','action'=>'getValidateCode'));?>" />
								<a id="change_code" href="#">看不清换一个</a>
							</span>
							<label id="code-error" class="error" for="code"></label>
						</span>
					</div>

					<div>
						<label></label>
						<span><button class="login-btn" type="submit">登&nbsp;录</button></span>
					</div>
					<div style="height: 20px;">
						<label style="height: 20px;"></label>
						<span style="line-height: 20px;height: 20px;color: red;font-size: 12px;" id="errorMsg">
							<?php echo !empty($this->router->getParams()[0]) ? $this->router->getParams()[0] : '' ;?>
						</span>
					</div>
				</form>
			</div>
			<div class="shadow"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$("#login_frm").validate({
			messages: {
				mname: "用户名不为空",
				mpwd: "密码不为空",
				code:'验证码不为空'
			}
		});
		$('#twe').css('display','none');
		$('#one').click(function(){
			$('#two').toggle();
		})
		
		$(document).on('focus','#mname,#mpwd,#code',function(){
			$('#errorMsg').html('');
		})
		$(document).on('click','#change_code',function(){
			  var src = "<?php echo $this->url->get(array('for'=>'common','controller'=>'Index','action'=>'getValidateCode'));?>";
     	  	  $.ajax({
     	  	  	  url : ""+src+"",
     	  	  	  data : { isAjax:true},
     	  	  	  success:function(rtn){
                      $("#codePic").attr("src",src);
     	  	  	  }
     	  	  });
		})
	})
</script>