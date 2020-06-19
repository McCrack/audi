$(document).ready( function() {

	$('ul.header-nav-slide-car-links > li:first-child > a').attr('href', '/ru/novye-avtomobili-audi-v-nalichii-v-avtosalone-audi-tsentr-kiev-yug/');

	$('ul.header-nav-slide-car-links > li:nth-child(2) > a').addClass('modal-test-drive');

  $('p.carline-price').each( function() {
    if ( $(this).text() == 'от 1 €'  || $(this).text() == 'від 1 €' ) {
    	$(this).addClass('hidden');
    }
  });

	/*SHARP CHANGED*/

	/*MODAL SIZE*/

	function overflowHidden() {
		$('html, body').css('overflow', 'hidden');
	}

	$('a.modal-size').on('click', function() {
		$('div.modal-size').fadeIn();
		overflowHidden();
	});

	$('a.modal-eco').on('click', function() {
		$('div.modal-eco').fadeIn();
		overflowHidden();
	});

	$('a.modal-g-tron').on('click', function() {
		$('div.modal-g-tron').fadeIn();
		overflowHidden();
	});

	$('a.modal-test-drive').on('click', function(event) {
		showTestDriveBox(event);
	});

	$('a.modal-service').on('click', function() {
		$('div.modal-service').fadeIn();
		overflowHidden();
	});

  $('div.section-content-main-block.active-modal-special').find('div.section-content-main-block-button a').on('click', function() {
  	$('div.modal-content, li.modal-menu-item').removeClass('active');
  	$('div.modal-special').fadeIn();
  	$('li.modal-menu-item').eq($(this).closest('div.section-content-main-block.active-modal-special').index()).addClass('active');
  	$('div.modal-content').eq($(this).closest('div.section-content-main-block.active-modal-special').index()).addClass('active');
  	overflowHidden();
  });

	/*MODAL SIZE*/

	/*CHANGE PAGES FOR MODALS*/

	$('div.modal-size').on('click', 'li.modal-menu-item', function() {

		$(this).addClass('active').siblings('div.modal-size li.modal-menu-item').removeClass('active');
		$('div.modal-size div.modal-layer-img img').removeClass('active').eq($(this).index()).addClass('active');
		$('div.modal-size div.modal-content').removeClass('active');
		$('div.modal-size div.modal-content').eq($(this).index()).addClass('active');
	});

	$('div.modal-eco').on('click', 'li.modal-menu-item', function() {

		$(this).addClass('active').siblings('div.modal-eco li.modal-menu-item').removeClass('active');
		$('div.modal-eco div.modal-layer-img img').removeClass('active').eq($(this).index()).addClass('active');
		$('div.modal-eco div.modal-content').removeClass('active');
		$('div.modal-eco div.modal-content').eq($(this).index()).addClass('active');
	});

	$('div.modal-g-tron').on('click', 'li.modal-menu-item', function() {

		$(this).addClass('active').siblings('div.modal-g-tron li.modal-menu-item').removeClass('active');
		$('div.modal-g-tron div.modal-layer-img img').removeClass('active').eq($(this).index()).addClass('active');
		$('div.modal-g-tron div.modal-content').removeClass('active');
		$('div.modal-g-tron div.modal-content').eq($(this).index()).addClass('active');
	});

	$('div.modal-news').on('click', 'li.modal-menu-item', function() {
		$(this).addClass('active').siblings('div.modal-news li.modal-menu-item').removeClass('active');
		$('div.modal-news div.modal-layer-img img').removeClass('active').eq($(this).index()).addClass('active');
		$('div.modal-news div.modal-content').removeClass('active');
		$('div.modal-news div.modal-content').eq($(this).index()).addClass('active');
	});

	$('body').on('click', 'div.modal-author li.modal-menu-item', function() {
		$(this).addClass('active').siblings('div.modal-author li.modal-menu-item').removeClass('active');
		$('div.modal-author div.modal-layer-img img').removeClass('active').eq($(this).index()).addClass('active');
		$('div.modal-author div.modal-content').removeClass('active');
		$('div.modal-author div.modal-content').eq($(this).index()).addClass('active');
	});

	$('a.modal-news-main').on('click', function() {
		$('div.modal-news').fadeIn();
	});

	/*CHANGE PAGES FOR MODALS*/

	/*SLIDE PREVIEW IN GALLERY*/

	$.each($('li.nm-mediagallery-item, div.gallery-arrow-right, div.gallery-arrow-left'), function() {
		$(this).on('click', function() {
			var parentForSmallSlides = $(this).closest('.gallery-wrapper');
			parentForSmallSlides.find('ul.nm-mediagallery').css('margin-left', ''+ - 60 * parentForSmallSlides.find('li.nm-active').index() +'px');
		});
	});

	/*SLIDE PREVIEW IN GALLERY*/

	/*MODALS FOR BOTTOM TILES*/

	$('div.section-content-main-block div.section-content-main-block-button a, div.section-content-main-100-block div.section-content-main-block-button, div.section-content-main-100-block span a, .section-content-main-block-caption a').on('click', function() {
		if ( $(this).closest('div.section-content-main-block, div.section-content-main-100-block').hasClass('active-modal') ) {
			$('div.modal').eq($(this).closest('div.section-content-main-block, div.section-content-main-100-block').index()).fadeIn();
			$('html, body').css('overflow', 'hidden');
		}
	});

	/*MODALS FOR BOTTOM TILES*/

	/*VALIDATION FOR CONTACTS*/

	$('body').on('click', 'div.modal-close', function() {
		$('div.modal').fadeOut();
		$('html, body').css('overflow', 'auto');
		/*$('.width-100').get(0).pause();*/
	});

	$(document).keydown(function(e) {
    if( e.keyCode === 27 ) {
			$('div.modal').fadeOut();
		$('html, body').css('overflow', 'auto');
    }
	});

	$('.modal-form-radio').on('click', function() {
		$('.modal-form-radio').removeClass('checked');
		$(this).addClass('checked');
			$('.modal-form-radio ~ .validation-error').css('color', 'white');
	});

	$('#modal-form input').on('blur', function() {
		if ( $(this).val().length == 0 ) {
			$(this).addClass('active');
		} else {
			$(this).removeClass('active');
		}
	});

	$('#modal-form-button').on('click', function() {
		var name = $('#modal-form-first-name'),
				lastName = $('#modal-form-last-name'),
				email = $('#modal-form-email'),
				gender = $('.modal-form-radio.checked').text();

		if ( $('.modal-form-radio').hasClass('checked') ) {
			$('.modal-form-radio ~ .validation-error').css('color', 'white');
		} else {
			$('.modal-form-radio ~ .validation-error').css('color', 'red');
		}

		if ( name.val().length ) {
			name.removeClass('active');
		} else {
			name.addClass('active');
		}

		if ( lastName.val().length ) {
			lastName.removeClass('active');
		} else {
			lastName.addClass('active');
		}

		if ( email.val().length ) {
			email.removeClass('active');
		} else {
			email.addClass('active');
		}

		if ( $('#modal-form-checkbox').hasClass(':checked') ) {
			$('#modal-form-checkbox + label').css('border-color', 'black');
		} else {
			$('#modal-form-checkbox + label').css('border-color', '#c03');
		}

		if ( $('.modal-form-radio').hasClass('checked') &&
			   name.val().length &&
			   lastName.val().length &&
			   email.val().length &&
			   !$('#modal-form-checkbox').hasClass(':checked') ) {
			$.ajax({
      type: 'POST',
      url: 'subscription/',
      data: {
        name: name,
        lastName: lastName,
        email: email,
        gender: gender
      },
      success: function() {
        $('#modal-form-first-name').val(''),
				$('#modal-form-last-name').val(''),
				$('#modal-form-email').val(''),
    		$('.modal-form-radio').removeClass('checked');
      }
    });
		}
	});

	/*VALIDATION FOR CONTACTS*/

	$('div.gallery-button, .audi-sport-img').on('click', function() {
		$('#gallery-wrapper-background').fadeIn(600);
		setTimeout(function() { $('div.gallery1, #gallery-wrapper-background').fadeIn(600); }, 600);
	});

	$('div.gallery-button, .audi-sport-img2').on('click', function() {
		$('#gallery2-wrapper-background').fadeIn(600);
		setTimeout(function() { $('div.gallery2, #gallery2-wrapper-background').fadeIn(600); }, 600);
	});

	$('div.gallery-button, .audi-sport-img3').on('click', function() {
		$('#gallery3-wrapper-background').fadeIn(600);
		setTimeout(function() { $('div.gallery3, #gallery3-wrapper-background').fadeIn(600); }, 600);
	});

	/*CARS IN STOCK */

	$('li.stock-img').on('click', function() {
		var car = $(this).attr('data-url');

		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active').find('.stock-submenu').fadeOut();
		} else {
			$('li.stock-img.active').removeClass('active').find('.stock-submenu').fadeOut(300);
			$(this).addClass('active').find('.stock-submenu').fadeIn();
		}

	});

	/*CARS IN STOCK */

	/*SHARP CHANGED*/

	$('#config-sidebar-modal').on('click', function() {
		$('.gallery1, #gallery-wrapper-background').fadeIn();
	});

	$('div.additional-equipment-options').on('click', function() {
		$(this).toggleClass('active').siblings('div.additional-equipment-container').slideToggle();
	});

	function configMoreCounter() {
		$('div.additional-equipment-options-wrap').each(function() {
			var count = $(this).find('.active').length,
					countText = $(this).find('p.amount-select');

			if ( count == 0 ) {
				countText.text('');
			} else if( count == 1 ) {
				countText.text(count + ' опция выбрана');
			} else if( count == 2 ) {
				countText.text(count + ' опции выбрано');
			} else {
				countText.text(count + ' опций выбрано');
			}
		});
	}

	$('div.linie-packages-name-checkbox, div.engine-list-main-button').on('click', function() {
		$(this).closest('div.additional-equipment-options-wrap').each(function() {
			var count = $(this).find('.active').length - 1,
					countText = $(this).find('p.amount-select');

			if ( count == 0 ) {
				countText.text('');
			} else if( count == 1 ) {
				countText.text(count + ' опция выбрана');
			} else if( count == 2 ) {
				countText.text(count + ' опции выбрано');
			} else {
				countText.text(count + ' опций выбрано');
			}
		});
	});

	$('div.additional-equipment-options-wrap').each(function() {
		configMoreCounter();
	});

	$('p.black-config-button').on('click', function() {
		configMoreCounter();
	});

	$('li.model-aside-filter-bar-accordeon a').on('click', function() {
		if ( $(this).closest('li.model-aside-filter-bar-accordeon').hasClass('active') ) {
			$(this).siblings('ul').slideUp().closest('li.model-aside-filter-bar-accordeon').addClass('paddings');
			$('li.model-aside-filter-bar-accordeon').removeClass('active');
			$(this).closest('li.model-aside-filter-bar-accordeon').removeClass('active');
		} else {
			$('li.model-aside-filter-bar-accordeon a').siblings('ul').slideUp().closest('li.model-aside-filter-bar-accordeon').addClass('paddings');
			$(this).siblings('ul').slideToggle().closest('li.model-aside-filter-bar-accordeon').toggleClass('paddings');
			$('li.model-aside-filter-bar-accordeon').removeClass('active');
			$(this).closest('li.model-aside-filter-bar-accordeon').addClass('active');
		}
	});

});


if ( $('div.all-model-content').length ) {

/*Global function remove from array*/

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

var noneua = "Тимчасово недоступні до замовлення в Україні",
		none = "Временно недоступны к заказу в Украине",
		fromua = "Ціна: від",
		from = "Цена: от";

/*--------------------------CheckBoxes Start-----------------------------------*/

/*Start var init*/
var carArray = [

	// A1
	{id: 0, name: "A1 Sportback", type: ["Sportback"], series: ["A1"], uaprice: "0", price: "0", photoUrl: "audi-a1-1.png", href: "/audi-a1-sportback"},

	// A3
  {id: 1, name: "A3 Sportback", type: ["Sportback"], series: ["A3"], uaprice: "0", price: "0", photoUrl: "audi-a3-sportback-2019-1.png", href: "/audi-a3-sportback"},
	{id: 2, name: "A3 Sportback g-tron", type: ["Sportback"], series: ["A3", "g-tron"], uaprice: "0", price: "0", photoUrl: "audi-a3-sportback-g-tron-1.png", href: "/audi-a3-sportback-g-tron"},
	{id: 3, name: "A3 Limousine", type: ["Limousine"], series: ["A3"], uaprice: "0", price: "0", photoUrl: "audi-a3-limousine-2019-1.png", href: "/audi-a3-limousine"},
	{id: 4, name: "A3 Cabriolet", type: ["Cabriolet"], series: ["A3"], uaprice: "0", price: "0", photoUrl: "audi-a3-cabriolet-2019-1.png", href: "/audi-a3-cabriolet"},
	{id: 5, name: "S3 Sportback", type: ["Sportback", "Sportwagen"], series: ["A3"], uaprice: "0", price: "0", photoUrl: "audi-s3-sportback-2019-1.png", href: "/audi-s3-sportback"},
	{id: 6, name: "S3 Limousine", type: ["Limousine", "Sportwagen"], series: ["A3"], uaprice: "0", price: "0", photoUrl: "audi-s3-limousine-2019-1.png", href: "/audi-s3-limousine"},
	{id: 7, name: "S3 Cabriolet", type: ["Cabriolet", "Sportwagen"], series: ["A3"], uaprice: "0", price: "0", photoUrl: "audi-s3-cabriolet-2019-1.png", href: "/audi-s3-cabriolet"},
	{id: 8, name: "RS 3 Sportback", type: ["Sportback", "Sportwagen"], series: ["A3", "RS"], uaprice: "0", price: "0", photoUrl: "audi-rs3-sportback-1.png", href: "/audi-rs3-sportback"},
	{id: 9, name: "RS 3 Limousine", type: ["Limousine", "Sportwagen"], series: ["A3", "RS"], uaprice: "0", price: "0", photoUrl: "audi-rs3-limousine-1.png", href: "/audi-rs3-limousine"},

	// A4
	{id: 10, name: "A4 Limousine", type: ["Limousine"], series: ["A4"], uaprice: "1162031", price: "1162031", photoUrl: "audi-a4-limousine-2019-1.png", href: "/audi-a4-limousine"},
	{id: 11, name: "A4 Limousine 2020", type: ["Limousine"], series: ["A4"], uaprice: "0", price: "0", photoUrl: "audi-a4-limousine-2020-1.png", href: "/audi-a4-limousine-2020"},
	{id: 12, name: "A4 Avant", type: ["Avant"], series: ["A4"], uaprice: "0", price: "0", photoUrl: "audi-a4-avant-2019-1.png", href: "/audi-a4-avant"},
	{id: 13, name: "A4 Avant 2020", type: ["Avant"], series: ["A4"], uaprice: "0", price: "0", photoUrl: "audi-a4-avant-2020-1.png", href: "/audi-a4-avant-2020"},
	{id: 14, name: "A4 Avant g-tron", type: ["Avant"], series: ["A4", "g-tron"], uaprice: "0", price: "0", photoUrl: "audi-a4-avant-g-tron-2018-1.png", href: "/audi-a4-avant-g-tron"},
	{id: 15, name: "A4 allroad quattro", type: ["allroad quattro"], series: ["A4"], uaprice: "1482140", price: "1482140", photoUrl: "audi-a4-allroad-quattro-1.png", href: "/audi-a4-allroad-quattro"},
	{id: 16, name: "S4 Limousine", type: ["Limousine", "Sportwagen"], series: ["A4"], uaprice: "0", price: "0", photoUrl: "audi-s4-limousine-1.png", href: "/audi-s4-limousine"},
	{id: 17, name: "S4 Limousine 2020", type: ["Limousine", "Sportwagen"], series: ["A4"], uaprice: "0", price: "0", photoUrl: "audi-s4-limousine-2020-1.png", href: "/audi-s4-limousine-2020"},
	{id: 18, name: "S4 Avant", type: ["Avant", "Sportwagen"], series: ["A4"], uaprice: "0", price: "0", photoUrl: "audi-s4-avant-1.png", href: "/audi-s4-avant"},
	{id: 19, name: "S4 Avant 2020", type: ["Avant", "Sportwagen"], series: ["A4"], uaprice: "0", price: "0", photoUrl: "audi-s4-avant-2020-1.png", href: "/audi-s4-avant-2020"},
	{id: 20, name: "RS 4 Avant", type: ["Avant", "Sportwagen"], series: ["A4", "RS"], uaprice: "0", price: "0", photoUrl: "audi-rs4-avant-1.png", href: "/audi-rs4-avant"},

	// A5
	{id: 21, name: "A5 Coupe", type: ["Coupe"], series: ["A5"], uaprice: "1251235", price: "1251235", photoUrl: "audi-a5-coupe-2019-1.png", href: "/audi-a5-coupe"},
	{id: 22, name: "A5 Sportback", type: ["Sportback"], series: ["A5"], uaprice: "1251235", price: "1251235", photoUrl: "audi-a5-sportback-2019-1.png", href: "/audi-a5-sportback"},
	{id: 23, name: "A5 Sportback g-tron", type: ["Sportback"], series: ["A5", "g-tron"], uaprice: "0", price: "0", photoUrl: "audi-a5-sportback-g-tron-1.png", href: "/audi-a5-sportback-g-tron"},
	{id: 24, name: "A5 Cabriolet", type: ["Cabriolet"], series: ["A5"], uaprice: "0", price: "0", photoUrl: "audi-a5-cabriolet-2019-1.png", href: "/audi-a5-cabriolet"},
	{id: 25, name: "S5 Coupe", type: ["Coupe"], series: ["A5"], uaprice: "0", price: "0", photoUrl: "audi-s5-coupe-1.png", href: "/audi-s5-coupe"},
	{id: 26, name: "S5 Sportback", type: ["Sportback", "Sportwagen"], series: ["A5"], uaprice: "0", price: "0", photoUrl: "audi-s5-sportback-1.png", href: "/audi-s5-sportback"},
	{id: 27, name: "S5 Cabriolet", type: ["Cabriolet", "Sportwagen"], series: ["A5"], uaprice: "0", price: "0", photoUrl: "audi-s5-cabriolet-1.png", href: "/audi-s5-cabriolet"},
	{id: 28, name: "RS 5 Coupe", type: ["Coupe", "Sportwagen"], series: ["A5", "RS"], uaprice: "0", price: "0", photoUrl: "audi-rs5-coupe-1.png", href: "/audi-rs5-coupe"},
	{id: 29, name: "RS 5 Sportback", type: ["Sportback", "Sportwagen"], series: ["A5", "RS"], uaprice: "0", price: "0", photoUrl: "audi-rs5-sportback-1.png", href: "/audi-rs5-sportback"},

	// A6
	{id: 30, name: "A6 Limousine", type: ["Limousine"],  series: ["A6"], uaprice: "0", price: "0", photoUrl: "audi-a6-limousine-1.png", href: "/audi-a6-limousine"},
	{id: 31, name: "A6 Avant", type: ["Avant"], series: ["A6"], uaprice: "0", price: "0", photoUrl: "audi-a6-avant-1.png", href: "/audi-a6-avant"},
	{id: 32, name: "A6 allroad quattro", type: ["allroad quattro"], series: ["A6"], uaprice: "0", price: "0", photoUrl: "audi-a6-allroad-quattro-1.png", href: "/audi-a6-allroad-quattro"},
	{id: 33, name: "S6 Limousine", type: ["Limousine", "Sportwagen"], series: ["A6"], uaprice: "0", price: "0", photoUrl: "audi-s6-limousine-1.png", href: "/audi-s6-limousine"},
	{id: 34, name: "S6 Avant", type: ["Sportwagen", "Avant"], series: ["A6"], uaprice: "0", price: "0", photoUrl: "audi-s6-avant-1.png", href: "/audi-s6-avant"},

	// A7
	{id: 35, name: "A7 Sportback", type: ["Sportback"], series: ["A7"], uaprice: "1945910", price: "1945910", photoUrl: "audi-a7-sportback-1.png", href: "/audi-a7-sportback"},
	{id: 36, name: "S7 Sportback", type: ["Sportback"], series: ["A7"], uaprice: "0", price: "0", photoUrl: "audi-s7-sportback-1.png", href: "/audi-s7-sportback"},

	// A8
	{id: 37, name: "A8", type: ["Limousine"], series: ["A8"], uaprice: "2227431", price: "2227431", photoUrl: "audi-a8-1.png", href: "/audi-a8"},
	{id: 38, name: "A8 L", type: ["Limousine"], series: ["A8"], uaprice: "2364390", price: "2364390", photoUrl: "audi-a8-l-1.png", href: "/audi-a8-l"},

	// Q2
	{id: 39, name: "Q2", type: ["SUV"], series: ["Q2"], uaprice: "802737", price: "802737", photoUrl: "audi-q2-1.png", href: "/audi-q2"},
	{id: 40, name: "SQ2", type: ["SUV"], series: ["Q2"], uaprice: "0", price: "0", photoUrl: "audi-sq2-1.png", href: "/audi-sq2"},

	// Q3
	{id: 41, name: "Q3", type: ["SUV"], series: ["Q3"], uaprice: "0", price: "0", photoUrl: "audi-q3-1.png", href: "/audi-q3"},

	// Q5
	{id: 42, name: "Q5", type: ["SUV"], series: ["Q5"], uaprice: "1425815", price: "1425815", photoUrl: "audi-q5-2019-1.png", href: "/audi-q5"},
	{id: 43, name: "SQ5 TDI", type: ["SUV"], series: ["Q5"], uaprice: "0", price: "0", photoUrl: "audi-sq5-tdi-1.png", href: "/audi-sq5"},

	// Q7
	{id: 44, name: "Q7", type: ["SUV"], series: ["Q7"], uaprice: "1737039", price: "1737039", photoUrl: "audi-q7-1.png", href: "/audi-q7"},
	{id: 45, name: "SQ7 TDI", type: ["SUV", "Sportwagen"], series: ["Q7"], uaprice: "2517638", price: "2517638", photoUrl: "audi-sq7-1.png", href: "/audi-sq7-tdi"},

	// Q8
	{id: 46, name: "Q8", type: ["SUV"], series: ["Q8"], uaprice: "1615246", price: "1615246", photoUrl: "audi-q8-1.png", href: "/audi-q8"},

	// TT
	{id: 47, name: "TT Coupe", type: ["Coupe"], series: ["TT"], uaprice: "0", price: "0", photoUrl: "audi-tt-coupe-1.png", href: "/audi-tt-coupe"},
	{id: 48, name: "TT Roadster", type: ["Cabriolet", "Roadster"], series: ["TT"], uaprice: "0", price: "0", photoUrl: "audi-tt-roadster-1.png", href: "/audi-tt-roadster"},
	{id: 49, name: "TTS Coupe", type: ["Coupe", "Sportwagen"], series: ["TT"], uaprice: "0", price: "0", photoUrl: "audi-tts-coupe-1.png", href: "/audi-tts-coupe"},
	{id: 50, name: "TTS Roadster", type: ["Cabriolet", "Roadster", "Sportwagen"], series: ["TT"], uaprice: "0", price: "0", photoUrl: "audi-tts-roadster-1.png", href: "/audi-tts-roadster"},
	{id: 51, name: "TT RS Coupe", type: ["Coupe", "Sportwagen"], series: ["TT", "RS"], uaprice: "0", price: "0", photoUrl: "audi-tt-rs-coupe-1.png", href: "/audi-tt-rs-coupe"},
	{id: 52, name: "TT RS Roadster", type: ["Cabriolet", "Roadster", "Sportwagen"], series: ["TT", "RS"], uaprice: "0", price: "0", photoUrl: "audi-tt-rs-roadster-1.png", href: "/audi-tt-rs-roadster"},

	// R8
	{id: 53, name: "R8 Coupe V10 quattro", type: ["Coupe", "Sportwagen"], series: ["R8"], uaprice: "0", price: "0", photoUrl: "audi-r8-coupe-v10-1.png", href: "/audi-r8-coupe-v10-quattro"},
	{id: 54, name: "R8 Coupe V10 performance quattro", type: ["Coupe", "Sportwagen"], series: ["R8"], uaprice: "0", price: "0", photoUrl: "audi-r8-coupe-v10-performance-1.png", href: "/audi-r8-coupe-v10-performance-quattro"},
	{id: 55, name: "R8 Spyder V10 quattro", type: ["Cabriolet", "Spyder", "Sportwagen"], series: ["R8"], uaprice: "0", price: "0", photoUrl: "audi-r8-spyder-v10-1.png", href: "/audi-r8-spyder-v10-quattro"},
	{id: 56, name: "R8 Spyder V10 performance quattro", type: ["Cabriolet", "Spyder", "Sportwagen"], series: ["R8"], uaprice: "0", price: "0", photoUrl: "audi-r8-spyder-v10-performance-1.png", href: "/audi-r8-spyder-v10-performance-quattro"},
	{id: 57, name: "R8 V10 Decennium quattro", type: ["Sportwagen"], series: ["R8"], uaprice: "0", price: "0", photoUrl: "audi-r8-v10-decennium-1.png", href: "/audi-r8-v10-decennium"},

	// e-tron
	{id: 58, name: "e-tron", type: ["SUV"], series: ["e-tron"], uaprice: "0", price: "0", photoUrl: "audi-e-tron-1.png", href: "/audi-e-tron"}
 ];

var carArrayLength = carArray.length;
var d = document;
DisplayLiCarArray ();

var subCarArray = [];


var Filter = {series:[], type:[], prices:[]};

var listOfDisplayCar = d.getElementsByClassName("all-model-content-main-car");
/*Var for Type and series checkbox*/
var modelSeriesCheckBox = d.getElementsByClassName('model-series-checkbox');
var modelTypeCheckBox = d.getElementsByClassName('model-type-checkbox');
/*Var for Price Select*/
var modelAsideSelectMax = d.getElementsByClassName("model-aside-select-max")[0];
var modelAsideSelectMin = d.getElementsByClassName('model-aside-select-min')[0];
/*Var for previev display*/
var carPreviewDisplay = d.getElementsByClassName('all-model-content-main-car-temporary');
var carPreviewDisplayL = carPreviewDisplay.length;

/*Start Function init*/

SetListeners();

function DisplayLiCarArray () {
	var UlForCars = d.getElementById("listing2");

	for (var i = 0; i < carArrayLength; i++) {
		if (LANGUAGE == "ru") {
			if (carArray[i].price == "0") {
				UlForCars.innerHTML += "<li class='all-model-content-main-car grid'><a href='/ru/modelnyy-ryad" + carArray[i].href + "'><img src='https://img.audi-kiev.com.ua/data/catalog/" + carArray[i].photoUrl + "'" + " alt='photo'></a><div class='all-model-content-main-car-details'><a href='/ru/modelnyy-ryad" + carArray[i].href+ "'>" + carArray[i].name + "</a><div class='all-model-content-main-car-details-stats'><p class=carline-price>" + none + "</p></div></div></li>"
			} else {
				UlForCars.innerHTML += "<li class='all-model-content-main-car grid'><a href='/ru/modelnyy-ryad" + carArray[i].href + "'><img src='https://img.audi-kiev.com.ua/data/catalog/" + carArray[i].photoUrl + "'" + " alt='photo'></a><div class='all-model-content-main-car-details'><a href='/ru/modelnyy-ryad" + carArray[i].href+ "'>" + carArray[i].name + "</a><div class='all-model-content-main-car-details-stats'><p class=carline-price>" + from + " " + carArray[i].price + " грн." + "</p></div></div></li>"
			}
		} else {
			if (carArray[i].uaprice == "0") {
				UlForCars.innerHTML += "<li class='all-model-content-main-car grid'><a href='/modelnyy-ryad" + carArray[i].href + "'><img src='https://img.audi-kiev.com.ua/data/catalog/" + carArray[i].photoUrl + "'" + " alt='photo'></a><div class='all-model-content-main-car-details'><a href='/modelnyy-ryad" + carArray[i].href + "'>" + carArray[i].name +"</a><div class='all-model-content-main-car-details-stats'><p class=carline-price>" + noneua + "</p></div></div></li>"
			} else {
				UlForCars.innerHTML += "<li class='all-model-content-main-car grid'><a href='/modelnyy-ryad" + carArray[i].href + "'><img src='https://img.audi-kiev.com.ua/data/catalog/" + carArray[i].photoUrl + "'" + " alt='photo'></a><div class='all-model-content-main-car-details'><a href='/modelnyy-ryad" + carArray[i].href + "'>" + carArray[i].name +"</a><div class='all-model-content-main-car-details-stats'><p class=carline-price>" + fromua + " " + carArray[i].uaprice + " грн." + "</p></div></div></li>"
			}
		}
	}
}

function SetListeners() {
	var modelSeriesCheckBoxLength = modelSeriesCheckBox.length;
	var modelTypeCheckBoxLength = modelTypeCheckBox.length;

	/*Init listeners for Series*/
	for(var i=0; i < modelSeriesCheckBoxLength; i++) {
		modelSeriesCheckBox[i].addEventListener('click', ChangeFilterParam);
	}

	/*Init listeners for Type*/
	for(var i=0; i < modelTypeCheckBoxLength; i++) {
		modelTypeCheckBox[i].addEventListener('click', ChangeFilterParam);
	}

	/*Init listeners for Price*/
	d.getElementsByClassName("model-aside-select-min")[0].addEventListener('change', ChangeFilterParamSelect);
	d.getElementsByClassName("model-aside-select-max")[0].addEventListener('change', ChangeFilterParamSelect);

	/*Init listeners fo filter-to-result*/

	d.getElementById("filter-to-result").addEventListener('click', ResetAllToDefault);

	/*Set Listeners for carPreviewDispaly*/

	for(var i=0; i < carPreviewDisplayL; i++) {
		carPreviewDisplay[i].addEventListener('click', carPreviewDisplayClick);
	}
}

/*Processing clicking on the starting grid of car*/
function carPreviewDisplayClick() {
	var linkText = this.getElementsByClassName('all-model-content-main-car-details')[0].innerHTML;
	var seriesCheckBoxes = document.getElementsByClassName('model-series-checkbox');

	for(var i=0 ; i < seriesCheckBoxes.length; i++) {
		if(seriesCheckBoxes[i].getElementsByTagName('P')[0].innerHTML == linkText) {
			seriesCheckBoxes[i].getElementsByClassName("model-aside-filter-bar-accordeon-panel-box")[0].className += " active";
			Filter.series[0] = linkText;
		}
	}

	for(var i=0; i < carPreviewDisplayL; i++) {
		carPreviewDisplay[i].style.display = 'none';
	}
	d.getElementById("tool-bar-id").style.display = "block";

	ApplyFilters();
}


/*Add and Remove Parametrs in filter and Display*/
function ChangeFilterParam (e) {

	var currentCheckBox = this.getElementsByClassName("model-aside-filter-bar-accordeon-panel-box")[0];
	var currentValue = this.getElementsByTagName('P')[0].innerHTML;

	/*Better to delete later*/
	d.getElementById("tool-bar-id").style.display = "block";
	for(var i=0; i < carPreviewDisplayL; i++) {
		carPreviewDisplay[i].style.display = 'none';
	}

	/*Series handled*/
	if(this.className == 'model-series-checkbox') {

		if(currentCheckBox.className.indexOf(" active") == -1){
			currentCheckBox.className += " active";
			Filter.series.push(currentValue);
			console.log(Filter.series);
		}
		else {
			currentCheckBox.className = currentCheckBox.className.replace(' active', "");
			Filter.series = removeA(Filter.series, currentValue);
		}

	}
	/*Type handled*/
	else if (this.className == 'model-type-checkbox') {

		if(currentCheckBox.className.indexOf(" active") == -1){
			currentCheckBox.className += " active";
			Filter.type[Filter.type.length] = currentValue;
		}
		else {
			currentCheckBox.className = currentCheckBox.className.replace(' active', "");
			Filter.type = removeA(Filter.type, currentValue);
		}

}
	ApplyFilters();

}

/*Change cost in select */
function ChangeFilterParamSelect(e) {
	console.log("this Selected index " + this.selectedIndex)
	/*If user choose default price "Choise" set Filter prices to default values*/
	if (modelAsideSelectMax.selectedIndex == 0 &&
	   modelAsideSelectMin.selectedIndex == 0) {
		Filter.prices.length = 0;
	}
	else if (this.selectedIndex == 0 && this.className =="model-aside-select-min") {

		Filter.prices[0] = parseFloat(this.options[1].value);

	}

	else if (this.selectedIndex == 0 && this.className == "model-aside-select-max") {

		console.log("mod aside select max " + this.options[modelAsideSelectMax.length -1 ].value);
		Filter.prices[1] = parseFloat(this.options[modelAsideSelectMax.length - 1].value);
	}

	else if (this.className == "model-aside-select-min") {
		/*If max price haven`t set yet*/
		if (modelAsideSelectMax.selectedIndex == 0) {
			Filter.prices[1] = parseFloat(modelAsideSelectMax.options[modelAsideSelectMax.length - 1].value);
		}
		/*If min price more than max change max*/
	 	else if(this.selectedIndex > modelAsideSelectMax.selectedIndex) {

			modelAsideSelectMax.selectedIndex = this.selectedIndex;
			Filter.prices[1] = parseFloat(modelAsideSelectMax.options[modelAsideSelectMax.selectedIndex].value);

		}

		Filter.prices[0] = parseFloat(this.options[this.selectedIndex].value);

	}
	else {
		/*If min price more than max change min*/
		if(this.selectedIndex < modelAsideSelectMin.selectedIndex) {

			modelAsideSelectMin.selectedIndex = this.selectedIndex;
			Filter.prices[0] = parseFloat(modelAsideSelectMin.options[modelAsideSelectMin.selectedIndex].value);

		}
		/*If min price haven`t set yet*/
		else if ( modelAsideSelectMin.selectedIndex == 0) {
			Filter.prices[0] = parseFloat(modelAsideSelectMin.options[1].value);
		}

		Filter.prices[1] = parseFloat(this.options[this.selectedIndex].value);
		console.log(typeof(parseFloat(this.options[this.selectedIndex].value)));
	}
	/**/
	for(var i=0; i < carPreviewDisplayL; i++) {
		carPreviewDisplay[i].style.display = 'none';
	}

	ApplyFilters();
	console.log('Min price:' + Filter.prices[0]);
	console.log('Max price:' + Filter.prices[1]);
}



function ApplyFilters() {

	/*Clear all*/
	subCarArray.length = 0;

	var typeLength = Filter.type.length;
	var seriesLength = Filter.series.length;
	var pricesLength = Filter.prices.length;
	var minPrice, maxPrice;

	if(pricesLength > 0) {
		minPrice = Filter.prices[0];
		maxPrice = Filter.prices[1];
	}


  /*1*/	if (typeLength != 0 && seriesLength == 0 && pricesLength == 0) {
		console.log(1);
		for(var i=0 ; i < typeLength ; i++) {
			for(var j=0; j < carArrayLength; j++ ) {
				if(carArray[j].type.indexOf(Filter.type[i]) != -1) {
					subCarArray.push(carArray[j]);}
			}
		}
	}
	/*2*/ else if (typeLength != 0 && seriesLength != 0 && pricesLength == 0) {
		console.log("Series and Type");
		for (var j = 0 ; j < seriesLength; j++){
			for (var i =0 ; i < typeLength; i++){
				for (var n = 0; n < carArrayLength; n++) {
					if(carArray[n].series.indexOf(Filter.series[j]) != -1 && carArray[n].type.indexOf(Filter.type[i]) != -1 ) {
								console.log('inside');
						       subCarArray.push(carArray[n]);

					}
			}
		}
	}
}

/*3*/	else if (typeLength != 0 && seriesLength == 0 && pricesLength != 0) {
	    console.log(3);
		for(var i=0 ; i < typeLength ; i++) {
			for(var j=0; j < carArrayLength; j++ ) {
				if( carArray[j].type.indexOf(Filter.type[i]) != -1 && carArray[j].price < maxPrice
				   && carArray[j].price > minPrice ) {
					subCarArray.push(carArray[j]);
				}
			}
		}

	}
/*4*/	else if (typeLength != 0 && seriesLength != 0 && pricesLength != 0) {
		console.log("All true inside");
		for (var i=0; i < typeLength; i++){
			for (var j=0; j < seriesLength; j++){
				for (var n = 0; n < carArrayLength; n++) {
					if(carArray[n].type.indexOf(Filter.type[i]) != -1 && carArray[n].series.indexOf(Filter.series[j]) != -1
					  && carArray[n].price < maxPrice && carArray[n].price > minPrice) {
						subCarArray.push(carArray[n]);
					}
				}
			}
		}
	}

/*5*/	else if (typeLength == 0 && seriesLength == 0 && pricesLength == 0) {
		 console.log(5);
	     d.getElementById('tool-bar-id').style.display = "none";
	     for(var i = 0; i < carPreviewDisplayL; i++) {
			 carPreviewDisplay[i].style.display = "block";
		 }
	}

/*6*/	else if (typeLength == 0 && seriesLength != 0 && pricesLength == 0) {
		console.log('Only Series');
		for(var i= 0; i < seriesLength; i++) {
			for(var j =0; j < carArrayLength; j++) {
				if(carArray[j].series.indexOf(Filter.series[i]) != -1) {
					subCarArray.push(carArray[j]);
				}
			}
		}
	}

/*7*/	else if (typeLength == 0 && seriesLength == 0 && pricesLength != 0) {
	    console.log(7);
		for(var i =0; i < carArrayLength; i++) {
			if(carArray[i].price < maxPrice && carArray[i].price > minPrice){
				subCarArray.push(carArray[i]);}
		}
	}
/*8*/	else if (typeLength == 0 && seriesLength != 0 && pricesLength != 0) {
	     console.log(8);
		for(var i= 0; i < seriesLength; i++) {
			for(var j =0; j < carArrayLength; j++) {

				if(carArray[j].series.indexOf(Filter.series[i]) != -1 &&
				  carArray[j].price < maxPrice && carArray[j].price > minPrice) {
                    console.log();
					subCarArray.push(carArray[j]);
				}
			}
		}
	}


	/*Set all Displayed car to none*/
	for (var i =0; i < carArrayLength; i++ ) {
		listOfDisplayCar[i].style.display = 'none';
	}

	console.log(subCarArray.length);

	for(var i = 0; i < subCarArray.length; i ++) {
		listOfDisplayCar[subCarArray[i].id].style.display = "block";
	}


}


function ResetAllToDefault() {

	Filter.prices.length = 0;
	Filter.type.length = 0;
	Filter.series.length = 0;

	var allCheckBoxes = d.getElementsByClassName("model-aside-filter-bar-accordeon-panel-box");
	var allCheckBoxesLength = allCheckBoxes.length;
	for(var i =0; i < allCheckBoxesLength; i++) {
		allCheckBoxes[i].className = allCheckBoxes[i].className.replace(' active', '');
	}

	modelAsideSelectMax.selectedIndex = 0;
	modelAsideSelectMin.selectedIndex = 0;

	ApplyFilters();
}



var obj1 = {id:"1", name:"A3 sport", type:['Compact', 'Sportback'], model:'a3', price : [13000, 15000]};






/*-----------------------From List to grid Start--------------------------------*/

var listDisplay = d.getElementById('toggle-list');
var gridDisplay = d.getElementById('toggle-grid');
var prevActiveToggle = 'toggle-grid';

listDisplay.addEventListener('click', ChangeDisplay);
gridDisplay.addEventListener('click', ChangeDisplay);

function ChangeDisplay (e) {

	// Define previous class
	if(prevActiveToggle == this.id) {
		return;
	}
	else {
		prevActiveToggle = this.id;
	}

	listDisplay.className = listDisplay.className.replace(' active', "");
	gridDisplay.className = gridDisplay.className.replace(' active', "");

	this.className += " active";

	var addClass;
	var removeClass;

	if(this.id == "toggle-list") {
		addClass = ' list';
		removeClass = ' grid';
	}
	else {
		addClass = ' grid';
		removeClass = ' list';
	}

	var n = listOfDisplayCar.length;

	for(var i =0; i < n; i++) {
		listOfDisplayCar[i].className = listOfDisplayCar[i].className.replace(removeClass, addClass);
	}

}

/*-----------------------From List to grid End--------------------------------*/
}

	            "use strict";


	           // Small modals start
                var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

                function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

                $(function () {

                	initLankoModals();
                	initLankoSubModals();
                });

                function initLankoSubModals() {
                	$(".lanko-submodal-link").each(function (index) {
                		var subModalsContainer = $(this).closest(".lanko-modal-submodals");
                		var subModals = subModalsContainer.find(".lanko-submodal");
                		// Get first main submodal
                		var mainModal = subModals.eq(0);

                		$(this).on("click", function () {
                			// Get link submodal name attr
                			var modalName = $(this).attr("submodal");
                			// Find submodal with modalName attr
                			var subModal = subModalsContainer.find("[submodalname=" + modalName + "]");
                			// Hide main modal and display selected
                			mainModal.fadeOut("fast", function () {
                				return subModal.fadeIn("fast");
                			});
                			// Handling back action to main model
                			subModal.find(".lanko-modal-content__back").click(function () {
                				// Hide current submodal and display main
                				subModal.fadeOut("fast", function () {
                					return mainModal.fadeIn("fast");
                				});
                			});
                		});
                	});
                }


                function initLankoModals() {
                	$(".lanko-modal-link").each(function (index) {

                		var modal = $('#' + $(this).attr('modalname'));

                		$(this).on("click", function () {
                			$('body').css({ 'overflow': 'hidden' });
                			// Show modal
                			modal.fadeIn();
                		});

                		// FIXME: Click on not modal area
                		modal.find(".lanko-better-modal__close-layer").click(function () {
                			modal.fadeOut();
                			$('body').css({ 'overflow': 'auto' });
                		});

                		// Close btn click
                		modal.find('.lanko-modal-content__close').click(function () {
                			// Hide modal
                			modal.fadeOut();
                			$('body').css({ 'overflow': 'auto' });
                		});
                	});

                	var modalTabs = new ModalTabs($('#sizes-modal'));
                }

                var ModalTabs = function () {
                	function ModalTabs(_modal) {
                		_classCallCheck(this, ModalTabs);

                		self = this;

                		this.modal = _modal;
                		this.navbar = this.modal.find(".lanko-modal-content__navbar");
                		this.navbarItems = this.modal.find(".lanko-modal-content__navbar .navbar-item");
                		this.contentTabs = this.modal.find(".content-row__tabs");
                		this.contentTabsItems = this.modal.find(".content-row__tab");
                		this.images = this.modal.find(".lanko-modal-content__tabs-image-container");
                		this.imagesItems = this.modal.find(".lanko-modal-content__tabs-image-container img");

                		this.currentTab = 0;

                		this.navbarItems.each(function () {
                			$(this).click(function () {
                				var chosenTab = $(this).index();

                				// Navbar highlitning
                				self.removeTabHighlight(self.currentTab);
                				self.addTabHighlight(chosenTab);

                				// Tab content handler
                				self.contentTabsItems.eq(self.currentTab).fadeOut("fast", function () {
                					self.contentTabsItems.eq(chosenTab).fadeIn("fast");
                				});

                				// Heading image hadler
                				self.imagesItems.eq(self.currentTab).fadeOut("fast", function () {
                					self.imagesItems.eq(chosenTab).fadeIn("fast");
                				});

                				self.currentTab = chosenTab;
                			});
                		});
                	}

                	_createClass(ModalTabs, [{
                		key: 'removeTabHighlight',
                		value: function removeTabHighlight(tabIndex) {
                			this.navbarItems.eq(tabIndex).removeClass("active");
                		}
                	}, {
                		key: 'addTabHighlight',
                		value: function addTabHighlight(tabIndex) {
                			this.navbarItems.eq(tabIndex).addClass("active");
                		}
                	}]);

                	return ModalTabs;
                }();

	           // Small modals end


                $(function () {

                	$(".modal-link").each(function (index) {

                		$(this).on("click", function () {
                			$('body').css({
                				'overflow': 'hidden'
                			});

                			var modal = $('[activator=' + $(this).attr('id') + "]");
                			// TODO: animate this
                			modal.css({
                				'display': 'block'
                			});

                			/// Click on not modal area
                			modal.click(function () {
                				modal.css({
                					'display': 'none'
                				});
                				$('body').css({
                					'overflow': 'auto'
                				});
                			});

                			// Close btn click
                			modal.find('.close').click(function () {
                				modal.css({
                					'display': 'none'
                				});
                				$('body').css({
                					'overflow': 'auto'
                				});
                			});
                		});
                	});
                });

                var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

                function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

                var PreviewSlider = function () {
                	function PreviewSlider(slider) {
                		var _this = this;

                		_classCallCheck(this, PreviewSlider);

                		var self = this;

                		this.slider = slider.find('.slider');
                		this.slides = this.slider.find('.slides');
                		this.slide = this.slides.find('.slide');
                		this.slidesAmount = this.slide.length;
                		this.currentSlide = 0;

                		this.previousSlide;

                		// Preview slider
                		this.previewSlider = slider.find('.preview-slider');
                		this.previewSliderSlides = this.previewSlider.find('.slides');
                		this.previewSliderSlide = this.previewSlider.find('.slide');
                		this.previewSliderSlidesAmount = this.previewSliderSlide.length;
                		this.previewCurrentSlide = 0;

                		// Init slider size
                		this.setSize();
                		// Click to slide left
                		this.slider.find('#left').click(function () {
                			_this.slideLeft();
                		});
                		// Click to slide right
                		this.slider.find('#right').click(function () {
                			_this.slideRight();
                		});

                		// Preview controls
                		this.previewSlider.find('#left').click(function () {
                			_this.previewSlideLeft();
                		});
                		this.previewSlider.find('#right').click(function () {
                			_this.previewSlideRight();
                		});

                		// TODO: rewrite when slides will be on margins
                		// TODO: add previous slide
                		this.previewSliderSlide.click(function () {
                			// Slide main slider
                			self.slideTo($(this).index());
                		});

                		// Adaptive sizing
                		$(window).resize(function () {
                			_this.setSize();
                			_this.slides.css({ 'margin-left': -_this.slider.width() * _this.currentSlide });
                		});
                	}

                	// Resize slider


                	_createClass(PreviewSlider, [{
                		key: 'setSize',
                		value: function setSize() {
                			this.slides.width(this.slider.width() * this.slide.length);
                			this.slide.width(this.slider.width());

                			this.previewSliderSlides.width(this.previewSliderSlide.outerWidth() * this.previewSliderSlidesAmount);
                		}
                		// Slide to destination slide

                	}, {
                		key: 'slideTo',
                		value: function slideTo(destinationSlide) {
                			this.previousSlide = this.currentSlide;

                			this.slides.animate({ 'margin-left': -this.slider.width() * destinationSlide }, 500);
                			this.currentSlide = destinationSlide;

                			// Remove border from previous slide
                			this.previewSliderSlide.eq(this.previousSlide).find('.image-container').removeClass('active');
                			// Add border to previous slide
                			this.previewSliderSlide.eq(this.currentSlide).find('.image-container').addClass('active');
                		}
                		// Slide left

                	}, {
                		key: 'slideLeft',
                		value: function slideLeft() {
                			this.currentSlide === 0 ? this.slideTo(this.slidesAmount - 1) : this.slideTo(this.currentSlide - 1);
                		}
                		// Slide right

                	}, {
                		key: 'slideRight',
                		value: function slideRight() {
                			this.currentSlide === this.slidesAmount - 1 ? this.slideTo(0) : this.slideTo(this.currentSlide + 1);

                			// TODO: add opportunity to slide preview slider when current slide of the bounds preview slider
                			// if (this.currentSlide + 1 > (Math.floor( this.previewSlider.width()/this.previewSliderSlide.outerWidth() ))) {
                			// 	this.previewSlideRight();
                			// }
                		}
                	}, {
                		key: 'previewSlideLeft',
                		value: function previewSlideLeft() {
                			if (this.previewCurrentSlide === 0) {
                				console.log("no slides there");
                				this.previewSliderSlides.animate({ 'margin-left': 0 }, 500);
                			} else {
                				this.previewCurrentSlide--;
                				this.previewSliderSlides.animate({ 'margin-left': -this.previewSlider.width() * this.previewCurrentSlide }, 500);
                			}
                		}
                	}, {
                		key: 'previewSlideRight',
                		value: function previewSlideRight() {
                			if (this.previewCurrentSlide === Math.floor(this.previewSliderSlides.width() / this.previewSlider.width()) + 1) {
                				console.log("no slides there");
                			} else {
                				if (this.previewSlider.width() * (this.previewCurrentSlide + 1) > this.previewSliderSlides.width() - this.previewSlider.width()) {
                					// Slide to edge
                					console.log("Slide to edge");
                					this.previewSliderSlides.animate({ 'margin-left': -(this.previewSliderSlides.width() - this.previewSlider.width() - 5) }, 500);
                				} else {
                					console.log("Just slide");
                					this.previewCurrentSlide++;
                					this.previewSliderSlides.animate({ 'margin-left': -this.previewSlider.width() * this.previewCurrentSlide }, 500);
                				}
                			}
                		}
                	}]);

                	return PreviewSlider;
                }();

                $(function () {

                	var previewSlider = new PreviewSlider($('.lanko-gallery-wrapper'));
                })

                var PreviewSliderOne = function () {
                	function PreviewSliderOne(slider) {
                		var _this = this;

                		_classCallCheck(this, PreviewSliderOne);

                		var self = this;

                		this.slider = slider.find('.slider');
                		this.slides = this.slider.find('.slides');
                		this.slide = this.slides.find('.slide');
                		this.slidesAmount = this.slide.length;
                		this.currentSlide = 0;

                		this.previousSlide;

                		// Preview slider
                		this.previewSliderOne = slider.find('.preview-slider');
                		this.previewSliderOneSlides = this.previewSliderOne.find('.slides');
                		this.previewSliderOneSlide = this.previewSliderOne.find('.slide');
                		this.previewSliderOneSlidesAmount = this.previewSliderOneSlide.length;
                		this.previewCurrentSlide = 0;

                		// Init slider size
                		this.setSize();
                		// Click to slide left
                		this.slider.find('#left').click(function () {
                			_this.slideLeft();
                		});
                		// Click to slide right
                		this.slider.find('#right').click(function () {
                			_this.slideRight();
                		});

                		// Preview controls
                		this.previewSliderOne.find('#left').click(function () {
                			_this.previewSlideLeft();
                		});
                		this.previewSliderOne.find('#right').click(function () {
                			_this.previewSlideROneight();
                		});

                		// TODO: rewrite when slides will be on margins
                		// TODO: add previous slide
                		this.previewSliderOneSlide.click(function () {
                			// Slide main slider
                			self.slideTo($(this).index());
                		});

                		// Adaptive sizing
                		$(window).resize(function () {
                			_this.setSize();
                			_this.slides.css({ 'margin-left': -_this.slider.width() * _this.currentSlide });
                		});
                	}

                	// Resize slider


                	_createClass(PreviewSliderOne, [{
                		key: 'setSize',
                		value: function setSize() {
                			this.slides.width(this.slider.width() * this.slide.length);
                			this.slide.width(this.slider.width());

                			this.previewSliderOneSlides.width(this.previewSliderOneSlide.outerWidth() * this.previewSliderOneSlidesAmount);
                		}
                		// Slide to destination slide

                	}, {
                		key: 'slideTo',
                		value: function slideTo(destinationSlide) {
                			this.previousSlide = this.currentSlide;

                			this.slides.animate({ 'margin-left': -this.slider.width() * destinationSlide }, 500);
                			this.currentSlide = destinationSlide;

                			// Remove border from previous slide
                			this.previewSliderOneSlide.eq(this.previousSlide).find('.image-container').removeClass('active');
                			// Add border to previous slide
                			this.previewSliderOneSlide.eq(this.currentSlide).find('.image-container').addClass('active');
                		}
                		// Slide left

                	}, {
                		key: 'slideLeft',
                		value: function slideLeft() {
                			this.currentSlide === 0 ? this.slideTo(this.slidesAmount - 1) : this.slideTo(this.currentSlide - 1);
                		}
                		// Slide right

                	}, {
                		key: 'slideRight',
                		value: function slideRight() {
                			this.currentSlide === this.slidesAmount - 1 ? this.slideTo(0) : this.slideTo(this.currentSlide + 1);

                			// TODO: add opportunity to slide preview slider when current slide of the bounds preview slider
                			// if (this.currentSlide + 1 > (Math.floor( this.previewSliderOne.width()/this.previewSliderOneSlide.outerWidth() ))) {
                			// 	this.previewSlideROneight();
                			// }
                		}
                	}, {
                		key: 'previewSlideLeft',
                		value: function previewSlideLeft() {
                			if (this.previewCurrentSlide === 0) {
                				console.log("no slides there");
                				this.previewSliderOneSlides.animate({ 'margin-left': 0 }, 500);
                			} else {
                				this.previewCurrentSlide--;
                				this.previewSliderOneSlides.animate({ 'margin-left': -this.previewSliderOne.width() * this.previewCurrentSlide }, 500);
                			}
                		}
                	}, {
                		key: 'previewSlideROneight',
                		value: function previewSlideROneight() {
                			if (this.previewCurrentSlide === Math.floor(this.previewSliderOneSlides.width() / this.previewSliderOne.width()) + 1) {
                				console.log("no slides there");
                			} else {
                				if (this.previewSliderOne.width() * (this.previewCurrentSlide + 1) > this.previewSliderOneSlides.width() - this.previewSliderOne.width()) {
                					// Slide to edge
                					console.log("Slide to edge");
                					this.previewSliderOneSlides.animate({ 'margin-left': -(this.previewSliderOneSlides.width() - this.previewSliderOne.width() - 5) }, 500);
                				} else {
                					console.log("Just slide");
                					this.previewCurrentSlide++;
                					this.previewSliderOneSlides.animate({ 'margin-left': -this.previewSliderOne.width() * this.previewCurrentSlide }, 500);
                				}
                			}
                		}
                	}]);

                	return PreviewSliderOne;
                }();

                $(function () {

                	var previewSliderOne = new PreviewSliderOne($('.audi-gallery-one'));
                });

                var PreviewSliderTwo = function () {
                	function PreviewSliderTwo(slider) {
                		var _this = this;

                		_classCallCheck(this, PreviewSliderTwo);

                		var self = this;

                		this.slider = slider.find('.slider');
                		this.slides = this.slider.find('.slides');
                		this.slide = this.slides.find('.slide');
                		this.slidesAmount = this.slide.length;
                		this.currentSlide = 0;

                		this.previousSlide;

                		// Preview slider
                		this.previewSliderTwo = slider.find('.preview-slider');
                		this.previewSliderTwoSlides = this.previewSliderTwo.find('.slides');
                		this.previewSliderTwoSlide = this.previewSliderTwo.find('.slide');
                		this.previewSliderTwoSlidesAmount = this.previewSliderTwoSlide.length;
                		this.previewCurrentSlide = 0;

                		// Init slider size
                		this.setSize();
                		// Click to slide left
                		this.slider.find('#left').click(function () {
                			_this.slideLeft();
                		});
                		// Click to slide right
                		this.slider.find('#right').click(function () {
                			_this.slideRight();
                		});

                		// Preview controls
                		this.previewSliderTwo.find('#left').click(function () {
                			_this.previewSlideLeft();
                		});
                		this.previewSliderTwo.find('#right').click(function () {
                			_this.previewSlideRTwoight();
                		});

                		// TODO: rewrite when slides will be on margins
                		// TODO: add previous slide
                		this.previewSliderTwoSlide.click(function () {
                			// Slide main slider
                			self.slideTo($(this).index());
                		});

                		// Adaptive sizing
                		$(window).resize(function () {
                			_this.setSize();
                			_this.slides.css({ 'margin-left': -_this.slider.width() * _this.currentSlide });
                		});
                	}

                	// Resize slider


                	_createClass(PreviewSliderTwo, [{
                		key: 'setSize',
                		value: function setSize() {
                			this.slides.width(this.slider.width() * this.slide.length);
                			this.slide.width(this.slider.width());

                			this.previewSliderTwoSlides.width(this.previewSliderTwoSlide.outerWidth() * this.previewSliderTwoSlidesAmount);
                		}
                		// Slide to destination slide

                	}, {
                		key: 'slideTo',
                		value: function slideTo(destinationSlide) {
                			this.previousSlide = this.currentSlide;

                			this.slides.animate({ 'margin-left': -this.slider.width() * destinationSlide }, 500);
                			this.currentSlide = destinationSlide;

                			// Remove border from previous slide
                			this.previewSliderTwoSlide.eq(this.previousSlide).find('.image-container').removeClass('active');
                			// Add border to previous slide
                			this.previewSliderTwoSlide.eq(this.currentSlide).find('.image-container').addClass('active');
                		}
                		// Slide left

                	}, {
                		key: 'slideLeft',
                		value: function slideLeft() {
                			this.currentSlide === 0 ? this.slideTo(this.slidesAmount - 1) : this.slideTo(this.currentSlide - 1);
                		}
                		// Slide right

                	}, {
                		key: 'slideRight',
                		value: function slideRight() {
                			this.currentSlide === this.slidesAmount - 1 ? this.slideTo(0) : this.slideTo(this.currentSlide + 1);

                			// TODO: add opportunity to slide preview slider when current slide of the bounds preview slider
                			// if (this.currentSlide + 1 > (Math.floor( this.previewSliderTwo.width()/this.previewSliderTwoSlide.outerWidth() ))) {
                			// 	this.previewSlideRTwoight();
                			// }
                		}
                	}, {
                		key: 'previewSlideLeft',
                		value: function previewSlideLeft() {
                			if (this.previewCurrentSlide === 0) {
                				console.log("no slides there");
                				this.previewSliderTwoSlides.animate({ 'margin-left': 0 }, 500);
                			} else {
                				this.previewCurrentSlide--;
                				this.previewSliderTwoSlides.animate({ 'margin-left': -this.previewSliderTwo.width() * this.previewCurrentSlide }, 500);
                			}
                		}
                	}, {
                		key: 'previewSlideRTwoight',
                		value: function previewSlideRTwoight() {
                			if (this.previewCurrentSlide === Math.floor(this.previewSliderTwoSlides.width() / this.previewSliderTwo.width()) + 1) {
                				console.log("no slides there");
                			} else {
                				if (this.previewSliderTwo.width() * (this.previewCurrentSlide + 1) > this.previewSliderTwoSlides.width() - this.previewSliderTwo.width()) {
                					// Slide to edge
                					console.log("Slide to edge");
                					this.previewSliderTwoSlides.animate({ 'margin-left': -(this.previewSliderTwoSlides.width() - this.previewSliderTwo.width() - 5) }, 500);
                				} else {
                					console.log("Just slide");
                					this.previewCurrentSlide++;
                					this.previewSliderTwoSlides.animate({ 'margin-left': -this.previewSliderTwo.width() * this.previewCurrentSlide }, 500);
                				}
                			}
                		}
                	}]);

                	return PreviewSliderTwo;
                }();

                $(function () {

                	var previewSliderTwo = new PreviewSliderTwo($('.audi-gallery-two'));
                });

                var PreviewSliderThree = function () {
                	function PreviewSliderThree(slider) {
                		var _this = this;

                		_classCallCheck(this, PreviewSliderThree);

                		var self = this;

                		this.slider = slider.find('.slider');
                		this.slides = this.slider.find('.slides');
                		this.slide = this.slides.find('.slide');
                		this.slidesAmount = this.slide.length;
                		this.currentSlide = 0;

                		this.previousSlide;

                		// Preview slider
                		this.previewSliderThree = slider.find('.preview-slider');
                		this.previewSliderThreeSlides = this.previewSliderThree.find('.slides');
                		this.previewSliderThreeSlide = this.previewSliderThree.find('.slide');
                		this.previewSliderThreeSlidesAmount = this.previewSliderThreeSlide.length;
                		this.previewCurrentSlide = 0;

                		// Init slider size
                		this.setSize();
                		// Click to slide left
                		this.slider.find('#left').click(function () {
                			_this.slideLeft();
                		});
                		// Click to slide right
                		this.slider.find('#right').click(function () {
                			_this.slideRight();
                		});

                		// Preview controls
                		this.previewSliderThree.find('#left').click(function () {
                			_this.previewSlideLeft();
                		});
                		this.previewSliderThree.find('#right').click(function () {
                			_this.previewSlideRThreeight();
                		});

                		// TODO: rewrite when slides will be on margins
                		// TODO: add previous slide
                		this.previewSliderThreeSlide.click(function () {
                			// Slide main slider
                			self.slideTo($(this).index());
                		});

                		// Adaptive sizing
                		$(window).resize(function () {
                			_this.setSize();
                			_this.slides.css({ 'margin-left': -_this.slider.width() * _this.currentSlide });
                		});
                	}

                	// Resize slider


                	_createClass(PreviewSliderThree, [{
                		key: 'setSize',
                		value: function setSize() {
                			this.slides.width(this.slider.width() * this.slide.length);
                			this.slide.width(this.slider.width());

                			this.previewSliderThreeSlides.width(this.previewSliderThreeSlide.outerWidth() * this.previewSliderThreeSlidesAmount);
                		}
                		// Slide to destination slide

                	}, {
                		key: 'slideTo',
                		value: function slideTo(destinationSlide) {
                			this.previousSlide = this.currentSlide;

                			this.slides.animate({ 'margin-left': -this.slider.width() * destinationSlide }, 500);
                			this.currentSlide = destinationSlide;

                			// Remove border from previous slide
                			this.previewSliderThreeSlide.eq(this.previousSlide).find('.image-container').removeClass('active');
                			// Add border to previous slide
                			this.previewSliderThreeSlide.eq(this.currentSlide).find('.image-container').addClass('active');
                		}
                		// Slide left

                	}, {
                		key: 'slideLeft',
                		value: function slideLeft() {
                			this.currentSlide === 0 ? this.slideTo(this.slidesAmount - 1) : this.slideTo(this.currentSlide - 1);
                		}
                		// Slide right

                	}, {
                		key: 'slideRight',
                		value: function slideRight() {
                			this.currentSlide === this.slidesAmount - 1 ? this.slideTo(0) : this.slideTo(this.currentSlide + 1);

                			// TODO: add opportunity to slide preview slider when current slide of the bounds preview slider
                			// if (this.currentSlide + 1 > (Math.floor( this.previewSliderThree.width()/this.previewSliderThreeSlide.outerWidth() ))) {
                			// 	this.previewSlideRThreeight();
                			// }
                		}
                	}, {
                		key: 'previewSlideLeft',
                		value: function previewSlideLeft() {
                			if (this.previewCurrentSlide === 0) {
                				console.log("no slides there");
                				this.previewSliderThreeSlides.animate({ 'margin-left': 0 }, 500);
                			} else {
                				this.previewCurrentSlide--;
                				this.previewSliderThreeSlides.animate({ 'margin-left': -this.previewSliderThree.width() * this.previewCurrentSlide }, 500);
                			}
                		}
                	}, {
                		key: 'previewSlideRThreeight',
                		value: function previewSlideRThreeight() {
                			if (this.previewCurrentSlide === Math.floor(this.previewSliderThreeSlides.width() / this.previewSliderThree.width()) + 1) {
                				console.log("no slides there");
                			} else {
                				if (this.previewSliderThree.width() * (this.previewCurrentSlide + 1) > this.previewSliderThreeSlides.width() - this.previewSliderThree.width()) {
                					// Slide to edge
                					console.log("Slide to edge");
                					this.previewSliderThreeSlides.animate({ 'margin-left': -(this.previewSliderThreeSlides.width() - this.previewSliderThree.width() - 5) }, 500);
                				} else {
                					console.log("Just slide");
                					this.previewCurrentSlide++;
                					this.previewSliderThreeSlides.animate({ 'margin-left': -this.previewSliderThree.width() * this.previewCurrentSlide }, 500);
                				}
                			}
                		}
                	}]);

                	return PreviewSliderThree;
                }();

                $(function () {

                	var previewSliderThree = new PreviewSliderThree($('.audi-gallery-three'));
                });


                $(function () {

                	// Change car image on control click
                	$('#changecar-a5design').click(function () {
                		$(this).addClass('active');
                		$('#changecar-a5sport').removeClass('active');

                		$('.changing-cars-wrapper').find('.cars-part .cars img').attr("src", "//img.audi-kiev.com.ua/data/content/models/a5_sportback/1920x1080_Interieur_A5Sportback_2.jpg");
                	});

                	$('#changecar-a5sport').click(function () {
                		$(this).addClass('active');
                		$('#changecar-a5design').removeClass('active');

                		$('.changing-cars-wrapper').find('.cars-part .cars img').attr("src", "//img.audi-kiev.com.ua/data/content/models/a5_sportback/1920x1080_Interieur_A5Sportback_1.jpg");
                	});
                });
