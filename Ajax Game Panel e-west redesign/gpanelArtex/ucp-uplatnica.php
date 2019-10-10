<?php
session_start();
include("includes.php");
$naslov = "Uplatnica";
$fajl = "ucp";
$return = "ucp.php";
$ucp = "ucp-uplatnica";
$gpr = "1";
$gps = "ucp-uplatnica";



if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
	die();
}


$drzava = mysql_real_escape_string($_GET['drzava']);

$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '{$_SESSION['klijentid']}'");

?>
<?php
if($drzava == "srb")
{
	header("Content-type: image/png");
	$slika = @imagecreatefrompng('./assets/img/srbija.png');
	$boja = imagecolorallocate($slika, 255, 120, 0);

	imagestring($slika, 6, 35, 50, $klijent['ime'] . ' ' . $klijent['prezime'], $boja);
	imagestring($slika, 6, 35, 68, $klijent['email'], $boja);
	imagestring($slika, 6, 35, 130, "Internet usluga", $boja);
	imagestring($slika, 6, 35, 200, "Mirza Hrvanovic", $boja);
	imagestring($slika, 6, 520, 60, "Iznos...", $boja);
	imagestring($slika, 6, 395, 103, "161-30000562365-81", $boja);
	imagestring($slika, 3, 395, 180, "Iznos = Koliko novca zelite na racunu.", $boja);
}
else if($drzava == "cg")
{
	header("Content-type: image/png");
	$slika = @imagecreatefrompng('./assets/img/crnagora.png');
	$boja = imagecolorallocate($slika, 0, 0, 0);
	
	imagestring($slika, 5, 120, 72, $klijent['ime'] . ' ' . $klijent['prezime'], $boja);
	imagestring($slika, 5, 120, 92, $klijent['email'], $boja);
	
	imagestring($slika, 5, 120, 170, "Internet usluga", $boja);
	
	imagestring($slika, 5, 120, 250, "Mirza Hrvanovic", $boja);
	imagestring($slika, 6, 527, 90, "1613000056236581", $boja);
	imagestring($slika, 3, 480, 135, "Cjena", $boja);
}
else if($drzava == "bih")
{
	header("Content-type: image/png");
	$slika = @imagecreatefrompng('./assets/img/bosna.png');
	$boja = imagecolorallocate($slika, 255, 120, 0);
	
	imagestring($slika, 5, 220, 25, $klijent['ime'] . ' ' . $klijent['prezime'], $boja);
	imagestring($slika, 3, 15, 45, $klijent['email'], $boja);
	imagestring($slika, 5, 120, 72, "Internet usluga", $boja);
	imagestring($slika, 6, 140, 130, "Mirza Hrvanovic", $boja);
	imagestring($slika, 6, 427, 82, "1 6 1 3 0 0 0 0 5 6 2 3 6 5 8 1", $boja);
	imagestring($slika, 3, 450, 135, "Neki iznos u KM.", $boja);
}
else if($drzava == "hr")
{
	header("Content-type: image/png");
	$slika = @imagecreatefrompng('./assets/img/hrvatska.png');
	$boja = imagecolorallocate($slika, 255, 120, 0);
	
	imagestring($slika, 5, 35, 90, $klijent['ime'] . ' ' . $klijent['prezime'], $boja);
	imagestring($slika, 3, 35, 110, "Vasa adresa", $boja);
	imagestring($slika, 3, 35, 130, $klijent['email'], $boja);
	imagestring($slika, 5, 35, 180, "Uskoro", $boja); 
	imagestring($slika, 6, 540, 50, "= Iznos uplate u KN", $boja);
	imagestring($slika, 6, 350, 175, "Uskoro", $boja);
	imagestring($slika, 6, 265, 215, "Vas OIB", $boja);
	imagestring($slika, 6, 200, 255, "Internet usluga", $boja);
}
else if($drzava == "mk")
{

}

imagepng($slika);
imagedestroy($slika);

?>
<?php if(empty($_GET['drzava'])) { 
	include("./assets/header.php");
	?>

   <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                   <a href="ucp-billing.php"><li>Pregled</li></a>
                    <a href="ucp-billingadd.php"><li>Nova Uplata</li></a>
                    <a href="ucp-uplatnica.php"><li class="panel-nav-active">Uplatnice</li></a>
                    <a href="ucp-smslogovi.php"><li>SMS Logovi</li></a>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-ticket-alt"></i> Primjeri Uplatnica</h4>
                        <p>Ovdje možete pogledati kako da ispunite uplatnicu!</p>
                    </div>

                    <div class="new-ticket">
                    	<form action="">
                    		<div class="form-input">
                    		<select name="drzava">
                    			<option value="bih">Bosna i Hercegovina</option>
                    			<option value="srb">Srbija</option>
                    			<option value="cg">Crna Gora</option>
                    			<option value="hr">Hrvatska</option>
                    		</select>
                    	</div>
                    		<div class="form-input">
                    		<button type="submit">Dalje</button>
                    	</div>
                    	</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }; ?>
