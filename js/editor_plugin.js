// Ref. http://brettterpstra.com/adding-a-tinymce-button/
// Ref.	Shortcode Ninja plugin by VisualShortcodes.com

(function() {
	var icon_url;
	
    tinymce.create('tinymce.plugins.ipcbox_shortcodes', {
		
        /**
	   	* Initializes the plugin, this will be executed after the plugin has been created.
	   	* This call is done before the editor instance has finished it's initialization so use the onInit event
	   	* of the editor instance to intercept that event.
	   	*
	   	* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
	   	* @param {string} url Absolute URL to where the plugin is located.
	   	*/
		init : function(ed, url) {
			icon_url = url+'/download.png';
		    this.editor = ed;
			ed.addCommand( "ipcboxOpenDialog",function(a,c){
				dummyText = ' 在此输入内容 ';
				selectedText = ' 在此输入内容 '; // Grab the selected text from the content editor.
				if ( ed.selection.getContent().length > 0 ) { selectedText = ed.selection.getContent(); }
				pw_current_scType = c.identifier;
				pw_current_scTitle = c.title;
				
				jQuery.get(url+"/dialog.php", {pw_current_scType: pw_current_scType, pw_current_scTitle: pw_current_scTitle, selectedText: selectedText}, function(b){ //successhtml
					
					jQuery('.scgen_con_wrap').addClass( 'pw_shortcode-' + pw_current_scType );
					
					// Skip thickbox for certain shortcodes.
					switch ( pw_current_scType ) {
						
						case '0':		var a = '[dl href="'+dummyText+'"]'+selectedText+'[/dl]  ';
											tinyMCE.activeEditor.execCommand("mceInsertContent", false, a);
											break;
						default:
							jQuery("#pwork_scthickbox").remove();
							jQuery("body").append(b);
							jQuery("#pwork_scthickbox").hide();
							var f = jQuery(window).width();
							b = jQuery(window).height();
							f=720<f?720:f;
							f -= 80;
							b -= 115;
							tb_show("插入 "+ pw_current_scTitle +" 短代码", "#TB_inline?width="+f+"&height="+b+"&inlineId=pwork_scthickbox");
							var copybg = jQuery('#pw_scgen_wrap').css('background-image');
							jQuery('#pw_scgen_wrap').closest('#TB_ajaxContent').css('background-image', copybg);
						break;
					
					} // End SWITCH Statement
				
				}); // end $.get
						
			}); // end addCommand

        }, // end init
		
		createControl : function(n, cm) {
            if(n=="ipcbox_shortcodes"){
				n = cm.createMenuButton("ipcbox_shortcodes",{
					title : "插入短代码",
					image : icon_url,
					icons : false
					});
				var a = this;
				n.onRenderMenu.add(function(c,b){
					c=b.addMenu({title:"Wordpress"});
					a.addWithDialog(c,"下载样式","dl");
				});
				return n;
			}
			return null
        },
		addImmediate: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("mceInsertContent", false, a)
                }
            })
        },
        addWithDialog: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("ipcboxOpenDialog", false, {
                        title: e,
                        identifier: a
                    })
                }
            })
        },
		
		
		/**
	   	* Returns information about the plugin as a name/value array.
	   	* The current keys are longname, author, authorurl, infourl and version.
	   	*
	   	* @return {Object} Name/value array containing information about the plugin.
	   	*/
		getInfo: function () {
            return {
                longname: "IPCbox Shortcodes Generator",
                author: "VisualShortcodes.com (modified by Janze Siaro)",
                authorurl: "http://www.ipcbox.org",
                infourl: "http://visualshortcodes.com/shortcode-ninja",
                version: "1.0"
            }
        }
		
    }); // end tinymce.create
	
    tinymce.PluginManager.add('ipcbox_shortcodes', tinymce.plugins.ipcbox_shortcodes);
	
})();