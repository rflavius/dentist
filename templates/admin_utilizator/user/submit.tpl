<form method="post" action="{USER_CREATE_LINK}">
	<!-- BEGIN error -->
	<div id="error_messages"><br />{ERROR_MSG}</div>
	<!-- END error -->

	<table border="0" cellspacing="2" cellpadding="2" width="100%" align="center" class="text">
	<tr>
			<td colspan="2"  align="center" class="title_head">Promovare Online Gratuita</td>
	</tr>
		
	<tr >
			<td colspan="2">Daca aveti nevoie de ajutor accesati: <a href="{CONTNOU}">Exemplu creare cont nou</a></td>
	</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		
		<tr>
			<td class="text2" width="25%" >Nume :</td>
			<td width="50%"><input type="text" name="firstname" value="{FIRSTNAME}" /></td>
		</tr>
		<tr>
			<td class="text2">Prenume :</td>
			<td><input type="text" name="lastname"  value="{LASTNAME}" /></td>
		</tr>
		<tr>
			<td class="text2">E-mail :</td>
			<td><input type="text" name="email"  value="{EMAIL}" /></td>
		</tr>
		<tr>
			<td class="text2">Utilizator:</td>
			<td><input type="text" name="username" value="{USERNAME}" /></td>
		</tr>
		<tr>
			<td class="text2">Parola :</td>
			<td><input type="password" name="pass_1"  /></td>
		</tr>
		<tr>
			<td class="text2" >Retipareste Parola :</td>
			<td><input type="password" name="pass_2"  /></td>
		</tr>

		<tr>
			<td class="text2">Cod de siguranta :</td>
			<td><input type="text" name="security_code"  /></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<img src="security_image.php?code={SECURITYID}" alt="Security Image">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top:15px;"> Sunt de acord cu  <a href="{TERMENICONDITII}">termenii si conditiile</a> site-ului <input type="checkbox" name="agree" value="agree"/></td>
			
		</tr>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" class="button" value="Creeaza"/></td>
		</tr>
	</table>

	<table border="0" cellspacing="4" cellpadding="1" align="left" class="text">
	<tr>
			<td >Toate campurile sunt obligatorii! <br />	</td>
	<tr>
		<td><p style="color:#990000;">Odata ce ati complectat formularul de mai sus si ati dat click pe "Creeaza" deventiti membru al site-ului DentistOnline si 
	 veti beneficia de anumite servicii precum: </p><ol>
										<li>Adaugarea de informatii despre cabinetul, laboratorul, clinica dvs.</li>
										<li>Modificarea acestor informatii </li>
										<li>Modificarea informatiilor care privesc contul dvs ca membru </li>
										<li>Adaugare anunturi</li>
										<li>Modificarea anunturi </li>
										<li>Adaugare articole</li>
										<li>Modificarea articole </li>
										<li>Galerie imagini </li>
										<li>Mesaje </li>
									<!-- 	<li>Informatii factura</li>  -->
										</ol> 
				</td>							
	</tr>
	
	</table>
</form>