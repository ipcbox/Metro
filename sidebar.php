<div id="sidebar">
<ul>
<li class="clear"></li>
<li style="_display:block;width:301px;overflow:hidden;margin-bottom:7px"><a href="http://list.qq.com/cgi-bin/qf_invite?id=<?php echo get_option('swt_emaillist'); ?>" target="_blank" title="输入邮箱，及时掌握本站分享的资源">
<img alt="输入邮箱，及时掌握本站分享的资源" width="301" src="<?php bloginfo('template_directory'); ?>/images/qqmail.png"></a></li><li
class="clear"></li>
<li class="widget tab_box" id="tab_box_posts">
<ul class="tab_menu">
<li class="current">热门围观</li><li>最新文章</li><li>最新评论</li>
</ul>
<div class="tab_content">
<div><ul class="tab_post_links"><?php simple_get_most_viewed(); ?></ul>
</div>
<div class="hide">
<ul class="tab_post_links"><?php $myposts = get_posts('numberposts=10&offset=0');foreach($myposts as $post) :?>
<li><a href="<?php the_permalink(); ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_title)), 0, 37,"...","utf-8"); ?></a></li><?php endforeach; ?>
</ul>
</div>
<div class="hide">
<ul class="comment_ul">
		<?php
			global $wpdb;
			$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, SUBSTRING(comment_content,1,16) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND user_id='0' ORDER BY comment_date_gmt DESC LIMIT 10";
			$comments = $wpdb->get_results($sql);
			$output = $pre_HTML;
			foreach ($comments as $comment) {$output .= "\n<li><div class=\"rc_avatar\">".get_avatar(get_comment_author_email(), 32)."</div><div class=\"rc_comment\">".strip_tags($comment->comment_author).":<br />" . " <a href=\"" . get_permalink($comment->ID) ."#comment-" . $comment->comment_ID . "\" title=\"查看 " .$comment->post_title . "\">" . strip_tags($comment->com_excerpt)."</a></div></li>";}
			$output .= $post_HTML;
			$output = convert_smilies($output);
			echo $output;
		?> 
</ul>
</div>
</div><!-- .tab_content END-->
</li>
<li class="clear"></li> 
<li class="clear"></li>
<ul id="sidebar_float" class="clear">
<li class="clear"></li>
<ul class="widget tab_box" id="tab_box_top" style="margin-bottom:0">
<ul class="tab_menu"><li class="current">发现精彩</li><li>标签云集</li><li>更多精彩</li></ul>
<div class="tab_content">
<div>
<ul class="tab_post_links">
<?php $myposts = get_posts('numberposts=7&orderby=rand');foreach($myposts as $post) :?>
<li style="font-size:12px"><a href="<?php the_permalink(); ?>" rel="bookmark" target="_blank" title="详细阅读 <?php the_title_attribute(); ?>"><?php echo cut_str($post->post_title,37); ?></a></li><?php endforeach; ?>
</ul>
</div><div class="hide">
<div class="tags">
<ul>
	<?php wp_tag_cloud('smallest=12&largest=12&unit=px&number=50&orderby=count&order=RAND');?>		
</ul></div>
</div>
<div class="hide">
<ul class="tab_post_links">
<li><a href="<?php echo get_option('home'); ?>/?random" target="_blank" title="点我随机推荐一篇文章">点我试试手气</a></li>
<li><a href="http://list.qq.com/cgi-bin/qf_invite?id=<?php echo get_option('swt_emaillist'); ?>" target="_blank" title="通过QQ订阅本站">订阅到QQ邮箱</a></li>
<li><a href="<?php echo get_option('home'); ?>/feed" target="_blank" title="通过RSS订阅本站">通过RSS订阅</a></li>
<li><a href="<?php echo get_option('home'); ?>/guestbook" target="_blank" title="去留言板吐槽一番吧">温情留言板</a></li>
</ul>
</div>
</div>
</ul><li class="clear"></li>
<li class="clear"></li>
</ul></ul></div>
<div class="clear"></div>