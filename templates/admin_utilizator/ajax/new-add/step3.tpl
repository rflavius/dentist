<div class="page-header">
	<h3>Finalizare - Alege promovarea care te avantajeaza</h3>
</div>
<div class='clearfix'>&nbsp;</div>
<div class='jumbotron'>
	<div class='form-group'>
		<div class='col-sm-12'>
			<!-- BEGIN list_pachete -->
			<div class="panel panel-default col-sm-3">
				<div class="panel-heading">
					<h3 class="panel-title">{PACHET}</h3>
				</div>
				<div class="panel-body">
					<p>{PACHET_DESCR}</p>
					<p>{PACHET_PRICE} RON/luna<br><input type="radio" name="level" value="{PACHET_ID}" onClick="AddAjaxAbonamentCost(this.value,'')" {PACHET_SELL}></p>
					<p>{PACHET_OFERTA}<a href="{SITE_BASE}/admin_utilizator/?page=user.publicitate#{PACHET_HASHTAG}" target="_blank">[ Detalii pachet ]</a></p>
				</div>
			</div>
			<!-- END list_pachete -->
			<div class="panel panel-default col-sm-3">
				<div class="panel-heading">
					<h3 class="panel-title">Promovare BANNER</h3>
				</div>
				<div class="panel-body">
					<p>...</p>
					<p>Pentru detalii ne puteti contacta prin email la: admin@dentistonline.ro, sau telefonic la: 0727.380.368 .</p>
					<p><a href="{SITE_BASE}/admin_utilizator/?page=user.publicitate#bannere" target="_blank">[ Detalii pachet ]</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-5'>
			<label>Perioada promovarii</label>
			<select name="perioada" id='perioadaPachet' onChange='AddAjaxAbonamentCost("", this.value)' class='form-control' >
				<option value=""> - - - - - - - - - - </option>
				<!-- BEGIN list_perioada -->
				<option value="{PERIOADA}" {PERIOADA_SELL}>{PERIOADA_VALUE}</option>
				<!-- END list_perioada -->
			</select>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-6'>
			<label>Date facturare</label>
			<select name="type" onchange="loadform(this.value);" class='form-control'>
				<option value="" selected>Fara factura</option>
				<option value="persoana_fizica" >Persoana fizica</option>
				<option value="firma" >Firma</option>
			</select>
		</div>
		<div class='col-sm-6'>
			<div id='facturare_block'></div>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-12'>
			<br>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Rezumat promovare</h3>
				</div>
				<div class="panel-body">
					<div id='summary_div'>
						<p>{SUMMARY}</p>
					</div>
				</div>
				<div class="panel-footer">
					<p>Alegeti o promovare avantajoasa oferita de cel mai bun portal stomatologic din Romania.</p>
				</div>
			</div>
		</div>
	</div>
	<div class='clearfix'>&nbsp;</div>
	<div class='form-group'>
		<div class='col-sm-12 text-center'>
			<button type='submit' class='btn btn-primary btn-lg'><i class="fa fa-check-circle-o" aria-hidden="true" style='font-size:22px;'></i>&nbsp;&nbsp;Finalizare</button>
		</div>
	</div>
</div>