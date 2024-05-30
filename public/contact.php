<?php
require_once('../admin/settings.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez Librairie Lejeune pour des livres, fournitures de papeterie et cadeaux uniques. Parcourez notre sélection dès aujourd'hui!">


    <!-- Custom Sass file -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Google Fonts Preconnect and Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Favicon -->

    <!-- Title -->
    <title>Contactez-nous</title>
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
    <div class="header-image--contact">
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

            <h1>Contactez-nous</h1>
            <p>
                Pour toute question relative au service clientèle, aux commandes en magasin et en ligne, aux
                remboursements et aux retours, veuillez contacter notre équipe du service clientèle.
            </p>
        </section>
        <div class="square-left">
            <img src="../assets/components/square-left.png" alt="square">
        </div>
        <!-----------------------------------------------------------------
                               Introduction end
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                               Contact icons
        ------------------------------------------------------------------>
        <section class="contact-icons-container">
            <div class="contact-icons container">
                <article>
                    <img src="../assets/icons/contact-icons-02.png" alt="Livraison gratuite">
                    <p>Téléphonez-nous au<span>0493 38 77 29</span></p>
                </article>

                <article>
                    <img src="../assets/icons/contact-icons-03.png" alt="Retours faciles">
                    <p>Contactez-nous sur<span>Via le formulaire de contact</span></p>
                </article>

                <article>
                    <img src="../assets/icons/contact-icons-04.png" alt="Qualité première">
                    <p>Envoyer-nous un message<span>support@librairie.com</span></p>
                </article>
            </div>
        </section>
        <!-----------------------------------------------------------------
                               Contact icons end
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                                Contact form
        ------------------------------------------------------------------>
        <!-- Contact section -->
        <section class="contact-section container">
            <div class="contact-title">
                <h1>Contactez-nous</h1>
            </div>
            <!-- Contact form -->
            <form action="/action_page.php">
                <label for="fname">Prénom</label>
                <input type="text" id="fname" name="firstname" placeholder="Votre prénom...">

                <label for="lname">Nom</label>
                <input type="text" id="lname" name="lastname" placeholder="Votre nom...">

                <label for="country">Pay</label>
                <select id="country" name="country">
                    <option value="australia">Belgique</option>
                    <option value="canada">France</option>
                    <option value="usa">Angleterre</option>
                </select>

                <label for="subject">Message</label>
                <textarea id="subject" name="subject" placeholder="Rédiger votre message..." style="height:200px"></textarea>
                <!-- Checkbox -->
                <div class="checkbox">
                    <input type="checkbox" id="cgu" name="cgu" required>
                    <label for="cgu">J'accepte les condition générales d'utilisation</label>
                </div>
                <!-- Checkbox end -->
                <!-- Button -->
                <input type="reset" value="Réinitialiser">
                <input type="submit" value="Envoyer">
                <!-- Button end -->
            </form>

            <!-- Contact form end -->
        </section>
        <!-- Contact section end -->
        <!-------------------------------------------------------- 
                          Contact form end
        ---------------------------------------------------------->


    </main>

    <!-- Footer -->
    <footer>
        <div data-include="footer"></div>
    </footer>


    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>

</body>

</html>