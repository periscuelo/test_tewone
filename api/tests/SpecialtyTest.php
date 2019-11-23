<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class SpecialtyTest extends TestCase
{
    /**
     * /specialties [GET]
     */
    public function testShouldReturnAllSpecialties() {
        $this->get('/specialties');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'id',
                'specialty',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }
}
