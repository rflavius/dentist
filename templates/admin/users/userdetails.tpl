<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION}
			<br>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="10">List user details</td>
				</tr>
				<tr>
					<td class="bgmain">Username</td>
					<td class="bgmain" nowrap>Name</td>
					<td class="bgmain">Email</td>
					<td class="bgmain" nowrap>Submit date</td>
					<td class="bgmain" nowrap>Last login</td>
					<td class="bgmain" width="10%" nowrap>&nbsp;</td>
					<td class="bgmain" nowrap>Cabinet</td>
					<td class="bgmain" width="7%">Status</td>
					<td class="bgmain" width="7%">Delete</td>
				</tr>
				<tr class="{BGCOLOR}">
					<td valign="top"><b><a href="?page=users.details.{ID_USER}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top">{LASTNAME}, {FIRSTNAME}</td>
					<td valign="top">{MAINEMAIL}</td>
					<td valign="top">{SUBMIT_DATE}</td>
					
					<td valign="top">{LAST_LOGIN}</td>
					<td valign="top" align="center">[ <a href="?page=users.logins&user_id={ID_USER}">View logins</a> ]</td>
					<td align="center"><a href="?page=users.details.{ID_USER}.{USERNAME}">{ARECABINET}</a></td>
					<td align="center" valign="top">
						<a href="?page=users.set.{IMAGE_TITLE}.{ID_USER}">
							<img src="../images/admin/{IMAGEUSER}" title="Turn {USERNAME}'s account to {IMAGEUSER_TITLE}">
						</a>
					</td>
					<td align="center" valign="top">
						<a href="?page=delete.user.{ID_USER}">
							<img src="../images/admin/delete.png" title="Delete {USERNAME}'s account">
						</a>
					</td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">Listare cabinete, laboaratoare, clinici pentru {USERNAME}</td>
				</tr>
				
				<tr>
					<td class="bgmain" width="10%">Nume firma</td>
					<td class="bgmain" width="10%" >Imagine cabinet</td>
					<td class="bgmain" width="15%">Descriere</td>
					<td class="bgmain" width="10%" nowrap>Parent module</td>
					<td class="bgmain" width="5%" nowrap>Tip Promovare</td>
					<td class="bgmain" width="10%">Contract Id</td>
					<td class="bgmain" width="10%">Proforma Id</td>
					<td class="bgmain" width="5%">Facturi</td>
					<td class="bgmain" width="5%">Vizite</td>
					<td class="bgmain" width="5%">Phone views</td>

					<td class="bgmain" width="5%">Status</td>
					<td class="bgmain" width="15%">Actions</td>
					</tr>
				<!-- BEGIN list_firme -->
				<tr class="row1">
					<td valign="top"><a href="{EDITFIRMA}">{NUME_FIRMA}</a></td>
					<td align="center" valign="top"><img src="{THUMBNAIL}" border="0"></td>
					<td valign="top"><div id="norows">{DESCRIERE}</div></td>
					<td valign="top" >{PARENT_MODULE}</td>
					<td valign="top" align='center'>{PROMOVARE}</td>
					<td align="center"><a href="?page=contracte.detaliicontract.{CONTRACT_ID}">{CONTRACT_ID}</a></td>
					<td align="center"><a href="?page=plati.viewproforma.{PROFORMA_ID}">{PROFORMA_ID}</a></td>
					<td align="center"><a href="?page=plati.listfiscaleuser.{ID_USER}">{NR_FACT_FISCALE}</a></td>
					<td align="center">{NR_VISITS_CABINET}</td>
					<td align="center">{NR_PHONE_VIEWS}</td>


					<td align="center" valign="top">
						<a href="?page=cabinete.set.{IMAGE_TITLE}.{IDFIRMA}">
							<img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center" valign="top">
						<a href="?page=cabinete.edit.{IDFIRMA}.{ID_USER}">Edit cab<img src="../images/admin/edit.png" title='Edit "{NUME_CABINET}" cabinet'></a><br />
						<a href="?page=delete.cabinete.{IDFIRMA}">Delete cab<img src="../images/admin/delete.png" title='Delete "{NUME_CABINET}" cabinet'></a><br />
						<a href="?page=cabinete.generatemail.{IDFIRMA}">Generate e-mail</a><br />
						<a href="?page=plati.genereazaproforma.{IDFIRMA}.{ID_USER}.{JUDET_ID}.{TYPE_ID}">Generate proforma</a><br />
						<a href="?page=recomandate.add.{IDFIRMA}.{ID_USER}.{JUDET_ID}.{TYPE_ID}">Add recomended</a><br />
						{PRELUNGESTE_PROMOVARE}
						Recomandat:{RECOMANDED} <a href="?page=cabinete.schimba.{RECOMANDED}.{IDFIRMA}.{ID_USER}.{JUDET_ID}.{TYPE_ID}">change</a>
						
					</td>
				</tr>
				
			
				<!-- END list_firme -->

				<!-- BEGIN if_no_firme -->
					<td class="bgmain" colspan="10" align="center"  style="color:#339900"> Acest user nu are nici o firma adugata!</td>
				<!-- END if_no_firme -->
			</table>
		</td>
	</tr>
	<tr>
	<td>
</table>
<br />
<table width="98%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="tbhead" colspan="11">List anunturi pentru {USERNAME}</td>
	</tr>
			<!-- BEGIN if_anunturi -->
			<tr>
				<td class="bgmain" width="10%">Title</td>
				<td class="bgmain" width="10%">Image</td>
				<td class="bgmain" width="20%">Content</td>
				<td class="bgmain" width="8%" nowrap>Date Add</td>
				<td class="bgmain" width="8%" nowrap>Date Mod</td>
				<td class="bgmain" width="8%" nowrap>Date Exp</td>
					<td class="bgmain" width="8%" nowrap>Vizite</td>
				
				<td class="bgmain" width="8%" nowrap>Published</td>
				<td class="bgmain" width="5%">Edit</td>
				<td class="bgmain" width="5%">Delete</td>
			</tr>
			<!-- BEGIN list_anunturi -->
			<tr class="{BGCOLOR}">
			<td><b>{TITLU}</b></td>
				<td valign="top" align="center"><img src="{THUMBNAILS}" ></td>
				<td valign="top" >{CONTENT}</td>
				<td valign="top" align="center">{DATE_ADDED}</td>
				<td valign="top">{DATE_MOD}</td>
				<td valign="top">{DATE_EXP}</td>
				<td valign="top">{VIZITE}</td>
				
				<td align="center" valign="top">
					<a href="?page=anunturi.set.{IMAGE_TITLE}.{ID}">
				<img src="../images/admin/{IMAGE}" title='Turn "{TITLU}" anunturi to {IMAGE_TITLE}'>
					</a>
				</td>
				<td align="center" valign="top"><a href="?page=anunturi.edit.{ID}.{USER_ID}"><img src="../images/admin/edit.png" title='Edit "{TITLU}" anunturi'></a></td>
				<td align="center" valign="top">
					<a href="?page=delete.anunturi.{ID}">
						<img src="../images/admin/delete.png" title='Delete "{TITLU}" anunturi'>
					</a>
				</td>
				</td>
			</tr>
			<!-- END list_anunturi -->
			<!-- BEGIN no_anunturi -->
			<tr>
				<td colspan="11"class="bgmain" style="color:#339900">Userul nu are nici un anunt adaugat</td>
			</tr>
			<!-- END no_anunturi -->
		</table>
		<br />


<table width="98%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="tbhead" colspan="11">List articole pentru {USERNAME}</td>
	</tr>
			<!-- BEGIN if_articole -->
			<tr>
				<td class="bgmain" width="10%">Title</td>
				<td class="bgmain" width="10%">Image</td>
				<td class="bgmain" width="20%">Content</td>
				<td class="bgmain" width="8%" nowrap>Date Add</td>
				<td class="bgmain" width="8%" nowrap>Date Mod</td>
				<td class="bgmain" width="8%" nowrap>Vizits</td>
				<td class="bgmain" width="8%" nowrap>Published</td>
				<td class="bgmain" width="5%">Edit</td>
				<td class="bgmain" width="5%">Delete</td>
			</tr>
			<!-- BEGIN list_articole -->
			<tr class="{BGCOLOR}">
			<td><b>{TITLU}</b></td>
				<td valign="top" align="center"><img src="{THUMBNAILS}" ></td>
					<td valign="top" >{CONTENT}</td>
			<td valign="top" align="center">{DATE_ADDED}</td>
				<td valign="top">{DATE_MOD}</td>
				<td valign="top">{VISITS}</td>
				<td align="center" valign="top">
					<a href="?page=articles.set.{IMAGE_TITLE}.{ID}">
				<img src="../images/admin/{IMAGE}" title='Turn "{TITLU}" article to {IMAGE_TITLE}'>
					</a>
				</td>
				<td align="center" valign="top"><a href="?page=articles.edit.{ID}.{USER_ID}"><img src="../images/admin/edit.png" title='Edit "{TITLU}" anunturi'></a></td>
				<td align="center" valign="top">
					<a href="?page=delete.articles.{ID}">
						<img src="../images/admin/delete.png" title='Delete "{TITLU}" anunturi'>
					</a>
				</td>
				</td>
			</tr>
			<!-- END list_articole -->
			<!-- BEGIN no_articole -->
			<tr>
				<td colspan="11"class="bgmain" style="color:#339900">Userul nu are nici un articol adaugat</td>
			</tr>
			<!-- END no_articole -->
		</table>
		<br />


<table align="center" class="grey" cellspacing="{CS}" cellpadding="{CP}" width="98%">
	<tr><td colspan="8" class="tbhead">List {USERNAME} mesages</td>
	</tr>
	<tr>
		
			<td class="bgmain" width="10%">De la</td>
			<td class="bgmain" width="10%">Email</td>
			<td class="bgmain" width="15%" >Subiect</td>
			<td class="bgmain" width="40%" >Mesaj </td>
			<td class="bgmain" width="5%" >Citit</td>
			<td class="bgmain" width="5%" >Status</td>
			<td class="bgmain" width="10%" >Data </td>
			<td class="bgmain" width="10%" >Delete </td>
		
	</tr>
	<!-- BEGIN list -->
	<tr class="{BGCOLOR}">
		
		 <td >{NUME_EXPEDITOR}	</td>
		 <td >{EMAIL}</td> 
		<td >{SUBIECT_MESAJ}</td>
		<td >{MESAJ}  <br> <b>Telefon:</b>{TELEFON}<!-- ...<a href="{DETALIIMESAJ}">citeste</a> --></td>
		<td  style="color:{COLOR_MESAGE};">{MESAJ_STATUS} </td>
		<td align="center"><a href="?page=users.setmesaj.{IMAGE_TITLE}.{ID_MESAJ}">
							<img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE}'>
						</a> </td>
		<td >{DATA} </td>
		<td ><a href="?page=users.deletemesaj.{ID_MESAJ}">sterge</a> </td>
	</tr>
	<!-- END list -->
</table>

		<br />
		<input type="button" name="sbmtbtn" value="Back" class="button" onclick="history.back();"/>