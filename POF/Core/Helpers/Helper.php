<?php

namespace Core\Helpers;

use Core\Model\User;

class Helper
{
    /**
     * TO REDIRECT PAGE
     * 
     * @param string $path
     * @return void
     */
    public static function redirect($path)
    {
        header("location: $path");
    }

    /**
     * TO CHECK PERMISSION
     * 
     * @param array $permissions_set
     * @return bool
     */
    public static function check_permission(array $permissions_set): bool
    {
        $display = true;

        if (!isset($_SESSION['user'])) {
            return false;
        }

        $user = new User;
        $assigned_permissions = $user->get_permission();
        foreach ($permissions_set as $permission) {
            if (!in_array($permission, $assigned_permissions)) {
                // if any of the permissions_set are not assigned to the user , redirect to the dashboard
                return false;
            }
        }
        return $display;
    }
}
