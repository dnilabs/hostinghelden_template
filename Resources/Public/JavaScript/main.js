jQuery(function($){
  $(".toggleLevel").click(function(){
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
    } else {
      $(".navbar-nav .toggle-l"+$(this).data("uid")).removeClass("active");
      $(this).addClass("active");
    }
    return false;
  });
  // toplink
  var toplink = $('#top');
  $( window ).scroll(function() {
    var position = $(document).scrollTop();
    if (position <= 300) {
      toplink.removeClass("showtoplink");
    } else {
      toplink.addClass("showtoplink");
    }
  });
  toplink.click(function() {
    $('html, body').animate({
      scrollTop : 0
    }, 500);
  });

});
