var hts = 0;
var fb_dd_t = 0;
var wishlist = new Array();

$(function()
{
	$('#srf-pc').focus(function()
	{
		$(this).hide();
		$('#srf-ph').show().focus();
	});
	$('#srf-ph').blur(function()
	{
		$(this).hide();
		$('#srf-pc').show();
	});
	$('#srf-e').focus(function()
	{
		if ($(this).val() == 'Enter Email') $(this).val('');
	}).blur(function()
	{
		if ($(this).val() == '') $(this).val('Enter Email');
	});
	
	$('.sr-i-back').click(function(e){
		e.preventDefault();
		history.go(-1);
	});
	$('.clr2 .clr2-slider-ct a').hover(function(){
		$('span', $(this)).show();
	},function(){
		$('span', $(this)).hide();
	});
	
	if ($.cookie('wishlist') != null && $.cookie('wishlist') != '')
	{	
		wishlist = $.evalJSON($.cookie('wishlist'));
		$.each(wishlist, function(k,v)
		{
			$('.wl-items').append(v.html);
		});
		if ($('.wl-items li').size() > 0) 
		{
			$('.wl-items-replacement').hide();
			$('.wl-items-wrapp').show();
		}
	}
	
	$('.wl-items li span').live('click',function()
	{
		var p = $(this).parents('li:first');
		var course_id = $('input', p).val();
		
		var wishlistTemp = new Array();
		$.each(wishlist, function(k,v)
		{
			if (v.course_id != course_id)
			{
				wishlistTemp.push(wishlist[k]);
			}
		});
		wishlist = wishlistTemp;
		$.cookie('wishlist', $.toJSON(wishlist));
		p.remove();
		
		if ($('.wl-items li').size() == 0) 
		{
			$('.wl-items-wrapp').hide();
			$('.wl-items-replacement').show();
		}
	});
	
	$('.gcl-wl').click(function(e)
	{
		e.preventDefault();
		
		var title = $(this).attr('title');
		var course_id = $(this).attr('rel');
		if (title.length > 28) title = title.substr(0, 28) + ' ..';
		
		wishlistItem(title, course_id);
	});
	function wishlistItem(title, course_id)
	{
		if ($('.wl-items input[value='+ course_id +']').size() > 0) return;
		if ($('.wl-items-wrapp').css('display') == 'none') 
		{
			$('.wl-items-replacement').hide();
			$('.wl-items-wrapp').show();
		}
		var html = '<li>' 
			+ title 
			+ '<span></span>' 
			+ '<input type="hidden" name="courses[]" value="' + course_id + '" />'  
			+ '</li>';
		
		$('.wl-items').append(html);
		
		// persistent
		wishlist.push({ course_id: course_id, html: html });
		$.cookie('wishlist', $.toJSON(wishlist), { path: '/' });
	}
	
	$('.clr2-slider-nr span').click(function()
	{
		var a = $('.ct-slider-content-group.active');
		var n = a.next('.ct-slider-content-group');
		var i = $('.ct-slider-content-group').index(n);
		if (i == -1) n = $('.ct-slider-content-group:first');
		
		a.hide('slide', { direction: 'left' }, 500, function(){
			$(this).removeClass('active');
			n.show('slide', { direction: 'right' }, 500, function(){
				$(this).addClass('active');
			});
		});
	});
	
	$('.clr2-slider-nl span').click(function()
	{
		var a = $('.ct-slider-content-group.active');
		var p = a.prev('.ct-slider-content-group');
		var i = $('.ct-slider-content-group').index(p);
		if (i == -1) p = $('.ct-slider-content-group:last');
		
		a.hide('slide', { direction: 'right' }, 500, function(){
			$(this).removeClass('active');
			p.show('slide', { direction: 'left' }, 500, function(){
				$(this).addClass('active');
			});
		});
	});
	
	$('.EditAccountDetails').click(function()
	{
		$('.sr-ad-r3').show();
		if ($('.sr-ad-r3 form').size() == 0)
		{
			location.reload();
		}
	});
	
	if (document.location.hash == '#EditAccountDetails')
	{
		if ($('.sr-ad-r3').css('display') == 'none')
		{
			$('.sr-ad-r3').show();
		}
		location = document.location.hash;
	}
	
	$('.EditAccountDetailsCancel').click(function()
	{
		$('.sr-ad-r3').hide();
	});
	$('.ItemCountPerPage select').change(function()
	{
		var p = $(this).parents('.ItemCountPerPage:first');
		document.location = $('input[name=ItemCountPerPageUri]', p).val() + $(this).val();
	});
	$('li.course-clr3-tc1').click(function(e){
		e.preventDefault();
		if ($(this).is('.course-clr3-tc1-active')) return;
		
		var t = $(this).attr('rel');
		$('.course-clr3-c').removeClass('course-clr3-c-active');
		$(t).addClass('course-clr3-c-active');
		
		$('.course-clr3-tc2').removeClass('course-clr3-tc2-active');
		$('.course-clr3-tc3').removeClass('course-clr3-tc2-active');
		$(this).addClass('course-clr3-tc1-active');
	});
	
	$('li.course-clr3-tc2').click(function(e){
		e.preventDefault();
		if ($(this).is('.course-clr3-tc2-active')) return;
		
		var t = $(this).attr('rel');
		$('.course-clr3-c').removeClass('course-clr3-c-active');
		$(t).addClass('course-clr3-c-active');
		
		$('.course-clr3-tc1').removeClass('course-clr3-tc1-active');
		$('.course-clr3-tc3').removeClass('course-clr3-tc2-active');
		$(this).addClass('course-clr3-tc2-active');
	});
	
	$('li.course-clr3-tc3').click(function(e){
		e.preventDefault();
		if ($(this).is('.course-clr3-tc2-active')) return;
		
		var t = $(this).attr('rel');
		$('.course-clr3-c').removeClass('course-clr3-c-active');
		$(t).addClass('course-clr3-c-active');
		
		$('.course-clr3-tc1').removeClass('course-clr3-tc1-active');
		$('.course-clr3-tc2').removeClass('course-clr3-tc2-active');
		$(this).addClass('course-clr3-tc2-active');
	});
	
	$('li.clr3-tc1').click(function(e){
		e.preventDefault();
		if ($(this).is('.clr3-tc1-active')) return;
		
		$('.clr3-tc2').removeClass('clr3-tc2-active');
		$(this).addClass('clr3-tc1-active');
	});
	
	$('li.clr3-tc2').click(function(e){
		e.preventDefault();
		if ($(this).is('.clr3-tc2-active')) return;
		
		$('.clr3-tc1').removeClass('clr3-tc1-active');
		$(this).addClass('clr3-tc2-active');
	});
	
	$('.fb-dropdown-container .fb-input').click(function()
	{
		$('.fb-dd-content').hide();
		var p = $(this).parents('.fb-dropdown-container:first');
		
		$(this).blur();
		$('.fb-dd-content', p).show();
		$('.fb-dd-content', p).scrollTop($(".fb-dd-content ul li.active", p).offset().top - $(".fb-dd-content", p).offset().top);
		$(document).keyup(function(e)
		{
			/* debug
			 * console.log(String.fromCharCode(e.keyCode));
			 */
			
			var key = String.fromCharCode(e.keyCode);
			var findLetter = $(".fb-dd-content ul li:contains(" + key + "):first", p);
			var resetLetter = $(".fb-dd-content ul li:contains(A):first", p);
			
			if (findLetter.size() > 0)
			{
				$('.fb-dd-content', p).scrollTop(resetLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$('.fb-dd-content', p).scrollTop(findLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$(".fb-dd-content ul li.active", p).removeClass('active');
				findLetter.addClass('active');
			}
		});
	});
	$('.fb-dropdown-container .fb-dd-arrow').click(function()
	{
		$('.fb-dd-content').hide();
		var p = $(this).parents('.fb-dropdown-container:first');
		
		$('.fb-input', p).addClass('i-focus');
		$('.fb-dd-content', p).show();
		$('.fb-dd-content', p).scrollTop($(".fb-dd-content ul li.active", p).offset().top - $(".fb-dd-content", p).offset().top);
		$(document).keyup(function(e)
		{
			/* debug
			 * console.log(String.fromCharCode(e.keyCode));
			 */
			
			var key = String.fromCharCode(e.keyCode);
			var findLetter = $(".fb-dd-content ul li:contains(" + key + "):first", p);
			var resetLetter = $(".fb-dd-content ul li:contains(A):first", p);
			
			if (findLetter.size() > 0)
			{
				$('.fb-dd-content', p).scrollTop(resetLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$('.fb-dd-content', p).scrollTop(findLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$(".fb-dd-content ul li.active", p).removeClass('active');
				findLetter.addClass('active');
			}
		});
	});
	$('.fb-dd-content ul li').click(function()
	{
		var p = $(this).parents('.fb-dropdown-container:first');
		var rel_id = $(this).attr('rel');
		
		clearTimeout(fb_dd_t);
		
		// here !!!
		// here starts the code for the GMAP MLS dropdowns !!!!
		if(p.attr('id')=='location')
		{
			$('input[name=sell_location]').val(rel_id);
		}
		if(p.attr('id')=='beds')
		{
			$('input[name=sell_beds]').val(rel_id);
		}
		if(p.attr('id')=='baths')
		{
			$('input[name=sell_baths]').val(rel_id);
		}
		if(p.attr('id')=='price')
		{
			$('input[name=sell_price]').val(rel_id);
		}
		
		//this is for the quick search on home page !
		if(p.attr('id')=='pprice')
		{
			$('input[name=search_sell_price]').val(rel_id);
			$('input[name=pprice]').val(rel_id);
		}
		if(p.attr('id')=='listing-type')
		{
			$('input[name=search_sell_listtype]').val(rel_id);
		}
		if(p.attr('id')=='state')
		{
			$('input[name=search_sell_state]').val(rel_id);
		}
		
		
		
		
		$('.fb-dd-content ul li', p).removeClass('active');
		$(this).addClass('active');
		
		$('.fb-input', p).val($(this).html());
		$('.fb-dd-content', p).hide();
		
		$('.fb-input', p).removeClass('i-focus');
		if (p.is('.contactLocation'))
		{
			$('input[name=county_id]', p).val(rel_id);
			$('.fb-dd-content', p).parents('form:first').submit();
		}
		if (p.is('.golfIndexSort'))
		{
			$('input[name=sort_id]', p).val(rel_id);
			$('.fb-dd-content', p).parents('form:first').submit();
		}
		if (p.is('.selectProvinceSearch'))
		{
			var county_id = $(this).attr('id');
			var counties_s = $('.selectCountySearch');
			$('.fb-dd-content ul', counties_s).hide();
			$('ul[id=counties_' + county_id + ']').show();
			
			$('.fb-dd-content ul li', counties_s).removeClass('active');
			$('ul[id=counties_' + county_id + '] li:first').addClass('active');
			
			$('.fb-input', counties_s).val($('ul[id=counties_' + county_id + '] li:first').html());
			$('input[name=province_id]', p).val(rel_id);
		}
		if (p.is('.selectCountySearch'))
		{
			$('input[name=county_id]', p).val(rel_id);
		}
		if (p.is('.selectRegionAds'))
		{
			document.location = $('input[name=selectRegionAdsUri]', p).val() + 'county/' + $('input[name=county]', p).val() + '/county_id/' + rel_id;
		}
		if (p.is('.selectTypeAds'))
		{
			document.location = $('input[name=selectTypeAdsUri]', p).val() + 'type_label/' + $('input[name=type_label]', p).val() + '/type_val/' + rel_id;
		}
		if (p.is('.qsProvince'))
		{
			$('input[name=county_id]', p).val(rel_id);
		}
		if (p.is('.qsCountry'))
		{
			$('input[name=country_id]', p).val(rel_id);
		}
		if (p.is('.qsType'))
		{
			$('input[id=mtypeid]', p).val(rel_id);
		}
		if (p.is('.planTypeDropdown'))
		{
			$('input[id=planType]', p).val(rel_id);
		}
		if (p.is('.gcTypeDD'))
		{
			$('input[id=mtypeid]', p).val(rel_id);
			$('.fb-dd-content', p).parents('form:first').submit();
		}
	});
	var mouse_is_inside = false;
	$('.fb-dd-content').hover(function()
	{
		clearTimeout(fb_dd_t);
		mouse_is_inside=true;
	},function()
	{
		var p = $(this).parents('.fb-dropdown-container:first');
		mouse_is_inside=false;
		if ($(this).css('display') == 'block')
		{
			fb_dd_t = setTimeout(function()
			{
				$('input', p).blur();
				$('.fb-dd-content', p).hide();
				
			}, 2000);
		}
	});
	$('body').mouseup(function(){ 
        if(! mouse_is_inside) 
        {
        	clearTimeout(fb_dd_t);
        	$.each($('.fb-dd-content'), function(){
        		var p = $(this).parents('.fb-dropdown-container:first');
        		if ($(this).css('display') == 'block')
    			{
        			$('input', p).blur();
    				$('.fb-dd-content', p).hide();
    				$(document).keyup(function(e){ e.preventDefault(); });
    			}
        	});
        }
    });
	
	$('.letter-input input').keyup(function()
	{
		$(this).parents('form:first').submit();
	});
	$('.clearLetter').click(function(e)
	{
		e.preventDefault();
		var p = $(this).parents('.letter-input:first');
		$('input', p).val('');
		$(this).hide();
		$(this).parents('form:first').submit();
	});
	
	$('#survey').submit(function(e)
	{
		e.preventDefault();
		var p = $(this).parents('.surveyFormWrapp:first');
		var survey_id = $('input[name=survey_id]', p).val();
		
		if ($('.survey input:checked').size() == 0) 
		{
			$('.surveyFormWrapp .ui-state-error').show();
			return;
		}
		$('.surveyFormWrapp .ui-state-error').hide();
		if ($('input[name=email]', $(this)).val() == '' || $('input[name=email]', $(this)).val() == 'Your Email Address')
		{
			$('.surveyFormWrapp .ui-state-error').html("Without your Email address, we can't submit your vote!").show();
			return;
		}
		var regexp = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
		if ( !( regexp.test( $('input[name=email]', $(this)).val() ) ) ) 
		{
			$('.surveyFormWrapp .ui-state-error').html("Supplied Email address is not valid!").show();
			return;
		}
		
		$('.surveyFormWrapp').hide();
		$('.surveyResultsWrapp').show();
		$('.surveyResultsWrapp .ajax-loaded').hide();
		$('.surveyResultsWrapp .ajax-loader').show();
		
		$.ajax({
			url: '/index/survey/survey_id/' + survey_id,
			type: 'POST',
			data: $('form', p).serialize(),
			success: function(d)
			{
				$('.surveyResultsWrapp .ajax-loader').hide();
				$('.surveyResultsWrapp .ajax-loaded').html(d).show();
			}
		});
	});
	
	var hrd_def = 'Type in your Email';
	$('.header-rd input[type=text]').focus(function(){
		if ($(this).val() == hrd_def) $(this).val('');
	}).blur(function(){
		if ($(this).val() == '') $(this).val(hrd_def);
	});
	
	var sfw_ied = 'Your Email Address';
	$('.surveyFormWrapp input[name=email]').focus(function(){
		if ($(this).val() == sfw_ied) $(this).val('');
	}).blur(function(){
		if ($(this).val() == '') $(this).val(sfw_ied);
	});
	
	$('.backSurvey').live('click', function(e){
		e.preventDefault();
		
		$('.surveyResultsWrapp').hide();
		$('.surveyFormWrapp').show();
		$('.surveyFormWrapp input[name=email]').val('Your Email Address');
		$('.surveyFormWrapp input[type=radio]').attr('checked', false);
	});
	$('.surveyViewResults').click(function(e)
	{
		e.preventDefault();
		var p = $(this).parents('.surveyFormWrapp:first');
		var survey_id = $('input[name=survey_id]', p).val();
		
		$('.surveyFormWrapp').hide();
		$('.surveyResultsWrapp').show();
		$('.surveyResultsWrapp .ajax-loaded').hide();
		$('.surveyResultsWrapp .ajax-loader').show();
			
		$.ajax({
			url: '/index/survey/survey_id/' + survey_id,
			type: 'GET',
			success: function(d)
			{
				$('.surveyResultsWrapp .ajax-loader').hide();
				$('.surveyResultsWrapp .ajax-loaded').html(d).show();
			}
		});
	});
	$('.expandSearch').click(function(e)
	{
		e.preventDefault();
		if ($('#searchForm').css('display') == 'none') $('#searchForm').show();
		else $('#searchForm').hide();
	});
	
	var nfi_name = $('#newsletterForm input.nfi-name').val();
	var nfi_email = $('#newsletterForm input.nfi-email').val();
	var nfi_def;
	$('#newsletterForm input').focus(function()
	{
		if ($(this).is('.nfi-name')) nfi_def = nfi_name;
		if ($(this).is('.nfi-email')) nfi_def = nfi_email;
		
		if ($(this).val() == nfi_def) $(this).val('');
	}).blur(function()
	{
		if ($(this).is('.nfi-name')) nfi_def = nfi_name;
		if ($(this).is('.nfi-email')) nfi_def = nfi_email;
		
		if ($(this).val() == '') $(this).val(nfi_def);
	});
	
	var nfi_name_top = $('#newsletterFormTop input.ngt-name').val();
	var nfi_email_top = $('#newsletterFormTop input.ngt-email').val();
	var nfi_def_top;
	$('#newsletterFormTop input').focus(function()
	{
		if ($(this).is('.ngt-name')) nfi_def_top = nfi_name_top;
		if ($(this).is('.ngt-email')) nfi_def_top = nfi_email_top;
		
		if ($(this).val() == nfi_def_top) $(this).val('');
	}).blur(function()
	{
		if ($(this).is('.ngt-name')) nfi_def_top = nfi_name_top;
		if ($(this).is('.ngt-email')) nfi_def_top = nfi_email_top;
		
		if ($(this).val() == '') $(this).val(nfi_def_top);
	});
});

var RecaptchaOptions = {
	theme : 'clean',
	lang : 'en'
};


	$('.fb-dropdown-container .fb-input').click(function()
	{
		$('.fb-dd-content').hide();
		var p = $(this).parents('.fb-dropdown-container:first');
		
		$(this).blur();
		$('.fb-dd-content', p).show();
		$('.fb-dd-content', p).scrollTop($(".fb-dd-content ul li.active", p).offset().top - $(".fb-dd-content", p).offset().top);
		$(document).keyup(function(e)
		{
			/* debug
			 * console.log(String.fromCharCode(e.keyCode));
			 */
			
			var key = String.fromCharCode(e.keyCode);
			var findLetter = $(".fb-dd-content ul li:contains(" + key + "):first", p);
			var resetLetter = $(".fb-dd-content ul li:contains(A):first", p);
			
			if (findLetter.size() > 0)
			{
				$('.fb-dd-content', p).scrollTop(resetLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$('.fb-dd-content', p).scrollTop(findLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$(".fb-dd-content ul li.active", p).removeClass('active');
				findLetter.addClass('active');
			}
		});
	});
	$('.fb-dropdown-container .fb-dd-arrow').click(function()
	{
		$('.fb-dd-content').hide();
		var p = $(this).parents('.fb-dropdown-container:first');
		
		$('.fb-input', p).addClass('i-focus');
		$('.fb-dd-content', p).show();
		$('.fb-dd-content', p).scrollTop($(".fb-dd-content ul li.active", p).offset().top - $(".fb-dd-content", p).offset().top);
		$(document).keyup(function(e)
		{
			/* debug
			 * console.log(String.fromCharCode(e.keyCode));
			 */
			
			var key = String.fromCharCode(e.keyCode);
			var findLetter = $(".fb-dd-content ul li:contains(" + key + "):first", p);
			var resetLetter = $(".fb-dd-content ul li:contains(A):first", p);
			
			if (findLetter.size() > 0)
			{
				$('.fb-dd-content', p).scrollTop(resetLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$('.fb-dd-content', p).scrollTop(findLetter.offset().top - $(".fb-dd-content", p).offset().top);
				$(".fb-dd-content ul li.active", p).removeClass('active');
				findLetter.addClass('active');
			}
		});
	});
	$('.fb-dd-content ul li').click(function()
	{
		var p = $(this).parents('.fb-dropdown-container:first');
		var rel_id = $(this).attr('rel');
		
		clearTimeout(fb_dd_t);
		
		$('.fb-dd-content ul li', p).removeClass('active');
		$(this).addClass('active');
		
		$('.fb-input', p).val($(this).html());
		$('.fb-dd-content', p).hide();
		
		$('.fb-input', p).removeClass('i-focus');
		if (p.is('.contactLocation'))
		{
			$('input[name=county_id]', p).val(rel_id);
			$('.fb-dd-content', p).parents('form:first').submit();
		}
		if (p.is('.golfIndexSort'))
		{
			$('input[name=sort_id]', p).val(rel_id);
			$('.fb-dd-content', p).parents('form:first').submit();
		}
		if (p.is('.selectProvinceSearch'))
		{
			var county_id = $(this).attr('id');
			var counties_s = $('.selectCountySearch');
			$('.fb-dd-content ul', counties_s).hide();
			$('ul[id=counties_' + county_id + ']').show();
			
			$('.fb-dd-content ul li', counties_s).removeClass('active');
			$('ul[id=counties_' + county_id + '] li:first').addClass('active');
			
			$('.fb-input', counties_s).val($('ul[id=counties_' + county_id + '] li:first').html());
			$('input[name=province_id]', p).val(rel_id);
		}
		if (p.is('.selectCountySearch'))
		{
			$('input[name=county_id]', p).val(rel_id);
		}
		if (p.is('.selectRegionAds'))
		{
			document.location = $('input[name=selectRegionAdsUri]', p).val() + 'county/' + $('input[name=county]', p).val() + '/county_id/' + rel_id;
		}
		if (p.is('.selectTypeAds'))
		{
			document.location = $('input[name=selectTypeAdsUri]', p).val() + 'type_label/' + $('input[name=type_label]', p).val() + '/type_val/' + rel_id;
		}
		if (p.is('.qsProvince'))
		{
			$('input[name=county_id]', p).val(rel_id);
		}
		if (p.is('.qsCountry'))
		{
			$('input[name=country_id]', p).val(rel_id);
		}
		if (p.is('.qsType'))
		{
			$('input[id=mtypeid]', p).val(rel_id);
		}
		if (p.is('.planTypeDropdown'))
		{
			$('input[id=planType]', p).val(rel_id);
		}
		if (p.is('.gcTypeDD'))
		{
			$('input[id=mtypeid]', p).val(rel_id);
			$('.fb-dd-content', p).parents('form:first').submit();
		}
	});
	var mouse_is_inside = false;
	$('.fb-dd-content').hover(function()
	{
		clearTimeout(fb_dd_t);
		mouse_is_inside=true;
	},function()
	{
		var p = $(this).parents('.fb-dropdown-container:first');
		mouse_is_inside=false;
		if ($(this).css('display') == 'block')
		{
			fb_dd_t = setTimeout(function()
			{
				$('input', p).blur();
				$('.fb-dd-content', p).hide();
				
			}, 2000);
		}
	});