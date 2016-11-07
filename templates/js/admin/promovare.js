/*
 * here we have all JS functions that works with the new pachete system with services
 */

var pachet;
var servicii;
var total;

function is_array( mixed_var ) {
    // *     example 1: is_array(['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: true
    // *     example 2: is_array('Kevin van Zonneveld');
    // *     returns 2: false
    return ( mixed_var instanceof Array );
}

function str_replace(search, replace, subject) {
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'    
    
    var f = search, r = replace, s = subject;
    var ra = is_array(r), sa = is_array(s), f = [].concat(f), r = [].concat(r), i = (s = [].concat(s)).length;
 
    while (j = 0, i--) {
        while (s[i] = s[i].split(f[j]).join(ra ? r[j] || "" : r[0]), ++j in f){};
    };
     
    return sa ? s : s[0];
}

function updatePachet(pk)
{
	// initialize
	pachet = document.getElementById('firma_pachet').value;
	servicii = document.getElementById('firma_servicii').value;
	total = document.getElementById('firma_total').value;

	if(pachet=='1' && pk!=pachet)
	{
		var r = confirm("Sunteti sigur?\nModificand planul tarifar veti pierde serviciile selectate anterior.");
		if(r==true)
		{
			document.getElementById('firma_pachet').value = pk;
			document.getElementById('firma_servicii').value = "";
			
			var url="index.php?page=ajax&type=calculate_total";
			url=url+"&pk="+pk+"&servicii="+servicii;
			
			var target = 'total_price';
			var myAjax = new Ajax.Updater(target, url, {method: 'get',onSuccess: storeTotal});
			$(target).show();
			uncheckServices();
			window.location.href = 'index.php?page=users.viewpromovare.'+document.getElementById('cabinet_id').value+'.'+pk;
		}
	}
	else
	{
		document.getElementById('firma_pachet').value = pk;
		
		var url="index.php?page=ajax&type=calculate_total";
		url=url+"&pk="+pk+"&servicii="+servicii;
		
		var target = 'total_price';
		var myAjax = new Ajax.Updater(target, url, {method: 'get',onSuccess: storeTotal});
		$(target).show();
		window.location.href = 'index.php?page=users.viewpromovare.'+document.getElementById('cabinet_id').value+'.'+pk;
	}
}

function updatePachet2(pk)
{
	// initialize
	pachet = document.getElementById('firma_pachet').value;
	servicii = document.getElementById('firma_servicii').value;
	total = document.getElementById('firma_total').value;

	if(pachet=='1' && pk!=pachet)
	{
		var r = confirm("Sunteti sigur?\nModificand planul tarifar veti pierde serviciile selectate anterior.");
		if(r==true)
		{
			document.getElementById('firma_pachet').value = pk;
			document.getElementById('firma_servicii').value = "";
			
			var url="index.php?page=ajax&type=calculate_total";
			url=url+"&pk="+pk+"&servicii="+servicii;
			
			var target = 'total_price';
			var myAjax = new Ajax.Updater(target, url, {method: 'get',onSuccess: storeTotal});
			$(target).show();
			
			generateFacturaText(pk,servicii);
		}
	}
	else
	{
		document.getElementById('firma_pachet').value = pk;
		
		var url="index.php?page=ajax&type=calculate_total";
		url=url+"&pk="+pk+"&servicii="+servicii;
		
		var target = 'total_price';
		var myAjax = new Ajax.Updater(target, url, {method: 'get',onSuccess: storeTotal});
		$(target).show();
		
		generateFacturaText(pk,servicii);
	}
}

function generateFacturaText(pachet,servicii)
{
	var url="index.php?page=ajax&type=generate_factura_text";
	url=url+"&pk="+pachet+"&servicii="+servicii+"&cabid="+document.adauga_firma.cabinet_id.value;

	var target = 'factura_text';
	var myAjax = new Ajax.Updater(target, url, {method: 'get',onSuccess: function(response){document.getElementById('factura_text').value = response.responseText;}});
	$(target).show();
}

function storeTotal(response)
{
	document.getElementById('firma_total').value = response.responseText;
	document.getElementById('total_price').value = response.responseText;
}

function addPachetService(serv)
{
	pachet = document.getElementById('firma_pachet').value;
	servicii = document.getElementById('firma_servicii').value;
	
	for(var x=0;x<document.adauga_firma.elements.length;x++)
	{
		var y=document.adauga_firma.elements[x];
		if (y.name=="services[]" && y.value==serv)
		{
			if (y.checked==true)
			{
				var url="index.php?page=ajax&type=calculate_total";
				url=url+"&pk="+pachet+"&servicii="+servicii+";"+serv;
				
				var target = 'total_price';
				var myAjax = new Ajax.Updater(target, url, {method: 'get',onSuccess: storeTotal});
				$(target).show();
				document.getElementById('firma_servicii').value = servicii+";"+serv;
				generateFacturaText(pachet,servicii+";"+serv);
			}
			else if (y.checked==false)
			{
				servicii = str_replace(";"+serv,"",servicii);
				var url="index.php?page=ajax&type=calculate_total";
				url=url+"&pk="+pachet+"&servicii="+servicii;
				
				var target = 'total_price';
				var myAjax = new Ajax.Updater(target, url, {method: 'get',onSuccess: storeTotal});
				$(target).show();
				document.getElementById('firma_servicii').value = servicii;
				generateFacturaText(pachet,servicii);
			}
		}
	}
}

function uncheckServices()
{
	for(var x=0;x<document.adauga_firma.elements.length;x++)
	{
		var y=document.adauga_firma.elements[x];
		if (y.name=="services[]")
		{
			y.checked=false;
		}
	}
	document.adauga_firma.servicii.value='';
	document.adauga_firma.total.value = '0';
}