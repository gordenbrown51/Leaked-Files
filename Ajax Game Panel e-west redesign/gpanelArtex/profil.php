<?php
session_start();

include("includes.php");

if (empty($_GET['id'])) {
	header("Location: profil.php?id=". $_SESSION['klijentid']  ."");
}

function obfuscate_email($email)
{
    $em   = explode("@",$email);
    $name = implode(array_slice($em, 0, count($em)-1), '@');
    $len  = floor(strlen($name)/2);

    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);

}

$profilid = mysql_real_escape_string($_GET['id']);
$profilid = htmlspecialchars($profilid);

if(!is_numeric($profilid))
{
	die();
}

$naslov = "Pregled profila #".$profilid;

if($profilid != $_SESSION['klijentid'])
{
	$return = "profil.php";
	$fajl = "profil";
	$profil = "profil";
}
else
{
	$return = "ucp.php";
	$fajl = "ucp";
	$ucp = "ucp";
}

$sql = "SELECT * FROM klijenti WHERE klijentid = '{$profilid}'";
$profil = mysql_query($sql);

if(mysql_num_rows($profil) != 1)
{
	die();
}

$broj['ptiketa'] = query_numrows("SELECT `id` FROM `tiketi` WHERE `user_id` = '{$profilid}'");
$broj['podgovora'] = query_numrows("SELECT `id` FROM `tiketi_odgovori` WHERE `user_id` = '{$profilid}'");
$broj['servera'] = query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '{$profilid}'");
$broj['friends'] = query_numrows("SELECT `id` FROM `friends_list` WHERE `user_one` = '{$profilid}' OR `user_two` = '{$profilid}'");

$profil = mysql_fetch_assoc($profil);

$prijatelji = mysql_query("SELECT f.*, k.ime, k.prezime  
							FROM friends_list f, klijenti k 
							WHERE f.user_one = {$profilid} AND k.klijentid = f.user_two 
							OR f.user_two = {$profilid} AND k.klijentid = f.user_one ORDER BY RAND() LIMIT 0, 16");

$sql = "SELECT s.rank, s.name sname, s.id sid, s.cena scena, s.igra sigra, s.slotovi sslotovi, s.status sstatus, k.zemlja kzemlja 
		FROM serveri s, klijenti k 
		WHERE s.user_id = {$profilid} AND k.klijentid = {$profilid} ORDER BY `sid` DESC";

$serveri = mysql_query($sql);

include("./assets/header.php");

if($profil['cover'] == "cover.jpg") $cover = "cover.png";
else $cover = $profilid.''.$profil['cover'];

function OwnProfile($id)
{
	if($_SESSION['klijentid'] == $id) return true;
	else return false;
}
?>

    <div class="main">
        <div class="panel">
         <div class="panel-nav">
                <ul class="light-border">
                    <a href="profil.php"><li class="panel-nav-active">Profil</li></a>
                  <?php if(OwnProfile($profilid)) { ?> <a href="ucp-podesavanja.php"><li>Postavke Profila</li></a> <a href="ucp-logovi.php"><li>Logovi</li></a>  <?php } ?>
                </ul>
            </div>

<div class="panel-main">
            <div class="panel-padding">
                    <div class="user">
                        <div class="user-thumb">
                            <img src="assets/mirza/img/2.png" alt="Avatar">
                        </div>
                        
                        <div class="user-avatar">
                            <img src="assets/mirza/img/1.png" alt="Avatar">
                        </div>

                    <div class="user-status">
                        <ul>
                            <li>
                                <h3 class="c-yellow">Ime</h3>
                                <h4><?php echo $profil['ime']; ?></h4>
                            </li>
                            <li>
                                <h3 class="c-green"></i>Prezime</h3>
                                <h4><?php echo $profil['prezime']; ?></h4>
                            </li>
                            <li>
                                <h3 class="c-red"></i>Status</h3>
                                <h4>Korisnik</h4>
                            </li>
                            <li>
                                <h3 class="c-red"></i>Država</h3>
                                <h4><?php echo drzavaimg($profil['zemlja']); ?></h4>
                            </li>
                        </ul>
                    </div>


                    <div class="user-servers">

<?php
	if(mysql_num_rows($serveri) == 0) { echo '<p>'.$jezik['text414'].'</p>'; } else { ?>
                         <table>
                            <tr>
                                <td>Ime</td>
                                <td>IP</td>
                                <td>Status</td>
                                <td>Rank</td>
                            </tr>

	<?php while($row = mysql_fetch_array($serveri))
	{
		if($row['scena'] == "0" or $row['scena'] == NULL) $cena = $jezik['text415'];
		else $cena = novac($row['scena'], $row['kzemlja']);
?>
		<tr>
			<td><?php echo igra_no_name($row['sigra']); ?> <a href="server.php?id=<?php echo $row['sid']; ?>"><?php echo $row['sname']; ?></a></td>
			<td><?php echo ipadresa($row['sid']); ?></td>
		    <td><?php echo srv_status($row['sstatus']); ?></td>
			<td>#<?php echo $row['rank']; ?></td>
		</tr>

<?php
	}
}
?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include("./assets/footer.php");
?>
