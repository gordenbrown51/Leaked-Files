<?php
session_start();

$naslov = "Login";
$fajl = "login";

include("includes.php");

$br = @file_get_contents('preuzimanja.txt');

$br = number_format($br, 0);

$slajd = mysql_query("SELECT * FROM `slajdovi`");

include("./assets/header.php");
?>
<?php
if (klijentUlogovan() == TRUE)
{
	header("Location: index.php");
	$_SESSION['msg'] = "Uspješno ste logovani!";
	die();
?>
<?php } else { ?>
        <div class="login-header">
<div class="login-header"></div>
<div class="login-page">
		<form action="login_process.php" method="post">
				<div class="login-page-cont">
			<h1>Prijava</h1>
                        <input type="hidden" name="task" id="task" value="login" />
                        <input type="hidden" name="return" value="<?php
                                    if (isset($_GET['return']))
                                    {
                                        echo htmlspecialchars($_GET['return'], ENT_QUOTES);
                                    }
                        ?>" />
                        			<input type="text" name="username" placeholder="Username" title="<?php echo $jezik['text3']; ?>" style="margin-top: -4px;" />
                        <input type="password" name="sifra" placeholder="Password" title="<?php echo $jezik['text4']; ?>" style="margin-top: -2px;" />
                            <button type="submit" name="login">Prijava</button>
                            <a href="resetpw.php">Zaboravljena Lozinka?</a>
                             <a href="register.php">Nemate naloga?</a>
                        </div>                </div>
                    </form>
            </div>
<?php }; ?>

<?php
include("./assets/footer.php");
?>
