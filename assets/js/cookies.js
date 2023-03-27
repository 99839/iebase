(function($) {
  "use strict";

  window.addEventListener("load", function(){
    window.cookieconsent.initialise({
      content: {
        header: 'Cookies used on the website!',
        message: cookies.message,
        dismiss: cookies.dismiss,
        allow: 'Allow cookies',
        deny: 'Decline',
        link: cookies.link,
        href: cookies.href,
        close: '&#x274c;',
      },
      cookie: {
        expiryDays: 365
      },
      position: 'bottom'
    });
    $(".cc-banner").wrapInner("<div class='cc-container container'></div>");
  });

})(jQuery);
