jQuery(document).ready(function()
{
	playNewContractNavigation(1);
	
	//ignore the enter key on new contract form
	jQuery(window).keydown(function(event)
	{
		if( (event.keyCode == 13))
		{
			event.preventDefault();
			return false;
		}
	});
});

var max_steps = 3;

/**
 * here we play the navigation and the content based on where we are
 * @param step
 */
function playNewContractNavigation(step)
{
	for(i=1; i<= max_steps; i++)
	{
		if(i>step)
		{
			jQuery('.nav-tabs #tab'+i).attr('class', 'disabled');
			jQuery('.nav-tabs #tab'+i+" a").attr('href', '#');
		}
		else
		{
			// first remove the previous active tab
			jQuery('.nav-tabs li').attr('class', '');
			
			// now we check to see if the step is the current step
			if(i==jQuery('#current_step').val())
			{
				jQuery('.nav-tabs #tab'+i).attr('class', 'active');
				// show tab content
				// If the tab is not active
				if (!jQuery('#step'+i).hasClass('active'))
				{
					// Then activate it
					jQuery('#step'+i).parents('.tab-content')
						.find('.tab-pane')
						.each(function(index, tab)
							{
								var tabId = jQuery(tab).attr('id');
								var li = jQuery('a[href="#' + tabId + '"][data-toggle="tab"]').parent();
								//alert(tabId);
								if (tabId == "step"+jQuery('#current_step').val())
								{
									// activate the tab pane
									jQuery(tab).addClass('active in');
									// and the associated <li> element
									jQuery(li).addClass('active');
								}
								else
								{
									jQuery(tab).removeClass('active in');
									jQuery(li).removeClass('active');
								}
							});
				}
			}
			else
			{
				jQuery('.nav-tabs #tab'+i).attr('class', '');
			}
			jQuery('.nav-tabs #tab'+i+" a").attr('href', '#step'+i);
		}
	}
}

/**
 * here we parse the cities list based on what judet he selected
 * @param val
 */
function CompleteLocalitateFirma(val)
{
	if (val != "")
	{
		jQuery.ajax({
			type: "GET",
			url: "../admin_utilizator/sources/ajax.php",
			data: {type: 'list-cities', judet: val}
		})
		.done(function(html)
		{
			jQuery('#localitate_ajax_addfirm').html(html);
		});
	}
}

/**
 * here we validate the step and disply the next block
 * @param step
 */
function nextStep(step, refresh = true)
{
	if(jQuery("#orderForm").valid())
	{
		if(validStep(step))
		{
			// calculate the next step
			if(refresh == false)
			{
				var next_step = +step + 1;
			}
			else
			{
				var next_step = step;
			}
			
			// a few more validations and checkings
			jQuery('#newContractLoading').removeClass('hide').addClass('show');
			jQuery.ajax({
				type: "GET",
				url: "../admin_utilizator/sources/ajax.php",
				data: {type: 'new-add', step: next_step, data: jQuery("#orderForm :input").serialize()}
			})
			.done(function(html)
			{
				jQuery('#current_step').attr('value', next_step);
				playNewContractNavigation(next_step);
				jQuery('#step'+next_step).html(html);
				
				jQuery('#newContractLoading').removeClass('show').addClass('hide');
			});
		}
	}
}

/**
 * here we validate the step using PHP validatin if we need
 */
function validStep(step)
{
	var error = true;
	var data = jQuery("#orderForm :input").serializeArray(); // convert form to array
	if(step=='1')
	{
		data.push({name: "file", value: jQuery('#picture_harta').val()});
	}
	else if(step=='2')
	{
		data.push({name: "servicii_file", value: jQuery('#servicii_file').val()});
		data.push({name: "video_file", value: jQuery('#video_file').val()});
		data.push({name: "banner_file", value: jQuery('#banner_file').val()});
		
		var gallery = document.getElementById('gallery_file').files;
		var imgs = '';
		for (var i = 0; i < gallery.length; i++)
		{
			imgs[i] = gallery[i].name;
		}
		data.push({name: "gallery_file", value: imgs});
	}
	
	jQuery.ajax({
		type: "GET",
		url: "../admin_utilizator/sources/ajax.php",
		data: {type: 'new-add', step: 'validate', data: jQuery.param(data), 'what': step}
	})
	.done(function(html)
	{
		var result = JSON.parse(html);
		jQuery('#ajaxResponse').html(result.html);
		jQuery('html, body').animate({scrollTop: jQuery("#ajaxResponse").offset().top}, 2000);
		if(result.type == 'error')
		{
			error = false;
		}
	});
	return Boolean(error);
}

/**
 * here we recalculate the contract price based on what he selects
 */
function AddAjaxAbonamentCost(pachet, months)
{
	if(pachet=="") pachet = jQuery("#orderForm #pachetContract").val();
	if(months=="") months = jQuery("#orderForm #perioadaContract").val();
	jQuery('#newContractLoading').removeClass('hide').addClass('show');
	jQuery.ajax({
		type: "GET",
		url: "../admin_utilizator/sources/ajax.php",
		data: {type: 'new-add', step: 'recalculate', 'pachet': pachet, 'perioada': months}
	})
	.done(function(html)
	{
		jQuery('#summary_div').html(html);
		jQuery('#newContractLoading').removeClass('show').addClass('hide');
	});
}

function showFacturare(type)
{
	if(type != "")
	{
		jQuery('#newContractLoading').removeClass('hide').addClass('show');
		jQuery.ajax({
			type: "GET",
			url: "../admin_utilizator/sources/ajax.php",
			data: {type: 'new-add', step: 'facturare', 'tip': type}
		})
		.done(function(html)
		{
			jQuery('#facturare_block').html(html);
			jQuery('#newContractLoading').removeClass('show').addClass('hide');
		});
	}
	else jQuery('#facturare_block').html();
}