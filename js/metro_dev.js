var strBatchView = "";

function setCommentForm(a, b, c, d) {
	if (g("author") != null) g("author").value = a;
	if (g("email") != null) g("email").value = b;
	if (g("url") != null) g("url").value = c;
	if (null != g("ck")) {
		g("ck").value = d
	}
}
function checkComment() {
	var a = document.getElementById('comment').value;
	if (document.getElementById('author') != null) {
		if (document.getElementById('author').value == "" || document.getElementById('email').value == "" || a == "") {
			alert("嘿嘿，你好像还有东西没写耶，我不给你发！");
			return false
		}
	}
	re = /[一-龥]{1,}/ig;
	r = a.match(re);
	if (r == null || r.length <= 0) {
		alert("为了促进世界和平与社会和谐，你至少要写一个中文字的说……");
		return false
	}
	return true
}
function commentHotkey() {
	if (g('comment') == null) return;
	g('comment').onkeydown = function(a) {
		var b = null;
		if (window.event) {
			b = window.event
		} else {
			b = a
		}
		if (b != null && b.ctrlKey && b.keyCode == 13) {
			document.getElementById('submit').click()
		}
	}
}
jQuery(function() {
	jQuery('.thumbnail img').hover(function() {
		jQuery(this).fadeTo("fast", 0.5)
	}, function() {
		jQuery(this).fadeTo("fast", 1)
	})
});
jQuery(document).ready(function() {
	jQuery("a[rel='external'],a[rel='external nofollow']").click(function() {
		window.open(this.href);
		return false
	})
});
jQuery(document).ready(function($) {
	$(".ext_post_l ul li:even").addClass("");
	$(".ext_post_l ul li:odd").addClass("ext_post_sep");
	$(".ext_post_r ul li:even").addClass("");
	$(".ext_post_r ul li:odd").addClass("ext_post_sep")
});
jQuery(document).ready(function($) {
	$("a[href*='http://']:not([href*='" + location.hostname + "']),[href*='https://']:not([href*='" + location.hostname + "'])").addClass("external").attr("target", "_blank");
	$('.nav-ul .dropdownlink').hover(function() {
		$(this).find('.submenu').stop().fadeTo('fast', 1)
	}, function() {
		$(this).find('.submenu').stop().fadeOut()
	});
	$(".post_content a[href='" + window.location.href + "']").addClass("selflink");
	$('.selflink').click(function() {
		return false
	});
	if ($("#posts").outerHeight(true) || $(".post").outerHeight(true) || $(".page").outerHeight(true) > $("#sidebar").outerHeight(true)) {
		$("#sidebar_float").scrollFollow({
			bottomObj: '#ext_post,#photo_list,#footer',
			marginTop: 8,
			marginBottom: 0
		})
	};
	$("#share_toolbar_wrapper").scrollFollow({
		marginTop: 0,
		marginBottom: 0
	});
	$('#tab_box_posts').Tabs({
		event: 'mouseover'
	});
	$('#nav_explor').Tabs({
		event: 'mouseover'
	});
	$('#tab_box_top').Tabs({
		event: 'mouseover'
	});
	$('.entry').hover(function() {
		var a = $(this).find('.entry-more');
		var b = a.parent().parent().outerHeight() - 3;
		a.css("height", b);
		a.find('span').css("top", (b / 2 - 25));
		a.show()
	}, function() {
		$(this).find('.entry-more').hide()
	});
	$('.dropdownlink').hover(function() {
		$('submenu tab_box', this).slideDown(300)
	}, function() {
		$('submenu tab_box', this).slideUp(300)
	});
	$('.comment').hover(function() {
		$(this).find('.comment_text .comment_reply_links').stop(true, true).show()
	}, function() {
		$(this).find('.comment_text .comment_reply_links').stop(true, true).hide()
	});
	goTopButton()
});

function postDigg(typee, id) {
	jQuery.ajax({
		type: "POST",
		url: "/",
		data: {
			type: typee,
			postid: id
		},
		success: function(data) {
			if (data == "请勿非法提交！" || data == "您已经顶过该日志，请不要重复顶日志！") {
				alert(data)
			} else {
				jQuery("#qlwz-digg").html(data)
			}
		},
		error: function() {
			alert("Digg出错")
		}
	})
}