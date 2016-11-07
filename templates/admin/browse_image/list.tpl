<!-- FUNCTION TO ADD THE M.F. IMAGES IN THE STUPID SCRIPT -->
<script language="javascript" type="text/javascript">
	var js = "mcImageManager.insertFileToTinyMCE";
	function insertURL(url)
	{
		// Crop away query
		if ((pos = url.indexOf('?')) != -1)
			url = url.substring(0, url.indexOf('?'));

		// Handle custom js call
		if (window.opener && js != "") {
			eval("window.opener." + js + "(url);");
			top.close();
			return;
		}

		// Handle form item call
		if (window.opener && formname != "") {
			var elements = elementnames.split(',');

			for (var i=0; i<elements.length; i++) {
				var elm = window.opener.document.forms[formname].elements[elements[i]];
				if (elm && typeof elm != "undefined")
					elm.value = url;
			}

			top.close();
		}
		top.close();
	}
</script>
<form method="post" action="" name="">
	<div align="center">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<!-- BEGIN chose_pictures -->
		<tr>
			<td align="center">
				<a href="javascript:insertURL('../images/uploaded_photos/{PICTURE}');"><img src="../images/uploaded_photos/{PICTURE}" border="0"></a>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<!-- END chose_pictures -->
		</table>
	</div>
</form>