<?php
/*
Template Name: Link
*/
?>
<?php get_header(); ?>
<div class="page"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<script type="text/javascript">
jQuery(document).ready(function($){
$(".flink a").each(function(e){
	$(this).prepend("<img src=http://www.google.com/s2/favicons?domain="+this.href.replace(/^(http:\/\/[^\/]+).*$/, '$1').replace( 'http://', '' )+" style=float:left;padding:5px;>");
}); 
});
</script>
<h2 class="page_title" style="font-size: 15px;font-weight: normal;color: #969696;">友情链接</h2>
<div class="flink"><ul>
<?php wp_list_bookmarks('orderby=id&category_orderby=id'); ?></ul>
</div>
<div class="clear"></div>
<div class="linkstandard">
<h2 class="page_title">链接须知</h2><ul>
<li>一、在您申请本站友情链接之前请先做好本站链接，然后在下面留言。</li>
<li>二、谢绝任何非法内容的的友情链接，本站只接受正规网站的友链。</li>
<li>三、本站友链要求半年以上的软件分享、游戏下载、IT博客等，其他的恕不通过（如果你的站很有特色，我会考虑）。</li>
<li>四、本站暂不受理Baidu和Google没有收录的站点。</li>
<li>五、要求大部分内容原创、用心做站，完全以盈利为目的，采集类或其他没有实质内容的站点恕不受理。</li>
<li style="color:red;font-weight:bold">六、由于近期本站清理了一部分无效链接，如有误删请联系我，这里先表示歉意。</li>
</ul>
</div>
<h2 class="page_title" style="font-size: 15px;font-weight: normal;color: #969696;">温情留言板</h2>
<?php comments_template(); ?>

	<?php endwhile;?>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>