(function($){
	"use strict";

/*
-----------------------------------------------------
	Header Sticky
-----------------------------------------------------
*/
	$(window).on('scroll',function() {
		if ($(this).scrollTop() > 120){  
			$('.navbar-area').addClass("sticky");
		}
		else{
			$('.navbar-area').removeClass("sticky");
		}
	});
/*
-----------------------------------------------------
	Hover Button Effect
-----------------------------------------------------
*/
	let toolTip = document.getElementById('tooltip');
	if (toolTip) {
		window.addEventListener('mousemove', toolTipXY);
	}
	function toolTipXY(e) {
		let x = e.clientX,
			y = e.clientY;

		if (toolTip) {
			toolTip.style.top = (y + 0) + 'px';
			toolTip.style.left = (x + 0) + 'px';
		}
	}
/*
-----------------------------------------------------
	 Team Slides
-----------------------------------------------------
*/
	 $('.team-card').owlCarousel({
		nav: true,
		loop: true,
		dots: false,
		margin: 10,
		autoplay: true,
		autoplayHoverPause: true,
		navText: [
			"<i class='fi fi-tr-arrow-small-left' ></i>",
			"<i class='fi fi-tr-arrow-small-right'></i>"
		],
		responsive: {
			0: {
				items: 1
			},
			576: {
				items: 2
			},
			768: {
				items: 1
			},
			992: {
				items: 3
			},
			1200: {
				items: 2
			}
		}
	});
/*
-----------------------------------------------------
	 developes Slides
-----------------------------------------------------
*/
	 $('.developes-card').owlCarousel({
		nav: false,
		loop: true,
		dots: false,
		margin: 10,
		autoplay: true,
		autoplayHoverPause: true,
		navText: [
			"<i class='fi fi-tr-arrow-small-left' ></i>",
			"<i class='fi fi-tr-arrow-small-right'></i>"
		],
		responsive: {
			0: {
				items: 1
			},
			576: {
				items: 2
			},
			768: {
				items: 2
			},
			992: {
				items: 3
			},
			1200: {
				items: 3
			}
		}
	});
/*
-----------------------------------------------------
	 Testimonial Slides
-----------------------------------------------------
*/
	 $('.testimonial-content').owlCarousel({
		nav: true,
		loop: true,
		dots: false,
		margin: 20,
		autoplay: true,
		autoplayHoverPause: true,
		smartSpeed:1000,
		navText: [
			"<i class='fi fi-tr-arrow-left'></i>",
			"<i class='fi fi-tr-arrow-right'></i>"
		],
		responsive: {
			0: {
				items: 1
			},
			576: {
				items: 1
			},
			768: {
				items: 2
			},
			992: {
				items: 2
			},
			1200: {
				items: 3

			}
		}
	});
/*
-----------------------------------------------------
	Workflow Slides
-----------------------------------------------------
*/
	 $('.workflow-wrapper').owlCarousel({
		nav: false,
		loop: true,
		dots: false,
		margin: 20,
		autoplay: true,
		autoplayHoverPause: true,
		smartSpeed:1000,
		responsive: {
			0: {
				items: 1
			},
			576: {
				items: 1
			},
			768: {
				items: 2
			},
			992: {
				items: 2
			},
			1200: {
				items: 2

			}
		}
	});
/*
-----------------------------------------------------
	 Testimonial Slides 2
-----------------------------------------------------
*/
	 $('.testimonial-content-2').owlCarousel({
		nav: false,
		loop: true,
		dots: true,
		margin: 20,
		autoplay: true,
		autoplayHoverPause: true,
		smartSpeed:1000,
		responsive: {
			0: {
				items: 1
			},
			576: {
				items: 2
			},
			768: {
				items: 1
			},
			992: {
				items: 1
			},
			1200: {
				items: 2

			}
		}
	});
/*
-----------------------------------------------------
	Popup Image
-----------------------------------------------------
*/
	$('.popup-btn').magnificPopup({
		type: 'image',
		gallery:{
			enabled:true
		}
	});

/*
-----------------------------------------------------
	Counter Js
-----------------------------------------------------
*/
	if ("IntersectionObserver" in window) {
	let counterObserver = new IntersectionObserver(function (entries, observer) {
		entries.forEach(function (entry) {
			if (entry.isIntersecting) {
			let counter = entry.target;
			let target = parseInt(counter.innerText);
			let step = target / 200;
			let current = 0;
			let timer = setInterval(function () {
				current += step;
				counter.innerText = Math.floor(current);
				if (parseInt(counter.innerText) >= target) {
				clearInterval(timer);
				}
			}, 10);
			counterObserver.unobserve(counter);
			}
		});
	});

	let counters = document.querySelectorAll(".counter-num");
	counters.forEach(function (counter) {
		counterObserver.observe(counter);
	});
    }

/*
-----------------------------------------------------
	Gallery MixItUp 
-----------------------------------------------------
*/
	$(function () {
		var filterList = {
			init: function () {
				$('.item-grid').mixItUp({
					selectors: {
					target: '.item',
					filter: '.filter'	
				},
				load: {
				  filter: 'all'
				}     
				});								
			}
		};
		filterList.init();
	});	

/*
-----------------------------------------------------
	Popup Video
-----------------------------------------------------
*/
	$('.popup-youtube').magnificPopup({
		disableOn: 320,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});
/*
-----------------------------------------------------
	Input Plus & Minus Number JS
-----------------------------------------------------
*/
	$('.input-counter').each(function() {
		var spinner = jQuery(this),
		input = spinner.find('input[type="text"]'),
		btnUp = spinner.find('.plus-btn'),
		btnDown = spinner.find('.minus-btn'),
		min = input.attr('min'),
		max = input.attr('max');
		
		btnUp.on('click', function() {
			var oldValue = parseFloat(input.val());
			if (oldValue >= max) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue + 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});
		btnDown.on('click', function() {
			var oldValue = parseFloat(input.val());
			if (oldValue <= min) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue - 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});
	});
/*
-----------------------------------------------------
	Meetai Testimonial
-----------------------------------------------------
*/
	
	$('.aithm-testimonial-navigator').owlCarousel({
		loop: true,
		nav: true,
		dots: false,
		autoplayHoverPause: true,
		autoplay: true,
		items: 1,
		navText: [
			"<i class='bx bx-left-arrow-alt'></i>",
			"<i class='bx bx-right-arrow-alt'></i>"
		]
	});

/*
-----------------------------------------------------
	Faq Section
-----------------------------------------------------
*/
	const faqItems = document.querySelectorAll('.faq-item');

	faqItems.forEach(item => {
	const question = item.querySelector('.faq-question');
	const answer = item.nextElementSibling;
	const icon = item.querySelector('i');
	
	item.addEventListener('click', () => {
		faqItems.forEach(otherItem => {
		if (otherItem !== item) {
			const otherAnswer = otherItem.nextElementSibling;
			const otherIcon = otherItem.querySelector('i');
	
			otherAnswer.classList.remove('active');
			otherIcon.classList.remove('active');
			otherAnswer.style.maxHeight = "0";
		}
		});
	
		answer.classList.toggle('active');
		icon.classList.toggle('active');
		if (answer.classList.contains('active')) {
		answer.style.maxHeight = answer.scrollHeight + "px";
		} else {
		answer.style.maxHeight = "0";
		}
	});
	});

/*
-----------------------------------------------------
	Aos Animation
-----------------------------------------------------
*/
	AOS.init({
		once: true,
		offset: 200,
		duration: 2000,
	});

/*
-----------------------------------------------------
	Go to Top
-----------------------------------------------------
*/
	$(function(){
		// Scroll Event
		$(window).on('scroll', function(){
			var scrolled = $(window).scrollTop();
			if (scrolled > 600) $('.go-top').addClass('active');
			if (scrolled < 600) $('.go-top').removeClass('active');
		});  
		// Click Event
		$('.go-top').on('click', function() {
			$("html, body").animate({ scrollTop: "0" },  500);
		});
	});

/*
-----------------------------------------------------
	Nice Select
-----------------------------------------------------
*/
	$('select').niceSelect();

	

	
   var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            autoHeight: true,
            loop: true,
            effect: "fade",
            autoplay: {
                delay: 10000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: { 
                1199: { slidesPerView: 1 },
                991: { slidesPerView: 1 },
                767: { slidesPerView: 1 },
                575: { slidesPerView: 1 },
                0: { slidesPerView: 1 },
            },
        });
        
        var clientSlider = new Swiper(".client-slider", {
            spaceBetween: 20,
            speed: 1300,
            loop: true,
            centeredSlides: false,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            slidesPerView: 9,
            breakpoints: {
                1199: { slidesPerView: 9 },
                991: { slidesPerView: 6 },
                767: { slidesPerView: 4 },
                575: { slidesPerView: 3 },
                0: { slidesPerView: 2 },
            },
        });



    $('#subscribe-form').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        let form = $(this);
        let messageBox = $('#subscribe-message');
        let submitButton = $("#subscribe-btn");
        let btnText = $("#btn-text");
        let btnSpinner = $("#btn-spinner");

        // Prevent multiple submissions
        if (submitButton.attr('disabled')) {
            return; // Exit if already submitting
        }

        // Clear previous messages
        messageBox.empty();

        // Disable button and show loading state
        submitButton.attr("disabled", true)
            .attr("aria-disabled", "true"); // Accessibility
        btnText.text("Subscribing...");
        btnSpinner.removeClass("d-none");

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                console.log('Response:', response);
                if (response.success) {
                    messageBox.html(`<div class="alert alert-success" role="alert">${response.message}</div>`);
                    form[0].reset(); // Reset form fields
                    form.find('input:first').focus(); // Focus back to first input for accessibility
                } else {
                    // Handle multiple errors if returned
                    let errorMessage = response.errors && Array.isArray(response.errors) 
                        ? response.errors.join('<br>') 
                        : response.message || 'Subscription failed!';
                    messageBox.html(`<div class="alert alert-danger" role="alert">${errorMessage}</div>`);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Something went wrong!';
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors && Array.isArray(xhr.responseJSON.errors)) {
                        errorMsg = xhr.responseJSON.errors.join('<br>');
                    } else if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                }
                messageBox.html(`<div class="alert alert-danger" role="alert">${errorMsg}</div>`);
            },
            complete: function () {
                // Reset button state
                submitButton.attr("disabled", false)
                    .removeAttr("aria-disabled");
                btnText.text("Subscribe");
                btnSpinner.addClass("d-none");
            }
        });
    });

    

 
    $('#contactForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let messageBox = $('#msgSubmit');
        let submitButton = form.find('.quote-us-button');
        let btnText = submitButton.find("span");
        let btnIcon = submitButton.find("i");

        if (submitButton.attr('disabled')) return;

        messageBox.empty().addClass('hidden');
        $('.error-message').text('');

        submitButton.attr("disabled", true).attr("aria-disabled", "true");
        btnText.text("Sending...");
        btnIcon.removeClass("bx-paper-plane").addClass("bx-loader bx-spin");

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                console.log('Success Response:', response); // Debug
                if (response.success) {
                    let message = response.subscription_error 
                        ? `${response.message} (${response.subscription_error})`
                        : response.message;
                    messageBox.html(`<div class="alert alert-success" role="alert">${message}</div>`).removeClass("hidden");
                    form[0].reset();
                    form.find('input:first').focus();
                    setTimeout(() => messageBox.addClass("hidden").empty(), 3000);
                }
            },
            error: function (xhr) {
                console.log('Error Response:', xhr.responseJSON); // Debug
                let response = xhr.responseJSON || {};
                let errorMessage = response.message || 'Something went wrong!';

                if (response.errors) {
                    if (Array.isArray(response.errors)) {
                        // Handle array errors (e.g., general exceptions)
                        errorMessage = response.errors.join('<br>');
                    } else if (typeof response.errors === 'object') {
                        // Handle object errors (validation)
                        $.each(response.errors, (field, errors) => {
                            form.find(`.error-message[data-field="${field}"]`).text(errors[0]);
                        });
                    }
                }

                messageBox.html(`<div class="alert alert-danger" role="alert">${errorMessage}</div>`).removeClass("hidden");
                setTimeout(() => messageBox.addClass("hidden").empty(), 3000);
            },
            complete: function () {
                submitButton.attr("disabled", false).removeAttr("aria-disabled");
                btnText.text("Send Message");
                btnIcon.removeClass("bx-loader bx-spin").addClass("bx-paper-plane");
            }
        });
    });




 var $grid = $('.project-list').isotope({
            itemSelector: '.project-item',
            layoutMode: 'fitRows'
        });

        $('.social-ads-project-category-btn').on('click', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });

            // Add active class to the current button
            $('.social-ads-project-category-btn').removeClass('active');
            $(this).addClass('active');
        });
        
        $( "#tabs" ).tabs();

        
}(jQuery));