(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.xatkitActivate = {
    attach: function (context, settings) {
      $('main', context).once('xatkitActivate').each(function () {
        if (drupalSettings.xatkit.profileAvatar && drupalSettings.xatkit.launcherImage) {
          logos = {
            profileAvatar: drupalSettings.xatkit.profileAvatar,
            launcherImage: drupalSettings.xatkit.launcherImage
          }
        }
        else {
          logos = {}
        }
        xatkit.renderXatkitWidget({
          "server": drupalSettings.xatkit.server,
          "username": "Alice",
          "widget": {
            title: drupalSettings.xatkit.title,
            subtitle: drupalSettings.xatkit.subtitle,
            images: logos
          },
          "storage": {
            "autoClear": true
          }
        });
        console.log(drupalSettings.xatkit.rtl);
        if (drupalSettings.xatkit.rtl == 1) {
          $('.xatkit-widget-container > .xatkit-launcher').css('align-self', 'unset');
          $('.xatkit-widget-container').css('right', 'unset');
          $('.xatkit-widget-container').css('margin', '0 0 20px 20px');
        }
      });


    }
  }
})(jQuery, Drupal, drupalSettings);
