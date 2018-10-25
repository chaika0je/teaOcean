<?php

class Catalog
{

    public static function getAllCategories()
    {
        $db = Db::getConnection();

        $categories = $db->query("SELECT * FROM `categories`");
        $categories = $categories->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    public static function getAllSubcategories()
    {
        $db = Db::getConnection();

        $subcategories = $db->query("SELECT * FROM `subcategories`");
        $subcategories = $subcategories->fetchAll(PDO::FETCH_ASSOC);

        return $subcategories;
    }

    public static function getAllProducts()
    {
        $db = Db::getConnection();

        $products = $db->query("SELECT * FROM `products`");
        $products = $products->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public static function getCategories($section)
    {
        $db = Db::getConnection();

        $categories = $db->query("SELECT * FROM `categories` WHERE `section` = '$section'");
        $categories = $categories->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    public static function getSubcategories($section, $categoryId)
    {
        $db = Db::getConnection();

        $subcategories = $db->query("SELECT * FROM `subcategories` WHERE `in-category` = $categoryId AND `in-section` = '$section' ORDER BY `id`");
        $subcategories = $subcategories->fetchAll(PDO::FETCH_ASSOC);

        return $subcategories;
    }

    public static function getProducts($subcategoryId)
    {
        $db = Db::getConnection();

        $products = $db->query("SELECT * FROM `products` WHERE `in-sub-category` = $subcategoryId");
        $products = $products->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public static function getProductsBySection($section)
    {
        $db = Db::getConnection();

        $product = $db->query("SELECT * FROM `products` WHERE `in-section` = '$section'");
        $product = $product->fetchAll(PDO::FETCH_ASSOC);

        return $product;
    }
    public static function getProductById($id)
    {
        $db = Db::getConnection();

        $product = $db->query("SELECT * FROM `products` WHERE `id` = $id");
        $product = $product->fetch(PDO::FETCH_ASSOC);

        return $product;
    }

    public static function getCategoryById($id)
    {
        $db = Db::getConnection();

        $category = $db->query("SELECT * FROM `categories` WHERE `id`= $id");
        $category = $category->fetch(PDO::FETCH_ASSOC);

        return $category;
    }

    public static function getRandomProducts($amount)
    {
        $db = Db::getConnection();

        $product = $db->query("SELECT * FROM `products` WHERE `picType` = '50' ORDER BY rand() LIMIT $amount");
        $product = $product->fetchAll(PDO::FETCH_ASSOC);

        return $product;
    }
}