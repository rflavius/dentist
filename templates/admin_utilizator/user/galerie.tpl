{INFORMATION}
<!-- BEGIN if_firme -->
<fieldset >
	<legend> Adauga noi imagini/modifica imaginile curente </legend>
	<table width="100%" class="big_table form" cellpadding="4" cellspacing="1" >
	<tr>
		<td class="table_subhead" width="35%">Denumire</td>
		<td class="table_subhead" width="20%" >Imagine principala</td>
		<td class="table_subhead" width="20%" >Numar Imagini</td>
		<td class="table_subhead" width="15%" align="center" >Actiuni </td>
		</tr>
	<!-- BEGIN list_firme -->
	<tr class="row1">
		<td valign="top"><b> {NUME_FIRMA} </b>	</td>
		<td align="center" valign="top"><a href="{MODIFICA_IMAGINI}"><img src="{THUMBNAIL}" border="0" title="{NUME_FIRMA}"></a> </td>
		<td align="center" valign="top">[ <a href="{MODIFICA_IMAGINI}" title="Adauga noi imagini/modifica imaginile curente pentru {NUME_FIRMA}"><b>{NR_IMAGINI} </b>imagini</a> ]<br></td>

		<td align="center" valign="top" > 
			<a href="{MODIFICA_IMAGINI}" title="Adauga noi imagini/modifica imaginile curente pentru {NUME_FIRMA}" class="button2">Modifica </a>
			<a href="{PREVIEW}" target="_blank" title="Vezi cum arata {NUME_FIRMA} pe www.dentistonline.ro " class="button2">Preview</a>
			<br>
		</td>
	</tr>
	<!-- END list_firme -->
	</table>
</fieldset>


<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
		<li><b>"Modifica"</b> - adaugati/schimbati imaginile din galeria dvs, cat si pozitia lor in galerie.</li> 
		<li><b>"Preview"</b> -  veti vedea cum arata cabinetul/clinica/laboratorul dvs.  pe website-ul nostru.</li>
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
		<li> Nu aveti nici un cabinet, clinica, laborator, depozit  adaugate.
	Doar dupa ce veti adauga o firma veti avea acces la galerie. [ <a href="?page=user.addfirm"><b>Adauga firma</b></a> ]</li>
	</td>
</tr>
<tr>
	<td style="text-align:center;" class="row1"> <br>
		<a href="?page=user.addfirm"><img align="center" src="../images/banner2.jpg"></a>
		<br>&nbsp;
	</td>
</tr>
</table>
<!-- END if_no_firme -->