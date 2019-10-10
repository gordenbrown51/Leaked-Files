<?php
session_start();

$naslov = "Zaboravljena lozinka";
$fajl = "resetpw";

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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <script>
       function onSubmit(token) {
         document.getElementById("resetpw").submit();
       }
     </script>
        <div class="login-header">
<div class="login-header"></div>
<div class="login-page">    
        <form action="login_process.php" method="POST" id="resetpw"> 
        <div class="login-page-cont">
            <h1>Zaboravljena lozinka?</h1>          
            <input type="hidden" name="task" value="resetpw" />
                <input name="username" type="text" placeholder="<?php echo $jezik['text388']; ?>" />
                <button class="g-recaptcha" data-sitekey="6Ldgw3wUAAAAAIkgb67DW3D95l2psr5Dui7wr8Sq" data-callback='onSubmit' type="submit"> <?php echo $jezik['text224']; ?></button> 
                            <a href="login.php">Sjetili ste se lozinke?</a>
                            <a href="register.php">Već imate nalog?</a>
                </div>           </div>         
        </form>
            </div>

<?php }; ?>

<?php
include("./assets/footer.php");
?>
