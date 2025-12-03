<?php
// Library for Question Import functionality

// Function to parse the simple format with intelligent answer detection
function parseSimpleFormat($text, $defaultPoints = 1) {
    $questions = [];
    // Normalize newlines
    $text = str_replace(["\r\n", "\r"], "\n", $text);
    
    // Clean up: Remove leading/trailing whitespace and normalize multiple blank lines to double newlines
    $text = trim($text);
    // Replace 3+ consecutive newlines with exactly 2 newlines (question separator)
    $text = preg_replace("/\n{3,}/", "\n\n", $text);
    
    // Split by double newlines (blocks)
    $blocks = explode("\n\n", $text);

    foreach ($blocks as $block) {
        $block = trim($block);
        if (empty($block)) continue;
        
        $lines = explode("\n", $block);
        $lines = array_filter($lines, function($line) { return trim($line) !== ''; });
        
        if (empty($lines)) continue;

        // Re-index array
        $lines = array_values($lines);

        $questionText = trim($lines[0]);
        // Remove "Question:" prefix if present (optional support for legacy style in simple parser)
        if (stripos($questionText, 'Question:') === 0) {
            $questionText = trim(substr($questionText, 9));
        }

        $answers = [];
        $correctAnswerIndex = 0;
        $points = $defaultPoints; // Use default points from parameter
        $type = QUESTION_TYPE_MULTIPLECHOICE; // Default type

        // Process remaining lines
        $answerIndex = 1;
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            
            if (empty($line)) continue; // Skip any remaining blank lines
            
            // Check for metadata lines (optional)
            if (stripos($line, 'Points:') === 0) {
                $points = (int)trim(substr($line, 7));
                continue;
            }
            if (stripos($line, 'Type:') === 0) {
                // Simple type mapping if needed, but defaulting to 1 is safe for now
                continue;
            }

            // Check for correct answer marker (explicit *)
            $isCorrect = false;
            if (strpos($line, '*') === 0) {
                $isCorrect = true;
                $line = trim(substr($line, 1));
            }

            if (!empty($line)) {
                $answers[$answerIndex] = $line;
                if ($isCorrect) {
                    $correctAnswerIndex = $answerIndex;
                }
                $answerIndex++;
            }
        }

        // Intelligent answer detection: If no correct answer was marked with *,
        // try to auto-detect based on context
        if ($correctAnswerIndex == 0 && count($answers) > 0) {
            $correctAnswerIndex = detectCorrectAnswer($questionText, $answers);
        }

        if (!empty($questionText) && !empty($answers)) {
            $questions[] = [
                'text' => $questionText,
                'answers' => $answers,
                'correct' => $correctAnswerIndex,
                'points' => $points,
                'type' => $type
            ];
        }
    }
    return $questions;
}

// Intelligent answer detection helper
function detectCorrectAnswer($question, $answers) {
    // If only 2 answers, check for common true/false patterns
    if (count($answers) == 2) {
        foreach ($answers as $idx => $ans) {
            $ansLower = strtolower(trim($ans));
            // Check if it's a true/false or yes/no question
            if (in_array($ansLower, ['true', 'đúng', 'yes', 'có'])) {
                return $idx;
            }
        }
    }
    
    // For mathematical questions, try to evaluate
    if (preg_match('/[\d\+\-\*\/\=]/', $question)) {
        foreach ($answers as $idx => $ans) {
            if (is_numeric(trim($ans))) {
                // Simple heuristic: first numeric answer might be correct
                // This is a placeholder - real logic would evaluate the math
                return $idx;
            }
        }
    }
    
    // Default: return the first answer if no intelligence works
    return 1;
}

// Function to insert a parsed question
function insertParsedQuestion($qData, $subjectid = null) {
    global $g_db, $srv_settings;
    
    // If subject ID not provided, get the first available subject
    if ($subjectid === null || $subjectid == 0) {
        $subjectid = $g_db->GetOne("SELECT subjectid FROM ".$srv_settings['table_prefix']."subjects ORDER BY subjectid LIMIT 1");
        if (!$subjectid) {
            // If no subjects exist, create a default one
            $g_db->Execute("INSERT INTO ".$srv_settings['table_prefix']."subjects (subject_name, subject_description) VALUES ('Imported Questions', 'Questions imported via bulk import')");
            $subjectid = $g_db->Insert_ID($srv_settings['table_prefix'].'subjects', 'subjectid');
        }
    }
    
    $f_question_text = $g_db->qstr(convertTextAreaHTML(true, $qData['text']), 0);
    
    // Insert Question
    if($g_db->Execute("INSERT INTO ".$srv_settings['table_prefix']."questions (subjectid, question_pre, question_post, question_text, question_solution, question_points, question_type) VALUES(".$subjectid.", '', '', ".$f_question_text.", '', ".(int)$qData['points'].", ".(int)$qData['type'].")")===false) {
        return false;
    }
    $f_questionid = (int)$g_db->Insert_ID($srv_settings['table_prefix'].'questions', 'questionid');

    // Insert Answers with correct column name (answer_percents not answer_percent)
    foreach ($qData['answers'] as $idx => $ansText) {
        $f_answer_text = $g_db->qstr(convertTextAreaHTML(true, $ansText), 0);
        $f_is_correct = ($idx == $qData['correct']) ? 1 : 0;
        $f_percents = ($f_is_correct) ? 100 : 0;
        $f_feedback = $g_db->qstr('', 0);
        
        $g_db->Execute("INSERT INTO ".$srv_settings['table_prefix']."answers (answerid, questionid, answer_text, answer_feedback, answer_correct, answer_percents) VALUES(".$idx.", ".$f_questionid.", ".$f_answer_text.", ".$f_feedback.", ".$f_is_correct.", ".$f_percents.")");
    }
    return true;
}
?>
