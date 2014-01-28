<?php
$name = $mail_message->getName();
$body_content = $mail_message->getContent();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style>
h1{
  float: left;
  margin-top: 18px;
  margin-left: 14px;
  font-size: 19px;
  font-family: 'ITCAvantGardeStd-Demi';
  color: #404040;
  padding-left: 25px;
  margin-bottom: 5px;
}

p{
  font-size:14px;
  margin:10px;
}

a{
 text-decoration:none; 
 font-family:Arial; 
 font-size:14px; 
 color: #F68F00;
 display:inline-block;
}

</style>
</head>
<body style="font-family:Arial; font-size:14px; color:#8D8A6A;">
 <table width="670" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td><h2>&iexcl;Hola <?= $name ?>&#33;</h2></td>
  </tr>
</table>
<br>
<br>
 <table width="670" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
    <?php echo html_entity_decode($body_content) ?>
    </td>
  </tr>
</table>

 <br >
 <br >
<table width="670" border="0" cellpadding="0" cellspacing="0" align="center" style="font-family:Arial; font-size:14px; color:#8D8A6A;">
   <tr>
    <td>Cualquier sugerencia o petici&oacute;n no dudes en escribirnos, estaremos atentos. <br />
        <b>Gracias por tu participaci&oacute;n.  &iexcl;Seguimos avanzado&#33; </b>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td> <img src="http://www.kuepa.com/escuela/images/logo_email_preicfes_footer.png" />   </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php

?>


</body>
</html>