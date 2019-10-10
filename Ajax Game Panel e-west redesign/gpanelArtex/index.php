<?php
session_start();

$naslov = "Početna";
$fajl = "index";

include("includes.php");

$br = @file_get_contents('preuzimanja.txt');

$br = number_format($br, 0);

$slajd = mysql_query("SELECT * FROM `slajdovi`");

include("./assets/header.php");
?>
	<div class="home">
		<div class="home-content">
			<?php if (klijentUlogovan() == true) { ?>
			<h1><?php printf("Dobrodošao, %s", $client['ime']); ?></h1>
		<?php } else { ?>
			<h1>Dobrodošao na SAD Hosting</h1>
		<?php }; ?>
			<a href="naruci.php"><button>Kreiraj Server</button></a>
			<a href="#navigate-to-services"><button class="second-button">Cijene</button></a>
	    </div>
	</div>
	<!--<div class="home-about" id="navigate-to-about-us">
		<div class="home-about-text">
			<h2>#kvaliteta</h2>
			<h1>O nama</h1>
			<p>e-West Hosting se bavi hostovanjem game servera od 2015. godine, dan danas radimo i svaki dan se trudimo da poboljšamo naše usluge. Od 2018. koristimo potpuno novi responsive dizajn koji je uradio <a target="_blank" href="http://instagram.com/hrvanovicmirza">Mirza Hrvanovic</a>. Naš cilj iz dana u dan je zaštiti i omogućiti kvalitetne usluge našim korisnicima. Pridružite se!</p>
		</div>
	</div>
-->
	<div class="home-services" id="navigate-to-services">
		<ul>
				    	<h1>Naše usluge</h1>
			<li>
				<div class="home-services-padding">
				    <div class="home-services-content">
				        <div class="img">
					        <img src="assets/img/mc-banner.png">
					        <h1>Minecraft</h1>
				        </div>

				        <p>AntiDDos Zaštita</p>
				        <p>Ping: 20-35ms</p>
				        <p>24h Podrška</p>

				        <h4>3<i class="fas fa-euro-sign"></i><font class="font-16px">/1GB</font></h4><a href="naruci.php"><button>Naruči</button></a>
			        </div>
			    </div>
			</li>
			<li>
				<div class="home-services-padding">
				    <div class="home-services-content">
				        <div class="img">
					        <img src="assets/img/samp-banner.png">
					        <h1>SA:MP</h1>
				        </div>

				        <p>AntiDDos Zaštita</p>
				        <p>Ping: 20-35ms</p>
				        <p>24h Podrška</p>

				        <h4>0.06<i class="fas fa-euro-sign"></i><font class="font-16px">/slot</font></h4><a href="naruci.php"><button>Naruči</button></a>
			        </div>
			    </div>
			</li>
			<li>
				<div class="home-services-padding">
				    <div class="home-services-content">
				        <div class="img">
					        <img src="assets/img/cs16-banner.png">
					        <h1>CS 1.6</h1>
				        </div>
				        <p>AntiDDos Zaštita</p>
				        <p>Ping: 20-35ms</p>
				        <p>24h Podrška</p>

				        <h4>0.36<i class="fas fa-euro-sign"></i><font class="font-16px">/slot</font></h4><a href="naruci.php"><button>Naruči</button></a>
			        </div>
			    </div>
			</li>
			<li>
				<div class="home-services-padding">
				    <div class="home-services-content">
				        <div class="img">
					        <img src="assets/img/ts3-banner.png">
					        <h1>TeamSpeak 3</h1>
				        </div>

				        <p>AntiDDos Zaštita</p>
				        <p>Ping: 20-35ms</p>
				        <p>24h Podrška</p>

				        <h4>N/A<font class="font-16px">/slot</font></h4><button>Uskoro</button>
			        </div>
			    </div>
			</li>

			<li>
			</li>
		</ul>
	</div>

	<div class="home-features">
		<ul>
			<h1>Prednosti</h1>

			<li>
			    <div class="title">
				    <img src="assets/img/shield.png">
				    <h3>Sigurnost</h3>
			    </div>
			    <p>Uz kupljeni server na našem hostingu imate full AntiDDos zaštitu</p>
		    </li>
			<li>
			    <div class="title">
				    <img src="assets/img/rocket.png">
				    <h3>Kvaliteta</h3>
			    </div>
			    <p>SAD Hosting koristi kvalitetne servere velikog kapaciteta</p>
		    </li>
			<li>
			    <div class="title">
				    <img src="assets/img/messages.png">
				    <h3>Support</h3>
			    </div>
			    <p>Našu podršku možete kontaktirati 24/7</p>
		    </li>
		</ul>
	</div>
<?php
include("./assets/footer.php");
?>
