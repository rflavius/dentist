<div style="position: absolute;left: 0;top:0;width: 100%;height:100%;z-index: 100;text-align: center;background-color: #4D4D4D;filter:alpha(opacity=35);-moz-opacity:0.35;opacity:0.35;" id="popup_bg">
</div>
<div id="popup_div" style='position: absolute;left: 30%;top:25%;z-index: 1000;background-color: white;border: 1px solid #8F8F8F;' >
	<table border='0' width='96%' align='center' cellspacing='2' cellpadding='3' class="popup">
		<tr>
			<td align="center">
				<table border="0" cellspacing="3" cellpadding="4" align="center" width="90%">
					<tr>
						<td colspan="2" style="border-bottom: 4px solid #BACED9;"><h2>Sondaj rapid !</h2></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<p style="color: #A40000;">{SONDAJ_TEXT}</p>
							<p><b><u>Faptul ca votati nu va obliga la nimic</u>, e doar un simplu sondaj pentru a vedea opinia clientilor nostri !</b></p>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="special">Pentru a vota faceti un click pe raspunsul dorit .</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td align="center"><img src="../templates/skins/user/images/yes.jpg" onclick="VoteSondaj('{SONDAJ_USER_ID}','Y');" style="cursor:pointer;"></td>
						<td align="center"><img src="../templates/skins/user/images/no.jpg"  onclick="VoteSondaj('{SONDAJ_USER_ID}','N');" style="cursor:pointer;"></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>