<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputText = $_POST['text'];
    $sortingOrder = $_POST['sorting_order']; 
    $displayLimit = $_POST['display_limit'];

    $stopWords = ['and', 'in', 'of', 'to', 'a', 'is', 'that', 'it', 'with', 'as', 'for', 'was', 'on', 'at', 'by', 'an'];

    function tokenizeText($text) {
        $words = str_word_count(strtolower($text), 1);
        return $words;
    }
    function calculateWordFrequencies($words, $stopWords) {
        $filteredWords = array_diff($words, $stopWords);
        $wordFrequencies = array_count_values($filteredWords);
        return $wordFrequencies;
    }
    $words = tokenizeText($inputText);
    $wordFrequencies = calculateWordFrequencies($words, $stopWords);

    if ($sortingOrder === 'asc') {
        asort($wordFrequencies);
    } else {
        arsort($wordFrequencies);
    }
    $wordFrequencies = array_slice($wordFrequencies, 0, $displayLimit, true);

    echo '<h2>Word Frequencies</h2>';
    echo '<table>';
    echo '<tr><th>Word</th><th>Frequency</th></tr>';
    foreach ($wordFrequencies as $word => $frequency) {
        echo '<tr><td>' . htmlspecialchars($word) . '</td><td>' . htmlspecialchars($frequency) . '</td></tr>';
    }
    echo '</table>';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <form action="process.php" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" required></textarea><br><br>
        
        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select><br><br>
        
        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="10" min="1"><br><br>
        
        <input type="submit" value="Calculate Word Frequency">
    </form>
</body>
</html>
