<script language="JavaScript" type="text/javascript">
<!--
function confirmDelete()
{
var agree=confirm("Sunteti sigur ca vreti sa stergeti acest mesaj ?");
if (agree)
	return true ;
else
	return false ;
}
//-->
</script>

{ERROR}
<fieldset>
	<legend>LISTA CU MESAJELE DVS</legend>
		<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table">
		<tr>
			<td class="table_subhead">#</td>
			<td class="table_subhead"><b>Subiect</b></td>
			<td class="table_subhead"><b>Nume Expeditor</b></td>
			<td class="table_subhead"><b>Data Expedierii</b></td>
			<td class="table_subhead"><b>ACTIUNI</b></td>
		</tr>
		<!-- BEGIN if_no_records -->
		<tr>
			<td class="row1" colspan="5">{NO_RECORDS}</td>
		</tr>
		<!-- END if_no_records -->
		<!-- BEGIN list_row -->
		<tr >
			<td class="{BGROW}"><a href="{VIEW_MSG_LINK}" target="_blank">{NR}</a></td>
			<td class="{BGROW}"><a href="{VIEW_MSG_LINK}" target="_blank">{SUBJECT}</a></td>
			<td class="{BGROW}">{SENDER_NAME}</td>
			<td class="{BGROW}">{DATE}</td>
			<td nowrap class="{BGROW}">
				<ul>
					<li><a href="{VIEW_MSG_LINK}" target="_blank">[ vezi mesaj ]</a></li>
					<li><a onclick="return confirmDelete()" href="{DELETE_MSG_LINK}">[ sterge mesaj ]</a></li>
				</ul>
			</td>
		</tr>
		<!-- END list_row -->
		</table>
</fieldset>