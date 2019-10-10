<?php
session_start();
include("includes.php");
$naslov = $jezik['text320'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";
$gpr = "1";
$gps = "gp-backup";

$basename = basename($_SERVER['REQUEST_URI']);




if(klijentServeri($_SESSION['klijentid']) == 0)
{
	$_SESSION['msg'] = $jezik['text300'];
	header("Location: index.php");
}



/*if($_SESSION['klijentid'] != 652)
{
	$_SESSION['msg'] = "Soon.";
	header("Location: index.php");
}*/

$serverid = mysql_real_escape_string($_GET['id']);

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}

if(!isset($_GET['id']) or !is_numeric($_GET['id']))
{
	$_SESSION['msg'] = $jezik['text311'];
	header("Location: gp-serveri.php");
	die();
}

if(query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '".$_SESSION['klijentid']."' AND `id` = '".$serverid."'") == 0)
{
	$_SESSION['msg'] = $jezik['text312'];
	header("Location: gp-serveri.php");
	die();
}

$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '{$serverid}'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '{$server['ip_id']}'");


include("./assets/header.php"); ?>
   <div class="main">
        <div class="panel">
             <div class="panel-nav">
                    <ul class="light-border">
                        <a href="gp-server.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-server") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-flag"></i> <?php echo $jezik['text20']; ?>
                            </li>
                        </a>
                        <a href="gp-webftp.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-webftp") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-folder-open"></i> <?php echo $jezik['text21']; ?>
                            </li>
                        </a>
<?php
                        if($server['igra'] == "1") {
?>
                        <a href="gp-admini.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-admini") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-group"></i> <?php echo $jezik['text22']; ?>
                            </li>
                        </a>
                        <a href="gp-plugins.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-plugins") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo $jezik['text23']; ?>
                            </li>
                        </a>
<?php
                        }
?>
                        <a href="gp-modovi.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-modovi") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo $jezik['text24']; ?>
                            </li>
                        </a>
                        <a href="gp-konzola.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-konzola") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-th-list"></i> Console
                            </li>
                        </a>
                        <!--<a href="gp-backup2.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-backup2") echo 'class="active"'; ?>>
                                <i class="icon-download"></i> Backup
                            </li>
                        </a>-->
                        <a href="gp-reinstall.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-reinstall") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-refresh"></i> <?php echo $jezik['text25']; ?>
                            </li>
                        </a>
                        <a href="gp-transfer.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-transfer") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo "Transfer"; ?>
                            </li>
                        </a>



<?php
                        if($server['igra'] == "1") {
?>
                        <a href="gp-boost.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-boost") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-random"></i> <?php echo $jezik['text26']; ?>
                            </li>
                        </a>

<?php
                        }
?>
                                                <a href="gp-autorestart.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-autorestart") echo 'class="panel-nav-active"'; ?>><i class="icon-refresh"></i> AutoRR</li>
                        </a>


                    </ul>
                </div>


            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-server"></i> BackUP</h4>
                        <p>Sačuvajte podatke servera. Maksimalno mozete uraditi jedan backup, svi ostali ce zamenjivati prvi.</p>
                        <?php if (mysql_num_rows($result) <= 0) { ?>
			           <h3>Nije pronađen nijedan BackUP</h3>
		               <?php } ?>
		<form action="serverprocess.php" method="post">
		    <?php echo $cg2->generateHiddenField( "server-backup2", "bfe7507954135d") . "\n"; ?>
			<input type="hidden" name="task" value="server-backup2" />
			<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
			<button type="submit"><i class="icon-upload"></i> Napravi backup</button>
		</form>
</div>

<div class="user-servers">
<?php
$cg2 = new CSRFGuard();
?>

<?php	
		
		$query = "SELECT * FROM `server_backup` WHERE `srvid` = '" . $serverid . "'";
		if (!($result = mysql_query($query))) {
			//exit("Failed!! " . mysql_error());
			$error = "Failed!!";
		}
		if (mysql_num_rows($result) <= 0) {
		} else {
			
			while ($line = mysql_fetch_assoc($result)) {
				$id += 1;
				
				$date = date('d.m.Y - H:i:s', $line['time']);
				$size = $line['size'];
				$status = $line['status'];
				$idb = $line['id'];
				
				/*$c = new Cipher();
				$encrypted = $c->encrypt($name);
				$name = $encrypted;*/
				
				if($status == "copying") 
					$status2 = "<td><font class='c-yellow'>Copying files...</font></td>";
				else if($status == "ok") 
					$status2 = "<td><font class='c-green'>Available</font></td>";
				else if($status == "restore") 
					$status2 = "<td><font class='c-yellow'>Restoring...</font></td>";
				else if($status == "error1" || $status == "error2" || $status == "error3") 
					$status2 = "<td><font class='c-red'>Error!</font></td>";
				
				?>
	<div class="user-server-single">
		<table>
			<tr>
				<th>ID</th>
				<td>#<?php echo $id; ?></td>
			</tr>

			<tr>
				<th>Date</th>
				<td><?php echo $date; ?></td>
			</tr>

			<tr>
				<th>Size</th>
				<td><?php echo $size; ?></td>
			</tr>

			<tr>
				<th>Status</th>
				<?php echo $status2; ?>
			</tr>

			<tr>
				<th>Action</th>
				<?php if($status == "ok") {	?>	
				<td>
			<form action= \"serverprocess.php\" method=\"post\">";echo $cg2->generateHiddenField( "server-restorebackup2", "bfe7507954135d") . "\n";
			echo "<input type=\"hidden\" name=\"data\" value=\"$idb\" />
			<input type=\"hidden\" name=\"task\" value=\"server-restorebackup2\" />
			<input type=\"hidden\" name=\"serverid\" value=\"$serverid\" />
			<button onclick=\"return confirm('Do you really want to restore this backup?\\nThe data can NOT be recovered!')\"> <i class=\"icon-download\"></i> Restore</button></button>
				</form>
				
				
			<form action= \"serverprocess.php\" method=\"post\">";echo $cg2->generateHiddenField( "server-delbackup2", "bfe7507954135d") . "\n";
			echo "<input type=\"hidden\" name=\"data\" value=\"$idb\" />
			<input type=\"hidden\" name=\"task\" value=\"server-delbackup2\" />
			<input type=\"hidden\" name=\"serverid\" value=\"$serverid\" />
			<button onclick=\"return confirm('Do you really want to delete this backup?\\nThe data can NOT be recovered!')\"> <i class=\"icon-download\"></i> Delete</button></button>
				</form>	
				</td>
			</tr></table></div>
			<?php 
			
			}
		}
	}


			
?>			
		
	
</div></div></div>
	</div>
</div>
<?php
include("./assets/footer.php");
?>