<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class HierarchyHelper
{
    /**
     * Get the hierarchy of a given user.
     *
     * @param int $userId
     * @return array
     */
    public static function getHierarchy($userId)
    {
        // This is a placeholder for the actual logic to retrieve the hierarchy.
        // You would typically query your database or use a service to get this data.
        return [
            'user_id' => $userId,
            'hierarchy' => 'Example Hierarchy Data',
        ];
    }



    function hasAccess($requiredRole)
    {
        $rolesHierarchy = [
            'user' => 1,
            'associado' => 2,
            'moderador' => 3,
            'admin' => 4,
        ];

        $userRole = Auth::user()->role ?? 'user';

        return $rolesHierarchy[$userRole] >= $rolesHierarchy[$requiredRole];
    }
}
