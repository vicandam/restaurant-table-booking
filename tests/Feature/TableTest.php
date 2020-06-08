<?php

namespace Tests\Feature;

use App\Table;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Library\TestFactory;
use Tests\TestCase;

class TableTest extends TestCase
{
    use RefreshDatabase;

    protected $factory;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->factory = new TestFactory();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_create_table()
    {
        $this->factory
            ->createUser()
            ->signIn($this);

        $attributes = [
            'capacity' => 6,
            'status' => 'Available'
        ];

        $response = $this->post('api/table', $attributes);

        $data = $response->getOriginalContent()['table'];

        $this->assertEquals($data['status'], $attributes['status']);

        $response->assertStatus(200);
    }

    public function test_retrieved_table_list()
    {
        $this->factory
            ->createTable();

        $attributes = [
            'limit' => 5,
            'page' => 1,
            'sort' => 'desc'
        ];

        $response = $this->get('api/table?' . http_build_query($attributes));

        $data = $response->getOriginalContent()['table'];

        $this->assertEquals('Available', $data[0]->status);

        $response->assertStatus(200);
    }

    public function test_update_table()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createTable();

        $attributes = [
            'capacity' => 6,
            'status' => 'Occupied'
        ];

        $response = $this->patch('api/table/' . $this->factory->table->id, $attributes);

        $data = $response->getOriginalContent()['table'];

        $this->assertEquals($data['status'], $attributes['status']);

        $response->assertStatus(200);
    }

    public function test_delete_table()
    {
        $this->factory
            ->createUser()
            ->createTable();

        $response = $this->delete('api/table/' . $this->factory->table->id);

        $result = $response->getOriginalContent()['table'];

        $this->assertEquals(true, $result);

        $response->assertStatus(200);
    }
}
