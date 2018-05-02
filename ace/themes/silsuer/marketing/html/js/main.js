$(function() {
	function tab(ul,li){
		$(li).mouseover(function(){
		$(ul).hide().eq($(this).index()).show();
		$(li).removeClass("hover").eq($(this).index()).addClass("hover");
		return false;
		});
	}
	function show(li,p){
		$(li).hover(function(){
			$(this).find(p).fadeIn(300);
		},function(){
			$(this).find(p).fadeOut(300);
		});
	}
	
	jQuery.navlevel2 = function(level1,dl,dytime) {
	  $(level1).mouseenter(function(){
		  varthis = $(this);
		  delytime=setTimeout(function(){
			varthis.find(dl).slideDown();
		},dytime);
		
	  });
	  $(level1).mouseleave(function(){
		 clearTimeout(delytime);
		 $(this).find(dl).hide();
	  });
	};
  $.navlevel2(".mli",".m_dl",50);

$(".zp_div .zp_title").click(function(){
	$(".zp_div").find(".zp_txt").slideUp()
	$(".zp_div").eq($(this).parent().index()).find(".zp_txt").slideDown();
	$(".zp_div").removeClass("hover").eq($(this).parent().index()).addClass("hover");
	return false;
});
var hei=$(window).height();
$(".apply").click(function(){
	var name=$(this).attr("data-id");
	$('#name').val(name);
	$(".zp_bg").fadeIn(500);
	$(".zp_pos").css({"margin-top":(hei-339)/2});
});
$(".tc_close,.can").click(function(){
	$(".zp_bg").fadeOut(100);
});
});

function qh(div,ul,li){
	var sWidth = $(div).width(); //获取焦点图的宽度（显示面积）
	var len = $(li).length; //获取焦点图个数
	var index = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
	var btn = "<div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span></span>";
	}
	btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
	$(div).append(btn);

	//为小按钮添加鼠标滑入事件，以显示相应的内容
	$(div).find(".btn span").mouseenter(function() {
		index = $(div).find(".btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");

	//上一页按钮
	$(div).find(".pre").click(function() {
		index -= 1;
		if(index == -1) {index = len - 1;}
		showPics(index);
	});

	//下一页按钮
	$(div).find(".next").click(function() {
		index += 1;
		if(index == len) {index = 0;}
		showPics(index);
	});

	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
//	$(ul).css("width",sWidth * (len));
	showPics(index);
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$(div).hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},4000); //此4000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		$(li).eq(index).animate({opacity: 1,"z-index": "1"},1500).siblings().animate({opacity: 0,"z-index": "0"},1500);
		$(div).find(".btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
		$(div).find(".btn span").stop(true,false).animate({"opacity":"1"},500).eq(index).stop(true,false).animate({"opacity":"1","background":"red"},500); //为当前的按钮切换到选中的效果
	}
}




function openlinks(url){
	if(url.length != 0){
		window.open(url)
	}
}



