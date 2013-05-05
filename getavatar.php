<?php/*Template Name: avatar*/?>
<?php get_header(); ?>
<div class="page"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2 class="page_title">教你玩转Gravatar全球通用头像</h2><ul>
<?php the_content('Read more...'); ?>
<h2 class="page_title" style="font-size: 15px;font-weight: normal;color: #969696;">温情留言板</h2>
<div id="comments"><div class="section_title"><span>各种回音</span></div>
<?php comments_template(); ?>
</div>
	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>