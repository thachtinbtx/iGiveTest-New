<?php
// Refactored to use modern Smarty template

$f_resultid = (int)readGetVar('resultid');

// Setup page variables
$g_vars['page']['location'] = array('reports_manager', 'test_results', 'question_details');
$g_vars['page']['header'] = $lngstr['page_header_results_questions'];
$g_vars['page']['can_access'] = false;
$g_vars['page']['can_edit_questions'] = ($G_SESSION['access_questionbank'] > 1);

// Determine if the current user can access this report
if ($G_SESSION['access_reportsmanager'] > 1) {
    $g_vars['page']['can_access'] = true;
} else {
    $g_vars['page']['can_access'] = getRecordCount($srv_settings['table_prefix'].'results', 'userid='.$G_SESSION['userid'].' AND resultid='.$f_resultid) > 0;
}

if (!$g_vars['page']['can_access']) {
    $g_vars['page']['notifications'] = $lngstr['inf_cant_view_this_test_details'];
} else {
    // --- Data Fetching ---

    // Fetch Proctoring/Time Away Data
    $i_time_away = getRecordItem($srv_settings['table_prefix'].'results', 'result_time_away', 'resultid='.$f_resultid);
    if ($i_time_away > 0) {
        $g_vars['page']['time_away'] = $i_time_away;
        $g_vars['page']['time_away_formatted'] = getTimeFormatted($i_time_away);
    }

    // Define table headers
    $i_tablefields = array(
        array("Question", "Question Content", $srv_settings['table_prefix']."results_answers.test_questionid", "hidden md:table-cell"),
        array("Answer Given", "The user's submitted answer", "", "hidden md:table-cell"),
        array("Points", "Points awarded for the answer", $srv_settings['table_prefix']."results_answers.result_answer_points", "hidden md:table-cell text-right"),
        array("Correct?", "Whether the answer was correct", $srv_settings['table_prefix']."results_answers.result_answer_iscorrect", "hidden md:table-cell text-center"),
    );

    // Process sorting options
    $i_order_no = isset($_GET["order"]) ? (int)$_GET["order"] : 0;
    $i_direction = (isset($_GET["direction"]) && $_GET["direction"] == 'DESC') ? "DESC" : "ASC";
    $i_sql_order_addon = ($i_order_no >= 0 && isset($i_tablefields[$i_order_no][2])) ? " ORDER BY ".$i_tablefields[$i_order_no][2]." ".$i_direction : "";

    $g_vars['page']['table_headers'] = array();
    foreach($i_tablefields as $i_fieldno => $i_field) {
        $header = ['text' => $i_field[0], 'class' => $i_field[3], 'sortable' => !empty($i_field[2])];
        if ($header['sortable']) {
            $nextDir = ($i_order_no == $i_fieldno && $i_direction == 'ASC') ? "DESC" : "ASC";
            $header['sort_url'] = 'reports-manager.php?action=viewq&resultid='.$f_resultid.'&order='.$i_fieldno.'&direction='.$nextDir;
            $header['sort_icon'] = ($i_order_no == $i_fieldno) ? ($i_direction == 'ASC' ? '▲' : '▼') : '';
        }
        $g_vars['page']['table_headers'][] = $header;
    }
    
    // Fetch all answer details for the given resultid
    $i_rSet2 = $g_db->Execute("SELECT result_answerid, questionid, test_questionid, result_answer_text, result_answer_points, result_answer_iscorrect FROM ".$srv_settings['table_prefix']."results_answers WHERE resultid=".$f_resultid.$i_sql_order_addon);

    $g_vars['page']['results'] = array();
    if ($i_rSet2) {
        while (!$i_rSet2->EOF) {
            $row = $i_rSet2->fields;
            
            // 1. Get Question Text
            $questionTextFull = getRecordItem($srv_settings['table_prefix'].'questions', 'question_text', 'questionid='.$row['questionid']);
            
            // 2. Get Formatted Answer Text
            $nQuestionType = getRecordItem($srv_settings['table_prefix'].'questions', 'question_type', 'questionid='.$row['questionid']);
            $answerTextFull = '';
            switch($nQuestionType) {
                case QUESTION_TYPE_MULTIPLECHOICE:
                case QUESTION_TYPE_TRUEFALSE:
                case QUESTION_TYPE_MULTIPLEANSWER:
                    $arrAnswerIDs = explode(',', $row['result_answer_text']);
                    $arrRealAnswerText = array();
                    foreach($arrAnswerIDs as $val) {
                        if(is_numeric(trim($val))) {
                           $realText = getRecordItem($srv_settings['table_prefix'].'answers', 'answer_text', 'answerid='.intval($val));
                           if ($realText !== false) $arrRealAnswerText[] = strip_tags($realText);
                        }
                    }
                    $answerTextFull = implode(', ', $arrRealAnswerText);
                    break;
                default:
                    $answerTextFull = $row['result_answer_text'];
                    break;
            }

            // 3. Get Correctness Icon
            $correct_icon = '';
            switch($row['result_answer_iscorrect']) {
                case IGT_ANSWER_IS_CORRECT:
                    $correct_icon = '<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>';
                    break;
                case IGT_ANSWER_IS_PARTIALLYCORRECT:
                    $correct_icon = '<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-600 shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></span>';
                    break;
                case IGT_ANSWER_IS_UNDEFINED:
                     $correct_icon = '<a href="reports-manager.php?action=viewa&answerid='.$row['result_answerid'].'&resultid='.$f_resultid.'" class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></a>';
                    break;
                default: // Incorrect
                    $correct_icon = '<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 text-red-600 shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></span>';
                    break;
            }

            // 4. Add processed data to results array
            $g_vars['page']['results'][] = [
                'question_text_full' => strip_tags($questionTextFull),
                'question_text' => truncateString(strip_tags($questionTextFull), 50),
                'answer_text_full' => strip_tags($answerTextFull),
                'answer_text' => convertTextValue(truncateString($answerTextFull, 50)),
                'points' => $row['result_answer_points'],
                'is_correct_icon' => $correct_icon,
                'view_url' => 'reports-manager.php?action=viewa&answerid='.$row['result_answerid'].'&resultid='.$f_resultid,
                'edit_url' => 'question-bank.php?action=editq&questionid='.$row['questionid']
            ];

            $i_rSet2->MoveNext();
        }
        $i_rSet2->Close();
    }
}

// Pass data to Smarty and display the template
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('reports-manager-details');
?>