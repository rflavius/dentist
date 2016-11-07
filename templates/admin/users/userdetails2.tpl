<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION}
			<br>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="7">List user details</td>
				</tr>
				<tr>
					<td class="bgmain">Username</td>
					<td class="bgmain" nowrap>Name</td>
					<td class="bgmain">Email</td>
					<td class="bgmain" nowrap>Submit date</td>
					<td class="bgmain" nowrap>Last login</td>
					<td class="bgmain" nowrap>Cabinet</td>
					<td class="bgmain" width="7%">Status</td>
				</tr>
				<tr class="{BGCOLOR}">
					<td valign="top"><b>{USERNAME}</b></td>
					<td valign="top">{LASTNAME}, {FIRSTNAME}</td>
					<td valign="top">{MAINEMAIL}</td>
					<td valign="top">{SUBMIT_DATE}</td>
					
					<td valign="top">{LAST_LOGIN}</td>
					<td align="center">{ARECABINET}</td>
					<td align="center" valign="top"><img src="../images/admin/{IMAGEUSER}" title="Turn {USERNAME}'s account to {IMAGEUSER_TITLE}"></td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="12">Listare cabinete, laboaratoare, clinici pentru {USERNAME}</td>
				</tr>
				
				<tr>
					<td class="bgmain" width="10%">Nume firma</td>
					<td class="bgmain" width="10%" >Imagine cabinet</td>
					<td class="bgmain" width="15%">Descriere</td>
					<td class="bgmain" width="7%" nowrap>Telefon</td>
					<td class="bgmain" width="7%" nowrap>E-mail</td>
					<td class="bgmain" width="5%" nowrap>Vizitatori</td>
					<td class="bgmain" width="10%" nowrap>Parent module</td>
					<td class="bgmain" width="5%" nowrap>Tip Promovare</td>
					<td class="bgmain" width="10%">Proforma Id</td>
					<td class="bgmain" width="5%">Facturi</td>
					<td class="bgmain" width="5%">Status</td>
					<td class="bgmain" width="15%">Actions</td>
					</tr>
				<!-- BEGIN list_firme -->
				<tr class="row1">
					<td valign="top">{NUME_FIRMA}</td>
					<td align="center" valign="top"><img src="{THUMBNAIL}" border="0"></td>
					<td valign="top"><div id="norows">{DESCRIERE}</div></td>
					<td valign="top" >{CAB_TEL}</td>
					<td valign="top" >{CAB_EMAIL}</td>
					<td valign="top" >{CAB_VISITS}</td>
					<td valign="top" >{PARENT_MODULE}</td>
					<td valign="top" align='center'>{PROMOVARE}</td>
					<td align="center"><a href="?page=plati.viewproforma.{PROFORMA_ID}">{PROFORMA_ID}</a></td>
					<td align="center"><a href="?page=plati.listfiscaleuser.{ID_USER}">{NR_FACT_FISCALE}</a></td>
					<td align="center" valign="top"><img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE}'></td>
					<td align="center" valign="top">
						<a href="?page=plati.genereazaproforma.{IDFIRMA}.{ID_USER}.{JUDET_ID}.{TYPE_ID}">Generate proforma</a><br />
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
		<td class="tbhead" colspan="8">List anunturi pentru {USERNAME}</td>
	</tr>
			<!-- BEGIN if_anunturi -->
			<tr>
				<td class="bgmain" width="10%">Title</td>
				<td class="bgmain" width="10%">Image</td>
				<td class="bgmain" width="20%">Content</td>
				<td class="bgmain" width="8%" nowrap>Date Add</td>
				<td class="bgmain" width="8%" nowrap>Date Mod</td>
				<td class="bgmain" width="8%" nowrap>Date Exp</td>
				<td class="bgmain" width="8%" nowrap>Vizitatori</td>
				<td class="bgmain" width="8%" nowrap>Published</td>
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
				<td align="center" valign="top"><img src="../images/admin/{IMAGE}" title='Turn "{TITLU}" anunturi to {IMAGE_TITLE}'></td>
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
		<td class="tbhead" colspan="7">List articole pentru {USERNAME}</td>
	</tr>
			<!-- BEGIN if_articole -->
			<tr>
				<td class="bgmain" width="20%">Title</td>
				<td class="bgmain" width="10%">Image</td>
				<td class="bgmain" width="30%">Content</td>
				<td class="bgmain" width="8%" nowrap>Date Add</td>
				<td class="bgmain" width="8%" nowrap>Date Mod</td>
				<td class="bgmain" width="5%" nowrap>Vizitatori</td>
				<td class="bgmain" width="8%" nowrap>Published</td>
			</tr>
			<!-- BEGIN list_articole -->
			<tr class="{BGCOLOR}">
				<td><b>{TITLU}</b></td>
				<td valign="top" align="center"><img src="{THUMBNAILS}" ></td>
				<td valign="top" >{CONTENT}</td>
				<td valign="top" align="center">{DATE_ADDED}</td>
				<td valign="top">{DATE_MOD}</td>
				<td valign="top">{ART_VISITS}</td>
				<td align="center" valign="top"><img src="../images/admin/{IMAGE}" title='Turn "{TITLU}" article to {IMAGE_TITLE}'></td>
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
	<tr>
		<td colspan="7" class="tbhead">List {USERNAME} mesages</td>
	</tr>
	<tr>
		<td class="bgmain" width="10%">De la</td>
		<td class="bgmain" width="10%">Email</td>
		<td class="bgmain" width="15%" >Subiect</td>
		<td class="bgmain" width="40%" >Mesaj </td>
		<td class="bgmain" width="5%" >Citit</td>
		<td class="bgmain" width="5%" >Status</td>
		<td class="bgmain" width="10%" >Data </td>
	</tr>
	<!-- BEGIN list -->
	<tr class="{BGCOLOR}">
		<td >{NUME_EXPEDITOR}</td>
		<td >{EMAIL}</td> 
		<td >{SUBIECT_MESAJ}</td>
		<td >{MESAJ}  <br> <b>Telefon:</b>{TELEFON}<!-- ...<a href="{DETALIIMESAJ}">citeste</a> --></td>
		<td  style="color:{COLOR_MESAGE};">{MESAJ_STATUS} </td>
		<td align="center"><img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE}'></td>
		<td >{DATA} </td>
	</tr>
	<!-- END list -->
</table>

		<br />
		<input type="button" name="sbmtbtn" value="Back" class="button" onclick="history.back();"/>