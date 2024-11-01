

if(typeof(tinymce) !== 'undefined')
{
    console.log('tinymce');
    if (typeof(wp.data) == 'undefined')
    {
        tinymce.PluginManager.add('custom_mce_button', function(editor, url) {
            
            editor.addButton('custom_mce_button', {
                title: "Analyze it with Watsonfinds",
                icon: 'watsonfinds-mce-icon',
                onclick: function() {
                    var content = editor.getContent({format : 'text'});
                    var html_content = editor.getContent();
                    content = jQuery('<span>' + content + '</span>').text();
                    process_content(content, html_content, editor);
                    // wf_editor.analyzeText();
                }
            });
        });


        // var wf_editor = {
        //     setContent : function(content){
        //         tinymce.editors[0].setContent(content);
        //     },

        //     analyzeText : function(){
        //         var html_content = tinymce.editors[0].getContent({format : 'text'})
        //         content = jQuery('<span>' + html_content + '</span>').text();
        //         process_content(content, html_content);
        //     }
        // }
    }

}
else if (typeof wp.blocks !== 'undefined') 
{
    console.log('gutenberg');
    var wf_editor = {
        setContent : function(content){
            wp.data.dispatch( 'core/editor' ).resetBlocks([]);
            var blocks = wp.blocks.parse(content);
            wp.data.dispatch( 'core/editor' ).insertBlocks( blocks );
        },

        analyzeText : function(){
            var html_content = wp.data.select( "core/editor" ).getEditedPostContent();
            content = jQuery('<span>' + html_content + '</span>').text();
            process_content(content, html_content, wf_editor);
        }
    }

}


if (jQuery('#watsonfinds-textarea').length > 0 )
{
    var wf_editor = {
        setContent : function(content){
            jQuery('#watsonfinds-textarea').val(content.replace(/<br *\/?>/gi, '\n'));
        },

        analyzeText : function(){
            var element = jQuery('#watsonfinds-textarea');
            if (element.length == 0 )
            {
                element = jQuery('#content');
            } 
            if (element.length > 0)
            {
                var content = element.val();
                var html_content = content.replace(/\n/gi, '<br\/>');
                content = jQuery('<span>' + content + '</span>').text();
                process_content(content, html_content, wf_editor);
            }
            
        }
    }
}











