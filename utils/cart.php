<?php

/**
 * cart.php
 * Fonctions utilitaires pour la gestion du panier
 */

//Mise en place d'un namespace
namespace Utils;

use Product;

class Cart
{
    /**
     * Supprimer les valeurs nulles d'un tableau
     * @param array $input - le tableau
     * @return array - le tableau filtre
     */
    static function array_filter_recursive($tab)
    {
        foreach ($tab as &$value) {
            if (is_array($value)) {
                $value = Cart::array_filter_recursive($value);
            }
        }
        return array_filter($tab);
    }

    /**
     * Retourner le prix d'un produit en fonction de sa taille (pour menu et boisson +0.50€)
     * @param int $id_product - l'ID du produit
     * @param string $size - la taille du produit
     * @return float - le prix
     */
    static function getPriceForCart($id_product, $size)
    {
        $price = 0;
        $product = new Product($id_product);
        $priceProduct = $product->price->value;
        if ($size === '50cl' || $size === 'maxi') {
            $price = $priceProduct + 0.50;
        } else {
            $price = $priceProduct;
        }
        return $price;
    }

    /**
     * Retourner l'ID du produit qui a une quantité
     * @param array $data - données d'une commande
     */
    static function getProductByQuantity($data)
    {
        // Parcourir les quantités pour trouver l'ID avec une quantité définie
        foreach ($data['quantity'] as $product_id => $quantity) {
            if (!empty($quantity)) {
                return $product_id;
            }
        }
    }

    /**
     * Retourner le nom du produit pour le panier
     * @param int $id du produit
     * @return string - le nom du produit
     */
    static function getNameProductForCart($id)
    {
        $product = new Product($id);
        return $product->name->value;
    }
}
