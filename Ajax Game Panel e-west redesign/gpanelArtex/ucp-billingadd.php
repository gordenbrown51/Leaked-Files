<?php
session_start();
include("includes.php");
$naslov = $jezik['text563'];
$fajl = "ucp";
$return = "ucp.php";
$ucp = "ucp-billing";
$tip = $_GET['tip'];


include("./assets/header.php");
?>
<?php
if(!isset($_SESSION['klijentid'])){
    header("Location: process.php?task=logout");
} 
if($_GET['tip'] == 'sms') {
    header('Location: ucp-smsadd.php');
    exit;
}

$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$_SESSION['klijentid']."'");

// Ovo za info, ti uradi
$ppinfo = query_fetch_assoc("SELECT * FROM `paypal_ipn` WHERE `clientid` = '{$_SESSION[klijentid]}' ORDER BY `id` DESC LIMIT 1");



?>
   <div class="main">
        <div class="panel">
            <div class="panel-nav">
                <ul class="light-border">
                <ul class="light-border">
                   <a href="ucp-billing.php"><li>Pregled</li></a>
                    <a href="ucp-billingadd.php"><li class="panel-nav-active">Nova Uplata</li></a>
                    <a href="ucp-uplatnica.php"><li>Uplatnice</li></a>
                    <a href="ucp-smslogovi.php"><li>SMS Logovi</li></a>
                </ul>
            </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-comment-dollar"></i> Billing</h4>
                        <?php if($_GET['tip'] === "banka") { ?>
                            <p>Dodajte novu uplatu putem uplatnice!</p>
                            <h3><i class="fas fa-info-circle"></i> Pogledajte <a target="_blank" href="ucp-uplatnica.php">OVDJE</a> kako ispuniti uplatnicu</h3>
                        <?php }; ?>
                        <?php if($_GET['tip'] === "paypal") { ?>
                            <p>Dodajte novu uplatu putem PayPal-a!</p>
                        <?php }; ?>
                        <?php if($_GET['tip'] === "psc") { ?>
                            <p>Dodajte novu uplatu putem PaySafeCard-a!</p>
                        <?php } 
                         if(empty($_GET['tip'])) { ?>
                            <p>Dodajte novu uplatu! Pogledajte <a target="_blank" href="ucp-uplatnica.php">OVDJE</a> kako ispuniti uplatnicu</p>
                        <?php }; ?>
                    </div>
                  
<?php	if(!isset($_GET['tip'])){	?>
<div class="new-ticket">  
            <form action="ucp-billingadd.php" method="GET">
                <div class="form-input">
                    <label>Način plaćanja</label>
                <select name="tip">
                    <option value="banka"><?php echo $jezik['text566']; ?></option> /* Banka */
                    <option value="paypal"><?php echo $jezik['text567']; ?></option> /* PayPal */
                    <option value="psc">Paysafecard (Hrvatska)</option>
                    <option value="sms">SMS</option>
                    </select>
                </div>
                <div class="form-input">
                <button type="submit"><i class="icon-arrow-right"></i> Dalje</button>
            </div>
            </form>
</div>
<?php } else if($_GET['tip']=="psc") {	?>

<div class="new-ticket">  
        <form action="process.php" method="POST">
            <div class="form-input">
                <label>*<?php echo $jezik['text570']; ?></label>
                 <input name="novac" type="text" placeholder="Primjer: 50.00 kn: " />
            </div>

            <div class="form-input">
                <label>*<?php echo $jezik['text571']; ?></label>
                <input name="psc" type="text" placeholder="PSC broj: xxxxxxxxxxxxxxxx" />
            </div>

            <input type="hidden" name="task" value="dodaj_uplatu_psc" />
            <input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />

            <div class="form-input">
                <button type="submit"><i class="icon-arrow-right"></i> <?php echo $jezik['text562']; ?></button>
            </div>
        </form>
    </div>

<?php	} else if($_GET['tip']=="banka") {	?>
<div class="new-ticket">
            <form action="process.php" method="POST">
                <div class="form-input">
                    <label>*<?php echo $jezik['text569']; ?></label>
                    <input name="ime" type="text" placeholder="<?php echo $jezik['text576']; ?>: <?php echo $klijent['ime'].' '.$klijent['prezime']; ?>" />
                </div>

                <div class="form-input">
                    <label>*<?php echo $jezik['text570']; ?></label>
                     <input name="novac" type="text" placeholder="<?php echo $jezik['text576']; ?>: <?php echo str_replace(" din", "", novac("250", $klijent['zemlja'])); ?>" />
                </div>

                <div class="form-input">
                    <label>*<?php echo $jezik['text571']; ?></label>
                     <input name="brracuna" type="text" placeholder="<?php echo $jezik['text576']; ?>: xxxxxxxxxxxxxx" />
                </div>

                <div class="form-input">
                    <label>*<?php echo $jezik['text572']; ?></label>
                    <input name="datum" type="text" placeholder="<?php echo $jezik['text576']; ?>: <?php echo date("d.m.Y, H:i", time()); ?>" />
                </div>

                <div class="form-input">
                    <label>*<?php echo $jezik['text573']; ?></label>
                            <select name="drzava">
                                <option value="srb">Srbija</option>
                                <option value="cg">Crna gora</option>
                                <option value="bih">Bosna i Hercegovina</option>
                                <option value="hr">Hrvatska</option>
                            </select>
                </div>

                <div class="form-input">
                    <label><?php echo $jezik['text574']; ?></label>
                    <input name="uplatnice" type="text" placeholder="http://slika.png | http://slika2.png ..." />
                </div>

                            <input type="hidden" name="task" value="dodaj_uplatu" />
                            <input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />

                 <div class="form-input">
                             <button type="submit"><i class="icon-arrow-right"></i> <?php echo $jezik['text562']; ?></button>

                 </div>
            </form>
        </div>

    <?php	} else if($_GET['tip']=="paypal") {	?>

            <script type="text/javascript">
                //<!--

                function paymentProcess() {
                    var mForm = document.paypal_form;
                    var pmtAmt = 0;
                    pmtAmt = mForm.amount.value;

                    var check_re = /^[^\d]*([0-9,]*\.?\d*).*$/;

                        if ((trim(pmtAmt) != "") && pmtAmt.match(check_re)) {
                            var amount = parseFloat(pmtAmt.replace(check_re, "$1").replace(",", ""));
                            amount = amount.toFixed(2);

                            if (!isNaN(amount))
                            {
                                if (amount < 1) {
                                    alert("<?php echo _GP_BILLINGADD_PAYPAL_AMOUNT_MIN ?>");
                                } else if (amount > 10000) {
                                    alert("<?php echo _GP_BILLINGADD_PAYPAL_AMOUNT_MAX ?>");
                                } else {

                                    mForm.amount.value = amount;
                                    mForm.submit();
                                }
                            } else {
                                alert("<?php echo _GP_BILLINGADD_PAYPAL_AMOUNT_ER1 ?>");
                            }
                        } else {
                            alert("<?php echo _GP_BILLINGADD_PAYPAL_AMOUNT_ER1 ?>");
                        }
                }


                //-->
            </script>
<div class="new-ticket">  
            <?php


                if($_SESSION['klijentid'] == 652) //botko
                echo '<form name="paypal_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
                else
                echo '<form name="paypal_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">';


            ?>

                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="<?php echo $config['paypal']['email']?>">
                        <input type="hidden" name="item_name" value="e-West Payment Add Funds">



                        <?php

                            $random_hash2 = random_str( $length = 6, $chars = "1234567890" );
                            $random_hash3 = random_str( $length = 2, $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" );

                            $tid = ''.$_SESSION['klijentid']."-".$random_hash3."".$random_hash2.'';

                        ?>

                        <input type="hidden" name="invoice" value="<?php echo $tid;?>" />
                        <input type="hidden" name="currency_code" value="EUR">
                        <?php


                            if($_SESSION['klijentid'] == 651) //botko
                            echo '<input type="hidden" name="notify_url" value="http://morenja.info/paypal/paypal_payment.php" />';
                            else
                            echo '<input type="hidden" name="notify_url" value="http://morenja.info/paypal/paypal_payment.php" />';


                        ?>
                        <input type="hidden" name="cancel_return" value="http://morenja.info/ucp-billingadd.php?tip=paypalcancel" />
                        <input type="hidden" name="return" value="http://morenja.info/ucp-billingadd.php?tip=paypalsuccessfunds" />

                        <input type="hidden" name="cbt" value="Back to Morenja Hosting" />
                        <input type="hidden" name="no_note" value="1" />
                        <input type="hidden" name="no_shipping" value="1" />
                        <input type="hidden" name="cs" value="1" />
                        <input type="hidden" name="cpp_header_image" value="http://morenja.info/assets/blue/img/logo2.png" />
                        <input type="hidden" name="page_style" value="gameservers"/>

            <div class="form-input">
                <label>*<?php echo _GP_BILLINGADD_PAYPAL_AMOUNT ?></label>
                <input type="text" name="amount" placeholder="<?php echo $jezik['text576']; ?>: 10€"/> <br />
            </div>


                        <input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />

                        <!--<input type="image" src="https://www.paypalobjects.com/en_US/AT/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!" style="border:0;width:100px;">-->

                        <a href="javascript:paymentProcess();"><button><i class="icon-arrow-right"></i> <?php echo $jezik['text562']; ?></button></a>

    </form>
</div>
        <?php	} else if($_GET['tip']=="paypalsuccessfunds") {

        $payment_status = $_POST['payment_status'];
        $datum = $_POST['payment_date'];
        $txn_id = $_POST['txn_id'];

        ?>
<?php	} ?>
        </td>
    </tr>
</table> <!-- #tabbilling end -->
<script src="https://assets.fortumo.com/fmp/fortumopay.js" type="text/javascript"></script>
<?php
include("./assets/footer.php");
?>