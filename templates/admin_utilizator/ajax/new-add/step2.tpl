<div class="page-header">
	<h3>Detalii Servicii & Tarife</h3>
</div>
<div class='clearfix'>&nbsp;</div>
<div class='jumbotron'>
	<div class='form-group'>
		<div class='col-sm-12'>
			<label>Descriere *</label>
			<textarea name="descriere"  rows="8" class='form-control' required placeHolder="Descrierea unitatii dvs ...">{DESCRIERE}</textarea>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-6'>
			<label>Echipa medicala</label>
			<textarea name="echipa_medicala" rows="8" class='form-control'  placeHolder="Echipa medicala ...">{ECHIPA_MEDICALA}</textarea>
		</div>
		<div class='col-sm-6'>
			<label>Orar *</label>
			<textarea name="orar" rows="8" class='form-control' required placeHolder="Introduceti orarul de functionare ...">{ORAR}</textarea>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-12'>
			<label>Servicii si Tarife</label>
			<textarea name="tarife" rows="6" class='form-control'>{TARIFE}</textarea><br>
			<p><input type="file" id='servicii_file' name="servicii" size="43"><br> Puteti adauga fisier PDF sau fisier Microsoft Office.</p>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
</div>

<div class='clearfix'>&nbsp;</div>

<div class="page-header">
	<h3>Media</h3>
</div>
<div class='clearfix'>&nbsp;</div>
<div class='jumbotron'>
	<div class='form-group'>
		<div class='col-sm-12'>
			<label>Video</label>
			<p><input type="file" id='video_file' name="video" size="43"><br>Dimensiunea maxima a fisierului video: 8Mb.</p>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-12'>
			<label>Banner publicitar</label>
			<p>
				<input type="file" id='banner_file' name="banner" size="43"><br>
				Dimensiunea acceptata este : 210x80px. Imaginea trebuie sa aiba una din urmatoarele extensii: jpg, gif, png .
			</p>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-12'>
			<label>Galerie imagini</label>
			<p><input type="file" id='gallery_file' name="galery" multiple size="43"><br>Puteti selecta mai multe imagini odata pentru a fii adaugate.</p>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-12 text-center'>
			<br>
			<button name="Submit" type="button" class="btn btn-default btn-lg" onClick="nextStep('2', false)">
				<i class="fa fa-angle-double-right" aria-hidden="true" style='font-size:22px;'></i>&nbsp;Pasul urmator
			</button>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
</div>

