<?php get_header(); ?>
<div class="post" itemscope itemtype="http://schema.org/Article">
<script type="text/javascript">
    function doZoom(size) {
        var zoom = document.all ? document.all['post_content'] : document.getElementById('post_content');
        zoom.style.fontSize = size + 'px';
    }
</script>
<div class="post-top-ad">
</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post-title"><h1 id="post-title" itemprop="name"><?php the_title(); ?></h1>
<div class="post_meta"><span class="entry-category-icon"><?php the_category(', ') ?></span>
<span class="font"><a href="javascript:doZoom(12)">小</a> <a href="javascript:doZoom(15)">中</a> <a href="javascript:doZoom(18)">大</a></span>
</div>
<div class="post-title-block"><div class="post-title-date"><center><span class="post-day"><?php the_time('d') ?></span><br/><span class="post-month"><?php the_time('F') ?></span></center></div></div></div>
<div id="share_toolbar_wrapper"></div>
<div id="post_expire_msg"></div>
<div class="post_content" id="post_content" itemprop="articleBody">
        <?php if (get_option('swt_adb') == 'Display') { ?><div style="float:right;border:1px #ccc solid;padding:2px;overflow:hidden;margin:12px 0 1px 2px;"><?php echo stripslashes(get_option('swt_adbcode')); ?></div><?php { echo ''; } ?><?php } else { } ?><?php the_content(); ?>
        <?php if (get_option('swt_adc') == 'Display') { ?><p style="text-align:center;"><?php echo stripslashes(get_option('swt_adccode')); ?></p><?php { echo ''; } ?><?php } else { } ?>
</div>
<?php $Date_1=get_post_time("Y-m-d");$Date_2=date("Y-m-d");$d1=strtotime($Date_1);$d2=strtotime($Date_2);$Days=round(($d2-$d1)/3600/24);
  if($Days>365){  ?> 
<script language="JavaScript">var show_exipre_time=getCookie("no_exipre_msg");if(show_exipre_time==null){show_exipre_time=0};if(show_exipre_time<3){var post_expire_msg=document.getElementById("post_expire_msg");post_expire_msg.style.display="block";post_expire_msg.innerHTML="温馨提示：由于此文章发布于<?php echo times_ago(); ?>前，日久失修可能图片或下载链接会失效，如有不便请谅解<br /><a onClick=\"no_exipre_msg();\">[ 明白，不要再提示 ]</a>"}else{if(no_exipre_msg<3){SetCookie("no_exipre_msg","true",5)}}function no_exipre_msg(){SetCookie("no_exipre_msg","true",5);document.getElementById("post_expire_msg").style.display="none"}function SetCookie(name,value,days){var exp=new Date();exp.setTime(exp.getTime()+days*86400000);document.cookie=name+"="+escape(value)+";expires="+exp.toGMTString()}function getCookie(name){var arr=document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));if(arr!=null)return unescape(arr[2]);return null}function delCookie(name){var exp=new Date();exp.setTime(exp.getTime()-1);var cval=getCookie(name);if(cval!=null)document.cookie=name+"="+cval+";expires="+exp.toGMTString()}</script>	<?php }  ?>
				<script type="text/javascript">
		var post_title = '<?php the_title(); ?>';
		var post_description = '<?php strip_tags(the_excerpt()); ?>';
		var post_url = "<?php the_permalink() ?>";  
		var post_img = '<?php get_the_thumbnail(get_the_ID()); ?>';
		var previous_post_title = '<?php if (get_previous_post()) { echo get_the_title(get_previous_post(false,'')); } else { echo "木有啦"; } ?>';
		var previous_post_url = "<?php if (get_previous_post()) { echo get_permalink(get_previous_post(false,'')); } else { echo "javascript:alert('木有啦，已经是最后一篇了...');"; } ?>";
		var next_post_title = '<?php if (get_next_post()) { echo get_the_title(get_next_post(false,'')); } else { echo "木有啦"; } ?>';
		var next_post_url = "<?php if (get_next_post()) { echo get_permalink(get_next_post(false,'')); } else { echo "javascript:alert('你正在看的文章已经是最新的了...');"; } ?>";
		bds_config = { //百度分享
			'bdDes':post_description,
			'bdText':post_title
			,'bdPic':post_img		};
		bdShare_config = { "url":post_url};
		loadShareToolbar('<?php if(function_exists('the_views')) { the_views();; } ?>',post_url,previous_post_url,previous_post_title,next_post_url,next_post_title);
	</script>
<div style="clear:both;margin-top:20px">
</div>
<div class="clear"></div>
<div class="entry-author">
<?php echo get_avatar( get_the_author_email(), '80' ); ?><span class="entry-author-name"><?php  echo the_author_meta( 'nickname' ); ?></span><br/>
<div class="entry-author-description"><?php  echo the_author_meta( 'description' ); ?></div>
<div class="entry-author-links">
<?php if (get_the_author_meta('weibo_sina')!=""){ ?><?php echo "<a href='" . get_the_author_meta('weibo_sina') . "' target='_blank'>新浪微博</a>&nbsp;&nbsp;|&nbsp;&nbsp;"; ?><?php } ?><?php if (get_the_author_meta('weibo_tx')!=""){ ?><?php echo "<a href='" . get_the_author_meta('weibo_tx') . "' target='_blank'>腾讯微博</a>&nbsp;&nbsp;|&nbsp;&nbsp;"; ?><?php } ?><?php if (get_the_author_meta('qq')!=""){ ?><?php echo "<a href='" . get_the_author_meta('qq') . "' target='_blank'>QQ空间</a>&nbsp;&nbsp;|&nbsp;&nbsp;"; ?><?php } ?></div>
<div class="entry-author-title">关于本文的小编</div></div>
<div class="section_title"><span>关于本文</span></div>
<div class="post_detail">
<ul>
<li>属于分类：<span id="post_category"><?php the_category(', ') ?></li>
<li><?php the_tags('本文标签：', ', ', ''); ?></li>
<?php if($article_source_link || $article_source){	
?>
<li>文章来源：来自 <?php if (!$article_source_link) echo $article_source; else echo '<a rel="nofollow" target="_blank" href="'.$article_source_link.'">'.$article_source.'</a>';?></li>
<?php } ?>
<li>流行热度：<span id="post_view_count">超过<?php if(function_exists('the_views')) echo the_views().'人围观'; ?></span></li>
<li>生产日期：<?php the_date_xml(); ?></li>
<li>加载用时：加载本文共用时 <?php timer_stop(1);?> 秒</li>
</ul>
<div id="wumiiDisplayDiv" class="wumiidisplay"></div>
<div class="section_title"><span>相关文章</span></div>
<ul class="same-cat-post"><?php include('includes/related.php'); ?></ul>
</div>
<?php comments_template(); ?>

	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>