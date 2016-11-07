<script type="text/javascript">
		_editor_url = "../third_party/htmlarea/";
		_editor_lang = "en";
</script>
<script type="text/javascript" src="../third_party/htmlarea/htmlarea.js"></script>
<br>
<form method="post" enctype="multipart/form-data" action="?page=modules.template_created.{LINK}">
<table width="80%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="head-menu">Create static page : {LINK}</td>
	</tr>
	<tr bgcolor="{BGCOLOR1}">
		<td width="100%">
			<textarea name="content" id="cabinet_content" rows="11" cols="121"></textarea>
			<script type="text/javascript">HTMLArea.replace("cabinet_content");</script>
		</td>
	</tr>
	<tr bgcolor="{BGCOLOR2}">
		<td align="center">
			<input type="submit" value="Finish" class="button">
		</td>
	</tr>
</table>
<br>
</form>