<script type="text/javascript" src="{SITE_BASEE}/templates/js/admin/promovare.js"></script>

<br>
<form method="post" action="?page=users.dopromovare" name='adauga_firma'>
<input type='hidden' name='firma_pachet' value='1' id='firma_pachet'>
<input type='hidden' name='firma_servicii' value='{SELL_SERVS}' id='firma_servicii'>
<input type='hidden' name='total' value='{TOTAL}' id='firma_total'>
<input type='hidden' name='cabinet_id' value='{CAB_ID}' id='cabinet_id'>
<input type='hidden' name='user_id' value='{USER_ID}'> 

	<table width="45%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Adauga Tip Promovare</td>
		</tr>
		<tr> 
			<td class="row1" width='120'><b>Pachet</b><p class="star">*</p></td>
			<td class="row2">
				<select name="pachet" onChange="updatePachet2(this.value)">
					<!-- BEGIN list_pachete -->
					<option value='{PACHET_ID}' {PACHET_SELL}>{PACHET} - {COST} RON</option>
					<!-- END list_pachete -->
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1"><b>Servicii</b><p class="star">*</p></td>
			<td class="row2">
				<table cellpadding="4" cellspacing="1">
				<!-- BEGIN list_servicii -->
				<tr>
					<td width='240'>{SERV} {VALUE} - {SERV_PRET}RON</td>
					<td align='center'><input type='checkbox' name='services[]' value='{SERV_ID}' {SERV_CHECK} onClick=addPachetService('{SERV_ID}')></td>
				</tr>
				<!-- END list_servicii -->
				</table>
			</td>
		</tr>
		<tr> 
			<td class="row1"><b>Total Promovare</b>:</td>
			<td class="row2"><b><span id='total_price'>{TOTAL}</span> RON</b></td>
		</tr>
		<tr>
			<td colspan='2' class='tbhead'>Date facturare</td>
		</tr>
		<tr>
			<td colspan='2'>
				{FACTURARE_BLOCK}
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2" class='row1'>
				<input type="submit" value="Adauga" class="button" />
			</td>
		</tr>
	</table>
</form>