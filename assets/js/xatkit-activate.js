(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.yourbehavior = {
    attach: function (context, settings) {
      console.log(drupalSettings.xatkit);
      xatkit.renderXatkitWidget({
        "server": drupalSettings.xatkit.server,
        "username": "Alice",
        "widget": {
          title: drupalSettings.xatkit.title,
          subtitle: drupalSettings.xatkit.subtitle,
         },
        "storage": {
          "autoClear": true
        }
      });
    }
  }
})(jQuery, Drupal, drupalSettings);
