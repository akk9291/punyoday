<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Shivirs table
        Schema::create('shivirs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "33वाँ श्रावक संस्कार शिविर"
            $table->string('shivir_number')->nullable(); // e.g. "33"
            $table->integer('year'); // e.g. 2026
            $table->string('slug')->unique(); // e.g. "sanskar-shivir-ashoknagar-2026"
            $table->string('location'); // e.g. "अशोकनगर (म.प्र.)"
            $table->string('venue'); // e.g. "आनंदपुर रोड, अशोकनगर"
            $table->date('start_date');
            $table->date('end_date');
            $table->date('reg_start_date')->nullable();
            $table->date('reg_end_date')->nullable();
            $table->enum('status', ['draft', 'registration_open', 'registration_closed', 'ongoing', 'completed', 'archived'])->default('draft');
            $table->integer('max_limit')->default(5000);
            $table->string('prefix')->default('ASH-2026-');
            $table->text('contact_info')->nullable();
            $table->boolean('is_male_only')->default(true);
            $table->text('description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('logo')->nullable();
            $table->json('seo_meta')->nullable();
            $table->timestamps();
        });

        // 2. Shivir Dynamic Sections (CMS)
        Schema::create('shivir_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('background')->nullable(); // e.g. "bg-amber-50"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Shivir Dynamic Section Items (Persons / Contact / Feature Items)
        Schema::create('shivir_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_section_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Shivir Rules
        Schema::create('shivir_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('rule_text');
            $table->enum('rule_type', ['general', 'mandatory', 'prohibition', 'what_to_bring', 'what_not_to_bring'])->default('general');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Shivir FAQs
        Schema::create('shivir_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->text('answer');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Shivir Daily Schedules
        Schema::create('shivir_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->integer('day_number')->default(1);
            $table->date('date')->nullable();
            $table->string('time_slot'); // e.g. "05:00 AM - 06:00 AM"
            $table->string('activity_name'); // e.g. "सामयिक एवं प्रतिक्रमण"
            $table->string('location_venue')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Announcements
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['normal', 'important', 'emergency'])->default('normal');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Participants
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('father_name');
            $table->string('mother_name')->nullable();
            $table->date('dob');
            $table->integer('age');
            $table->string('mobile');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('district');
            $table->string('state');
            $table->string('pincode');
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->text('family_info')->nullable();
            $table->string('social_org')->nullable();
            $table->string('social_position')->nullable();
            $table->boolean('previous_shivir_attended')->default(false);
            $table->integer('previous_shivir_count')->default(0);
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number');
            $table->string('blood_group')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('id_document_path')->nullable();
            $table->timestamps();
        });

        // 9. Registrations
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->string('registration_number')->unique(); // e.g. ASH-2026-00001
            $table->string('qr_token')->unique(); // Secure random token
            $table->enum('status', ['pending', 'approved', 'checked_in', 'cancelled'])->default('approved');
            $table->boolean('rules_accepted')->default(true);
            $table->dateTime('checked_in_at')->nullable();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 10. Accommodation Blocks, Rooms, Beds
        Schema::create('accommodation_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g. "Block A - Mahavir Bhawan"
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('accommodation_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_block_id')->constrained()->onDelete('cascade');
            $table->string('room_number'); // e.g. "101"
            $table->integer('capacity')->default(4);
            $table->string('floor')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('accommodation_beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_room_id')->constrained()->onDelete('cascade');
            $table->string('bed_number'); // e.g. "1", "Bed A"
            $table->boolean('is_occupied')->default(false);
            $table->timestamps();
        });

        Schema::create('room_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('accommodation_bed_id')->constrained()->onDelete('cascade');
            $table->dateTime('allocated_at');
            $table->foreignId('allocated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 11. Groups / Batches
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g. "साधना समूह – 07"
            $table->string('leader_name')->nullable();
            $table->string('leader_contact')->nullable();
            $table->string('meeting_point')->nullable();
            $table->text('schedule_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 12. Attendance Sessions & Records
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('session_name'); // e.g. "सुबह प्रतिक्रमण", "संध्या प्रवचन"
            $table->date('session_date');
            $table->enum('type', ['morning', 'evening', 'session', 'special', 'full_day'])->default('session');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->dateTime('scanned_at');
            $table->foreignId('scanned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('device_info')->nullable();
            $table->unique(['attendance_session_id', 'registration_id']);
            $table->timestamps();
        });

        // 13. Meals & Meal Records
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('meal_name'); // e.g. "प्रात: जलपान", "दोपहर भोजन"
            $table->date('meal_date');
            $table->timestamps();
        });

        Schema::create('meal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->dateTime('scanned_at');
            $table->foreignId('scanned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->unique(['meal_id', 'registration_id']);
            $table->timestamps();
        });

        // 14. Transport Routes & Assignments
        Schema::create('transport_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shivir_id')->constrained()->onDelete('cascade');
            $table->string('vehicle_number');
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('pickup_point');
            $table->integer('capacity')->default(50);
            $table->timestamps();
        });

        Schema::create('transport_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transport_route_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 15. Certificates
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->string('verification_token')->unique();
            $table->date('issued_date');
            $table->timestamps();
        });

        // 16. Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // e.g. "emergency_view", "verify_registration", "room_allocate"
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('transport_assignments');
        Schema::dropIfExists('transport_routes');
        Schema::dropIfExists('meal_records');
        Schema::dropIfExists('meals');
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('attendance_sessions');
        Schema::dropIfExists('group_members');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('room_allocations');
        Schema::dropIfExists('accommodation_beds');
        Schema::dropIfExists('accommodation_rooms');
        Schema::dropIfExists('accommodation_blocks');
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('participants');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('shivir_schedules');
        Schema::dropIfExists('shivir_faqs');
        Schema::dropIfExists('shivir_rules');
        Schema::dropIfExists('shivir_section_items');
        Schema::dropIfExists('shivir_sections');
        Schema::dropIfExists('shivirs');
    }
};
