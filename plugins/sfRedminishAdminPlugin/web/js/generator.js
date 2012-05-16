$(function(){
	// Textarea autoresize handler
	$('div.sf_admin_form_row.sf_admin_text div.content > textarea').autoResize({
	    // On resize:
	    onResize : function() {
	        $(this).css({opacity:0.8});
	    },
	    // After resize:
	    animateCallback : function() {
	        $(this).css({opacity:1});
	    },
	    // Quite slow animation:
	    animateDuration : 300
	});
	
	// Handling list selection
	$('div.sf_admin_list tr.sf_admin_row').click(function() {
		toggleSelection($(this));
	});
	
	$('div.sf_admin_list th#sf_admin_list_batch_actions a#sf_admin_list_batch_toggle').click(function(){
		toggleAllSelections($(this).parents('div.sf_admin_list:first'));
		return false;
	});
	
	$('#filters table tr td table tbody tr :input').not(':first').each(function(){
		var autoRegex = /^autocomplete_(.*)$/
		if (match = autoRegex.exec($(this).attr('id'))) {
			var $inputs = $('div#' + match[1] + '_list :input');
			if ( ! $inputs.length) {
				$(this).parents('tr:first').hide();
			}
		} else if ( ! $(this).val()) {
			$(this).parents('tr:first').hide();
		}
	});
	
	$('td.add-filter select').change(function(){
		var field = $(this).val();
		if (field != '') {
			$('#filters table tr td table tbody tr td *[id^="' + field + '"]').parents('tr').show();
		}
	});
	
	// Graphs Ajax Handler
	$('div[id^="graph_"]').each(function(){
		var name = $(this).attr('rel');
		var id = this.id;
		var element = $(this);
		$.ajax({
			url:      '/backend_dev.php/notabackend/ajax/graph',
			data:     {'name': name },
			type:     'POST',
			dataType: 'json',
			success:  function(json) {
				element.empty();
				json.graphOptions.axes.xaxis.renderer = $.jqplot.DateAxisRenderer;
				$.jqplot(id, json.tabularData, json.graphOptions);
			}
		});
	});
	
	// Dashboard blocks handler
	$('#dashboard-container h3').wrap('<a href="#" />');
	
	$('#dashboard-container h3').parent().click(function(){
		$(this).siblings('.graph, ul').slideToggle();
		return false;
	});
	
	// Form blocks handler
	$('fieldset.generated_fieldset h3').wrap('<a href="#" />');
	$('fieldset.generated_fieldset div.fieldset_content').not('.opened').not(':first').hide();
	
	$('fieldset.generated_fieldset h3').parent().click(function(){
		$(this).siblings('.fieldset_content').toggle();
		return false;
	});
	
	// Tasks handler
	$('ul#menu-tasks li a').click(function(){
		isError = false;
		
		var initData = 'Executing ' + $(this).text() + ' Task';
        displayTaskDialog(initData, taskDialogOptions.initState, false);
		
		var classes = $(this).parent().attr('class');
		var element = $(this);
		$(this).find('span').attr('class', '').addClass('icon').addClass('icon-loading');
		var url = $(this).attr('href');
		$.ajax({
			url:      url,
			dataType: 'html',
			success: function(data)
			{
				element.parent().attr('class', classes);
				
				var options = {
					'title':     'Confirmation',
					'modal':     true,
					'resizable': false
				};
				
				if (data.match(/^Error: /)) {
					//data = data.replace(/^Error: /, '');
					options.title = 'Error';
					var isError = true;
				}
				
				displayTaskDialog(data, options, isError);
			}
		})
		return false;
	});
	
	// Quick Access Handler
	$('ul#quick-access li a').click(function(){
		$($(this).attr('href')).find('.fieldset_content').show();
		$.scrollTo($(this).attr('href'), 1000);
		return false;
	});
});

//Init global variables
taskDialogOptions = {
    initState : {
        'title':     'Execution',
        'modal':     true,
        'resizable': false,
        'width':     'auto',
        'minWidth':  300,
        'maxWidth':  700,
        close:       function(event, ui) {
            $('ul.sf_admin_td_actions li a.ui-state-active').removeClass('ui-state-active');
            $(this).remove();
        }
    },
    
    successState : {
        'title':     'Confirmation',
        'modal':     true,
        'resizable': false,
        'width':     'auto',
        'minWidth':  300,
        'maxWidth':  700
    },
    
    errorState : {
        'title':     'Error',
        'modal':     true,
        'resizable': true,
        'width':     'auto',
        'minWidth':  300,
        'maxWidth':  700
    },
};


function displayTaskDialog(data, options, isError)
{
    if ( ! $('#dialog').length) {
    	var $section = $('<div class="'
                +  ( ! isError ? 'notice ui-state-highlight ui-corner-all' : 'error ui-state-error ui-corner-all')
                + ' section"><span class="'
                + (isError ? 'ui-icon ui-icon-alert' : 'ui-icon ui-icon-info')
                + ' floatleft"></span><h3>' + (isError ? 'Error' : 'Processing') + '</h3>' + formatData(data, isError) + '</div>');
    	var dialog = $('<div id="dialog"></div>');
    	$section.appendTo(dialog);
    } else {
    	var $section = $('<div class="'
                +  ( ! isError ? 'ui-state-success ui-corner-all' : 'error ui-state-error ui-corner-all')
                + ' section"><span class="'
                + (isError ? 'ui-icon ui-icon-alert' : 'ui-icon-success')
                + ' floatleft"></span><h3>' + (isError ? 'Error' : 'Success') + '</h3>' + formatData(data, isError) + '</div>');
        var dialog = $('#dialog');
        dialog.empty().append($section);
        // Recentering the dialog
        options['position'] = dialog.data('dialog').options.position;;
    }
	
	dialog.dialog(options);
	
	$('p.see-trace a').bind('click', function(){
        $(this).html($(this).parent().next('div.trace').is(':hidden') ? 'Hide trace' : 'Show trace');
        $(this).parent().next('div.trace').slideToggle('fast');
        return false;
    });
    
    $('p.see-message a').bind('click', function(){
        $(this).html($(this).parent().next('div.message').is(':hidden') ? 'Hide message' : 'Show message');
        $(this).parent().next('div.message').slideToggle('fast');
        return false;
    });
    
    $('div.message, div.trace').css({width: $('#dialog .section:first').width() + 'px'});
}

function formatData(content, isError)
{
    if (isError) {
        var fileRegex = /\(File: .+/;
        if (match = fileRegex.exec(content)) {
            var file = match;
        }
        
        var traceRegex = /(#[0-9]+(.*\r*\n*)+)/;
        if (match = traceRegex.exec(content)) {
            var trace = match[1];
        }
        
        var mainErrorRegex = /^(Error: .*)(\r{0,1}\n(.*\r*\n*)+)/;
        if (match = mainErrorRegex.exec(content)) {
            var mainError = match[1];
            var errorMessage = match[2].replace(file, '').replace(trace, '');
        }
        
        content = '<strong>' + mainError + '</strong>'
                + ( ! errorMessage
                   ? ''
                   : ( ! errorMessage.match(/^\r{0,1}\n*$/)) ? '<p class="see-message"><a href="#">Show message</a></p><div class="message"><pre>' + errorMessage + '</pre></div>' : '')
                + (file ? '<p>' + file + '</p>' : '')
                + (trace ? '<p class="see-trace"><a href="#">Show trace</a></p><div class="trace"><pre>' + trace + '</pre></div>' : '');
    } else {
        if (content.match(/^(.*\r{0,1}\n)/)) {
            content = content.replace(/^(.*\r{0,1}\n)((.*\r*\n*)+)/, '<strong>$1</strong><p class="see-message"><a href="#">Show message</a></p><div class="message"><pre>$2</pre></div>');
        } else {
            content = content.replace(/^(.*)/, '<strong>$1</strong>');
        }
    }
    
    return content;
}

function toggleSelection(tr) {
	if (tr.hasClass('context-menu-selection')) {
		removeSelection(tr);
	} else {
	    addSelection(tr);	
	}
}

function addSelection(tr) {
	tr.addClass('context-menu-selection');
	tr.find('.sf_admin_batch_checkbox').attr('checked', true);
}

function removeSelection(tr) {
	tr.removeClass('context-menu-selection');
	tr.find('.sf_admin_batch_checkbox').removeAttr('checked');
}

function toggleAllSelections(el) {
	var boxes = el.find('.sf_admin_batch_checkbox');
	var all_checked = true;
	boxes.each(function(){
		if ($(this).is(':checked') == false) {
			all_checked = false;
		}
	});
	boxes.each(function(){
		if (all_checked) {
			removeSelection($(this).parents('tr:first'));
		} else if ($(this).is(':checked') == false) {
			addSelection($(this).parents('tr:first'));
		}
	});
}
