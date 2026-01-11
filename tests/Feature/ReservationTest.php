<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'customer']);
        $this->actingAs($this->user);
    }

    /**
     * Test reservation creation with correct status and code generation.
     */
    public function test_reservation_creation_with_correct_status_and_code()
    {
        $this->withoutMiddleware();

        $data = [
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '19:00',
            'number_of_people' => 4,
            'service_type' => 'Gala Dinner',
            'special_requests' => 'No nuts please'
        ];

        $response = $this->post(route('customer.reservation.store'), $data);

        $response->assertRedirect(route('customer.reservation.index'));
        $this->assertDatabaseHas('reservations', [
            'user_id' => $this->user->id,
            'date' => $data['reservation_date'],
            'time' => $data['reservation_time'],
            'guests' => $data['number_of_people'],
            'service_type' => $data['service_type'],
            'notes' => $data['special_requests'],
            'status' => 'pending',
            'total_price' => 200000 // 4 * 50000
        ]);

        // Check that code was generated
        $reservation = Reservation::where('user_id', $this->user->id)->first();
        $this->assertNotNull($reservation->code);
        $this->assertStringStartsWith('RES-', $reservation->code);
    }

    /**
     * Test availability check prevents double booking.
     */
    public function test_availability_check_prevents_double_booking()
    {
        $this->withoutMiddleware();

        // Create existing reservation with 'lunas' status
        Reservation::create([
            'user_id' => $this->user->id,
            'code' => 'RES-000001',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
            'service_type' => 'Gala Dinner',
            'notes' => '',
            'status' => 'lunas',
            'total_price' => 100000
        ]);

        $data = [
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '19:00',
            'number_of_people' => 4,
            'service_type' => 'Gala Dinner',
            'special_requests' => ''
        ];

        $response = $this->post(route('customer.reservation.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors('reservation_date');
        $this->assertDatabaseMissing('reservations', [
            'user_id' => $this->user->id,
            'date' => $data['reservation_date'],
            'time' => $data['reservation_time'],
            'guests' => $data['number_of_people']
        ]);
    }

    /**
     * Test reservation update with correct status check.
     */
    public function test_reservation_update_with_status_check()
    {
        $this->withoutMiddleware();

        $reservation = Reservation::create([
            'user_id' => $this->user->id,
            'code' => 'RES-000001',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
            'service_type' => 'Gala Dinner',
            'notes' => '',
            'status' => 'pending',
            'total_price' => 100000
        ]);

        $updateData = [
            'reservation_date' => now()->addDays(2)->format('Y-m-d'),
            'reservation_time' => '20:00',
            'number_of_people' => 6,
            'service_type' => 'Cooking Class',
            'special_requests' => 'Updated request'
        ];

        $response = $this->put(route('customer.reservation.update', $reservation->id), $updateData);

        $response->assertRedirect(route('customer.reservation.index'));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'date' => $updateData['reservation_date'],
            'time' => $updateData['reservation_time'],
            'guests' => $updateData['number_of_people'],
            'service_type' => $updateData['service_type'],
            'notes' => $updateData['special_requests'],
            'total_price' => 300000 // 6 * 50000
        ]);
    }

    /**
     * Test reservation cannot be updated if status is not pending.
     */
    public function test_reservation_cannot_be_updated_if_not_pending()
    {
        $this->withoutMiddleware();

        $reservation = Reservation::create([
            'user_id' => $this->user->id,
            'code' => 'RES-000001',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
            'service_type' => 'Gala Dinner',
            'notes' => '',
            'status' => 'lunas', // Not pending
            'total_price' => 100000
        ]);

        $updateData = [
            'reservation_date' => now()->addDays(2)->format('Y-m-d'),
            'reservation_time' => '20:00',
            'number_of_people' => 6,
            'service_type' => 'Cooking Class',
            'special_requests' => 'Updated request'
        ];

        $response = $this->put(route('customer.reservation.update', $reservation->id), $updateData);

        $response->assertRedirect(route('customer.reservation.index'));
        $response->assertSessionHas('error', 'Reservasi tidak dapat diupdate.');
    }

    /**
     * Test reservation deletion with status check.
     */
    public function test_reservation_deletion_with_status_check()
    {
        $this->withoutMiddleware();

        $reservation = Reservation::create([
            'user_id' => $this->user->id,
            'code' => 'RES-000001',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
            'service_type' => 'Gala Dinner',
            'notes' => '',
            'status' => 'pending',
            'total_price' => 100000
        ]);

        $response = $this->delete(route('customer.reservation.destroy', $reservation->id));

        $response->assertRedirect(route('customer.reservation.index'));
        $this->assertSoftDeleted($reservation);
    }

    /**
     * Test reservation cannot be deleted if status is not pending.
     */
    public function test_reservation_cannot_be_deleted_if_not_pending()
    {
        $this->withoutMiddleware();

        $reservation = Reservation::create([
            'user_id' => $this->user->id,
            'code' => 'RES-000001',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
            'service_type' => 'Gala Dinner',
            'notes' => '',
            'status' => 'lunas', // Not pending
            'total_price' => 100000
        ]);

        $response = $this->delete(route('customer.reservation.destroy', $reservation->id));

        $response->assertRedirect(route('customer.reservation.index'));
        $response->assertSessionHas('error', 'Reservasi tidak dapat dibatalkan.');
        $this->assertDatabaseHas('reservations', ['id' => $reservation->id]);
    }

    /**
     * Test calendar shows only lunas reservations.
     */
    public function test_calendar_shows_only_lunas_reservations()
    {
        // Create pending reservation
        Reservation::create([
            'user_id' => $this->user->id,
            'code' => 'RES-000001',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
            'service_type' => 'Gala Dinner',
            'notes' => '',
            'status' => 'pending',
            'total_price' => 100000
        ]);

        // Create lunas reservation
        $lunasReservation = Reservation::create([
            'user_id' => $this->user->id,
            'code' => 'RES-000002',
            'date' => now()->addDays(2)->format('Y-m-d'),
            'time' => '20:00',
            'guests' => 4,
            'service_type' => 'Cooking Class',
            'notes' => '',
            'status' => 'lunas',
            'total_price' => 200000
        ]);

        // Test the controller method directly
        $controller = new \App\Http\Controllers\Customer\ReservationController();
        $response = $controller->calendar();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $viewData = $response->getData();
        $this->assertArrayHasKey('reservations', $viewData);
        $reservations = $viewData['reservations'];
        $this->assertTrue($reservations->contains($lunasReservation));
        $this->assertEquals(1, $reservations->count());
    }
}
