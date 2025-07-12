<?php

namespace Apphp\MLKit\NLP\Preprocessors;

/**
 * TextPreprocessor class for NLP text preprocessing operations
 *
 * This class provides methods for common text preprocessing tasks in NLP:
 * - Trimming whitespace
 * - Removing duplicate words/tokens
 */
class TextPreprocessor
{
    /**
     * Trims excess whitespace from text
     *
     * - Removes leading and trailing whitespace
     * - Replaces multiple spaces with a single space
     * - Normalizes line breaks
     *
     * @param string $text The input text to process
     * @return string The processed text with normalized whitespace
     */
    public function trimWhitespace(string $text): string
    {
        // Remove leading and trailing whitespace
        $text = trim($text);

        // Replace multiple spaces with a single space
        $text = preg_replace('/\s+/', ' ', $text);

        return $text;
    }

    /**
     * Removes duplicate words from text
     *
     * @param string $text The input text to process
     * @param bool $caseSensitive Whether comparison should be case-sensitive (default: false)
     * @param bool $withinSentencesOnly Whether to remove duplicates only within individual sentences (default: false)
     * @return string The processed text with duplicates removed
     */
    public function removeDuplicates(string $text, bool $caseSensitive = false, bool $withinSentencesOnly = false): string
    {
        // Trim whitespace first for better processing
        $text = $this->trimWhitespace($text);
        
        if ($withinSentencesOnly) {
            // Split text into sentences
            $sentences = preg_split('/(?<=[.!?])\s+/', $text);
            $processedSentences = [];
            
            foreach ($sentences as $sentence) {
                // Process each sentence individually to remove duplicates
                $processedSentences[] = $this->removeDuplicatesFromString($sentence, $caseSensitive);
            }
            
            // Join sentences back together
            return implode(' ', $processedSentences);
        } else {
            // Process entire text as one unit
            return $this->removeDuplicatesFromString($text, $caseSensitive);
        }
    }
    
    /**
     * Helper method to remove duplicates from a string
     * 
     * @param string $text The input text to process
     * @param bool $caseSensitive Whether comparison should be case-sensitive
     * @return string The processed text with duplicates removed
     */
    private function removeDuplicatesFromString(string $text, bool $caseSensitive): string
    {
        // Split text into words
        $words = explode(' ', $text);
        
        // Track seen words
        $seenWords = [];
        $result = [];
        
        foreach ($words as $word) {
            $compareWord = $caseSensitive ? $word : strtolower($word);
            
            // Only add word if we haven't seen it before
            if (!in_array($compareWord, $seenWords)) {
                $seenWords[] = $compareWord;
                $result[] = $word;
            }
        }
        
        // Join words back into text
        return implode(' ', $result);
    }

    /**
     * Removes duplicate sentences from text
     *
     * @param string $text The input text to process
     * @param bool $caseSensitive Whether comparison should be case-sensitive (default: false)
     * @return string The processed text with duplicate sentences removed
     */
    public function removeDuplicateSentences(string $text, bool $caseSensitive = false): string
    {
        // Split text into sentences (simple split by period, exclamation, question mark)
        $sentences = preg_split('/(?<=[.!?])\s+/', $text);

        // Track seen sentences
        $seenSentences = [];
        $result = [];

        foreach ($sentences as $sentence) {
            $sentence = trim($sentence);
            if (empty($sentence)) {
                continue;
            }

            $compareSentence = $caseSensitive ? $sentence : strtolower($sentence);

            // Only add sentence if we haven't seen it before
            if (!in_array($compareSentence, $seenSentences)) {
                $seenSentences[] = $compareSentence;
                $result[] = $sentence;
            }
        }

        // Join sentences back into text
        return implode(' ', $result);
    }

    /**
     * Process text with multiple preprocessing steps
     *
     * @param string $text The input text to process
     * @param array $options Configuration options for preprocessing
     * @return string The fully processed text
     */
    public function process(string $text, array $options = []): string
    {
        $defaultOptions = [
            'trimWhitespace' => true,
            'removeDuplicateSentences' => false,
            'removeDuplicateWords' => false,
            'caseSensitive' => false,
            'withinSentencesOnly' => false,
        ];

        $options = array_merge($defaultOptions, $options);

        // Apply preprocessing steps based on options
        if ($options['trimWhitespace']) {
            $text = $this->trimWhitespace($text);
        }

        if ($options['removeDuplicateSentences']) {
            $text = $this->removeDuplicateSentences($text, $options['caseSensitive']);
        }

        if ($options['removeDuplicateWords']) {
            $text = $this->removeDuplicates($text, $options['caseSensitive'], $options['withinSentencesOnly']);
        }

        return $text;
    }
}
