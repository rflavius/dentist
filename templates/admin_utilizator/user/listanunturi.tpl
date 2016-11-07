<!-- BEGIN if_anunturi -->
{INFORMATION}
<fieldset >
			<legend> <b>{USERNAME}</b>  aici ai toate anunturile adaugate. </legend>
<table align="center" border="0" cellspacing="1" cellpadding="1" width="100%" >
	<tr>
		<td width="100%">
			<table width="100%"  cellpadding="1" cellspacing="1" class="big_table form">
				<tr>
						<td   class="table_subhead" width="20%">Titlu </td>
						<td   class="table_subhead" width="35%">Descriere</td>
						<td   class="table_subhead" width="10%" align="center">Imagine</td>
						<td   class="table_subhead" width="10%" align="center">Status</td>
						<td   class="table_subhead" width="15%" align="center">Actiuni </td>
				</tr>
				<!-- BEGIN list_anunturi -->
				<tr class="row1">
					<td valign="top">	<b>	{FRONTENDANUNT}	</b>	</td>
					<td valign="top"><div id="norows">{CONTINUT}...<a href="{EDITANUNT}"><b>[ citeste tot ]</b></a></div></td>
					<td align="center" valign="top"><a href="{EDITANUNT}"><img src="{THUMBNAIL}" border="0"></a></td>
					<td valign="top">	<b>	{STATUSANUNT}	</b>	</td>
					<td align="center" valign="top">
						<a href="{EDITANUNT}" align="center"  title='Modifica anuntul "{TITLU}"' class="button2" style="text-decoration: none;">Modifica</a>
							<a href="{PREVIEW}" target="_blank" >[Vezi cum arata anuntul tau]</a>
						<a href="{PRELUNGESTEANUNT}" title='Prelungeste anuntul "{TITLU}" cu inca 6 luni' class="button2" style="text-decoration: none;">Prelungeste</a>
					<!-- 	<a href="{DELETEANUNT}" title='Stergeti anuntul "{TITLU}"' class="button2" style="text-decoration: none;">Sterge</a> -->
							
					</td>
				</tr>
				<!-- END list_anunturi -->
			</table>
		</td>
	</tr>
</table>
</fieldset>
				
<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td class="row1"> 
	<li><b>"Modifica"</b>  - datele caracteristice anuntului dvs.(imagine, descriere etc.)</li>
	<li><b>"Preview"</b> -  veti vedea cum arata articolul dvs. pe website-ul nostru.</li>
	<li><b>"Prelungeste"</b> - prelungiti data expirarii anuntului dvs. cu 6 luni</li>
	<li><b>"Sterge"</b> - anuntul adaugat .</li>
	<li>Status  <b>"Inactiv/Activ "</b>, doar cand statusul e <b>Activ</b>, anuntul va aparea pe site-ul nostru.</li>
	
	</td>
</tr>
</table>

<!-- END if_anunturi -->

				
<!-- BEGIN if_no_anunt -->
<table border="0" cellspacing="1" cellpadding="1" align="center" class="big_table form">
<tr>
	<td class="table_subhead">Nu aveti nici un anunt. Click <a href="{USERADDANUNT}">[ adaugare anunt ]</a> </td>
</tr>

<tr>
	<td class="row1"> Anunturile bine detaliate si cu <b>imagine</b> sunt postate pe <b>prima pagina</b> a site-ul nostru pentru o anumita perioada de timp.</td>
</tr>
<tr>
	<td class="row1"><a href="{USERADDANUNT}"><img src="../images/anunturi.jpg"></a><br><br></td>
</tr>
</table>
<!-- END if_no_anunt -->


