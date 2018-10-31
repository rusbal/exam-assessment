<?php

namespace Tests\Feature;

use App\Export;
use Tests\TestCase;

class ExportTest extends TestCase
{
    public function testUnauthorizedUserCannotExport()
    {
        $this->json('POST', '/api/exports', [])
            ->assertStatus(401);
    }

    public function testCanCreateReadAndDelete()
    {
        $response = $this->_canCreate();
//        $row = $response->getData();
//        $this->_canRead($row);
//        $this->_canDelete($row);
    }

    private function _canCreate()
    {
        $response = $this->json('POST', '/api/exports', [], $this->getAuth())
            ->assertStatus(201);

        $res_array = json_decode($response->content(), true);
        $this->assertArrayHasKey('csv_uri', $res_array);

        return $response;
    }
}
