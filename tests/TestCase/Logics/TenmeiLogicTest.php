<?php
// このコマンドで実行する
// ドッカーコンテナーに入る
// docker exec -it 1a bash
// テストコードの実行 
// ./vendor/bin/phpunit tests/TestCase/Logics/TenmeiLogicTest.php

declare(strict_types=1);

namespace App\Test\TestCase\Logics;

use App\Logics\TenmeiLogic;
use Cake\TestSuite\TestCase;

/**
 * App\Logics\TenmeiLogic Test Case
 *
 * TenmeiLogicクラスのテストケース
 */
class TenmeiLogicTest extends TestCase
{
    /**
     * テスト対象のクラス
     *
     * @var \App\Logics\TenmeiLogic
     */
    public $TenmeiLogic;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->TenmeiLogic = new TenmeiLogic();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TenmeiLogic);
        parent::tearDown();
    }

    /**
     * calculateFortuneTelling() メソッドのテスト
     * ↓ このアノテーションが重要
     * @dataProvider calculateFortuneTellingDataProvider
     * @param int $year
     * @param int $month
     * @param int $day
     * @param array $expected
     * @return void
     */
    public function testCalculateFortuneTelling(int $year, int $month, int $day, array $expected): void
    {
        $actual = $this->TenmeiLogic->calculateFortuneTelling($year, $month, $day);
        $this->assertEquals($expected, $actual);
    }

    /**
     * calculateFortuneTelling() メソッド用のデータプロバイダ
     * 上のテストメソッドにアノテーションがついているので、このメソッドが返す値を順次使用する
     *
     * @return array
     */
    public static function calculateFortuneTellingDataProvider(): array
    {
        return [
            // ケース1: 2025年8月12日のテスト
            'valid date case 1'  => [2025, 8, 12, ['talent' => 20, 'weakness' => 11, 'destiny' => 2]],
            'valid date case 2'  => [1985, 1,  1, ['talent' =>  3, 'weakness' =>  7, 'destiny' => 7]],
            'valid date case 3'  => [2000,12, 31, ['talent' =>  9, 'weakness' =>  9, 'destiny' => 9]],
            'valid date case 4'  => [1999, 9,  9, ['talent' =>  2, 'weakness' => 10, 'destiny' => 1]],
            'valid date case 5'  => [1940, 2,  6, ['talent' =>  0, 'weakness' =>  0, 'destiny' => 4]],
            'valid date case 6'  => [1956, 2,  5, ['talent' =>  6, 'weakness' => 22, 'destiny' => 1]], 
            'valid date case 7'  => [1969, 9, 29, ['talent' =>  1, 'weakness' =>  9, 'destiny' => 9]],
            'valid date case 8'  => [1985, 1,  1, ['talent' =>  3, 'weakness' =>  7, 'destiny' => 7]],
            'valid date case 9'  => [1999, 9,  9, ['talent' =>  2, 'weakness' => 10, 'destiny' => 1]],
            'valid date case 10' => [2025, 8, 12, ['talent' => 20, 'weakness' => 11, 'destiny' => 2]],
            'valid date case 11' => [1925, 7,  4, ['talent' =>  6, 'weakness' => 22, 'destiny' => 1]], 
            'valid date case 12' => [1933, 12, 5, ['talent' =>  2, 'weakness' => 15, 'destiny' => 6]],
            'valid date case 13' => [1940, 2,  6, ['talent' =>  0, 'weakness' =>  0, 'destiny' => 4]],
            'valid date case 14' => [1956, 2,  5, ['talent' =>  6, 'weakness' => 22, 'destiny' => 1]],
            'valid date case 15' => [1969, 9, 29, ['talent' =>  1, 'weakness' =>  9, 'destiny' => 9]],
            'valid date case 16' => [1978, 7, 21, ['talent' => 13, 'weakness' =>  8, 'destiny' => 8]],
            'valid date case 17' => [1985, 1,  1, ['talent' =>  3, 'weakness' =>  7, 'destiny' => 7]],
            'valid date case 18' => [1999, 9,  9, ['talent' =>  2, 'weakness' => 10, 'destiny' => 1]],
            'valid date case 19' => [2005, 3, 10, ['talent' => 11, 'weakness' => 11, 'destiny' => 2]],
            'valid date case 20' => [2025, 8, 12, ['talent' => 20, 'weakness' => 11, 'destiny' => 2]],
        ];
    }
}