jQuery(document).ready(function($){

  $('.action.search label, .action.search i').click(function(){
    $('.action.search').toggleClass('active');
  });

  $('.site-actions .socials > .active-socials').click(function(){
    $('.site-actions .socials').toggleClass('active');
  });

  $('.site-actions .show-site-nav').click(function(){
    $('body').toggleClass('show-nav');
    $('body,html').scrollTop(0)  ;
  });

  function responsiveIframe() {
     // Fix responsive iframe
    $('iframe').each(function(){
      var iw = $(this).width();
      var ih = $(this).height();
      var ip = $(this).parent().width();
      var ipw = ip/iw;
      var ipwh = Math.round(ih*ipw);
      $(this).css({
        'width': ip,
        'height' : ipwh,
      });
    });
  }

  responsiveIframe();

  $(window).resize(function(){
    responsiveIframe();
  });

  // Accordion
  $('.accordion-toggle').click(function(){
    $(this).removeClass('collapsed');
    $('.accordion-toggle').addClass('collapsed');
  });

  // Back to top
  $('.back-top').click(function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });

});
