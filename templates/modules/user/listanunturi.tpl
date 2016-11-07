<!-- BEGIN if_anunturi -->
<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" class="text">
	<tr>
		<td width="100%">
			{INFORMATION}
			<table width="100%"  cellpadding="4" cellspacing="1" class="dark_bg">
				<tr>
					<td class="tbhead" colspan="5">{USERNAME} aici ai toate anunturile adaugate. <b></b></td>
				</tr>
				
				<tr>
						<td   class="bgmain" width="20%">Titlu </td>
						<td  class="bgmain" width="35%">Descriere</td>
						<td   class="bgmain" width="10%" align="center">Imagine</td>
						<td   class="bgmain" width="10%" align="center">Status</td>
						<td   class="bgmain" width="15%" align="center">Actiuni </td>
						
				</tr>
				<!-- BEGIN list_anunturi -->
				<tr class="row1">
					<td valign="top">	<b>	{FRONTENDANUNT}	</b>	</td>
					<td valign="top"><div id="norows">{CONTINUT}...</div></td>
					<td align="center" valign="top"><a href="{EDITANUNT}"><img src="{THUMBNAIL}" border="0"></a></td>
					<td valign="top">	<b>	{STATUSANUNT}	</b>	</td>
					<td align="center" valign="top">
						<a href="{EDITANUNT}" align="center"  title='Modifica anuntul "{TITLU}"' class="button" style="text-decoration: none;"><input type="submit" name="sbmtbtn" value="Modifica"  class="button"/></a>
						<a href="{PRELUNGESTEANUNT}" title='Prelungeste anuntul "{TITLU}" cu inca 6 luni' class="button" style="text-decoration: none;"><input type="submit" name="sbmtbtn" value="Prelungeste"  class="button"/></a>
						<a href="{DELETEANUNT}" title='Stergeti anuntul "{TITLU}"' class="button" style="text-decoration: none;"><input type="submit" name="sbmtbtn" value="Sterge"  class="button"/></a>
						
					</td>
					
				</tr>
				<!-- END list_anunturi -->
			</table>
		</td>
	</tr>
</table>
				
				
<table border="0" cellspacing="4" cellpadding="1" width="100%">
<tr>
	<td class="attention_verde"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td> <li>Accesati <b>"Modifica"</b> si veti avea posibilitatea de a modifica datele caracteristice anuntului dvs.(imagine,descriere etc.)</li></td>
</tr>
<tr>
	<td> <li>Accesati <b>"Prelungeste"</b> si veti avea posibilitatea de a prelungi data expirarii anuntului dvs. cu 6 luni</li></td>
</tr>
<tr>
	<td> <li>Accesati <b>"Sterge"</b> si veti avea posibilitatea de a sterge anuntul adaugat de dvs.</li></td>
</tr>
<tr>
	<td><li>Status  <b>"Inactiv/Activ "</b>, doar cand statusul e ectiv acesta va aparea pe site-ul nostru.</li>
	<li>Accesati</div>  <b>"Titlul"</b> anuntului si veti vedea cu arata anuntul pe website-ul DentistOnline.</li>
	</td>
</tr>
</table>

<!-- END if_anunturi -->

				
<!-- BEGIN if_no_anunt -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tr>
	<td ><br />Nu aveti nici un anunt. Click <a href="{USERADDANUNT}">adaugare anunt</a> </td>
</tr>
</table>
	
<!-- END if_no_anunt -->


