<?php get_header(); ?>
<div class="page"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2 class="page_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <?php the_content('Read more...'); ?>
<?php comments_template(); ?>

	<?php endwhile;endif;?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>