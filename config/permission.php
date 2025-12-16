<?php

return [

       'models' => [

              /*
               * When using the "HasPermissions" trait from this package, we need to know which
               * Eloquent model should be used to retrieve your permissions. Of course, it
               * is often just the "Spatie\Permission\Models\Permission" class but you
               * may use whatever you like.
               *
               * The model you want to use as a Permission model must implement the
               * `Spatie\Permission\Contracts\Permission` contract.
               */

              'permission' => Spatie\Permission\Models\Permission::class,

              /*
               * When using the "HasRoles" trait from this package, we need to know which
               * Eloquent model should be used to retrieve your roles. Of course, it
               * is often just the "Spatie\Permission\Models\Role" class but you
               * may use whatever you like.
               *
               * The model you want to use as a Role model must implement the
               * `Spatie\Permission\Contracts\Role` contract.
               */

              'role' => Spatie\Permission\Models\Role::class,

       ],

       'table_names' => [

              /*
               * When using the "HasRoles" trait from this package, we need to know which
               * table should be used to retrieve your roles. We have chosen a basic
               * default value but you may easily change it to any table you like.
               */

              'roles' => 'roles',

              /*
               * When using the "HasPermissions" trait from this package, we need to know which
               * table should be used to retrieve your permissions. We have chosen a basic
               * default value but you may easily change it to any table you like.
               */

              'permissions' => 'permissions',

              /*
               * When using the "HasPermissions" trait from this package, we need to know which
               * table should be used to retrieve your model permissions. We have chosen a
               * basic default value but you may easily change it to any table you like.
               */

              'model_has_permissions' => 'model_has_permissions',

              /*
               * When using the "HasRoles" trait from this package, we need to know which
               * table should be used to retrieve your model roles. We have chosen a
               * basic default value but you may easily change it to any table you like.
               */

              'model_has_roles' => 'model_has_roles',

              /*
               * When using the "HasRoles" trait from this package, we need to know which
               * table should be used to retrieve your role permissions. We have chosen a
               * basic default value but you may easily change it to any table you like.
               */

              'role_has_permissions' => 'role_has_permissions',
       ],

       'column_names' => [
              /*
               * Change this if you want to name the related model primary key other than
               * `model_id`.
               *
               * For example, this would be nice if your primary keys are all UUIDs. In
               * that case, name this `model_uuid`.
               */

              'model_morph_key' => 'model_id',

              /*
               * Change this if you want to name the related team primary key other than
               * `team_id`.
               *
               * For example, this would be nice if your primary keys are all UUIDs. In
               * that case, name this `team_uuid`.
               */

              'team_foreign_key' => 'team_id',
       ],

       /*
        * When set to true, the required permission check method will be registered
        * on the Gate for the "super-admin" role, allowing you to bypass specific
        * permission checks.
        */
       'register_permission_check_method' => true,

       /*
        * When set to true, the health check will be done in the background.
        * This is useful when you have a large number of permissions.
        */
       'teams' => false,

       /*
        * When set to true, the class names of the permission and role models will
        * be used in the exception messages.
        */
       'display_permission_in_exception' => false,

       'display_role_in_exception' => false,

       'enable_wildcard_permission' => false,

       'cache' => [

              /*
               * By default all permissions are cached for 24 hours to speed up performance.
               * When permissions or roles are updated the cache is flushed automatically.
               */

              'expiration_time' => \DateInterval::createFromDateString('24 hours'),

              /*
               * The key to use for the cache.
               */

              'key' => 'spatie.permission.cache',

              /*
               * The store to use for the cache.
               */

              'store' => 'default',
       ],
];
