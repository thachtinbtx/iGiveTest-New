<?php
$g_vars['page']['location'] = array('test_manager', 'test_manager', 'test_questions');
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$f_testid = (int)readGetVar('testid');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'editquestions';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);

// Floating orbs for scientific feel
echo '<div class="fixed -top-32 right-1/4 w-64 h-64 bg-gradient-radial from-pastel-mint/15 to-transparent rounded-full blur-3xl floating pointer-events-none"></div>';
echo '<div class="fixed bottom-1/4 -left-32 w-64 h-64 bg-gradient-radial from-pastel-lavender/15 to-transparent rounded-full blur-3xl floating-slow pointer-events-none"></div>';

// Modern header with glassmorphic card  
echo '<div class="glass-panel-strong rounded-2xl shadow-neumorphic p-6 mb-6 relative z-10">';
echo '<div class="flex items-center gap-4">';
echo '<div class="bg-pastel-mint/20 rounded-2xl p-3 shadow-neumorphic-sm">';
echo '<svg class="w-8 h-8 text-pastel-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>';
echo '</div>';
echo '<div>';
echo '<h2 class="text-3xl font-bold text-pastel-mint tracking-tight">'.$lngstr['page_header_test_questions'].'</h2>';
echo '<p class="text-slate-600 mt-1">'.$lngstr['tooltip_tests_questions'].'</p>';
echo '</div>';
echo '</div>';
echo '</div>';
writeErrorsWarningsBar();
$i_pagewide_id = 0;
  
$i_subjectid_addon = '';
$i_sql_where_addon = '';
if(isset($_GET['subjectid']) && $_GET['subjectid'] != '') {
	$i_subjectid_addon .= '&subjectid='.(int)$_GET['subjectid'];
$i_sql_where_addon .= $srv_settings['table_prefix'].'questions.subjectid='.(int)$_GET['subjectid'].' AND ';
}
 
$i_direction = '';
$i_order_addon = '';
$i_sql_order_addon = '';
$i_tablefields = array(
	array($lngstr['label_editquestions_hdr_test_questionid'], $lngstr['label_editquestions_hdr_test_questionid_hint'], $srv_settings['table_prefix'].'tests_questions.test_questionid'),
	array($lngstr['label_editquestions_hdr_questionid'], $lngstr['label_editquestions_hdr_questionid_hint'], $srv_settings['table_prefix'].'questions.questionid'),
	array($lngstr['label_editquestions_hdr_subjectid'], $lngstr['label_editquestions_hdr_subjectid_hint'], $srv_settings['table_prefix'].'questions.subjectid'),
	array($lngstr['label_editquestions_hdr_question_text'], $lngstr['label_editquestions_hdr_question_text_hint'], ''),
	array($lngstr['label_editquestions_hdr_question_type'], $lngstr['label_editquestions_hdr_question_type_hint'], $srv_settings['table_prefix'].'questions.question_type'),
	array($lngstr['label_editquestions_hdr_question_points'], $lngstr['label_editquestions_hdr_question_points_hint'], $srv_settings['table_prefix'].'questions.question_points'),
  
);
$i_order_no = isset($_GET['order']) ? (int)$_GET['order'] : 0;
if($i_order_no>=count($i_tablefields))
 $i_order_no = -1;
if($i_order_no>=0) {
	$i_direction = (isset($_GET['direction']) && $_GET['direction']) ? 'DESC' : '';
$i_order_addon = '&order='.$i_order_no.'&direction='.$i_direction;
$i_sql_order_addon = ' ORDER BY '.$i_tablefields[$i_order_no][2].' '.$i_direction;
}
 
$i_url_limitto_addon = '';
$i_url_pageno_addon = '';
$i_url_limit_addon = '';
$i_pageno = 0;
$i_limitcount = isset($_GET['limitto']) ? (int)$_GET['limitto'] : $G_SESSION['config_itemsperpage'];
if($i_limitcount>0) {
	$i_recordcount = getRecordCount($srv_settings['table_prefix'].'tests_questions, '.$srv_settings['table_prefix'].'questions', $i_sql_where_addon."".$srv_settings['table_prefix']."tests_questions.testid=".$f_testid." AND ".$srv_settings['table_prefix']."tests_questions.questionid=".$srv_settings['table_prefix']."questions.questionid");
$i_pageno = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
if($i_pageno < 1)
 $i_pageno = 1;
$i_limitfrom = ($i_pageno-1)*$i_limitcount;
$i_pageno_count = floor(($i_recordcount - 1) / $i_limitcount) + 1;
if($i_limitfrom > $i_recordcount) {
 $i_pageno = $i_pageno_count;
$i_limitfrom = ($i_pageno-1)*$i_limitcount;
}
$i_url_limitto_addon .= '&limitto='.$i_limitcount;
$i_url_pageno_addon .= '&pageno='.$i_pageno;
$i_url_limit_addon .= $i_url_limitto_addon.$i_url_pageno_addon;
} else {
	$i_url_limitto_addon = '&limitto=';
$i_url_limit_addon .= $i_url_limitto_addon;
$i_limitfrom = -1;
$i_limitcount = -1;
}
 
$i_2_subjectid_addon = '';
$i_2_sql_where_addon = '';
if(isset($_GET['subjectid2']) && $_GET['subjectid2'] != '') {
	$i_2_subjectid_addon .= '&subjectid2='.(int)$_GET['subjectid2'];
$i_2_sql_where_addon .= $srv_settings['table_prefix'].'questions.subjectid='.(int)$_GET['subjectid2'].' AND ';
}
 
$i_2_direction = '';
$i_2_order_addon = '';
$i_2_sql_order_addon = '';
$i_2_tablefields = array(
	array($lngstr['label_editquestions_hdr_questionid'], $lngstr['label_editquestions_hdr_questionid_hint'], $srv_settings['table_prefix'].'questions.questionid'),
	array($lngstr['label_editquestions_hdr_subjectid'], $lngstr['label_editquestions_hdr_subjectid_hint'], $srv_settings['table_prefix'].'questions.subjectid'),
	array($lngstr['label_editquestions_hdr_question_text'], $lngstr['label_editquestions_hdr_question_text_hint'], ''),
	array($lngstr['label_editquestions_hdr_question_type'], $lngstr['label_editquestions_hdr_question_type_hint'], $srv_settings['table_prefix'].'questions.question_type'),
	array($lngstr['label_editquestions_hdr_question_points'], $lngstr['label_editquestions_hdr_question_points_hint'], $srv_settings['table_prefix'].'questions.question_points'),
);
$i_2_order_no = isset($_GET['order2']) ? (int)$_GET['order2'] : 0;
if($i_2_order_no>=count($i_2_tablefields))
 $i_2_order_no = -1;
if($i_2_order_no>=0) {
	$i_2_direction = (isset($_GET['direction2']) && $_GET['direction2']) ? 'DESC' : '';
$i_2_order_addon = '&order2='.$i_2_order_no.'&direction2='.$i_2_direction;
$i_2_sql_order_addon = ' ORDER BY '.$i_2_tablefields[$i_2_order_no][2].' '.$i_2_direction;
}
 
$i_2_url_limitto_addon = '';
$i_2_url_pageno_addon = '';
$i_2_url_limit_addon = '';
$i_2_pageno = 0;
$i_2_limitcount = isset($_GET['limitto2']) ? (int)$_GET['limitto2'] : $G_SESSION['config_itemsperpage'];
if($i_2_limitcount>0) {
	$i_2_recordcount = 0;
$i_2_recordcount = getRecordCount($srv_settings['table_prefix'].'questions', $i_2_sql_where_addon.'1=1');
$i_2_pageno = isset($_GET['pageno2']) ? (int)$_GET['pageno2'] : 1;
if($i_2_pageno < 1)
 $i_2_pageno = 1;
$i_2_limitfrom = ($i_2_pageno-1)*$i_2_limitcount;
$i_2_pageno_count = floor(($i_2_recordcount - 1) / $i_2_limitcount) + 1;
if($i_2_limitfrom > $i_2_recordcount) {
 $i_2_pageno = $i_2_pageno_count;
$i_2_limitfrom = ($i_2_pageno-1)*$i_2_limitcount;
}
$i_2_url_limitto_addon .= '&limitto2='.$i_2_limitcount;
$i_2_url_pageno_addon .= '&pageno2='.$i_2_pageno;
$i_2_url_limit_addon .= $i_2_url_limitto_addon.$i_2_url_pageno_addon;
} else {
	$i_2_url_limitto_addon = '&limitto2=';
$i_2_url_limit_addon .= $i_2_url_limitto_addon;
$i_2_limitfrom = -1;
$i_2_limitcount = -1;
}
 
echo '<form name=qlinksForm class=iactive method=post>';
// Glassmorphic Toolbar
echo '<div class="glass-panel rounded-2xl shadow-neumorphic-sm p-4 mb-6 flex flex-wrap items-center justify-between gap-4 relative z-10">';
echo '<div class="flex items-center gap-3">';
// Add Question Button
echo '<a href="question-bank.php?testid='.$f_testid.'&action=createq" class="btn-neumorphic p-2 text-pastel-sky hover:text-blue-600 transition-colors" title="'.$lngstr['label_action_create_and_add_question'].'">';
echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';
echo '</a>';

// Delete Button
echo '<button type="button" class="btn-neumorphic p-2 text-pastel-salmon hover:text-red-600 transition-colors" title="'.$lngstr['label_action_question_links_delete'].'" onclick="f=document.qlinksForm;if (confirm(\''.$lngstr['qst_delete_question_links'].'\')) { f.action=\'test-manager.php?testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=deleteq&confirmed=1\';f.submit();}">';
echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
echo '</button>';
echo '<div class="w-px h-8 bg-slate-200 mx-2"></div>';
// Subject Select
echo '<div class="relative">';
echo '<select name=subjectid class="input-neumorphic pr-8" onchange="document.location.href=\'test-manager.php?testid='.$f_testid.'&subjectid=\'+this.value+\''.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=editt\';">';
echo '<option value=""></option>';
$i_rSet2 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."subjects");
if(!$i_rSet2) {
	showDBError(__FILE__, 2);
} else {
	while(!$i_rSet2->EOF) {
 echo '<option value='.$i_rSet2->fields['subjectid'];
if(isset($_GET['subjectid']) && ($_GET['subjectid']==$i_rSet2->fields['subjectid']))
 echo ' selected=selected';
echo '>'.convertTextValue($i_rSet2->fields['subject_name']).'</option>'."\n";
$i_rSet2->MoveNext();
}
$i_rSet2->Close();
}
echo '</select>';
echo '</div>';
echo '</div>';
if($i_limitcount > 0) {
 echo '<div class="flex items-center gap-2">';
	if($i_pageno > 1) {
 echo '<a href="test-manager.php?action=editt&pageno=1&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limitto_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-pastel-cadet transition-colors" title="'.$lngstr['button_first_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></a>';
echo '<a href="test-manager.php?action=editt&pageno='.max(($i_pageno-1), 1).'&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limitto_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-pastel-cadet transition-colors" title="'.$lngstr['button_prev_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>';
} else {
 echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></button>';
echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>';
}
if($i_pageno < $i_pageno_count) {
 echo '<a href="test-manager.php?action=editt&pageno='.min(($i_pageno+1), $i_pageno_count).'&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limitto_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-pastel-cadet transition-colors" title="'.$lngstr['button_next_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>';
echo '<a href="test-manager.php?action=editt&pageno='.$i_pageno_count.'&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limitto_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-pastel-cadet transition-colors" title="'.$lngstr['button_last_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></a>';
} else {
 echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>';
echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></button>';
}
echo '</div>';
}
echo '</div>'; // End glassmorphic toolbar

// Glassmorphic Table
echo '<div class="glass-panel rounded-2xl shadow-neumorphic-sm overflow-hidden mb-8">';
echo '<div class="overflow-x-auto">';
echo '<table class="w-full text-left border-collapse">';
echo '<thead><tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider">';
echo '<th class="p-3 w-12 text-center"><input type=checkbox name=toggleAll onclick="toggleCBs(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></th>';
// Manual Headers for Test Questions
echo '<th class="p-3 w-20 text-right font-semibold">'.$lngstr['label_editquestions_hdr_test_questionid'].'</th>';
echo '<th class="p-3 w-20 text-right font-semibold">'.$lngstr['label_editquestions_hdr_questionid'].'</th>';
echo '<th class="p-3 w-32 font-semibold">'.$lngstr['label_editquestions_hdr_subjectid'].'</th>';
echo '<th class="p-3 font-semibold">'.$lngstr['label_editquestions_hdr_question_text'].'</th>';
echo '<th class="p-3 w-64 font-semibold text-green-600">Correct Answer</th>'; // New Column
echo '<th class="p-3 w-32 font-semibold">'.$lngstr['label_editquestions_hdr_question_type'].'</th>';
echo '<th class="p-3 w-20 text-right font-semibold">'.$lngstr['label_editquestions_hdr_question_points'].'</th>';
echo '<th class="p-3 w-32 text-center font-semibold">'.$lngstr['label_hdr_action'].'</th></tr></thead><tbody class="divide-y divide-slate-200">';

$i_questionids_in_the_test = array();
// Updated SQL with subquery for correct answers
$i_rSet1 = $g_db->SelectLimit("SELECT ".$srv_settings['table_prefix']."tests_questions.test_questionid, ".$srv_settings['table_prefix']."tests_questions.questionid, ".$srv_settings['table_prefix']."tests_questions.test_sectionid, ".$srv_settings['table_prefix']."questions.subjectid, ".$srv_settings['table_prefix']."questions.question_text, ".$srv_settings['table_prefix']."questions.question_time, ".$srv_settings['table_prefix']."questions.question_type, ".$srv_settings['table_prefix']."questions.question_points, ".$srv_settings['table_prefix']."subjects.subject_name, (SELECT GROUP_CONCAT(answer_text SEPARATOR '<br>') FROM ".$srv_settings['table_prefix']."answers WHERE ".$srv_settings['table_prefix']."answers.questionid = ".$srv_settings['table_prefix']."questions.questionid AND ".$srv_settings['table_prefix']."answers.answer_correct = 1) as correct_answers FROM ".$srv_settings['table_prefix']."tests_questions, ".$srv_settings['table_prefix']."questions, ".$srv_settings['table_prefix']."subjects WHERE ".$i_sql_where_addon."".$srv_settings['table_prefix']."tests_questions.testid=".$f_testid." AND ".$srv_settings['table_prefix']."tests_questions.questionid=".$srv_settings['table_prefix']."questions.questionid AND ".$srv_settings['table_prefix']."questions.subjectid=".$srv_settings['table_prefix']."subjects.subjectid".$i_sql_order_addon, $i_limitcount, $i_limitfrom);

if(!$i_rSet1) {
	showDBError(__FILE__, 1);
} else {
	$i_counter = 0;
while(!$i_rSet1->EOF) {
 $rowname = ($i_counter % 2) ? 'rowone' : 'rowtwo';
array_push($i_questionids_in_the_test, $i_rSet1->fields['questionid']);
echo '<tr class="hover:bg-slate-50 transition-colors duration-200 group">';
echo '<td class="p-3 text-center"><input id=cb_'.$i_pagewide_id.' type=checkbox name=box_qlinks[] value="'.$i_rSet1->fields['test_questionid'].'" onclick="toggleCB(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></td>';
echo '<td class="p-3 text-right text-slate-400 font-mono text-xs">#'.$i_rSet1->fields['test_questionid'].'</td>';
echo '<td class="p-3 text-right text-slate-400 font-mono text-xs">#'.$i_rSet1->fields['questionid'].'</td>';
echo '<td class="p-3"><a href="test-manager.php?testid='.$f_testid.(isset($_GET['subjectid']) && $_GET['subjectid'] != '' ? '' : '&subjectid='.$i_rSet1->fields['subjectid']).$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=editt" class="text-indigo-600 text-sm font-medium hover:text-indigo-800 transition-colors">'.convertTextValue($i_rSet1->fields['subject_name']).'</a></td>';
echo '<td class="p-3 text-slate-600 text-sm leading-relaxed">'.getTruncatedHTML($i_rSet1->fields['question_text']).'</td>';
echo '<td class="p-3 text-green-700 text-sm bg-green-50/50 border-l border-green-100">'.($i_rSet1->fields["correct_answers"] ? $i_rSet1->fields["correct_answers"] : '<span class="text-slate-300 italic">None</span>').'</td>'; // Correct Answer Data
echo '<td class="p-3"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">';
switch ($i_rSet1->fields['question_type']) {
 case QUESTION_TYPE_MULTIPLECHOICE:
 echo $lngstr['label_atype_multiple_choice'];
break;
case QUESTION_TYPE_TRUEFALSE:
 echo $lngstr['label_atype_truefalse'];
break;
case QUESTION_TYPE_MULTIPLEANSWER:
 echo $lngstr['label_atype_multiple_answer'];
break;
case QUESTION_TYPE_FILLINTHEBLANK:
 echo $lngstr['label_atype_fillintheblank'];
break;
case QUESTION_TYPE_ESSAY:
 echo $lngstr['label_atype_essay'];
break;
case QUESTION_TYPE_RANDOM:
 echo $lngstr['label_atype_random'];
break;
}
echo '</span></td>';
echo '<td class="p-3 text-right font-bold text-slate-700 text-sm">'.(($i_rSet1->fields['question_type']<>QUESTION_TYPE_RANDOM) ? $i_rSet1->fields['question_points'] : '').'</td>';
  
 echo '<td class="p-3"><div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">';
// Edit Button
echo '<a href="question-bank.php?testid='.$f_testid.'&questionid='.$i_rSet1->fields['questionid'].'&action=editq" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="'.$lngstr['label_action_question_edit'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>';
// Move Up/Down Buttons
echo '<div class="flex flex-col">';
echo '<a href="test-manager.php?testid='.$f_testid.'&test_questionid='.$i_rSet1->fields['test_questionid'].$i_subjectid_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=moveup" class="p-0.5 text-slate-400 hover:text-indigo-600 transition-colors" title="'.$lngstr['label_action_question_moveup'].'"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></a>';
echo '<a href="test-manager.php?testid='.$f_testid.'&test_questionid='.$i_rSet1->fields['test_questionid'].$i_subjectid_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=movedown" class="p-0.5 text-slate-400 hover:text-indigo-600 transition-colors" title="'.$lngstr['label_action_question_movedown'].'"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></a>';
echo '</div>';
// Delete Button
echo '<a href="test-manager.php?testid='.$f_testid.'&test_questionid='.$i_rSet1->fields['test_questionid'].$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=deleteq" onclick="return confirmMessage(this, \''.$lngstr['qst_delete_question_link'].'\')" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="'.$lngstr['label_action_question_link_delete'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>';
echo '</div></td></tr>';
$i_counter++;
$i_pagewide_id++;
$i_rSet1->MoveNext();
}
$i_rSet1->Close();
}
echo '</tbody></table>';
echo '</div></div></form>';
 
// Second Section Header
echo '<div class="flex items-center gap-3 mb-4 mt-12">';
echo '<div class="bg-indigo-100 rounded-xl p-2">';
echo '<svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>';
echo '</div>';
echo '<h2 class="text-2xl font-bold text-slate-700 tracking-tight">'.$lngstr['page_header_questionbank'].'</h2>';
echo '</div>';

echo '<form name=qbankForm class=iactive method=post>';
// Glassmorphic Toolbar 2
echo '<div class="glass-panel rounded-2xl shadow-neumorphic-sm p-4 mb-6 flex flex-wrap items-center justify-between gap-4 relative z-10">';
echo '<div class="flex items-center gap-3">';
// Create Question Button
echo '<a href="question-bank.php?action=createq" class="btn-neumorphic p-2 text-indigo-600 hover:text-indigo-800 transition-colors" title="'.$lngstr['label_action_create_question'].'">';
echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';
echo '</a>';
// Append Button
echo '<button type="button" class="btn-neumorphic p-2 text-emerald-600 hover:text-emerald-800 transition-colors" title="'.$lngstr['label_action_questions_append'].'" onclick="f=document.qbankForm;f.action=\'test-manager.php?testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=append\';f.submit();">';
echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
echo '</button>';
// Delete Button
echo '<button type="button" class="btn-neumorphic p-2 text-red-500 hover:text-red-700 transition-colors" title="'.$lngstr['label_action_questions_delete'].'" onclick="f=document.qbankForm;if (confirm(\''.$lngstr['qst_delete_questions'].'\')) { f.action=\'question-bank.php?testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=deleteq&confirmed=1\';f.submit();}">';
echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
echo '</button>';
echo '<div class="w-px h-8 bg-slate-200 mx-2"></div>';
// Subject Select
echo '<div class="relative">';
echo '<select name=subjectid2 class="input-neumorphic pr-8" onchange="document.location.href=\'test-manager.php?testid='.$f_testid.'&subjectid2=\'+this.value+\''.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=editt\';">';
echo '<option value=""></option>';
$i_rSet2 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."subjects");
if(!$i_rSet2) {
	showDBError(__FILE__, 2);
} else {
	while(!$i_rSet2->EOF) {
 echo '<option value='.$i_rSet2->fields['subjectid'];
if(isset($_GET['subjectid2']) && ($_GET['subjectid2']==$i_rSet2->fields['subjectid']))
 echo ' selected=selected';
echo '>'.convertTextValue($i_rSet2->fields['subject_name']).'</option>'."\n";
$i_rSet2->MoveNext();
}
$i_rSet2->Close();
}
echo '</select>';
echo '</div>';
echo '</div>';
if($i_2_limitcount > 0) {
 echo '<div class="flex items-center gap-2">';
	if($i_2_pageno > 1) {
 echo '<a href="test-manager.php?action=editt&pageno2=1&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limitto_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-indigo-600 transition-colors" title="'.$lngstr['button_first_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></a>';
echo '<a href="test-manager.php?action=editt&pageno2='.max(($i_2_pageno-1), 1).'&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limitto_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-indigo-600 transition-colors" title="'.$lngstr['button_prev_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>';
} else {
 echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></button>';
echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>';
}
if($i_2_pageno < $i_2_pageno_count) {
 echo '<a href="test-manager.php?action=editt&pageno2='.min(($i_2_pageno+1), $i_2_pageno_count).'&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limitto_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-indigo-600 transition-colors" title="'.$lngstr['button_next_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>';
echo '<a href="test-manager.php?action=editt&pageno2='.$i_2_pageno_count.'&testid='.$f_testid.$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limitto_addon.'" class="btn-neumorphic p-2 text-slate-500 hover:text-indigo-600 transition-colors" title="'.$lngstr['button_last_page'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></a>';
} else {
 echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>';
echo '<button disabled class="btn-neumorphic p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></button>';
}
}
echo '</div>'; // End glassmorphic toolbar 2

echo '<div class="glass-panel rounded-2xl shadow-neumorphic-sm overflow-hidden mb-8">';
echo '<div class="overflow-x-auto">';
echo '<table class="w-full text-left border-collapse">';
echo '<thead><tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider">';
echo '<th class="p-3 w-12 text-center"><input type=checkbox name=toggleAll onclick="toggleCBs(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></th>';
// Manual Headers for Question Bank
echo '<th class="p-3 w-20 text-right font-semibold">'.$lngstr['label_editquestions_hdr_questionid'].'</th>';
echo '<th class="p-3 w-32 font-semibold">'.$lngstr['label_editquestions_hdr_subjectid'].'</th>';
echo '<th class="p-3 font-semibold">'.$lngstr['label_editquestions_hdr_question_text'].'</th>';
echo '<th class="p-3 w-64 font-semibold text-green-600">Correct Answer</th>'; // New Column
echo '<th class="p-3 w-32 font-semibold">'.$lngstr['label_editquestions_hdr_question_type'].'</th>';
echo '<th class="p-3 w-20 text-right font-semibold">'.$lngstr['label_editquestions_hdr_question_points'].'</th>';
echo '<th class="p-3 w-32 text-center font-semibold">'.$lngstr['label_hdr_action'].'</th></tr></thead><tbody class="divide-y divide-slate-200">';

// Updated SQL with subquery for correct answers
$i_rSet2 = $g_db->SelectLimit("SELECT ".$srv_settings['table_prefix']."questions.questionid, ".$srv_settings['table_prefix']."questions.subjectid, ".$srv_settings['table_prefix']."questions.question_text, ".$srv_settings['table_prefix']."questions.question_time, ".$srv_settings['table_prefix']."questions.question_type, ".$srv_settings['table_prefix']."questions.question_points, ".$srv_settings['table_prefix']."subjects.subject_name, (SELECT GROUP_CONCAT(answer_text SEPARATOR '<br>') FROM ".$srv_settings['table_prefix']."answers WHERE ".$srv_settings['table_prefix']."answers.questionid = ".$srv_settings['table_prefix']."questions.questionid AND ".$srv_settings['table_prefix']."answers.answer_correct = 1) as correct_answers FROM ".$srv_settings['table_prefix']."questions, ".$srv_settings['table_prefix']."subjects WHERE ".$i_2_sql_where_addon."".$srv_settings['table_prefix']."questions.subjectid=".$srv_settings['table_prefix']."subjects.subjectid".$i_2_sql_order_addon, $i_2_limitcount, $i_2_limitfrom);
if(!$i_rSet2) {
	showDBError(__FILE__, 2);
} else {
	$i_counter = 0;
while(!$i_rSet2->EOF) {
 $rowname = ($i_counter % 2) ? 'rowone' : 'rowtwo';
$i_rowtitle = '';
     
 if(!in_array($i_rSet2->fields['questionid'], $i_questionids_in_the_test) || ($i_rSet2->fields['question_type'] == QUESTION_TYPE_RANDOM)) {
 echo '<tr class="hover:bg-slate-50 transition-colors duration-200 group">';
 echo '<td class="p-3 text-center"><input id=cb_'.$i_pagewide_id.' type=checkbox name=box_questions[] value="'.$i_rSet2->fields['questionid'].'" onclick="toggleCB(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></td>';
 echo '<td class="p-3 text-right text-slate-400 font-mono text-xs">#'.$i_rSet2->fields['questionid'].'</td>';
 echo '<td class="p-3"><a href="test-manager.php?testid='.$f_testid.(isset($_GET['subjectid2']) && $_GET['subjectid2'] != '' ? '' : '&subjectid2='.$i_rSet2->fields['subjectid']).$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=editt" class="text-indigo-600 text-sm font-medium hover:text-indigo-800 transition-colors">'.convertTextValue($i_rSet2->fields['subject_name']).'</a></td>';
 echo '<td class="p-3 text-slate-600 text-sm leading-relaxed">'.getTruncatedHTML($i_rSet2->fields['question_text']).'</td>';
 echo '<td class="p-3 text-green-700 text-sm bg-green-50/50 border-l border-green-100">'.($i_rSet2->fields["correct_answers"] ? $i_rSet2->fields["correct_answers"] : '<span class="text-slate-300 italic">None</span>').'</td>'; // Correct Answer Data
 echo '<td class="p-3"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">';
switch ($i_rSet2->fields['question_type']) {
 case QUESTION_TYPE_MULTIPLECHOICE:
 echo $lngstr['label_atype_multiple_choice'];
break;
case QUESTION_TYPE_TRUEFALSE:
 echo $lngstr['label_atype_truefalse'];
break;
case QUESTION_TYPE_MULTIPLEANSWER:
 echo $lngstr['label_atype_multiple_answer'];
break;
case QUESTION_TYPE_FILLINTHEBLANK:
 echo $lngstr['label_atype_fillintheblank'];
break;
case QUESTION_TYPE_ESSAY:
 echo $lngstr['label_atype_essay'];
break;
case QUESTION_TYPE_RANDOM:
 echo $lngstr['label_atype_random'];
break;
}
echo '</span></td>';
echo '<td class="p-3 text-right font-bold text-slate-700 text-sm">'.($i_rSet2->fields['question_type']<>QUESTION_TYPE_RANDOM ? $i_rSet2->fields['question_points'] : '').'</td>';
echo '<td class="p-3"><div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">';
// Append Button
echo '<a href="test-manager.php?testid='.$f_testid.'&questionid='.$i_rSet2->fields['questionid'].$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=append" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded transition-colors" title="'.$lngstr['label_action_question_append'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></a>';
// Edit Button
echo '<a href="question-bank.php?testid='.$f_testid.'&questionid='.$i_rSet2->fields['questionid'].'&action=editq" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="'.$lngstr['label_action_question_edit'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>';
// Delete Button
echo '<a href="question-bank.php?testid='.$f_testid.'&questionid='.$i_rSet2->fields['questionid'].$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.$i_2_subjectid_addon.$i_2_order_addon.$i_2_url_limit_addon.'&action=deleteq" onclick="return confirmMessage(this, \''.$lngstr['qst_delete_question'].'\')" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="'.$lngstr['label_action_question_delete'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>';
echo '</div></td></tr>';
$i_counter++;
$i_pagewide_id++;
}
$i_rSet2->MoveNext();
}
$i_rSet2->Close();
}
echo '</tbody></table>';
echo '</div></div></form>';
displayTemplate('_footer');
?>