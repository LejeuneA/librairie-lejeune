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
    <title>Qui sommes-nous</title>
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
    
    <!-- Main -->
    <main>

    <!-----------------------------------------------------------------
                               Introduction
    ------------------------------------------------------------------>
        <div class="square-right">
            <img src="../assets/components/square-right.png" alt="square">
        </div>

        <section class="introduction">

            <h1>Qui sommes-nous?</h1>
            <p>
                Depuis plus de 40 ans, nous rendons le monde des loisirs culturels accessible à tous. L’esprit ouvert,
                nous
                accompagnons jeunes et moins jeunes, francophones et non francophones, lecteurs assidus et occasionnels
                dans
                leur quête d’histoires captivantes et divertissantes … Pour chaque moment de la vie, nous offrons de
                l’inspiration, des conseils, de l’aide, de l’orientation et de la détente. Nous connaissons la bonne
                entrée
                pour chaque thème ou proposons des pistes pour l’aborder. Contrairement à ce qu’on pourrait croire,
                votre
                Librairie n’est pas une simple librairie-papeterie, mais un lieu plein d’histoires, qui enrichissent la
                vie
                quotidienne et s’adressent à toutes les générations.
                Les activités de Librairie Lejeune ne se limitent pas au secteur du retail. Les écoles, bibliothèques,
                entreprises et services publics peuvent également s’adresser à nous. En tant que clients professionnels,
                ils
                se voient attribuer un interlocuteur privilégié qui fait le lien entre leurs désirs.
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
                    Pour les bibliothèques, écoles, services publics et entreprises exclusivement…
                </h2>
                <p>
                    ... nous développons des formules de collaboration spéciales. En tant que client professionnel, vous
                    avez des exigences spécifiques, mais vous attendez sans aucun doute la même qualité de service
                    personnalisé que n'importe quel client privé. Nos services ont une grande expérience des gros
                    volumes, des procédures et processus (de paiement) spécifiques ... et connaissent parfaitement le
                    monde de l'enseignement belge. Nous entretenons également des relations étroites avec l'ensemble du
                    réseau des éditeurs (scolaires) en Belgique (et à l'étranger). En d'autres termes, nous sommes au
                    courant des dernières publications et des travaux en cours.
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
                    Comme notre propre magasin 
                </h2>
                <p>
                    C’est notre métier de livrer sur mesure toute commande, peu importe son volume ou sa particularité,
                    et de la suivre de A à Z. Nous considérons votre école, bibliothèque, service ou entreprise comme
                    s’il s’agissait d’un de nos propres magasins. C’est pour cette raison que nous nous chargeons de
                    tous les aspects logistiques – faciliter la vie du client est pour ainsi dire notre marque de
                    fabrique – et appliquons judicieusement les meilleures pratiques.
                </p>
            </div>
            <!-- Information-bottom-left end -->

            <!-- Information-bottom-right -->
            <div class="information-bottom-right information-bottom-right--about-us">
                <h3>
                    Devenir partenaire?
                </h3>
                <ul>
                    <li>
                        En savoir plus?
                    </li>
                    <li>
                        <i class="fa-regular fa-envelope"></i>
                        Contactez-nous par mail <br><a
                            href="mailto:contact@acelyalejeune.be">corporate@librairie.com</a>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i>
                        ou par téléphone <br> <span>0493 38 77 29</span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>

</body>

</html>