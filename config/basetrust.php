<?php

/**
 * This file is part of AdiFaidz\Base wrapper of Base,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Base
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Base User Model
    |--------------------------------------------------------------------------
    |
    | This is the User model used by Base to create correct relations.  Update
    | the user if it is in a different namespace.
    |
    */
    'user' => 'AdiFaidz\Base\BaseUser',

    /*
    |--------------------------------------------------------------------------
    | Base Users Table
    |--------------------------------------------------------------------------
    |
    | This is the users table used by Base to save users to the database.
    |
    */
    'users_table' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Base Role Model
    |--------------------------------------------------------------------------
    |
    | This is the Role model used by Base to create correct relations.  Update
    | the role if it is in a different namespace.
    |
    */
    'role' => 'AdiFaidz\Base\BaseRole',

    /*
    |--------------------------------------------------------------------------
    | Base Roles Table
    |--------------------------------------------------------------------------
    |
    | This is the roles table used by Base to save roles to the database.
    |
    */
    'roles_table' => 'roles',

    /*
    |--------------------------------------------------------------------------
    | Base Permission Model
    |--------------------------------------------------------------------------
    |
    | This is the Permission model used by Base to create correct relations.
    | Update the permission if it is in a different namespace.
    |
    */
    'permission' => 'AdiFaidz\Base\BasePermission',

    /*
    |--------------------------------------------------------------------------
    | Base Permissions Table
    |--------------------------------------------------------------------------
    |
    | This is the permissions table used by Base to save permissions to the
    | database.
    |
    */
    'permissions_table' => 'permissions',

    /*
    |--------------------------------------------------------------------------
    | Base User Profile Model
    |--------------------------------------------------------------------------
    |
    | This is the User Profile model used by Base to create correct relations.
    | Update the user profile if it is in a different namespace.
    |
    */
    'userprofile' => 'AdiFaidz\Base\BaseUserprofile',

    /*
    |--------------------------------------------------------------------------
    | Base User Profiles Table
    |--------------------------------------------------------------------------
    |
    | This is the user profiles table used by Base to save user profiles to the
    | database.
    |
    */
    'userprofiles_table' => 'userprofiles',

    /*
    |--------------------------------------------------------------------------
    | Base permission_role Table
    |--------------------------------------------------------------------------
    |
    | This is the permission_role table used by Base to save relationship
    | between permissions and roles to the database.
    |
    */
    'permission_role_table' => 'permission_role',

    /*
    |--------------------------------------------------------------------------
    | Base role_user Table
    |--------------------------------------------------------------------------
    |
    | This is the role_user table used by Base to save assigned roles to the
    | database.
    |
    */
    'role_user_table' => 'role_user',

    /*
    |--------------------------------------------------------------------------
    | User Foreign key on Base's role_user Table (Pivot)
    |--------------------------------------------------------------------------
    */
    'user_foreign_key' => 'user_id',

    /*
    |--------------------------------------------------------------------------
    | Role Foreign key on Base's role_user and permission_role Tables (Pivot)
    |--------------------------------------------------------------------------
    */
    'role_foreign_key' => 'role_id',

    /*
    |--------------------------------------------------------------------------
    | Permission Foreign key on Base's permission_role Table (Pivot)
    |--------------------------------------------------------------------------
    */
    'permission_foreign_key' => 'permission_id',

    /*
    |--------------------------------------------------------------------------
    | Method to be called in the middleware return case
    | Available: abort|redirect
    |--------------------------------------------------------------------------
    */
    'middleware_handling' => 'abort',

    /*
    |--------------------------------------------------------------------------
    | Parameter passed to the middleware_handling method
    |--------------------------------------------------------------------------
    */
    'middleware_params' => '403',
];
