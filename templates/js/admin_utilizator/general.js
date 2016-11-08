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