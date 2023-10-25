A PHP utility function for splitting up text by sentence with an optional rolling context window

# Use cases
This utility function was built as while building an AI summarization tool. Whether you're using a "Refine" or "Map reduce" approach to summarizing large texts, you'll need to split text into chunks that are coherent (not breaking mid-sentence). TextChunker breaks text up by sentence, storing them in an array, and then re-composes based on the parameters you pass in. TextChunker is also able to keep a "context window" that allows you to throttle how much context from the previous chunk of text you'd like to include in the next prompt.

# Example:
$splitTextArray = textChunker($episodeTranscript, 8000, 2);

# Parameters
 - text: the string (multiple sentences) you'd like to split
 - maxCharacters: the total number of characters each "chunk" should include
 - contextWindowSize: the number of sentences from the end of the last chunk to be added to the beginning of the next chunk
