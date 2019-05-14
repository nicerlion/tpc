(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		$('.tpc-details').live('click', function(){
			$(this).find('.hover-popup').slideToggle();
		});

		// Style Quiz

		// Style Quiz Navigation

		$('#quizNextSizeButton').click(function(e){
			e.preventDefault();
			$('#typeSelection').removeClass('display-none');
			$(this).parent().addClass('display-none');
			$('html, body').animate({
				scrollTop: $("#typeSelection h5").offset().top
			}, 1000);
		});
		$('#quizNextTypeButton').click(function(e){
			e.preventDefault();
			$('#colorSelection').removeClass('display-none');
			$(this).parent().addClass('display-none');
			$('html, body').animate({
				scrollTop: $("#colorSelection h5").offset().top
			}, 1000);
		});
		
		// Select size
		var purseSize = $('.tpc-purse-selection input[type=checkbox]');
		purseSize.val(this.checked);
		purseSize.change(function() {

			$('.error-size').addClass('display-none');

			if(this.checked) {
				$(this).prop('checked');
				$(this).closest('.tpc-purse-selection').addClass('selected');
			}
			else{
				$(this).closest('.tpc-purse-selection').removeClass('selected');
			}
			purseSize.val(this.checked);        
		});

		// Select type
		var purseType = $('.tpc-purse-type input[type=checkbox]');
		purseType.val(this.checked);
		purseType.change(function() {
			
			$('.error-type').addClass('display-none');

			if(this.checked) {
				$(this).prop('checked');
				$(this).closest('.tpc-purse-type').addClass('selected');
			}
			else{
				$(this).closest('.tpc-purse-type').removeClass('selected');
			}
			purseType.val(this.checked);        
		});

		// Select color
		var purseColor = $('.tpc-color-selection input[type=checkbox]');
		purseColor.val(this.checked);
		purseColor.change(function() {

			$('.error-color').addClass('display-none');

			if(this.checked) {
				$(this).prop('checked');
				$(this).closest('.tpc-color-selection').addClass('selected');
				$(this).next('.quiz-color-text').addClass('selected');
			}
			else{
				$(this).closest('.tpc-color-selection').removeClass('selected');
			}
			purseColor.val(this.checked);        
		});

		// Form submission
		$('#theQuiz').submit(function(){

			var selectedSize = [],
			selectedType = [],
			selectedColor = [];
		
			$('.tpc-purse-selection input:checked').each(function(){
				selectedSize.push($(this).attr('size'));
			});
			$('.tpc-purse-type input:checked').each(function(){
				selectedType.push($(this).attr('ptype'));
			});
			$('.tpc-color-selection input:checked').each(function(){
				selectedColor.push($(this).attr('color'));
			});

			// Purse selection validation
			var error = 'no';

			if(selectedSize.length <= 0){
				$('.error-size').removeClass('display-none');
				error = 'yes';
			}
			if(selectedType.length <= 0){
				$('.error-type').removeClass('display-none');
				error = 'yes';
			}
			if(selectedColor.length <= 0){
				$('.error-color').removeClass('display-none');
				error = 'yes';
			}
			if( error == 'yes' ){
				$('.quizError').removeClass('display-none');
				return (false);
			}
			
			// Converting array to string
			var selectedSizeToString = selectedSize.join();
			var selectedTypeToString =  selectedType.join();
			var selectedColorToString = selectedColor.join();

			sessionStorage.setItem('purseSize',selectedSizeToString);
			sessionStorage.setItem('purseType',selectedTypeToString);
			sessionStorage.setItem('purseColor',selectedColorToString);
			localStorage.setItem('upSellhasBeenOpened',false);

			return (true);

		})

		$('.quiz-selection-container').click( function(){
			$('.quizError').addClass('display-none');
		});

		// Add contact info to trigger the pop up
		$('.contact-us').attr('data-toggle','modal');
		$('.contact-us').attr('data-target','#contactUsModal');

		// Upsell page
		$('.tpc-black-sm-button a').live('click',function(){
			localStorage.setItem('upSellhasBeenOpened',false);
		});
		
		$('.tpc-membership-button a').live('click',function(){
			localStorage.setItem('upSellhasBeenOpened',false);
			localStorage.setItem('productCartMembership', $('#TpcProductId').val());
		});

		$('.upsell-submit').live( 'click', function(){
			if ($(this).attr('data-toggle')) {
				jQuery("#tpc-script").html("<style>#place-order-container{display: block !important;} .upsell-btn{display: none !important;}</style>");
				localStorage.setItem('upSellhasBeenOpened', true);
			}
		});
		$('#selectSubmit').live('click', function () {
			if ($(this).attr('data-toggle')) {
				jQuery("#tpc-script").html("<style>#place-order-container{display: block !important;} .upsell-btn{display: none !important;}</style>");
				localStorage.setItem('upSellhasBeenOpened', true);
			}
		});

		function getQueryString() {
			let search = window.location.search.substring(1);
			return search ? JSON.parse(
				'{"' + search.replace(/&/g, '","').replace(/=/g, '":"') + '"}',
				function (key, value) { return key === "" ? value : decodeURIComponent(value) }
			): {};
		}

		function setCookie(name, value, days) {
			var expires = "";
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				expires = "; expires=" + date.toUTCString();
			}
			document.cookie = name + "=" + (value || "") + expires + "; path=/";
		}

		function getCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}

		function eraseCookie(name) {
			document.cookie = name + '=; Max-Age=-99999999;';
		}

		(function () {
			let queryData = getQueryString();
			let referers = '';
			if (queryData.click_id) {
				if (getCookie('refererClickID')) {
					eraseCookie('refererClickID');
				}
				setCookie('refererClickID', queryData.click_id, 30);
			}
			for (let refererParameter in queryData) {
				if (!getCookie(refererParameter)) {
					setCookie(refererParameter, queryData[refererParameter], 30);
					referers += `${refererParameter},`;
				}
			}
			if (referers) {
				window.localStorage.setItem('PSRID', referers);
			}
			// setCookie('PSRID', referers, 30);
		})();
	});
	
})(jQuery, this);
