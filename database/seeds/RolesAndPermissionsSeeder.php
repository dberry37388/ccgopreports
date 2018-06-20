<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
    
        $boardRole = Role::create(['name' => 'board']);
        $commissionerRole = Role::create(['name' => 'commissioner']);
        $countyWideRole = Role::create(['name' => 'countywide']);
    
        $role = Role::create(['name' => 'admin']);
    }
}
