<?php
session_start();
include("includes.php");
$naslov = $jezik['text403'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";



if(klijentServeri($_SESSION['klijentid']) == 0)
{
	$_SESSION['msg'] = $jezik['text300'];
	header("Location: index.php");
	die();
}

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
	die();
}

$sql = "SELECT s.rank, s.name sname, s.id sid, s.cena scena, s.igra sigra, s.slotovi sslotovi, s.status sstatus, k.zemlja kzemlja 
		FROM serveri s, klijenti k 
		WHERE s.user_id = '".$_SESSION['klijentid']."' AND k.klijentid = '".$_SESSION['klijentid']."' ORDER BY `sid` DESC";
$serveri = mysql_query($sql);

include("./assets/header.php");
?>
    <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                    <a href="gp-serveri.php"><li class="panel-nav-active">Moji Serveri</li></a>
                    <a href="naruci-zahtev.php"><li>Naručeno</li></a>
                    <a href="naruci.php?nacin=1&lokacija=2&igra=1"><li>Novi Server</li></a>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-server"></i> Moji Serveri</h4>
                        <p>Ovdje možete pogledati Vašu listu kupljenih servera.</p>
   <?php
	if(mysql_num_rows($serveri) == 0) echo '<h3>'.$jezik['text414'].'</h3>';
	while($row = mysql_fetch_array($serveri))
	{
		if($row['scena'] == "0" or $row['scena'] == NULL) 
			$cena = $jezik['text415'];
		else 
			//$cena = novac($row['scena'], $row['kzemlja']);
		    $cena = price_by_slot($_SESSION['klijentid'], $row['sigra'], $row['sid'] );
?>
                    </div>

                    <div class="user-servers">
<div class="user-server-single">
    <table>
		<tr>
			<th><?php echo $jezik['text407']; ?></th>
			<td><a href="gp-server.php?id=<?php echo $row['sid']; ?>"><?php echo $row['sname']; ?></a></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text408']; ?></th>
			<td><?php echo srv_istekao($row['sid']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text409']; ?></th>
			<td><?php echo $cena; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text410']; ?></th>
			<td><?php echo ipadresa($row['sid']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text411']; ?></th>
			<td><?php echo igra($row['sigra']); ?></td>
		</tr>

                            <tr> 
                                <?php if($row['sigra'] == "3") { ?>
                                <th>Memorija</th>
                                <td><?php echo $row['sslotovi']; ?> GB</td>
                                <?php } else { ?>
                                <th><?php echo $jezik['text524']; ?></th>
                                <td><?php echo $row['sslotovi']; ?></td>
                                <?php } ?>
                            </tr>

		<tr>
			<th><?php echo $jezik['text413']; ?></th>
			<td><?php echo srv_status($row['sstatus']); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text604']; ?></th>
			<td>#<?php echo $row['rank']; ?></td>
		</tr>

		<tr>
			<th>Akcije</th>
			<td>
				<a href="gp-server.php?id=<?php echo $row['sid']; ?>"><button>Edit</button></a>
			</td>
		</tr>
		</table>
	</div>

<?php
	}
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46634717-1', 'e-trail.eu');
  ga('send', 'pageview');

</script>
</div> <!-- #tabbilling end -->

<?php
include("./assets/footer.php");
?>
