<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-CN" itemscope itemtype="http://schema.org/WebPage">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php
$UA = $_SERVER['HTTP_USER_AGENT'];
if(strpos($UA, 'MSIE 8.0'))
echo '<meta http-equiv="X-UA-Compatible" content="ie=7" />';
?>
<?php include('includes/seo.php'); ?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/lib/load-styles.php?c=1&load=style&ver=1.28" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/lib/load-scripts.php?c=1&load=jquery%2Clazyload%2Ccommon%2Cmetro%2Cphzoom&ver=1.28"></script>
<!--[if lt IE 9]><script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script><![endif]-->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('url'); ?>/favicon.ico" type="image/x-icon" />
<?php if ( is_singular() ){ ?>
<script type="text/javascript">jQuery(document).ready(function($){var $images=$('.post_content a:has(img)');$images.phzoom({})});</script>
<?php } ?>
<?php wp_head(); ?>
</head>

<body><script type="text/javascript">if(screen.width>1030){document.getElementsByTagName('body')[0].className = "widescreen";}</script>
<div id="container">
<div id="header">
<div id="logo"><h1><a title="<?php bloginfo('name'); ?> 首页" href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
</div>
</div>
<div id="nav"><ul class="nav-ul">
<li<?php if ( is_home() ) { echo ' class="current_page_item"'; }?>><a href="<?php echo get_option('home'); ?>/">首页</a></li>

<li class="dropdownlink">
<a href="javascript:alert('点我木有用，用鼠标指着我就会出现下拉菜单');document.getElementById('s').focus();">探索发现<span></span></a>
<div class="submenu tab_box" id="nav_explor"> <script type="text/javascript">/*<![CDATA[*/document.write('<div style="margin:30px auto;margin:10px auto;text-align:center;color:#999">载入中...</div>');/*]]>*/</script> </div>
</li>
<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'primary', 'echo' => false)) )); ?>
<li class="dropdownlink">
<a href="javascript:alert('点我木有用，用鼠标指着我就会出现下拉菜单');">关注与爆料<span></span></a>
<ul class="submenu">
<li class="first"><a target="_blank" href="http://t.qq.com/ipcbox" rel="nofllow">腾讯微博</a></li>
<li><a target="_blank" href="http://user.qzone.qq.com/342558980/main" rel="nofllow">QQ空间</a></li>
<li><a href="javascript:alert('点我木有用，直接用手机打开本站即可切换到手机移动版');" >手机移动版</a></li>
</ul>
</li>
<li class="dropdownlink"><a href="<?php echo get_option('home'); ?>/guestbook">留言<span></span></a>
<ul class="submenu">
<li class="first"><a title="捐赠/付款到Ipcbox" href="https://me.alipay.com/ipcbox">捐赠/付款</a></li>
</ul>
</li><a class="nav-robot" title="点我吧，点我吧！我能随机给你找一篇好看的文章！" target="_blank" rel="nofollow" href="<?php echo get_option('home'); ?>?random">随机</a>
</ul>
<div class="search">	
<div class="search_site addapted" style="overflow: hidden; width: 260px; ">	
			<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
				<input type="submit" value id="searchsubmit" class="button">
				<input type="text" id="s" name="s" value="搜索..." onfocus="if (this.value == '搜索...') {this.value = '';}" onblur="if (this.value == '') {this.value = '搜索...';}" >
			</form>
		</div></div>
<div class="clear"></div>
</div>
<!--nav end-->
<div id="crumb"><?php the_breadcrumb(); ?>
<div id="crumb_r"><script type="text/javascript"><!--
google_ad_client = "ca-pub-2420325514385307";
/* ipcboxCrumb */
google_ad_slot = "3716144827";
google_ad_width = 468;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</div>
<?php if ( is_home() ) { ?>
<div class="bd_bg">
<div class="hotlist clearfix">
<?php global $wpdb;
$most_viewed = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.*, (meta_value+0) AS views FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE post_date < '".current_time('mysql')."' AND post_type <> 'page' AND post_status = 'publish' AND meta_key = 'views' AND post_password = '' ORDER BY views DESC LIMIT 8");
if($most_viewed) {
foreach ($most_viewed as $post) {
$post_views = intval($post->views);
$post_title = htmlspecialchars(stripslashes($post->post_title));
$permalink = get_permalink($post->ID);?>
<li class="bd_t"><a href="<?php echo $permalink ?>" rel="bookmark" title="<?php echo $post_title ?>"><?php dm_the_thumbnail() ?></a><p class="p5"><a target="_blank" href="<?php echo $permalink ?>" title="<?php echo $post_title ?>" rel="bookmark"><?php echo $post_title ?></a></p></li>
<?php }
}
?>
</div>				
</div>
<?php } ?>
