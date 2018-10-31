<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = factory(App\Employee::class, 200)->create();

        foreach ($employees as $employee) {
            $employee->companies()->save(App\Company::inRandomOrder()->first());
        }
    }
}
