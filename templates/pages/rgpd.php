<?php

/**
 * display_rgpd.php
 * Controleur : Générer l'affichage de la page RGPD
 *  Paramètres:
 *      $user - L'utilisateur à afficher
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Informations sur les données personnelles</title>
</head>
<!-- Afficher le header -->
<?= include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Vos données personnelles</h1>

        <p>
            Conformément au Règlement Général sur la Protection des Données (RGPD), nous vous informons de la manière dont
            vos données personnelles sont collectées, utilisées, et partagées. Vous disposez d'un droit de consultation,
            modification et suppression de ces données.
        </p>
        <section>
            <h2>Informations de votre compte</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $user->name->html(); ?></td>
                        <td><?= $user->first_name->html(); ?></td>
                        <td><?= $user->mail->html(); ?></td>
                    </tr>
                </tbody>
            </table>


            <h2>Vos droits</h2>
            <p>
                Vous avez le droit de :
            </p>
            <ul>
                <li>Consulter et récupérer les données personnelles que nous détenons sur vous.</li>
                <li>Modifier vos données personnelles si elles sont incorrectes ou incomplètes.</li>
                <li>Demander la suppression de vos données personnelles.</li>
            </ul>

            <p>
                Pour exercer ces droits, veuillez nous contacter à l'adresse suivante : <a href="mailto:support@example.com">support-rgpd@wacdo.com</a>.
            </p>

            <p>
                Nous mettons en œuvre toutes les mesures nécessaires pour protéger vos données sensibles.
            </p>

            <h2>Gestion des Cookies</h2>
        </section>
        <section>
            <h2>Politique de gestion des cookies</h2>
            <p>Notre site utilise des cookies pour améliorer votre expérience utilisateur et assurer le bon fonctionnement de nos services. Cette section détaille les types de cookies que nous utilisons, leur finalité, et comment vous pouvez gérer vos préférences.</p>

            <h3>1. Qu'est-ce qu'un cookie ?</h3>
            <p>Un cookie est un petit fichier texte déposé sur votre appareil (ordinateur, tablette, smartphone) lorsque vous visitez un site web. Les cookies permettent au site de reconnaître votre appareil et de mémoriser certaines informations sur vos préférences ou vos actions passées.</p>

            <h3>2. Types de cookies utilisés</h3>
            <p>Nous utilisons les types de cookies suivants sur notre site :</p>
            <ul>
                <li><strong>Cookies nécessaires</strong> : Ces cookies sont indispensables pour assurer le fonctionnement du site. Ils vous permettent de naviguer sur le site et d'utiliser ses fonctionnalités, comme accéder à des zones sécurisées ou conserver votre session active.</li>
                <li><strong>Cookies de session</strong> : Ces cookies permettent de maintenir votre session utilisateur active, par exemple pour gérer votre connexion et les informations de votre panier d'achat. Ces cookies expirent à la fermeture de votre navigateur.</li>
                <li><strong>Cookies de performance</strong> : Ils collectent des informations sur la façon dont les utilisateurs interagissent avec notre site, afin que nous puissions améliorer sa performance. Les données collectées par ces cookies sont anonymes.</li>
            </ul>

            <h3>3. Finalité des cookies</h3>
            <p>Les cookies que nous utilisons sur ce site ont pour objectif de :</p>
            <ul>
                <li><strong>Assurer le bon fonctionnement du site</strong> : Les cookies de session et de sécurité permettent d'assurer la continuité de votre navigation en conservant des informations essentielles, comme votre panier ou votre connexion.</li>
                <li><strong>Améliorer votre expérience utilisateur</strong> : Nous utilisons des cookies pour mémoriser vos préférences, telles que votre langue ou vos choix de produits, afin de rendre votre expérience de navigation plus fluide.</li>
            </ul>

            <h3>4. Gestion des cookies</h3>
            <p>Vous avez la possibilité de gérer vos préférences de cookies directement depuis notre site ou via les paramètres de votre navigateur. Vous pouvez choisir de bloquer certains types de cookies ou de supprimer ceux déjà installés. Cependant, veuillez noter que certaines fonctionnalités du site peuvent être limitées ou indisponibles si vous bloquez certains cookies nécessaires.</p>

            <h3>5. Consentement</h3>
            <p>En utilisant notre site, vous consentez à l'utilisation des cookies conformément à la présente politique. Vous pouvez retirer votre consentement à tout moment en modifiant les paramètres de votre navigateur.</p>
        </section>

        <p>
            Cordialement,<br>
            L'équipe de Wacdo
        </p>
    </div>
</body>

</html>