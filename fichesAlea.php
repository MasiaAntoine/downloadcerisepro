<!-- <?php
    // include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    // session_start();

    // $bdd = connexion_db();

    // vide la table des fiches
    // $stmt = $bdd->prepare("DELETE FROM fiches");
    // $stmt->execute();
    // return $stmt->fetchAll();
    
    // for($i=0;$i<20;$i++) {
    //     //tableau des correspondance
    //     $correspondance = [
    //         "1.1.1", "1.1.2", "1.1.3", "1.1.4", "1.1.5", "1.2.1", "1.2.2", "1.2.3", "1.2.4", "1.2.5", "1.3.1", "1.3.2", "1.3.3", "1.3.4", 
    //         "2.1.1", "2.1.2", "2.1.3", "2.1.4", "2.2.1", "2.2.2", "2.2.3", "2.2.4", "2.2.1", "2.2.2", "2.2.3", "2.2.4", "2.3.1", "2.3.2", "2.3.3", "2.4.1", "2.4.2", "2.4.3", "2.4.4",
    //         "3.1.1", "3.1.2", "3.1.3", "3.2.1", "3.2.2", "3.2.3", "3.2.4", "3.3.1", "3.3.2", "3.3.3", "3.3.4", "3.3.5", "3.4.1", "3.4.2",
    //         "4.1.1", "4.1.2", "4.1.3", "4.1.4", "4.1.5", "4.1.6", "4.1.7", "4.1.8", "4.1.9", "4.2.1", "4.2.2", "4.2.3" 
    //     ];
    //     $correspondance = $correspondance[rand(0,count($correspondance)-1)];
    
    //     //tableau filiere
    //     $filiere = ["bts", "bac"];
    //     $filiere = $filiere[rand(0,count($filiere)-1)];
    
    //     //qualité
    //     $quality = rand(0,2);
    
    //     //random date
    //     $timestamp = rand(strtotime("Jan 01 2018"), strtotime("Dec 30 2022"));
    //     $date = date("Y.m.d", $timestamp);
    
    //     //random titre
    //     $titre = substr(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum, 0, 30);
    //     $text1 = substr(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum, 0, 200);
    //     $text2 = substr(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum, 0, 200);
    //     $text3 = substr(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum, 0, 200);
    //     $text4 = substr(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum, 0, 200);
    //     $text5 = substr(simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum, 0, 200);
    
    //     $titre = openssl_encrypt($titre, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    //     $text1 = openssl_encrypt($text1, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    //     $text2 = openssl_encrypt($text2, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    //     $text3 = openssl_encrypt($text3, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    //     $text4 = openssl_encrypt($text4, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    //     $text5 = openssl_encrypt($text5, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);

    //     //
    //     $stmt = $bdd->prepare("INSERT INTO fiches(Filiere,Quality,Public,Date,Titre,Correspondance,Text1,Text2,Text3,Text4,Text5) VALUES (:filiere,:quality,true,:date,:titre,:correspondance,:text1,:text2,:text3,:text4,:text5)");
    //     $stmt->execute([
    //         ":filiere" => $filiere,
    //         ":quality" => $quality,
    //         ":date" => $date,
    //         ":titre" => $titre,
    //         ":text1" => $text1,
    //         ":text2" => $text2,
    //         ":text3" => $text3,
    //         ":text4" => $text4,
    //         ":text5" => $text5,
    //         ":correspondance" => $correspondance
    //     ]);
    //     $stmt->rowCount();
    // }
    
?> -->