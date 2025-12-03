<?php
$g_vars['page']['location'] = array('test_manager', 'grading_systems');
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'grades';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);

// Floating orbs
echo '<div class="fixed -top-32 -left-32 w-64 h-64 bg-gradient-radial from-pastel-mint/15 to-transparent rounded-full blur-3xl floating-slow pointer-events-none"></div>';
echo '<div class="fixed top-1/2 -right-32 w-64 h-64 bg-gradient-radial from-pastel-lavender/15 to-transparent rounded-full blur-3xl floating pointer-events-none"></div>';

// Modern header
echo '<div class="glass-panel-strong rounded-2xl shadow-neumorphic p-6 mb-6 relative z-10">';
echo '<div class="flex items-center gap-4">';
echo '<div class="bg-pastel-mint/20 rounded-2xl p-3 shadow-neumorphic-sm">';
echo '<svg class="w-8 h-8 text-pastel-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>';
echo '</div>';
echo '<div>';
echo '<h2 class="text-3xl font-bold text-pastel-mint tracking-tight">'.$lngstr['page_header_grades'].'</h2>';
echo '<p class="text-slate-600 mt-1">'.$lngstr['tooltip_gscales'].'</p>';
echo '</div>';
echo '</div>';
echo '</div>';

writeErrorsWarningsBar();
$i_pagewide_id = 0; 
$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
	array($lngstr["label_grades_hdr_gscaleid"], $lngstr["label_grades_hdr_gscaleid_hint"], "gscaleid"),
	array($lngstr["label_grades_hdr_gscale_name"], $lngstr["label_grades_hdr_gscale_name_hint"], "gscale_name"),
	array($lngstr["label_grades_hdr_gscale_description"], $lngstr["label_grades_hdr_gscale_description_hint"], "gscale_description"),
);
$i_order_no = isset($_GET["order"]) ? (int)$_GET["order"] : 0;
if($i_order_no>=count($i_tablefields))
 $i_order_no = -1;
if($i_order_no>=0) {
	$i_direction = (isset($_GET["direction"]) && $_GET["direction"]) ? "DESC" : "";
$i_order_addon = "&order=".$i_order_no."&direction=".$i_direction;
$i_sql_order_addon = " ORDER BY ".$i_tablefields[$i_order_no][2]." ".$i_direction;
} 
$i_url_limitto_addon = "";
$i_url_pageno_addon = "";
$i_url_limit_addon = "";
$i_pageno = 0;
$i_limitcount = isset($_GET["limitto"]) ? (int)$_GET["limitto"] : $G_SESSION['config_itemsperpage'];
if($i_limitcount>0) {
	$i_recordcount = getRecordCount($srv_settings['table_prefix'].'gscales');
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
	$i_url_limitto_addon = "&limitto=";
$i_url_limit_addon .= $i_url_limitto_addon;
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
 
echo '<form name=gradesForm class=iactive method=post>';
echo '<div class="glass-panel rounded-2xl shadow-neumorphic-sm mb-6 overflow-hidden">';
echo '<div class="p-4 flex flex-wrap justify-between items-center gap-3">';

// Action Buttons
echo '<div class="flex flex-wrap gap-2">';
echo '<a href="grades.php?action=create" class="btn-neumorphic-primary px-4 py-2.5 flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg><span class="font-semibold">'.$lngstr['label_action_create_grade'].'</span></a>';
echo '<button type="button" onclick="f=document.gradesForm;if (confirm(\''.$lngstr['qst_delete_grades'].'\')) { f.action=\'grades.php?action=delete&confirmed=1\';f.submit();}" class="btn-neumorphic-danger px-4 py-2.5 flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg><span class="font-semibold">'.$lngstr['label_action_grades_delete'].'</span></button>';
echo '</div>';

// Pagination
if($i_limitcount > 0) {
	$i_url_pages_addon = $i_url_limitto_addon.$i_order_addon;
	echo '<div class="flex items-center gap-2">';
	echo '<span class="text-sm text-slate-600 font-medium">'.sprintf($lngstr['label']['KtoLofN'], $nRecordFrom, $nRecordTo, $i_recordcount).'</span>';
	echo '<div class="flex gap-1">';
	for($i = $nStartPage; $i <= $nEndPage; $i++) {
		if($i != $i_pageno)
			echo '<a href="grades.php?pageno='.$i.$i_url_pages_addon.'" class="px-3 py-1 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic text-sm font-semibold text-slate-700 transition-all">'.$i.'</a>';
		else echo '<span class="px-3 py-1 rounded-lg bg-pastel-mint/30 text-pastel-mint font-bold text-sm">'.$i.'</span>';
	}
	echo '</div>';
	
	// First/Prev/Next/Last
	echo '<div class="flex gap-1">';
	if($i_pageno > 1) {
		echo '<a href="grades.php?pageno=1'.$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_first_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></a>';
		echo '<a href="grades.php?pageno='.max(($i_pageno-1), 1).$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_prev_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>';
	} else {
		echo '<span class="p-2 rounded-lg bg-slate-100 text-slate-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></span>';
		echo '<span class="p-2 rounded-lg bg-slate-100 text-slate-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></span>';
	}
	if($i_pageno < $i_pageno_count) {
		echo '<a href="grades.php?pageno='.min(($i_pageno+1), $i_pageno_count).$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_next_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>';
		echo '<a href="grades.php?pageno='.$i_pageno_count.$i_url_pages_addon.'" class="p-2 rounded-lg glass-card shadow-neumorphic-sm hover:shadow-neumorphic transition-all" title="'.$lngstr['button_last_page'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></a>';
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
echo '<thead><tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider">';
echo '<th class="p-3 w-12 text-center"><input type=checkbox name=toggleAll onclick="toggleCBs(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></th>';
echo '<th class="p-3 w-20 text-right font-semibold">'.$lngstr["label_grades_hdr_gscaleid"].'</th>';
echo '<th class="p-3 w-1/3 font-semibold">'.$lngstr["label_grades_hdr_gscale_name"].'</th>';
echo '<th class="p-3 font-semibold">'.$lngstr["label_grades_hdr_gscale_description"].'</th>';
echo '<th class="p-3 w-32 text-center font-semibold">'.$lngstr['label_hdr_action'].'</th>';
echo '</tr></thead><tbody class="divide-y divide-slate-200">';

$i_rSet1 = $g_db->SelectLimit("SELECT * FROM ".$srv_settings['table_prefix']."gscales".$i_sql_order_addon, $i_limitcount, $i_limitfrom);
if(!$i_rSet1) {
	showDBError(__FILE__, 1);
} else {
	$i_counter = 0;
while(!$i_rSet1->EOF) {
 $rowname = ($i_counter % 2) ? "rowone" : "rowtwo";
 $is_system = $i_rSet1->fields["gscaleid"] <= SYSTEM_GRADES_MAX_INDEX;
echo '<tr class="hover:bg-slate-50 transition-colors duration-200 group">';
echo '<td class="p-3 text-center"><input id=cb_'.$i_pagewide_id.' type=checkbox name=box_grades[] value="'.$i_rSet1->fields["gscaleid"].'" onclick="toggleCB(this);" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"></td>';
echo '<td class="p-3 text-right font-mono text-xs text-slate-400">#'.$i_rSet1->fields["gscaleid"].'</td>';
echo '<td class="p-3 text-slate-700 font-medium text-sm">'.getTruncatedHTML($i_rSet1->fields["gscale_name"]).'</td>';
echo '<td class="p-3 text-slate-600 text-sm">'.$i_rSet1->fields["gscale_description"].'</td>';
echo '<td class="p-3"><div class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">';
echo '<a href="grades.php?gscaleid='.$i_rSet1->fields["gscaleid"].'&action=settings" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" title="'.$lngstr['label_action_grade_settings'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></a>';
echo '<a href="grades.php?gscaleid='.$i_rSet1->fields["gscaleid"].'&action=edit" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="'.$lngstr['label_action_gradescales_edit'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>';
if(!$is_system) {
	echo '<a href="grades.php?gscaleid='.$i_rSet1->fields["gscaleid"].$i_url_limit_addon.'&action=delete" onclick="return confirmMessage(this, \''.$lngstr['qst_delete_grade'].'\')" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="'.$lngstr['label_action_grade_delete'].'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>';
} else {
	echo '<span class="p-1.5 text-slate-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></span>';
}
echo '</div></td></tr>';
$i_counter++;
$i_pagewide_id++;
$i_rSet1->MoveNext();
}
$i_rSet1->Close();
}
echo '</tbody></table>';
echo '</div></div></form>';
displayTemplate('_footer');
?>
