<?php

use Illuminate\Database\Seeder;

use App\Employee;
use App\Student;

class studentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::first();

        Student::create([
            'employee_id' => $employee->id,
            'full_name' => 'murid 1',
            'nis' => '173140913111001',
            'password' => app('hash')->make('7470')
        ]);
    }
}
