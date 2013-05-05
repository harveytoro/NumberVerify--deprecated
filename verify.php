<?php

session_start();
require 'verifySMS.php';


$obj = new verifySMS();

if(isset($_POST['submit'])){

$number = $_POST['twilionum'];
$jsn = $obj->send_sms($number,'TwilioNumber');
$_SESSION['vrfy']=$jsn;

}

if(isset($_POST['verify'])){
$jsn = $_SESSION['vrfy'];
if($jsn === $_POST['twilionum']){
echo "Enhorabuena";

}else{
	echo "Try again dirtbag";
}
}

?>
<html>

<head>
<title></title>

</head>
<body>
<h1></h1>

<div id="twiliostyle">
<form method='post' action='verify.php'>

<input id="twiliobox" type="text"  name="twilionum" placeholder="Verification code as sent via text" />
<div class="submit-container">


<input class="submit-button" type="submit" name="verify" value="Verify"/>
</div>
</form>
</div>
</body>
</html>