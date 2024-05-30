<?php
require_once('../admin/settings.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez Librairie Lejeune pour des livres, fournitures de papeterie et cadeaux uniques. Parcourez notre sélection dès aujourd'hui!">


    <!-- Custom Sass file -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Google Fonts Preconnect and Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->

    <!-- Title -->
    <title>Travailler chez nous</title>
</head>

<body>
   <!-----------------------------------------------------------------
                               Header
    ------------------------------------------------------------------>
    <header>
        <!-----------------------------------------------------------------
                               Navigation
        ------------------------------------------------------------------>
        <?php displayNavigationGlobal(); ?>
        <!-----------------------------------------------------------------
                            Navigation end
        ------------------------------------------------------------------>
    </header>
    <!-----------------------------------------------------------------
                               Header end
    ------------------------------------------------------------------>
        <div class="header-image--work-with-us">
        </div>
    </header>
    <!-----------------------------------------------------------------
                            Header end
    ------------------------------------------------------------------>
    <!-- Main -->
    <main>

        <!-----------------------------------------------------------------
                               Introduction
    ------------------------------------------------------------------>
        <div class="square-right">
            <img src="../assets/components/square-right.png" alt="square">
        </div>

        <section class="introduction">

            <h1>Travailler chez nous</h1>
            <p>
                Nous visons à développer le potentiel culturel et créatif à tout âge et à chaque moment de la vie.  
                Pour nous, la culture, c'est une ouverture sur le monde et sur les autres ! Nous vous offrons un cadre
                de travail inspirant qui vous permet d'exprimer votre personnalité et votre richesse culturelle dans vos
                contacts avec les clients. Travailler chez nous, c'est aimer cultiver le savoir et la créativité, en y
                alliant vos propres connaissances et votre appétit d'apprendre.
                Notre offre d’emplois est aussi vaste que nos univers en librairie et papeterie. Vous avez la
                possibilité de travailler près de chez vous dans plus de 45 magasins dans tout le pays. 
                Et pourquoi ne pas gérer vous-même un magasin ? Seul(e) ou à deux. Vous bénéficierez du soutien et de
                l’expérience des experts de nos sièges centraux et de notre centre de distribution (Temse). Et, bien
                sûr, de vos collègues de notre réseau de magasins. Chez Librairie Lejeune, vous n’êtes jamais seul(e).
            </p>
        </section>
        <div class="square-left">
            <img src="../assets/components/square-left.png" alt="square">
        </div>
        <!-----------------------------------------------------------------
                               Introduction end
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                               Information
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                               Information top
        ------------------------------------------------------------------>
        <section class="information-top">

            <!-- Container -->
            <div class="container">

                <h2>
                    Vous voulez passer du statut d'amateur de livres à celui de libraire ? Vous avez déjà de
                    l'expérience dans la vente de livres et vous souhaitez rejoindre l'équipe de nous ?
                </h2>
                <p>
                    Nous aimons les livres, et nos clients aussi. Nous travaillons dur pour créer une expérience de
                    librairie incroyable pour nos clients (en magasin et en ligne!) où l'environnement, le service, le
                    choix, la recommandation et la découverte sont tous des standards d'or - tout cela grâce à nos
                    équipes compétentes, amicales et enthousiastes.
                </p>
            </div>
        </section>
        <!-- Information-top end -->

        <!-- Container end -->
        <!-----------------------------------------------------------------
                               Information top end
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                               Information bottom
        ------------------------------------------------------------------>
        <section class="information-bottom container">

            <!-- Information-bottom-left -->
            <div class="information-bottom-left">
                <h2>
                    Travailler chez nous
                </h2>
                <p>
                    En travaillant avec nous, vous pourrez utiliser votre expertise et votre enthousiasme pour offrir à
                    nos clients les plaisirs irremplaçables d'une bonne librairie.
                    Si vous êtes un amoureux des livres, sympathique et flexible, et que vous pensez avoir ce que nous
                    recherchons, nous serions ravis d'entendre parler de vous. Jetez un coup d'œil ci-dessous pour voir
                    s'il existe des offres d'emploi pertinentes auxquelles vous pouvez postuler.
                </p>
            </div>
            <!-- Information-bottom-left end -->

            <!-- Information-bottom-right -->
            <div class="information-bottom-right information-bottom-right--work-with-us">
                <h3>
                    Envie de travailler chez nous?
                </h3>
                <ul>
                    <li>
                        <i class="fa-regular fa-envelope"></i>
                        Envoyez-nous votre CV par mail <br><a
                            href="mailto:contact@acelyalejeune.be">contact@librairie.com</a>
                    </li>
                </ul>
            </div>
            <!-- Information-bottom-right end -->
        </section>
        <!-- Information-top end -->

        <!-----------------------------------------------------------------
                            Information bottom end
        ------------------------------------------------------------------>
    </main>
    <!-- Main end -->


    <!-----------------------------------------------------------------
                                Footer
    ------------------------------------------------------------------>
    <footer>
        <div data-include="footer"></div>
    </footer>
    <!-----------------------------------------------------------------
                              Footer end
    ------------------------------------------------------------------>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>