<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Event;
use App\Models\EventItEquipment;
use App\Models\EventMeal;
use App\Models\EventMealDetail;
use App\Models\EventType;
use App\Models\ItEquipment;
use App\Models\Location;
use App\Models\MealSession;
use App\Models\ServingMethod;
use App\Models\SpecialGuest;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'staff',
            'admin',
            'it admin',
            'dietary', // ✅ ganti dari ditary
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $departments = ['IT', 'HR', 'Finance', 'Operations'];
        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept]);
        }

        $users = [
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'department' => 'Operations',
                'staff_id' => 'STF001',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'department' => 'HR',
                'staff_id' => 'ADM001',
            ],
            [
                'name' => 'IT Admin User',
                'email' => 'itadmin@example.com',
                'password' => bcrypt('password'),
                'role' => 'it admin',
                'department' => 'IT',
                'staff_id' => 'ITA001',
            ],
            [
                'name' => 'Dietary User',
                'email' => 'dietary@example.com',
                'password' => bcrypt('password'),
                'role' => 'dietary',
                'department' => 'Finance',
                'staff_id' => 'DIT001',
            ],
        ];

        foreach ($users as $data) {
            $department = Department::where('name', $data['department'])->first();

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'staff_id' => $data['staff_id'],
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'department_id' => $department->id ?? null,
                ]
            );

            $user->syncRoles([$data['role']]);
        }



        // Seed Event Types
        $eventTypes = ['Meeting', 'Training', 'Seminar', 'Workshop'];
        foreach ($eventTypes as $event) {
            EventType::firstOrCreate(['name' => $event]);
        }

        // Seed Locations
        $locations = ['HQ - Kuala Lumpur', 'Branch - Penang', 'Branch - Johor', 'Warehouse - Selangor'];
        foreach ($locations as $loc) {
            Location::firstOrCreate(['name' => $loc]);
        }

        // Seed IT Equipment
        $equipments = ['Dell Laptop', 'HP Printer', 'Cisco Router', 'Projector'];
        foreach ($equipments as $equip) {
            ItEquipment::firstOrCreate(['name' => $equip]);
        }


        // Special Guests
        $guests = ['CEO', 'CFO', 'CTO', 'Guest Speaker'];
        foreach ($guests as $guest) {
            SpecialGuest::firstOrCreate(['name' => $guest]);
        }

        // Serving Methods
        $methods = ['Buffet', 'Plated', 'Self-Service', 'Packed Meal'];
        foreach ($methods as $method) {
            ServingMethod::firstOrCreate(['name' => $method]);
        }

        $equipments = ['Online Setup', 'PA System', 'Laptop'];
        foreach ($equipments as $eq) {
            ItEquipment::firstOrCreate(['name' => $eq]);
        }
        $mealSessions = [
            ['name' => 'Breakfast', 'start_time' => '07:30:00', 'end_time' => '09:00:00'],
            ['name' => 'Lunch', 'start_time' => '12:30:00', 'end_time' => '14:00:00'],
            ['name' => 'Dinner', 'start_time' => '19:00:00', 'end_time' => '21:00:00'],
        ];

        foreach ($mealSessions as $session) {
            MealSession::firstOrCreate(['name' => $session['name']], $session);
        }

        $faker = \Faker\Factory::create();

        $allDepartments  = Department::all();
        $allLocations    = Location::all();
        $allEventType    = EventType::all();
        $allEquipments   = ItEquipment::all();
        $allGuests       = SpecialGuest::all();
        $allServing      = ServingMethod::all();
        $mealSessions    = \App\Models\MealSession::all();
        $allUsers        = \App\Models\User::all(); // ambil semua user

        for ($i = 1; $i <= 3; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');

            $event = \App\Models\Event::create([
                'name'          => "Event $i",
                'department_id' => $allDepartments->random()->id,
                'event_type_id' => $allEventType->random()->id,
                'date'          => $date,
                'start_time'    => '09:00:00',
                'end_time'      => '17:00:00',
                'location_id'   => $allLocations->random()->id,
                'status'        => rand(0, 2), // contoh 0=pending,1=confirmed,2=completed
                'contact_no'    => $faker->phoneNumber(),
                'user_id'       => $allUsers->random()->id, // simpan user yang request
            ]);

            // kalau ada meal (contoh selain event pertama)
            if ($i > 1) {
                $eventMeal = \App\Models\EventMeal::create([
                    'event_id'              => $event->id,
                    'remark'                => $faker->sentence(),
                    'total_pax'             => $faker->numberBetween(20, 100),
                    'total_vegetarian_meal' => $faker->numberBetween(5, 30),
                    'special_guest_id'      => $allGuests->random()->id,
                    'serving_method_id'     => $allServing->random()->id,
                ]);

                // Buat details untuk setiap meal session
                foreach ($mealSessions as $session) {
                    \App\Models\EventMealDetail::create([
                        'event_meal_id'   => $eventMeal->id,
                        'meal_session_id' => $session->id,
                        'time'            => $faker->time('H:i'),
                        'remark'          => $faker->sentence(),
                    ]);
                }
            }

            $event->itEquipments()->attach(
                $allEquipments->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
