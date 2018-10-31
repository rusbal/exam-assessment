<?php

namespace Tests\Unit;

use App\Company;
use App\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCompanyFillableFields()
    {
        $row = Company::create(['name' => 'ABC']);
        $this->assertEquals('ABC', $row->name);
    }

    public function testCompanyBelongsToManyEmployees()
    {
        $company = factory(Company::class, 1)->create()->first();
        $company->employees()->save(Employee::create(['name' => 'Peter']));
        $this->assertEquals(1, $company->employees()->count());
    }
}
