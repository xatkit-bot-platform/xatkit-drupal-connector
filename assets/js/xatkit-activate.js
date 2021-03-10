(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.xatkitActivate = {
    attach: function (context, settings) {
      $('main', context).once('xatkitActivate').each(function () {
        var style = document.createElement('style');
        style.innerHTML = customStyle();
        document.head.appendChild(style);
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


function customStyle () {

  cssStyles = `
        .xatkit-conversation-container .xatkit-header {
          background-color: ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-full-screen .xatkit-close-button {
          background-color: ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-conversation-container .xatkit-close-button {
          background-color: ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-quick-list-button > .xatkit-quick-button {
          border: 2px solid ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-quick-list-button > .xatkit-quick-button:active {
          background: ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-quick-list-button > .xatkit-quick-button-selected {
          background: ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-quick-list-button > .xatkit-quick-button-selected:hover {
          background: ` + drupalSettings.xatkit.color + `; !important;}
        .xatkit-widget-container > .xatkit-launcher {
          background-color: ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-widget-container > .xatkit-launcher:hover {
          background-color: ` + drupalSettings.xatkit.color + `; !important;
        }
        .xatkit-widget-container > .xatkit-launcher:focus {
          background-color: ` + drupalSettings.xatkit.color + `; !important;
        }`;
  if (drupalSettings.xatkit.left == 1) {
    cssStyles = cssStyles + `
          .xatkit-widget-container > .xatkit-launcher {
              align-self: unset !important;
          }
          .xatkit-widget-container {
              right: unset !important;
              margin: 0 0 20px 20px !important;
          }`;
  }
  return cssStyles;
}
