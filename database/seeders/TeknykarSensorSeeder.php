<?php

namespace Database\Seeders;

use App\Enums\MapPinType;
use App\Enums\SensorUnit;
use App\Models\MapPin;
use App\Models\Sensor;
use App\Models\SensorDevice;
use App\Models\SensorDeviceGroup;
use App\Models\SensorParameter;
use Illuminate\Database\Seeder;

class TeknykarSensorSeeder extends Seeder
{
    /**
     * Each entry represents a SensorDeviceGroup (the station).
     * Each sensorDevice entry represents a SensorDevice (a group within the station, e.g. Air Quality).
     * Each sensorDevice has sensorParameters, each with a platform_parameter_id (Teknykar endpoint ID).
     *
     * @var array<int, array{
     *     sensorDeviceGroupName: array{en: string, ku: string, ar: string},
     *     latitude: float,
     *     longitude: float,
     *     sensorDevices: array<int, array{
     *         sensorDeviceName: array{en: string, ku: string, ar: string},
     *         sensorParameters: array<int, array{name: string, unit: string, icon: string, platform_parameter_id: int}>
     *     }>
     * }>
     */
    private array $sensorDeviceGroups = [
        [
            'sensorDeviceGroupName' => [
                'en' => 'Hawler Psychiatric Hospital',
                'ku' => 'نەخۆشخانەی دەروونی هەولێر',
                'ar' => 'مستشفى أربيل للأمراض النفسية',
            ],
            'latitude'      => 36.1994058941314,
            'longitude'     => 44.022088748999955,
            'sensorDevices' => [
                [
                    'sensorDeviceName' => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorUnit::Celsius,    'icon' => 'thermometer', 'platform_parameter_id' => 123151],
                        ['name' => 'Humidity',    'unit' => SensorUnit::Humidity,      'icon' => 'droplet',     'platform_parameter_id' => 123152],
                        ['name' => 'CO',          'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123153],
                        ['name' => 'SO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123154],
                        ['name' => 'NO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123155],
                        ['name' => 'O3',          'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123156],
                        ['name' => 'PM2.5',       'unit' => SensorUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123157],
                        ['name' => 'PM10',        'unit' => SensorUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123158],
                        ['name' => 'CH4',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123132],
                        ['name' => 'CO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123133],
                        ['name' => 'PM100',       'unit' => SensorUnit::MilligramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123134],
                    ],
                ],
            ],
        ],
        [
            'sensorDeviceGroupName' => [
                'en' => 'Rozhawa Emergency Hospital',
                'ku' => 'نەخۆشخانەی فریاکەوتنی رۆژئاوا',
                'ar' => 'مستشفى طواريء رۆژئاوا',
            ],
            'latitude'      => 36.161037541346225,
            'longitude'     => 43.96886246726921,
            'sensorDevices' => [
                [
                    'sensorDeviceName' => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorUnit::Celsius,    'icon' => 'thermometer', 'platform_parameter_id' => 123143],
                        ['name' => 'Humidity',    'unit' => SensorUnit::Humidity,      'icon' => 'droplet',     'platform_parameter_id' => 123144],
                        ['name' => 'CO',          'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123145],
                        ['name' => 'SO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123146],
                        ['name' => 'NO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123147],
                        ['name' => 'O3',          'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123148],
                        ['name' => 'PM2.5',       'unit' => SensorUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123149],
                        ['name' => 'PM10',        'unit' => SensorUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123150],
                        ['name' => 'CH4',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123159],
                        ['name' => 'CO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123160],
                        ['name' => 'PM100',       'unit' => SensorUnit::MilligramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123161],
                    ],
                ],
            ],
        ],
        [
            'sensorDeviceGroupName' => [
                'en' => 'Erbil Environment Directorate',
                'ku' => 'بەڕێوەبەرایەتی ژینگەی هەولێر',
                'ar' => 'مديرية بيئة أربيل',
            ],
            'latitude'      => 36.15685769216389,
            'longitude'     => 44.01836803986594,
            'sensorDevices' => [
                [
                    'sensorDeviceName' => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorUnit::Celsius,    'icon' => 'thermometer', 'platform_parameter_id' => 123135],
                        ['name' => 'Humidity',    'unit' => SensorUnit::Humidity,      'icon' => 'droplet',     'platform_parameter_id' => 123136],
                        ['name' => 'CO',          'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123137],
                        ['name' => 'SO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123138],
                        ['name' => 'NO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123139],
                        ['name' => 'O3',          'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123140],
                        ['name' => 'PM2.5',       'unit' => SensorUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123141],
                        ['name' => 'PM10',        'unit' => SensorUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123142],
                        ['name' => 'CH4',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123162],
                        ['name' => 'CO2',         'unit' => SensorUnit::PartsPerMillion,    'icon' => 'cloud',       'platform_parameter_id' => 123163],
                        ['name' => 'PM100',       'unit' => SensorUnit::MilligramsPerCubicMeter, 'icon' => 'gauge',       'platform_parameter_id' => 123164],
                    ],
                ],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->sensorDeviceGroups as $sensorDeviceGroupData) {
            $sensorDeviceGroup = SensorDeviceGroup::create([
                'name' => $sensorDeviceGroupData['sensorDeviceGroupName'],
            ]);

            $firstSensorDevice = null;

            foreach ($sensorDeviceGroupData['sensorDevices'] as $sensorDeviceData) {
                $sensor = Sensor::create([
                    'name' => $sensorDeviceGroupData['sensorDeviceGroupName']['en'].' - '.$sensorDeviceData['sensorDeviceName']['en'],
                ]);

                foreach ($sensorDeviceData['sensorParameters'] as $sensorParameterData) {
                    SensorParameter::create([
                        'sensor_id'             => $sensor->id,
                        'name'                  => $sensorParameterData['name'],
                        'unit'                  => $sensorParameterData['unit'],
                        'icon'                  => $sensorParameterData['icon'],
                        'platform_parameter_id' => $sensorParameterData['platform_parameter_id'],
                    ]);
                }

                $sensorDevice = SensorDevice::create([
                    'name'                   => $sensorDeviceData['sensorDeviceName'],
                    'sensor_id'              => $sensor->id,
                    'sensor_device_group_id' => $sensorDeviceGroup->id,
                    'platform_device_id'     => $sensor->id,
                ]);

                $firstSensorDevice ??= $sensorDevice;
            }

            MapPin::create([
                'icon'                   => 'weather-station',
                'type'                   => MapPinType::WeatherStation,
                'latitude'               => $sensorDeviceGroupData['latitude'],
                'longitude'              => $sensorDeviceGroupData['longitude'],
                'sensor_device_group_id' => $sensorDeviceGroup->id,
                'data'                   => ['stationName' => $sensorDeviceGroupData['sensorDeviceGroupName']],
            ]);
        }
    }
}
