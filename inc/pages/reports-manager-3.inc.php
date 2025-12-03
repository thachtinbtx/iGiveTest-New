<?php
$g_vars['page']['location'] = array('reports_manager', 'test_results', 'question_details', 'answer_details');
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$f_resultid = (int)readGetVar('resultid');
$f_answerid = (int)readGetVar('answerid');
$g_vars['page']['selected_section'] = 'reportsmanager';
$g_vars['page']['selected_tab'] = 'reportsmanager-3';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);
 
$i_can_access = false;
if($G_SESSION['access_reportsmanager'] > 1) {
	$i_can_access = true;
} else {
 
	$i_rSet1 = $g_db->Execute("SELECT resultid FROM ".$srv_settings['table_prefix']."results WHERE userid=".$G_SESSION['userid']." AND resultid=".$f_resultid);
if(!$i_rSet1) {
 showDBError(__FILE__, 1);
} else {
 $i_can_access = $i_rSet1->RecordCount() > 0;
}
}
if(!$i_can_access)
 $g_vars['page']['notifications'] = $lngstr['inf_cant_view_this_test_details'];
writeErrorsWarningsBar();
if($i_can_access) {
 
	$i_testid = 0;
$i_rSet2 = $g_db->Execute("SELECT testid FROM ".$srv_settings['table_prefix']."results WHERE resultid=".$f_resultid);
if(!$i_rSet2) {
 showDBError(__FILE__, 2);
} else {
 if(!$i_rSet2->EOF) {
 $i_testid = $i_rSet2->fields["testid"];
}
$i_rSet2->Close();
}
 
	$i_questionid = 0;
$i_rSet3 = $g_db->Execute("SELECT questionid, result_answer_text, result_answer_points, result_answer_iscorrect, result_answer_feedback FROM ".$srv_settings['table_prefix']."results_answers WHERE resultid=".$f_resultid." AND result_answerid=".$f_answerid);
if(!$i_rSet3) {
 showDBError(__FILE__, 3);
} else {
 if(!$i_rSet3->EOF) {
 $i_questionid = (int)$i_rSet3->fields["questionid"];
$i_result_answer_text = $i_rSet3->fields["result_answer_text"];
$i_result_answer_points = $i_rSet3->fields["result_answer_points"];
$i_result_answer_iscorrect = $i_rSet3->fields["result_answer_iscorrect"];
$i_result_answer_feedback = $i_rSet3->fields["result_answer_feedback"];
}
$i_rSet3->Close();
}
 
    $i_rSet4 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."questions WHERE questionid=".$i_questionid);
    if(!$i_rSet4) {
        showDBError(__FILE__, 4);
    } else {
        if(!$i_rSet4->EOF) {
            $i_questiontext = $i_rSet4->fields["question_text"];
            $i_questiontype = $i_rSet4->fields["question_type"];
            $i_questionpoints = $i_rSet4->fields["question_points"];
        } else {
            // Question deleted
            $i_questiontext = '<span class="text-red-500 italic">['.$lngstr['inf_question_deleted'].']</span>';
            $i_questiontype = -1; // Unknown type
            $i_questionpoints = 0;
        }
        $i_rSet4->Close();
    }

    
    // Correct Answer Block
    echo '<div class="neu-card p-6 mb-6 border border-white/60 shadow-lg">';
    echo '<h2 class="text-xl font-bold text-emerald-600 mb-4 flex items-center gap-2">';
    echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
    echo $lngstr['page_reportsmanager']['correct_answer'];
    echo '</h2>';
    
    echo '<div class="mb-4 text-lg font-medium text-slate-800">'.$i_questiontext.'</div>';
    
    echo '<div class="space-y-2">';
	$i_answers = array();
    $i_rSet5 = $g_db->Execute("SELECT answer_text, answer_correct FROM ".$srv_settings['table_prefix']."answers WHERE questionid=".$i_questionid." ORDER BY answerid");
    if(!$i_rSet5) {
        showDBError(__FILE__, 5);
    } else {
        $i_answerno = 1;
        while(!$i_rSet5->EOF) {
            $i_answers[$i_answerno] = $i_rSet5->fields["answer_text"];
            $i_answers_correct[$i_answerno] = $i_rSet5->fields["answer_correct"];
            $i_answerno++;
            $i_rSet5->MoveNext();
        }
        $i_rSet5->Close();
    }
    
    for($i=1;$i<$i_answerno;$i++) {
        $isCorrect = $i_answers_correct[$i];
        $bgClass = $isCorrect ? 'bg-emerald-50 border-emerald-200' : 'bg-slate-50 border-slate-100';
        $textClass = $isCorrect ? 'text-emerald-800 font-semibold' : 'text-slate-600';
        $icon = $isCorrect ? '<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' : '<div class="w-5 h-5 rounded-full border-2 border-slate-300"></div>';
        
        echo '<div class="flex items-start gap-3 p-3 rounded-lg border '.$bgClass.'">';
        echo '<div class="mt-0.5 flex-shrink-0">'.$icon.'</div>';
        echo '<div class="'.$textClass.'">'.$i_answers[$i].'</div>';
        echo '</div>';
    }
    echo '</div>'; // End space-y-2
    echo '</div>'; // End neu-card

    // Your Answer Block
    echo '<div class="neu-card p-6 mb-6 border border-white/60 shadow-lg">';
    echo '<h2 class="text-xl font-bold text-indigo-600 mb-4 flex items-center gap-2">';
    echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>';
    echo $lngstr['page_reportsmanager']['your_answer'];
    echo '</h2>';
    
    echo '<div class="space-y-2">';
    switch($i_questiontype) {
        case QUESTION_TYPE_MULTIPLECHOICE:
        case QUESTION_TYPE_TRUEFALSE:
            $i_answers_given = (int)$i_result_answer_text;
            $isCorrect = $i_answers_correct[$i_answers_given];
            $bgClass = $isCorrect ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200';
            $icon = $isCorrect ? '<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' : '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            
            echo '<div class="flex items-start gap-3 p-3 rounded-lg border '.$bgClass.'">';
            echo '<div class="mt-0.5 flex-shrink-0">'.$icon.'</div>';
            echo '<div class="text-slate-800 font-medium">'.(isset($i_answers[$i_answers_given]) ? $i_answers[$i_answers_given] : $i_result_answer_text).'</div>';
            echo '</div>';
            break;
            
        case QUESTION_TYPE_MULTIPLEANSWER:
            $i_answers_given = explode(QUESTION_TYPE_MULTIPLEANSWER_BREAK, $i_result_answer_text);
            foreach($i_answers_given as $i_answer_given) {
                $isCorrect = $i_answers_correct[$i_answer_given];
                $bgClass = $isCorrect ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200';
                $icon = $isCorrect ? '<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' : '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                
                echo '<div class="flex items-start gap-3 p-3 rounded-lg border '.$bgClass.'">';
                echo '<div class="mt-0.5 flex-shrink-0">'.$icon.'</div>';
                echo '<div class="text-slate-800 font-medium">'.(isset($i_answers[$i_answer_given]) ? $i_answers[$i_answer_given] : $i_answer_given).'</div>';
                echo '</div>';
            }
            break;
            
        case QUESTION_TYPE_FILLINTHEBLANK:
        case QUESTION_TYPE_ESSAY:
        default:
            echo '<div class="p-4 bg-slate-50 rounded-lg border border-slate-200 text-slate-800 font-mono text-sm whitespace-pre-wrap">';
            echo nl2br($i_result_answer_text);
            echo '</div>';
            break;
    }
    
    if($G_SESSION['access_reportsmanager'] > 2 && $i_questiontype == QUESTION_TYPE_ESSAY) {
        echo '<div class="mt-6 pt-6 border-t border-slate-200">';
        echo '<form method=post action="reports-manager.php?resultid='.$f_resultid.'&answerid='.$f_answerid.'&action=setpoints" class="space-y-4">';
        
        echo '<div>';
        echo '<label class="block text-sm font-bold text-slate-700 mb-1">'.$lngstr['page_editquestion_points'].'</label>';
        echo '<input type="text" name="points" value="'.$i_result_answer_points.'" class="neu-input w-24" size="3">';
        echo '</div>';
        
        echo '<div>';
        echo '<label class="block text-sm font-bold text-slate-700 mb-1">'.$lngstr['page_reportsmanager']['answerfeedback'].'</label>';
        echo '<textarea name="feedback" class="neu-input w-full h-24">'.$i_result_answer_feedback.'</textarea>';
        echo '</div>';
        
        echo '<input class="neu-btn-primary px-6 py-2" type=submit name=bsubmit value=" '.$lngstr['button_set'].' ">';
        echo '</form>';
        echo '</div>';
    } elseif (!empty($i_result_answer_feedback)) {
        echo '<div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100 text-blue-800">';
        echo '<div class="font-bold text-xs uppercase tracking-wider mb-1 text-blue-500">Feedback</div>';
        echo nl2br($i_result_answer_feedback);
        echo '</div>';
    }
    
    echo '</div>'; // End space-y-2
    echo '</div>'; // End neu-card
}
displayTemplate('_footer');
?>
