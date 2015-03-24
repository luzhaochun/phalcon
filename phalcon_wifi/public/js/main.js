$(function() {
	var t_id = setInterval(animate,20);
	var pos=0;
	var dir=2;
	var len=0;
	function animate(){
		var elem = document.getElementById('progress');
		if(elem != null) {
			if (pos==0) len += dir;
			if (len>32 || pos>79) pos += dir;
			if (pos>79) len -= dir;
			if (pos>79 && len==0) pos=0;
			elem.style.left = pos;
			elem.style.width = len;
		}
	}
	function remove_loading() {
		this.clearInterval(t_id);
		var targelem = document.getElementById('loader_container');
		targelem.style.display='none';
		targelem.style.visibility='hidden';
	}
	//左边列表的显示隐藏
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;
		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();
		$next.slideToggle();
		$this.parent().toggleClass('open');
		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	
	var accordion = new Accordion($('#accordion'), false);
	
	//菜单搜索
	$("input").keyup(function(){
		var searchStr = $("#search").val();
		if (searchStr == "") {
			return;
		}
		$("#accordion").find("ul.submenu").hide();
		$("#accordion").find("li").removeClass("open");
		//子菜单
		$("#accordion").find("li:has(a)").each(function (index) {
			if(typeof($(this).children("a").html()) != "undefined") {
				if ($(this).children("a").html().indexOf(searchStr) > -1) {
					//$(this).addClass("current");
					$(this).parent().parent().addClass("open");
					$(this).parent().show();
				}
			}
		});
		//主菜单
		$("#accordion").find("li:has(div)").each(function (index) {
			var tmpParentName = $(this).children("div.link").children("a").html();
			if(tmpParentName.indexOf(searchStr) > -1) {
				$(this).addClass("open");
				$(this).children(".submenu").show();
			}
		});
	});
	
	
	//左侧收缩效果
	$('.inner_box .user_date').css('width', $('.inner_box').width()+-350+'px'); 
	$('#container').css('width', $('.inner_box').width()+-350+'px'); 
	$('#shortcut_btn').click(function(){
		if($('#main .main-menu').css('display')=='block'){
			$('.main-menu').hide();
			$('#main .main-content').css('padding-left','0px');
			$('.shortcut .shortcut_btn').css('background','url(./images/shortcut1.png)');
			
		}else{
			$('.main-menu').show();
			$('#main .main-content').css('padding-left','241px;');
			$('.shortcut .shortcut_btn').css('background','url(./images/shortcut2.png)');
		}
		$('.inner_box .user_date').css('width', $('.inner_box').width()+-350+'px');
		$('#container').css('width', $('.inner_box').width()+-350+'px'); 
	});	
	
	//左边列表的高度控制
	if($('#main .main-content').height()<$(document).height()){
		$('#main .main-menu').css('height', $(document).height()+-115+'px');
	}else{
		$('#main .main-menu').css('height', $('#main .main-content').height()+'px');
	}
	$('#main .shortcut').css('min-height', $('#main .main-menu').height()+-2+'px');
	$('#inner').css('height', $('#main .main-menu').height()+-2+'px');
	
	//加载效果显示
	$("#accordion .submenu a,#accordion .link a").click(function(){
		var url = $(this).attr("rel");
		var ref =$(this).attr('ref');
		if(ref && ref =='data'){
			$("#right_frame").fadeOut(1000,function(){
				$("#right_frame").attr("src",url);
				window.location.href=url;
			})
		}else{
			$("#right_frame").fadeOut(500,function(){
				$("#right_frame").attr("src",url);
				//$("#right_frame").load(function(){
					$("#right_frame").fadeIn(500);
				//})
			});
		}
		
	})
	
	//权限分配的选项显示隐藏
	//assign privileges
	//ng_first:get first children
	var ng_first = $("#treeDemo .level3:first").children(":first");
	//ng_last:get last children
	var ng_last  = $("#treeDemo .level3:last").children(":first");
	//ng_middle:get middle children
	var ng_middle = $("#treeDemo .level3 .center_open");
	
	//control init page's css
	if(ng_first.hasClass('roots_open')){
		ng_first.removeClass('roots_open').addClass('roots_close').siblings('ul').hide();
	}
	if(ng_last.hasClass('bottom_open')){
		ng_last.removeClass('bottom_open').addClass('bottom_close').siblings('ul').hide();
	}
	ng_middle.each(function(){
		$(this).removeClass('center_open').addClass('center_close').siblings('ul').hide();
	})
	
	//click 
	ng_first.on('click',function(){
		if(ng_first.hasClass('roots_open')){
			ng_first.removeClass('roots_open').addClass('roots_close').siblings('ul').hide();
		}else if(ng_first.hasClass('roots_close')){
			ng_first.removeClass('roots_close').addClass('roots_open').siblings('ul').show();
		}
	})
	
	ng_last.on('click',function(){
		if(ng_last.hasClass('bottom_open')){
			ng_last.removeClass('bottom_open').addClass('bottom_close').siblings('ul').hide();
		}else if(ng_last.hasClass('bottom_close')){
			ng_last.removeClass('bottom_close').addClass('bottom_open').siblings('ul').show();
		}
	})
	
	ng_middle.each(function(){
		$(this).on('click',function(){
			if($(this).hasClass('center_open')){
				$(this).removeClass('center_open').addClass('center_close').siblings('ul').hide();
			}else if($(this).hasClass('center_close')){
				$(this).removeClass('center_close').addClass('center_open').siblings('ul').show();
			}
		})
	})
	
	//checkbox select
	//please fix this place
	//var main_checkbox = $("#treeDemo .level3");
	//alert(main_checkbox.length);
	
	//checkbox select
	var main_checkbox = $('#treeDemo .but_title input[type="checkbox"]');
	main_checkbox.on('click',function(){
		if($(this).prop('checked')==false){
			$(this).parent().siblings('ul').find('input[type="checkbox"]').prop('checked',false);
		}else if($(this).prop('checked')==true){
			$(this).parent().siblings('ul').find('input[type="checkbox"]').prop('checked',true);
		}
	})
	
	main_checkbox.parent().siblings('ul').find('input[type="checkbox"]').on('click',function(){
		var sibling_checkbox_length = $(this).closest('.level1').find('input[type="checkbox"]').length;
		var sibling_checkbox_checked_length = $(this).closest('.level1').find('input[type="checkbox"]:checked').length;
		if(sibling_checkbox_length==sibling_checkbox_checked_length){
			$(this).closest('.level1').siblings('.but_title').find('input[type="checkbox"]').prop('checked',true);
		}else{
			$(this).closest('.level1').siblings('.but_title').find('input[type="checkbox"]').prop('checked',false);
		}
	})
});

//插件
(function ($) {
	//checkbox 批量处理插件
	$.fn.selectCheckBox = function () {
		var selectboxs = this;
		return selectboxs.each(function (index) {
			$(this).click(function () {
				if (index == 0 ) {
					if ($(this).is(':checked')) {
						selectboxs.prop("checked",'checked');
					} else {
						selectboxs.removeAttr("checked");
					}
				} else {
					if($(this).is(':checked')){
						var checked_length = $("input[type='checkbox']:checked").length;
						if(selectboxs.first().prop('checked') == false && (checked_length == selectboxs.length-1 )){
							selectboxs.first().prop("checked",'checked');
						}
					}else{
						selectboxs.first().removeAttr("checked");
					}
				}
			});
		});
	};
	
	//table隔行换色
	$.fn.tableBgColor = function() {
		var tds =this.find("tr");
		for(var j=0; j<tds.length; j++){
			if(j%2==1){
				tds[j].className="over";
			}else{
				tds[j].className="out";
			}
		}
	};
})(jQuery);








