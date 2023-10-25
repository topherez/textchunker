<?php

function textChunkerWithOverlap(string $text, int $maxChunkSize, int $contextWindowSize = 0): array
{
  
  $text = preg_replace('/\s+/', ' ', $text);

  if ($text === '') {
      return [];
  }

  $pattern = '/(?<=[.!?])\s+/';
  $sentences = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);

  $chunks = [];
  $currentChunk = '';
  $currentContext = '';
  $nextContext = '';

  $contextWindow = [];
  $contextString = '';
  $queuedContext = '';

  foreach ($sentences as $sentence) {
    $contextWindow[] = $sentence;
  
    if(count($contextWindow) > $contextWindowSize && $contextWindowSize > 0){
      $contextWindow = array_slice($contextWindow, -$contextWindowSize);
    }
  
    $contextString = implode(' ', $contextWindow);
    $queuedContextLength = strlen($queuedContext);
    $sentenceLength = strlen($sentence);
  
    if ($currentChunk === '') {
        $currentChunk = $sentence;
    } elseif (strlen($currentChunk) + $sentenceLength + strlen($currentContext) + 1 <= $maxChunkSize) {
        $currentChunk .= ' ' . $sentence;
        $currentContext = $contextString;
    } else {
        if (count($chunks) == 0) {
            $chunks[] = $currentChunk;
        } else {
            if($contextWindowSize > 0){
              $chunks[] = $nextContext . ' ' . $currentChunk;
            }else{
              $chunks[] = $currentChunk;
            }
        }
  
        $nextContext = $currentContext; // Store the current context for the next chunk
        $currentChunk = $sentence;
        $contextWindow = [];
        $currentContext = $sentence;
      }
    }
  
    // Add the last chunk (if it exists) after the loop
    if (!empty($currentChunk)) {
      if($contextWindowSize > 0){
        $chunks[] = $nextContext . ' ' . $currentChunk;
      }else{
        $chunks[] = $currentChunk;
      }
    }
  
    return $chunks;
  }
?>
