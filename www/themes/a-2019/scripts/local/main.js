//= ../../../../../bower_components/jquery/dist/jquery.js
//= ../../../../../bower_components/swiper/dist/js/swiper.js
//= ../../../../../bower_components/vanilla-lazyload/dist/lazyload.js
//= ../../../../../bower_components/wow/dist/wow.js
//= components/mask.js

// initialize animation
new WOW().init();

// check and open modal window
$(document).on("click", "a[href='#modal']", function(event) {
  $("body").css("overflow", "hidden");
  $("#" + $(this).data("name")).fadeIn(300);
});

// close modal window
function hide() {
  $("body").css("overflow", "auto");
  $(".modal").fadeOut(300);
}

$(document).mouseup(function(e) {
  if ($(".modal").has(e.target).length === 0) {
    $("body").css("overflow", "auto");
    $(".modal").fadeOut(300);
  }
});

// carousel anchor
$(document).on("click", "a[href='#carousel']", function(event) {
  event.preventDefault();

  $("html, body").animate({
    scrollTop: $($.attr(this, "href")).offset().top
  }, 600);
});

// inside anchor
$(document).on("click", "a[href^='#inside-']", function(event) {
  event.preventDefault();

  $("html, body").animate({
    scrollTop: $($.attr(this, "href")).offset().top - 194
  }, 600);
});

// post anchor
$(document).on("click", "a[href='#post']", function(event) {
  event.preventDefault();

  $("html, body").animate({
    scrollTop: $($.attr(this, "href")).offset().top - 50
  }, 600);
});

// scroll menu
$(window).scroll(function() {

  // only for desktop version
  if (window.innerWidth > 768) {

    // default page
    if ($(window).scrollTop() >= 497) {
      $(".default .main__black").addClass("main__black--sticky");
    } else {
      $(".default .main__black").removeClass("main__black--sticky");
    };

    // model page
    if ($(window).scrollTop() >= 672) {
      $(".model .main__black").addClass("main__black--sticky");
    } else {
      $(".model .main__black").removeClass("main__black--sticky");
    }
  } else {

    // default page
    if ($(window).scrollTop() >= 259) {
      $(".default .main__black").addClass("main__black--sticky");
    } else {
      $(".default .main__black").removeClass("main__black--sticky");
    };

    // model page
    if ($(window).scrollTop() >= 302) {
      $(".model .main__black").addClass("main__black--sticky");
    } else {
      $(".model .main__black").removeClass("main__black--sticky");
    };
  };
});

// chech black line width
$(document).ready(function() {

  // only for desktop version
  if (window.innerWidth > 768) {
    var listWidth = [],
        clicked = false,
        blackLine = $(".main__black nav"),
        blackLineMore = $(".main__black--more");

    blackLine.find("li").each(function() {
      listWidth.push($(this).innerWidth());
    });

    var listWidthSum = listWidth.reduce(function(a, b) {
      return parseInt(a, 10) + parseInt(b, 10);
    });

    if (blackLine.innerWidth() < (listWidthSum + blackLineMore.innerWidth())) {
      blackLine.find("li:not(:lt(4)):not(.main__black--more)").addClass("main__black--hidden");
    } else {
      blackLineMore.css("display", "none");
    };

    // open hidden elements
    blackLineMore.click(function() {

      (!clicked) ? (
        $(".main__black--hidden, .main__black--more").addClass("clicked")
      ) : (
        $(".main__black--hidden, .main__black--more").removeClass("clicked")
      );

      clicked = !clicked;
    });
  }
});

// sliders
$(document).ready(function() {

  // thumbs gallery on the overview page
  var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 6,
      slidesPerView: 9,
      watchSlidesProgress: true,
      watchSlidesVisibility: true,
      breakpoints: {
        768: {
          slidesPerView: 4
        }
      }
  });

  var galleryTop = new Swiper('.gallery-top', {
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: galleryThumbs
    }
  });

  // initialize swipers when document ready
  var main = new Swiper(".swiper", {
    speed: 500,
    keyboard: {
      enabled: true
    },
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    pagination: {
      clickable: true,
      el: ".swiper-pagination"
    }
  });

  // multiple simple swiper touch slider on the post and default pages
  $(".post__content .container > .swiper-container, .default__overview .swiper-container").each(function(index) {
    var post = new Swiper($(this)[0], {
        slidesPerView: "auto",
        speed: 500,
        pagination: {
          el: '.swiper-pagination',
          type: 'fraction'
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        }
    });
  });

  // multiple wide swiper touch slider on the post page
  $(".post__content--swiper + .swiper-container").each(function(index) {
    var post = new Swiper($(this)[0], {
        slidesPerView: "auto",
        centeredSlides: true,
        simulateTouch: false,
        loopedSlides: 100,
        speed: 500,
        loop: true,
        pagination: {
          el: '.swiper-pagination',
          type: 'fraction'
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        }
    });
  });
});

$(document).ready(function() {

  // initialize lazy load
  var myLazyLoad = new LazyLoad({
      elements_selector: ".lazy"
  });

  // pause video on click label
  $(".tabs label").click(function() {
    var id = $(this).attr("for");

    $("video").each(function() {
      $(this).get(0).pause();
      $(this).get(0).currentTime = 0;
    });

    $(".tabs").find("section[id='" + id + "']").children().get(0).play();
  });

  // main menu and cars menu
  var headerSitemap = $(".sitemap--header"),
      headerSitemapHeight = headerSitemap.height(),
      headerCarsList = $(".header__cars--list li"),
      headerCars = $(".header__cars"),
      burger = $(".burger"),
      article = $(".main"),
      opened = false;


  // initialize height
  $(".sitemap--header, .header__substrate").css("height", 0);

  // open main menu
  $(".menu > div").click(function() {
    headerSitemap.addClass("opened").css("height", headerSitemapHeight);
    $(".menu label").removeClass("selected");
    $(this).addClass("selected");
    headerCars.trigger("reset");
    article.addClass("opened");

    // only for mobile version
    if (opened && window.innerWidth < 768) {
      menuClose();
    } else {
      if (!opened) {
        headerSitemap.addClass("opened").css("height", headerSitemapHeight);
      } else {
        menuClose();
      };
    };

    opened = !opened;
  });

  // only for mobile version
  if (window.innerWidth < 768) {

    // toggle list
    var link = $(".sitemap__title");

    $(".sitemap--footer .sitemap__title, .sitemap--header .sitemap__block:not(:first-of-type) .sitemap__title").removeAttr("href");
    link.click(function(e) {
        var ul = $(this).next().height();

        $(this).toggleClass("opened");
        headerSitemap.css("height", "auto");
        link.not(this).removeClass("opened");
    });
  } else {
    $(document).mouseup(function(e) {
      if ($(".header").has(e.target).length === 0) {
        menuClose();

        opened = !opened;
      };
    });
  };

  // open cars menu
  $(".menu label").click(function() {
    var name = $(this).attr("for"),
        cars = headerCars.find("input[id = '" + name + "'] + div").height();

    if (cars <= 460)
      cars = 460;

    $("input[id = '" + name + "'] + div .header__cars--list li").children("div").css("display", "none");
    $("input[id = '" + name + "'] + div .header__cars--list li:first-child").children("div").css("display", "block");
    headerSitemap.removeClass("opened").css("height", 0);
    $(".menu div, .menu label").removeClass("selected");
    $(".header__substrate").css("height", cars);
    $(this).addClass("selected");
    article.addClass("opened");

    opened = !opened;
  });

  // close main menu and cars menu
  $(".header__substrate--close").click(function() {
    menuClose();

    opened = !opened;
  });

  function menuClose() {
    $(".sitemap--header, .header__substrate").removeClass("opened").css("height", 0);
    $(".menu div, .menu label").removeClass("selected");
    headerCars.trigger("reset");

    // only for mobile version
    if (window.innerWidth < 768) {
      link.removeClass("opened");
    };

    setTimeout(function() {
      article.removeClass("opened");
    }, 600);
  };

  // change cars on the cars menu
  headerCarsList.mouseenter(function() {
    $(this).children("div").css("display", "block");
    headerCarsList.not(this).children("div").css("display", "none");
  });

  // open main menu on the blog page
  burger.click(function() {

    (!opened) ?
      burger.addClass("opened") : burger.removeClass("opened");

    opened = !opened;
  });

  // disable dragging images
  $("img").on("dragstart", function(event) {
      event.preventDefault();
  });

  // add class to every second element
  $('.feed__preview').each(function(i, el) {
    if (i % 2 === 0) {
      $(this).addClass("feed__preview--hood");
    }
    else {
      $(this).addClass("feed__preview--cellar");
    };

    $(".feed__preview:nth-child(3n)").addClass("r");
    $(".feed__preview:nth-child(6n)").addClass("l");
  });

  // only for desktop version
  if (window.innerWidth > 768) {

    // detect Safari using jQuery
    var safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

    if (!safari) {

      // basic sticking an element
      $("#video").stick_in_parent({
        offset_top: 55
      });
    } else {
      $("#video").prop("autoplay", true).css("display", "flex");
    };
  } else {
    var elem = $(".main__black .selected").parent(),
        detached = elem.detach(),
        checked = false;

    // detach an element and paste the first
    $(".main__black nav").prepend(detached);

    // change color for the first element
    elem.css("background-color", "#000");

    $(".main__black nav li:first-of-type").click(function() {

      (!checked) ?
        $(".main__black").addClass("checked") : $(".main__black").removeClass("checked");

      checked = !checked;
    });
  };

  // check contacts page
  if (window.location.href.indexOf("/kontakty") > -1) {
    $(".btn + .btn").remove();
  };

  // opening the inside block
  var inside = "#inside-";

  $(".model__overview--inside").css("display", "none");
  $(".circle").click(function() {
    var name = $(this).data("name");

    ($(this).hasClass("active")) ? (
      $(this).removeClass("active white"),
      $(inside + name).find(".container").addClass("unfade"),
      $(inside + name).stop(true, true).slideUp({
        duration: 600, queue: false
      }, 1200)
    ) : (
      $(this).addClass("active white"),
      $(inside + name).find(".container").removeClass("unfade"),
      $(inside + name).stop(true, true).slideDown({
        duration: 600, queue: false
      }, 1200)
    );
  });
});

$(document).ready(function() {

  // detach modal and paste to the end of the page
  var modal = $(".modal--content").detach();

  // detach an element and paste to the first
  $("#default").append(modal);

  // detach slider and paste to the top of the page
  var slider = $(".model__overview--slider").detach();

  // detach an element and paste to the first
  $("#slider").append(slider);

  // temporary solution to moving the e-tron after TT in the carousel
  var eTron = $(".slider").find("[data-model='e-tron']").detach();
  var r8 = $(".slider").find("[data-model='R8']").detach();

  // detach an element and paste to the end of the carousel
  $(".slider").find("[data-model='TT']").after(eTron);
  $(".slider").find("[data-model='TT']").after(r8);

  // temporary solution to removing other cars in the carousel and lineup
  $("p:contains('other cars')").parent(".model-series-checkbox").remove();
  $(".slider").find("[data-model='other cars']").remove();
  $(".slider").find("[data-body='other cars']").remove();
  $("label[for='other cars']").remove();

  // temporary solution to moving the RS label close to the R8 label
  var labelRS = $("label[for='RS']").detach();
  var labelTT = $("label[for='TT']").detach();

  // detach elements and paste to close to elements
  $("label[for='R8']").after(labelRS);
  $("label[for='Q8']").after(labelTT);

  // change label position on focus select / input in the modal window
  $("select, input").focusin(function() {
    $(this).parent().addClass("focused");
  });
});
