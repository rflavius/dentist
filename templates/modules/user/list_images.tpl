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
<!-- BEGIN if_images -->
<table border="0" cellspacing="1" cellpadding="4" width="90%" align="center" class="dark_bg">
<tr>
	<td colspan="3" class="tbhead">Imagini pentru  {NUME_FIRMA}</td>
</tr>

<tr >
	<td class="bgmain"><b>Pozitia in galerie</b></td>
	<td class="bgmain"><b>Imagine</b></td>
	<td class="bgmain"><b>Actiuni</b></td>
</tr>
<!-- BEGIN list_images -->
<tr class="row1">
	<td align="center">
		<span style="padding-right: 20px;">
		<a href="{RE_ORDER_UP}"><img src="{SITE_BASE}/images/admin/up.png" title="Move up" border="0"></a>
		</span>
		<span style="width: 50px;">
		<a href="{RE_ORDER_DOWN}"><img src="{SITE_BASE}/images/admin/down.png" title="Move down" border="0"></a></span>
</td>
	<td  align="center"><a href="{IMG}" target="_blank">
		<img src="{THUMBNAIL}" border="0" alt="{NUME_FIRMA}" title="{NUME_FIRMA}" id="img"></a></td>
	<td  class="table_content_border text" align="center"><a onclick="return confirmDelete()" href="{DELETE_IMAGE}" >sterge imagine</a></td>
</tr>
<!-- END list_images -->
</table>
<!-- END if_images -->
<br>


<form method="post" action="{USER_ADD_IMAGES}" name='add_images' ENCTYPE="multipart/form-data">
<table border="0" cellspacing="1" cellpadding="4" width="90%" align="center" class="dark_bg">
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
<hr >
<br />
<!-- imagine harta -->
<table border="0" cellspacing="1" cellpadding="4" width="90%" align="center" class="dark_bg">
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
<table border="0" cellspacing="1" cellpadding="4" width="90%" align="center" class="dark_bg">
<tr>
	<td class="tbhead"><b>Adauga Imagine Localizare</b></td>
</tr>
<tr class="row1">
	<td>Imagine localizare:&nbsp;&nbsp;<input type="file" name="picture_5" size='20' value="" >&nbsp;&nbsp; </td>
</tr>
<tr class="row1">
	<td align="center" colspan="2"><br /><input type="submit" class="button" value="Adauga"/><br/></td>
</tr>
</table>
</form>
 <!-- END upload_harta -->

 <table border="0" cellspacing="3" cellpadding="1" width="98%" align="center">
	<tr>
		<td colspan="2" class="attention_albastru"><b>Atentie!</b></td>
	</tr>
	<tr>
		<td><li> Daca stergeti o imagine, veti aveti posibilitatea de a adauga alta in locul ei. </li></td>
	</tr>
	<tr>
		<td><li>Pentru a modifica pozitia in galeria de imagini doar click pe sageti.</li></td>
	</tr>
<!-- 	<tr>
		<td><li> Dimensiune maxima pentru o imagine este  <b>{SIZE_MAX_IMG}</b> px. </li></td>
	</tr> -->
	<tr>
		<td><li>Extensiile acceptate pentru imagini sunt :jpg, jpeg, png, gif.</li></td>
	</tr>
</table>
