<?php

namespace Database\Seeders;

use App\Enums\MapPinType;
use App\Models\MapPin;
use App\Models\Sensor;
use App\Models\SensorDevice;
use App\Models\SensorDeviceGroup;
use App\Models\SensorParameter;
use Illuminate\Database\Seeder;

class TeknykarSensorSeeder extends Seeder
{
    /**
     * @var array<int, array{
     *     name: array{en: string, ku: string, ar: string},
     *     latitude: float,
     *     longitude: float,
     *     groups: array<int, array{
     *         name: array{en: string, ku: string, ar: string},
     *         parameters: array<int, array{name: string, unit: string, icon: string, endpointId: int}>
     *     }>
     * }>
     */
    private array $stations = [
        [
            'name'      => [
                'en' => 'Hawler Psychiatric Hospital',
                'ku' => 'نەخۆشخانەی دەروونی هەولێر',
                'ar' => 'مستشفى أربيل للأمراض النفسية',
            ],
            'latitude'  => 36.1994058941314,
            'longitude' => 44.022088748999955,
            'groups'    => [
                [
                    'name'       => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'parameters' => [
                        ['name' => 'Temperature', 'unit' => '°C',    'icon' => 'thermometer', 'endpointId' => 123151],
                        ['name' => 'Humidity',    'unit' => '%',      'icon' => 'droplet',     'endpointId' => 123152],
                        ['name' => 'CO',          'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123153],
                        ['name' => 'SO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123154],
                        ['name' => 'NO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123155],
                        ['name' => 'O3',          'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123156],
                        ['name' => 'PM2.5',       'unit' => 'µg/m³', 'icon' => 'gauge',       'endpointId' => 123157],
                        ['name' => 'PM10',        'unit' => 'µg/m³', 'icon' => 'gauge',       'endpointId' => 123158],
                        ['name' => 'CH4',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123132],
                        ['name' => 'CO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123133],
                        ['name' => 'PM100',       'unit' => 'mg/m³', 'icon' => 'gauge',       'endpointId' => 123134],
                    ],
                ],
            ],
        ],
        [
            'name'      => [
                'en' => 'Rozhawa Emergency Hospital',
                'ku' => 'نەخۆشخانەی فریاکەوتنی رۆژئاوا',
                'ar' => 'مستشفى طواريء رۆژئاوا',
            ],
            'latitude'  => 36.161037541346225,
            'longitude' => 43.96886246726921,
            'groups'    => [
                [
                    'name'       => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'parameters' => [
                        ['name' => 'Temperature', 'unit' => '°C',    'icon' => 'thermometer', 'endpointId' => 123143],
                        ['name' => 'Humidity',    'unit' => '%',      'icon' => 'droplet',     'endpointId' => 123144],
                        ['name' => 'CO',          'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123145],
                        ['name' => 'SO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123146],
                        ['name' => 'NO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123147],
                        ['name' => 'O3',          'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123148],
                        ['name' => 'PM2.5',       'unit' => 'µg/m³', 'icon' => 'gauge',       'endpointId' => 123149],
                        ['name' => 'PM10',        'unit' => 'µg/m³', 'icon' => 'gauge',       'endpointId' => 123150],
                        ['name' => 'CH4',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123159],
                        ['name' => 'CO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123160],
                        ['name' => 'PM100',       'unit' => 'mg/m³', 'icon' => 'gauge',       'endpointId' => 123161],
                    ],
                ],
            ],
        ],
        [
            'name'      => [
                'en' => 'Erbil Environment Directorate',
                'ku' => 'بەڕێوەبەرایەتی ژینگەی هەولێر',
                'ar' => 'مديرية بيئة أربيل',
            ],
            'latitude'  => 36.15685769216389,
            'longitude' => 44.01836803986594,
            'groups'    => [
                [
                    'name'       => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'parameters' => [
                        ['name' => 'Temperature', 'unit' => '°C',    'icon' => 'thermometer', 'endpointId' => 123135],
                        ['name' => 'Humidity',    'unit' => '%',      'icon' => 'droplet',     'endpointId' => 123136],
                        ['name' => 'CO',          'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123137],
                        ['name' => 'SO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123138],
                        ['name' => 'NO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123139],
                        ['name' => 'O3',          'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123140],
                        ['name' => 'PM2.5',       'unit' => 'µg/m³', 'icon' => 'gauge',       'endpointId' => 123141],
                        ['name' => 'PM10',        'unit' => 'µg/m³', 'icon' => 'gauge',       'endpointId' => 123142],
                        ['name' => 'CH4',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123162],
                        ['name' => 'CO2',         'unit' => 'ppm',    'icon' => 'cloud',       'endpointId' => 123163],
                        ['name' => 'PM100',       'unit' => 'mg/m³', 'icon' => 'gauge',       'endpointId' => 123164],
                    ],
                ],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->stations as $station) {
            $firstGroup = null;

            foreach ($station['groups'] as $groupData) {
                $group = SensorDeviceGroup::create(['name' => $station['name']]);
                $sensor = Sensor::create(['name' => $station['name']['en'].' - '.$groupData['name']['en']]);

                foreach ($groupData['parameters'] as $parameter) {
                    SensorParameter::create([
                        'sensor_id'             => $sensor->id,
                        'name'                  => $parameter['name'],
                        'unit'                  => $parameter['unit'],
                        'icon'                  => $parameter['icon'],
                        'platform_parameter_id' => $parameter['endpointId'],
                    ]);
                }

                SensorDevice::create([
                    'name'                   => $groupData['name'],
                    'sensor_id'              => $sensor->id,
                    'sensor_device_group_id' => $group->id,
                    'platform_device_id'     => $sensor->id,
                ]);

                $firstGroup ??= $group;
            }

            MapPin::create([
                'icon'                   => 'weather-station',
                'type'                   => MapPinType::WeatherStation,
                'latitude'               => $station['latitude'],
                'longitude'              => $station['longitude'],
                'sensor_device_group_id' => $firstGroup->id,
                'data'                   => ['stationName' => $station['name']],
            ]);
        }
    }
}
