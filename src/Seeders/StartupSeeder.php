<?php
namespace AdiFaidz\Base\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StartupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        $config = config('base_seeder.role_structure');
        $mapPermission = collect(config('base_seeder.permissions_map'));

        foreach ($config as $key => $modules) {
            // Create a new role
            $role = config('base.roles.model')::create([
                'name' => $key,
                'display_name' => ucfirst($key),
                'description' => ucfirst($key)
            ]);

            $this->command->info('Creating Role '. strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {
                $permissions = explode(',', $value);

                foreach ($permissions as $p => $perm) {
                    $permissionValue = $mapPermission->get($perm);

                    $permission = config('base.permissions.model')::firstOrCreate([
                        'name' => $module . '-' . $permissionValue,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ]);

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);

                    if (!$role->hasPermission($permission->name)) {
                        $role->attachPermission($permission);
                    } else {
                        $this->command->info($key . ': ' . $p . ' ' . $permissionValue . ' already exist');
                    }
                }
            }

            $this->command->info("Creating '{$key}' user");
            // Create default user for each role
            $user = config('base.users.model')::create([
                'name' => ucfirst($key),
                'email' => $key.'@app.com',
                'password' => bcrypt('password'),
                'remember_token' => str_random(10),
            ]);
            $user->attachRole($role);

            $this->command->info("Creating '{$key}' user profile");
            $userprofile = config('base.userprofiles.model')::create([
              'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        config('base.users.model')::truncate();
        config('base.roles.model')::truncate();
        config('base.permissions.model')::truncate();
        config('base.userprofiles.model')::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
