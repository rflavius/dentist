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

{ERROR}
<table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>Editeaza imagini pentru {NUME_FIRMA}</td>
</tr>
</table>
<br /><br />
<!-- BEGIN if_images -->
<table border="0" cellspacing="1" cellpadding="4" width="70%" align="center" class="grey">
<tr>
	<td colspan="3" class="tbhead">Galerie Imagini </td><td class="tbhead" align="center"> [ <a href="?page=cabinete.edit.{CABINET_ID}.{USER_ID}" align="center">Editeaza informatii pentru  : {NUME_FIRMA}</a> ]</td>
</tr>

<tr >
	<td class="bgmain"><b>Pozitia in galerie</b></td>
	<td class="bgmain"><b>Imagine</b></td>
	<td class="bgmain" colspan="2"><b>Actiuni</b></td>
</tr>
<!-- BEGIN list_images -->
<tr class="{BGCOLOR}">
	<td align="center">
		<span style="padding-right: 20px;">
		<a href="{RE_ORDER_UP}"><img src="{SITE_BASE}/images/admin/up.png" title="Move up" border="0"></a>
		</span>
		<span style="width: 50px;">
		<a href="{RE_ORDER_DOWN}"><img src="{SITE_BASE}/images/admin/down.png" title="Move down" border="0"></a></span>
</td>
	<td  align="center"><a href="{IMG}" target="_blank">
		<img src="{THUMBNAIL}" border="0" alt="{NUME_FIRMA}" title="{NUME_FIRMA}" id="img"></a></td>
	<td  class="table_content_border text" align="center"><a onclick="return confirmDelete()" href="{DELETE_IMAGE}" >sterge imagine</a></td><td>
		<form method="post" action="?page=cabinete.rename_image.{IMAGE_ID}.{CABINET_ID}">
			<input type="text" name="new_image_name" size="70" value="{IMAGE_NAME}">
			<input type="hidden" name="old_image_name" value="{IMAGE_NAME}">
			<input name="Submit" value="Redenumeste" type="submit" class="button">
		</form>
	</td>
</tr>
<!-- END list_images -->
</table>
<!-- END if_images -->
<br>


<form method="post" action="{USER_ADD_IMAGES}" name='add_images' ENCTYPE="multipart/form-data">
<table border="0" cellspacing="1" cellpadding="4" width="70%" align="center" class="grey">
<tr>
	<td class="tbhead"><b>Adauga Imagini</b></td>
</tr>

<!-- BEGIN if_upload -->
<tr>
	<td class="bgmain" style="text-align:left">Puteti sa adaugati inca <b>{NR_MAX_IMG}</b> imagini pentru {NUME_FIRMA}</td>
</tr>
<!-- BEGIN upload_block -->
<tr class="row1">
	<td>Imaginea nr <b>{IMG_NR}</b>:&nbsp;&nbsp;<input type="file" name="picture_{IMG_NR}" size='20' value="" ></b></td>
</tr>
<!-- END upload_block -->
<tr class="row1">
	<td align="center" colspan="2"><br /><input type="submit" class="button" value="Adauga"/><br /></td>
</tr>
<!-- END if_upload -->
<!-- BEGIN if_no_upload -->
<tr>
	<td class="row1"><b>{NO_UPLOAD}</b></td>
</tr>
<!-- END if_no_upload -->
</table>
</form>
<br />
<hr width="500">
<br />
<!-- imagine harta -->
<table border="0" cellspacing="1" cellpadding="4" width="70%" align="center" class="grey">
<tr>
	<td colspan="3" class="tbhead">Imagine harta - localizare pentru {NUME_FIRMA}.</td>
</tr>
<!-- BEGIN if_images_harta -->
<tr >
	<td class="bgmain"><b>Imagine</b></td>
	<td class="bgmain"><b>Actiuni</b></td>
</tr>

<tr class="row1">
		<td align="center">
		<img src="{THUMBNAIL_HARTA}" border="0" alt="{NUME_FIRMA}" title="{NUME_FIRMA}" id="img"></td>
	<td align="center"><a onclick="return confirmDelete()" href="{DELETE_IMAGE}" >sterge imagine</a></td>
</tr>
<!-- END if_images_harta -->


<!-- BEGIN if_no_images_harta -->
<tr>
	<td colspan="3" class="row1" align="center"><b>Nu aveti imagine pentru localizare.Va rugam adaugati! </b></td>
</tr>
<!-- END if_no_images_harta -->
</table>
<br />

 <!-- BEGIN upload_harta -->
<form method="post" action="{USER_ADD_IMAGE_HARTA}" name='add_images' ENCTYPE="multipart/form-data">
<table border="0" cellspacing="1" cellpadding="4" width="70%" align="center" class="grey">
<tr>
	<td class="tbhead"><b>Adauga Imagine Localizare</b></td>
</tr>
<tr class="row1">
	<td>Imagine localizare:&nbsp;&nbsp;<input type="file" name="picture_harta" size='20' value="" >&nbsp;&nbsp; </td>
</tr>
<tr class="row1">
	<td align="center" colspan="2"><br /><input type="submit" class="button" value="Adauga"/><br/></td>
</tr>
</table>
</form>
 <!-- END upload_harta -->


<table border="0" cellspacing="1" cellpadding="4" width="70%" align="center" class="grey">
<tr>
	<td colspan="3" class="tbhead">Banner pentru {NUME_FIRMA}.</td>
</tr>
<!-- BEGIN if_images_banner -->
<tr >
	<td class="bgmain" style="text-align:center;"><b>Imagine</b></td>
	<td class="bgmain" style="text-align:center;"><b>Actiuni</b></td>
	<td class="bgmain" style="text-align:center;"><b>Afisari banner</b></td>
</tr>

<tr class="row1">
		<td style="text-align:center;">
		<img src="{THUMBNAIL_BANNER}" width="210"  border="0" alt="{NUME_FIRMA}" title="{NUME_FIRMA}" id="img"></td>
	<td style="text-align:center;"><a onclick="return confirmDelete()" href="{DELETE_BANNER}" >[ sterge imagine ]</a></td>
	<td style="text-align:left;"><b>Afisari curente</b>:{AFISARI_CURENTE}<br>
	<br> <b>Total afisari:</b> {TOTAL_AFISARI}<br><br>
	     <form method="post" action="?page=cabinete.adauga_bonus.{ID_BANNER}">
			<b>Bonus :</b><input type="text" name="bonus">
			<input type="submit" value="Adauga" class="button">
	     </form>
		</td>
</tr>
<!-- END if_images_banner -->

<!-- BEGIN if_no_images_banner -->
<tr>
	<td colspan="3" class="row1" align="center"><b>Nu aveti banner.Va rugam adaugati! </b>
			<form method="post" action="{USER_ADD_IMAGE_BANNER}" name='add_banner' ENCTYPE="multipart/form-data">
				<table border="0" cellspacing="1" cellpadding="4" width="98%" align="center" class="big_table form">
				<tr class="row1">
					<td>Banner:&nbsp;&nbsp;<input type="file" name="banner" size='20' value="" >&nbsp;&nbsp;
					<input type="submit" class="button" value="Adauga"/><br/></td>
				</tr>
				</table>
				</form>
		</td>
</tr>
<!-- END if_no_images_banner -->
</table>
<br />


 <table border="0" cellspacing="3" cellpadding="1" width="70%" align="center">
	<tr>
		<td colspan="2" class="attention_albastru"><b>Atentie!</b></td>
	</tr>
	<tr>
		<td><li> Dimensiune maxima pentru o imagine este  <b>{SIZE_MAX_IMG}</b> px. </li></td>
	</tr>
	<tr>
		<td><li>Extensiile acceptate pentru imagini sunt :jpg, jpeg, png, gif.</li></td>
	</tr>
</table>