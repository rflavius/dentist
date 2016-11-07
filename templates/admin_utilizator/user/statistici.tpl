<script src="{SITE_BASE}/templates/js/highcharts/highcharts.js"></script>

{INFORMATION}
<!-- BEGIN if_firme -->
<fieldset>
	<legend> Statistici pentru <b>{UTILIZATOR}</b> </legend>
	<table width="100%" class="big_table form" cellpadding="1" cellspacing="1">
	<!-- BEGIN list_firme -->
	<tr>
		<td class="table_subhead" width="20%" colspan="2">{NUME_FIRMA} </td>
	</tr>
	<tr>
		<td width="20%" class="row2"><img src="http://www.dentistonline.ro/images/allstufs/statistics3.jpg"></td>
		<td class="row2">
			<table border='0' width='100%' align='center' cellspacing='1' cellpadding='1' class="big_table form">
				<tr>
					<td class="row1" width="90%"><b>Vizitatori</b><br> *numarul de persoane ce au fost interesate de {NUME_FIRMA}</td>
					<td class="row1">{NR_VIZITATORI}</td>
				</tr>
				<tr>
					<td class="row1"><b>Mesaje</b><br>*mesajele primite prin intermediul www.dentistonline.ro</td>
					<td class="row1"><a href="http://www.dentistonline.ro/admin_utilizator/?page=user.mesaje" target="_blank">[ {NR_MESAJE} ]</a> </td>
				</tr>
				<tr>
					<td class="row1"><b>Numar accesari telefon cabinet</b>
					<br>*cate persoane au dorit afisarea numarului dvs de telefon pentru a va suna.<br>
					*statistica disponibila din luna aprilie 2015</td>
					<td class="row1"> <b>  {NR_ACCESARI_TELEFON} </b> </td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END list_firme -->
</table>
</fieldset>

<fieldset>
	<legend>Statistici ultimele 3 luni</legend>
	{WIDGET_VISITORS_BLOCK}
	{WIDGET_EMAIL_BLOCK}
	{WIDGET_PHONE_BLOCK}
</fieldset>

<br>

<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td class="row2">
		<li> daca accesati numarul de mesaje, veti vedea mesajele primite prin intermediul nostru</li> 
		<li> daca accesati numarul de imagini, veti avea posibilitatea de a modifica imaginile deja adaugate, banner-ul,harta.</li>
		<li> daca accesati numarul de fisere .pdf,aveti posibilitatea de a edita/adauga un fisier pdf. </li> 
		<li> daca accesati numarul de fisiere video, aveti posibilitatea de a edita/adauga un fisier video</li> 
		<li> mentionam ca si firmele care au ales planul de promovare Recomandat pe judet beneficiaza de beneficiile oferite de planul abonament, fiind excluse (Afisari banner, Afisarii prima pagina, Afisari articol)</li>

	</td>
</tr>
</table>
<!-- END if_firme -->
			

<!-- BEGIN if_no_firme -->
<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td> 
		<li> Nu aveti nici un cabinet, clinica, laborator, depozit  adaugate.<br>
	Doar dupa ce veti adauga o firma veti avea acces la statistici. [ <a href="?page=user.addfirm"><b>Adauga firma</b></a> ]</li>
	</td>
</tr>
<tr>
	<td style="text-align:center;" class="row1"> <br>
		<a href="?page=user.addfirm">
		{PROMOVARE_TEXT}
		</a>
		<br>&nbsp;
	</td>
</tr>
</table>
<!-- END if_no_firme -->
<!-- <fieldset style="width:100%;border:0px;">
<table align="center" border="0" cellspacing="0" cellpadding="0" width="99%" valign="top">
	<tr>
		<td > 
		{PROMOVARE_TEXT}
		</td>
	</tr>
</table>
</fieldset> -->