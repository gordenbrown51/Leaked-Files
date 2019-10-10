<?php
session_start();
include("includes.php");
$naslov = $jezik['text320'];
$fajl = "gp";
$return = "gp-autorestart";
$ucp = "gp-autorestart";
$gpr = "1";
$gps = "gp-autorestart";

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


include("./assets/header.php");

$cg2 = new CSRFGuard();
?>
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
                        <h4 class="c-red"><i class="fas fa-server"></i> AutoRestart</h4>
                        <p>Podesite automatski restart Vašeg servera svakog dana</p>
                    </div>

               <div class="new-ticket">
	<form action="serverprocess.php?task=autorr" method="post">
	            <input type="hidden" name="srvid" value="<?php echo $server['id'] ?>" />
	            <div class="form-input">
				<select name="autorr">
				    <option value="-1">Disabled</option>
					
					<?php
                for ($i=0;$i<24;$i++) {
                    if ($server['autorestart'] == $i) 
						$selekt = " selected=\"selected\" $i";
                    else 
						$selekt = "";
                ?>
                <option value="<?php echo $i ?>" <?php echo $selekt ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>:00</option>
                <?php
                }
                ?>
 
				</select></div>
				<div class="form-input">
				<button type="submit"><i class="icon-arrow-right"></i> Save</button>
			</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>
<?php
include("./assets/footer.php");
?>