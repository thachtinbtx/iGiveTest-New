<?php
$g_vars['page']['location'] = array('question_bank', 'question_bank');
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'questionbank';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);
// Floating orbs for scientific feel
echo '<div class="fixed -top-32 -left-32 w-64 h-64 bg-gradient-radial from-pastel-cadet/15 to-transparent rounded-full blur-3xl floating-slow pointer-events-none"></div>';
echo '<div class="fixed top-1/2 -right-32 w-64 h-64 bg-gradient-radial from-pastel-lavender/15 to-transparent rounded-full blur-3xl floating pointer-events-none"></div>';

// Modern header with glassmorphic card
echo '<div class="glass-panel-strong rounded-2xl shadow-neumorphic p-6 mb-6 relative z-10">';
echo '<div class="flex items-center gap-4">';
echo '<div class="bg-pastel-cadet/20 rounded-2xl p-3 shadow-neumorphic-sm">';
echo '<svg class="w-8 h-8 text-pastel-cadet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
echo '</div>';
echo '<div>';
echo '<h2 class="text-3xl font-bold text-pastel-cadet tracking-tight">'.$lngstr['page_header_questionbank'].'</h2>';
echo '<p class="text-slate-600 mt-1">'.$lngstr['tooltip_questionbank'].'</p>';
echo '</div>';
echo '</div>';
echo '</div>';
writeErrorsWarningsBar();
$i_pagewide_id = 0;
  
$i_subjectid_addon = '';
$i_sql_where_addon = '';
if(isset($_GET['subjectid']) && $_GET['subjectid'] != '') {
	$i_subjectid_addon .= '&subjectid='.(int)readGetVar('subjectid');
$i_sql_where_addon .= $srv_settings['table_prefix'].'questions.subjectid='.(int)readGetVar('subjectid').' AND ';
}
   
$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
	array($lngstr["label_editquestions_hdr_questionid"], $lngstr["label_editquestions_hdr_questionid_hint"], $srv_settings['table_prefix']."questions.questionid"),
	array($lngstr["label_editquestions_hdr_subjectid"], $lngstr["label_editquestions_hdr_subjectid_hint"], $srv_settings['table_prefix']."questions.subjectid"),
	array($lngstr["label_editquestions_hdr_question_text"], $lngstr["label_editquestions_hdr_question_text_hint"], ""),
	array($lngstr["label_editquestions_hdr_question_type"], $lngstr["label_editquestions_hdr_question_type_hint"], $srv_settings['table_prefix']."questions.question_type"),
	array($lngstr["label_editquestions_hdr_question_points"], $lngstr["label_editquestions_hdr_question_points_hint"], $srv_settings['table_prefix']."questions.question_points"),
);
$i_order_no = isset($_GET["order"]) ? (int)$_GET["order"] : 0;
if($i_order_no>=count($i_tablefields))
 $i_order_no = -1;
if($i_order_no>=0) {
	$i_direction = "DESC";
	if(isset($_GET["direction"]) && $_GET["direction"] == "ASC") $i_direction = "";
	
    $i_order_addon = "&order=".$i_order_no."&direction=".($i_direction ? "DESC" : "ASC");
    $i_sql_order_addon = " ORDER BY ".$i_tablefields[$i_order_no][2]." ".($i_direction ? "DESC" : "ASC");
}

$i_url_limitto_addon = "";
$i_url_pageno_addon = "";
$i_url_limit_addon = "";
$i_pageno = 0;
$i_limitcount = isset($_GET["limitto"]) ? (int)$_GET["limitto"] : $G_SESSION['config_itemsperpage'];
if($i_limitcount>0) {
	$i_recordcount = getRecordCount($srv_settings['table_prefix'].'questions', $i_sql_where_addon."1=1");
    $i_pageno = isset($_GET["pageno"]) ? (int)$_GET["pageno"] : 1;
    if($i_pageno < 1)
        $i_pageno = 1;
    $i_limitfrom = ($i_pageno-1)*$i_limitcount;
    $i_pageno_count = floor(($i_recordcount - 1) / $i_limitcount) + 1;
    if($i_limitfrom > $i_recordcount) {
        $i_pageno = $i_pageno_count;
        $i_limitfrom = ($i_pageno-1)*$i_limitcount;
    }
    $i_url_limitto_addon .= "&limitto=".$i_limitcount;
    $i_url_pageno_addon .= "&pageno=".$i_pageno;
    $i_url_limit_addon .= $i_url_limitto_addon.$i_url_pageno_addon;
} else {
	$i_limitfrom = -1;
    $i_limitcount = -1;
}

$nPageWindow = IGT_CONFIG_NAVIGATION_WINDOW;
if (!IGT_CONFIG_NAVIGATION_SHOW_ALWAYS) {
	if ($i_recordcount == 0 || ($i_pageno_count == 1 && $this->NavShowAll == false))
        return;
}

if($i_pageno > floor($nPageWindow/2) + 1 && $i_pageno_count > $nPageWindow)
	$nStartPage = $i_pageno - floor($nPageWindow/2);
else
	$nStartPage = 1;

if($i_pageno <= $i_pageno_count - floor($nPageWindow/2) && $nStartPage + $nPageWindow-1 <= $i_pageno_count)
	$nEndPage = $nStartPage + $nPageWindow - 1;
else
{
	$nEndPage = $i_pageno_count;
    if($nEndPage - $nPageWindow + 1 >= 1)
        $nStartPage = $nEndPage - $nPageWindow + 1;
}
$nRecordFrom = ($i_pageno - 1) * $i_limitcount + 1;
if($i_pageno != $i_pageno_count)
    $nRecordTo = $i_pageno * $i_limitcount;
else $nRecordTo = $i_recordcount;

echo '<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="">';
echo '<tr valign=top><td class=rowhdr2 colspan=2><a class=rowhdr2 href="javascript:void(0)" onclick="javascript:toggleSection(\'div_filter_questionbank\')">'.$lngstr['label_filter_header'].'</td></tr>';
echo '<tr valign=top><td class=rowone colspan=2><div id=div_filter_questionbank style="display:'.(isset($_COOKIE['div_filter_questionbank']) && $_COOKIE['div_filter_questionbank']=='Y' ? 'block' : 'none').'"><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';

  

$i_subjects = array('' => $lngstr['label_none']);
$i_rSet2 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."subjects");
if(!$i_rSet2) {
	showDBError(__FILE__, 2);
} else {
	while(!$i_rSet2->EOF) {
        $i_subjects[$i_rSet2->fields['subjectid']] = $i_rSet2->fields['subject_name'];
        $i_rSet2->MoveNext();
    }
    $i_rSet2->Close();
}
$f_subjectid = isset($_GET['subjectid']) ? (int)readGetVar('subjectid') : '';
writeTR2($lngstr['page_editquestion_subjectid'], getSelectElement('subjectid', $f_subjectid, $i_subjects, ' onchange="document.location.href=\'question-bank.php?subjectid=\'+this.value+\''.$i_order_addon.$i_url_limit_addon.'\';"'));

   
echo '</table>';

echo '</div></td></tr>';
echo '</table></p>';


echo '<p><form name=qbankForm class=iactive method=post><div class="glass-panel-strong rounded-2xl shadow-neumorphic mb-6 overflow-hidden">';
echo '<div class="p-4 flex flex-wrap justify-between items-center gap-3">';

// Action Buttons
echo '<div class="flex flex-wrap gap-2">';
echo '<a href="question-bank.php?action=createq" class="btn-neumorphic-primary px-4 py-2.5 flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg><span class="font-semibold">'.$lngstr['label_action_create_question'].'</span></a>';
echo '<a href="question-bank.php?action=import" class="btn-neumorphic-secondary px-4 py-2.5 flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg><span class="font-semibold">'.$lngstr['button_import'].'</span></a>';
echo '<button type="button" onclick="f=document.qbankForm;f.action=\'question-bank.php?action=statsq\';f.submit();" class "btn-neumorphic px-4 py-2.5 flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg><span class="font-semibold">'.$lngstr['label_action_questions_stats'].'</span></button>';
echo '<button type="button" onclick="f=document.qbankForm;if (confirm(\''.$lngstr['qst_delete_questions'].'\')) { f.action=\'question-bank.php?action=deleteq&confirmed=1\';f.submit();}" class="btn-neumorphic-danger px-4 py-2.5 flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg><span class="font-semibold">'.$lngstr['label_action_questions_delete'].'</span></button>';
echo '</div>';

// Pagination
if($i_limitcount > 0) {
	$i_url_pages_addon = $i_url_limitto_addon.$i_order_addon.$i_subjectid_addon;
	echo '<div class="flex items-center gap-2">';
	echo '<span class="text-sm text-slate-600 font-medium">'.sprintf($lngstr['label']['KtoLofN'], $nRecordFrom, $nRecordTo, $i_recordcount).'</span>';
	echo '<div class="flex gap-1">';
	for($i = $nStartPage; $i <= $nEndPage; $i++) {
		if($i != $i_pageno)
			echo '<a href="question-bank.php?pageno='.$i.$i_url_pages_addon.'" class="px-3 py-1 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic text-sm font-semibold text-slate-700 transition-all">'.$i.'</a>';
		else echo '<span class="px-3 py-1 rounded-lg bg-pastel-sky/30 text-pastel-sky font-bold text-sm">'.$i.'</span>';
	}
	echo '</div>';
	
	// First/Prev/Next/Last buttons
	echo '<div class="flex gap-1">';
	if($i_pageno > 1) {
		echo '<a href="question-bank.php?pageno=1'.$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_first_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></a>';
		echo '<a href="question-bank.php?pageno='.max(($i_pageno-1), 1).$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_prev_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>';
	} else {
		echo '<span class="p-2 rounded-lg bg-slate-100 text-slate-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></span>';
		echo '<span class="p-2 rounded-lg bg-slate-100 text-slate-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></span>';
	}
	if($i_pageno < $i_pageno_count) {
		echo '<a href="question-bank.php?pageno='.min(($i_pageno+1), $i_pageno_count).$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_next_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>';
		echo '<a href="question-bank.php?pageno='.$i_pageno_count.$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_last_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></a>';
	} else {
		echo '<span class="p-2 rounded-lg bg-slate-100 text-slate-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>';
		echo '<span class="p-2 rounded-lg bg-slate-100 text-slate-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></span>';
	}
	echo '</div>';
	echo '</div>';
}
echo '</div>';
echo '<div class="overflow-x-auto">';
echo '<table class="w-full text-left border-collapse">';
echo '<thead>';
echo '<tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider">';
echo '<th class="p-3 w-12 text-center"><input type="checkbox" name="toggleAll" onclick="toggleAllGlass(this)" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></th>';

foreach($i_tablefields as $i_fieldno=>$i_field) {
    $i_content = $i_field[0];
    if($i_field[2]) {
        $sortIcon = '';
        if($i_order_no==$i_fieldno) {
            $sortIcon = $i_direction ? ' <span class="text-indigo-600">▼</span>' : ' <span class="text-indigo-600">▲</span>';
        } else {
            $sortIcon = ' <span class="text-slate-300 group-hover:text-slate-400">▼</span>';
        }
        $nextDir = ($i_order_no==$i_fieldno && $i_direction) ? "ASC" : "DESC";
        $i_content = '<a href="question-bank.php?order='.$i_fieldno.'&direction='.$nextDir.$i_subjectid_addon.$i_url_limit_addon.'" class="group flex items-center gap-1 hover:text-indigo-600 transition-colors">'.$i_content.$sortIcon.'</a>';
    }
    $class = "p-3 font-semibold";
    if($i_fieldno == 0 || $i_fieldno == 4) $class .= " w-20 text-right";
    elseif($i_fieldno == 1 || $i_fieldno == 3) $class .= " w-32";
    
    echo '<th class="'.$class.'">'.$i_content.'</th>';
    
    // Insert Correct Answer column after Question Text (index 2)
    if($i_fieldno == 2) {
        echo '<th class="p-3 w-64 font-semibold text-green-600">Correct Answer</th>';
    }
}
echo '<th class="p-3 w-32 text-center font-semibold">'.$lngstr['label_hdr_action'].'</th>';echo '</tr>';
echo '</thead>';
echo '<tbody class="divide-y divide-slate-200">'; // Visible borders

$i_rSet1 = $g_db->SelectLimit("SELECT ".$srv_settings['table_prefix']."questions.questionid, ".$srv_settings['table_prefix']."questions.subjectid, ".$srv_settings['table_prefix']."questions.question_text, ".$srv_settings['table_prefix']."questions.question_time, ".$srv_settings['table_prefix']."questions.question_type, ".$srv_settings['table_prefix']."questions.question_points, ".$srv_settings['table_prefix']."subjects.subject_name, (SELECT GROUP_CONCAT(answer_text SEPARATOR '<br>') FROM ".$srv_settings['table_prefix']."answers WHERE ".$srv_settings['table_prefix']."answers.questionid = ".$srv_settings['table_prefix']."questions.questionid AND ".$srv_settings['table_prefix']."answers.answer_correct = 1) as correct_answers FROM ".$srv_settings['table_prefix']."questions, ".$srv_settings['table_prefix']."subjects WHERE ".$i_sql_where_addon."".$srv_settings['table_prefix']."questions.subjectid=".$srv_settings['table_prefix']."subjects.subjectid".$i_sql_order_addon, $i_limitcount, $i_limitfrom);
if(!$i_rSet1) {
	showDBError(__FILE__, 1);
} else {
	$i_counter = 0;
while(!$i_rSet1->EOF) {
 echo '<tr class="hover:bg-slate-50 transition-colors duration-200 group">';
 echo '<td class="p-3 text-center"><input type="checkbox" name="box_questions[]" value="'.$i_rSet1->fields["questionid"].'" onclick="toggleGlassRow(this)" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></td>';
 echo '<td class="p-3 text-right font-mono text-xs text-slate-400">#'.$i_rSet1->fields["questionid"].'</td>';
 echo '<td class="p-3"><a href="question-bank.php?action=editt'.(isset($_GET["subjectid"]) && $_GET["subjectid"] != "" ? "" : '&subjectid='.$i_rSet1->fields["subjectid"]).$i_order_addon.$i_url_limit_addon.'" class="text-indigo-600 text-sm font-medium hover:text-indigo-800 transition-colors">'.convertTextValue($i_rSet1->fields["subject_name"]).'</a></td>';
 echo '<td class="p-3 text-slate-600 text-sm leading-relaxed">'.getTruncatedHTML($i_rSet1->fields["question_text"]).'</td>'; // Smaller font
 echo '<td class="p-3 text-green-700 text-sm bg-green-50/50 border-l border-green-100">'.($i_rSet1->fields["correct_answers"] ? $i_rSet1->fields["correct_answers"] : '<span class="text-slate-300 italic">None</span>').'</td>'; // New Column Data
 echo '<td class="p-3"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">';
switch ($i_rSet1->fields["question_type"]) {
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
echo '<td class="p-3 text-right font-bold text-slate-700 text-sm">'.($i_rSet1->fields["question_type"]<>QUESTION_TYPE_RANDOM ? $i_rSet1->fields["question_points"] : '').'</td>';
echo '<td class="p-3"><div class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">';
// Stats Button
echo ($i_rSet1->fields["question_type"]<>QUESTION_TYPE_RANDOM ? '<a href="question-bank.php?questionid='.$i_rSet1->fields["questionid"].'&action=statsq" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" title="'.$lngstr['label_action_question_stats'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></a>' : '<span class="p-1.5 text-slate-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></span>');
// Edit Button
echo '<a href="question-bank.php?questionid='.$i_rSet1->fields["questionid"].'&action=editq" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="'.$lngstr['label_action_question_edit'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>';
// Delete Button
echo '<a href="question-bank.php?questionid='.$i_rSet1->fields["questionid"].$i_subjectid_addon.$i_order_addon.$i_url_limit_addon.'&action=deleteq" onclick="return confirmMessage(this, \''.$lngstr['qst_delete_question'].'\')" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="'.$lngstr['label_action_question_delete'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>';
echo '</div></td></tr>';
$i_counter++;
$i_pagewide_id++;
$i_rSet1->MoveNext();
}
$i_rSet1->Close();
}
echo '</tbody></table>';
echo '</div></div></form>';

// Local JS for glassmorphic checkbox handling
echo '<script>
function toggleGlassRow(checkbox) {
 const row = checkbox.closest("tr");
 if (checkbox.checked) {
 row.classList.add("bg-white/40");
 } else {
 row.classList.remove("bg-white/40");
 }
}

function toggleAllGlass(toggleCheckbox) {
 const checkboxes = document.querySelectorAll("input[name=\'box_questions[]\']");
 checkboxes.forEach(cb => {
 cb.checked = toggleCheckbox.checked;
 toggleGlassRow(cb);
 });
}
</script>';

displayTemplate('_footer');
?>
