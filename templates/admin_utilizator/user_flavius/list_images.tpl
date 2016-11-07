<script language="JavaScript" type="text/javascript">
<!--
function confirmDelete()
{
var agree=confirm("Sunteti sigur ca vreti sa stergeti aceasta imagine ?");
if (agree)
	return true ;
else
	return false ;
}
//-->
</script>

<h1>Modifica imagini din galeria photo</h1>
{INFORMATION}
<fieldset>
	<legend>IMAGINI ALE OFERTEI</legend>
	<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table">
	<tr>
		<td class="table_subhead" width="200">Pozitia in galerie</td>
		<td class="table_subhead">Imagine</td>
		<td class="table_subhead">ACTIUNI</td>
	</tr>
	<!-- BEGIN if_no_images -->
	<tr>
		<td colspan="3" class="row1">{NO_RECORDS}</td>
	</tr>
	<!-- END if_no_images -->

	<!-- BEGIN list_images -->
	<tr >
		<td align="center" class="{BGROW}">
			<span style="padding-right: 20px;">
			<a href="{RE_ORDER_UP}"><img src="{SITE_BASE}/images/admin/up.png" title="Move up" border="0" style="border:none;"></a>
			</span>
			<span style="width: 50px;">
			<a href="{RE_ORDER_DOWN}"><img src="{SITE_BASE}/images/admin/down.png" title="Move down" border="0"  style="border:none;"></a></span>
		</td>
		<td align="center" class="{BGROW}"><a href="{IMG}" target="_blank"><img src="{SITE_BASE}/resize.php?max=80&image={IMG}" border="0" alt="{NAME}" title="{NAME}" id="img"></a></td>
		<td  class="{BGROW}"><a onclick="return confirmDelete()" href="{DELETE_IMAGE}" >[ sterge imagine ]</a></td>
	</tr>
	<!-- END list_images -->
	</table>
	<br>

	<form method="post" action="{USER_ADD_IMAGES}" name='add_images' ENCTYPE="multipart/form-data">
	<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table">
	<tr>
		<td class="table_subhead">Adauga Imagini</td>
	</tr>
	</table>
	<table border="0" cellspacing="1" cellpadding="3" width="100%" align="center" class="big_table form">
	<!-- BEGIN if_upload -->
	<tr>
		<td class="row2">Puteti sa adaugati <b>{NR_MAX_IMG}</b> imagini pentru aceasta oferta ! <!-- Tipul imaginilor sa fie <b>JPG</b>. Dimensiunea maxima a imaginii sa fie <b>640 x 480 pixeli</b> . --></td>
	</tr>
	<tr><td class="row1">&nbsp;</td></tr>
	<!-- BEGIN upload_block -->
	<tr >
		<td nowrap class="{BG_ROW}">&nbsp;&nbsp;Imaginea nr <b>{IMG_NR}</b>:&nbsp;&nbsp;<input type="file" name="image_{IMG_NR}" size='20' value="" ></td>
	</tr>
	<!-- END upload_block -->
	<tr ><td class="row2">&nbsp;</td></tr>
	<tr >
		<td align="center" colspan="2" class="row1"><input type="submit" class="button" value="Adauga"/></td>
	</tr>
	<!-- END if_upload -->
	<!-- BEGIN if_no_upload -->
	<tr>
		<td class="row2" ><b>{NO_UPLOAD}</b></td>
	</tr>
	<!-- END if_no_upload -->
	</table>
	</form>
</fieldset>
<br />