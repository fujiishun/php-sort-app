<?php
/**
 * クイックソート関数
 *
 * 基準値を選択し、左側に基準値以下の値、右側に基準値より大きい値を振り分け、分割・統治法でソートを実現します。
 *
 * @param array $arr ソート対象の配列
 * @param array &$history ソートの履歴を格納する配列
 */
function quickSort(array $arr, array &$history): array {
    // 配列が1つ以下ならそのまま返す
    if (count($arr) < 2) return $arr;

    // 一番初めの値を基準値を設定
    $pivot = $arr[0];
    $left = [];
    $right = [];

    // 基準値をもとに配列を分割
    foreach (array_slice($arr, 1) as $value) {
        if ($value <= $pivot) {
            $left[] = $value; // 基準値以下の値は左側（$left）に追加
        } else {
            $right[] = $value; // 基準値より大きい値は右側（$right）に追加
        }
    }

    // 履歴を記録
    $history[] = sprintf(
        "基準値: %s, 左側の値: [%s], 右側の値: [%s]",
        $pivot,
        implode(', ', $left),
        implode(', ', $right)
    );

    // ソート結果を結合する
    return array_merge(quickSort($left, $history), [$pivot], quickSort($right, $history));
}
?>
