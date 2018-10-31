<?php

namespace Tests\Feature;

use App\Employee;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function testUnauthorizedUserCannotCreate()
    {
        $this->json('POST', '/api/employees', ['name' => 'John Employee'])
            ->assertStatus(401);
    }

    public function testCannotCreateInvalid()
    {
        $this->json('POST', '/api/employees', ['name' => ''], $this->getAuth())
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
        $response = $this->json('POST', '/api/employees', ['name' => 'John Employee'], $this->getAuth())
            ->assertStatus(201);
        $this->assertEquals(1, Employee::count());
        return $response;
    }

    private function _canRead($row)
    {
        $this->json('GET', '/api/employees/'.$row->id)
            ->assertStatus(200)
            ->assertJson(['data' => [
                'id' => $row->id,
                'name' => $row->name
            ]]);
    }

    private function _canDelete($row)
    {
        $this->json('DELETE', '/api/employees/'.$row->id, [], $this->getAuth())
            ->assertStatus(204);
        $this->assertEquals(0, Employee::count());
    }

    public function testCanUpdate()
    {
        $company = factory(Employee::class, 1)->create(['name' => 'John Old'])->first();
        $this->json('PUT', '/api/employees/'.$company->id, ['name' => 'John Updated'], $this->getAuth())
            ->assertStatus(200);
        $updated = Employee::find($company->id);
        $this->assertEquals('John Updated', $updated->name);
    }
}
