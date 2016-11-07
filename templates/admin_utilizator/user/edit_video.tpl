{ERROR}
<br>

<fieldset >
	<legend> Prezentare video pentru firma dvs</legend>
	<table border="0" cellspacing="1" cellpadding="4" width="98%" align="center" class="big_table form" style="text-align:center;">
	<tr >
		<td class="table_subhead" style="text-align:center;" width="60%">Video </td>
		<td class="table_subhead" style="text-align:center;" width="20%">Imagine </td>
		<td class="table_subhead" style="text-align:center;" width="20%"><b>Data adaugarii</b></td>
	</tr>
<!-- BEGIN list_video -->
<tr> 
	<td align="center" class="row1">
		<div id='{DIV_ID}' align="center"  ></div>
		<script type="text/javascript">
				jwplayer('{DIV_ID}').setup({
				'flashplayer': '../jwplayer/player.swf',
				'id': 'playerID',
				'width': '480',
				'height': '270',
				'file': '{VIDEO_PATH}',
				'image': '{IMAGE_PATH}',
				'plugins': 'viral',
				'viral.oncomplete': 'false',
				'viral.onpause': 'false',
				'controlbar.position':'bottom',
				'skin': '../jwplayer/glow.zip',
				'controlbar': 'over',
				'backcolor ':'ffffff'
			});
		</script>
	</td>
	<td class="row1">{IMAGE_VIDEO}</td>
	<td class="row1">{DATE_ADD} &nbsp;<br>
	<a href="?page=user.deletevideo.{VIDEO_ID}" class="button2">Sterge video</a></td>
</tr>
<!-- END list_video -->
	</table>
<br>
<br>

<FORM METHOD=POST ACTION="?page=user.domodifyvideo.{CAB_ID}" ENCTYPE="multipart/form-data">
<fieldset >
	<legend> Modifica fisier video</legend>
	<table border="0" cellspacing="1" cellpadding="4" width="98%" align="center" class="big_table form" style="text-align:center;">
	<tr >
		<td class="table_subhead" style="text-align:center;" colspan="2">Alege fisierul video pentru prezentarea firmei dvs</td>
	</tr>
	

	<tr>
			<td><b>Youtube link:</b> <input type="text" name="youtube_url" size='60' value="" ></td>
			<td><b>Fisier :</b>
		<input type="file" name="video" size='60' value="" ><br>Dimensiunea maxima a fisierului video: 8Mb.</td>
	</tr>
	
	
	<tr class="row1">
		<td style="text-align:center;" colspan="2" align="center"><br><input type="submit" class="button" value="Adauga"/></td>
	</tr>

	</table>

</FORM>
<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0' class="big_table">
<tr>
	<td class="row1">Pentru prezentare dvs. adaugati un link de pe Youtube sau un fisier video. </td>
</tr>
<tr>
	<td class="row1">In galeria Video pot fi afisate maxim 2 video-uri . </td>
</tr>
<tr>
	<td class="row1">Daca aveti nevoie de ajutor va rugam sa ne trimite-ti un e-mail la : admin@dentistonline.ro </td>
</tr>
<tr>
	<td></td>
</tr>
<tr>
	<td></td>
</tr>
</table>
