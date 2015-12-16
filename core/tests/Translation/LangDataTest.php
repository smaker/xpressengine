<?php
namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Translation\LangData;

class LangDataTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testLangData()
    {
        $data = [
            'previous' => [
                'ko' => '이전',
                'en' => 'Prev',
            ],
            'next' => [
                'ko' => '다음',
                'en' => 'Next',
            ],
            'week' => [
                'mon' => [
                    'ko' => '월',
                    'en' => 'monday',
                ],
                'tue' => [
                    'ko' => '화',
                    'en' => 'tueseday',
                ],
            ],
        ];

        $expectedData = [
            'previous' => [
                'ko' => '이전',
                'en' => 'Prev',
            ],
            'next' => [
                'ko' => '다음',
                'en' => 'Next',
            ],
            'week.mon' => [
                'ko' => '월',
                'en' => 'monday',
            ],
            'week.tue' => [
                'ko' => '화',
                'en' => 'tueseday',
            ],
        ];

        $retrievedData = [];

        $langData = new LangData();
        $langData->setData($data);
        $langData->each(function ($item, $locale, $value) use (&$retrievedData) {
            $retrievedData[$item][$locale] = $value;
        });

        $this->assertSame($expectedData, $retrievedData);
    }
}
