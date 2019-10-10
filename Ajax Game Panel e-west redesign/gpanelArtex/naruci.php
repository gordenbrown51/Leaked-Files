<?php

		
session_start();
include("includes.php");

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}


/*$_SESSION['msg'] = "Open ticket for new server!";
		header("Location: gp-podrska.php");
		die();*/
		
$naslov = $jezik['text461'];
$fajl = "naruci";
$return = "naruci.php";
$ucp = "naruci";


include("./assets/header.php");

?>
<div class="main">
<?php
        
		

if(isset($_GET['igra']))
{	
	$igra = mysql_real_escape_string($_GET['igra']);
	$lokacija = mysql_real_escape_string($_GET['lokacija']);
	
	if(!is_numeric($igra) OR !is_numeric($lokacija))
	{
		$_SESSION['msg'] = $jezik['text462'];
		header("Location: naruci.php");
		die();
	}
	
	if($igra == "0" OR $igra > "3")
	{
		$_SESSION['msg'] = $jezik['text463'];
		header("Location: naruci.php");
		die();
	}
	
	if($lokacija != "2")
	{
		$_SESSION['msg'] = $jezik['text464'];
		header("Location: naruci.php");
		die();
	}

	$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '{$_SESSION['klijentid']}'");

	$cenaslota = query_fetch_assoc("SELECT `cena` FROM `modovi` WHERE `igra` = '{$igra}'");
	$cenaslota = explode("|", $cenaslota['cena']);

	if($klijent['zemlja'] == "srb") $cena = $cenaslota[0];
	else if($klijent['zemlja'] == "hr") $cena = $cenaslota[3];
	else if($klijent['zemlja'] == "bih") $cena = $cenaslota[4];
	else if($klijent['zemlja'] == "mk") $cena = $cenaslota[2];
	else if($klijent['zemlja'] == "cg") $cena = $cenaslota[1];
	else if($klijent['zemlja'] == "other") $cena = $cenaslota[1];

}
else
{
	$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '{$_SESSION['klijentid']}'");
}


?>

<?php			
			if(!isset($_GET['igra']))
			{
				if(query_numrows("SELECT `id` FROM `serveri_naruceni` WHERE `klijentid` = '{$_SESSION['klijentid']}'") == 0)
				{
?>

        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-serveri.php"><li>Moji Serveri</li></a>
                    <a href="naruci-zahtev.php"><li>Zahtjevi</li></a>
                    <a href="naruci.php"><li class="panel-nav-active">Naruči Server</li></a>
                </ul>
            </div>
            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-blue"><i class="fas fa-plus"></i> Novi Server</h4>
                        <p>Želiš novi server? Naruči ga tako što ćeš ispuniti formu.</p>
                    </div>
                    <div class="new-server">
                        <form action="naruci.php" method="GET">
                        	<input type="hidden" name="nacin" value="1" />
					        <input type="hidden" name="lokacija" value="2" />
                            <div class="form-input">
                                <label>Izaberite Igru</label>
                                <select name="igra">

                                	<option value="1">Counter Strike 1.6</option>
                                	<option value="2">SA:MP</option>
                                    <option value="3">Minecraft</option>
                                    <option value="4" disabled>Call of Duty 4 MW3 - <?php echo $jezik['text35']; ?></option>    
                                </select>
                            </div>
                            <button type="submit"><?php echo $jezik['text471']; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php	
				}	
				else
				{
?>			
				<?php header("Location: naruci-zahtev.php"); ?>		
<?php
				}
			}
			else if(isset($_GET['igra'])) {	?>
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-serveri.php"><li class="c-4d4d4d">Moji Serveri</li></a>
                    <a href="naruci-zahtev.php"><li class="c-4d4d4d">Zahtjevi</li></a>
                    <a href="naruci.php?nacin=1&lokacija=2&igra=1"><li class="panel-nav-active c-white">Novi Server</li></a>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-blue"><i class="fas fa-plus"></i> Novi Server</h4>
                        <p>Želiš novi server? Naruči ga tako što ćeš ispuniti formu.</p>
                    </div>
                    <div class="new-server">

						<form action="" method="get">
							<input type="hidden" name="nacin" value="1" />
							<input type="hidden" name="lokacija" value="2" />
							<div class="form-input">
								<label><?php echo $jezik['text478']; ?></label>
								<select name="igra" onchange="this.form.submit()">
									<option value="1" <?php if($_GET['igra'] == "1") echo'disabled selected="selected"'; ?>>Counter-Strike 1.6</option>
									<option value="2" <?php if($_GET['igra'] == "2") echo'disabled selected="selected"'; ?>>GTA San Andreas Multiplayer</option>
									<option value="3" <?php if($_GET['igra'] == "3") echo'disabled selected="selected"'; ?>>Minecraft</option>
									<option value="4" disabled <?php if($_GET['igra'] == "4") echo'disabled selected="selected"'; ?>>Call of Duty 4 MW3 - <?php echo $jezik['text35']; ?></option>
								</select>
							</div>	
						</form>

						<form action="process.php" method="POST">
							<input type="hidden" name="igra" value="<?php echo $igra; ?>" />
							<input type="hidden" name="task" value="naruciserver" />
							<input id="drzava" name="drzava" value="<?php echo $cena.'|'.drzava_valuta($klijent['zemlja']); ?>" type="hidden" />
							<input id="flag" name="zemlj" value="<?php echo drzava($klijent['zemlja']); ?>" title="<?php echo drzava_valuta($klijent['zemlja']); ?>" type="hidden" />				
							<div class="form-input">
								<label><?php if($igra == "3") { ?> <?php echo "Izaberite memoriju servera"; } else { ?> <?php echo $jezik['text481'];  } ?></label>
								<select name="slotovi" id="slotovi" onchange="izracunajCenu()">
									<option value="0" >- <?php if($igra == "3") { ?><?php echo "Izaberite memoriju servera"; ?> <?php } else { ?><?php echo $jezik['text479']; ?><?php } ?> -</option>
							<?php	if($igra == "1") {	?>
									<option value="12">12 <?php echo $jezik['text480']; ?></option>
									<option value="14">14 <?php echo $jezik['text480']; ?></option>
									<option value="16">16 <?php echo $jezik['text480']; ?></option>
									<option value="18">18 <?php echo $jezik['text480']; ?></option>
									<option value="20">20 <?php echo $jezik['text480']; ?></option>
									<option value="22">22 <?php echo $jezik['text480']; ?></option>
									<option value="24">24 <?php echo $jezik['text480']; ?></option>
									<option value="26">26 <?php echo $jezik['text480']; ?></option>
									<option value="28">28 <?php echo $jezik['text480']; ?></option>
									<option value="30">30 <?php echo $jezik['text480']; ?></option>
									<option value="32">32 <?php echo $jezik['text480']; ?></option>                                                                      
							<?php	}
									if($igra == "2") {	?>
									<option value="30">30 <?php echo $jezik['text480']; ?></option>
									<option value="40">40 <?php echo $jezik['text480']; ?></option>
									<option value="50">50 <?php echo $jezik['text480']; ?></option>
									<option value="100">100 <?php echo $jezik['text480']; ?></option>
									<option value="150">150 <?php echo $jezik['text480']; ?></option>
									<option value="200">200 <?php echo $jezik['text480']; ?></option>
									<option value="250">250 <?php echo $jezik['text480']; ?></option>
									<option value="300">300 <?php echo $jezik['text480']; ?></option>
									<option value="350">350 <?php echo $jezik['text480']; ?></option>
									<option value="400">400 <?php echo $jezik['text480']; ?></option>
									<option value="450">450 <?php echo $jezik['text480']; ?></option>
									<option value="500">500 <?php echo $jezik['text480']; ?></option>
							<?php	}
									if($igra == "3") {	?>	
									<option value="1" selected="selected">1 GB</option>
									<option value="2">2 GB</option>
									<option value="3">3 GB</option>
									<option value="4">4 GB</option>
									<option value="5">5 GB</option>
									<option value="6">6 GB</option>
									<option value="7">7 GB</option>
									<option value="8">8 GB</option>
									<option value="9">9 GB</option>
                                                                        <option value="10">10 GB</option>
                                                                        <option value="15">15 GB</option>
							<?php	}
									if($igra == "4") {	?>		
									<option value="12">12</option>
									<option value="14">14</option>
									<option value="16">16</option>
									<option value="18">18</option>
									<option value="20">20</option>
									<option value="22">22</option>
									<option value="24">24</option>
									<option value="26">26</option>
									<option value="28">28</option>
									<option value="30">30</option>
									<option value="32">32</option>
									<option value="34">34</option>
									<option value="36">36</option>
									<option value="38">38</option>
									<option value="40">40</option>
									<option value="42">42</option>
									<option value="44">44</option>
									<option value="46">46</option>
									<option value="48">48</option>
									<option value="50">50</option>
									<option value="52">52</option>
									<option value="54">54</option>
									<option value="56">56</option>
									<option value="58">58</option>
									<option value="60">60</option>
									<option value="62">62</option>
									<option value="64">64</option>																
							<?php	}	?>									
								</select>
								</div>					
							<div class="form-input">
								<label><?php echo $jezik['text489']; ?></label>
								<select name="mesec" id="meseci" onchange="izracunajCenu()">
									<option value="1">1 <?php echo $jezik['text484']; ?></option>
								</select>	
							</div>

							<div class="form-input">
								<label><?php echo $jezik['text492']; ?></label>
								<select name="lokacija">
									<option disabled value="1" <?php if($_GET['lokacija'] == "1") echo'disabled selected="selected"'; ?>>Premium - <?php echo $jezik['text490']; ?></option>
									<option selected="selected" value="2" <?php if($_GET['lokacija'] == "2") echo'selected="selected"'; ?>>Lite - <?php echo $jezik['text491']; ?></option>
								</select>
							</div>

							<div class="form-input">
								<label><?php echo $jezik['text494']; ?></label>
								<div name="cena" type="text" readonly="readonly" id="cena"><?php echo $jezik['text493']; ?>...</div>
								<input type="hidden" id="cenab" name="cenab" disabled>
							</div>

								<input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
								<button type="submit"><i class="icon-arrow-right"></i> <?php echo $jezik['text495']; ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>



		<?php	}	?>
			</div>
<?php
include("./assets/footer.php");
?>