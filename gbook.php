<?php
/*
Template Name: Guestbook
*/
?>
<?php get_header(); ?>
<div class="page"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2 class="page_title" style="font-size: 15px;font-weight: normal;color: #969696;">尽情吐槽吧</h2>
<div class="clear"></div>
<p class="articles_all">非常欢迎大家灌水和吐槽，有什么想法和问题可以和我们沟通！我习惯了寂寞，并不代表我不渴望快乐！只要是留言或者评论都有机会上我们的读者墙和首页的热心读者墙，欢迎大家积极踊跃的留言和交流，有什么问题，意见和建议也可以在这里提。希望能为大家打造一个自由轻松的交流环境！</p>
<div class="clear"></div>
<h2 class="page_title" style="font-size: 15px;font-weight: normal;color: #969696;">温情留言板</h2>
<?php comments_template(); ?>

	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>