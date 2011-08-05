// $id$
$(document).ready(function(){

  var lastrev;
  var update_dir = Drupal.settings.live_update.update_dir;
  var stateloc = update_dir+'/state.txt';
  var $timestamp = new Date().getTime() 

  // Find the latest revision so we don't update old content
  $.getJSON( stateloc, { time: $timestamp }, 
    function (states) { 
      for (rev in states) { 
        lastrev = rev;
      }
    }
  );

  var refreshId = setInterval(function() { 

    // Poll the state file
    $timestamp = new Date().getTime() 
    $.getJSON(stateloc, { time: $timestamp },  function(states) { 

      // Loop through states to see if there are new revisions
      for (rev in states) { 

        state = states[rev];

        if (parseInt(rev) > parseInt(lastrev)) { 

          contentloc = update_dir+'/'+rev+'.html';
          target = state.settings.target || Drupal.settings.live_update.target;
          method = state.settings.method || Drupal.settings.live_update.method;
          liveUpdateContent(contentloc, target, method);

          // update our state
          lastrev = rev
        }

      }
    });
  }, 5000);
});

/** 
 * Get new content and insert it into the DOM as prescribed by target, method
 **/
function liveUpdateContent(contentloc, target, method) { 
  var $timestamp = new Date().getTime() 
  $.get(contentloc, { time: $timestamp }, function (data) { 
    $(target).fadeOut(function() { 
      $(this)[method](data).fadeIn();
    });
  });
}
