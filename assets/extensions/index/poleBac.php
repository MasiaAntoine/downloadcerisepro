<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
?>

<h1>filières > Bac</h1>
<section class="features">
    <article>
        <a href="fiches-bac-p1-date-1" class="image"><img src="images/pole1.jpg" alt="" /></a>
        <h3 class="major">Pôle 1</h3>
        <p><?= selectAllFiche(true,"bac",1); ?> fiches</p>
        <a href="fiches-bac-p1-date-1" class="special">selectionner</a>
    </article>
    <article>
        <a href="fiches-bac-p2-date-1" class="image"><img src="images/pole2.jpg" alt="" /></a>
        <h3 class="major">Pôle 2</h3>
        <p><?= selectAllFiche(true,"bac",2); ?> fiches</p>
        <a href="fiches-bac-p2-date-1" class="special">selectionner</a>
    </article>
    <article>
        <a href="fiches-bac-p3-date-1" class="image"><img src="images/pole3.jpg" alt="" /></a>
        <h3 class="major">Pôle 3</h3>
        <p><?= selectAllFiche(true,"bac",3); ?> fiches</p>
        <a href="fiches-bac-p3-date-1" class="special">selectionner</a>
    </article>
    <article>
        <a href="fiches-bac-p4-date-1" class="image"><img src="images/pole4.jpg" alt="" /></a>
        <h3 class="major">Pôle 4</h3>
        <p><?= selectAllFiche(true,"bac",4); ?> fiches</p>
        <a href="fiches-bac-p4-date-1" class="special">selectionner</a>
    </article>
</section>
<ul class="actions" onclick="backPole()">
    <li><a class="button primary">Retour</a></li>
</ul>