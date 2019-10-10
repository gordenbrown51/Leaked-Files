<?php
session_start();

$naslov = "Novi Tiket";
$fajl = "login";

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}

include("includes.php");

$br = @file_get_contents('preuzimanja.txt');

$br = number_format($br, 0);

$slajd = mysql_query("SELECT * FROM `slajdovi`");

include("./assets/header.php");
?>

    <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-podrska.php?pokazi=sve"><li>Arhiva</li></a>
                    <a href="novi-tiket.php"> <li class="panel-nav-active">Novi Tiket</li></a>
                    <a href="gp-podrska.php?pokazi=zakljucani"><li>Zaključani tiketi</li></a>
                    <li>Live Chat</li>
                    <li>Email Support</li>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-blue"><i class="fas fa-plus"></i> Novi Tiket</h4>
                        <p>Želiš nas kontaktirati? Pošalji tiket i sačekaj odgovor od naše podrške</p>
                    </div>
                    <div class="new-ticket">
                        <form action="process.php" method="POST">
                        	<input type="hidden" name="task" value="tiketadd" />
                            <div class="form-input">
                                <label>Tiket se odnosi na</label>
                                <select name="server">
<?php
						$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$_SESSION['klijentid']."'");
						$registrovan = strtotime($klijent['kreiran']);
						$vreme = strtotime(date("Y-m-d", time()));
						
						$serveri = mysql_query("SELECT s.id id, s.port port, s.name name, b.ip ip, s.box_id sboxid FROM serveri s, boxip b WHERE s.user_id = '".$_SESSION['klijentid']."' AND b.ipid = s.ip_id");
						
					    if (mysql_num_rows($serveri) > 0){
							
						while($row = mysql_fetch_array($serveri)) {
?>
							<option value="<?php echo $row['id']; ?>"><?php echo $row['ip'].":".$row['port']." - ".$row['name']; ?></option>
<?php
						}
						}else{
							echo "<option value=\"-1\"?>Bez servera.</option>";
						}
?>
                                </select>
                            </div>

                            <div class="form-input">
                                <label>Naslov</label>
                                <input name="naslov" type="text" autocomplete="off">
                            </div>

                            <div class="form-input">
                            	<label>Vrsta</label>
                            <select name="vrsta">
                            <option value="1"><?php echo $jezik['text233']; ?></option>
							<option value="2"><?php echo $jezik['text234']; ?></option>
							<option value="3"><?php echo $jezik['text235']; ?></option>
						</select>
					</div>

						<div class="form-input">
							<label>Prioritet</label>
						<select name="prioritet">
							<option <?php if(($registrovan + 5184000) > time()) echo 'disabled '; ?>value="1"><?php echo $jezik['text237']; ?></option>
							<option value="2" selected="selected"><?php echo $jezik['text238']; ?></option>
							<option value="3"><?php echo $jezik['text239']; ?></option>
						</select>
					</div>

                            <div class="form-input">
                                <label>Opis</label>
                                <textarea name="tiketodg"></textarea>
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
<?php
include("./assets/footer.php");
?>