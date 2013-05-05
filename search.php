<?php get_header();?>
<div id="posts">
<div id="posts-list">
<div class="clear"></div>
<?php $count = 1; ?>
<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
<?php if(($count == 1||$count == 2||$count == 3)) : ?>
<div class="entry top-entry" itemscope itemtype="http://schema.org/Article">
<h2 class="entry-title">
<a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>" itemprop="name"><?php the_title(); ?></a><?php include('includes/new.php'); ?></h2>
<div class="entry-meta">
<span class="entry-category-icon"><?php the_category(', ') ?></span>
<span class="entry-comment-icon"><?php comments_popup_link ('0条评论','1条评论','%条评论'); ?></span>
<span class="entry-view-icon">超过<?php if(function_exists('the_views')) echo the_views().'人围观'; ?></span>
<span class="entry-number"><div class="post-title-date"><center><span class="post-day"><?php the_time('d') ?></span><br><span class="post-month"><?php the_time('F'); ?></span></center></div>
</span><!--文章-->
</div>
<div class="entry-content" itemprop="description">
<p class="entry-image"><a href="<?php the_permalink() ?>" rel="bookmark" target="_blank" title="<?php the_title(); ?>"><?php $random = mt_rand(1, 10);$image_id = get_post_thumbnail_id();$cover = wp_get_attachment_image_src($image_id, 'photo-medium');if ($image_id) {echo '<img src="' . $cover[0] . '" alt="' . get_the_title() . '" width="450" height="250"/>';} else {echo '<img src="' . get_template_directory_uri() . '/images/random/tl'.$random.'.png" alt="no image" width="450" height="250"/>';} ?></a></p><p><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 150,"...","utf-8"); ?></p>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
<?php else: ?>
<div class="entry" itemscope itemtype="http://schema.org/Article">
<div class="entry-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" target="_blank" title="<?php the_title(); ?>"><?php dm_the_thumbnail(); ?></a></div><div class="entry-body">
<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"  itemprop="name"><?php the_title(); ?></a></h2>
<div class="entry-meta">
<span class="entry-category-icon"><?php the_category(', ') ?></span>
<span class="entry-comment-icon"><?php comments_popup_link ('0条评论','1条评论','%条评论'); ?></span>
<span class="entry-view-icon">超过<?php if(function_exists('the_views')) echo the_views().'人围观'; ?></span>
<span class="entry-number"><?php the_time('m') ?>-<?php the_time('d') ?></span>
</div>
<div class="entry-content" itemprop="description">
<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 180,"...","utf-8"); ?></div>
<a class="entry-more" href="<?php the_permalink() ?>" itemprop="url" title="阅读全文..."><span></span></a></div>
<div class="clear"></div></div> <div class="clear"></div>
<?php endif;$count++; ?>
		<?php endwhile; else: ?>
<h3 class="center">非常抱歉，无法搜索到与之相匹配的信息。</h3>
<?php endif; ?> 
<div class="navigation"><?php pagination($query_string); ?></div>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>