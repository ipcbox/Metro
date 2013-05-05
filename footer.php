<div style="display:none" id="nav_explor_content">
<ul class="tab_menu">
<li  class="current">文章分类</li><li>热门标签</li></ul>
<div class="tab_content">
<div><ul class="cat_ul">
<?php wp_list_categories('order=DESC&depth=1&title_li='); ?>
</ul><div class="clear"></div></div>
<div class="hide">
<div class="tags_div">
<?php wp_tag_cloud('smallest=12&largest=12&unit=px&number=25&orderby=count&order=RAND');?>
</div></div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<script type="text/javascript">/*<![CDATA[*/document.getElementById("container").style.overflow = "visible";
	document.getElementById("nav_explor").innerHTML=document.getElementById("nav_explor_content").innerHTML;
	if(getCookie("force_normal_theme")=="true"){document.write('<center><a id="goMobile" href="#" onclick="goMobile()">给我切换回手机版显示</a></center>');}/*]]>*/ 
	 jQuery(document).ready(function ($) {
		$('.entry-thumb img,.commentlist img,.post_content img,.sidebar ul li img,.ext_post_show_l img,.entry-author img,.avatar_box img').lazyload({effect : "fadeIn"});//lazyload
	})</script>
<div id="footer">
<div id="footer-body">
<a id="footer-logo" rel="nofollow" href="<?php bloginfo('url'); ?>"></a>
<div id="footer-content">
<?php echo comicpress_copyright(); ?> <a rel="nofollow" href="<?php bloginfo('url'); ?>" ><?php bloginfo('name'); ?></a> 版权所有  |  Theme By <a target="_blank" href="http://www.ipcbox.org">IPC软件盒</a>  |   
 <?php if (get_option('swt_beian') == 'Display') { ?>
<a href="http://www.miitbeian.gov.cn/" rel="external"><?php echo stripslashes(get_option('swt_beianhao')); ?></a>
<?php { echo '  |  '; } ?><?php } else { } ?> <?php if (get_option('swt_tj') == 'Display') { ?><?php echo stripslashes(get_option('swt_tjcode')); ?><?php } else { } ?>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;[ <a rel="nofollow" target="_blank" href="<?php bloginfo('url'); ?>/contact">广告投放</a> ]
</div>
</div>
</div>
<?php
	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
?>
<?php wp_footer(); ?>
<script type="text/javascript">
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('e c(){3 5=2.f(\'h\')[0];3 4;4=d.i();3 9="<j /> (k:<a 6=\'"+2.7.6+"\'>"+2.7.6+"</a>).";3 8=4+9;3 1=2.g(\'l\');1.b.r=\'t\';1.b.v=\'-m\';5.u(1);1.s=8;4.n(1);d.o(e(){5.p(1)},0)}2.q=c;',32,32,'|newdiv|document|var|selection|body_element|href|location|copytext|pagelink||style|addLink|window|function|getElementsByTagName|createElement|body|getSelection|br|via|div|99999px|selectAllChildren|setTimeout|removeChild|oncopy|position|innerHTML|absolute|appendChild|left'.split('|'),0,{}))
</script>
<?php if ( is_singular() ){ ?>
<!--<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/comments-ajax.js"></script>-->
<?php } ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/lib/load-scripts.php?c=1&load=realgravatar%2CcolorTip%2Choveraccordion&ver=1.28"></script>
</body>
</html>
<?php endif;?>