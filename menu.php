<header id="header"<?php if(isset($home)) {echo(' class="alt"');} ?>>
    <h1><a>Download Cerise Pro</a></h1>
    <nav>
        <a href="#menu">Menu</a>
    </nav>
</header>

<nav id="menu">
    <div class="inner">
        <h2>Menu</h2>
        <ul class="links">
            <li><a href="/">Accueil</a></li>
            <li><a href="fiches-bac-p1-date-1">Les fiches</a></li>

            <?php if(isset($_SESSION['idUser'])): ?>
            <li><a href="boutique">pièces cerises</a></li>
            <?php endif; ?>
            <br>

            <?php if(isset($_SESSION['idUser'])): ?>
            <a href="/profil" class="button">Profil</a>
            <?php else: ?>
            <a href="/connexion" class="button">Connexion</a>
            <?php endif; ?>
        </ul>
        <a href="#" class="close">Close</a>
    </div>
</nav>