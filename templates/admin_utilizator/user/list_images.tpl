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
<fieldset >
			<legend> Imagini pentru  {NUME_FIRMA}</legend>
<table border="0" cellspacing="1" cellpadding="4" width="98%" align="center" class="big_table form" style="text-align:center;">
<tr >
	<td class="table_subhead" style="text-align:center;"><b>Pozitia in galerie</b></td>
	<td class="table_subhead" style="text-align:center;"><b>Imagine</b></td>
	<td class="table_subhead" style="text-align:center;"><b>Actiuni</b></td>
</tr>
<!-- BEGIN list_images -->
<tr class="row1">
	<td style="text-align:center;">
		<span style="padding-right: 20px;">
		<a href="{RE_ORDER_UP}"><img src="{SITE_BASE}/images/admin/up.png" title="Move up" border="0"></a>
		</span>
		<span style="width: 50px;">
		<a href="{RE_ORDER_DOWN}"><img src="{SITE_BASE}/images/admin/down.png" title="Move down" border="0"></a></span>
</td>
	<td  style="text-align:center;"><a href="{IMG}" target="_blank">
		<img src="{THUMBNAIL}" border="0" alt="{NUME_FIRMA}" title="{NUME_FIRMA}" id="img"></a></td>
	<td  style="text-align:center;"><a onclick="return confirmDelete()" href="{DELETE_IMAGE}" >[ sterge imagine ]</a></td>
</tr>
<!-- END list_images -->
</table>
<!-- END if_images -->
<br>


<form method="post" action="{USER_ADD_IMAGES}" name='add_images' ENCTYPE="multipart/form-data">
<table border="0" cellspacing="1" cellpadding="4" width="98%"  class="big_table form" style="text-align:center;">
<tr>
	<td class="table_subhead"><b>Adauga Imagini</b></td>
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
<table border="0" cellspacing="1" cellpadding="4" width="98%" align="center" class="big_table form">
<tr>
	<td colspan="3" class="table_subhead">Imagine harta - localizare pentru {NUME_FIRMA}.</td>
</tr>
<!-- BEGIN if_images_harta -->
<tr >
	<td class="bgmain" style="text-align:center;"><b>Imagine</b></td>
	<td class="bgmain" style="text-align:center;"><b>Actiuni</b></td>
</tr>

<tr class="row1">
		<td style="text-align:center;">
		<img src="{THUMBNAIL_HARTA}" border="0" alt="{NUME_FIRMA}" title="{NUME_FIRMA}" id="img"></td>
	<td style="text-align:center;"><a onclick="return confirmDelete()" href="{DELETE_IMAGE}" >[ sterge imagine ]</a></td>
</tr>
<!-- END if_images_harta -->

<!-- BEGIN if_no_images_harta -->
<tr>
	<td colspan="3" class="row1" align="center"><b>Nu aveti imagine pentru localizare.Va rugam adaugati! </b>
			<form method="post" action="{USER_ADD_IMAGE_HARTA}" name='add_images' ENCTYPE="multipart/form-data">
				<table border="0" cellspacing="1" cellpadding="4" width="100%" align="center" class="big_table form">
					<tr class="row1">
						<td>Imagine localizare:&nbsp;&nbsp;<input type="file" name="picture_harta" size='20' value="" >&nbsp;&nbsp; <input type="submit" class="button" value="Adauga"/></td>
				</tr>
				</table>
			</form>
	</td>

</tr>
<!-- END if_no_images_harta -->
</table>
<br />


 <!-- 0000000000000000000000000000 Banner pentru publicitate 00000000000000000000000000000 -->
<table border="0" cellspacing="1" cellpadding="4" width="98%" align="center" class="big_table form">
<tr>
	<td colspan="3" class="table_subhead">Banner pentru {NUME_FIRMA}.</td>
</tr>
<!-- BEGIN if_images_banner -->
<tr >
	<td class="bgmain" style="text-align:center;"><b>Imagine</b></td>
	<td class="bgmain" style="text-align:center;"><b>Actiuni</b></td>
</tr>

<tr class="row1">
		<td style="text-align:center;">
		<img src="{THUMBNAIL_BANNER}" width="210"  border="0" alt="{NUME_FIRMA}" title="{NUME_FIRMA}" id="img"></td>
	<td style="text-align:center;"><a onclick="return confirmDelete()" href="{DELETE_BANNER}" >[ sterge imagine ]</a></td>
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
</fieldset>


<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
			<li> Daca <b>stergeti o imagine</b>, veti aveti posibilitatea de a <b>adauga alta in locul ei</b>. </li>
			<li>Pentru a <b>modifica pozitia</b> in galeria de imagini doar <b>click pe sageti</b>.</li>
			<li>Extensiile acceptate pentru imagini sunt :<b>jpg, jpeg, png, gi</b>f.</li>
	</td>
</tr>
</table>
