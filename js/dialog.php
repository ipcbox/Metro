<?php 
/* ---------------------------------------------------
/* Displays Shortcode Generator in Thickbox (Edit Screen)
/* ---------------------------------------------------
/*/

// Setup URL to WordPres
$absolute_path = __FILE__;
$path_to_wp = explode( 'wp-content', $absolute_path );
$wp_url = $path_to_wp[0];

// Access WordPress
require_once( $wp_url.'/wp-load.php' );

// Display Helpers
include_once (TEMPLATEPATH.'/js/var_options_scgen.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div id="pwork_scthickbox">
<div id="pw_scgen_wrap">

	<?php // $_GET data
	$pw_current_scType = $_REQUEST['pw_current_scType'];
	$pw_current_scTitle = $_REQUEST['pw_current_scTitle'];
	$selectedText = $_REQUEST['selectedText']; ?>
    <div>
    	<h2 class="h2sc"><?php echo $pw_current_scTitle; _e( ' 选项'); ?></h2>
        <div class="scgen_buttons">
        	<input type="button" id="pw_scgen_insert" class="button-primary" name="insert" value="插入" accesskey="I" />
            <br />
            <input type="button" id="pw_scgen_cancel" class="button" name="cancel" value="取消" accesskey="C" />
        </div>   
        <div class="panel_divide"></div>
    </div>    
    
    <div class="scgen_con_wrap">

        <?php if( $shortcode = $options_scgen[$pw_current_scType] ) { ?>
            <div id="div_<?php echo $pw_current_scTitle; ?>" class="scgen_content">
            	<form>
                <input type="hidden" id="pw_current_scType" value="<?php echo $pw_current_scType; ?>"/>                
                <?php foreach($shortcode as $scprop => $value) { ?>
                    <div class="<?php echo $pw_current_scType; ?>_sc_prop_wrapper sc_prop_wrapper">
                        <div class="scprop_title fl"><?php echo ucfirst($scprop);?><br /><span class="scprop_desc"><?php if ( !empty($value['reqd']) ) echo $value['reqd']; ?></span></div>
                        <div class="scprop_input fl"><?php
						if ( !empty($value['is']) && ($value['is']=='maincontent') ) {
							$id = 'maincontent';
							$val = $selectedText;
						}else{
							$id="";
							$val="";
						}
                        // Main content defined by 'shortcodename_content_repeat' and 'shortcodename_content' in javascript...
                        // class="sc_prop" used in javascript to define attributes of shortcode
                        switch($value['type']) {
							case 'textarea': ?>
                            <textarea class="sc_prop <?php echo $id;?>" name="<?php echo $value['id'];?>" style="width:90%;height:70px" rows="3" wrap="off"><?php echo $val;?></textarea>
                            <?php break;
                            case 'text': ?>
                            <input type="text" class="sc_prop <?php echo $id;?>" name="<?php echo $value['id'];?>" size="30" value="<?php echo $val;?>"/>
                            <?php break;
                            case 'select': ?>
                            <select class="sc_prop <?php echo $id;?>" name="<?php echo $value['id']; ?>">
                                <?php if(!empty($value['options'])) {
                                    foreach($value['options'] as $select_key => $option) { ?>
                                        <option value="<?php echo $select_key; ?>"><?php echo $option; ?></option>
                                    <?php }
                                }?>							
                            </select>
                            <?php break; ?>
							<?php 
                        } //end switch 
						if (!empty($value['desc'])) echo '<div class="scprop_desc">'.$value['desc'].'</div>';?>
                        </div>
                        <div class="clearfix"></div>
                    </div> <!-- end sc_prop_wrapper -->
                <?php } //end foreach ?>
                <div class="scodepreview_sc_prop_wrapper sc_prop_wrapper">
                    <div class="scprop_title fl"><div class="scodepreview_button">预览代码</div></div>
                    <div class="scprop_input fl">
                        <textarea class="scodepreview" name="scodepreview" style="width:90%;" rows="4"></textarea>
                        <div class="scprop_desc"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                </form>
            </div> <!-- end scgen_content -->
        <?php } //end if ?>
	
	</div><!-- end scgen_con_wrap -->
</div><!-- pw_scgen_wrap -->
</div><!-- pwork_scthickbox -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dialog.js"></script>
</body>
</html>