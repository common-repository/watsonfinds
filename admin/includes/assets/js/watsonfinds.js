
var process_content;
var wf_popup;
var wf_editor;

jQuery(document).ready(function($)
{
	process_content = function (content, html_content, editor)
	{
		if(content && content.length >= 50)
		{
			wf_editor = editor;
			var old_content;
			var hs = get_wf_ce_history();
			if(typeof(hs) !== 'undefined')
			{
				old_content = hs.slice(-1)[0].content;
			}
			if (old_content != content)
			{
				$(document.body).append('<div id="watsonfinds_overlay"><img src="' + watsonfinds_vars.wp_admin + '/images/spinner-2x.gif"/></div>');
				var data = {
					action:'watsonfinds',
					content: content,
					page: watsonfinds_vars.page,
					type: watsonfinds_vars.type
				}
				$.post(ajaxurl, data, function(result)
				{
					push_wf_history(content, html_content, result);
					$('#watsonfinds_overlay').remove();
					show_result(result);
					return false;

				});
				
			}
			else
			{
				show_result(hs.slice(-1)[0].result);
			}
			
		}
		else
		{
			watsonfinds_modal({
					type: 'error',
				    title: 'Watsonfinds', //Modal Title
				    text: 'Please add at least 50 words!', //Modal HTML Content
				    size: 'small', //Modal Size (normal | large | small)
				    zIndex: 100001, //z-index
				    center: true, //Center Modal Box?
				    theme: 'atlant', //Modal Custom Theme (xenon | atlant | reseted)
				    animate: true, //Slide animation
				    
				});
		}
		
		return false;
	}


	$('#watsonfinds-process-textarea').on('click', function(){
		
		// var content = $('#watsonfinds-textarea').val();
		// var html_content = content.replace(/\n/gi, '<br\/>');
		// content = $('<span>' + content + '</span>').text();
		// process_content(content, html_content, 'watsonfinds-textarea');
		// return false;
		wf_editor.analyzeText();
		return false;
	})

	$('#watsonfinds-process-gutenberg').on('click', function(){
		
		// var content = $('#watsonfinds-textarea').val();
		// var html_content = content.replace(/\n/gi, '<br\/>');
		// content = $('<span>' + content + '</span>').text();
		// process_content(content, html_content, 'watsonfinds-textarea');
		// return false;
		wf_editor.analyzeText();
		return false;
	})

	
});

function show_result(result)
{
	wf_popup = watsonfinds_modal({
	    title: 'Watsonfinds', //Modal Title
	    text: result, //Modal HTML Content
	    size: 'large', //Modal Size (normal | large | small)
	    zIndex: 100000, //z-index
	    center: true, //Center Modal Box?
	    theme: 'atlant', //Modal Custom Theme (xenon | atlant | reseted)
	    animate: true, //Slide animation
	    template: '<div class="modal-box"><div class="modal-inner"><div class="modal-title"><a class="modal-close-btn"></a></div><div class="modal-text"></div></div></div>'
	    
	
	});
}

function push_wf_history(content, html_content, result)
{
	var wf_history;
	wf_history = wf_editor.watsonfinds_history;
	if(typeof(wf_history) === 'undefined')
	{
		wf_history = [];
		wf_editor.watsonfinds_history = wf_history;
	}
	if (wf_history.length == 5)
	{
		wf_history.shift();
	}
	
	wf_history.push({
		'content' : content,
		'result'  : result,
		'html_content': html_content
	});
}

function get_wf_ce_history()
{

	var wf_history = wf_editor.watsonfinds_history;
	return wf_history;
}

function set_wf_ce_content(content)
{
	wf_editor.setContent(content);
	wf_popup.close();

}

