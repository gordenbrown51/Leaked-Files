<?php
session_start();
include("includes.php");
$naslov = "Dodaj admina";
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-admini";
$gpr = "1";
$gps = "gp-admini";



if(klijentServeri($_SESSION['klijentid']) == 0)
{
	$_SESSION['msg'] = $jezik['text300'];
	header("Location: index.php");
}

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

if(query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '{$_SESSION['klijentid']}' AND `id` = '{$serverid}'") == 0)
{
	$_SESSION['msg'] = $jezik['text312'];
	header("Location: gp-serveri.php");
	die();
}
$serverid = mysql_real_escape_string($_GET['id']);

$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '{$serverid}'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '{$server['ip_id']}'");

if($server['igra'] == "1")
{
	$sql = "SELECT * FROM `plugins`";
}
else
{
	$_SESSION['msg'] = $jezik['text313'];
	header("Location: gp-server.php?id=".$serverid);
	die();
}

$ip = $boxip['ip'];

include("./assets/header.php");

$filename = "ftp://$server[username]:$server[password]@$ip:21/cstrike/addons/amxmodx/configs/users.ini";
$contents = file_get_contents($filename);	

$fajla = explode("\n;", $contents);
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
                        <h4 class="c-red"><i class="fas fa-server"></i> Dodaj Admina</h4>
                        <p>Dodajte admina na Vaš server</p>
</div>

<div class="new-ticket">
        <form action="serverprocess.php" method="POST">                
            <input type="hidden" name="task" value="adminadd" />
                <div class="form-input">
                    <label>*<?php echo $jezik['text246']; ?></label>
                        <select name="vrsta">
                            <option value="0" selected="selected" disabled><?php echo $jezik['text243']; ?> ...</option>
                            <option value="1"><?php echo $jezik['text244']; ?></option>
                            <option value="2"><?php echo $jezik['text245']; ?></option>
                        </select>
                </div> 

                <div class="form-input">
                    <label>*<?php echo $jezik['text245']; ?></label>
                        <input name="steamid" type="text" placeholder="<?php echo $jezik['text247']; ?>" />
                    </div>

                <div class="form-input">
                    <label>*<?php echo $jezik['text248']; ?></label>
                        <input name="nick" type="text" placeholder="<?php echo $jezik['text248']; ?>" />
                    </div>

                <div class="form-input">
                    <label>*<?php echo $jezik['text249']; ?></label>
                        <input name="sifra" type="password" placeholder="<?php echo $jezik['text249']; ?>" />
                    </div>

                <div class="form-input">
                    <label>*<?php echo $jezik['text254']; ?></label>
                        <select name="vrsta_admina">
                            <option value="1"><?php echo $jezik['text250']; ?></option>
                            <option value="2"><?php echo $jezik['text251']; ?></option>
                            <option value="3"><?php echo $jezik['text252']; ?></option>
                            <option value="4"><?php echo $jezik['text253']; ?></option>
                        </select>
                    </div>
                  <div class="form-input">
                    <label>*<?php echo $jezik['text255']; ?></label>
                        <input style="margin-top:0;" name="komentar" type="text" placeholder="<?php echo $jezik['text255']; ?>"> </div>

                <div class="form-input">
                        <button type="submit"><i class="icon-exchange"></i> <?php echo $jezik['text256']; ?></button>
                    </form>     
                    </div>
                </div>

</div></div></div></div></div></div></div></div>
<?php
include("./assets/footer.php");
?>