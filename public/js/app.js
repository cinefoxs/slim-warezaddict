/**
 * Loading Overlay
 *
 * $.LoadingOverlay("show");
 * setTimeout(function() {
 *   $.LoadingOverlay("hide");
 * }, 1500);
 *
*/

// Doc Ready
$(document).ready(function() {

  // Console Message (Remove Me!)
  console.log('Everything Loaded And Ready!!!');

  // Toggle Active Class On Navbar (TODO: Fix this!)
  $('.nav-link').on('click', function(e) {
    $(this).toggleClass('active');
  });

  // Smooth Scroll Back To Top
  $('#scroll').on('click', function(e) {
    $("html, body").animate({
      scrollTop: 0,
    }, 300, 'linear');
    e.preventDefault();
    e.stopPropagation();
    return false;
  });

  // Disable a href="#" Links
  $('a[href="#"]').on('click', function(e) {
    e.preventDefault();
  });

});
