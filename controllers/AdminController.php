<?php
class AdminController extends UserAdmin
{

    public function actionLogin()
    {
        if(self::checkAdmin()) {
            header("Location: /panel");

            if (isset($_POST['submit'])) {
                $login = FormHandler::prepareInput($_POST['login']);
                $password = FormHandler::preparePassword($_POST['password']);

                Admin::login($login, $password);
            }

            require_once ROOT . '/views/admin/login/main.php';
        }
        return true;
    }

    public function actionIndex()
    {
        if(!self::checkAdmin())
            header("Location: /");
        else
            require_once ROOT . '/views/admin/index/main.php';

        return true;
    }

    public function actionViewCategory()
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else
        {
            if (isset($_POST['addCategory'])) {
                if (Admin::addCategory($_POST['name'], $_POST['description']))
                    echo "<script>alert('Категория добвалена')</script>";
                else
                    die("Ошибка добавления категории");
            }

            require_once ROOT . '/views/admin/categories/main.php';
        }
        return true;
    }

    public function actionViewSubcategory()
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else {
            $categories = Catalog::getAllCats();

            if (isset($_POST['addSubcategory'])) {
                if (Admin::addSubcategory($_POST['name'], $_POST['description'], $_POST['categories']))
                    echo "<script>alert('Подкатегория добвалена')</script>";
                else
                    die("Ошибка добавления подкатегории");
            }

            require_once ROOT . '/views/admin/subcategories/main.php';
        }
        return true;
    }

    public function actionViewProducts()
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else {
            $categories = Catalog::getAllCategories();
            $subcategories = Catalog::getAllSubcategories();


            if (isset($_POST['addProduct'])) {
                if (Admin::addProduct(
                    $_POST['name'],
                    $_POST['description'],
                    $_POST['price'],
                    $_POST['categories'],
                    $_POST['subcategories'],
                    $_POST['type'],
                    $_POST['art'],
                    $_POST['GR'],
                    $_POST['TP'],
                    $_POST['TM'],
                    $_POST['typePic'],
                    $_POST['in-section'])
                ) {
                    echo "<script>alert('Товар добвален')</script>";
                } else {
                    die("Ошибка добавления товара");
                }
            }
            if (isset($_POST['delPR'])) {
                Admin::delProduct($_POST['productID']);
            }


            require_once ROOT . '/views/admin/products/main.php';
            return true;
        }
    }
    
    public function actionSendMail()
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else {
            if (isset($_POST['sendToAll'])) {
                Admin::sendMailToAllUsers($_POST['toAllMessage']);
            }

            if (isset($_POST['sendToPerson'])) {
                Admin::sendMailToSomeUser($_POST['personMessage'], $_POST['sendToMail']);
            }

            require_once ROOT . '/views/admin/mail/main.php';
        }
        return true;
    }

    public function actionEditProduct($id)
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else {
            $product = Catalog::getProductById($id);

            if (isset($_POST['UpdateProduct'])) {
                Admin::updateProduct($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['art'], $_POST['GR'], $_POST['TP'], $_POST['TM'], $_POST['typePic']);
                header("Location: /panel/product");
            }

            require_once ROOT . '/views/admin/edit/main.php';
        }
        return true;
    }

    public function actionViewOrders()
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else {
            $orders = Admin::getAllOrders();

            require_once ROOT . '/views/admin/orders/main.php';
        }
        return true;
    }

    public function actionViewSettings()
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else
        {
            if (isset($_POST['change'])) {
                unset($_POST['change']);
                Admin::updatePage($_POST);
            }

            require_once ROOT . '/views/admin/settings/main.php';
        }
        return true;
    }

    public function actionEditOrder($orderNumber)
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else {
            $order = Admin::getOrderByID($orderNumber);
            $user = User::getUserById($order['customer']);

            if (isset($_POST['change'])) {
                unset($_POST['change']);
                Admin::updateOrder($_POST);
                header("Location: /panel/orders");
            }

            require_once ROOT . '/views/admin/orders/edit/main.php';
        }
        return true;
    }

    public function actionViewCallbacks()
    {
        if(!self::checkAdmin()) {
            header("Location: /");
        }
        else {
            $callbacks = Admin::loadCallbacks();
            require_once ROOT . '/views/admin/callbacks/main.php';
        }
        return true;
    }
}