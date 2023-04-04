(function ($) {

  'use strict';

  // =====================
  // Sictk header
  // =====================

  window.onscroll = function() {scrollFunction()};

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
        (window.onmousemove = function (s) {
          o ||
            (t.style.transform =
              "translate(" + s.clientX + "px, " + s.clientY + "px)"),
            (e.style.transform =
              "translate(" + s.clientX + "px, " + s.clientY + "px)"),
            (n = s.clientY),
            (i = s.clientX);
        }),
          $("body").on("mouseenter", "a, .cursor-pointer", function () {
            e.classList.add("cursor-hover"), t.classList.add("cursor-hover");
          }),
          $("body").on("mouseleave", "a, .cursor-pointer", function () {
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

  $('.js-off-canvas-toggle').click(function (e) {
    e.preventDefault();
    $('.js-off-canvas-content, .js-off-canvas-container').toggleClass('is-active');
  });

  // =====================
  // Search
  // =====================

  var search_field = $('.js-search-input'),
    toggle_search = $('.js-search-toggle');

  toggle_search.click(function (e) {
    e.preventDefault();
    $('.js-search').addClass('is-active');

    // If off-canvas is active, just disable it
    $('.js-off-canvas-container').removeClass('is-active');

    setTimeout(function () {
      search_field.focus();
    }, 500);
  });

  $('.ie-search, .js-search-close').on('click keyup', function (event) {
    if (event.target == this || $(event.target).hasClass('js-search-close') || event.keyCode == 27) {
      $('.ie-search').removeClass('is-active');
    }
  });

  // =====================
  // Ajax Load More
  // =====================

  $('body').on('click', '#ie_loadmore', function () {
    $.ajax({
      url: ie_loadmore_params.ajaxurl, // AJAX handler
      data: {
        'action': 'loadmore', // the parameter for admin-ajax.php
        'query': ie_loadmore_params.posts, // loop parameters passed by wp_localize_script()
        'page': ie_loadmore_params.current_page, // current page
        'first_page': ie_loadmore_params.first_page
      },
      type: 'POST',
      beforeSend: function (xhr) {
        //$('#ie_loadmore').text('Loading...'); // some type of preloader
        $('#ie_loadmore').text(ie_loadmore_params.iecore_loading); // some type of preloader
        $('.js-load-posts').addClass('ie-btn--loading');
      },
      success: function (data) {
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
  $(document).on('click', '.sl-button', function () {
    var button = $(this);
    var post_id = button.attr('data-post-id');
    var security = button.attr('data-nonce');
    var iscomment = button.attr('data-iscomment');
    var allbuttons;
    if (iscomment === '1') { /* Comments can have same id */
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
        beforeSend: function () {
          loader.html('&nbsp;<div class="loader">Loading...</div>');
        },
        success: function (response) {
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

  /* Tab Slider
-------------------------------------------------------*/
  //$("#widget-tabs .js-tabs-link").aniTabs();

  $("document").ready(function () {
    $(".tab-slider--body").hide();
    $(".tab-slider--body:first").show();
  });

  $(".tab-slider--nav li").click(function () {
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


  /* Ajax Comment
-------------------------------------------------------*/
  jQuery.extend(jQuery.fn, {
    /*
     * check if field value lenth more than 3 symbols ( for name and comment )
     */
    validate: function () {
      if (jQuery(this).val().length < 5) { jQuery(this).addClass('error'); return false } else { jQuery(this).removeClass('error'); return true }
    },
    /*
     * check if email is correct
     * add to your CSS the styles of .error field, for example border-color:red;
     */
    validateEmail: function () {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
        emailToValidate = jQuery(this).val();
      if (!emailReg.test(emailToValidate) || emailToValidate == "") {
        jQuery(this).addClass('error'); return false
      } else {
        jQuery(this).removeClass('error'); return true
      }
    },

  });

  jQuery(function ($) {

    /*
     * On comment form submit
     */
    $('#commentform').submit(function () {

      // define some vars
      var button = $('#submit'), // submit button
        respond = $('#respond'), // comment form container
        commentlist = $('.comment-list'), // comment list container
        cancelreplylink = $('#cancel-comment-reply-link');

      // if user is logged in, do not validate author and email fields
      if ($('#author').length)
        $('#author').validate();

      if ($('#email').length)
        $('#email').validateEmail();

      // validate comment in any case
      $('#comment').validate();

      // if comment form isn't in process, submit it
      if (!button.hasClass('loadingform') && !$('#author').hasClass('error') && !$('#email').hasClass('error') && !$('#comment').hasClass('error')) {

        // ajax request
        $.ajax({
          type: 'POST',
          url: misha_ajax_comment_params.ajaxurl, // admin-ajax.php URL
          data: $(this).serialize() + '&action=ajaxcomments', // send form data + action parameter
          beforeSend: function (xhr) {
            // what to do just after the form has been submitted
            button.addClass('loadingform').val('Loading...');
          },
          error: function (request, status, error) {
            if (status == 500) {
              alert('Error while adding comment');
            } else if (status == 'timeout') {
              alert('Error: Server doesn\'t respond.');
            } else {
              // process WordPress errors
              var wpErrorHtml = request.responseText.split("<p>"),
                wpErrorStr = wpErrorHtml[1].split("</p>");

              alert(wpErrorStr[0]);
            }
          },
          success: function (addedCommentHTML) {

            // if this post already has comments
            if (commentlist.length > 0) {

              // if in reply to another comment
              if (respond.parent().hasClass('comment')) {

                // if the other replies exist
                if (respond.parent().children('.children').length) {
                  respond.parent().children('.children').append(addedCommentHTML);
                } else {
                  // if no replies, add <ol class="children">
                  addedCommentHTML = '<ol class="children">' + addedCommentHTML + '</ol>';
                  respond.parent().append(addedCommentHTML);
                }
                // close respond form
                cancelreplylink.trigger("click");
              } else {
                // simple comment
                commentlist.append(addedCommentHTML);
              }
            } else {
              // if no comments yet
              addedCommentHTML = '<ol class="comment-list">' + addedCommentHTML + '</ol>';
              respond.before($(addedCommentHTML));
            }
            // clear textarea field
            $('#comment').val('');
          },
          complete: function () {
            // what to do after a comment has been added
            button.removeClass('loadingform').val('Post Comment');
          }
        });
      }
      return false;
    });
  });


  /* Sticky sidebar
-------------------------------------------------------*/
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
  /* Post reading progress for single post page
  -------------------------------------------------------*/
  jQuery(document).ready(function ($) {
    if ($(".banner").height() === 0) {
      $(".banner").html('<p class="adblock-warning">~~o(>_<)o ~~ 本站只有少量推介广告，请不要屏蔽，谢谢！<i class="alert-close iecon-cross"></p>');
    }
    $('.alert-close').on('click', function (c) {
      $(this).parent().fadeOut('slow', function (c) {
      });
    });
  });
  /* Lightbox
-------------------------------------------------------*/
  Zoom("#lightbox", {
    background: "auto",
  });

  /* commentsToggle
-------------------------------------------------------*/

  var body, commentsToggle, commentsArea, resizeTimer;

  commentsToggle = $('#show-comments-button');
  commentsArea = $('#comments .comments-area__wrapper');

  // Enable commentsToggle.
  (function () {
    // Return early if commentsToggle is missing.
    if (!commentsToggle.length) {
      return;
    }

    // Add an initial values for the attribute.
    commentsToggle.add(commentsArea).attr('aria-expanded', 'false');

    commentsToggle.on('click', function () {
      $(this).add(commentsArea).toggleClass('toggled-on');

      $(this).add(commentsArea).attr('aria-expanded', $(this).add(commentsArea).hasClass('toggled-on'));
    });
  })();

  // Shows comments area by certain anchors.
  function showCommentsByAnchor() {
    var anchor = window.location.hash.replace("#", "");

    if (!anchor.length) {
      return;
    }

    if (anchor == "comments" || anchor == "respond" || anchor.includes("comment-")) {
      $('#comments .comments-area__wrapper').slideDown(0);
      $('#show-comments-button').slideUp(0);
    }
  }

  // Get the browser's scrollbar size for alignfull elements.
  function scrollbarWidth() {
    var $outer = $('<div>').css({ visibility: 'hidden', width: 100, overflow: 'scroll' }).appendTo('body'),
      widthWithScroll = $('<div>').css({ width: '100%' }).appendTo($outer).outerWidth();
    $outer.remove();
    var scrollbarWidth = 100 - widthWithScroll;

    document.documentElement.style.setProperty('--scrollbar-width', scrollbarWidth + 'px');
  }

  // Fire on document ready.
  $(document).ready(function () {
    body = $(document.body);

    // Show comments.
    $('#show-comments-button').on('click', function () {
      $('#show-comments-button').slideUp(100);
      $('#comments .comments-area__wrapper').slideDown(200, function () {
        $.scrollTo($('#comments .comments-area__wrapper'), {
          duration: 600,
          offset: { 'top': -48 }
        });
      });
    });

    // Show comments by anchor.
    showCommentsByAnchor();

    // Scroll to comments.
    $('.comments-link > a').on('click', function () {
      $('#comments .comments-area__wrapper').slideDown(0);
      $('#show-comments-button').slideUp(0);
    });

    // Get the browser's scrollbar size for alignfull elements.
    scrollbarWidth();

    $(window).on('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        scrollbarWidth();
      }, 300);
    });
  });
  
   // target all anchor link elements
  const links = document.querySelectorAll('.navigation__link');

  links.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      if (!link.classList.contains('active')) {
        const active = document.querySelector('.navigation__link.active');
      if (active !== null) {
        active.classList.remove('active');
      }
      link.classList.add('active');
      }
    });
  });

})(jQuery);
