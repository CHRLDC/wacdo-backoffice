<?php

/**
 * Template de page complète : Détails de la commande
 *  Paramètres :
 *      $order - l'objet Order chargé
 *      $orderDetails - tous les détails de la commande (tous les produits de tous les Element d'une commande et tous ses détails)
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Détails de la commande</title>
</head>
<!-- Affichage du header -->
<?php include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Détails de la commande</h1>
        <div>
            <a href="index.php"><input type="button" value="Liste des commandes"></a>
        </div>
        <ul>
            <li><strong>Numéro de commande :</strong> <?= $order->number->html() ?></li>
            <li><strong>Type de commande :</strong> <?= translate($order->orderType->html()) ?></li>
            <?php if ($order->orderType->value === "eatIn"): ?>
                <li><strong>Numéro de place :</strong> <?= $order->place_number->html() ?></li>
            <?php endif; ?>
            <li><strong>Montant total :</strong> <?= $order->amount->html() ?>€</li>
            <li><strong>Provenance :</strong>
                <?php if (empty($order->User->html())): ?>
                    Commande Internet
                <?php else: ?>
                    <?= $order->User->target->name->html(); ?>
                <?php endif; ?>
            </li>
            <li><strong>Date de création :</strong> <?= $order->created_date->html() ?></li>
            <li><strong>Statut :</strong> <?= translate($order->status->html()) ?></li>
            <?php if ($order->status->html() === "delivered"): ?>
                <li><strong>Date de livraison :</strong> <?= $order->delivered_date->html() ?></li>
            <?php endif; ?>
        </ul>

        <h3>Éléments de la commande</h3>
        <ul>
            <?php foreach ($orderDetails['elements'] as $element): ?>
                <?php
                // Dépannage car problème sur getFullOrder()...
                $product = new Product();
                $products = $product->getProductsOfElement(htmlspecialchars($element->id));
                ?>
                <li>
                    <ul>
                        <?php foreach ($products as $product): ?>
                            <li> <?= $product->name->html() ?></li>
                        <?php endforeach; ?>
                        <?php if (!empty($element->size_menu->html())): ?>
                            <li><strong>Taille du menu :</strong> <?= $element->size_menu->html() ?></li>
                        <?php endif; ?>
                        <?php if (!empty($element->size_item->html())): ?>
                            <li><strong>Taille de l'item :</strong> <?= $element->size_item->html() ?></li>
                        <?php endif; ?>
                        <li><strong>Quantité :</strong> <?= $element->quantity->html() ?></li>
                        <li><strong>Prix :</strong> <?= $element->price->html() ?>€</li>
                    </ul>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
        <!-- Affichage du lien pour changer le statut de la commande en fonction de l'état de la commande et du rôle de l'utilisateur connecté -->
        <?php if ($order->status->html() != "delivered" && $order->status->html() != "canceled"): ?>
            <h3>Changer le statut de la commande</h3>
            <ul>
                <?php if (sessionIsconnected() && in_array($userConnected->role->html(), ['reception', 'admin'])): ?>
                    <li><a href="update_status_order.php?order_id=<?= $order->getId() ?>&status=canceled" onclick="return confirm('Êtes-vous sûr de vouloir annuler la commande ?');">Annulée</a></li>
                    <li><a href="update_status_order.php?order_id=<?= $order->getId() ?>&status=delivered" onclick="return confirm(`Êtes-vous sûr d'avoir livré la commande ?`);">Livrée</a></li>
                <?php endif; ?>
                <?php if (sessionIsconnected() && in_array($userConnected->role->html(), ['preparer', 'admin'])): ?>
                    <li><a href="update_status_order.php?order_id=<?= $order->getId() ?>&status=standby">En attente</a></li>
                    <li><a href="update_status_order.php?order_id=<?= $order->getId() ?>&status=inProgress">En cours de préparation</a></li>
                    <li><a href="update_status_order.php?order_id=<?= $order->getId() ?>&status=prepared">Préparée</a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>

</html>