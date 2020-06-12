<?php

namespace Tests\Feature;

use App\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Library\TestFactory;
use Tests\TestCase;

class BookingTest extends TestCase
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

    public function test_create_booking()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createBooking();

        $attributes = [
            'table' => 1,
            'date' => '07/01/2020',
            'time' => '8:15 PM'
        ];

        $response = $this->post('api/booking', $attributes);

        $data = $response->getOriginalContent()['booking'];

        $this->assertEquals($data->time, $attributes['time']);
        $response->assertOk();
        $response->assertStatus(200);
    }

    public function test_retrieved_booking_list()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createTable()
            ->createBooking();

        $attributes = [
            'limit' => 5,
            'page' => 1,
            'sort' => 'desc'
        ];

        $response = $this->get('api/booking?' . http_build_query($attributes));

        $this->assertEquals(true, Booking::count());

        $response->assertStatus(200);
    }
    public function test_retrieved_booking_confirmed()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createTable()
            ->createBooking(
                1,
                [
                    'status' => 'declined'
                ]
            );

        $attributes = [
            'limit' => 5,
            'page' => 1,
            'sort' => 'desc'
        ];

        $response = $this->get('api/confirmed-booking?' . http_build_query($attributes));

        $this->assertEquals($this->factory->booking->status, 'declined');

        $response->assertStatus(200);
    }
    public function test_retrieved_booking_pending()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createTable()
            ->createBooking(
                1,
                [
                    'status' => 'pending'
                ]
            );

        $attributes = [
            'limit' => 5,
            'page' => 1,
            'sort' => 'desc'
        ];

        $response = $this->get('api/pending-booking?' . http_build_query($attributes));

        $this->assertEquals($this->factory->booking->status, 'pending');

        $response->assertStatus(200);
    }

    public function test_update_booking()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createTable()
            ->createBooking();

        $attributes = [
            'tableId' => 1,
            'status'  => 'accepted'
        ];

        $response = $this->patch('api/booking/' . $this->factory->booking->id, $attributes);

        $data = $response->getOriginalContent()['booking'];

        $this->assertEquals($data, $attributes['tableId']);

        $response->assertStatus(200);
    }
}
