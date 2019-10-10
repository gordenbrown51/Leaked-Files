<?php
session_start();
include("includes.php");
$naslov = $jezik['text586'];
$fajl = "ucp";
$return = "ucp.php";
$ucp = "ucp-podesavanja";

include("./assets/header.php");

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}

// if($_SESSION['sigkod'] == "0") 
//{ $_SESSION['msg'] = "Morate uneti sigurnosni kod!"; header("Location: index.php"); die(); }

$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$_SESSION['klijentid']."'");

?>
    <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="profil.php?id=<?php echo $klijent['klijentid']; ?>"><li>Profil</li></a>
                    <a href="ucp-podesavanja.php"><li class="panel-nav-active">Postavke</li></a>
                    <a href="ucp-logovi.php"><li>Logovi</li></a> 
                </ul>
            </div>

          <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-blue"><i class="fas fa-user-edit"></i> Postavke</h4>
                        <p>Podesi svoj profil!</p>
                    </div>
                    <div class="new-ticket">

                        <form action="process.php" method="POST">
                        	<div class="form-input">
                        		<label>*<?php echo $jezik['text588']; ?></label>
                        		<input readonly="readonly" name="username" type="text" value="<?php echo $klijent['username']; ?>"><
                        	</div>

                       	    <div class="form-input">
                       	    	<label>*<?php echo $jezik['text589']; ?></label>
                       	    	<input readonly="readonly" name="email" type="text" id="email" value="<?php echo $klijent['email']; ?>">
                        	</div>

                        	<div class="form-input">
                        		<label>*<?php echo $jezik['text590']; ?></label>
                        		<input name="ime" type="text" value="<?php echo $klijent['ime'].' '.$klijent['prezime']; ?>">
                        	</div>
                        	<div class="form-input">
                        		<label>*<?php echo $jezik['text591']; ?></label>
                        							<select name="zemlja">
						<option value="srb" data-image="avatari/Filip.png" <?php if($klijent['zemlja'] == "srb") echo'selected="selected"'; ?>>Srbija</option>
						<option value="cg" <?php if($klijent['zemlja'] == "cg") echo'selected="selected"'; ?>>Crna gora</option>
						<option value="bih" <?php if($klijent['zemlja'] == "bih") echo'selected="selected"'; ?>>Bosna i Hercegovina</option>
						<option value="hr" <?php if($klijent['zemlja'] == "hr") echo'selected="selected"'; ?>>Hrvatska</option>
						<option value="mk" <?php if($klijent['zemlja'] == "mk") echo'selected="selected"'; ?>>Makedonija</option>
						<option value="other" <?php if($klijent['zemlja'] == "other") echo'selected="selected"'; ?>>No Balkan</option>
					</select>
                        	</div>
                        	<div class="form-input">
                        		<label>*<?php echo $jezik['text594']; ?></label>
                     <select name="akcije">
						<option value="1" <?php if($klijent['mail'] == "1") echo 'selected="selected"'; ?>><?php echo $jezik['text592']; ?></option>
						<option value="0" <?php if($klijent['mail'] == "0") echo 'selected="selected"'; ?>><?php echo $jezik['text593']; ?></option>
					</select>
                        	</div>                       	
                        	<div class="form-input">
                        		<label>*<?php echo $jezik['text595']; ?></label>
                        		<input disabled readonly="readonly" name="sifrax" type="password" id="age" placeholder="<?php echo $jezik['text595']; ?>e" />
                        	</div>
                        	<div class="form-input">
                        		<label>*<?php echo $jezik['text596']; ?></label>
                        		<input name="sifra" type="password" id="age" placeholder="<?php echo $jezik['text315']; ?>" />
                        	</div>	
                           <div class="form-input">
                           	<label>*<?php echo $jezik['text597']; ?></label>
                           	<input name="sifra_potvrda" type="password" id="age" placeholder="<?php echo $jezik['text315']; ?>">
                        	</div>	

                        <div class="form-input">
                        		<label>*Tema</label>
                     <select name="mirza-themes">
						<option value="1">Klasična</option>
						<option value="1">Noćni mod</option>
						<option value="1">Halloween mod</option>
					</select>
                        	</div>   
                           <div class="form-input">
					<input type="hidden" name="task" value="profil-edit" />
					<input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
					       <button type="submit"> <i class="icon-arrow-right"></i> <?php echo $jezik['text205']; ?> </button>
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