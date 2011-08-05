// $Id: fivestarextra-admin.js,v 1.1 2008/10/27 12:34:28 likeless Exp $

/**
 * Fivestarextra admin interface enhancments.
 */
if (Drupal.jsEnabled) {
  $(document).ready(function() {
    
    function fivestarextra_noderestrict_nodetypes() {
      if ($('#edit-fivestar-noderestrict-enable').attr('checked')) {
        $('div.fivestarextra_noderestrict_nodetypes input').
          attr('disabled', false);
      }
      else {
        $('div.fivestarextra_noderestrict_nodetypes input').
          attr('disabled', 'disabled');
      }
    }
    
    $('#edit-fivestar-noderestrict-enable')
      .change( fivestarextra_noderestrict_nodetypes );
    
    fivestarextra_noderestrict_nodetypes();
    
  });
};
