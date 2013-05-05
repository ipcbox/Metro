<?php 
function getUserId() {
		global $wpdb,$current_user;
		get_currentuserinfo();
		return array('id' => $current_user->ID, 'login' => $current_user->user_login);
		}
function get_user_ids($user=''){
              $user="'".$user."'";
              global $wpdb;
              $user_ids = $wpdb->get_row( $wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_login = %d ORDER BY ID", $user) );
              foreach($user_ids as $user_id){
                 return $user_id;
                }
        }
function ipcbox_setup_theme() {
// 取消原有jQuery
if ( !is_admin() ) { 
    if ( $localhost == 0 ) { 
        function my_init_method() {
            wp_deregister_script( 'jquery' );
        }    
        add_action('init', 'my_init_method'); 
    }
}
   //去除头部冗余代码
    remove_action( 'wp_head',   'feed_links_extra', 3 ); 
    remove_action( 'wp_head',   'rsd_link' ); 
    remove_action( 'wp_head',   'wlwmanifest_link' ); 
    remove_action( 'wp_head',   'index_rel_link' ); 
    remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
    remove_action( 'wp_head',   'wp_generator' ); 
    remove_action('the_excerpt', 'wpautop');
//支持外链缩略图
if ( function_exists('add_theme_support') )
     add_theme_support('post-thumbnails', array(
    'post',
    'page',
    'photo',
));
 add_post_type_support('page', 'excerpt'); 
 set_post_thumbnail_size(140, 100, true);
 /* Image resize for photos */
add_image_size('photo-medium', 450, 250, true);
add_image_size('medium', 650, 480, true);
add_action('init','dtheme_gzip');
add_action('wp_print_scripts','dtheme_disable_autosave' );
remove_action('pre_post_update','wp_save_post_revision' );
    add_filter('wp_mail_from', 'dtheme_res_from_email');
    add_filter('wp_mail_from_name', 'dtheme_res_from_name');
add_action('pre_ping','ipcbox_noself_ping');
}
add_action( 'after_setup_theme', 'ipcbox_setup_theme' );
if ( !function_exists('wp_new_user_notification') ) :
function wp_new_user_notification($user_id, $plaintext_pass = '', $flag='') {
	if(func_num_args() > 1 && $flag !== 1)
		return;

	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

	@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);
	
	if ( empty($plaintext_pass) )
		return;

	// 你可以在此修改发送给用户的注册通知Email
	$message  = sprintf(__('Username: %s'), $user_login) . "\r\n";
	$message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n";
	$message .= '登陆网址: ' . wp_login_url() . "\r\n";

	// sprintf(__('[%s] Your username and password'), $blogname) 为邮件标题
	wp_mail($user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);
}
endif;

/* 修改注册表单 */
function ipcbox_show_password_field() {
?>
<p>
	<label>密码(至少6位)<br/>
		<input id="user_pwd1" class="input" type="password" tabindex="21" size="25" value="<?php echo $_POST['user_pass']; ?>" name="user_pass"/>
	</label>
</p>
<p>
	<label>重复密码<br/>
		<input id="user_pwd2" class="input" type="password" tabindex="22" size="25" value="<?php echo $_POST['user_pass2']; ?>" name="user_pass2" />
	</label>
</p>
<?php
}

/* 处理表单提交的数据 */
function ipcbox_check_fields($login, $email, $errors) {
	global $wpdb;
	$last_reg = $wpdb->get_var("SELECT `user_registered` FROM `$wpdb->users` ORDER BY `user_registered` DESC LIMIT 1");

	if ( (time() - strtotime($last_reg)) < 60 )
		$errors->add('anti_spam', "<strong>错误</strong>：先歇会，稍后再注册，谢谢您的理解");
		
	if(strlen($_POST['user_pass']) < 6)
		$errors->add('password_length', "<strong>错误</strong>：密码长度至少6位");
	elseif($_POST['user_pass'] != $_POST['user_pass2'])
		$errors->add('password_error', "<strong>错误</strong>：两次输入的密码必须一致");
}

/* 保存表单提交的数据 */
function ipcbox_register_extra_fields($user_id, $password="", $meta=array()) {
	$userdata = array();
	$userdata['ID'] = $user_id;
	$userdata['user_pass'] = $_POST['user_pass'];

	wp_new_user_notification( $user_id, $_POST['user_pass'], 1 );
	wp_update_user($userdata);
}

function remove_default_password_nag() {
	global $user_ID;
	delete_user_setting('default_password_nag', $user_ID);
	update_user_option($user_ID, 'default_password_nag', false, true);
}

add_action('admin_init', 'remove_default_password_nag');
add_action('register_form','ipcbox_show_password_field');
add_action('register_post','ipcbox_check_fields',10,3);
add_action('user_register', 'ipcbox_register_extra_fields');
?>