<?php
session_start();
include("includes.php");
$naslov = $jezik['text14'];
$fajl = "ucp";
$return = "ucp.php";
$ucp = "ucp-billing";

include("./assets/header.php");

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}

$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$_SESSION['klijentid']."'");
$billing = mysql_query("SELECT * FROM `billing` WHERE `klijentid` =  '".$_SESSION['klijentid']."' ORDER BY `id`");

?>
   <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="ucp-billing.php"><li class="panel-nav-active">Pregled</li></a>
                <ul class="light-border">
                    <a href="ucp-billingadd.php"><li>Nova Uplata</li></a>
                    <a href="ucp-uplatnica.php"><li>Uplatnice</li></a>
                    <a href="ucp-smslogovi.php"><li>SMS Logovi</li></a>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-comment-dollar"></i> Billing</h4>
                        <p>Ovdje možete pogledati čitavu historiju Vaših uplata!</p>
                        <?php if(mysql_num_rows($billing) == 0) { ?>
                        <h3><i class="fas fa-exclamation-triangle bold"></i> <?php echo $jezik['text559']; ?></p></h3>
                        <?php }; ?>
                    </div>

           <div class="user-servers">			
<?php	
			while($row = mysql_fetch_array($billing)) {	
				$tiketi = query_fetch_assoc("SELECT `id` FROM `tiketi` WHERE `billing` = '{$row['id']}'");
?>
<div class="user-server-single">
			<table>
				<tr>
					<th><?php echo $jezik['text554']; ?></th>
					<td>#<?php echo $row['id']; ?></td>
				</tr>

				<tr>
					<th><?php echo $jezik['text556']; ?></th>
					<td><?php echo getMoney($klijent['klijentid'], true, $row['iznos'] ); ?></td>
				</tr>

				<tr>
					<th><?php echo $jezik['text557']; ?></th>
					<td><?php echo vreme($row['vreme']); ?></td>
				</tr>

				<tr>
					<th><?php echo $jezik['text558']; ?></th>
					<td><?php echo billing_status($row['status']); ?></td>
				</tr>	

				<tr>
					<th><?php echo $jezik['text555']; ?></th>
					<td><a href="gp-tiket.php?id=<?php echo $tiketi['id']; ?>"><button><i class="fas fa-search"></i> Pregled</button></a>
					</td>
				</tr>
			</table>
		</div>
<?php
			}	
?>
</div>
</div>
</div>
</div>
</div>

<

<?php
include("./assets/footer.php");
?>