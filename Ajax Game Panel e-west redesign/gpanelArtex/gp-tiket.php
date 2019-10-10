<?php
session_start();

$naslov = $jezik['text416'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-podrska";

include("includes.php");
require_once './includes/libs/GameQ.php';


if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
	die();
}


$idtiketa = mysql_real_escape_string($_GET['id']);
$idtiketa = htmlspecialchars($idtiketa);

if(!isset($idtiketa))
{
	$_SESSION['msg'] = $jezik['text417'];
	header("Location: gp-tiket.php?id=". $idtiketa ."");
	die();
}


$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$_SESSION['klijentid']."'");

if(query_numrows("SELECT `id` FROM `tiketi` WHERE `id` = '".$idtiketa."' AND `user_id` = '".$klijent['klijentid']."'") == 0)
{
	$_SESSION['msg'] = $jezik['text418'];
	header("Location: gp-podrska.php");	
}

$billing = mysql_query("SELECT * FROM `billing` WHERE `klijentid` =  '".$_SESSION['klijentid']."' AND `status` = 'Leglo' or `status` = 'Nije leglo' ORDER BY `id`");

$sql =  "SELECT * FROM `tiketi_odgovori` WHERE `tiket_id` = '".$idtiketa."' ORDER BY `vreme_odgovora`";
$tiket = mysql_query($sql);

$tiketinf = query_fetch_assoc("SELECT * FROM `tiketi` WHERE `id` = '".$idtiketa."'");

$serverb = query_numrows("SELECT * FROM `tiketi` WHERE `id` = '".$idtiketa."' AND `naslov` LIKE 'Billing:%'");

if(!$serverb == "1") 
{
	require("./includes/libs/lgsl/lgsl_class.php");
	$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$tiketinf['server_id']."'");
	
	$ip = ipadresa($server['id']);
	$ip = explode(":", $ip);	

	if($server['igra'] == "1") $querytype = "halflife";
	else if($server['igra'] == "2") $querytype = "samp";	
	else if($server['igra'] == "3") $querytype = "minecraft";

	if($server['status'] == "Aktivan" AND $server['startovan'] == "1")
	{
		$serverl = lgsl_query_live($querytype, $ip[0], NULL, $server['port'], NULL, 's');
		
		$srvmapa = @$serverl['s']['map'];
		$srvime = @$serverl['s']['name'];
		$srvigraci = @$serverl['s']['players'].'/'.@$serverl['s']['playersmax'];
	}

	if(@$serverl['b']['status'] == '1') $srvonline = $jezik['text218'];
	else $srvonline = $jezik['text219'];	


}

include("./assets/header.php");

					$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$tiketinf['server_id']."'");
					$box = query_fetch_assoc("SELECT * FROM `box` WHERE `boxid` = '".$server['box_id']."'");
					$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$server['ip_id']."'");
?>

   <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-podrska.php?pokazi=sve"><li>Arhiva</li></a>
                    <a href="novi-tiket.php"> <li>Novi Tiket</li></a>
                    <a href="gp-podrska.php?pokazi=zakljucani"><li>Zaključani tiketi</li></a>
                    <li>Live Chat</li>
                    <li>Email Support</li>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-header light-border">
                    		<?php echo tikett_status_mirza_panel($tiketinf['status']); ?> <p class="bold"><?php echo $tiketinf['naslov']; ?> - <?php echo vreme($tiketinf['datum']); ?></p>


                    		<?php
					if($tiketinf['status'] == 3) {
?>					
						<form action="process.php" method="post">
							<input type="hidden" name="task" value="tiket-odkljucaj" />
							<input type="hidden" name="tiket-id" value="<?php echo $idtiketa; ?>" />
							<button class="bg-green c-white" type="submit"><i class="icon-unlock" ></i> <?php echo $jezik['text431']; ?></button>
						</form>	
<?php
					} else {
?>							
						<form action="process.php" method="post">
							<input type="hidden" name="task" value="tiket-zakljucaj" />
							<input type="hidden" name="tiket-id" value="<?php echo $idtiketa; ?>" />
							<button class="bg-red c-white" type="submit"><i class="icon-lock" ></i> <?php echo $jezik['text432']; ?></button>
						</form>
<?php
					} if($serverb != "1") {
?>
						<button class="c-white bg-blue" onclick="location = 'gp-server.php?id=<?php echo $server['id']; ?>'"><i class="fas fa-arrow-right"></i> Server</button>
<?php
					}
?>

                    </div>
        <?php
				$q = query_fetch_assoc("SELECT * FROM `tiketi_odgovori` WHERE `user_id` = '".$_SESSION['klijentid']."' AND `tiket_id` = '".$idtiketa."' ORDER BY `id` DESC LIMIT 1");
?>
<?php
				if($tiketinf['status'] == 1 OR $tiketinf['status'] == 8) echo'<div class="user-no-tickets" style="margin-top: 10px"><p>'.$jezik['text436'].'</p></div>';
				else if($tiketinf['status'] == 4) echo'<div class="user-no-tickets" style="margin-top: 10px"><p>'.$jezik['text437'].'</p></div>';
				else if($tiketinf['status'] == 3) echo'<div class="user-no-tickets" style="margin-top: 10px"><p>'.$jezik['text438'].'</p></div>';
?>
<?php		
			if(mysql_num_rows($tiket) == 0) echo $jezik['text443'];
			while($row = mysql_fetch_array($tiket)) {	
				$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$row['user_id']."'");
				$admin = query_fetch_assoc("SELECT * FROM `admin` WHERE `id` = '".$row['admin_id']."'");
?>
<?php 
					if($row['admin_id'] != NULL)
					{ ?>

									<div class="ticket-msg">
                    	<div class="ticket-msg-header">
                    		<div class="ticket-msg-header-img">
                    			<?php echo avatar($row['admin_id']); ?>	
                    		</div>

                    		<div class="ticket-msg-header-layer1">
                    			<h4><?php echo $admin['fname'] . "". $admin['lname']; ?>  - <font class="c-red"><?php echo adminRank($admin['status']) ?></font></h4> 
                    			<h3><?php echo vreme($row['vreme_odgovora']); ?></h3>
                    		</div>


                    	<div class="ticket-msg-text">
                    		<p><?php echo makeClickableLinks($row['odgovor']); if(!empty($admin['signature'])) { echo $admin['signature']; }?></p>
                    	</div>
                    </div> 
                                        	</div>

<?php
					}
					else
					{ ?>
						                                             <div class="ticket-msg">
                         <div class="ticket-msg-header">
                              <div class="ticket-msg-header-img">
                                    <?php echo avatar($row['user_id']); ?>
                                 </div>                
                              <div class="ticket-msg-header-layer1">
                                   <h4><?php echo $klijent['ime'] . "". $klijent['prezime']; ?>  - <font class="c-blue"><?php echo $jezik['text435']; ?></font></h4> 
                                   <h3><?php echo vreme($row['vreme_odgovora']); ?></h3>
                              </div>
                         <div class="ticket-msg-text">
                              <p><?php echo $row['odgovor']; ?></p>
                         </div>         
                         </div>
                         </div>      
<?php
					}
?>
<?php
			}
				$q = query_fetch_assoc("SELECT * FROM `tiketi_odgovori` WHERE `user_id` = '".$_SESSION['klijentid']."' AND `tiket_id` = '".$idtiketa."' ORDER BY `id` DESC LIMIT 1");	
?>
<div class="ticket-answer" id="nav-to-ticket-answer">
				<form action="process.php" method="POST">
					<input type="hidden" name="task" value="tiketodg" />
					<input type="hidden" id="id" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
					<input type="hidden" id="tidd" name="tiketid" value="<?php echo $idtiketa; ?>" />
					<textarea <?php if($tiketinf['status'] != "2") { if($q['vreme_odgovora'] > (time()-300)) { echo 'readonly="readonly" style="cursor: wait;" placeholder="'.$jezik['text439'].'"'; } else if($tiketinf['status'] == 3) { echo ' readonly="readonly" style="cursor: wait;" placeholder="'.$jezik['text440'].'"'; } } else { echo ' placeholder="'.$jezik['text441'].'..."'; }?> rows="1" name="komentar" id="odgtextarea" class="komentar" placeholder="Napisi komentar..."></textarea>
					<button id="comment" type="submit"><i class="icon-exchange"></i> <?php echo $jezik['text442']; ?></button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
include("./assets/footer.php");
?>