<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Role;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['code' => 0,'name' => 'SuperAdmin'],
            ['code' => 1,'name' => 'Admin'],
            ['code' => 2,'name' => 'Siswa'],
            ['code' => 3,'name' => 'Teacher'],
            ['code' => 4,'name' => 'Ppdb']
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
