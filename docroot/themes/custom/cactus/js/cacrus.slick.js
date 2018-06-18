(function ($, Drupal) {
  Drupal.behaviors.slickHomeSlider = {
    attach: function attach(context) {
      $(context).find('.view-display-id-slideshow_home .view-content').each(function () {
        $(this).slick({
          infinite: true,
          slidesToShow: 1,
          autoplay: true,
          nextArrow: '<button type="button" class="slick-next">' + Drupal.t('Next') + '</button>',
          prevArrow: '<button type="button" class="slick-prev">' + Drupal.t('Previous') + '</button>',
        });
      });
    }
  };

})(jQuery, Drupal);
