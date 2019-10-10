<?php
session_start();
include("includes.php");		
$naslov = $jezik['text498'];
$fajl = "naruci";
$return = "naruci";
if(!isset($_GET['serverid'])){
	$_SESSION['msg'] = $jezik['text499'];
	header("Location: naruci-zahtev.php");
	die();
}
if(!isset($_GET['klijentid'])){
	$_SESSION['msg'] = $jezik['text500'];
	header("Location: naruci-zahtev.php");
	die();
}
if(isset($_GET['ip']))
{
	$ip = mysql_real_escape_string($_GET['ip']);
	$ip = htmlspecialchars($ip);
					
	$ipm = explode("_", $ip);
					
	unset($ip);
					
	$ip = $ipm[0];
	$boxid = $ipm[1];
					
	$ipid = $ip;
	$boxidd = $boxid;
	
	$masina = query_fetch_assoc("SELECT `boxid`, `ip`, `name`, `sshport`, `maxsrv` FROM `box` WHERE `boxid` = '".$boxid."'");
					
	$ip = query_fetch_assoc("SELECT `ip` FROM `boxip` WHERE `boxid` = '".$boxid."'");
					
	if(getStatus($ip['ip'], $masina['sshport']) == "Offline" || $masina['maxsrv'] < query_numrows("SELECT `id` FROM `serveri` WHERE `box_id` = '".$masina['boxid']."'"))
	{
		$_SESSION['msg'] = $jezik['text501'];
		header("Location: naruci-zahtev.php");
		die();
	}
}
$serverid = mysql_real_escape_string($_GET['serverid']);
$serverid = htmlspecialchars($serverid);
$klijentid = mysql_real_escape_string($_GET['klijentid']);
$klijentid = htmlspecialchars($klijentid);
if(query_numrows("SELECT * FROM `serveri_naruceni` WHERE `id` = '".$serverid."' AND `klijentid` = '".$klijentid."' AND `status` = 'Uplacen'") == 0)
{
	$_SESSION['msg'] = $jezik['text502'];
	header("Location: naruci-zahtev.php");	
	die();
}
$srv = query_fetch_assoc("SELECT * FROM `serveri_naruceni` WHERE `id` = '".$serverid."' AND `klijentid` = '".$klijentid."' AND `status` = 'Uplacen'");
//$sql = "SELECT m.boxid boxid, m.ip ip, m.maxsrv maxsrv, ";
$masinaa = mysql_query("SELECT * FROM `boxip`");
include("./assets/header.php");
$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$_SESSION['klijentid']."'");
//$billing = mysql_query("SELECT * FROM `billing` WHERE `klijentid` =  '".$_SESSION['klijentid']."' ORDER BY `id`");
if($srv['igra'] == "1") { $gsg12 = "cs"; $igrag = "Counter-Strike 1.6"; } if($srv['igra'] == "2") { $gsg12 = "samp"; $igrag = "GTA San Andreas Multiplayer"; }
if($srv['igra'] == "3") { $gsg12 = "minecraft"; $igrag = "Minecraft"; } if($srv['igra'] == "4") { $gsg12 = "cod"; $igrag = "Call of Duty 4"; }
$sqlw = mysql_query("SELECT * FROM `modovi` WHERE `igra` = '".$srv['igra']."'");
?>
    <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-serveri.php"><li>Moji Serveri</li></a>
                    <a href="naruci-zahtev.php"><li>Zahtjevi</li></a>
                    <a href="naruci.php?nacin=1&lokacija=2&igra=1"><li>Naruči Server</li></a>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-server"></i> Instalacija Servera</h4>
                        <p>Instalirajte Vaš server!</p>

                         <h3>Instalacija <?php echo $igrag; ?> servera, <?php echo $srv['slotovi']; ?> slotova</h3>
                    </div>

		<?php	if(!isset($_GET['ip'])){	?>
			<div class="new-ticket">
				<form action="naruci-instaliraj.php" method="GET">
					<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
					<input type="hidden" name="klijentid" value="<?php echo $klijentid; ?>" />
					<div class="form-input">
					<select id="drzs" name="ip">
<?php
			if(mysql_num_rows($masinaa) == 0) { echo '<option disabled>'.$jezik['text506'].'</option>'; }
			while($row = mysql_fetch_array($masinaa)) {	
				$masina = query_fetch_assoc("SELECT `boxid`, `ip`, `name`, `sshport`, `maxsrv` FROM `box` WHERE `boxid` = '".$row['boxid']."'");
				if(getStatus($row['ip'], $masina['sshport']) == "Online") {
					if($masina['maxsrv'] > query_numrows("SELECT `id` FROM `serveri` WHERE `box_id` = '".$masina['boxid']."'")) {
						$ip = query_fetch_assoc("SELECT `ip`, `ipid` FROM `boxip` WHERE `boxid` = '".$masina['boxid']."'");
?>
						
						<option value="<?php echo $row['ipid'].'_'.$row['boxid']; ?>"><?php echo $row['ip'].' - '.$masina['name']; ?></option>
<?php	
					}
				}
			}	
?>
					</select></div>
				<div class="form-input">
					<button type="submit"><i class="icon-arrow-right"></i> <?php echo $jezik['text471']; ?></button>
				</div>
			</form>
		</div>
<?php	
				}	
				else if(isset($_GET['ip']))
				{
				
					$ip = mysql_real_escape_string($_GET['ip']);
					$ip = htmlspecialchars($ip);
					
					$ipm = explode("_", $ip);
					
					unset($ip);
					
					$ip = $ipm[0];
					$boxid = $ipm[1];
					
					$ipid = $ip;
					$boxidd = $boxid;
	
					$masina = query_fetch_assoc("SELECT `boxid`, `ip`, `name`, `sshport`, `maxsrv` FROM `box` WHERE `boxid` = '".$boxid."'");
					
					$ip = query_fetch_assoc("SELECT `ip` FROM `boxip` WHERE `boxid` = '".$boxid."'");
					
					if(getStatus($ip['ip'], $masina['sshport']) == "Offline" || $masina['maxsrv'] < query_numrows("SELECT `id` FROM `serveri` WHERE `box_id` = '".$masina['boxid']."'"))
					{
						$_SESSION['msg'] = $jezik['text501'];
						header("Location: naruci-zahtev.php");
						die();
					}
					/*------------------------------------*/
					// IP
					if($srv['igra'] == "1")
					{
						for($port = 27015; $port <= 29999; $port++)
						{
							if(query_numrows("SELECT * FROM `serveri` WHERE `ip_id` = '".$ipid."' AND `port` = '".$port."' LIMIT 1") == 0)
							{
								require("./includes/libs/lgsl/lgsl_class.php");
								$serverl = lgsl_query_live('halflife', $ip['ip'], NULL, $port, NULL, 's');
								if(@$serverl['b']['status'] == '1') $srvonline = $jezik['text218'];
								else $srvonline = $jezik['text219'];	
								if($srvonline == $jezik['text219'])
								{
									$port = $port;
									break;
								}
							}
						}
					}
					else if($srv['igra'] == "2")
					{
						for($port = 7787; $port <= 9999; $port++)
						{
							if(query_numrows("SELECT * FROM `serveri` WHERE `box_id` = '".$boxid."' AND `port` = '".$port."' LIMIT 1") == 0)
							{
								require("./includes/libs/lgsl/lgsl_class.php");
								$serverl = lgsl_query_live('samp', $masina['ip'], NULL, $port, NULL, 's');
								if(@$serverl['b']['status'] == '1') $srvonline = $jezik['text218'];
								else $srvonline = $jezik['text219'];	
								if($srvonline == $jezik['text219'])
								{
									$port = $port;
									break;
								}
							}
						}					
					}
					else if($srv['igra'] == "3")
					{
						for($port = 25565; $port <= 25999; $port++)
						{
							if(query_numrows("SELECT * FROM `serveri` WHERE `box_id` = '".$boxid."' AND `port` = '".$port."' LIMIT 1") == 0)
							{
								require("./includes/libs/lgsl/lgsl_class.php");
								$serverl = lgsl_query_live('minecraft', $ip['ip'], NULL, $port, NULL, 's');
								if(@$serverl['b']['status'] == '1') $srvonline = $jezik['text218'];
								else $srvonline = $jezik['text219'];	
								if($srvonline == $jezik['text219'])
								{
									$port = $port;
									break;
								}
							}
						}					
					}
					/*------------------------------------*/					
					
?>

<div class="new-ticket">
				<form action="process.php" method="POST">

					<div class<="form-input">
						<label>*<?php echo $jezik['text512']; ?></label>
					    <input name="ime" type="text" placeholder="<?php echo $jezik['text512']; ?>" required>
					</div>  
							<div class="form-input">
							<label>*<?php echo $jezik['text513']; ?></label>						
								<select name="mod" required>
<?php	
								if($srv['igra'] == "1") {
									while($row = mysql_fetch_array($sqlw)) 
									{
?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['ime']; ?></option>							
<?php	
									}
								} 
								else if($srv['igra'] == "2") 
								{	
									while($row = mysql_fetch_array($sqlw)) 
									{
?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['ime']; ?></option>							
<?php	
									}	
								}
								else if($srv['igra'] == "3") 
								{	
									while($row = mysql_fetch_array($sqlw)) 
									{
?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['ime']; ?></option>							
<?php	
									}	
								}
								else if($srv['igra'] == "4") 
								{	
									while($row = mysql_fetch_array($sqlw)) 
									{
?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['ime']; ?></option>							
<?php	
									}	
								}								
?>
								</select>
							</div>   						

							<div class="form-input">
								<label>*<?php echo $jezik['text514']; ?></label>
								<input name="headuser" type="text" placeholder="Pera" required>				
							</div>

							<div class="form-input">
								<label>*<?php echo $jezik['text515']; ?></label>
								<input name="headpass" type="password" placeholder="Password" required>
								</div>  

								<input type="hidden" name="task" value="instalirajserver" />
								<input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
								<input type="hidden" name="igra" value="<?php echo  $srv['igra']; ?>" />
								<input type="hidden" name="cena" value="<?php echo  $srv['cena']; ?>" />
								<input type="hidden" name="slotovi" value="<?php echo  $srv['slotovi']; ?>" />
								<input type="hidden" name="port" value="<?php echo  $port; ?>" />
								<input type="hidden" name="meseci" value="<?php echo $srv['meseci']; ?>" />
								<input type="hidden" name="ipid" value="<?php echo $ipid; ?>" />
								<input type="hidden" name="boxid" value="<?php echo $boxidd; ?>" />
								<input type="hidden" name="narsrvid" value="<?php echo $serverid; ?>" />
								<div class="form-input">
								<button type="submit"><i class="icon-arrow-right"></i> <?php echo $jezik['text516']; ?></button>
							</div>
				</form>
			</div>
		<?php	}	?>
	</div>
</div>
</div>
</div>
<?php
include("./assets/footer.php");
?>