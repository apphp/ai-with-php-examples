<?php
// Use the TextPreprocessor class
use Apphp\MLKit\NLP\Preprocessors\TextPreprocessor;

/**
 * Example of using TextPreprocessor to remove duplicates and trim whitespace
 */
function demonstrateTextPreprocessing() {
    // Create sample text with duplicate words and excess whitespace
    $sampleText = '  This is   a sample   text with With with duplicate duplicate words   and  excess    whitespace.
    This is a repeated sentence. This is a repeated sentence.  ';

    echo "<b>Original Text:</b>";
    echo '<br>' . htmlspecialchars($sampleText) . '<br><br>';
    echo '----------------------<br><br>';

    // Create an instance of TextPreprocessor
    $preprocessor = new TextPreprocessor();

    // Example 1: Trim whitespace only
    $trimmedText = $preprocessor->trimWhitespace($sampleText);
    echo "<b>After Trimming Whitespace:</b>";
    echo '<br>' . htmlspecialchars($trimmedText) . '<br><br>';

    // Example 2: Remove duplicate words (case-insensitive)
    $noDuplicatesText = $preprocessor->removeDuplicates($sampleText, caseSensitive: false);
    echo "<b>After Removing Duplicate Words (case-insensitive):</b>";
    echo '<br>' . htmlspecialchars($noDuplicatesText) . '<br><br>';

    // Example 3: Remove duplicate words (case-sensitive)
    $noDuplicatesCaseSensitiveText = $preprocessor->removeDuplicates($sampleText, caseSensitive: true);
    echo "<b>After Removing Duplicate Words (case-sensitive):</b>";
    echo '<br>' . htmlspecialchars($noDuplicatesCaseSensitiveText) . '<br><br>';

    // Example 4: Remove duplicate sentences
    $noDuplicateSentencesText = $preprocessor->removeDuplicateSentences($sampleText);
    echo "<b>After Removing Duplicate Sentences:</b>";
    echo '<br>' . htmlspecialchars($noDuplicateSentencesText) . '<br><br>';

    // Example 5: Process with multiple options
    $processedText = $preprocessor->process($sampleText, [
        'trimWhitespace' => true,
        'removeDuplicateSentences' => true,
        'removeDuplicateWords' => true,
        'caseSensitive' => false,
        'withinSentencesOnly' => true
    ]);
    echo "<b>After Full Processing:</b>";
    echo '<br>' . htmlspecialchars($processedText) . '<br><br>';
}

// Call the function to demonstrate text preprocessing
demonstrateTextPreprocessing();
