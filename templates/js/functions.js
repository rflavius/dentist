$(document).ready(function()
{
	if($('[data-toggle="popover"]'))
	{
		$('[data-toggle="popover"]').each(function ()
		{
			var button = $(this);
			button.popover().on('shown.bs.popover', function()
			{
				$('#closePopup').on('click', function ()
				{
					button.popover('hide');
				});
			});
		});
	}
	
	// here we show the oferta popup
	displayOfertaModal();
});

/*
 * display oferta modal
 */
function displayOfertaModal()
{
	$.ajax({
		type: "GET",
		url: "http://www.dentistonline.ro/ajax.php",
		data: {type: 'oferta_modal'}
	})
	.done(function(html)
	{
		$("#ajax_container").html(html);
	});
}

function displayUserPanelOfertaModal()
{
	$.ajax({
		type: "GET",
		url: "http://www.dentistonline.ro/admin_utilizator/sources/ajax.php",
		data: {type: 'free_user_modal'}
	})
	.done(function(html)
	{
		$("#ajax_container").html(html);
	});
}

function RedirectURL(link,banner_id)
{
	if(link!="")
	{
		countBannerClicks(banner_id);
		window.open(link,'_blank');
	}
}

function SetLanguage(url)
{
	self.location.href=url;
}

function breakFree()
{
	if (top.location) top.location.replace(self.location.href)
	else top.document.location.replace(self.document.location.href);
}

if (top!= self) breakFree();


function countBannerClicks(b_id)
{
	var url="http://www.dentistonline.ro/ajax.php";
	url=url+"?type=banner&id="+b_id;
	//alert(url);
	var target = 'ajax_container';
	var myAjax = new Ajax.Updater(target, url, {	method: 'get'});
	$(target).show();
}

function displayPhoneNumber(id,type_element)
{
	document.getElementById('phone_details_ajax').style.display = 'none';
	document.getElementById('the_phone_div').style.visibility = 'visible';

	var url="http://www.dentistonline.ro/ajax.php";
	url=url+"?type=phone_views&id="+id+"&tip_element="+type_element;
	var target = 'phone_details_ajax';
	var myAjax = new Ajax.Updater(target, url, { method: 'get'});
}

function countPhoneNumberViews(id,type_element)
{
	$.ajax({
		type: "GET",
		url: "http://www.dentistonline.ro/ajax.php",
		data: {type: 'phone_views', id: id, tip_element: type_element}
	});
}