var progressindicator = '<img src="/mobibl/img/progress.gif" id="progress" alt="Progress-indicator" />';

function getSearchResults() {

  // alert('før');
  $('#searchformsubmit').append(progressindicator);
  var q = $('#q').val();
  var library = $.getUrlVar('lib');
  // Use dummy: 'true' as argument to glitre/api/ to get back dummy data
  $.get('/mobibl/glitre/api/', { q: q, library: library, format: 'plugin.mobibl' }, function (html) { $('#searchresults').empty(); $('#searchresults').append(html); $('#progress').remove(); });
  // Remove the progress indicator once the search results are loaded
  $.get('/mobibl/glitre/api/', { q: q, library: library, format: 'plugin.mobiblfull' }, function (html) { $('body').append(html); });
  return false;

}

function saveSettings() {
  localStorage.theme = $('#theme').val();
  jQT.goBack();
  return false;
}

function loadSettings() {
  $('#theme').val(localStorage.theme);
}

$.jQTouch({
	icon: 'jqtouch.png',
	statusBar: 'black-translucent',
	preloadImages: [
		'/mobibl/img/progress.gif'
		 ]
});

$(document).ready(function(){

	// Perform search
	$('#search form').submit(getSearchResults);

        // Saving settings triggers the saveSettings function
	$('#settings form').submit(saveSettings);
        $('#settings').bind('pageAnimationStart', loadSettings);

        // Feeds
	$('.feed').bind('pageAnimationEnd', function(e, info){
	    if (!$(this).data('loaded')) {  // Make sure the data hasn't already been loaded (we'll set 'loaded' to true a couple lines further down)
                var elem = $(this).attr('id');
                $('#feedprogresscontainer').append(progressindicator);
                $.get('feeds/index.php', { feed: elem }, function (html) { $('#' + elem).append(html); $('#progress').remove(); });
		$.get('feeds/index.php', { feed: elem, part: 'main' }, function (html) { $('body').append(html); });
		$(this).data('loaded', true);
	    }
	});

 	// Bokhylla
	$('#bokhylla').bind('pageAnimationEnd', function(e, info){
		// Make sure this only happens the first time we show this page
		if (!$(this).data('bokhyllainit')) {
		   if (!$(this).data('pagecounter')) {  
				$(this).data('pagecounter', 0);
		    }
	        $('#bokhyllaprogresscontainer').append(progressindicator);
	        $.get('bokhylla/index.php', { page: $(this).data('pagecounter') }, function (html) { $('#bokhyllaul').append(html); $('#progress').remove(); });
	        $(this).data('pagecounter', $(this).data('pagecounter') + 1);
	        $(this).data('bokhyllainit', true);
		}
	});
	$('#bokhyllamore').click(function() {
  		$('#bokhyllaprogresscontainer').append(progressindicator);
	    $.get('bokhylla/index.php', { page: $('#bokhylla').data('pagecounter') }, function (html) { $('#bokhyllaul').append(html); $('#progress').remove(); });
	    $('#bokhylla').data('pagecounter', $('#bokhylla').data('pagecounter') + 1);
	});
	$('#bokhyllarand').click(function() {
  		$('#bokhyllaprogresscontainer').append(progressindicator);
	    $.get('bokhylla/index.php', { rand: 'true' }, function (html) { $('#bokhyllaul').append(html); $('#progress').remove(); });
	});
	
/*
        // Debug
	$('#debug').bind('pageAnimationEnd', function(e, info){
	    if (!$(this).data('loaded')) {  // Make sure the data hasn't already been loaded (we'll set 'loaded' to true a couple lines further down)
                        $(this).append($('<div id="progress">Henter...</div>').         // Append a placeholder in case the remote HTML takes its sweet time making it back
                         load('debug.php', function() {        // Overwrite the "Loading" placeholder text with the $.get('feeds/index.php', { feed: 'hig_news', part: 'main' }, function(html) { $('body').append(html) })remote HTML
                         $(this).parent().data('loaded', true);  // Set the 'loaded' var to true so we know not to re-load the HTML next time the #callback div animation ends
                }));
                $('#progress').remove();
	    }
	});
*/	
});

// Thanks to: http://jquery-howto.blogspot.com/2009/09/get-url-parameters-values-with-jquery.html
$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      // The following two lines remove anything after a #
      var subhash = hash[1].split('#');
      hash[1] = subhash[0];
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});