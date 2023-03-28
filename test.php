<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';

    // mailRefuserFiche("7nle51B4QsglVJGSXd+9NIxBZYo6G9180iFteKL/xno=",3,"1.1.1")
    $mail = openssl_encrypt("pro.antoine.masia@gmail.com", $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    
    // mailtest($mail);
    mailConfirmation($mail,"fsefsefsefsf");
?>