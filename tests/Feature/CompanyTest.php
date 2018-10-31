<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function testUnauthorizedUserCannotCreate()
    {
        $this->json('POST', '/api/companies', ['name' => 'ABC Company'])
            ->assertStatus(401);
    }

    public function testCannotCreateInvalid()
    {
        $this->json('POST', '/api/companies', ['name' => ''], $this->getAuth())
            ->assertStatus(422);
    }

    public function testCanCreateReadAndDelete()
    {
        $response = $this->_canCreate();
        $row = $response->getData();
        $this->_canRead($row);
        $this->_canDelete($row);
    }

    private function _canCreate()
    {
        $response = $this->json('POST', '/api/companies', ['name' => 'ABC Company'], $this->getAuth())
            ->assertStatus(201);
        $this->assertEquals(1, Company::count());
        return $response;
    }

    private function _canRead($row)
    {
        $employees = factory(Employee::class, 2)->create();
        Company::find($row->id)->employees()->attach($employees);

        $this->json('GET', '/api/companies/'.$row->id)
            ->assertStatus(200)
            ->assertJson(['data' => [
                'id' => $row->id,
                'name' => $row->name,
                'created_date' => explode(' ', $row->created_at)[0],
                'employee_count' => 2
            ]]);
    }

    private function _canDelete($row)
    {
        $this->json('DELETE', '/api/companies/'.$row->id, [], $this->getAuth())
            ->assertStatus(204);
        $this->assertEquals(0, Company::count());
    }

    public function testCanUpdate()
    {
        $company = factory(Company::class, 1)->create(['name' => 'ABC Old'])->first();
        $this->json('PUT', '/api/companies/'.$company->id, ['name' => 'ABC Updated'], $this->getAuth())
            ->assertStatus(200);
        $updated = Company::find($company->id);
        $this->assertEquals('ABC Updated', $updated->name);
    }
}
