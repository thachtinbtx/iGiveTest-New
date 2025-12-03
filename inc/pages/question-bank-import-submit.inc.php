<?php
require_once('inc/question_import.lib.php');

$f_import_document = readPostVar('import_document');
$f_import_document = stripslashes($f_import_document);
$f_action_type = readPostVar('action_type', 'preview');
$f_confirm_import = readPostVar('confirm_import', 0);
$f_import_data_encoded = readPostVar('import_data', '');
$f_import_subject = (int)readPostVar('import_subject', 0);

// --- LOGIC FLOW ---

if ($f_confirm_import == 1 && !empty($f_import_data_encoded)) {
    // CONFIRMATION STEP: Insert data
    $import_package = unserialize(base64_decode($f_import_data_encoded));
    $questions = $import_package['questions'];
    $subjectid = $import_package['subjectid'];
    
    $count = 0;
    $errors = [];
    
    if (is_array($questions)) {
        foreach ($questions as $idx => $q) {
            if (insertParsedQuestion($q, $subjectid)) {
                $count++;
            } else {
                $errors[] = "Question ".($idx+1).": ".$q['text'];
            }
        }
    }
    
    // Show success/error page before redirecting
    $g_vars['page']['location'] = array('question_bank', 'question_bank', 'import_success');
    $g_vars['page']['header'] = 'Import Complete';
    
    // Get subject name for display
    $subjectName = $g_db->GetOne("SELECT subject_name FROM ".$srv_settings['table_prefix']."subjects WHERE subjectid = ".$subjectid);
    
    $g_smarty->assign('g_vars', $g_vars);
    displayTemplate('_header');
    
    echo '<div class="glass-panel-strong rounded-2xl shadow-neumorphic p-6 mb-6 max-w-2xl mx-auto">';
    if ($count > 0) {
        echo '<div class="p-4 bg-green-100 text-green-800 rounded-xl mb-4 text-center">';
        echo '<h3 class="text-2xl font-bold mb-2">✓ Import Successful!</h3>';
        echo '<p class="text-lg">Successfully imported <strong>'.$count.'</strong> question(s) into the database.</p>';
        if ($subjectName) {
            echo '<p class="text-sm mt-2">Subject: <strong>'.htmlspecialchars($subjectName).'</strong></p>';
        }
        echo '</div>';
    }
    
    if (!empty($errors)) {
        echo '<div class="p-4 bg-yellow-100 text-yellow-800 rounded-xl mb-4">';
        echo '<h4 class="font-bold mb-2">⚠ Some questions failed:</h4>';
        echo '<ul class="list-disc pl-5">';
        foreach ($errors as $err) {
            echo '<li>'.htmlspecialchars($err).'</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    
    echo '<div class="text-center mt-6">';
    echo '<a href="question-bank.php" class="btn-neumorphic-primary px-8 py-3 font-bold rounded-xl inline-block">View Question Bank</a>';
    echo '</div>';
    echo '</div>';
    
    displayTemplate('_footer');

} else {
    // PREVIEW STEP: Parse and Show
    $parsedQuestions = parseSimpleFormat($f_import_document);
    
    // Package questions with subject for confirm step
    $import_package = [
        'questions' => $parsedQuestions,
        'subjectid' => $f_import_subject
    ];
    $encodedData = base64_encode(serialize($import_package));
    
    // Get subject name for display
    $subjectName = $g_db->GetOne("SELECT subject_name FROM ".$srv_settings['table_prefix']."subjects WHERE subjectid = ".$f_import_subject);

    // Display Preview UI
    $g_vars['page']['location'] = array('question_bank', 'question_bank', 'import_preview');
    $g_vars['page']['header'] = 'Import Preview';
    $g_smarty->assign('g_vars', $g_vars);
    displayTemplate('_header');
    
    // Inline Preview HTML (since we don't have a separate tpl for this yet and it's dynamic)
    echo '<div class="glass-panel-strong rounded-2xl shadow-neumorphic p-6 mb-6">';
    echo '<div class="flex items-center justify-between mb-4">';
    echo '<h3 class="text-xl font-bold text-pastel-cadet">Preview Questions</h3>';
    if ($subjectName) {
        echo '<div class="text-sm bg-pastel-sky/20 px-4 py-2 rounded-lg">';
        echo '<span class="text-slate-600">Subject:</span> <strong class="text-pastel-cadet">'.htmlspecialchars($subjectName).'</strong>';
        echo '</div>';
    }
    echo '</div>';
    
    if (empty($parsedQuestions)) {
        echo '<div class="p-4 bg-red-100 text-red-700 rounded-xl mb-4">No questions found. Please check your format.</div>';
        echo '<a href="question-bank.php?action=import" class="btn-neumorphic px-6 py-3 font-bold rounded-xl text-slate-600">Back</a>';
    } else {
        echo '<div class="overflow-x-auto mb-6">';
        echo '<table class="w-full text-left border-collapse">';
        echo '<thead><tr class="border-b border-white/20 text-pastel-cadet"><th class="p-4">#</th><th class="p-4">Question</th><th class="p-4">Answers</th><th class="p-4">Points</th></tr></thead>';
        echo '<tbody class="divide-y divide-white/10">';
        
        foreach ($parsedQuestions as $idx => $q) {
            echo '<tr>';
            echo '<td class="p-4 text-slate-500">'.($idx + 1).'</td>';
            echo '<td class="p-4 font-medium text-slate-700">'.htmlspecialchars($q['text']).'</td>';
            echo '<td class="p-4">';
            echo '<ul class="list-disc pl-4 space-y-1">';
            foreach ($q['answers'] as $aIdx => $ans) {
                $class = ($aIdx == $q['correct']) ? 'text-green-600 font-bold' : 'text-slate-600';
                $marker = ($aIdx == $q['correct']) ? ' (Correct)' : '';
                echo '<li class="'.$class.'">'.htmlspecialchars($ans).$marker.'</li>';
            }
            echo '</ul>';
            echo '</td>';
            echo '<td class="p-4 text-slate-700">'.$q['points'].'</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table></div>';
        
        echo '<form method="post" action="question-bank.php?action=import">';
        echo '<input type="hidden" name="bsubmit" value="1">'; // Keep triggering this include
        echo '<input type="hidden" name="confirm_import" value="1">';
        echo '<input type="hidden" name="import_data" value="'.$encodedData.'">';
        echo '<div class="flex justify-center gap-4">';
        echo '<button type="submit" class="btn-neumorphic-primary px-6 py-3 font-bold rounded-xl">Confirm & Import '.count($parsedQuestions).' Questions</button>';
        echo '<a href="question-bank.php?action=import" class="btn-neumorphic px-6 py-3 font-bold rounded-xl text-slate-600">Cancel</a>';
        echo '</div>';
        echo '</form>';
    }
    echo '</div>';
    displayTemplate('_footer');
}
?>
