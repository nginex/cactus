(function ($, Drupal) {
  Drupal.behaviors.masonryGrid = {
    attach: function attach(context) {
      $(window).on('load', function () {
        $(context).find('.view-article-teasers .view-content').masonry({
          itemSelector: '.article-teaser',
          horizontalOrder: true,
          percentPosition: true
        });
      });
    }
  };

})(jQuery, Drupal);
