<?php

namespace Tests\Unit;

use App\Company;
use App\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEmployeeFillableFields()
    {
        $row = Employee::create(['name' => 'Peter']);
        $this->assertEquals('Peter', $row->name);
    }

    public function testEmployeeBelongsToManyCompanies()
    {
        $row = factory(Employee::class, 1)->create()->first();
        $row->companies()->save(Company::create(['name' => 'ABC']));
        $this->assertEquals(1, $row->companies()->count());
    }
}
