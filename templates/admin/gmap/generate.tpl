<script>
function changeAddress(address)
{
	document.getElementById('adresa').value = address;
}

</script>

<style>
.multiple_adr_selector a{cursor:pointer;display:block;padding: 20px 10px;font-size:16px;}
.multiple_adr_selector a:hover{text-decoration:none;background-color:#F7F7F7;}
</style>

<br>
<table width="60%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class='row1'>{INFORMATION}</td>
	</tr>
</table>
<br>
<form action="" method='post' name='gmap_quick_search'>
<input type='hidden' name='cabinet_id' value='{ID}'>
<table width="60%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="tbhead" colspan="10">Generate GMAP coords</td>
	</tr>
	<tr>
		<td width='150' class='row1'>Adresa:</td>
		<td class='row1'><input type='text' name='adresa' value='{ADRESA}' size='60' id='adresa'></td>
	</tr>
	<tr>
		<td class='row2'>Judet:</td>
		<td class='row2'><input type='text' name='judet' value='{JUDET}'></td>
	</tr>
	<tr>
		<td class='row1'>Localitate:</td>
		<td class='row1'><input type='text' name='localitate' value='{LOCALITATE}'></td>
	</tr>
	<tr>
		<td colspan='2' class='row2'><input type='submit' value='generate' name='resend' class='button'></td>
	</tr>
</table>
</form>