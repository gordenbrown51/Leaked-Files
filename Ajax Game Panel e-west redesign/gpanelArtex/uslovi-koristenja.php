<?php
session_start();
include("includes.php");
$serverid = mysql_real_escape_string($_GET['id']);
$fajl = "uslovi";
$return = "index.php";
$domena = $_SERVER['SERVER_NAME'];


$metatitle = "Uslovi korištenja";
$metadesc = "Uslovi korištenja e-West Hostinga!";
$naslov = $metatitle;
include("./assets/header.php");
?>
    <div class="main">
        <div class="document-style">
            <p>
                <h1>Korištenje stranice</h1>
                <p>Na korištenje web stranice eWest, u vlasništvu eWest Hosting i svih njegovih dijelova, primjenjuju se ovi Uslovi korištenja.<br>
                Stranica zadržava pravo promjene, ukidanja (privremenog i trajnog) bilo kojeg sadržaja ili usluge na Stranici bez obaveze prethodne najave.<br>
                Portal sadrži linkove na web stranice trećih osoba. Portal linkove objavljuje u dobroj namjeri i ne može se smatrati odgovornim za sadržaje izvan Portala. Sadržaj izvan Portala koristite na vlastitu odgovornost.</p>
                <h1>Zaštita privatnosti</h1>
                <p>e-West štiti privatnost korisnika u najvećoj mogućoj mjeri.
                    e-West se obavezuje da će u dobroj namjeri koristiti podatke dobijene od korisnika tokom korištenja Stranice, te da privatne podatke neće distribuirati niti prodavati trećoj strani, osim uz dozvolu korisnika.

                    e-West može u skladu sa zakonom prikupljati određene podatke o korisnicima dobijene tokom korištenja portala (isključivo podaci o računaru i podaci o internet-provideru) ili podatke unesene u postupku registracije. Ove podatke Stranica koristi kako bi imao informacije o korisnicima koji ga koriste, te na taj način poboljšao Stranicu i njegove sadržaje dodatno usmjerio i prilagodio onima koji ga posjećuju. Na temelju tih podataka saznajemo koji su sadržaji najpopularniji među kojim posjetiocima.

                    Portal se obavezuje da će čuvati privatnost korisnika Hostinga, osim u slučaju teškog kršenja pravila Portala ili nezakonitih aktivnosti korisnika.

            </p>
            <h1>Obaveze Korisnika</h1>
            <p>
            Korisnicima Sajta strogo je zabranjeno:
            <br>- objavljivanje, slanje i razmjena sadržaja koji krše postojeće BH i/ili međunarodne zakone, sadržaja koji je uvredljiv, vulgaran, prijeteći, rasistički ili šovinistički, te štetan na bilo koji drugi način;
            <br>- objavljivanje, slanje i razmjena informacija za koje posjetitelj zna ili pretpostavlja da su lažne, a čije bi korištenje moglo nanijeti štetu drugim korisnicima;
            <br>- lažno predstavljanje, odnosno predstavljanje u ime druge pravne ili fizičke osobe;
            <br>- objavljivanje, slanje i razmjenu sadržaja koji su zaštićeni autorskim pravom;
            <br>- objavljivanje, slanje i razmjena neželjenih sadržaja korisnicima bez njihovog pristanka ili traženja, ili putem obmane;
            <br>- svjesno objavljivanje, slanje i razmjena sadržaja koji sadrži viruse ili slične računalne datoteke ili programe načinjene u svrhu uništavanja ili ograničavanja rada bilo kojeg računalnog softvera i/ili hardvera i telekomunikacijske opreme;
            <br>- prikupljanje, čuvanje i objavljivanje osobnih podataka drugih posjetitelja Portala i korisnika.
        </p>

<h1>Registrovani korisnici</h1>

<p>Registrovanjem na eWest hosting korisnik je obavezan proći postupak registracije, unijeti istinite podatke, te odabrati korisničko ime i lozinku.

<br>Za sve objavljene sadržaje pod pojedinim korisničkim imenom odgovoran je isključivo korisnik koji ga koristi. e-West ne može odgovarati za neovlašteno korištenje računa, niti eventualnu štetu nastalu na taj način.
<br>
<br>eWest zadržava pravo da ukine ili da uskrati mogućnost korištenja korisničkog računa bez prethodne najave ili/i objašnjenja.

<br>eWest ne snosi odgovornost za štetu nastalu ukidanjem korisničkog računa.
</p>
        </div>
    </div>

<?php
include("./assets/footer.php");
?>
