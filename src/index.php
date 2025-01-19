<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ソートアプリケーション</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #0056b3;
        }
        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .result {
            margin-top: 20px;
        }
        .result h2 {
            color: #007BFF;
            font-size: 2em;
            font-weight: bold;
        }
        .result .numbers {
            font-size: 1.8em; /* 数字のサイズを大きく */
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }
        .history {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-top: 10px;
            font-size: 0.9em;
            white-space: pre-wrap; /* 折り返しを有効に */
            text-align: left; /* 左詰め */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>値をソートする</h1>
        <form method="POST">
            <label for="values">値を入力してください（カンマ区切り）:</label>
            <input type="text" id="values" name="values" required>
            <label for="method">ソート方法を選んでください:</label>
            <select id="method" name="method" required>
                <option value="quick">クイックソート</option>
                <option value="radix">ラディックスソート</option>
            </select>
            <button type="submit">ソート実行</button>
        </form>
        <hr>

        <?php
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 入力値を取得
            $values = array_map('trim', explode(',', $_POST['values'])); // 空白を除去
            $method = $_POST['method'];

            $sortHistory = []; // 履歴を保存する配列

            // ソートロジックを読み込む
            if ($method === 'quick') {
                require_once 'quick_sort.php';
                $sorted = quickSort($values, $sortHistory);
                echo "<div class='result'>";
                echo "<h2>ソート結果:</h2>";
                echo "<div class='numbers'>" . implode(', ', $sorted) . "</div>"; // 数字を大きく表示
                echo "<hr>";
                echo "<h3>元の値:</h3>";
                echo "<p>" . implode(', ', $values) . "</p>";
                echo "<hr>";
                echo "<h3>ソートの履歴:</h3>";
                foreach ($sortHistory as $step) {
                    // 履歴内容を日本語化
                    $step = str_replace(['Pivot', 'Left', 'Right'], ['基準値', '左側の値', '右側の値'], $step);
                    echo "<div class='history'>$step</div>";
                }
                echo "</div>";
            } elseif ($method === 'radix') {
                require_once 'radix_sort.php';
                $sorted = radixSort($values, $sortHistory);
                echo "<div class='result'>";
                echo "<h2>ソート結果:</h2>";
                echo "<div class='numbers'>" . implode(', ', $sorted) . "</div>"; // 数字を大きく表示
                echo "<hr>";
                echo "<h3>元の値:</h3>";
                echo "<p>" . implode(', ', $values) . "</p>";
                echo "<hr>";
                echo "<h3>ソートの履歴:</h3>";
                foreach ($sortHistory as $step) {
                    // 履歴内容を日本語化
                    $step = str_replace(['Exp', 'Current state'], ['桁数', '現在の状態'], $step);
                    echo "<div class='history'>$step</div>";
                }
                echo "</div>";
            } else {
                echo "<div class='result'>";
                echo "<h2>エラー: 無効なソート方法が選択されました。</h2>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>
