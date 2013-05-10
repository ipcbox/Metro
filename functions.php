<?php
include("includes/theme_options.php");
include('includes/user-function.php');
add_editor_style('editor-style.css');
$match_num_from = 1;
$match_num_to = 10;
add_filter('the_content','tag_link',1);
//按长度排序
function tag_sort($a, $b){
	if ( $a->name == $b->name ) return 0;
	return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
}
add_action('template_redirect', 'ipcbox_redirect_single_post');
function ipcbox_redirect_single_post() {
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
        }
    }
}
//改变标签关键字
function tag_link($content){
global $match_num_from,$match_num_to;
	 $posttags = get_the_tags();
	 if ($posttags) {
		 usort($posttags, "tag_sort");
		 foreach($posttags as $tag) {
			 $link = get_tag_link($tag->term_id);
			 $keyword = $tag->name;
			 //连接代码
			 $cleankeyword = stripslashes($keyword);
			 $url = "<a href=\"$link\" title=\"".str_replace('%s',addcslashes($cleankeyword, '$'),__('View all posts in %s'))."\"";
			 $url .= ' target="_blank"';
			 $url .= ">".addcslashes($cleankeyword, '$')."</a>";
			 $limit = rand($match_num_from,$match_num_to);

			//不连接的 代码
             $content = preg_replace( '|(<a[^>]+>)(.*)('.$ex_word.')(.*)(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
			 $content = preg_replace( '|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);

				$cleankeyword = preg_quote($cleankeyword,'\'');

					$regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;

				$content = preg_replace($regEx,$url,$content,$limit);

	$content = str_replace( '%&&&&&%', stripslashes($ex_word), $content);

		 }
	 }
    return $content;
}
function cat_post_types() {
    global $post;
    if (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug      = $post_type->rewrite;
            echo '' . $post_type->labels->singular_name . '';
        }
    }
}
function add_custom_types_to_tax( $query ) {
if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
$post_types = get_post_types();
$query->set( 'post_type', $post_types );
return $query;
}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );
function dopt($e){
    return stripslashes(get_option($e));
}
function dlUrl($atts, $content = null) {
extract(shortcode_atts(array(
"href" => 'http://'
), $atts));
return '<div id="download"><div id="down_link">
<a href="'.$href.'">'.$content.'</a><p>如无特殊说明,本文件解压密码为:<span style="color:#f00">' . get_option('home') .'</span></p><div class="clear"></div></div></div>';
}
add_shortcode('dl', 'dlUrl');
add_action('admin_init', 'add_sc_button');
function add_sc_button() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter( 'mce_external_plugins', 'add_sc_tinymce_plugin' );
     add_filter( 'mce_buttons', 'register_sc_button' );
   }
}
function register_sc_button( $buttons ) {
	array_push( $buttons, "|", "ipcbox_shortcodes" );
	return $buttons;
}
function add_sc_tinymce_plugin( $plugin_array ) {
   $plugin_array['ipcbox_shortcodes'] = get_bloginfo( 'template_url' ) . '/js/editor_plugin.js';
   return $plugin_array;
}
add_filter('the_content','content_nofollow',999);
function content_nofollow($content){
	preg_match_all('/href="(.*?)"/',$content,$matches);
	if($matches){
		foreach($matches[1] as $val){
			if( strpos($val,home_url())===false ) $content=str_replace("href=\"$val\"", "href=\"$val\" rel=\"external nofollow\" ",$content);
		}
	}
	return $content;
}
function the_breadcrumb() {

  $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = '&raquo;'; // delimiter between crumbs
  $home = __('首页'); // text for the 'Home' link
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb

  global $post;
  $homeLink = home_url();

  if (is_home() || is_front_page()) {

    if ($showOnHome == 1) echo '<div id="crumb_l" itemprop="breadcrumb">你的位置：
<a href="' . $homeLink . '">' . $home . '</a></div>';

  } else {

    echo '<div id="crumb_l" itemprop="breadcrumb">你的位置：<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
      echo $before . '分类 "' . single_cat_title('', false) . '"' . $after;

    } elseif ( is_search() ) {
      echo $before . ' "' . get_search_query() . '" 的搜索结果' . $after;

    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

  } elseif(is_singular('photo')) {
      if ($showCurrent == 1) echo ' ' . $before . get_the_title() . $after;   
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
    $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="'. get_post_type_archive_link('photo') . '">' . $post_type->labels->singular_name . '</a>';
        if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
      }
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_tag() ) {
      echo $before . '标签 "' . single_tag_title('', false) . '"' . $after;

    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . '作者 ' . $userdata->display_name . $after;

    } elseif ( is_404() ) {
      echo $before . '404 错误' . $after;
    }

    if ( get_query_var('paged') ) {
      //if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
    echo ' (';
     echo '' . __('第') . ' ' . get_query_var('paged').'';
      //if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
    echo ' 页)';
    }

    echo '</div>';

  }
}
//阻止站内文章Pingback 
function ipcbox_noself_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}
//修改默认发信地址
function dtheme_res_from_email($email) {
    $wp_from_email = get_option('admin_email');
    return $wp_from_email;
}
function dtheme_res_from_name($email){
    $wp_from_name = get_option('blogname');
    return $wp_from_name;
}
//移除自动保存
function dtheme_disable_autosave() {
  wp_deregister_script('autosave');
}
//Gzip压缩
function dtheme_gzip() {
  if ( strstr($_SERVER['REQUEST_URI'], '/js/tinymce') )
    return false;
  if ( ( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler' )
    return false;
  if (extension_loaded('zlib') && !ob_start('ob_gzhandler'))
    ob_start();
} 
//缩略图获取
function dm_the_thumbnail() {  
    global $post;  
    if ( has_post_thumbnail() ) {   
    $domsxe = simplexml_load_string(get_the_post_thumbnail());
    $thumbnailsrc = $domsxe->attributes()->src;  
    echo '<img width="140" height="100" src="'.$thumbnailsrc.'" alt="'.trim(strip_tags( $post->post_title )).'" />';
    } else {
        $content = $post->post_content;  
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER); 
        $n = count($strResult[1]);  
        if($n > 0){
            echo '<img width="140" height="100" src="'.$strResult[1][0].'" alt="'.trim(strip_tags( $post->post_title )).'" />';  
        }else {
            echo '<img width="140" height="100" src="'.get_bloginfo('template_url').'/images/thumbnail.png" alt="'.trim(strip_tags( $post->post_title )).'" />';  
        }  
    }  
}
function ipcbox_queryinfo(){
global $author;
$userdata = get_userdata($author);
  echo '<div class="page_title">正在显示 ';
  if (is_category())    { echo '[ '; echo single_cat_title().' ] 分类下的文章';
  } elseif( is_tag() )  { echo '[ '; echo single_tag_title().' ] 标签下的文章';
  } elseif( is_day() )  { echo the_time('Y年 F j日').' 的文章';
  } elseif( is_month() )  { echo the_time('Y年 F').' 的文章';
  } elseif( is_year() )   { echo the_time('Y年').' 的文章';
  } elseif( is_author() )   { echo '作者 [ ';echo $userdata->display_name.'] 的文章';
  } elseif( is_search() )   { echo the_search_query(); echo ' 的搜索结果';
  } elseif( isset($_GET['paged']) && !empty($_GET['paged'])) { echo '的是以前的文章';
  }
  echo '</div>';
}
function dtheme_share(){
  echo '<div id="post_expire_msg" style="display: none;"></div>
                    <div id="share_toolbar_wrapper"></div>';
}
function get_the_thumbnail(){
global $post;
if (has_post_thumbnail()){
$domsxe = simplexml_load_string(get_the_post_thumbnail());
$thumbnailsrc = $domsxe->attributes()->src;
echo $thumbnailsrc;
} else {
$content = $post->post_content; preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER); 
$n = count($strResult[1]);  if($n > 0){
echo $strResult[1][0];
} else {
echo get_bloginfo('template_url').'/img/thumbnail.png';
} 
} 
}
if (function_exists('register_sidebar'))
{
    register_sidebar(array(
		'name'			=> '小工具1',
        'before_widget'	=> '',
        'after_widget'	=> '',
        'before_title'	=> '<h3>',
        'after_title'	=> '</h3>',
    	'after_widget' => '',
    ));
}
{
    register_sidebar(array(
		'name'			=> '小工具2',
        'before_widget'	=> '',
        'after_widget'	=> '',
        'before_title'	=> '<h3>',
        'after_title'	=> '</h3>',
    	'after_widget' => '',
    ));
}
{
    register_sidebar(array(
		'name'			=> '小工具3',
        'before_widget'	=> '',
        'after_widget'	=> '',
        'before_title'	=> '<h3>',
        'after_title'	=> '</h3>',
    	'after_widget' => '',
    ));
}

if ( function_exists('register_nav_menus') ) {
    register_nav_menus(array(
        'primary' => '导航菜单'
    ));
}
function random_postlite() {
	global $wpdb;
	$query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'post' AND post_password = '' AND 	post_status = 'publish' ORDER BY RAND() LIMIT 1";
	if ( isset( $_GET['random_cat_id'] ) ) {
		$random_cat_id = (int) $_GET['random_cat_id'];
		$query = "SELECT DISTINCT ID FROM $wpdb->posts AS p INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id AND tr.term_taxonomy_id = $random_cat_id) INNER JOIN  $wpdb->term_taxonomy AS tt ON(tr.term_taxonomy_id = tt.term_taxonomy_id AND taxonomy = 'category') WHERE post_type = 'post' AND post_password = '' AND 	post_status = 'publish' ORDER BY RAND() LIMIT 1";
	}
	if ( isset( $_GET['random_post_type'] ) ) {
		$post_type = preg_replace( '|[^a-z]|i', '', $_GET['random_post_type'] );
		$query = "SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type' AND post_password = '' AND 	post_status = 'publish' ORDER BY RAND() LIMIT 1";
	}
	$random_id = $wpdb->get_var( $query );
	wp_redirect( get_permalink( $random_id ) );
	exit;
}
if ( isset( $_GET['random'] ) )
add_action( 'template_redirect', 'random_postlite' );
// 获得热评文章
function simple_get_most_viewed($posts_num=10, $days=30){
    global $wpdb;
    $sql = "SELECT ID , post_title , comment_count
            FROM $wpdb->posts
           WHERE post_type = 'post' AND TO_DAYS(now()) - TO_DAYS(post_date) < $days
		   AND ($wpdb->posts.`post_status` = 'publish' OR $wpdb->posts.`post_status` = 'inherit')
           ORDER BY comment_count DESC LIMIT 0 , $posts_num ";
    $posts = $wpdb->get_results($sql);
    $output = "";
    foreach ($posts as $post){
        $output .= "\n<li><a href= \"".get_permalink($post->ID)."\" target=\"_blank\" rel=\"bookmark\" title=\"".$post->post_title." (".$post->comment_count."条评论)\" >". cut_str($post->post_title,37,"utf-8")."</a></li>";
    }
    echo $output;
}
//标题文字截断
function cut_str($src_str,$cut_length)
{
    $return_str='';
    $i=0;
    $n=0;
    $str_length=strlen($src_str);
    while (($n<$cut_length) && ($i<=$str_length))
    {
        $tmp_str=substr($src_str,$i,1);
        $ascnum=ord($tmp_str);
        if ($ascnum>=224)
        {
            $return_str=$return_str.substr($src_str,$i,3);
            $i=$i+3;
            $n=$n+2;
        }
        elseif ($ascnum>=192)
        {
            $return_str=$return_str.substr($src_str,$i,2);
            $i=$i+2;
            $n=$n+2;
        }
        elseif ($ascnum>=65 && $ascnum<=90)
        {
            $return_str=$return_str.substr($src_str,$i,1);
            $i=$i+1;
            $n=$n+2;
        }
        else 
        {
            $return_str=$return_str.substr($src_str,$i,1);
            $i=$i+1;
            $n=$n+1;
        }
    }
    if ($i<$str_length)
    {
        $return_str = $return_str . '';
    }
    if (get_post_status() == 'private')
    {
        $return_str = $return_str . '（private）';
    }
    return $return_str;
}
function times_ago( $type = 'post' ) {$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';return human_time_diff($d('U'),current_time('timestamp'));}
//cuttitle
function title($max_length) { 
$title_str = get_the_title(); 
if (mb_strlen($title_str,'utf-8') > $max_length ) { 
  $title_str = mb_substr($title_str,0,$max_length,'utf-8').'...'; 
} 
return $title_str; 
} 
//彩色标签云
function colorCloud($text) {
$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
return $text;
}
function colorCloudCallback($matches) {
$text = $matches[1];
//$color = dechex(rand(0,16777215));
$colors=array('0664B0','2F9944','CA5254','F53300');
$color=$colors[dechex(rand(0,3))];
$pattern = '/style=(\'|\")(.*)(\'|\")/i';
$text = preg_replace($pattern, "style=\"background:#{$color};color: #fff;display: inline-block;margin-bottom:3px;margin-right:3px;padding:2px 4px 3px 4px;border-radius:2px;opacity:.6;cursor:pointer;box-shadow:0 4px 3px -3px rgba(0,0,0,0.1);-webkit-transition:opacity .2s ease-in-out;-moz-transition:opacity .2s ease-in-out;-ms-transition:opacity .2s ease-in-out;-o-transition:opacity .2s ease-in-out;transition:opacity .2s ease-in-out;$2;\"", $text);
return "<a $text>";
}
add_filter('wp_tag_cloud', 'colorCloud', 1);
//分页
function pagination($query_string){
global $posts_per_page, $paged;
$my_query = new WP_Query($query_string ."&posts_per_page=-1");
$total_posts = $my_query->post_count;
if(empty($paged))$paged = 1;
$prev = $paged - 1;							
$next = $paged + 1;	
$range = 5; // 修改数字,可以显示更多的分页链接
$showitems = ($range * 2)+1;
$pages = ceil($total_posts/$posts_per_page);
if(1 != $pages){
	echo "<div class='pagenavi'>";
	echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."' class='extend' title='跳转到首页'>首页</a>":"";
	echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."' class='prev'>« 上一页</a>":"";		
	for ($i=1; $i <= $pages; $i++){
	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
	echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."'>".$i."</a>"; 
	}
	}
	echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>下一页 »</a>" :"";
	echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."' class='extend' title='跳转到最后一页'>末页</a>":"";
	echo "</div>\n";
	}
}
//分页2
if ( !function_exists('pagenavi') ) {
	function pagenavi( $p = 5 ) { // 取当前页前后各 2 页，根据需要改
		if ( is_singular() ) return; // 文章与插页不用
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; // 只有一页不用
		if ( empty( $paged ) ) $paged = 1;
		if ( $paged > $p + 1 ) p_link( 1, '« 上一页' );
		if ( $paged > $p + 2 ) echo '... ';
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // 中间页
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='prev-next-page'>{$i}</span> " : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo '... ';
		if ( $paged < $max_page - $p ) p_link( $max_page, '最后页' );
	}
	function p_link( $i, $title = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		echo "<a class='prev' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$i}</a> ";
	}next_posts_link("下一页 »");
}
//日志归档
	class hacklog_archives
{
	function GetPosts() 
	{
		global  $wpdb;
		if ( $posts = wp_cache_get( 'posts', 'ihacklog-clean-archives' ) )
			return $posts;
		$query="SELECT DISTINCT ID,post_date,post_date_gmt,comment_count,comment_status,post_password FROM $wpdb->posts WHERE post_type='post' AND post_status = 'publish' AND comment_status = 'open'";
		$rawposts =$wpdb->get_results( $query, OBJECT );
		foreach( $rawposts as $key => $post ) {
			$posts[ mysql2date( 'Y.m', $post->post_date ) ][] = $post;
			$rawposts[$key] = null; 
		}
		$rawposts = null;
		wp_cache_set( 'posts', $posts, 'ihacklog-clean-archives' );;
		return $posts;
	}
	function PostList( $atts = array() ) 
	{
		global $wp_locale;
		global $hacklog_clean_archives_config;
		$atts = shortcode_atts(array(
			'usejs'        => $hacklog_clean_archives_config['usejs'],
			'monthorder'   => $hacklog_clean_archives_config['monthorder'],
			'postorder'    => $hacklog_clean_archives_config['postorder'],
			'postcount'    => '1',
			'commentcount' => '1',
		), $atts);
		$atts=array_merge(array('usejs'=>1,'monthorder'   =>'new','postorder'    =>'new'),$atts);
		$posts = $this->GetPosts();
		( 'new' == $atts['monthorder'] ) ? krsort( $posts ) : ksort( $posts );
		foreach( $posts as $key => $month ) {
			$sorter = array();
			foreach ( $month as $post )
				$sorter[] = $post->post_date_gmt;
			$sortorder = ( 'new' == $atts['postorder'] ) ? SORT_DESC : SORT_ASC;
			array_multisort( $sorter, $sortorder, $month );
			$posts[$key] = $month;
			unset($month);
		}
		$html = '<div class="car-container';
		if ( 1 == $atts['usejs'] ) $html .= ' car-collapse';
		$html .= '">'. "\n";
		if ( 1 == $atts['usejs'] ) $html .= '<a href="#" class="car-toggler">展开所有月份'."</a>\n\n";
		$html .= '<ul class="car-list">' . "\n";
		$firstmonth = TRUE;
		foreach( $posts as $yearmonth => $posts ) {
			list( $year, $month ) = explode( '.', $yearmonth );
			$firstpost = TRUE;
			foreach( $posts as $post ) {
				if ( TRUE == $firstpost ) {
                    $spchar = $firstmonth ? '<span class="car-toggle-icon car-minus">-</span>' : '<span class="car-toggle-icon car-plus">+</span>';
					$html .= '	<li><span class="car-yearmonth" style="cursor:pointer;">'.$spchar.' ' . sprintf( __('%1$s %2$d'), $wp_locale->get_month($month), $year );
					if ( '0' != $atts['postcount'] ) 
					{
						$html .= ' <span title="文章数量">(共' . count($posts) . '篇文章)</span>';
					}
                    if ($firstmonth == FALSE) {
					$html .= "</span>\n		<ul class='car-monthlisting' style='display:none;'>\n";
                    } else {
                    $html .= "</span>\n		<ul class='car-monthlisting'>\n";
                    }
					$firstpost = FALSE;
                     $firstmonth = FALSE;
				}
				$html .= '			<li>' .  mysql2date( 'd', $post->post_date ) . '日: <a target="_blank" href="' . get_permalink( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a>';
				if ( '0' != $atts['commentcount'] && ( 0 != $post->comment_count || 'closed' != $post->comment_status ) && empty($post->post_password) )
					$html .= ' <span title="评论数量">(' . $post->comment_count . '条评论)</span>';
				$html .= "</li>\n";
			}
			$html .= "		</ul>\n	</li>\n";
		}
		$html .= "</ul>\n</div>\n";
		return $html;
	}
	function PostCount() 
	{
		$num_posts = wp_count_posts( 'post' );
		return number_format_i18n( $num_posts->publish );
	}
}
if(!empty($post->post_content))
{
	$all_config=explode(';',$post->post_content);
	foreach($all_config as $item)
	{
		$temp=explode('=',$item);
		$hacklog_clean_archives_config[trim($temp[0])]=htmlspecialchars(strip_tags(trim($temp[1])));
	}
}
else
{
	$hacklog_clean_archives_config=array('usejs'=>1,'monthorder'   =>'new','postorder'    =>'new');	
}
$hacklog_archives=new hacklog_archives();
add_filter('previous_posts_link_attributes', 'prev_link_attributes');
function prev_link_attributes(){
return 'class="prev"';
}
add_filter('next_posts_link_attributes', 'next_link_attributes');
function next_link_attributes(){
return 'class="next"';
}
//密码保护提示
function password_hint( $c ){
global $post, $user_ID, $user_identity;
if ( empty($post->post_password) )
return $c;
if ( isset($_COOKIE['wp-postpass_'.COOKIEHASH]) && stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH]) == $post->post_password )
return $c;
if($hint = get_post_meta($post->ID, 'password_hint', true)){
$url = get_option('siteurl').'/wp-pass.php';
if($hint)
$hint = '密码提示：'.$hint;
else
$hint = "请输入您的密码";
if($user_ID)
$hint .= sprintf('欢迎进入，您的密码是：', $user_identity, $post->post_password);
$out = <<<END
<form method="post" action="$url">
<p>这篇文章是受保护的文章，请输入密码继续阅读：</p>
<div>
<label>$hint<br/>
<input type="password" name="post_password"/></label>
<input type="submit" value="输入密码" name="Submit"/>
</div>
</form>
END;
return $out;
}else{
return $c;
}
}
add_filter('the_content', 'password_hint');
 function catch_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];
  if(empty($first_img)){
		$random = mt_rand(1, 20);
		echo get_bloginfo ( 'stylesheet_directory' );
		echo '/images/random/tb'.$random.'.jpg';
  }
  return $first_img;
 }
function time_ago( $type = 'commennt', $day = 3 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (time() - $d('U') > 60*60*24*$day){ return get_comment_date();
  }else{return human_time_diff($d('U'), strtotime(current_time('mysql', 0))). '前';
}
}
    if( dopt('swt_type') == 'Display'){
        add_filter('get_avatar','dtheme_avatar');  
    }
//自定义头像
add_filter( 'avatar_defaults', 'fb_addgravatar' );
function fb_addgravatar( $avatar_defaults ) {
$myavatar = get_bloginfo('template_directory') . '/images/gravatar.png';
  $avatar_defaults[$myavatar] = '自定义头像';
  return $avatar_defaults;
}
function dtheme_avatar_url($mail){ 
  $p = get_bloginfo('template_directory').'/images/gravatar.png';
  if($mail=='') return $p;
  preg_match("/src='(.*?)'/i", get_avatar( $mail,'48'), $matches);
  return $matches[1];
}
//评论头像缓存
function dtheme_avatar($avatar) {
  $tmp = strpos($avatar, 'http');
  $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
  $tmp = strpos($g, 'avatar/') + 7;
  $s = substr($avatar, strpos($avatar, "s=", $tmp) + 2, 2);
  $f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp).'_'.$s;
  $w = get_bloginfo('wpurl');
  $e = ABSPATH .'avatar/'. $f .'.png';
  $t = 14*24*60*60; 
  if ( !is_file($e) || (time() - filemtime($e)) > $t ) 
    copy(htmlspecialchars_decode($g), $e);
  else  
    $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.png'));
  if ( filesize($e) < 500 ) 
    copy(get_bloginfo('template_directory').'/images/gravatar.png', $e);
  return $avatar;
}
if ( ! function_exists( 'zipe_comment' ) ) :
function zipe_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>" itemprop="review" itemscope itemtype="http://schema.org/Review">
			<div class="comments_meta">
				<div class="avatar_box">
				<div class="avatar_img" style="background-image:url('<?php echo dtheme_avatar_url($comment->comment_author_email); ?>')">
                </div></div></div>
					<div class="comment_text">
                    <span class="comment_author_name">
                    <span itemprop="author"><?php comment_author(); ?></span> 说：</span>
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation" title="<?php comment_time('Y-n-j H:i') ?>">您的评论正在排队审核中</em>
					<?php else : ?>
						<meta itemprop="datePublished" content="<?php comment_time('Y-n-j H:i') ?>" />
					<?php endif; ?>
				<?php if ( $comment->comment_approved != '0' && !$parent_id = $comment->comment_parent) : ?>
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'li-comment','depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?><!-- .reply -->
			<?php endif; ?></span>
				<span itemprop="reviewBody"><p><?php comment_text(); ?></p>
				</span></div></li>
	<?php
}
endif;
// 评论回复/头像缓存

//登陆显示头像
function metro_get_avatar($email, $size = 48){
return get_avatar($email, $size);
}


//自动生成版权时间
function comicpress_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
    SELECT
    YEAR(min(post_date_gmt)) AS firstdate,
    YEAR(max(post_date_gmt)) AS lastdate
    FROM
    $wpdb->posts
    WHERE
    post_status = 'publish'
    ");
    $output = '';
    if($copyright_dates) {
    $copyright = "&copy; " . $copyright_dates[0]->firstdate;
    if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
    $copyright .= '-' . $copyright_dates[0]->lastdate;
    }
    $output = $copyright;
    }
    return $output;
    }

//设置个人资料相关选项
function my_profile( $contactmethods ) {
	$contactmethods['weibo_sina'] = '新浪微博';   //增加
	$contactmethods['weibo_tx'] = '腾讯微博';
      $contactmethods['renren'] = '人人';
       $contactmethods['qq'] = 'QQ空间';
	unset($contactmethods['aim']);   //删除
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	return $contactmethods;
}
add_filter('user_contactmethods','my_profile');
//垃圾评论拦截
class anti_spam {
  function anti_spam() {
    if ( !current_user_can('level_0') ) {
      add_action('template_redirect', array($this, 'w_tb'), 1);
      add_action('init', array($this, 'gate'), 1);
      add_action('preprocess_comment', array($this, 'sink'), 1);
    }
  }
  function w_tb() {
    if ( is_singular() ) {
      ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
      "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
    }
  }
  function gate() {
    if ( !empty($_POST['w']) && empty($_POST['comment']) ) {
      $_POST['comment'] = $_POST['w'];
    } else {
      $request = $_SERVER['REQUEST_URI'];
      $spamcom = isset($_POST['comment'])        ? $_POST['comment']                : null;
      $_POST['spam_confirmed'] = "$spamcom";
    }
  }

  function sink( $comment ) {
  $email = $comment['comment_author_email'];
  $g = 'http://www.gravatar.com/avatar/'. md5( strtolower( $email ) ). '?d=404';
  $headers = @get_headers( $g );
    if ( !preg_match("|200|", $headers[0]) ) {
      add_filter('pre_comment_approved', create_function('', 'return "0";'));
    }
    if ( !empty($_POST['spam_confirmed']) ) {
      if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment; 
      die();
      add_filter('pre_comment_approved', create_function('', 'return "spam";'));
      $comment['comment_content'] = $_POST['spam_confirmed'];
    }
    return $comment;
  }
}
$anti_spam = new anti_spam();
//评论邮件通知
function comment_mail_notify($comment_id) {
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改為你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email) && ($comment_author_email == $admin_email)) {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
    $subject = '您在 [' . get_option("blogname") . '] 的评论有新的回复';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在 [' . get_option("blogname") . '] 的文章 《' . get_the_title($comment->comment_post_ID) . '》 上发表评论:<br />'
       . nl2br(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给您的回复如下:<br />'
       . nl2br($comment->comment_content) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复的完整內容</a></p>
      <p>欢迎再次光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此郵件由系統自動發出, 請勿回覆.)</p>
    </div>';
	$message = convert_smilies($message);
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
//全部设置结束
?>