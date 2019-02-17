$(document).ready(function() {

  // Temp Console Message
  console.log('Everything loaded And ready!');

  // Navbar Active Class Toggle
  $('.nav-link').click(function() {
    $(this).toggleClass('active');
  });

  // Disable <a href="#"> Links
  $('a[href="#"]').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
  });

  // Rating
  $('.rating').click(function(e) {
    e.stopPropagation();
  });

  // Smooth Scroll Back To Top
  $('#scroll').click(function () {
    $("html, body").animate({ scrollTop: 0 }, 600);
    return false;
  });

}) /** END document.ready function **/

// rateIt Function
function rateIt(id, rating, user_id) {
  // Return rating in bootstrap badge
  $('#badge_' + id).html('999');
}
