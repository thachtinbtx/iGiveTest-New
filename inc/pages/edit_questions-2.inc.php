<?php
$g_vars['page']['location'] = array('question_bank', 'question_bank', 'edit_question');
$i_answers_editor = IGT_USE_EDITOR_FOR_ANSWERS ? $G_SESSION['config_editortype'] : 0;
$i_feedback_editor = IGT_USE_EDITOR_FOR_FEEDBACK ? $G_SESSION['config_editortype'] : 0;
$i_editor_boxes = array('question_text');
 initTextEditor($G_SESSION['config_editortype'], $i_editor_boxes);
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$f_testid = (int)readGetVar('testid');
$f_questionid = (int)readGetVar('questionid');
$f_answercount = (int)readGetVar('answercount');
$f_question_type = readGetVar('question_type');
if($f_testid) {
	$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'editquestions-2';
} else {
	$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'editquestions-2';
}
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);
// Floating orbs for scientific feel
echo '<div class="fixed -top-32 right-1/4 w-64 h-64 bg-gradient-radial from-pastel-sky/15 to-transparent rounded-full blur-3xl floating pointer-events-none"></div>';
echo '<div class="fixed bottom-1/4 -left-32 w-64 h-64 bg-gradient-radial from-pastel-salmon/15 to-transparent rounded-full blur-3xl floating-slow pointer-events-none"></div>';

// Modern header
echo '<div class="glass-panel-strong rounded-2xl shadow-neumorphic p-6 mb-6 relative z-10">';
echo '<div class="flex items-center gap-4">';
echo '<div class="bg-pastel-sky/20 rounded-2xl p-3 shadow-neumorphic-sm">';
echo '<svg class="w-8 h-8 text-pastel-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
echo '</div>';
echo '<div>';
echo '<h2 class="text-3xl font-bold text-pastel-sky tracking-tight">'.$lngstr['page_header_edit_question'].'</h2>';
echo '<p class="text-slate-600 mt-1">Edit question details and answers</p>';
echo '</div>';
echo '</div>';
echo '</div>';

writeErrorsWarningsBar(); 
$i_rSet1 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."questions WHERE questionid=".$f_questionid);
if(!$i_rSet1) {
	showDBError(__FILE__, 1);
} else {
	if(!$i_rSet1->EOF) { 
 if(!is_numeric($f_question_type) || $f_question_type < 0 || $f_question_type > QUESTION_TYPE_COUNT)
 $f_question_type = $i_rSet1->fields['question_type'];
echo '<form method=post action="question-bank.php'.getURLAddon().'" onsubmit="return submitForm();">';
echo '<div class="glass-panel rounded-2xl shadow-neumorphic p-8 relative z-10 space-y-6">';
$i_rowno = 0;
echo '<div class="grid grid-cols-1 md:grid-cols-12 gap-6">';
// Question Type
echo '<div class="md:col-span-4">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_type'].'</label>';
echo getSelectElement('question_type', $f_question_type, $m_question_types, ' onchange="updateQuestion();" class="input-neumorphic w-full"');
echo '</div>';

// Subject
 $f_subjectid = isset($_GET['subjectid']) ? (int)readGetVar('subjectid') : $i_rSet1->fields['subjectid'];
 $i_subjects = array();
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
echo '<div class="md:col-span-5">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_subjectid'].'</label>';
echo getSelectElement('subjectid', $f_subjectid, $i_subjects, 'class="input-neumorphic w-full"');
echo '</div>';

// Points (Moved from bottom)
if($f_question_type<>QUESTION_TYPE_RANDOM) {
 echo '<div class="md:col-span-3">';
 echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_points'].'</label>';
 echo getInputElement('question_points', $i_rSet1->fields['question_points'], '', 'class="input-neumorphic w-full"');
 echo '</div>';
}
echo '</div>'; // End grid
 $i = 0;
$i_rSet3 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."answers WHERE questionid=$f_questionid ORDER BY answerid");
if(!$i_rSet1) {
 showDBError(__FILE__, 3);
} else {
 $i_answercount = (int)$i_rSet3->RecordCount();
$i_answercount_nonempty = 0;
if($f_answercount > 0)
 $i_answercount_nonempty = min($i_answercount, $f_answercount);
else $i_answercount_nonempty = $i_answercount;
switch ($f_question_type) {
 case QUESTION_TYPE_MULTIPLECHOICE:
 case QUESTION_TYPE_MULTIPLEANSWER:
 case QUESTION_TYPE_TRUEFALSE:
 case QUESTION_TYPE_CUSTOM_SCORING: 
 if($f_answercount <= 0 && $i_answercount > 0)
 $f_answercount = $i_answercount; 
 $m_answercount_items = array(0 => '');
for($i=2; $i <= MAX_ANSWER_COUNT; $i++)
 $m_answercount_items[$i] = $i;
echo '<div class="glass-panel bg-white/20 p-4 rounded-xl mb-6 border border-white/10">';
echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">';
// Answer Count
echo '<div>';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_answer_count'].'</label>';
echo getSelectElement('answercount', $f_answercount, $m_answercount_items, ' onchange="updateQuestion();" class="input-neumorphic w-full"');
echo '</div>';
// Shuffle Answers
echo '<div>';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion']['shuffle_answers'].'</label>';
echo getSelectElement('question_shufflea', $i_rSet1->fields['question_shufflea'], $lngstr['page_editquestion']['shuffle_answers_items'], 'class="input-neumorphic w-full"');
echo '</div>';
// Advanced Settings (Partial Answers)
 if($f_question_type == QUESTION_TYPE_MULTIPLEANSWER) {
 echo '<div>';
 echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion']['advanced_settings'].'</label>';
 echo '<div class="glass-panel p-3 rounded-xl flex items-center gap-2 h-[46px]">'.getCheckbox('question_type2', $i_rSet1->fields['question_type2'], '', 'class="rounded text-pastel-mint focus:ring-pastel-mint"').'<span class="text-slate-700 text-sm">'.$lngstr['page_editquestion']['allow_partial_answers'].'</span></div>';
 echo '</div>';
}
echo '</div>';
echo '</div>';

 if($f_answercount <= 0 && $i_answercount <= 0)
 $f_answercount = DEFAULT_ANSWER_COUNT; 

echo '<div class="mb-6">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_question_text'].'</label>';
echo '<div class="glass-panel rounded-xl overflow-hidden shadow-neumorphic-inset">';
echo getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($i_rSet1->fields['question_text']) ? $i_rSet1->fields['question_text'] : $lngstr['page_editquestion_emptyquestion']);
echo '</div>';
echo '</div>'; 

// Auto-fill Answers Button
echo '<div class="flex items-center justify-center mb-6">';
echo '<button type="button" onclick="autoFillAnswers()" class="btn-neumorphic px-6 py-2.5 flex items-center gap-2 text-pastel-sky font-bold rounded-xl shadow-neumorphic hover:scale-105 transition-transform">';
echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>';
echo '<span>Load Answers from Question Text</span>';
echo '</button>';
echo '</div>';

// Answers Header
echo '<div class="flex items-center gap-4 mb-6">';
echo '<div class="h-px bg-slate-300 flex-1"></div>';
echo '<span class="text-slate-500 font-bold uppercase tracking-widest text-sm">Answers</span>';
echo '<div class="h-px bg-slate-300 flex-1"></div>';
echo '</div>';

 $i = 1;
while(!$i_rSet3->EOF && $i <= $i_answercount_nonempty) {
$bgColor = ($i % 2 == 1) ? 'bg-pastel-sky/5' : 'bg-pastel-lavender/5';
echo '<div class="'.$bgColor.' border-l-4 '.($i % 2 == 1 ? 'border-pastel-sky' : 'border-pastel-lavender').' rounded-lg mb-2 p-3 hover:shadow-md transition-shadow">';
echo '<div class="flex items-center gap-3">';
// Label
echo '<div class="flex-shrink-0 w-20"><span class="font-bold text-pastel-cadet text-base">'.sprintf($lngstr['label_choice_no'], $i).'</span></div>';
// Editor
echo '<div class="flex-1"><div class="bg-white/50 rounded-lg overflow-hidden border border-slate-200">'.getTextEditor($i_answers_editor, 'answer_text['.$i.']', $i_rSet3->fields['answer_text'], 2).'</div></div>';
// Controls
echo '<div class="flex items-center gap-2 flex-shrink-0">';
echo '<label class="flex items-center gap-1 cursor-pointer" title="'.$lngstr['label_accept_as_correct'].'">'.getCheckbox('answer_correct['.$i.']', $i_rSet3->fields['answer_correct'], '', ' onclick="changeChoicePercents(this, '.$i.')" class="rounded text-pastel-mint focus:ring-pastel-mint"').'<span class="text-xs font-medium text-slate-600 whitespace-nowrap">Correct</span></label>';
    echo '<div class="flex items-center gap-1">'.getInputElement('answer_percents['.$i.']', $i_rSet3->fields['answer_percents'], '', 'class="input-neumorphic w-12 text-center text-sm"').'<span class="text-xs text-slate-500">%</span></div>';
echo '</div>';
echo '</div>';
echo '<input type="hidden" name="answer_feedback_'.$i.'" value="">';
echo '</div>';
$i_rSet3->MoveNext();
$i++;
}
for($i = $i_answercount_nonempty + 1; $i <= $f_answercount; $i++) {
$bgColor = ($i % 2 == 1) ? 'bg-pastel-sky/5' : 'bg-pastel-lavender/5';
echo '<div class="'.$bgColor.' border-l-4 '.($i % 2 == 1 ? 'border-pastel-sky' : 'border-pastel-lavender').' rounded-lg mb-2 p-3 hover:shadow-md transition-shadow">';
echo '<div class="flex items-center gap-3">';
// Label
echo '<div class="flex-shrink-0 w-20"><span class="font-bold text-pastel-cadet text-base">'.sprintf($lngstr['label_choice_no'], $i).'</span></div>';
// Editor
echo '<div class="flex-1"><div class="bg-white/50 rounded-lg overflow-hidden border border-slate-200">'.getTextEditor($i_answers_editor, 'answer_text['.$i.']', '', 2).'</div></div>';
// Controls
echo '<div class="flex items-center gap-2 flex-shrink-0">';
echo '<label class="flex items-center gap-1 cursor-pointer" title="'.$lngstr['label_accept_as_correct'].'">'.getCheckbox('answer_correct['.$i.']', 0, '', ' onclick="changeChoicePercents(this, '.$i.')" class="rounded text-pastel-mint focus:ring-pastel-mint"').'<span class="text-xs font-medium text-slate-600 whitespace-nowrap">Correct</span></label>';
    echo '<div class="flex items-center gap-1">'.getInputElement('answer_percents['.$i.']', '0', '', 'class="input-neumorphic w-12 text-center text-sm"').'<span class="text-xs text-slate-500">%</span></div>';
echo '</div>';
echo '</div>';
echo '<input type="hidden" name="answer_feedback_'.$i.'" value="">';
echo '</div>';
}

break;
case QUESTION_TYPE_TRUEFALSE: 
 echo '<div class="mb-6">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_answer_count'].'</label>';
echo '<div class="glass-panel p-3 rounded-xl text-slate-700 font-mono">2</div>';
echo '</div>';

echo '<div class="mb-6">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_question_text'].'</label>';
echo '<div class="glass-panel rounded-xl overflow-hidden shadow-neumorphic-inset">';
echo getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($i_rSet1->fields['question_text']) ? $i_rSet1->fields['question_text'] : $lngstr['page_editquestion_emptyquestion']);
echo '</div>';
echo '</div>';

// Answers Header
echo '<div class="flex items-center gap-4 mb-6">';
echo '<div class="h-px bg-slate-300 flex-1"></div>';
echo '<span class="text-slate-500 font-bold uppercase tracking-widest text-sm">Answers</span>';
echo '<div class="h-px bg-slate-300 flex-1"></div>';
echo '</div>';

 $i = 1;
$i_answer_text = $lngstr['label_atype_truefalse_true'];
$i_answer_feedback = '';
$i_answer_correct = false;
$i_answer_percents = 0;
if(!$i_rSet3->EOF) {
 $i_answer_text = $i_rSet3->fields['answer_text'];
$i_answer_feedback = $i_rSet3->fields['answer_feedback'];
$i_answer_correct = $i_rSet3->fields['answer_correct'];
$i_answer_percents = $i_rSet3->fields['answer_percents'];
$i_rSet3->MoveNext();
}
$bgColor = 'bg-pastel-sky/5';
echo '<div class="'.$bgColor.' border-l-4 border-pastel-sky rounded-lg mb-2 p-3 hover:shadow-md transition-shadow">';
echo '<div class="flex items-center gap-3">';
echo '<div class="flex-shrink-0 w-20"><span class="font-bold text-pastel-cadet text-base">'.sprintf($lngstr['label_choice_no'], $i).'</span></div>';
echo '<div class="flex-1"><div class="bg-white/50 rounded-lg overflow-hidden border border-slate-200">'.getTextEditor($i_answers_editor, 'answer_text['.$i.']', $i_answer_text, 2).'</div></div>';
echo '<div class="flex items-center gap-2 flex-shrink-0">';
echo '<label class="flex items-center gap-1 cursor-pointer" title="'.$lngstr['label_accept_as_correct'].'">'.getCheckbox('answer_correct['.$i.']', $i_answer_correct, '', ' onclick="changeChoicePercents(this, '.$i.')" class="rounded text-pastel-mint focus:ring-pastel-mint"').'<span class="text-xs font-medium text-slate-600 whitespace-nowrap">Correct</span></label>';
echo '<div class="flex items-center gap-1">'.getInputElement('answer_percents['.$i.']', $i_answer_percents, '', 'class="input-neumorphic w-12 text-center text-sm"').'<span class="text-xs text-slate-500">%</span></div>';
echo '</div>';
echo '</div>';
echo '<input type="hidden" name="answer_feedback_'.$i.'" value="">';
echo '</div>';
$i = 2;
$i_answer_text = $lngstr['label_atype_truefalse_false'];
$i_answer_feedback = '';
$i_answer_correct = false;
$i_answer_percents = 0;
if(!$i_rSet3->EOF) {
 $i_answer_text = $i_rSet3->fields['answer_text'];
$i_answer_feedback = $i_rSet3->fields['answer_feedback'];
$i_answer_correct = $i_rSet3->fields['answer_correct'];
$i_answer_percents = $i_rSet3->fields['answer_percents'];
}
$bgColor = 'bg-pastel-lavender/5';
echo '<div class="'.$bgColor.' border-l-4 border-pastel-lavender rounded-lg mb-2 p-3 hover:shadow-md transition-shadow">';
echo '<div class="flex items-center gap-3">';
echo '<div class="flex-shrink-0 w-20"><span class="font-bold text-pastel-cadet text-base">'.sprintf($lngstr['label_choice_no'], $i).'</span></div>';
echo '<div class="flex-1"><div class="bg-white/50 rounded-lg overflow-hidden border border-slate-200">'.getTextEditor($i_answers_editor, 'answer_text['.$i.']', $i_answer_text, 2).'</div></div>';
echo '<div class="flex items-center gap-2 flex-shrink-0">';
echo '<label class="flex items-center gap-1 cursor-pointer" title="'.$lngstr['label_accept_as_correct'].'">'.getCheckbox('answer_correct['.$i.']', $i_answer_correct, '', ' onclick="changeChoicePercents(this, '.$i.')" class="rounded text-pastel-mint focus:ring-pastel-mint"').'<span class="text-xs font-medium text-slate-600 whitespace-nowrap">Correct</span></label>';
echo '<div class="flex items-center gap-1">'.getInputElement('answer_percents['.$i.']', $i_answer_percents, '', 'class="input-neumorphic w-12 text-center text-sm"').'<span class="text-xs text-slate-500">%</span></div>';
echo '</div>';
echo '</div>';
echo '<input type="hidden" name="answer_feedback_'.$i.'" value="">';
echo '</div>';
break;

case QUESTION_TYPE_FILLINTHEBLANK: 
 echo '<div class="mb-6">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_answer_count'].'</label>';
echo '<div class="glass-panel p-3 rounded-xl text-slate-700 font-mono">1</div>';
echo '</div>';
echo '<div class="mb-6">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_question_text'].'</label>';
echo '<div class="glass-panel rounded-xl overflow-hidden shadow-neumorphic-inset">'.getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($i_rSet1->fields['question_text']) ? $i_rSet1->fields['question_text'] : $lngstr['page_editquestion_emptyquestion']).'</div>';
echo '</div>';
 $i = 1;
$i_answer_text = '';
if(!$i_rSet3->EOF)
 $i_answer_text = $i_rSet3->fields['answer_text'];
echo '<div class="mb-6">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.sprintf($lngstr['label_answer_text'], $i).'</label>';
echo '<div class="glass-panel rounded-xl overflow-hidden">'.getTextEditor(0, 'answer_text['.$i.']', $i_answer_text, 3).'</div>';
echo '</div>';
break;
case QUESTION_TYPE_ESSAY: 
    echo '<div class="mb-6">';
    echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_question_text'].'</label>';
    echo '<div class="glass-panel rounded-xl overflow-hidden shadow-neumorphic-inset">'.getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($i_rSet1->fields['question_text']) ? $i_rSet1->fields['question_text'] : $lngstr['page_editquestion_emptyquestion']).'</div>';
    echo '</div>';
    
    // Model Answer Input
    $i = 1;
    $i_answer_text = '';
    if(!$i_rSet3->EOF)
        $i_answer_text = $i_rSet3->fields['answer_text'];
        
    echo '<div class="mb-6">';
    echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['label_answer_text'].' (Model Answer)</label>';
    echo '<div class="glass-panel rounded-xl overflow-hidden">'.getTextEditor(0, 'answer_text['.$i.']', $i_answer_text, 3).'</div>';
    // Hidden fields to ensure it saves correctly as a "correct" answer
    echo '<input type="hidden" name="answer_correct['.$i.']" value="1">';
    echo '<input type="hidden" name="answer_percents['.$i.']" value="100">';
    echo '</div>';
    break;
case QUESTION_TYPE_RANDOM:  
 echo '<div class="mb-6">';
echo '<label class="block text-sm font-semibold text-slate-700 mb-2">'.$lngstr['page_editquestion_question_name'].'</label>';
echo getInputElement('question_text', !empty($i_rSet1->fields['question_text']) ? $i_rSet1->fields['question_text'] : $lngstr['label_atype_random'].' ('.$i_subjects[$f_subjectid].')', '', 'class="input-neumorphic w-full"');
echo '</div>';
break;
}
$i_rSet3->Close();
}

 echo '</div>'; // End glass panel

// Action Buttons
echo '<div class="flex flex-wrap items-center justify-center gap-4 mt-8">';
echo '<button type="submit" name="bsubmit" class="btn-neumorphic-primary px-8 py-3 text-white font-bold rounded-xl shadow-neumorphic hover:scale-105 transition-transform">'.$lngstr['button_update'].'</button>';
echo '<button type="submit" name="bsubmit3" class="btn-neumorphic px-8 py-3 text-pastel-sky font-bold rounded-xl shadow-neumorphic hover:scale-105 transition-transform">Update</button>';
echo '<button type="submit" name="bsubmit2" class="btn-neumorphic px-8 py-3 text-pastel-cadet font-bold rounded-xl shadow-neumorphic hover:scale-105 transition-transform">'.$lngstr['button_update_and_create_new_question'].'</button>';
echo '<button type="submit" name="bcancel" class="btn-neumorphic px-8 py-3 text-pastel-salmon font-bold rounded-xl shadow-neumorphic hover:scale-105 transition-transform">'.$lngstr['button_cancel'].'</button>';
echo '</div>';
echo '</form>';
echo '<script language=JavaScript type="text/javascript">
function autoFillAnswers() {
    // Get content from TinyMCE editor with multiple fallback methods
    var questionText = "";
    
    // Method 1: Try TinyMCE
    if (typeof tinymce !== "undefined") {
        // Try to find editor by various possible IDs
        var editor = tinymce.get("question_text") || tinymce.activeEditor;
        
        if (editor) {
            questionText = editor.getContent({format: "text"});
            console.log("Got content from TinyMCE:", questionText.substring(0, 100));
        }
    }
    
    // Method 2: Fallback to textarea
    if (!questionText) {
        var textarea = document.querySelector("textarea[name=\'question_text\']") || document.getElementById("question_text");
        if (textarea) {
            questionText = textarea.value;
            console.log("Got content from textarea:", questionText.substring(0, 100));
        }
    }
    
    if (!questionText || questionText.trim().length === 0) {
        alert("Please enter question text first. Make sure to type your question with answers in the Question Text editor.");
        return;
    }
    
    // Parse answers from text - Smart parser
    var lines = questionText.split("\\n").map(function(line) { return line.trim(); }).filter(function(line) { return line.length > 0; });
    var answers = [];
    var questionLineIndex = -1;
    
    // First, find where the question ends (look for line with ?)
    for (var i = 0; i < lines.length; i++) {
        if (lines[i].includes("?")) {
            questionLineIndex = i;
            break;

        }
    }
    
    // If no question mark found, assume first line is question
    if (questionLineIndex === -1) {
        questionLineIndex = 0;
    }
    
    // Parse answers starting AFTER the question line
    for (var i = questionLineIndex + 1; i < lines.length; i++) {
        var line = lines[i];
        
        // Skip very long lines (likely explanation text, not answers)
        if (line.length > 200) continue;
        
        // Skip empty or very short lines
        if (line.length < 2) continue;
        
        var isCorrect = line.startsWith("*");
        
        // Remove various prefixes: *, A., A), 1., 1), -, etc.
        var cleanedText = line
            .replace(/^[*]\\s*/, "")                    // Remove * marker
            .replace(/^[A-Z][\\.\\)\\-]\\s*/i, "")      // Remove A. A) A-
            .replace(/^[0-9]+[\\.\\)\\-]\\s*/, "")      // Remove 1. 1) 1-
            .replace(/^[•\\-–—]\\s*/, "")               // Remove bullet points
            .trim();
        
        // If we have meaningful text after cleaning, treat as answer
        if (cleanedText.length > 0 && cleanedText.length <= 200) {
            answers.push({
                text: cleanedText,
                correct: isCorrect
            });
        }
    }
    
    if (answers.length === 0) {
        alert("No answers found. Please make sure your question text contains the question followed by answer options (one per line).");
        return;
    }
    
    // Fill answers into editors
    var answerCount = Math.min(answers.length, 10); // Max 10 answers
    var filledCount = 0;
    
    for (var i = 0; i < answerCount; i++) {
        var answerNum = i + 1;
        var answer = answers[i];
        
        // Fill answer text - try TinyMCE first, then textarea
        var filled = false;
        if (typeof tinymce !== "undefined") {
            var answerEditor = tinymce.get("answer_text[" + answerNum + "]");
            if (answerEditor) {
                answerEditor.setContent(answer.text);
                filled = true;
            }
        }
        
        if (!filled) {
            var answerTextarea = document.querySelector("textarea[name=\'answer_text[" + answerNum + "]\']");
            if (answerTextarea) {
                answerTextarea.value = answer.text;
                filled = true;
            }
        }
        
        if (filled) {
            filledCount++;
            
            // Check correct checkbox and set percentage
            var checkboxName = "answer_correct[" + answerNum + "]";
            var checkbox = document.querySelector("input[name=\\"" + checkboxName + "\\"]");
            var percentInput = document.getElementsByName("answer_percents[" + answerNum + "]")[0];
            
            if (checkbox) {
                checkbox.checked = answer.correct;
                
                // Set percentage value directly
                if (percentInput) {
                    percentInput.value = answer.correct ? "100" : "0";
                }
                
                // Also trigger the changeChoicePercents function for any side effects
                if (typeof changeChoicePercents === "function") {
                    changeChoicePercents(checkbox, answerNum);
                }
            }
        }
    }
    
    if (filledCount > 0) {
        alert("✅ Loaded " + filledCount + " answer(s) successfully!");
    } else {
        alert("❌ Could not fill answers. Please check your editor setup.");
    }
}

function updateQuestion() {
ctlQuestionType = document.getElementById("question_type");
nQuestionType = ctlQuestionType ? document.getElementById("question_type").options[document.getElementById("question_type").selectedIndex].value : "";
ctlSubjectID = document.getElementById("subjectid");
nSubjectID = ctlSubjectID ? ctlSubjectID.options[ctlSubjectID.selectedIndex].value : "";
ctlAnswerCount = document.getElementById("answercount");
nAnswerCount = ctlAnswerCount ? ctlAnswerCount.options[ctlAnswerCount.selectedIndex].value : "";
window.open("question-bank.php'.getURLAddon('', array('question_type', 'subjectid', 'answercount')).'&question_type="+nQuestionType+"&subjectid="+nSubjectID+"&answercount="+nAnswerCount,"_top");
}
</script>';
}
$i_rSet1->Close();
}
displayTemplate('_footer');
?>
