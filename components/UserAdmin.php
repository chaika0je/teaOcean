<?php
abstract class UserAdmin
{

    function checkAdmin()
    {
        if($_SESSION['logged'] = true and $_SESSION['admin'] = true)
            if(isset($_SESSION['name']) and isset($_SESSION['id']))
                return true;
            else
                return false;
        else
            return false;
    }

}