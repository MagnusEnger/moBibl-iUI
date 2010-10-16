var progressindicator = '<img src="/img/progress.gif" id="progress" alt="Progress-indicator" />';
var curlib;

function getSearchResults() {

  // Clear the floor for new results
  $('#searchcontent').empty();
  // Display progressindicator
  $('#searchformsubmit').append(progressindicator);
  // Get the query and the code for the library
  var q = $('#q').val();
  var library = $.getUrlVar('lib');
  // Initialize counter
  $('#search').data('searchcounter', 0);
  $('#searchresults').empty();
  // Use dummy: 'true' as argument to glitre/api/ to get back dummy data
  $.get('/glitre/api/', { q: q, library: library, page: $('#search').data('searchcounter'), format: 'mobibl' }, function (html) { 
  	$('#searchcontent').append(html); 
  	// Display "more" button
  	$('#searchmore').show();
  	var hitssofar = $('#searchresults li').length;
  	// Display the number of hist shown so far
  	$('#searchcountto').empty();
  	$('#searchcountto').append(hitssofar);
  	// Remove progress indicator
  	$('#progress').remove(); 
  });
  // Clone the searchcounter
  $('#searchcounter').clone(false).removeAttr("id").addClass('clonedsearchcounter').insertBefore($("#searchmore"));
  // Remove the progress indicator once the search results are loaded
  $.get('/glitre/api/', { q: q, library: library, page: $('#search').data('searchcounter'), format: 'mobiblfull' }, function (html) { 
  	$('body').append(html); 
  });
  // Increment the counter
  $('#search').data('searchcounter', $('#search').data('searchcounter') + 1);
  return false;

}

var jQT = new $.jQTouch({
	icon: 'jqtouch.png',
	statusBar: 'black-translucent',
	preloadImages: [
		'/img/progress.gif'
		 ]
});

$(document).ready(function(){

	// Change library
	$('.library').bind('pageAnimationEnd', function(e, info){
		curlib = $(this).attr('href').substring(1);
		if (!$(this).data('loaded')) {
			// TODO: Check if this library hs already been added
			$.get('index.php', { lib: curlib }, function (html) { 
				$('#' + curlib).append(html);
				$(this).data('loaded', true);
			});
		}
	});

	// Perform search
	$('#search form').submit(getSearchResults);
	$('#searchmore').click(function() {
	  var q = $('#q').val();
	  var library = $.getUrlVar('lib');
	  // Use dummy: 'true' as argument to glitre/api/ to get back dummy data
	  $.get('/glitre/api/', { q: q, library: library, page: $('#search').data('searchcounter'), format: 'mobibl' }, function (html) { 
	  	$('#searchresults').append(html); 
	  	var hitssofar = $('#searchresults li').length;
	  	// Display the number of hist shown so far
	  	$('#searchcountto').empty();
	  	$('#searchcountto').append(hitssofar);
	        // Remove the old searchcounter (if there is one)
	        $('.clonedsearchcounter').remove();
	        // Clone the searchcounter
	        $('#searchcounter').clone(false).removeAttr("id").addClass('clonedsearchcounter').insertBefore($("#searchmore"));
	  	// Check if we reached the max number of hits
	  	if (hitssofar == 10) {
	  	  // Remove the "more" button
	  	  $('#searchmore').hide();
	  	}
	  	$('#progress').remove(); 
	  });
	  // Remove the progress indicator once the search results are loaded
	  $.get('/glitre/api/', { q: q, library: library, page: $('#search').data('searchcounter'), format: 'mobiblfull' }, function (html) { 
	  	$('body').append(html); 
	  });
	  // Increment the counter
	  $('#search').data('searchcounter', $('#search').data('searchcounter') + 1);
	  return false;
	});

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
	        $.get('/bokhylla/index.php', { page: $(this).data('pagecounter') }, function (html) { $('#bokhyllaul').append(html); $('#progress').remove(); });
	        $(this).data('pagecounter', $(this).data('pagecounter') + 1);
	        $(this).data('bokhyllainit', true);
		}
	});
	$('#bokhyllamore').click(function() {
  		$('#bokhyllaprogresscontainer').append(progressindicator);
	    $.get('/bokhylla/index.php', { page: $('#bokhylla').data('pagecounter') }, function (html) { $('#bokhyllaul').append(html); $('#progress').remove(); });
	    $('#bokhylla').data('pagecounter', $('#bokhylla').data('pagecounter') + 1);
	});
	$('#bokhyllarand').click(function() {
  		$('#bokhyllaprogresscontainer').append(progressindicator);
	    $.get('/bokhylla/index.php', { rand: 'true' }, function (html) { $('#bokhyllaul').append(html); $('#progress').remove(); });
	});
	

        // Debug
	$('#debug').bind('pageAnimationEnd', function(e, info){
	    if (!$(this).data('loaded')) {  // Make sure the data hasn't already been loaded (we'll set 'loaded' to true a couple lines further down)
                        $(this).load('debug.php', function() {        // Overwrite the "Loading" placeholder text with the $.get('feeds/index.php', { feed: 'hig_news', part: 'main' }, function(html) { $('body').append(html) })remote HTML
                         $(this).parent().data('loaded', true);  // Set the 'loaded' var to true so we know not to re-load the HTML next time the #callback div animation ends
                });
	    }
	});
	
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
