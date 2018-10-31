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
            $companies = App\Company::inRandomOrder()->limit(rand(1, 7))->get();
            foreach ($companies as $company) {
                $employee->companies()->attach($company);
            }
        }
    }
}
