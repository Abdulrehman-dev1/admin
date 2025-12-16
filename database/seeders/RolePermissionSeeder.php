<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
       /**
        * Run the database seeds.
        */
       public function run(): void
       {
              // Reset cached roles and permissions
              app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

              // Create default permissions
              $permissions = [
                     'role-list',
                     'role-create',
                     'role-edit',
                     'role-delete',
                     'permission-list',
                     'permission-create',
                     'permission-edit',
                     'permission-delete',
                     'user-list',
                     'user-create',
                     'user-edit',
                     'user-delete',
                     'dashboard-list',
                     'scraper-list',
                     'olx-scraper-list',
                     'auction-list',
                     'auction-verification-list',
                     'slider-list',
                     'category-list',
                     'referral-list',
                     'buy-now-inquiry-list',
                     'utm-user-list',
                     'seo-list',
                     'wallet-list',
                     'transaction-list',
                     'promotion-list',
                     'individual-verification-list',
                     'corporate-verification-list',
                     'payment-request-list',
                     'payment-verification-list',
                     'order-list',
                     'blog-list',
                     'identity-list',
              ];

              foreach ($permissions as $permission) {
                     Permission::firstOrCreate(['name' => $permission]);
              }

              // Create roles and assign created permissions
              $adminRole = Role::firstOrCreate(['name' => 'admin']);
              $adminRole->syncPermissions(Permission::all());

              $userRole = Role::firstOrCreate(['name' => 'user']);

              // Fetch all users and assign roles based on the 'role' column
              $users = User::all();

              foreach ($users as $user) {
                     // Check the current 'role' column
                     if ($user->role === 'admin') {
                            $user->assignRole($adminRole);
                     } elseif ($user->role === 'user') {
                            $user->assignRole($userRole);
                     } else {
                            if (!$user->hasAnyRole(['admin', 'user'])) {
                                   $user->assignRole($userRole);
                            }
                     }
              }
       }
}
