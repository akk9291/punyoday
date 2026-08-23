<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Shivir;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\AccommodationBed;
use App\Models\AccommodationRoom;
use App\Models\AccommodationBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanskarShivirTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (Shivir::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'SanskarShivirSeeder']);
        }
    }

    public function test_public_homepage_renders_active_shivir()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('33वाँ श्रावक संस्कार शिविर');
    }

    public function test_participant_can_submit_registration()
    {
        $shivir = Shivir::where('status', 'registration_open')->first();

        $response = $this->post("/shivir/{$shivir->slug}/register", [
            'full_name' => 'आलोक जैन परीक्षण',
            'father_name' => 'श्री मूलचंद जैन',
            'mother_name' => 'श्रीमती शांति जैन',
            'dob' => '1995-05-15',
            'mobile' => '9826099888',
            'whatsapp' => '9826099888',
            'email' => 'alok@example.com',
            'address' => '123 जैन मोहल्ला',
            'city' => 'अशोकनगर',
            'district' => 'अशोकनगर',
            'state' => 'मध्य प्रदेश',
            'pincode' => '473331',
            'education' => 'स्नातक',
            'occupation' => 'व्यापार',
            'emergency_contact_name' => 'श्री मूलचंद जैन',
            'emergency_contact_number' => '9826011111',
            'rules_accepted' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('participants', [
            'full_name' => 'आलोक जैन परीक्षण',
            'mobile' => '9826099888',
        ]);
    }

    public function test_registration_status_check()
    {
        $shivir = Shivir::first();
        $registration = Registration::where('shivir_id', $shivir->id)->first();

        $response = $this->post('/registration-status', [
            'shivir_id' => $shivir->id,
            'query' => $registration->registration_number,
        ]);

        $response->assertStatus(200);
        $response->assertSee($registration->participant->full_name);
    }

    public function test_staff_qr_token_lookup_and_room_allocation()
    {
        $user = User::where('role', 'admin')->first();
        $registration = Registration::first();

        $this->actingAs($user);

        // Staff Lookup
        $response = $this->post('/staff/lookup', [
            'token' => $registration->qr_token,
        ]);

        $response->assertJson(['success' => true]);
        $response->assertJsonPath('data.reg_no', $registration->registration_number);

        // Staff Verify Checkin
        $verifyRes = $this->post("/staff/verify/{$registration->id}");
        $verifyRes->assertJson(['success' => true]);

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'checked_in',
        ]);
    }
}
