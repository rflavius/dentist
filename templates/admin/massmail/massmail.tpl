<br />
<center>
<form method="post" action="?page=massmail.send" name="formularmail">
<table border="0" cellspacing="1" cellpadding="4" width="600" bgcolor="#f1f1f1" class="grey">
<tr>
	<td class="tbhead" colspan="2">Mass mail</td>
</tr>
<tr>
	<td class="row2" align="right" width="150"><strong>Select destination</strong></td>
	<td class="row2">
	<select name="destination">
		<option value="users" selected>All users</option>
		<option value="allpackages">All Packages Users</option>
		<option value="1">Bronze Package Users</option>
		<option value="2">Silver Package Users</option>
		<option value="3">Gold Packages Users</option>
	</select>
	</td>
</tr>
<tr>
	<td class="row1" align="right"><strong>From</strong></td>
	<td class="row1"><input type="text" name="from" value="{DEF_FROM}" size="55"></td>
</tr>
<tr>
	<td class="row1" align="right"><strong>Subject</strong></td>
	<td class="row1"><input type="text" name="subject" size="55"></td>
</tr>
<tr>
	<td class="row2" align="right"><strong>Message</strong></td>
	<td class="row2"><textarea name="message" rows="15" cols="80"></textarea></td>
</tr>

<tr>
	<td colspan="2" class="row2" align="center"><input type="submit" class="button" value="Send mail"></td>
</tr>
</table>
</form>
</center>