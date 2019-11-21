<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class MedicalTest extends TestCase
{
    /**
     * /medical [POST]
     */
    public function testShouldReturnInsertedMedicalData() {
        $this->artisan('migrate:fresh --seed');

        $data = [
            [
                'name' => 'Fulano da Silva',
                'crm' => 123456,
                'phone' => '11988589957',
                'medicals_specialties' => [1, 2]
            ],
            [
                'name' => 'Fulano da Silva S',
                'crm' => 125356,
                'phone' => '11999588557',
                'medicals_specialties' => [3, 4]
            ]
        ];
        $this->post('/medical', $data[0]);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'name',
            'crm',
            'phone',
            'updated_at',
            'created_at',
            'id'
        ]);

        $this->post('/medical', $data[1]);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'name',
            'crm',
            'phone',
            'updated_at',
            'created_at',
            'id'
        ]);
    }

    /**
     * /medical [POST]
     */
    public function testShouldNotReturnInsertedMedicalData() {
        $data = [
            [
                'name' => 'Fulano da Silva',
                'crm' => 123456,
                'phone' => '11988589957',
                'medicals_specialties' => [1]
            ],
            [
                'name' => 'Fulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da SilvaFulano da SilvaFulano da Silva',
                'crm' => 333123,
                'phone' => '11999588557',
                'medicals_specialties' => [5, 6]
            ]
        ];

        $this->post('/medical', $data[0]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'crm',
            'medicals_specialties'
        ]);

        $this->post('/medical', $data[1]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'name'
        ]);
    }

    /**
     * /medicals [GET]
     */
    public function testShouldReturnAllMedicals() {
        $this->get('/medicals');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'crm',
                'phone',
                'created_at',
                'updated_at',
                'deleted_at',
                'medicals_specialties' => [
                    '*' => [
                        'id',
                        'specialty',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'pivot' => [
                            'id_medical',
                            'id_specialty',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * medicals/search [GET]
     */
    public function testShouldReturnMedicalSearched() {
        $this->get('medicals/search?search=fulano');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'crm',
                'phone',
                'created_at',
                'updated_at',
                'deleted_at',
                'medicals_specialties' => [
                    '*' => [
                        'id',
                        'specialty',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'pivot' => [
                            'id_medical',
                            'id_specialty',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * medicals/search [GET]
     */
    public function testShouldNotReturnMedicalSearched() {
        $this->get('medicals/search?search=zzz');
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
                'status',
                'info'
        ]);
    }

    /**
     * /medical/{id}/edit [GET]
     */
    public function testShouldReturnMedicalData() {
        $this->get('/medical/2/edit');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'id',
            'name',
            'crm',
            'phone',
            'created_at',
            'updated_at',
            'deleted_at',
            'medicals_specialties' => [
                '*' => [
                    'id',
                    'specialty',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'pivot' => [
                        'id_medical',
                        'id_specialty',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]
        ]);
    }

    /**
     * /medical/{id}/edit [GET]
     */
    public function testShouldNotReturnMedicalData() {
        $this->get('/medical/99/edit');
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'status',
            'info'
        ]);
    }

    /**
     * /medical/{id} [PUT]
     */
    public function testShouldReturnUpdatedMedicalData() {
        $data = [
            'name' => 'Fulano da Silva Sauro',
            'phone' => '1124556587',
            'medicals_specialties' => [1, 5]
        ];
        $this->put('/medical/2', $data);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'id',
            'name',
            'crm',
            'phone',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }

    /**
     * /medical/{id} [PUT]
     */
    public function testShouldNotReturnUpdatedMedicalData() {
        $data = [
            ['phone' => '112455658'],
            ['medicals_specialties' => [1]],
            ['crm' =>'123456'],
            ['crm' =>'aaaa'],
            ['name' => 'Fulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da Silva SFulano da SilvaFulano da SilvaFulano da Silva'],
            ['phone' => 1124556587]
        ];

        $this->put('/medical/2', $data[0]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'phone'
        ]);

        $this->put('/medical/2', $data[1]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'medicals_specialties'
        ]);

        $this->put('/medical/2', $data[2]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'crm'
        ]);

        $this->put('/medical/2', $data[3]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'crm'
        ]);

        $this->put('/medical/2', $data[4]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'name'
        ]);

        $this->put('/medical/2', $data[5]);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'phone'
        ]);
    }

    /**
     * /medical/{id} [DELETE]
     */
    public function testShouldReturnStatus204() {
        $this->delete('/medical/1');
        $this->seeStatusCode(204);
    }

    /**
     * /medical/{id} [DELETE]
     */
    public function testShouldNotReturnStatus204() {
        $this->delete('/medical/1');
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'status',
            'info'
        ]);
    }
}
