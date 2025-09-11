<?php
// 旧天命サイトでは、javascriptで書かれていたコードを geminiで php化、chatgptにて検証したコード
// 

namespace App\Logics;

/**
 *  天命を計算するロジッククラス
 * 
 * @return 連想配列
 * array [
 *    'talent' => (int),
 *    'weakness' => (int),
 *    'destiny' => (int),
 * ]
 *
*/
class TenmeiLogic {

    function calculateFortuneTelling(int $year, int $month, int $day): array
    {
        // ① 生年月日を年+月+日の合計を計算
        $sumOfBirthDate = $year + $month + $day;

        // ② 生年月日を一桁ずつすべて足した合計を計算
        // 文字列に変換して連結
        $birthDateStr = (string)$year . (string)$month . (string)$day;
        $sumOfDigitsOfBirthDate = 0;
        // 一桁ずつ再度数字に変換して合計する
        for ($i = 0; $i < strlen($birthDateStr); $i++) {
            $sumOfDigitsOfBirthDate += (int)$birthDateStr[$i];
        }

        // ③ ①で出た数字を一桁ずつ足した合計を計算
        $tempSum = $sumOfBirthDate;
        $sumOfDigits = 0;           // 弱点と天命の計算で使う
        while ($tempSum > 0) {
            $sumOfDigits += $tempSum % 10;
            $tempSum = floor($tempSum / 10);
        }

        // 才能の計算
        // ②で求めた数字から計算
        $talent = $sumOfDigitsOfBirthDate;
        if ($talent % 22 === 0) {
            $talent = 0;
        } else {
            while ($talent >= 22) {
                $talent -= 22;
            }
        }

        // 弱点の計算
        $weakness;
        if ($sumOfDigits === 22) {
            $weakness = 0;
        } elseif ($sumOfDigits === 19) {
            $weakness = 22 ;  // 特別なデータ 弱点が２つある人
        } elseif ($sumOfDigits >= 22) {
            $weakness = floor($sumOfDigits / 10) + ($sumOfDigits % 10);
        } else {
            $weakness = $sumOfDigits;
        }

        // 天命の計算
        $destiny = $sumOfDigits;
        while ($destiny >= 10) {
            $destiny = floor($destiny / 10) + ($destiny % 10);
        }

        // エンティティクラスのようなものを作った方が使いやすいかも
        return [
            'talent' => (int)$talent,
            'weakness' => (int)$weakness,
            'destiny' => (int)$destiny,
        ];
    }

}