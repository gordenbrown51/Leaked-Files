<?php
session_start();

include("includes.php");		
$naslov = $jezik['text517'];
$fajl = "naruci";
$return = "naruci";
$ucp = "naruci-zahtev";


include("./assets/header.php");

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}

$sql =  "SELECT s.id sid, s.klijentid sklijentid, s.igra sigra, s.lokacija slokacija, s.slotovi sslotovi, s.meseci smeseci, s.status sstatus, s.cena scena, u.zemlja uzemlja ".
		"FROM serveri_naruceni s, klijenti u ".
		"WHERE s.klijentid = '".$_SESSION['klijentid']."' AND u.klijentid = '".$_SESSION['klijentid']."' ".
		"ORDER BY s.status ASC";

$tiketi = mysql_query($sql);				
?>
<body>
    <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-serveri.php"><li>Moji Serveri</li></a>
                    <a href="naruci-zahtev.php"><li class="panel-nav-active">Zahtjevi</li></a>
                    <a href="naruci.php?nacin=1&lokacija=2&igra=1"><li>Naruči Server</li></a>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-server"></i> Naručeni serveri</h4>
                        <p>Ovdje možete pogledati Vašu listu naručenih servera.</p>
<?php   
        if(mysql_num_rows($tiketi) == 0) echo'<h3><i class="fas fa-exclamation-triangle"></i> '.$jezik['text529'].'</h3>';
        while($row = mysql_fetch_array($tiketi)){   

        $test = explode(" ", novac($row['scena'], $row['uzemlja']));
        $cena[] = $test[0];
?>
                    </div>

                    <div class="user-servers">
     <div class="user-server-single">
                        <table>
                            <tr>
                                <th>ID</th>
                                <td>#<?php echo $row['sid']; ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $jezik['text522']; ?></th>
                                <td><a href="#"><?php echo igra($row['sigra']); ?></a></td>
                            </tr>

                            <tr>
                                <th><?php echo $jezik['text523']; ?></th>
                                <td><?php echo lokacija_ded($row['slokacija']); ?></td>
                            </tr>
                            <tr> 
                                <?php if($row['sigra'] == "3") { ?>
                                <th>Memorija</th>
                                <td><?php echo $row['sslotovi']; ?> GB</td>
                                <?php } else { ?>
                                <th><?php echo $jezik['text524']; ?></th>
                                <td><?php echo $row['sslotovi']; ?></td>
                                <?php } ?>
                            </tr>

                            <tr>
                                <th><?php echo $jezik['text525']; ?></th>
                                <td><?php echo $row['smeseci']; ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $jezik['text526']; ?></th>
                                <td><?php echo novac($row['scena'], $row['uzemlja']); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $jezik['text527']; ?></th>
                                <?php if($row['sstatus'] == "Na cekanju" OR $row['sstatus'] == "Nije uplacen") {	?>
                                <td class="c-yellow"><?php echo $row['sstatus']; ?></td>
                            <?php } else { ?>
                            	<td class="c-green"><?php echo $row['sstatus']; ?></td>
                            <?php }; ?>
                            </tr>

                                
                                
                                
		<?php	if($row['sstatus'] == "Na cekanju" OR $row['sstatus'] == "Nije uplacen") {	?>
			<tr>
				<th><?php echo $jezik['text528']; ?></th>
               <td>
				<form action="process.php" method="post">
					<input type="hidden" name="task" value="uplati-server" />
					<input type="hidden" name="serverid" value="<?php echo $row['sid']; ?>" />
					<input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
					<button type="submit" id="ah">
						<i class="icon-credit-card"></i> Plati
					</button>
				</form>
				<form action="process.php" method="POST">
					<input type="hidden" name="task" value="otkazi-server" />
					<input type="hidden" name="serverid" value="<?php echo $row['sid']; ?>" />
					<input type="hidden" id="serverid" value="<?php echo $row['sid']; ?>" />
					<button type="submit" id="ah">
						<i class="icon-remove"></i> Otkaži
					</button>
				</form>	
				</td>
			</tr>
             </table>	
             			         </div>
		<?php	}else{	?>
		<tr>
			<th><?php echo $jezik['text528']; ?></th>
                <td>
				<form action="naruci-instaliraj.php" method="GET">
					<input type="hidden" name="serverid" value="<?php echo $row['sid']; ?>" />
					<input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
					<button type="submit" id="ah">
						<i class="icon-credit-card"></i> Instaliraj
					</button>
				</form>
				<form action="process.php" method="POST">
					<input type="hidden" name="task" value="povrati-novac" />
					<input type="hidden" name="serverid" value="<?php echo $row['sid']; ?>" />
					<input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
					<button type="submit" id="ah">
						<i class="icon-remove"></i> Povrati Novac
					</button>
				</form>
				</td>
			</tr>
  </table>
  			</div>
			<?php } }; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("./assets/footer.php");
?>