<?php

/*
*
* Template de page complète : afficher la liste des commandes
* Paramètres :
*    $orders_list : tableau des objets Order triés
* JavaScript : Rafraichissement de la liste toutes les secondes
*/

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien CSS -->
    <link rel="stylesheet" href="public/css/style.css">
    <title>Liste des commandes</title>
</head>
<!-- Inclure le Header -->
<?php include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Liste des commandes</h1>
        <!-- Options de tri -->
        <div class="sort-options">
            <label for="sort-by">Trier par :</label>
            <select id="sort-by">
                <option value="delivered_date">Date de livraison</option>
                <option value="created_date">Date de création</option>
                <option value="status">Statuts</option>
                <option value="amount">Montant</option>
                <option value="orderType">Type de commande</option>

                <!-- Ajouter d'autres critères de tri si nécessaire -->
            </select>

            <label>Ordre :</label>
            <label><input type="radio" name="sort-order" value="ASC" checked> Croissant</label>
            <label><input type="radio" name="sort-order" value="DESC"> Décroissant</label>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Table</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Provenance</th>
                    <th>Date de création</th>
                    <th>Date de livraison</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="orders-list">
                <!-- Fragment de la liste des commandes -->
                <?php include_once "templates/fragments/list_orders_fragment.php"; ?>
            </tbody>
        </table>
    </div>

    <!-- Lien JavaScript pour le rafraîchissement -->
    <script src="public/js/refresh_list_order.js" defer></script>
</body>

</html>