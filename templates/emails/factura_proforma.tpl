<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title> Factura proforma </title>
</head>
<body>
<table border="0" cellspacing="1" cellpadding="4" width="70%">
<tr>
	<td>Buna ziua %NUME_PERS_CONTACT%,</td>
</tr>
<tr>
	<td>
		<p>Mai jos aveti detaliile despre facturarea serviciilor oferite. </p>
		<p>Va rugam sa realizati plata in termen de <b>%EXPIRARE_FACTURA_PROFORMA%</b> zile lucratoare de la orice banca prin ordin de plata sau folosind sistemul electronic Online Banking.</p>
		<p>Ca persoana fizica puteti folosi depunerea de numerar la UniCredit Tiriac Bank, caz in care va rugam sa furnizati operatorului bancar si o copie a acestui document.</p>
		</td>
</tr>
<tr>
	<td>
		 <p>CA DESCRIERE A PLATII VA RUGAM SA TRECETI DOAR "Factura Proforma %NUMAR_FACTURA_PROFORMA%", 	(alte explicatii pot fi distorsionate la transferul intre banci,in plus numarul proformei este singurul care poate identifica plata).</p>
	</td>
</tr>
<tr>
	<td>
		<p>Activarea firmei dvs. se face in urma livrarii sumei in contul destinatie. Factura in original este diponibila in format electronic in panoul de administrare firma.</p> 
	</td>
</tr>
</table>
<p>--------------------------------------------------------------------------------------------------------------------------</p>
<table border="1" cellspacing="1" cellpadding="3" width="80%">
<tr>
	<td colspan="3">
		<table width="100%" >
		<tr>
			<td align="center" colspan="2">Factura Proforma nr.  <b>%NUMAR_FACTURA_PROFORMA%</b> din %DATA%</td>
		</tr>
		<tr>
			<td colspan="2" align="left" >Termen de plata : <b>%EXPIRARE_FACTURA_PROFORMA%</b> zile lucratoare de la data emiterii.</td>
		</tr>
		<tr>
			<td width="50%">
					<table cellspacing="1" cellpadding="3">
					<tr>
						<td width="30%"><b>Furnizor</b></td>
						<td>Rosu Flavius Romica PFA</td>
					</tr>
					<tr>
						<td><b>CUI</b></td>
						<td>22942874</td>
					</tr>
					<tr>
						<td><b>Nr. RC</b></td>
						<td>F05/2143/17.12.2007</td>
					</tr>
					<tr>
						<td valign="top"><b>Adresa</b></td>
						<td>Str.Atelierelor nr 13A,ap 32 etj 2, <br />Cod Postal 410542, Oradea Bihor</td>
					</tr>
					<tr>
						<td><b>Cod IBAN</b></td>
						<td>RO40 BACX 0000 0001 9501 8000</td>
					</tr>
					<tr>
						<td><b>Banca</b></td>
						<td>UniCredit Bank S.A</td>
					</tr>
					</table>
			</td>
				<td valign="top">
					<table cellspacing="1" cellpadding="3" > 
						<tr>
							<td width="30%"><b>Beneficiar</b></td>
							<td>%NUME_PERS_CONTACT_FIRMA%</td>
						</tr>
						
						<tr>
							<td><b>CUI/CNP</b></td>
							<td>%COD_FISCAL_CNP%</td>
						</tr>
						<tr>
							<td><b>Nr. RC/BI</b></td>
							<td>%NR_REG_COM_BI%</td>
						</tr>
						
						<tr>
							<td width="250"><b>Adresa</b></td>
							<td>%ADRESA%</td>
						</tr>
					</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td><b>Nr. crt.</b></td>
	<td><b>Denumirea produselor sau serviciilor</b></td>
	<td><b>Pret</b></td>
</tr>
<tr>
	<td>1.</td>
	<td >%DENUMIRE_SERVICI%</td>
	<td align="center">%PRET_TOTAL%</td>
</tr>
<tr >
	<td colspan="2" align="right" ><b>Total factura</b></td>
	<td align= "center"> %PRET_TOTAL% &nbsp; RON</td>
</tr>
</table>
<p>--------------------------------------------------------------------------------------------------------------------------</p>
<p>Daca aveti orice intrebari referitoare la aceasta factura proforma va rugam sa ne contactati.</p>
<p>Va multumim,</p>
<p>DentistOnline.ro</p>
</body>
</html>
