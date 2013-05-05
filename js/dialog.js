var tb_dialog_helper = {
    
    setUpButtons: function () {
        var a = this;
        jQuery("#pw_scgen_cancel").click(function () {
            a.closeDialog()
        });
        jQuery("#pw_scgen_insert").click(function () {
            a.insertAction()
        });
		jQuery(".scodepreview_button").click(function () {
            a.previewCode()
        });
    },

    makeShortcode: function () {
		var target = jQuery('#pw_current_scType').val();
		var shortcode = '';
		
		//init tag
		shortcode+= '['+target;
		//add attributes
		if(jQuery('.sc_prop').length > 0) {
			jQuery('.sc_prop').each(function() {
				if (!jQuery(this).hasClass('maincontent')) {
					if (jQuery(this).val()) {
						shortcode+= ' '+jQuery(this).attr('name')+'="'+jQuery(this).val()+'"';
					}
				}
			});
		}
		shortcode+= ']';
		//end tag
		if(jQuery('.maincontent').length > 0) {
			shortcode+= jQuery('.maincontent').val()+'[/'+target+'] ';
		}

		return shortcode;
		
    },

    insertAction: function () {
        var a = this.makeShortcode();
        tinyMCE.activeEditor.execCommand("mceInsertContent", false, a);
        this.closeDialog();
    },

    closeDialog: function () {
        tb_remove();
        jQuery("#pwork_scthickbox").remove();
    },
	
	previewCode: function () {
        var a = this.makeShortcode();
        jQuery(".scodepreview").val(a);
    },

};

tb_dialog_helper.setUpButtons();