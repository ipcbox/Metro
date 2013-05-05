<?php if(ISMOBILE && !isset($_COOKIE['force_normal_theme'])): ?>
 <?php include('mobile/comments.php'); ?>
 <?php else:?>
<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	/* This variable is for alternating comment background */
	$oddcomment = '';
?>
    <div style="margin:20px 0 30px 0"></div>
	<div id="comments">
    <div class="section_title"><span>各种回音</span></div>
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword">文章已设置密码，请输入密码才能查看评论</p>
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>



<?php if ( have_comments() ) : ?>		
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div class="commentnavi graybox">评论分页：<?php previous_comments_link('&laquo; 上一页'); ?>  <?php next_comments_link('下一页 &raquo;'); ?></div>
	<?php endif; // check for comment navigation ?>
	<ol id="comments_list">
		<?php wp_list_comments('type=comment&callback=metro_comment&end-callback=metro_end_comment&max_depth=23'); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div class="commentnavi graybox">评论分页：<?php previous_comments_link('&laquo; 上一页'); ?>  <?php next_comments_link('下一页 &raquo;'); ?></div>
	<?php endif; // check for comment navigation ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
		<div id="respond">
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
			<p class="must-log-in"><?php printf( __( '你必须 <a href="%s">登录</a> 才能发表评论.' ), wp_login_url(get_permalink() ) ); ?></p>
	<?php else : ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform"" name="commentForm" onSubmit="return(checkComment())">
				<?php comment_id_fields(); ?>
				<ul class="comment-l">
				<li style="height:28px;line-height:28px;overflow:hidden">
				<div id="cancel-comment-reply"><?php cancel_comment_reply_link('不要回复他 (她)'); ?></div>
				<label for="comment">评论内容：(必填)</label></li><li><textarea name="comment" id="comment" tabindex="1"></textarea></li>
				<li class="comment-btn"><p>( Ctrl+Enter快速提交 )&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" id="submit" tabindex="5" value="写好了，发出去！" /></p></li>
				<?php do_action('comment_form', $post->ID); ?>
				</ul>
				<ul class="comment-r">
		<?php if ( is_user_logged_in() ) : ?>
				<li><?php printf( str_replace('<br />', ' ', __( '<a href="%1$s">%2$s</a><br />(<a href="%3$s" title="注销登录">登出</a>)' )), admin_url( 'profile.php' ), $user_identity, wp_logout_url( get_permalink() ) ); ?></li>
		<?php else : ?>
				<li><label for="author">你的大名：(必填)</label></li>
				<li><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="2" aria-required='true' /></li>
				<li><label for="email">邮箱地址：(必填)</label></li>
				<li><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="3" aria-required='true' /></li>
				<li><label for="url">您的网址：</label></li>
                <li><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="25" tabindex="4" /></li>
		<?php endif; ?>
				</ul>
				<div class="clear"></div>
			</form>
	<?php endif; ?>
		</div>

<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) && ! have_comments() ) : ?>
		<p class="nocomments">评论已关闭！</p>
<?php endif; ?>
</div><!-- #comments -->
<?php endif;?>