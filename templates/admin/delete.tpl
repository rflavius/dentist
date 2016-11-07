<br>
<script language="JavaScript" type="text/javascript">
<!--
function DelBlog()
{
	if (document.delete_item.what.checked)
	{
		document.delete_item.submit();
	}
	else alert('Please check the checkbox to confirm !');
}
//-->
</script>
<form method="post" action="?page=delete.{THE_ACTION}.{THE_PARAM}.confirm" name="delete_item">
<table border="0" cellspacing="{CS}"  cellpadding="{CP}" width="350" align="center" class="grey">
	<tr>
		<td valign='top' class="tbhead">
			Are you sure you want to delete ?
		</td>
	</tr>
	<tr>
		<td valign='middle' height="60" class="{B1}" align="center">
			<input type="checkbox" name="what"/>
			&nbsp;&nbsp;<strong>{DELWHO}</strong></td>
	</tr>
	<tr>
		<td valign='top' class="{B2}" align="right">
			<input type="button" class="button" onClick="history.back();" value="&laquo; Back"/>
			&nbsp;&nbsp;
			<input type="button"  class="button" value="Delete &raquo;" onClick="DelBlog();"/></td>
	</tr>
</table>
</form>