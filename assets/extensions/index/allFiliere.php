<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
?>

<h1>filières</h1>
<section class="features">
    <article onclick="viewPole('bac')">
        <a class="image"><img src="images/pic04.jpg"/></a>
        <h3 class="major">filière bac pro</h3>
        <p><?= selectAllFiche(true,"bac"); ?> fiches</p>
        <a class="special">selectionner</a>
    </article>
    <article onclick="viewPole('bts')">
        <a class="image"><img src="images/pic05.jpg"/></a>
        <h3 class="major">filière BTS</h3>
        <p><?= selectAllFiche(true,"bts"); ?> fiches</p>
        <a class="special">selectionner</a>
    </article>
</section>