<?php
namespace Tests\Library;

use App\Booking;
use App\Table;
use App\User;
use Tests\TestCase;

class TestFactory extends TestCase
{
    public $table, $tables;
    public $user, $users;
    public $booking, $bookings;

    public function createUser($total=1, $attr=[])
    {
        if ($total > 1) {
            for ($i=0; $i < $total; $i++) {
                $this->users[] = factory(User::class)->create($attr);
            }

            $this->createInstance('users', $this->users);
        } else {
            $this->user = factory(User::class)->create($attr);
            $this->createInstance('user', $this->user);
        }

        return $this;
    }

    public function createTable($total=1, $attr=[])
    {
        if ($total > 1) {
            for ($i=0; $i < $total; $i++) {
                $this->tables[] = factory(Table::class)->create($attr);
            }

            $this->createInstance('tables', $this->tables);
        } else {
            $this->table = factory(Table::class)->create($attr);
            $this->createInstance('table', $this->table);
        }

        return $this;
    }
    public function createBooking($total=1, $attr=[])
    {
        if ($total > 1) {
            for ($i=0; $i < $total; $i++) {
                $this->bookings[] = factory(Booking::class)->create($attr);
            }

            $this->createInstance('tables', $this->bookings);
        } else {
            $this->booking = factory(Booking::class)->create($attr);
            $this->createInstance('table', $this->booking);
        }

        return $this;
    }

    public function createInstance($key, $instance)
    {
        $this->instances[$key] = $instance;
    }

    public function signIn($system)
    {
        $system->actingAs($this->user);

        return $this;
    }
}
