<?php
$g_vars['page']['location'] = array('test_manager', 'test_manager', 'assign'); 
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'testmanager-8';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);
echo '<h2>'.$lngstr['page_header_test_assignto_tests'].'</h2>';
writeErrorsWarningsBar();
writeInfoBar($lngstr['tooltip_tests_groups']);
$i_pagewide_id = 0;
  
$f_testids = array();
$i_testids_addon = "";
$i_sql_where_addon = "";
if(isset($_POST["box_tests"]) && is_array($_POST["box_tests"])) {
	foreach($_POST["box_tests"] as $f_testid) {
 array_push($f_testids, $f_testid);
}
} else if(isset($_GET["testids"]) && $_GET["testids"] != "") {
	$f_testids = explode(SYSTEM_ARRAY_ITEM_SEPARATOR, readGetVar('testids'));
} else {
	array_push($f_testids, readGetVar('testid'));
}
$i_testids_addon .= "&testids=".implode(SYSTEM_ARRAY_ITEM_SEPARATOR, $f_testids);
reset($f_testids);
if(list(,$val) = each($f_testids))
 $i_sql_where_addon .= "testid=".(int)$val;
while(list(,$val) = each($f_testids)) {
	$i_sql_where_addon .= " OR testid=".(int)$val;
}
if($i_sql_where_addon != "")
 $i_sql_where_addon = '('.$i_sql_where_addon.') AND ';
 
$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
	array($lngstr["label_edittests_hdr_testid"], $lngstr["label_edittests_hdr_testid_hint"], $srv_settings['table_prefix']."tests.testid"),
	array($lngstr["label_edittests_hdr_test_notes"], $lngstr["label_edittests_hdr_test_notes_hint"], ""),
	array($lngstr["label_edittests_hdr_test_name"], $lngstr["label_edittests_hdr_test_name_hint"], $srv_settings['table_prefix']."tests.test_name"),
	array($lngstr["label_edittests_hdr_subjectid"], $lngstr["label_edittests_hdr_subjectid_hint"], $srv_settings['table_prefix']."tests.subjectid"),
	array($lngstr["label_edittests_hdr_test_datestart"], $lngstr["label_edittests_hdr_test_datestart_hint"], $srv_settings['table_prefix']."tests.test_datestart"),
	array($lngstr["label_edittests_hdr_test_dateend"], $lngstr["label_edittests_hdr_test_dateend_hint"], $srv_settings['table_prefix']."tests.test_dateend"),
	array($lngstr["label_edittests_hdr_test_enabled"], $lngstr["label_edittests_hdr_test_enabled_hint"], $srv_settings['table_prefix']."tests.test_enabled"),
);
$i_order_no = isset($_GET["order"]) ? (int)$_GET["order"] : 0;
if($i_order_no>=count($i_tablefields))
 $i_order_no = -1;
if($i_order_no>=0) {
	$i_direction = (isset($_GET["direction"]) && $_GET["direction"]) ? "DESC" : "";
$i_order_addon = "&order=".$i_order_no."&direction=".$i_direction;
$i_sql_order_addon = " ORDER BY ".$i_tablefields[$i_order_no][2]." ".$i_direction;
}
  
$i_2_direction = "";
$i_2_order_addon = "";
$i_2_sql_order_addon = "";
$i_2_tablefields = array(
	array($lngstr["label_managegroups_hdr_groupid"], $lngstr["label_managegroups_hdr_groupid_hint"], $srv_settings['table_prefix']."groups.groupid"),
	array($lngstr["label_managegroups_hdr_group_name"], $lngstr["label_managegroups_hdr_group_name_hint"], $srv_settings['table_prefix']."groups.group_name"),
	array($lngstr["label_managegroups_hdr_group_description"], $lngstr["label_managegroups_hdr_group_description_hint"], $srv_settings['table_prefix']."groups.group_description"),
);
$i_2_order_no = isset($_GET["order2"]) ? (int)$_GET["order2"] : 0;
if($i_2_order_no>=count($i_2_tablefields))
 $i_2_order_no = -1;
if($i_2_order_no>=0) {
	$i_2_direction = (isset($_GET["direction2"]) && $_GET["direction2"]) ? "DESC" : "";
$i_2_order_addon = "&order2=".$i_2_order_no."&direction2=".$i_2_direction;
$i_2_sql_order_addon = " ORDER BY ".$i_2_tablefields[$i_2_order_no][2]." ".$i_2_direction;
}
 
$i_2_url_limitto_addon = "";
$i_2_url_pageno_addon = "";
$i_2_url_limit_addon = "";
$i_2_pageno = 0;
$i_2_limitcount = isset($_GET["limitto2"]) ? (int)$_GET["limitto2"] : $G_SESSION['config_itemsperpage'];
if($i_2_limitcount>0) {
	$i_2_recordcount = getRecordCount($srv_settings['table_prefix'].'groups');
$i_2_pageno = isset($_GET["pageno2"]) ? (int)$_GET["pageno2"] : 1;
if($i_2_pageno < 1)
 $i_2_pageno = 1;
$i_2_limitfrom = ($i_2_pageno-1)*$i_2_limitcount;
$i_2_pageno_count = floor(($i_2_recordcount - 1) / $i_2_limitcount) + 1;
if($i_2_limitfrom > $i_2_recordcount) {
 $i_2_pageno = $i_2_pageno_count;
$i_2_limitfrom = ($i_2_pageno-1)*$i_2_limitcount;
}
$i_2_url_limitto_addon .= "&limitto2=".$i_2_limitcount;
$i_2_url_pageno_addon .= "&pageno2=".$i_2_pageno;
$i_2_url_limit_addon .= $i_2_url_limitto_addon.$i_2_url_pageno_addon;
} else {
	$i_2_url_limitto_addon = "&limitto2=";
$i_2_url_limit_addon .= $i_2_url_limitto_addon;
$i_2_limitfrom = -1;
$i_2_limitcount = -1;
}
 
echo '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 font-sans text-slate-800">';

// Header
echo '<div class="mb-6">';
echo '  <h2 class="text-2xl font-bold text-slate-800">'.$lngstr['page_header_test_assignto_tests'].'</h2>';
echo '  <p class="text-slate-500 mt-1">'.$lngstr['tooltip_tests_groups'].'</p>';
echo '</div>';

echo '<form name="testsForm" id="testsForm" method="post" action="test-manager.php">';

// Selected Tests Table
echo '<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">';
echo '  <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">';
echo '    <h3 class="font-semibold text-slate-700">Selected Tests</h3>';
echo '    <div class="flex gap-2">';
echo '      <a href="test-manager.php?action=create" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="'.$lngstr['label_action_create_test'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></a>';
echo '      <button type="button" onclick="if(confirm(\''.$lngstr['qst_delete_tests'].'\')) { document.testsForm.action=\'test-manager.php?action=delete&confirmed=1\'; document.testsForm.submit(); }" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="'.$lngstr['label_action_tests_delete'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>';
echo '    </div>';
echo '  </div>';
echo '  <div class="overflow-x-auto">';
echo '    <table class="w-full text-left border-collapse">';
echo '      <thead>';
echo '        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">';
echo '          <th class="px-6 py-4 w-10"><input type="checkbox" name="toggleAll" onclick="toggleCBs(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"></th>';
foreach($i_tablefields as $i_fieldno=>$i_field) {
    $i_content = $i_field[0];
    if($i_field[2]) {
        $sortIcon = '';
        if($i_order_no==$i_fieldno) {
            $sortIcon = !$i_direction ? ' <span class="text-indigo-600">▲</span>' : ' <span class="text-indigo-600">▼</span>';
        } else {
            $sortIcon = ' <span class="text-slate-300 group-hover:text-slate-400">▲</span>';
        }
        $nextDir = ($i_order_no==$i_fieldno && !$i_direction) ? "DESC" : "";
        $i_content = '<a href="test-manager.php?action=groups'.$i_testids_addon.$i_2_order_addon.$i_2_url_limit_addon.'&order='.$i_fieldno.'&direction='.$nextDir.'" class="group flex items-center gap-1 hover:text-indigo-600 transition-colors">'.$i_content.$sortIcon.'</a>';
    }
    echo '<th class="px-6 py-4 whitespace-nowrap">'.$i_content.'</th>';
}
echo '          <th class="px-6 py-4 text-center">'.$lngstr['label_hdr_action'].'</th>';
echo '        </tr>';
echo '      </thead>';
echo '      <tbody class="divide-y divide-slate-100">';

$i_rSet1 = $g_db->Execute("SELECT ".$srv_settings['table_prefix']."tests.testid, ".$srv_settings['table_prefix']."tests.test_name, ".$srv_settings['table_prefix']."tests.subjectid, ".$srv_settings['table_prefix']."tests.test_datestart, ".$srv_settings['table_prefix']."tests.test_dateend, ".$srv_settings['table_prefix']."tests.test_notes, ".$srv_settings['table_prefix']."tests.test_enabled, ".$srv_settings['table_prefix']."subjects.subject_name FROM ".$srv_settings['table_prefix']."tests, ".$srv_settings['table_prefix']."subjects WHERE ".$i_sql_where_addon."".$srv_settings['table_prefix']."tests.subjectid=".$srv_settings['table_prefix']."subjects.subjectid".$i_sql_order_addon);

if(!$i_rSet1) {
    showDBError(__FILE__, 1);
} else {
    while(!$i_rSet1->EOF) {
        echo '<tr class="hover:bg-slate-50 transition-colors group">';
        echo '<td class="px-6 py-4"><input type="checkbox" name="box_tests[]" value="'.$i_rSet1->fields["testid"].'" onclick="toggleCB(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"></td>';
        echo '<td class="px-6 py-4 text-sm text-slate-600 font-mono">'.$i_rSet1->fields["testid"].'</td>';
        
        // Notes
        echo '<td class="px-6 py-4 text-center">';
        if(!empty($i_rSet1->fields["test_notes"])) {
             echo '<a href="javascript:void(0)" onClick="showDialog(\'test-manager.php?testid='.$i_rSet1->fields["testid"].'&action=notes\', 300, 200)" class="text-indigo-400 hover:text-indigo-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></a>';
        }
        echo '</td>';
        
        echo '<td class="px-6 py-4 text-sm font-medium text-slate-800">'.convertTextValue($i_rSet1->fields["test_name"]).'</td>';
        echo '<td class="px-6 py-4 text-sm text-indigo-600"><a href="test-manager.php?subjectid='.(isset($_GET["subjectid"]) && $_GET["subjectid"] != "" ? "" : $i_rSet1->fields["subjectid"]).$i_order_addon.'">'.convertTextValue($i_rSet1->fields["subject_name"]).'</a></td>';
        echo '<td class="px-6 py-4 text-sm text-slate-600">'.getDateLocal($lngstr['language']['date_format'],$i_rSet1->fields["test_datestart"]).'</td>';
        echo '<td class="px-6 py-4 text-sm text-slate-600">'.getDateLocal($lngstr['language']['date_format'],$i_rSet1->fields["test_dateend"]).'</td>';
        
        // Enabled
        echo '<td class="px-6 py-4 text-center">';
        echo '<a href="test-manager.php?testid='.$i_rSet1->fields["testid"].$i_order_addon.'&action=enable&set='.($i_rSet1->fields["test_enabled"] ? '0" class="text-green-500 hover:text-green-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' : '1" class="text-slate-300 hover:text-slate-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>').'</a>';
        echo '</td>';
        
        // Actions
        echo '<td class="px-6 py-4 text-center whitespace-nowrap">';
        echo '<div class="flex items-center justify-center gap-2">';
        echo '<a href="test-manager.php?testid='.$i_rSet1->fields["testid"].'&action=settings" class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors" title="'.$lngstr['label_action_test_settings'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></a>';
        echo '<a href="test-manager.php?testids='.$i_rSet1->fields["testid"].'&action=groups" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="'.$lngstr['label_action_test_groups_select'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></a>';
        echo '<a href="test-manager.php?testid='.$i_rSet1->fields["testid"].'&action=editt" class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-colors" title="'.$lngstr['label_action_questions_edit'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>';
        echo '<a href="test-manager.php?testid='.$i_rSet1->fields["testid"].'&action=delete" onclick="return confirmMessage(this, \''.$lngstr['qst_delete_test'].'\')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="'.$lngstr['label_action_test_delete'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        $i_rSet1->MoveNext();
    }
    $i_rSet1->Close();
}
echo '      </tbody>';
echo '    </table>';
echo '  </div>';
echo '</div>';
echo '</form>';

// Groups Table
echo '<h2 class="text-2xl font-bold text-slate-800 mb-4">'.$lngstr['page_header_test_assignto_groups'].'</h2>';
echo '<form name="groupsForm" id="groupsForm" method="post" action="test-manager.php">';

// Toolbar
echo '<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">';
echo '  <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">';
echo '    <a href="groups.php?action=create" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm whitespace-nowrap">';
echo '      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';
echo '      '.$lngstr['label_action_create_group'];
echo '    </a>';
echo '    <button type="button" onclick="if(confirm(\''.$lngstr['qst_delete_groups'].'\')) { document.groupsForm.action=\'groups.php?action=delete&confirmed=1\'; document.groupsForm.submit(); }" class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-colors shadow-sm whitespace-nowrap">';
echo '      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
echo '      '.$lngstr['label_action_groups_delete'];
echo '    </button>';
echo '  </div>';

// Pagination
if($i_2_limitcount > 0 && $i_2_pageno_count > 1) {
    echo '<div class="flex items-center gap-2">';
    if($i_2_pageno > 1) {
        echo '<a href="test-manager.php?action=groups&pageno2='.max(($i_2_pageno-1), 1).$i_testids_addon.$i_order_addon.$i_2_order_addon.$i_2_url_limitto_addon.'" class="p-2 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>';
    }
    echo '<span class="text-sm text-slate-600 font-medium">Page '.$i_2_pageno.' of '.$i_2_pageno_count.'</span>';
    if($i_2_pageno < $i_2_pageno_count) {
        echo '<a href="test-manager.php?action=groups&pageno2='.min(($i_2_pageno+1), $i_2_pageno_count).$i_testids_addon.$i_order_addon.$i_2_order_addon.$i_2_url_limitto_addon.'" class="p-2 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>';
    }
    echo '</div>';
}
echo '</div>';

// Table
echo '<div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">';
echo '  <div class="overflow-x-auto">';
echo '    <table class="w-full text-left border-collapse">';
echo '      <thead>';
echo '        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">';
echo '          <th class="px-6 py-4 w-10"><input type="checkbox" name="toggleAll" onclick="toggleCBs(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"></th>';

foreach($i_2_tablefields as $i_fieldno=>$i_field) {
    $i_content = $i_field[0];
    if($i_field[2]) {
        $sortIcon = '';
        if($i_2_order_no==$i_fieldno) {
            $sortIcon = !$i_2_direction ? ' <span class="text-indigo-600">▲</span>' : ' <span class="text-indigo-600">▼</span>';
        } else {
            $sortIcon = ' <span class="text-slate-300 group-hover:text-slate-400">▲</span>';
        }
        $nextDir = ($i_2_order_no==$i_fieldno && !$i_2_direction) ? "DESC" : "";
        $i_content = '<a href="test-manager.php?action=groups'.$i_testids_addon.$i_order_addon.$i_2_url_limit_addon.'&order2='.$i_fieldno.'&direction2='.$nextDir.'" class="group flex items-center gap-1 hover:text-indigo-600 transition-colors">'.$i_content.$sortIcon.'</a>';
    }
    echo '<th class="px-6 py-4 whitespace-nowrap">'.$i_content.'</th>';
}
echo '          <th class="px-6 py-4 text-center">'.$lngstr['page_assignto_hdr_assignto'].'</th>';
echo '          <th class="px-6 py-4 text-center">'.$lngstr['label_hdr_action'].'</th>';
echo '        </tr>';
echo '      </thead>';
echo '      <tbody class="divide-y divide-slate-100">';

$i_rSet3 = $g_db->SelectLimit("SELECT * FROM ".$srv_settings['table_prefix']."groups".$i_2_sql_order_addon, $i_2_limitcount, $i_2_limitfrom);

if(!$i_rSet3) {
    showDBError(__FILE__, 3);
} else {
    while(!$i_rSet3->EOF) { 
        $i_member_count = getRecordCount($srv_settings['table_prefix'].'groups_tests', $i_sql_where_addon."groupid=".$i_rSet3->fields["groupid"]);
        
        echo '<tr class="hover:bg-slate-50 transition-colors group">';
        echo '<td class="px-6 py-4"><input type="checkbox" name="box_groups[]" value="'.$i_rSet3->fields["groupid"].'" onclick="toggleCB(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"></td>';
        echo '<td class="px-6 py-4 text-sm text-slate-600 font-mono">'.$i_rSet3->fields["groupid"].'</td>';
        echo '<td class="px-6 py-4 text-sm font-medium text-slate-800">'.getTruncatedHTML($i_rSet3->fields["group_name"]).'</td>';
        echo '<td class="px-6 py-4 text-sm text-slate-600">'.$i_rSet3->fields["group_description"].'</td>';
        
        // Assign Toggle
        echo '<td class="px-6 py-4 text-center">';
        echo '<a href="test-manager.php?action=assignto&groupid='.$i_rSet3->fields["groupid"].$i_order_addon.$i_testids_addon.$i_2_url_limit_addon.'&set='.($i_member_count>=sizeof($f_testids) ? '0" class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold border border-green-200 hover:bg-green-200 transition-colors">'.$lngstr['label_yes'] : ($i_member_count>0 ? '1" class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold border border-yellow-200 hover:bg-yellow-200 transition-colors">'.$lngstr['label_partially'] : '1" class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200 hover:bg-slate-200 transition-colors">'.$lngstr['label_no'])).'</a>';
        echo '</td>';
        
        // Actions
        echo '<td class="px-6 py-4 text-center whitespace-nowrap">';
        echo '<div class="flex items-center justify-center gap-2">';
        echo '<a href="groups.php?groupid='.$i_rSet3->fields["groupid"].'&action=edit" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors" title="'.$lngstr['label_action_group_edit'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>';
        echo '<a href="groups.php?groupid='.$i_rSet3->fields["groupid"].'&action=delete" onclick="return confirmMessage(this, \''.$lngstr['qst_delete_group'].'\')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="'.$lngstr['label_action_group_delete'].'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        
        $i_rSet3->MoveNext();
    }
    $i_rSet3->Close();
}
echo '      </tbody>';
echo '    </table>';
echo '  </div>';
echo '</div>';
echo '</form>';
echo '</div>';
displayTemplate('_footer');
?>
