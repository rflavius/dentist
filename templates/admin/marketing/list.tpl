<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION} 
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}" width="200"><strong>Vezi contacte: </strong>   </td>
					<td class="{B2}" width="80">
						<select name="select_parent" onChange="MM_jumpMenu('parent',this,0)">
							<option value="?page=marketing">All  </option>
							<option value="?page=marketing&type=revin" {SEL_REVIN}>Revin cu telefon </option>
						</select>
					</td>
					<td class="{B2}" width="80">
						<select name="select_parent" onChange="MM_jumpMenu('parent',this,0)">
							<option value="?page=marketing">Toate contactele</option>
							<!-- BEGIN modules -->
								<option value="?page=marketing.module_{MODULE_ID}" {SELECTED_MODULE}>{MODULE_NAME}</option>
								<!-- BEGIN categories -->
									<option value="?page=marketing.category_{CATEGORY_ID}" {SELECTED_CAT}> ... {CATEGORY_NAME}</option>
								<!-- END categories -->
							<!-- END modules -->
						</select>
					</td>
					
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_CABINETE}</strong> Contacte</td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br>
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="14">Vezi contacte marketing</td>
				</tr>
				<tr>
					<td class="bgmain" >#</td>
					<td class="bgmain" >UserID</td>
					<td class="bgmain" >Facturi</td>
					<td class="bgmain" >Nume Cabinet</td>
					<td class="bgmain" >E-mail</td>
					<td class="bgmain" >Telefon</td>
					<td class="bgmain" >Promovare</td>
					<td class="bgmain" >Vizitatori</td>
					<td class="bgmain" nowrap>Tip/Judet</td>
					<td class="bgmain" >Comentarii</td>
					<td class="bgmain" >contactat</td>
					<td class="bgmain">revin cu tel</td>
					<td class="bgmain">E-mail Promovare</td>
					<td class="bgmain">&nbsp;</td>
				</tr>
				<!-- BEGIN list_contacts -->
				<tr class="{BGCOLOR}">
					<td align="center" valign="top">{NR}</td>
					<td align="center" valign="top"><a href='index.php?page=users.details.{USER_ID}'>{USER_ID}</a></td>
					<td align="left" valign="top" nowrap>
						Proforma: [{PROFORMA_ID}]<br>
						Fiscala [{CONTRACT_ID}]<br>
					</td>
					<td valign="top"><a href="{LINK_TO_CABINET}" target="_blank">{CABINET}</a></td>
					<td valign="top"><div id="norows">{EMAIL}</div></td>
					<td valign="top"><div id="norows">{TELEFON}</div></td>
					<td valign="top">{LOCPROMOVARE}</td>
					<td valign="top">{VISITS}</td>
					<td valign="top">{PARENT_MODULE}</td>
					<td valign="top">{COMMENTS}</td>
					<td valign="top">{DATE}</td>
					<td valign="top">{REV_DATE}</td>
					<td align="center" valign="top">
						<img src="../images/admin/{IMAGE2}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE2}'><br>
						<!-- BEGIN if_no_email_sent -->
						[ <a href="?page=marketing.sendmail.{CAB_ID}">trimite email</a> ]
						<!-- END if_no_email_sent -->
					</td>
					<td align="left" valign="top" nowrap>
						[ <a href="?page=marketing.addrevin.{ID}.{CAB_ID}">Revin cu telefon</a> ]<br />
						[ <a href="?page=marketing.addcomment.{ID}.{CAB_ID}">Adauga comentariu</a> ]<br />
						[ <a href="?page=plati.genereazaproforma.{CAB_ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">Genereaza proforma</a> ]<br />
					</td>
				</tr>
				<!-- END list_contacts -->
			</table>
		</td>
	</tr>
</table>