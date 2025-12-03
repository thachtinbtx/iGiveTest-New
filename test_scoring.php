<?php
function calculateScore($user_input, $correct_input) {
    // Normalize User Answer: Replace Đ/đ with D, then Uppercase
    // \xc4\x91 is đ, \xc4\x90 is Đ in UTF-8
    $user_ans = str_replace(array("\xc4\x91", "\xc4\x90", 'đ', 'Đ'), 'D', $user_input);
    $user_ans = mb_strtoupper($user_ans, 'UTF-8');
    
    // Normalize Correct Answer
    $correct_ans = str_replace(array("\xc4\x91", "\xc4\x90", 'đ', 'Đ'), 'D', $correct_input);
    $correct_ans = mb_strtoupper($correct_ans, 'UTF-8');

    // Calculate matches for first 4 characters
    $matches = 0;
    for($k=0; $k<4; $k++) {
        // Ensure we have characters to compare
        $u_char = isset($user_ans[$k]) ? $user_ans[$k] : '';
        $c_char = isset($correct_ans[$k]) ? $correct_ans[$k] : '';
        
        if($u_char != '' && $c_char != '' && $u_char == $c_char) {
            $matches++;
        }
    }

    // Calculate points based on matches
    $percent = 0;
    if($matches == 1) $percent = 10;
    elseif($matches == 2) $percent = 25;
    elseif($matches == 3) $percent = 50;
    elseif($matches == 4) $percent = 100;

    return array('matches' => $matches, 'percent' => $percent, 'debug_ans' => $user_ans);
}

// Test Cases
$tests = array(
    array('user' => 'DDDS', 'correct' => 'DDDS', 'expected_percent' => 100),
    array('user' => 'DDDD', 'correct' => 'DDDS', 'expected_percent' => 50), // 3 matches
    array('user' => 'DDSS', 'correct' => 'DDDS', 'expected_percent' => 50), // 3 matches
    array('user' => 'DSDD', 'correct' => 'DDDS', 'expected_percent' => 25), // 2 matches (D, S match 1st and 4th? No. D matches 1st. S matches 3rd? No. D matches 2nd? No.)
                                                                            // DDDS
                                                                            // DSDD
                                                                            // 1: D=D (Match)
                                                                            // 2: S!=D
                                                                            // 3: D!=D (Wait, correct is D) -> D!=D? No, correct is D. User is D. Match.
                                                                            // 4: D!=S
                                                                            // Wait. Correct: DDDS. User: DSDD.
                                                                            // 1: D vs D -> Match
                                                                            // 2: D vs S -> No
                                                                            // 3: D vs D -> Match
                                                                            // 4: S vs D -> No
                                                                            // Total 2 matches -> 25%
    array('user' => 'SSSS', 'correct' => 'DDDS', 'expected_percent' => 10), // 1 match (last S)
    array('user' => 'AAAA', 'correct' => 'DDDS', 'expected_percent' => 0),  // 0 matches
    array('user' => 'đdds', 'correct' => 'DDDS', 'expected_percent' => 100), // Case insensitive + Đ check
    array('user' => 'DD',   'correct' => 'DDDS', 'expected_percent' => 25), // Short input (2 matches)
);

echo "Running Scoring Tests...\n";
foreach($tests as $t) {
    $result = calculateScore($t['user'], $t['correct']);
    $status = ($result['percent'] == $t['expected_percent']) ? "PASS" : "FAIL";
    echo "User: {$t['user']} | Correct: {$t['correct']} | Matches: {$result['matches']} | Percent: {$result['percent']}% | Expected: {$t['expected_percent']}% -> $status\n";
    if ($status == "FAIL") {
        echo "DEBUG: User Hex: " . bin2hex($t['user']) . "\n";
        echo "DEBUG: User Ans: " . $result['debug_ans'] . "\n";
    }
}
?>
