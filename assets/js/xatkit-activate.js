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
      });
    }
  }
})(jQuery, Drupal, drupalSettings);
