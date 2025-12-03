<?php
$g_vars['page']['location'] = array('question_bank', 'question_bank', 'import_questions');
$g_vars['page']['header'] = $lngstr['page_header_import_questions'];
$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'questionbank-import';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);

// Pass a flag to the template to show the simple format instructions
$g_vars['page']['show_simple_instructions'] = true;

// Fetch available subjects for dropdown
$g_vars['page']['subjects'] = array();
$subjectsRS = $g_db->Execute("SELECT subjectid, subject_name FROM ".$srv_settings['table_prefix']."subjects ORDER BY subject_name");
if ($subjectsRS) {
    while (!$subjectsRS->EOF) {
        $g_vars['page']['subjects'][$subjectsRS->fields['subjectid']] = $subjectsRS->fields['subject_name'];
        $subjectsRS->MoveNext();
    }
    $subjectsRS->Close();
}

// Set default subject to first available
$g_vars['page']['default_subject'] = !empty($g_vars['page']['subjects']) ? key($g_vars['page']['subjects']) : 0;

$g_smarty->assign('g_vars', $g_vars);
displayTemplate('question-bank-import');
?>
