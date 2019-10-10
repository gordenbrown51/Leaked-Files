<?php
session_start();
include("includes.php");
$naslov = $jezik['text346'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-podrska";



if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
	die();
}

$sql =  "SELECT s.box_id sboxid, s.port sport, b.ip bip, t.id tid, t.server_id tsrvid, t.user_id tuid, t.status tstatus, t.datum tdatum, ".
		"t.naslov tnaslov, t.prioritet tprioritet, t.vrsta tvrsta ".
		"FROM tiketi t, serveri s, boxip b ".
		"WHERE t.user_id = '".$_SESSION['klijentid']."' AND t.status != '3' AND s.id = t.server_id AND b.ipid = s.ip_id ".
		"ORDER BY t.id DESC ";
		
$sql2 =  "SELECT s.box_id sboxid, s.port sport, b.ip bip, t.id tid, t.server_id tsrvid, t.user_id tuid, t.status tstatus, t.datum tdatum, ".
		"t.naslov tnaslov, t.prioritet tprioritet, t.vrsta tvrsta ".
		"FROM tiketi t, serveri s, boxip b ".
		"WHERE t.user_id = '".$_SESSION['klijentid']."' AND t.status = '3' AND s.id = t.server_id AND b.ipid = s.ip_id ".
		"ORDER BY t.id DESC ";
		
$sql3 =  "SELECT s.box_id sboxid, s.port sport, b.ip bip, t.id tid, t.server_id tsrvid, t.user_id tuid, t.status tstatus, t.datum tdatum, ".
		"t.naslov tnaslov, t.prioritet tprioritet, t.vrsta tvrsta ".
		"FROM tiketi t, serveri s, boxip b ".
		"WHERE t.user_id = '".$_SESSION['klijentid']."' AND s.id = t.server_id AND b.ipid = s.ip_id ".
		"ORDER BY t.id DESC ";	


$sql44 =  "SELECT  t.id tid, t.server_id tsrvid, t.user_id tuid, t.status tstatus, t.datum tdatum, ".
		"t.naslov tnaslov, t.prioritet tprioritet, t.vrsta tvrsta ".
		"FROM tiketi t ".
		"WHERE t.user_id = '".$_SESSION['klijentid']."' AND t.status != '3' AND t.server_id = '-1' ".
		"ORDER BY t.id DESC ";

$sql939 =  "SELECT s.box_id sboxid, s.port sport, b.ip bip, t.id tid, t.server_id tsrvid, t.user_id tuid, t.status tstatus, t.datum tdatum, ".
		"t.naslov tnaslov, t.prioritet tprioritet, t.vrsta tvrsta ".
		"FROM tiketi t, serveri s, boxip b ".
		"WHERE t.user_id = '".$_SESSION['klijentid']."' AND t.status = '2' AND s.id = t.server_id AND b.ipid = s.ip_id ".
		"ORDER BY t.id DESC ";

$sql940 =  "SELECT s.box_id sboxid, s.port sport, b.ip bip, t.id tid, t.server_id tsrvid, t.user_id tuid, t.status tstatus, t.datum tdatum, ".
		"t.naslov tnaslov, t.prioritet tprioritet, t.vrsta tvrsta ".
		"FROM tiketi t, serveri s, boxip b ".
		"WHERE t.user_id = '".$_SESSION['klijentid']."' AND t.status = '1' AND s.id = t.server_id AND b.ipid = s.ip_id ".
		"ORDER BY t.id DESC ";

$tiketi44 = mysql_query($sql44) or die(mysql_error());
		
$tiketi = mysql_query($sql) or die(mysql_error());
$tiketi2 = mysql_query($sql2) or die(mysql_error());
$tiketi3 = mysql_query($sql3) or die(mysql_error());
$tiketi939 = mysql_query($sql939) or die(mysql_error());
$tiketi940 = mysql_query($sql940) or die(mysql_error());

$broj_tiketa = mysql_num_rows($tiketi3);
$broj_zakljucanih_tiketa = mysql_num_rows($tiketi2);
$broj_otvorenih_tiketa = mysql_num_rows($tiketi940);
$broj_odgovorenih_tiketa = mysql_num_rows($tiketi939);
include("./assets/header.php");

?>
   <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-podrska.php?pokazi=sve"><li <?php if($_GET['pokazi'] === "sve") { ?> class="panel-nav-active" <?php } ?><?php if(empty($_GET['pokazi'])) { ?> class="panel-nav-active" <?php } ?>>Arhiva</li></a>

                    <a href="novi-tiket.php"> <li>Novi Tiket</li></a>
                    <a href="gp-podrska.php?pokazi=zakljucani"><li <?php if($_GET['pokazi'] === "zakljucani") { ?> class="panel-nav-active" <?php } ?>>Zaključani tiketi</li></a>
                    <li>Live Chat</li>
                    <li>Email Support</li>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-ticket-alt"></i> Tiketi</h4>
                        <p>Ovdje možete pogledati čitavu historiju Vaših tiketa!</p>
                    </div>
                    <div class="ticket-status">
                        <ul>
                            <li>
                                <h3 class="c-blue">Ukupno</h3>
                                <h4><?php echo $broj_tiketa; ?></h4>
                            </li>
                            <li>
                                <h3 class="c-green"></i>Otvoreno</h3>
                                <h4><?php echo $broj_otvorenih_tiketa; ?></h4>
                            </li>
                             <li>
                                <h3 class="c-yellow"></i>Odgovoreno</h3>
                                <h4><?php echo $broj_odgovorenih_tiketa; ?></h4>
                            </li>
                            <li>
                                <h3 class="c-red"></i>Zaključano</h3>
                                <h4><?php echo $broj_zakljucanih_tiketa; ?></h4>
                            </li>
                        </ul>
                    </div>
                    <div class="user-servers">			
<?php	
		
		if(isset($_GET['pokazi']))
		{
			if($_GET['pokazi'] == "zakljucani")
			{
				if(mysql_num_rows($tiketi2) == 0) echo'<div class="user-no-tickets"><p><i class="fas fa-exclamation-triangle"></i> '.$jezik['text362'].'</p></div>';
				while($row = mysql_fetch_array($tiketi2)){	
							
				if($row['tnaslov'] == "Billing: <z>Nova uplata</z>" or $row['tnaslov'] == "Billing: Nova uplata - Leglo" or $row['tnaslov'] == "Billing: Nova uplata - Nije leglo"){
					$server = $jezik['text363'];
				}
				else
				{
					$server = $row['bip'].":".$row['sport'];
				}
				
				$tiket = query_fetch_assoc("SELECT * FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."' ORDER BY `id` DESC LIMIT 1");
				
				$brporuka = query_numrows("SELECT `id` FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."'");
		?>
	<div class="user-server-single">
     <table>
        <tr>
             <th><?php echo $jezik['text353']; ?></th>
             <td>#<?php echo $row['tid']; ?></td>
        </tr>

        <tr>
			<th><?php echo $jezik['text354']; ?></th>
			<td><a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><?php echo $row['tnaslov']; ?></a></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text355']; ?></th>
			<td><?php echo $server; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text356']; ?></th>
			<td><?php echo vreme($row['tdatum']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text357']; ?></th>
			<td><?php if(isset($tiket['admin_id'])) { echo 'Support'; } else { echo 'Klijent'; } ?></td>

		</tr>

		<tr>
			<th><?php echo $jezik['text358']; ?></th>
			<td><?php echo $brporuka; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text359']; ?></th>
			<td><?php echo tiket_prioritet($row['tprioritet']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text360']; ?></th>
			<td><?php echo tiket_status($row['tstatus']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text361']; ?></th>
			<td>
							<a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><button  type="submit"><i class="fas fa-search"></i> Pregled</button></a>
					</td>
		</tr>
	</table>
</div>
		<?php	}				
			}
			else if($_GET['pokazi'] == "sve")
			{
				if(mysql_num_rows($tiketi3) == 0) echo'<tr><td colspan="9">'.$jezik['text364'].'</td></tr>';
				while($row = mysql_fetch_array($tiketi3)){	
							
				if($row['tnaslov'] == "Billing: <z>Nova uplata</z>" or $row['tnaslov'] == "Billing: Nova uplata - Leglo" or $row['tnaslov'] == "Billing: Nova uplata - Nije leglo"){
					$server = $jezik['text363'];
				}
				else
				{
					$server = $row['bip'].":".$row['sport'];
				}
				
				$tiket = query_fetch_assoc("SELECT * FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."' ORDER BY `id` DESC LIMIT 1");
				
				$brporuka = query_numrows("SELECT `id` FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."'");
		?>
		<div class="user-server-single">
     <table>
        <tr>
             <th><?php echo $jezik['text353']; ?></th>
             <td>#<?php echo $row['tid']; ?></td>
        </tr>

        <tr>
			<th><?php echo $jezik['text354']; ?></th>
			<td><a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><?php echo $row['tnaslov']; ?></a></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text355']; ?></th>
			<td><?php echo $server; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text356']; ?></th>
			<td><?php echo vreme($row['tdatum']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text357']; ?></th>
			<td><?php if(isset($tiket['admin_id'])) { echo 'Support'; } else { echo 'Klijent'; } ?></td>

		</tr>

		<tr>
			<th><?php echo $jezik['text358']; ?></th>
			<td><?php echo $brporuka; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text359']; ?></th>
			<td><?php echo tiket_prioritet($row['tprioritet']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text360']; ?></th>
			<td><?php echo tiket_status($row['tstatus']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text361']; ?></th>
			<td>
				<a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><button type="submit"><i class="fas fa-search"></i> Pregled</button></a>
					</td>
		</tr>
	</table>
</div>
		<?php	}				
			}
			else
			{
				header("Location: gp-podrska.php");
			}
		}
		else
		{
			if(mysql_num_rows($tiketi) == 0) 
				echo'<div class="user-no-servers"><p>'.$jezik['text367'].'</p></div>';
			
			while($row = mysql_fetch_array($tiketi)){	
					
			if($row['tnaslov'] == "Billing: <z>Nova uplata</z>" or $row['tnaslov'] == "Billing: Nova uplata - Leglo" or $row['tnaslov'] == "Billing: Nova uplata - Nije leglo"){
				$server = $jezik['text363'];
			}
			else
			{
				$server = $row['bip'].":".$row['sport'];
			}
		
			$tiket = query_fetch_assoc("SELECT * FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."' ORDER BY `id` DESC LIMIT 1");
		
			$brporuka = query_numrows("SELECT `id` FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."'");
?>
<div class="user-server-single">
     <table>
        <tr>
             <th><?php echo $jezik['text353']; ?></th>
             <td>#<?php echo $row['tid']; ?></td>
        </tr>

        <tr>
			<th><?php echo $jezik['text354']; ?></th>
			<td><a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><?php echo $row['tnaslov']; ?></a></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text355']; ?></th>
			<td><?php echo $server; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text356']; ?></th>
			<td><?php echo vreme($row['tdatum']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text357']; ?></th>
			<td><?php if(isset($tiket['admin_id'])) { echo 'Support'; } else { echo 'Klijent'; } ?></td>

		</tr>

		<tr>
			<th><?php echo $jezik['text358']; ?></th>
			<td><?php echo $brporuka; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text359']; ?></th>
			<td><?php echo tiket_prioritet($row['tprioritet']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text360']; ?></th>
			<td><?php echo tiket_status($row['tstatus']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text361']; ?></th>
			<td>
							<a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><button type="submit"><i class="fas fa-search"></i> Pregled</button></a>
					</td>
		</tr>
	</table>
</div>
<?php
			}
		
		

       	    while($row = mysql_fetch_array($tiketi44)){	
					
			if($row['tnaslov'] == "Billing: <z>Nova uplata</z>" or $row['tnaslov'] == "Billing: Nova uplata - Leglo" or $row['tnaslov'] == "Billing: Nova uplata - Nije leglo"){
				$server = $jezik['text363'];
			}
			else
			{
				$server = $row['bip'].":".$row['sport'];
			}
		
			$tiket = query_fetch_assoc("SELECT * FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."' ORDER BY `id` DESC LIMIT 1");
		
			$brporuka = query_numrows("SELECT `id` FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['tid']."'");
?>
     <table>
        <tr>
             <th><?php echo $jezik['text353']; ?></th>
             <td>#<?php echo $row['tid']; ?></td>
        </tr>

        <tr>
			<th><?php echo $jezik['text354']; ?></th>
			<td><a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><?php echo $row['tnaslov']; ?></a></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text355']; ?></th>
			<td><?php echo $server; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text356']; ?></th>
			<td><?php echo vreme($row['tdatum']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text357']; ?></th>
			<td><?php if(isset($tiket['admin_id'])) { echo 'Support'; } else { echo 'Klijent'; } ?></td>

		</tr>

		<tr>
			<th><?php echo $jezik['text358']; ?></th>
			<td><?php echo $brporuka; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text359']; ?></th>
			<td><?php echo tiket_prioritet($row['tprioritet']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text360']; ?></th>
			<td><?php echo tiket_status($row['tstatus']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text361']; ?></th>
			<td>
							<a href="gp-tiket.php?id=<?php echo $row['tid']; ?>"><button  type="submit"><i class="fas fa-search"></i> Pregled</button></a>
					</td>
		</tr>
	</table>
<?php
			}
		
		}
?>		
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("./assets/footer.php");
?>