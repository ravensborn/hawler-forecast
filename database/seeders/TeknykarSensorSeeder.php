<?php

namespace Database\Seeders;

use App\Enums\MapPinType;
use App\Enums\SensorParameterUnit;
use App\Models\MapPin;
use App\Models\SensorDevice;
use App\Models\SensorDeviceGroup;
use App\Models\SensorParameter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
     *         sensorParameters: array<int, array{name: string, unit: SensorParameterUnit, icon: string, platform_parameter_id: int}>
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
            'latitude' => 36.1994058941314,
            'longitude' => 44.022088748999955,
            'sensorDevices' => [
                [
                    'sensorDeviceName' => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorParameterUnit::Celsius, 'icon' => 'thermometer', 'platform_parameter_id' => 123151],
                        ['name' => 'Humidity', 'unit' => SensorParameterUnit::RelativeHumidity, 'icon' => 'droplet', 'platform_parameter_id' => 123152],
                        ['name' => 'CO', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123153],
                        ['name' => 'SO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123154],
                        ['name' => 'NO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123155],
                        ['name' => 'O3', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123156],
                        ['name' => 'PM2.5', 'unit' => SensorParameterUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123157],
                        ['name' => 'PM10', 'unit' => SensorParameterUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123158],
                        ['name' => 'CH4', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123132],
                        ['name' => 'CO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123133],
                        ['name' => 'PM100', 'unit' => SensorParameterUnit::MilligramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123134],
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
            'latitude' => 36.161037541346225,
            'longitude' => 43.96886246726921,
            'sensorDevices' => [
                [
                    'sensorDeviceName' => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorParameterUnit::Celsius, 'icon' => 'thermometer', 'platform_parameter_id' => 123143],
                        ['name' => 'Humidity', 'unit' => SensorParameterUnit::RelativeHumidity, 'icon' => 'droplet', 'platform_parameter_id' => 123144],
                        ['name' => 'CO', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123145],
                        ['name' => 'SO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123146],
                        ['name' => 'NO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123147],
                        ['name' => 'O3', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123148],
                        ['name' => 'PM2.5', 'unit' => SensorParameterUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123149],
                        ['name' => 'PM10', 'unit' => SensorParameterUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123150],
                        ['name' => 'CH4', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123159],
                        ['name' => 'CO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123160],
                        ['name' => 'PM100', 'unit' => SensorParameterUnit::MilligramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123161],
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
            'latitude' => 36.15685769216389,
            'longitude' => 44.01836803986594,
            'sensorDevices' => [
                [
                    'sensorDeviceName' => [
                        'en' => 'Air Quality',
                        'ku' => 'کوالیتی هەوا',
                        'ar' => 'جودة الهواء',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorParameterUnit::Celsius, 'icon' => 'thermometer', 'platform_parameter_id' => 123135],
                        ['name' => 'Humidity', 'unit' => SensorParameterUnit::RelativeHumidity, 'icon' => 'droplet', 'platform_parameter_id' => 123136],
                        ['name' => 'CO', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123137],
                        ['name' => 'SO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123138],
                        ['name' => 'NO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123139],
                        ['name' => 'O3', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123140],
                        ['name' => 'PM2.5', 'unit' => SensorParameterUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123141],
                        ['name' => 'PM10', 'unit' => SensorParameterUnit::MicrogramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123142],
                        ['name' => 'CH4', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123162],
                        ['name' => 'CO2', 'unit' => SensorParameterUnit::PartsPerMillion, 'icon' => 'cloud', 'platform_parameter_id' => 123163],
                        ['name' => 'PM100', 'unit' => SensorParameterUnit::MilligramsPerCubicMeter, 'icon' => 'gauge', 'platform_parameter_id' => 123164],
                    ],
                ],
            ],
        ],
        [
            'sensorDeviceGroupName' => [
                'en' => 'Extras',
                'ku' => 'Extras',
                'ar' => 'Extras',
            ],
            'latitude' => 36.15685769216389,
            'longitude' => 44.01836803986594,
            'sensorDevices' => [
                [
                    'sensorDeviceName' => [
                        'en' => 'Rain Meter Station Kalak',
                        'ku' => 'وێستگەی رێژەی باران - کەلەک',
                        'ar' => 'محطة قياس المطر - کەلەک',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorParameterUnit::Celsius, 'icon' => 'thermometer', 'platform_parameter_id' => 123079],
                        ['name' => 'Rain Value', 'unit' => SensorParameterUnit::Millimeters, 'icon' => 'cloud-rain', 'platform_parameter_id' => 123088],
                        ['name' => 'Humidity', 'unit' => SensorParameterUnit::RelativeHumidity, 'icon' => 'droplet', 'platform_parameter_id' => 123080],
                        ['name' => 'Pressure', 'unit' => SensorParameterUnit::Hectopascal, 'icon' => 'gauge', 'platform_parameter_id' => 123081],
                        ['name' => 'Motion / Vibration Level', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123082],
                        ['name' => 'Tilt / Orientation', 'unit' => SensorParameterUnit::Degrees, 'icon' => 'compass', 'platform_parameter_id' => 123083],
                        ['name' => 'Motion State', 'unit' => SensorParameterUnit::NoUnit, 'icon' => 'activity', 'platform_parameter_id' => 123084],
                        ['name' => 'Acceleration X Axis', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123085],
                        ['name' => 'Acceleration Y Axis', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123086],
                        ['name' => 'Acceleration Z Axis', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123087],
                    ],
                ],
                [
                    'sensorDeviceName' => [
                        'en' => 'Distance Measure - Radar',
                        'ku' => 'پێوەری ئاست - ڕادار',
                        'ar' => 'مقياس مستوى - رادار',
                    ],
                    'sensorParameters' => [
                        ['name' => 'Temperature', 'unit' => SensorParameterUnit::Celsius, 'icon' => 'thermometer', 'platform_parameter_id' => 123048],
                        ['name' => 'Distance', 'unit' => SensorParameterUnit::Meters, 'icon' => 'ruler', 'platform_parameter_id' => 123057],
                        ['name' => 'Humidity', 'unit' => SensorParameterUnit::RelativeHumidity, 'icon' => 'droplet', 'platform_parameter_id' => 123049],
                        ['name' => 'Pressure', 'unit' => SensorParameterUnit::Hectopascal, 'icon' => 'gauge', 'platform_parameter_id' => 123050],
                        ['name' => 'Motion / Vibration Level', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123051],
                        ['name' => 'Tilt / Orientation', 'unit' => SensorParameterUnit::Degrees, 'icon' => 'compass', 'platform_parameter_id' => 123052],
                        ['name' => 'Motion State', 'unit' => SensorParameterUnit::NoUnit, 'icon' => 'activity', 'platform_parameter_id' => 123053],
                        ['name' => 'Acceleration X Axis', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123054],
                        ['name' => 'Acceleration Y Axis', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123055],
                        ['name' => 'Acceleration Z Axis', 'unit' => SensorParameterUnit::GravitationalAcceleration, 'icon' => 'activity', 'platform_parameter_id' => 123056],
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

            foreach ($sensorDeviceGroupData['sensorDevices'] as $sensorDeviceData) {
                $sensorDevice = SensorDevice::create([
                    'name' => $sensorDeviceData['sensorDeviceName'],
                    'sensor_device_group_id' => $sensorDeviceGroup->id,
                    'platform_device_id' => Str::uuid(),
                ]);

                foreach ($sensorDeviceData['sensorParameters'] as $sensorParameterData) {
                    SensorParameter::create([
                        'sensor_device_id' => $sensorDevice->id,
                        'name' => $sensorParameterData['name'],
                        'unit' => $sensorParameterData['unit'],
                        'icon' => $sensorParameterData['icon'],
                        'platform_parameter_id' => $sensorParameterData['platform_parameter_id'],
                    ]);
                }
            }

            MapPin::create([
                'icon' => 'weather-station',
                'type' => MapPinType::WeatherStation,
                'latitude' => $sensorDeviceGroupData['latitude'],
                'longitude' => $sensorDeviceGroupData['longitude'],
                'sensor_device_group_id' => $sensorDeviceGroup->id,
                'data' => null,
            ]);
        }
    }
}
