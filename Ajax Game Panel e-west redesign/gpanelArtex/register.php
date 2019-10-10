<?php
session_start();

$naslov = "Registracija";
$fajl = "register";

include("includes.php");

$br = @file_get_contents('preuzimanja.txt');

$br = number_format($br, 0);

$slajd = mysql_query("SELECT * FROM `slajdovi`");

include("./assets/header.php");
?>
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <script>
       function onSubmit(token) {
         document.getElementById("registracija").submit();
       }
     </script>
<?php
if (klijentUlogovan() == TRUE)
{
	header("Location: index.php");
	$_SESSION['msg'] = "Uspješno ste loginovani!";
	die();
?>
<?php } else { ?>
        <div class="login-header">
<div class="login-header"></div>
<div class="login-page">
		<form action="regprocess.php" method="POST" id="registracija"> 
            <input type="hidden" name="task" value="registracija" />
				<div class="login-page-cont">
			<h1>Registracija</h1>
                        <div class="form-input">
                            <label>Username</label>
                            <input style="margin-top:0;" name="username" type="text" id="ki" placeholder="Nenad123" autocomplete="off" />
                        </div>
                        <div class="form-input">
                            <label>Ime i prezime</label>
                            <input style="margin-top:0;" name="ime" type="text" id="ki" placeholder="Nenad Bojanic" autocomplete="off" />
                        </div>
                        <div class="form-input">
                            <label>E-mail</label>
                            <input name="email" type="text" id="email" placeholder="nenad@old-brothers.info" autocomplete="off" />
                        </div>
                        <div class="form-input">
                            <label>Lokacija</label>
                        <select name="zemlja">
                            <option value="srb">Srbija</option>
                            <option value="cg">Crna gora</option>
                            <option value="bih">Bosna i Hercegovina</option>
                            <option value="hr">Hrvatska</option>
                            <option value="mk">Makedonija</option>
                            <option value="cg"><?php echo $jezik['text198']; ?></option>
                        </select>
                        </div>
                        <div class="form-input">
                            <label>Lozinka</label>
                            <input name="sifra" type="password" id="age" placeholder="Lozinka" />
                        </div>

                            <button class="g-recaptcha" data-sitekey="6Ldgw3wUAAAAAIkgb67DW3D95l2psr5Dui7wr8Sq" data-callback='onSubmit' name="login" type="submit">Submit</button>
                            <a href="resetpw.php">Zaboravljena Lozinka?</a>
                            <a href="login.php">Već imate nalog?</a>
                        </div>                </div>
                    </form>
            </div>
<?php }; ?>

<?php
include("./assets/footer.php");
?>
