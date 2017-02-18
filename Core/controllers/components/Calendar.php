<?php 
/**
* 
*/
class Calendar
{
	
	public function jourSemaine()
	{
		echo "<table clas='row' id='caltable'>";
		echo "<span><img src='./webroot/Font/images/calendrier.ico' width='20' height='20'>";
		echo "<span id='caption'>Calendrier</span></span>";
		echo "<tr id='mnt'><td>".date('M Y')."<td></tr>";
		echo "<th>Ma</th>";
		echo "<th>Mer</th>";
		echo "<th>Je</th>";
		echo "<th>Ve</th>";
		echo "<th>Sam</th>";
		echo "<th>Dim</th>";
		echo "<th>Lu</th>";
		$j = 1;
		
		echo "<tr>";	
		while ($j <= 7) {
			echo "<td class='click'>".$j."</td>";
			$j++;
		}
		echo "</tr>";
		
		echo "<tr>";
		while ($j <= 14) {
			echo "<td class='click'>".$j."</td>";
			$j++;
		}
		echo "</tr>";
			
		echo "<tr>";
		while ($j <= 21) {
			echo "<td class='click'>".$j."</td>";
			$j++;
		}
		echo "</tr>";

		echo "<tr>";
		while ($j <= 28) {
			echo "<td class='click'>".$j."</td>";
			$j++;
		}
		echo "</tr>";

		echo "<tr>";
		while ($j <= 31) {
			echo "<td class='click'>".$j."</td>";
			$j++;
		}
		echo "</tr>";

		echo "</table>";
	}
}
