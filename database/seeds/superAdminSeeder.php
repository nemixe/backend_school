<?php

use Illuminate\Database\Seeder;

use App\Employee;
use App\Role;

class superAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Employee;
        $user->full_name = 'ami jayas';
        $user->nip = '173140914111011';
        $user->password = app('hash')->make('7470');
        $user->save();
        $role = Role::where('name', 'Teacher')->firstOrFail();
        $user->roles()->attach($role);
    }
}
