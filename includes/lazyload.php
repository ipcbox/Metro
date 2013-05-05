<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/lazyload.js"></script>
<script type="text/javascript">
	jQuery(function() {          
    	jQuery('.entry-thumb img,.commentlist img,.post_content img,.sidebar ul li img,.ext_post_show_l img,.entry-author img,.avatar_box img).not("#respond_box img").lazyload({
        	placeholder:"<?php bloginfo('template_url'); ?>/images/image-pending.gif",
            effect:"fadeIn"
          });
    	});
</script>