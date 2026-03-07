<?php

namespace Database\Seeders;

use App\Enums\Severity;
use App\Models\MapPin;
use App\Models\SensorDeviceGroup;
use Illuminate\Database\Seeder;

class MapPinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = SensorDeviceGroup::first();

        $stations = [
            ['name' => 'Erbil Citadel', 'lat' => 36.1901, 'lng' => 44.0089],
            ['name' => 'Ankawa', 'lat' => 36.2290, 'lng' => 44.0163],
            ['name' => 'Ainkawa Park', 'lat' => 36.2215, 'lng' => 44.0250],
            ['name' => 'Sami Abdulrahman Park', 'lat' => 36.1980, 'lng' => 43.9930],
            ['name' => 'Erbil International Airport', 'lat' => 36.2376, 'lng' => 43.9632],
        ];

        foreach ($stations as $station) {
            MapPin::factory()->weatherStation()->create([
                'latitude' => $station['lat'],
                'longitude' => $station['lng'],
                'sensor_device_group_id' => $group?->id,
                'data' => [
                    'stationName' => $station['name'] . ' Weather Station',
                    'status' => 'active',
                ],
            ]);
        }

        $alerts = [
            [
                'name' => 'Erbil Bazaar',
                'lat' => 36.1870,
                'lng' => 44.0120,
                'severity' => Severity::High,
                'message' => [
                    'en' => 'Extreme heat warning',
                    'ar' => 'تحذير من الحرارة الشديدة',
                    'ku' => 'ئاگاداری گەرمای زۆر',
                ],
            ],
            [
                'name' => 'Naz City',
                'lat' => 36.2100,
                'lng' => 44.0350,
                'severity' => Severity::Medium,
                'message' => [
                    'en' => 'Strong winds advisory',
                    'ar' => 'تنبيه من الرياح القوية',
                    'ku' => 'ئاگاداری بای بەهێز',
                ],
            ],
            [
                'name' => 'Shanadar',
                'lat' => 36.1950,
                'lng' => 44.0200,
                'severity' => Severity::Low,
                'message' => [
                    'en' => 'Light dust forecast',
                    'ar' => 'توقعات غبار خفيف',
                    'ku' => 'پێشبینی تۆزی سووک',
                ],
            ],
        ];

        foreach ($alerts as $alert) {
            MapPin::factory()->alert()->create([
                'latitude' => $alert['lat'],
                'longitude' => $alert['lng'],
                'data' => [
                    'severity' => $alert['severity'],
                    'message' => $alert['message'],
                ],
                'expires_at' => now()->addDays(rand(1, 7)),
            ]);
        }

        $incidents = [
            [
                'lat' => 36.2050,
                'lng' => 44.0080,
                'message' => [
                    'en' => 'Road closure due to construction',
                    'ar' => 'إغلاق الطريق بسبب أعمال البناء',
                    'ku' => 'داخستنی ڕێگا بەهۆی بیناسازییەوە',
                ],
            ],
            [
                'lat' => 36.1920,
                'lng' => 44.0300,
                'message' => [
                    'en' => 'Water main break reported',
                    'ar' => 'تم الإبلاغ عن كسر في أنبوب المياه الرئيسي',
                    'ku' => 'شکانی بۆری سەرەکی ئاو',
                ],
            ],
        ];

        foreach ($incidents as $incident) {
            MapPin::factory()->incident()->create([
                'latitude' => $incident['lat'],
                'longitude' => $incident['lng'],
                'data' => [
                    'message' => $incident['message'],
                ],
                'expires_at' => now()->addDays(rand(1, 7)),
            ]);
        }
    }
}
