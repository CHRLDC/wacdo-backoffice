<?php
/*
*
* Fragment : Affiche la liste des commandes
* Paramètres :
*    $orders_list : tableau des objets Order
*
*/
?>

<?php if (!empty($orders_list)): ?>
    <?php foreach ($orders_list as $order): ?>
        <tr>
            <td><?= $order->number->html(); ?></td>
            <?php if (empty($order->place_number->html())): ?>
                <td>Non</td>
            <?php else: ?>
                <td><?= $order->place_number->html(); ?></td>
            <?php endif; ?>
            <td><?= translate($order->orderType->value); ?></td>
            <td><?= $order->amount->html(); ?> €</td>
            <td><?= translate($order->status->value); ?></td>
            <td><?php if (empty($order->User->html())): ?>
                    Commande Internet
                <?php else: ?>
                    <?= $order->User->target->name->html(); ?>
                <?php endif; ?></td>
            <td><?= $order->created_date->html(); ?></td>
            <td><?= $order->delivered_date->html(); ?></td>
            <td><a href="display_details_order.php?order_id=<?= $order->getId(); ?>">Voir</a></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="9">Aucune commande trouvée</td>
    </tr>
<?php endif; ?>