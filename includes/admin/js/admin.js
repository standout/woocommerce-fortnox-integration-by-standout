jQuery(function($) {
  $("#connect_to_fortnox").on("click", function(e) {
    e.preventDefault();
    $.post(ajaxurl, { action: "connect_to_fortnox", nonce: fortnox.nonce }, function() {
      window.location.reload();
    });
  });
  $("#disconnect_from_fortnox").on("click", function(e) {
    e.preventDefault();
    $.post(ajaxurl, { action: "disconnect_from_fortnox", nonce: fortnox.nonce }, function() {
      window.location.reload();
    });
  });
});
