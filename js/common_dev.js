if (window.self != window.top) {
	if (top.location.hostname.indexOf(".qq.com") > 0) {} else {
		var selfLocation = self.location.href;
		if (selfLocation.charAt(selfLocation.length - 1) == "?") {
			top.location.href = selfLocation.substring(0, selfLocation.length - 1)
		} else {
			top.location.href = selfLocation
		}
	}
}
window.___gcfg = {
	lang: 'zh-CN'
};
var bdShare_config = {
	"type": "small",
	"color": "blue",
	"uid": "139084",
	"likeText": "不错",
	"likedText": "已赞过"
};

function g(a) {
	return document.getElementById(a)
}
function getCookie(a) {
	var b, reg = new RegExp("(^| )" + a + "=([^;]*)(;|$)");
	if (b = document.cookie.match(reg)) {
		return unescape(decodeURI(b[2]))
	} else {
		return ""
	}
}
function delCookie(a) {
	var b = new Date();
	b.setTime(b.getTime() - 1);
	var c = getCookie(a);
	if (c != null) document.cookie = a + "=" + c + ";expires=" + b.toGMTString()
}
function goMobile() {
	delCookie("force_normal_theme");
	window.location.reload()
}
function getUserBrowser() {
	var b = navigator.userAgent.toLowerCase();
	if (/msie/i.test(b) && !/opera/.test(b)) {
		return 'ie'
	} else if (/chrome/i.test(b) && /webkit/i.test(b) && /mozilla/i.test(b)) {
		return 'chrome'
	} else if (/firefox/i.test(b)) {
		return 'firefox'
	} else if (/webkit/i.test(b) && !(/chrome/i.test(b) && /webkit/i.test(b) && /mozilla/i.test(b))) {
		return 'safari'
	} else if (/opera/i.test(b)) {
		return 'opera'
	} else {
		return 'unknown'
	}
}
function isMobile() {
	var a = navigator.userAgent.toLowerCase();
	if (a.indexOf('iphone') != -1) return "iphone";
	if (a.indexOf('ipod') != -1) return "ipod";
	if (a.indexOf('ipad') != -1) return "ipad";
	if (a.indexOf('android') != -1) return "android";
	return false
}
function shffleArray(v) {
	for (var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
	return v
}
function loadShareToolbar(b, c, d, e, f, g) {
	if (null == document.getElementById("share_toolbar_wrapper")) {
		return
	}
	if (b == "") {
		b = "0"
	} else {
		b = b + ""
	}
	var h = "";
	h += ("		<div id=\"share_toolbar\">");
	h += ("			<div title=\"本文围观次数\" id=\"stb_article_view\" class=\"stb_group\"><span id=\"stb_article_view_icon\"></span><span id=\"stb_view_count\">&nbsp" + b + "&nbsp;</span></div>");
	h += ("			<div class=\"stb_divide\"></div>");
	h += ("				<div id=\"bdshare\" class=\"bdshare_t bds_tools get-codes-bdshare stb_share_buttons stb_group\" data=\"{'url':'" + c + "'}\">");
	h += ("			        <a class=\"bds_tsina\" id=\"stb_btn_weibo\" href=\"javascript:void(0);\"></a>");
	h += ("			        <a class=\"bds_tqq\"post_url id=\"stb_btn_tqq\" href=\"javascript:void(0);\"></a>");
	h += ("			        <a class=\"bds_qzone\" id=\"stb_btn_qzone_small\" href=\"javascript:void(0);\"></a>");
	h += ("			        <a class=\"bds_renren\" id=\"stb_btn_renren_small\" href=\"javascript:void(0);\"></a>");
	h += ("			        <span class=\"bds_more\" id=\"stb_btn_more\"><span id=\"stb_sbtn_more_icon\"></span></span>");
	if (getUserBrowser() != "chrome") {
		h += ("			        <a class=\"shareCount\" href=\"javascript:void(0);\"></a>")
	}
	h += ("				</div>");
	h += ("			<div class=\"stb_divide\"></div>");
	if (d == "" || f == "" || e == "" || g == "") {} else {
		h += ("			<div class=\"stb_share_buttons stb_group\">");
		h += ("				<a id=\"stb_btn_prev\" href=\"" + f + "\" title=\"上一篇：" + g + "\"></a>");
		h += ("				<a id=\"stb_btn_next\" href=\"" + d + "\" title=\"下一篇：" + e + "\"></a>");
		h += ("			</div>")
	}
	h += ("			<div class=\"stb_group_right\">");
	h += ("				<div id=\"stb_like_gplus\" class=\"stb_like_btn\">");
	h += ("					<div class=\"g-plusone\" data-size=\"medium\" data-href=\"" + c + "\"></div>");
	h += ("				</div>");
	h += ("				<div class=\"bdlikebutton stb_like_btn\"></div>");
	h += ("			</div>");
	h += ("		</div>");
	document.getElementById("share_toolbar_wrapper").innerHTML = h;
	document.writeln('<scri' + 'pt type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=139084" ></scr' + 'ipt>');
	document.writeln('<scri' + 'pt type="text/javascript" id="bdshell_js"></scr' + 'ipt>');
	document.writeln('<scr' + 'ipt id="bdlike_shell"></scr' + 'ipt>');
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
	document.getElementById("bdlike_shell").src = "http://bdimg.share.baidu.com/static/js/like_shell.js?t=" + new Date().getHours();
	(function() {
		var a = document.createElement('script');
		a.type = 'text/javascript';
		a.async = true;
		a.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(a, s)
	})()
}
function timeAgo(a) {
	var b, d_hours, d_days;
	var c = parseInt(new Date().getTime() / 1000);
	var d = c - a;
	d_weeks = parseInt(d / 604800);
	d_days = parseInt(d / 86400);
	d_hours = parseInt(d / 3600);
	b = parseInt(d / 60);
	if (d_weeks > 0 && d_weeks < 4) {
		return d_weeks + "周前"
	} else if (d_days > 0 && d_days < 4) {
		return d_days + "天前"
	} else if (d_days <= 0 && d_hours > 0) {
		return d_hours + "小时前"
	} else if (d_hours <= 0 && b > 0) {
		return b + "分钟前"
	} else if (d_hours <= 0 && b == 0) {
		return "刚刚"
	} else {
		var s = new Date(a * 1000);
		var e = new Date();
		var f = (s.getMonth() + 1) + "月" + s.getDate() + "日";
		if (e.getFullYear() - s.getFullYear() >= 1) {
			f = s.getFullYear() + "年" + f
		}
		return f
	}
}
$.fn.extend({
	scrollFollow: function(d) {
		d = d || {};
		d.container = d.container || $(this).parent();
		d.bottomObj = d.bottomObj || '';
		d.bottomMargin = d.bottomMargin || 0;
		d.marginTop = d.marginTop || 0;
		d.marginBottom = d.marginBottom || 0;
		d.zindex = d.zindex || 9999;
		var e = $(window);
		var f = $(this);
		if (f.length <= 0) {
			return false
		}
		var g = f.position().top;
		var h = d.container.height();
		var i = f.css("position");
		if (d.bottomObj == '' || $(d.bottomObj).length <= 0) {
			var j = false
		} else {
			var j = true
		}
		e.scroll(function(a) {
			var b = f.height();
			if (f.css("position") == i) {
				g = f.position().top
			}
			scrollTop = e.scrollTop();
			topPosition = Math.max(0, g - scrollTop);
			if (j == true) {
				var c = $(d.bottomObj).position().top - d.marginBottom - d.marginTop;
				topPosition = Math.min(topPosition, (c - scrollTop) - b)
			}
			if (scrollTop > g) {
				if (j == true && (g + b > c)) {
					f.css({
						position: i,
						top: g
					})
				} else {
					if (window.XMLHttpRequest) {
						f.css({
							position: "fixed",
							top: topPosition + d.marginTop,
							'z-index': d.zindex
						})
					} else {
						f.css({
							position: "absolute",
							top: scrollTop + topPosition + d.marginTop + 'px',
							'z-index': d.zindex
						})
					}
				}
			} else {
				f.css({
					position: i,
					top: g
				})
			}
		});
		return this
	}
});
$.fn.extend({
	Tabs: function(c) {
		c = $.extend({
			event: 'mouseover',
			timeout: 0,
			auto: 0,
			callback: null
		}, c);
		var d = $(this),
			tabBox = d.children('div.tab_content').children('div'),
			menu = d.children('ul.tab_menu'),
			items = menu.find('li'),
			timer;
		var e = function(a) {
				a.siblings('li').removeClass('current').end().addClass('current');
				tabBox.siblings('div').addClass('hide').end().eq(a.index()).removeClass('hide')
			},
			delay = function(a, b) {
				b ? setTimeout(function() {
					e(a)
				}, b) : e(a)
			},
			start = function() {
				if (!c.auto) return;
				timer = setInterval(autoRun, c.auto)
			},
			autoRun = function() {
				var a = menu.find('li.current'),
					firstItem = items.eq(0),
					len = items.length,
					index = a.index() + 1,
					item = index === len ? firstItem : a.next('li'),
					i = index === len ? 0 : index;
				a.removeClass('current');
				item.addClass('current');
				tabBox.siblings('div').addClass('hide').end().eq(i).removeClass('hide')
			};
		items.bind(c.event, function() {
			delay($(this), c.timeout);
			if (c.callback) {
				c.callback.call(d)
			}
		});
		if (c.auto) {
			start();
			d.hover(function() {
				clearInterval(timer);
				timer = undefined
			}, function() {
				start()
			})
		}
		return this
	}
});

function goTopButton() {
	var a = arguments[0] ? arguments[0] : 25;
	if ($(window).width() >= 1060 && $('#footer').length) {
		var c = 500;
		var d = "<div id='gotop'><a title='返回顶部'>返回顶部</a></div>";
		$("#footer").append(d);
		var e = "";
		if ($('#main').length) {
			e = $('#main')
		} else if ($('#container').length) {
			e = $('#container')
		}
		if (e != "") {
			var f = e.offset().left + e.outerWidth(false) + a;
			$("#gotop").css("right", "none");
			$("#gotop").css("left", f + "px")
		}
		if ($(window).scrollTop() < c) {
			$("#gotop").hide()
		}
		$(window).scroll(function() {
			if ($(this).scrollTop() < c) {
				$("#gotop").fadeOut("slow")
			} else {
				$("#gotop").fadeIn("slow")
			}
		});
		$("#gotop a").click(function() {
			$("html,body").animate({
				scrollTop: 0
			}, "slow");
			return false
		})
	}
}