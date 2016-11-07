require(["dojo/ready", "dojo/on", "dijit/registry", "dojo/data/ItemFileReadStore", "dijit/form/FilteringSelect","dijit/form/ComboBox", "dojo/parser", "dojo/keys"], function(ready, on, registry, keys)
{
    ready(function(){
        // Now set up a linkage so that the store can be reloaded.
        on(registry.byId("search_location"), "keyup", function(evt)
        	{
        	
        	var vall = document.getElementById('search_location').value;
        	var keybord_movement = false;
			key = evt.keyCode;
			// if we hit down and up keys then do not load it again !!
			if(key == keys.DOWN_ARROW || key == keys.UP_ARROW)
			{
				keybord_movement = true;
			}
			else if(key == keys.ENTER)
			{
				// if he ussed down and up keys..then take the value..if not..then let it
				if(keybord_movement==true)
				{
					document.getElementById('autosuggestion').value = document.getElementById('search_location').value;
				}
				// if we hit enter then submit it !!!
				document.advsearch_form.submit();
			}
			else
			{
				if (vall.length >= 2)
				{
					//Reset the url and call close.  Note this could be a different JSON file, but for this example, just
					//Showing how you would set the URL.
					aStore.url = "./sources/autosuggestions.php?str="+vall;
					aStore.close();
				}
			}
        });
    });
});