(function($) {

  'use strict';

  // =====================
  // Sictk header
  // =====================

  window.onscroll = function() {
      scrollFunction()
  };

  function scrollFunction() {
      const item = document.querySelector(".js-header");
      if (document.body.scrollTop > 1 || document.documentElement.scrollTop > 1) {
          item.classList.add("ie-header--pinned");
      } else {
          item.classList.remove("ie-header--pinned");
      }
  }

  // =====================
  // Post Card Images Fade
  // =====================

  $('.js-fadein').viewportChecker({
      classToAdd: 'is-inview', // Class to add to the elements when they are visible
      offset: 100,
      removeClassAfterAnimation: true
  });

  // =====================
  // Modern cursor
  // =====================
  function cursorAnimate() {
      var myCursor = jQuery(".mouse-cursor");
      if (myCursor.length) {
          if ($("body")) {
              const e = document.querySelector(".cursor-inner"),
                  t = document.querySelector(".cursor-outer");
              let n,
                  i = 0,
                  o = !1;
              (window.onmousemove = function(s) {
                  o ||
                      (t.style.transform =
                          "translate(" + s.clientX + "px, " + s.clientY + "px)"),
                      (e.style.transform =
                          "translate(" + s.clientX + "px, " + s.clientY + "px)"),
                      (n = s.clientY),
                      (i = s.clientX);
              }),
              $("body").on("mouseenter", "a, .cursor-pointer", function() {
                      e.classList.add("cursor-hover"), t.classList.add("cursor-hover");
                  }),
                  $("body").on("mouseleave", "a, .cursor-pointer", function() {
                      ($(this).is("a") && $(this).closest(".cursor-pointer").length) ||
                      (e.classList.remove("cursor-hover"),
                          t.classList.remove("cursor-hover"));
                  }),
                  (e.style.visibility = "visible"),
                  (t.style.visibility = "visible");
          }
      }
  }
  cursorAnimate();

  // =====================
  // Off Canvas menu
  // =====================

  $('.js-off-canvas-toggle').click(function(e) {
      e.preventDefault();
      $('.js-off-canvas-content, .js-off-canvas-container').toggleClass('is-active');
  });

  // =====================
  // Search
  // =====================

  var search_field = $('.js-search-input'),
      toggle_search = $('.js-search-toggle');

  toggle_search.click(function(e) {
      e.preventDefault();
      $('.js-search').addClass('is-active');

      // If off-canvas is active, just disable it
      $('.js-off-canvas-container').removeClass('is-active');

      setTimeout(function() {
          search_field.focus();
      }, 500);
  });

  $('.ie-search, .js-search-close').on('click keyup', function(event) {
      if (event.target == this || $(event.target).hasClass('js-search-close') || event.keyCode == 27) {
          $('.ie-search').removeClass('is-active');
      }
  });

  // =====================
  // Ajax Load More
  // =====================

  $('body').on('click', '#ie_loadmore', function() {
      $.ajax({
          url: ie_loadmore_params.ajaxurl, // AJAX handler
          data: {
              'action': 'loadmore', // the parameter for admin-ajax.php
              'query': ie_loadmore_params.posts, // loop parameters passed by wp_localize_script()
              'page': ie_loadmore_params.current_page, // current page
              'first_page': ie_loadmore_params.first_page
          },
          type: 'POST',
          beforeSend: function(xhr) {
              //$('#ie_loadmore').text('Loading...'); // some type of preloader
              $('#ie_loadmore').text(ie_loadmore_params.iecore_loading); // some type of preloader
              $('.js-load-posts').addClass('ie-btn--loading');
          },
          success: function(data) {
              $('#ie_loadmore').remove();
              $('#ie_pagination').before(data).remove();
              ie_loadmore_params.current_page++;
              $('.js-grid').append(posts);
              $('.js-fadein').viewportChecker({
                  classToAdd: 'is-inview',
                  offset: 100,
                  removeClassAfterAnimation: true
              });
          }
      });
      return false;
  });

  // =====================
  // Post like
  // =====================

  $(document).on('click', '.sl-button', function() {
      var button = $(this);
      var post_id = button.attr('data-post-id');
      var security = button.attr('data-nonce');
      var iscomment = button.attr('data-iscomment');
      var allbuttons;
      if (iscomment === '1') {
          /* Comments can have same id */
          allbuttons = $('.sl-comment-button-' + post_id);
      } else {
          allbuttons = $('.sl-button-' + post_id);
      }
      var loader = allbuttons.next('#sl-loader');
      if (post_id !== '') {
          $.ajax({
              type: 'POST',
              url: simpleLikes.ajaxurl,
              data: {
                  action: 'process_simple_like',
                  post_id: post_id,
                  nonce: security,
                  is_comment: iscomment,
              },
              beforeSend: function() {
                  loader.html('&nbsp;<div class="loader">Loading...</div>');
              },
              success: function(response) {
                  var icon = response.icon;
                  var count = response.count;
                  allbuttons.html(icon + count);
                  if (response.status === 'unliked') {
                      var like_text = simpleLikes.like;
                      allbuttons.prop('title', like_text);
                      allbuttons.removeClass('liked');
                  } else {
                      var unlike_text = simpleLikes.unlike;
                      allbuttons.prop('title', unlike_text);
                      allbuttons.addClass('liked');
                  }
                  loader.empty();
              }
          });

      }
      return false;
  });

  // =====================
  // Tab Slider
  // =====================

  $("document").ready(function() {
      $(".tab-slider--body").hide();
      $(".tab-slider--body:first").show();
  });

  $(".tab-slider--nav li").click(function() {
      $(".tab-slider--body").hide();
      var activeTab = $(this).attr("rel");
      $("#" + activeTab).fadeIn();
      if ($(this).attr("rel") == "tab2") {
          $('.tab-slider--tabs').addClass('slide');
      } else {
          $('.tab-slider--tabs').removeClass('slide');
      }
      $(".tab-slider--nav li").removeClass("active");
      $(this).addClass("active");
  });

  // =====================
  // Validation Comment Form
  // =====================
  var forms = document.querySelectorAll(".comment-form");
  for (var i = 0; i < forms.length; i++) {
    forms[i].setAttribute("novalidate", true);
  }
  $(function () {
    let validator = $("form.comment-form").jbvalidator({
      errorMessage: true,
    });
  });


  // =====================
  // Sticky sidebar
  // =====================

  $(function() {
      $('.c-sidebar .widget').last().addClass('sticky-sidebar');
      if ($('.sticky-sidebar').length) {
          var el = $('.sticky-sidebar');
          var stickyTop = $('.sticky-sidebar').offset().top;
          var stickyHeight = $('.sticky-sidebar').height();
          var stickywidth = $('.sticky-sidebar').width();
          $(window).scroll(function() {
              var limit = $('.ie-footer').offset().top - stickyHeight - 20;
              var windowTop = $(window).scrollTop();
              if (stickyTop < windowTop) {
                  el.css({
                      position: 'fixed',
                      top: 100,
                      width: stickywidth
                  });
              } else {
                  el.css('position', 'static');
              }
              if (limit < windowTop) {
                  var diff = limit - windowTop;
                  el.css({
                      top: diff
                  });
              }
          });
      }
  });


  // =====================
  // Anti adblock
  // =====================

  jQuery(document).ready(function($) {
      if ($(".banner").height() === 0) {
          $(".banner").html('<p class="adblock-warning">~~o(>_<)o ~~ 本站只有少量推介广告，请不要屏蔽，谢谢！<i class="alert-close iecon-cross"></p>');
      }
      $('.alert-close').on('click', function(c) {
          $(this).parent().fadeOut('slow', function(c) {});
      });
  });

  // =====================
  // Lightbox
  // =====================

  Zoom("#lightbox", {
      background: "auto",
  });

})(jQuery);
