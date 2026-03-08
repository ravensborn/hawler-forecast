<?php

namespace Database\Seeders;

use App\Enums\AlertRuleOperator;
use App\Enums\AlertType;
use App\Models\AlertRule;
use App\Models\SensorParameter;
use Illuminate\Database\Seeder;

class AlertRuleSeeder extends Seeder
{
    /**
     * Each rule defines a threshold condition and the alert to create when triggered.
     *
     * 'platformParameterIds' links the rule to SensorParameters by their platform_parameter_id,
     * giving you explicit control over which sensors across which stations are covered.
     *
     * Cooldown is per-rule: if any linked parameter triggers it, ALL linked parameters
     * are silenced for `cooldownHours`.
     */
    private array $rules = [
        [
            'name' => 'High Temperature',
            'operator' => AlertRuleOperator::GreaterThan,
            'threshold' => 1.0,
            'cooldownHours' => 6,
            'shouldNotify' => true,
            'platformParameterIds' => [123151, 123143, 123135],
            'alertIcon' => 'thermometer',
            'alertType' => AlertType::Danger,
            'alertTitle' => [
                'en' => 'Extreme Temperature Warning',
                'ku' => 'ئاگاداری پلەی گەرمی زۆر',
                'ar' => 'تحذير من درجة حرارة مرتفعة',
            ],
            'alertDescription' => [
                'en' => 'Temperature has exceeded the safe threshold of 45°C.',
                'ku' => ' پلەی گەرمی لە ئاستی ئاسایی تێپەڕیوە.',
                'ar' => 'تجاوزت درجة الحرارة الحد الآمن البالغ 45 درجة مئوية.',
            ],
        ],
//        [
//            'name' => 'High CO Level',
//            'operator' => AlertRuleOperator::GreaterThan,
//            'threshold' => 9.0,
//            'cooldownHours' => 6,
//            'shouldNotify' => true,
//            'platformParameterIds' => [123153, 123145, 123137],
//            'alertIcon' => 'cloud',
//            'alertType' => AlertType::Danger,
//            'alertTitle' => [
//                'en' => 'High Carbon Monoxide Warning',
//                'ku' => 'ئاگاداری بەرزبوونەوەی کاربۆن مۆنۆکساید',
//                'ar' => 'تحذير من ارتفاع أول أكسيد الكربون',
//            ],
//            'alertDescription' => [
//                'en' => 'CO concentration has exceeded the safe threshold of 9 ppm.',
//                'ku' => 'ئاستی CO لە ئاستی سەلامەت تێپەڕیوە ٩ ppm.',
//                'ar' => 'تجاوز تركيز CO الحد الآمن البالغ 9 جزء في المليون.',
//            ],
//        ],
//        [
//            'name' => 'High PM2.5 Level',
//            'operator' => AlertRuleOperator::GreaterThan,
//            'threshold' => 35.0,
//            'cooldownHours' => 6,
//            'shouldNotify' => false,
//            'platformParameterIds' => [123157, 123149, 123141],
//            'alertIcon' => 'gauge',
//            'alertType' => AlertType::Warning,
//            'alertTitle' => [
//                'en' => 'Elevated PM2.5 Levels',
//                'ku' => 'بەرزبوونەوەی ئاستی PM2.5',
//                'ar' => 'ارتفاع مستويات PM2.5',
//            ],
//            'alertDescription' => [
//                'en' => 'PM2.5 concentration has exceeded the safe threshold of 35 µg/m³.',
//                'ku' => 'ئاستی PM2.5 لە ئاستی سەلامەت تێپەڕیوە ٣٥ µg/m³.',
//                'ar' => 'تجاوز تركيز PM2.5 الحد الآمن البالغ 35 ميكروغرام/م³.',
//            ],
//        ],
//        [
//            'name' => 'High PM10 Level',
//            'operator' => AlertRuleOperator::GreaterThan,
//            'threshold' => 150.0,
//            'cooldownHours' => 6,
//            'shouldNotify' => false,
//            'platformParameterIds' => [123158, 123150, 123142],
//            'alertIcon' => 'gauge',
//            'alertType' => AlertType::Warning,
//            'alertTitle' => [
//                'en' => 'Elevated PM10 Levels',
//                'ku' => 'بەرزبوونەوەی ئاستی PM10',
//                'ar' => 'ارتفاع مستويات PM10',
//            ],
//            'alertDescription' => [
//                'en' => 'PM10 concentration has exceeded the safe threshold of 150 µg/m³.',
//                'ku' => 'ئاستی PM10 لە ئاستی سەلامەت تێپەڕیوە ١٥٠ µg/m³.',
//                'ar' => 'تجاوز تركيز PM10 الحد الآمن البالغ 150 ميكروغرام/م³.',
//            ],
//        ],
//        [
//            'name' => 'High SO2 Level',
//            'operator' => AlertRuleOperator::GreaterThan,
//            'threshold' => 0.075,
//            'cooldownHours' => 6,
//            'shouldNotify' => false,
//            'platformParameterIds' => [123154, 123146, 123138],
//            'alertIcon' => 'cloud',
//            'alertType' => AlertType::Warning,
//            'alertTitle' => [
//                'en' => 'Elevated SO2 Levels',
//                'ku' => 'بەرزبوونەوەی ئاستی SO2',
//                'ar' => 'ارتفاع مستويات SO2',
//            ],
//            'alertDescription' => [
//                'en' => 'SO2 concentration has exceeded the safe threshold.',
//                'ku' => 'ئاستی SO2 لە ئاستی سەلامەت تێپەڕیوە.',
//                'ar' => 'تجاوز تركيز SO2 الحد الآمن.',
//            ],
//        ],
    ];

    public function run(): void
    {
        foreach ($this->rules as $ruleData) {
            $rule = AlertRule::updateOrCreate(
                ['name' => $ruleData['name']],
                [
                    'operator' => $ruleData['operator'],
                    'threshold' => $ruleData['threshold'],
                    'cooldown_hours' => $ruleData['cooldownHours'],
                    'should_notify' => $ruleData['shouldNotify'],
                    'alert_icon' => $ruleData['alertIcon'],
                    'alert_title' => $ruleData['alertTitle'],
                    'alert_description' => $ruleData['alertDescription'],
                    'alert_type' => $ruleData['alertType'],
                ],
            );

            $parameterIds = SensorParameter::query()
                ->whereIn('platform_parameter_id', $ruleData['platformParameterIds'])
                ->pluck('id');

            $rule->sensorParameters()->sync($parameterIds);
        }
    }
}
