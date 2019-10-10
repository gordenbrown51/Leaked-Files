<?php
session_start();
exit("---");
$naslov = $jezik['text320'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";
$gpr = "1";
$gps = "gp-backup";

$basename = basename($_SERVER['REQUEST_URI']);

include("includes.php");


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


include("./assets/header.php");

$cg2 = new CSRFGuard();
?>
	<div id="bsve">
		<i id="ib" class="icon-cog icon-spin icon-4x"></i>
		<p id="h5">Backup</p><br />
		<p>Backup možete uraditi kad god hoćete.</p><br />
		<p style="margin-top: -3px;">Maksimalno možete uraditi jedan backup, svi ostali će zamenjivati prvi.</p>	
		
		<form action="serverprocess.php" method="post">
		    <? echo $cg2->generateHiddenField( "server-backup", "bfe7507954135d") . "\n"; ?>
			<input type="hidden" name="task" value="server-backup" />
			<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
			<button type="submit" class="btn btn-warning btn-large btn-block" style="width: 35%; float: right; margin-top: -30px;"><i class="icon-upload"></i> Napravi backup</button>
		</form><br /><br />
		<table id="webftp">
			<tr>
				<th>ID</th>
				<th>Date</th>
				<th>Size</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
<?php			
		$listdata = get_backup_data($_SESSION['klijentid'],$serverid);
		
		
		
		if($listdata == false) 
		    echo '<tr><td colspan="5" align="center">Niste napravili nijednom backup.</td></tr>';
		else{
		foreach ( $listdata as $id => $fileinfo )
		{	
		    $id += 1;
			if($fileinfo['status'] == 4) 
			  continue;
			  
			echo "<tr>";
			
			if($fileinfo['status'] == 2) 
			        echo "<td colspan=\"5\" align=\"center\">Error. </td>";
			else{
				
		    echo "<td>#$id</td>";
			echo "<td>{$fileinfo['date']}</td>";
			echo "<td>{$fileinfo['size']}</td>";
			
			
			if($fileinfo['status'] == 0) 
			   echo "<td><font color=\"#E08010\">Processing...</font></td>";
			else if($fileinfo['status'] == 1) 
			   echo "<td><font color=\"#00FF00\">Available</font></td>";
			else if($fileinfo['status'] == 3) 
				echo "<td><font color=\"#E08010\">Restoring...</font></td>";
				
			echo "<td>
				
					<form action= \"serverprocess.php\" method=\"post\">";echo $cg2->generateHiddenField( "server-restorebackup", "bfe7507954135d") . "\n";
			echo "<input type=\"hidden\" name=\"data\" value=\"{$fileinfo['name']}\" />
			<input type=\"hidden\" name=\"task\" value=\"server-restorebackup\" />
			<input type=\"hidden\" name=\"serverid\" value=\"$serverid\" />
			<button id=\"ah\" onclick=\"return confirm('Do you really want to restore this backup?\\nThe data can NOT be recovered!')\"> <i class=\"icon-download\"></i> Povrati</button></button>
				</form>
				
				
			<form action= \"serverprocess.php\" method=\"post\">";echo $cg2->generateHiddenField( "server-delbackup", "bfe7507954135d") . "\n";
			echo "<input type=\"hidden\" name=\"data\" value=\"{$fileinfo['name']}\" />
			<input type=\"hidden\" name=\"task\" value=\"server-delbackup\" />
			<input type=\"hidden\" name=\"serverid\" value=\"$serverid\" />
			<button id=\"ah\" onclick=\"return confirm('Do you really want to delete this backup?\\nThe data can NOT be recovered!')\"> <i class=\"icon-download\"></i> Delete</button></button>
				</form>	
				</td>";
			}
			
			echo "</tr>";
			
			
			
		}
}		
		
?>			
			

	
		</table>
	</div>
</div>
<?php
include("./assets/footer.php");
?>