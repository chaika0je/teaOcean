<?php

class CatalogController
{
    public function actionCatalog()
    {
        $products = Catalog::getAllProducts();

        require_once ROOT . '/views/catalog/main.php';
        return true;
    }

    public function actionSection($section)
    {
        $categories = Catalog::getCategories($section);
        $products = Catalog::getProductsBySection($section);

        require_once ROOT . '/views/catalog/first/main.php';
        return true;
    }

    public function actionCategory($section, $categoryId)
    {
        //echo $categoryId;

        $categories = Catalog::getCategories($section);
        $subcategories = Catalog::getSubcategories($section, $categoryId);

        require_once(ROOT . '/views/catalog/second/main.php');
        return true;
    }

    public function actionProduct($id)
    {
        if (intval($id))
        {
            $item = Catalog::getProductById($id);
            $category = Catalog::getCategoryById($item['in-category']);
            // Список последних товаров
            $products = Catalog::getRandomProducts(3);
            require_once ROOT.'/views/product/main.php';
        }
        else
        {
            require_once ROOT.'/views/404/404_page.php';
        }
        return true;
    }
}