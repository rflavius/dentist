<table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<table border="0" cellspacing="1" cellpadding="4" align="right" valign="top">
		<tr>
			<td class="navigation_href" ><a href="{DICTIONAR_STOMATOLOGIC_URL}"><b>Dictionar stomatologic</b></a> | <a href="{ADD_TERM}"><b>Adauga termen medical</b></a> | <a href="{SEARCH_TERM}"> <b>Cauta termen medical</b></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="just_indent"><p>{MESSAGE}</p><br /><p>Stiti unele definitii despre anumiti termenii stomatologici sau din dieverse ramuri ale medicinii? Aici e locul potrivit pentru afirmarea dvs.</p>
	</td>
</tr>
<tr>
	<td><br />
	<form method="post" action="{AD_FORM_URL}" name="">
			<table border="0" cellspacing="1" cellpadding="4">
		<tr>
			<td class="text2"><b>Termen medical:</b><span>*</span><br />
			 &nbsp;<i>numele termenului ex: dinte</i>
			</td>
			<td><input type="text" name="titlu" value="{TITLU}" size="54"/></td>
		</tr>
		<tr>
			<td class="text2"><b>Definitie,explicatie:</b><span>*</span></td>	
			<td><textarea name="continut" rows="10" cols="40">{CONTINUT_TERMEN}</textarea></td>
		</tr>
		<tr>
			<td class="text2"><b>Autor:</b></td>
			<td><input type="text" name="autor" value="{AUTOR}" size="54"/> </td>
		</tr>
		<tr>
			<td class="text2"><b>Email:</b></td>
			<td><input type="text" name="email" value="{EMAIL}" size="54"/></td>
		</tr>
		<tr>
			<td class="text2"><b>Cod de siguranta </b>:<span>*</span></td>
			<td><input type="text" name="security_code2" size="20" /></td>
		</tr>
		<tr>
		<td colspan="2" align="center">
			<img src="{SITEBASE}/security_image.php?code={SECURITYID}" alt="Security Image">
		</td>
	</tr>
	<tr>
	<td colspan="2" align="center"><br />
		<input type="submit" class="button" value=" Adauga ">
	</td>
	</tr>
	</table>
</form>
		
	</td>
</tr>



</table>