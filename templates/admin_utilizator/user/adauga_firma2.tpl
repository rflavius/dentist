		<script type="text/javascript" src="{SITE_BASE}/upload_js/dojo.js"  djConfig="isDebug:false, parseOnLoad: true, debugAtAllCosts:false"></script>

		<script  type="text/javascript">

			var fileMask = ["Images", "*.jpg;*.jpeg;*.gif;*.png"];
			dojo.require("dojox.form.FileUploader");
			dojo.require("dijit.form.Button");
			dojo.require("dojo.parser");
			dojo.require("dijit.ProgressBar");


			imageHTML = function(data){
				var txt = '<img src="{SITE_BASE}/upload_js/resizeImage2.inc.php?width=80&height=80&cropratio=1:1&image=/'+data.file+'&firma_id='+dojo.byId('firma_id').value+'">';
				return txt;
			};



			dojo.addOnLoad(function(){
				var uploadUrl='{SITE_BASE}/upload_js/ajax_images.php?firma_id='+dojo.byId('firma_id').value;
				var rmFiles = "";

				if(dojo.byId("uploader")){

					var f0 = new dojox.form.FileUploader({
						force: "HTML",
						hoverClass:"uploadBtn",
						activeClass:"uploadBtn",
						pressClass:"uploadBtn",
						disabledClass:"uploadBtn",
						degradable:true,
						uploadUrl:uploadUrl,
						uploadOnChange:false,
						selectMultipleFiles:false,
						fileMask:fileMask,
						isDebug:true,
						devMode:true
					},"uploader");
					
					doUpload = function(){
						console.log("doUpload")
						dojo.style(dojo.byId('loading_dojoUpload'), 'display', 'block');
						dojo.style(dojo.byId('uploader'), 'display', 'none');
						f0.upload();
					}
					
					dojo.connect(f0, "onChange", function(data){
						dojo.forEach(data, function(d)
						{
							doUpload();
						});
					});

					dojo.connect(f0, "onComplete", function(data){
						dojo.style(dojo.byId('uploader'), 'display', 'block');
						dojo.style(dojo.byId('loading_dojoUpload'), 'display', 'none');

						dojo.forEach(data, function(d){
							dojo.byId("Thumbs").innerHTML += imageHTML(d);//'<img src="'+d.file+'" />';
						});
					});
				}

			});
    </script>

	<style>
	.uploadBtn,#uploader,dojoxUploaderNorm{
	clear:both;
	display:block;
	background:url('{SITE_BASE}/upload_js/uploaderBtn.png') no-repeat;
	width:219px;
	height:50px;
	cursor:pointer !important;
	}
	.dijitFileInputReal{
	display:none;
	height:1px;
	cursor:pointer !important;
	}
	.progBar{
		width:200px;
		display:none;
	}

	#loading_dojoUpload{
	display:none;
	background: url('{SITE_BASE}/upload_js/loading.gif') no-repeat left center;
	height:30px;
	line-height:30px;
	color: #575757;
	font-size:11px;
	text-indent:20px;
	font-family: 'Arial';
	}
	.thumbList{
	margin:10px 0px 10px 0px;
	padding:5px;
	}
	.thumbList img{border:1px solid #3870AB;margin-right:10px;float:left;margin-bottom:5px;}
	</style>


{ERROR_MSG}
<br>
<div class="steps">
	<span class="step1_inactive"></span>
	<span class="step2_active"></span>
	<span class="step3_inactive"></span>
	<div style="color: #255A82;font-size:16px;">
		<p style="float:left;">Detalii firma & Localizare</p>
		<p style="float:left;margin-left:250px;">Servicii si Tarife & Galerie Imagini & Video</p>
		<p style="float:right;">Finalizare</p>
	</div>
</div>
<br>
<div class='clearfix'></div>
<!-- BEGIN ADD_FIRM_BLOCK -->
<form name="adauga_firma" method="post" action="{INSERT_FIRMA2}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="big_table form">
	<tr> 
		<td colspan="2" class="table_subhead">Servicii si Tarife & Prezentare video</td>
	</tr>
	<tr> 
      <td class="row1">Echipa medicala</td>
      <td class="row1"><br /></td>
   </tr>
	<tr> 
      <td class="row1">Orar <span>*</span></td>
      <td class="row1"><br /></td>
	</tr>
	<tr> 
      <td class="row1">Descriere  <span>*</span></td>
      <td class="row1"><textarea name="descriere"  rows="8" cols="40" >{DESCRIERE}</textarea><br />
		
			</td>
	</tr>
	<tr> 
      <td class="row1">Servicii si Tarife </td>
      <td class="row1"><textarea name="tarife" rows="8" cols="40" >{TARIFE}</textarea><br />	<br>
			<p><input type="file" name="servicii" size="43"><br> Puteti adauga fisier PDF sau fisier Microsoft Office.</p>
			</td>
	</tr>
	<tr> 
      <td class="row1">Galerie Imagini </td>
      <td class="row1" style="padding-top: 10px;">
			</td>
	</tr>


	<tr> 
      <td class="row1">Adauga video </td>
      <td class="row1"><input type="file" name="video" size="43"><p>Dimensiunea maxima a fisierului video: 8Mb.</p></td>
	</tr>
	<tr> 
      <td class="row1">Adauga banner </td>
      <td class="row1"><input type="file" name="banner" size="43">
				<p>Dimensiunea acceptata este : 210x80px . <br>Imaginea trebuie sa aiba una din urmatoarele extensii: jpg,gif,png .</p>
			</td>
	</tr>
	<tr> 
			<td class="row1" colspan="2" style="text-align:center;"><input name="Submit" value="Pasul urmator" type="submit" class="button"></td>
	</tr>
</table>
</form>
<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
			<li>Completarea campurilor  cu * este obligatorie!</li>
			<li>Daca ati adaugat un fisier video,pdf,doc, dupa acesare "Pasul urmator" va rugam sa asteptati un pic, sunt necesare cateva secunde pentru a urca fisierul. </li>
			<li>Oferiti informatii cat mai cuprinzatoare, vizitatori va vor contacta in functie de acestea.</li> 
			<li>Extensiile acceptate pentru imagini sunt jpg, jpeg, png, gif. </li>
	</td>
</tr>
</table>
