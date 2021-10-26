(function (Drupal, $) {
  "use strict";
  // Behaviors might be called with a DOM element (document on page
  // load) or a jQuery object (on AJAX load). DDB React expects a DOM
  // element with querySelectorAll, so this tries to do the right
  // thing.
  var getElement = function(element) {
    if (typeof element.querySelectorAll !== 'function') {
      element = element[0] || element;
    }

    if (typeof element.querySelectorAll !== 'function') {
      return null;
    }

    return element;
  }

  Drupal.behaviors.ddbReactHandler = {
      attach: function (context, settings) {
          var element = getElement(context);
          if (element) {
            $.ajax({
              url: '/ddb-react/user.js',
              dataType: 'script',
              cache: true,
              success: function () {
                window.ddbReact.mount(element);
              }
            });
          }
      },
      detach: function(context) {
          var element = getElement(context);
          if (element) {
            window.ddbReact.unmount(element);
          }
        }
    };
  }(Drupal, jQuery));