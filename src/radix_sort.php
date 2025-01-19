<?php
/**
 * ラディックスソート関数
 *
 * 与えられた配列を1の位から順番にソートしていくことで、配列を昇順に並べ替えます。
 * 具体的には、1の位→10の位→100の位...と、桁ごとにカウントソートを実行します。
 *
 * @param array $arr ソート対象の配列
 * @param array &$history ソートの履歴を格納する配列（参照渡し）
 */
function radixSort(array $arr, &$history) {
    // 最大桁数を計算するため、配列の中で最も大きい値を取得
    $max = max($arr);
    // 桁数を表す変数
    $exp = 1;

    // 最大桁数までループ（1の位、10の位、100の位...のように）
    while ($max >= $exp) {
        // 指定された桁ごとにカウントソートを実行
        $arr = countingSortByDigit($arr, $exp, $history);
        // 次の桁へ進む
        $exp *= 10;
    }

    return $arr;
}

/**
 * 各桁ごとのソート処理
 *
 * @param array $arr ソート対象の配列
 * @param int $exp 現在の桁数
 * @param array &$history ソートの履歴を格納する配列
 */
function countingSortByDigit(array $arr, $exp, &$history) {
    // 結果を格納する配列
    $output = array_fill(0, count($arr), 0);
    // 0～9までのカウントを保持する配列
    $count = array_fill(0, 10, 0);

    // 各桁の0～9の出現回数をカウント
    foreach ($arr as $num) {
        // 現在の桁の値を取得
        $digit = intval(($num / $exp) % 10);
        $count[$digit]++;
    }

    // count配列を累積和にすることで、各桁の値が配列内で「どの位置に挿入されるべきか」を決定する
    for ($i = 1; $i < 10; $i++) {
        // 現在のカウントに、前の桁の累積値を加える
        $count[$i] += $count[$i - 1];
    }

    // 累積和を利用して正しい位置に数字を配置
    for ($i = count($arr) - 1; $i >= 0; $i--) {
        // 現在の値から対象の桁を取得
        $digit = intval(($arr[$i] / $exp) % 10);
        // 累積和に基づいて、結果を配列に挿入
        // 同じ数字が複数の場合は挿入位置をずらしていく（後ろから挿入）
        $output[--$count[$digit]] = $arr[$i];
    }

    // 現在のソート状態を履歴に追加
    $history[] = "桁数 (exp): $exp, 現在の状態: [" . implode(', ', $output) . "]";

    return $output;
}
?>
