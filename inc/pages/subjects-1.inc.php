<?php
$g_vars['page']['location'] = array('question_bank', 'subjects');
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'subjects';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);

// --- Logic for Pagination & Sorting (Preserved) ---
$i_pagewide_id = 0; 
$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
	array($lngstr["label_subjects_hdr_subjectid"], $lngstr["label_subjects_hdr_subjectid_hint"], $srv_settings['table_prefix']."subjects.subjectid"),
	array($lngstr["label_subjects_hdr_subject_name"], $lngstr["label_subjects_hdr_subject_name_hint"], $srv_settings['table_prefix']."subjects.subject_name"),
	array($lngstr["label_subjects_hdr_subject_description"], $lngstr["label_subjects_hdr_subject_description_hint"], $srv_settings['table_prefix']."subjects.subject_description"),
);
$i_order_no = isset($_GET["order"]) ? (int)$_GET["order"] : 0;
if($i_order_no>=count($i_tablefields)) $i_order_no = -1;
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
	$i_recordcount = getRecordCount($srv_settings['table_prefix'].'subjects');
	$i_pageno = isset($_GET["pageno"]) ? (int)$_GET["pageno"] : 1;
	if($i_pageno < 1) $i_pageno = 1;
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
	if ($i_recordcount == 0 || ($i_pageno_count == 1 && $this->NavShowAll == false)) return;
} 
if($i_pageno > floor($nPageWindow/2) + 1 && $i_pageno_count > $nPageWindow)
	$nStartPage = $i_pageno - floor($nPageWindow/2);
else
	$nStartPage = 1; 
if($i_pageno <= $i_pageno_count - floor($nPageWindow/2) && $nStartPage + $nPageWindow-1 <= $i_pageno_count)
	$nEndPage = $nStartPage + $nPageWindow - 1;
else {
	$nEndPage = $i_pageno_count;
	if($nEndPage - $nPageWindow + 1 >= 1) $nStartPage = $nEndPage - $nPageWindow + 1;
}
$nRecordFrom = ($i_pageno - 1) * $i_limitcount + 1;
if($i_pageno != $i_pageno_count) $nRecordTo = $i_pageno * $i_limitcount;
else $nRecordTo = $i_recordcount;

// --- UI Rendering ---
?>

<div class="mt-6">
    <!-- Header & Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-700 tracking-tight"><?php echo $lngstr['page_header_subjects']; ?></h2>
            <p class="text-slate-500 mt-1"><?php echo $lngstr['tooltip_subjects']; ?></p>
        </div>
        
        <div class="flex gap-3">
             <a href="subjects.php?action=create" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-xl shadow-lg shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <?php echo $lngstr['label_action_create_subject']; ?>
            </a>
            
            <button onclick="if(confirm('<?php echo $lngstr['qst_delete_subjects']; ?>')) { document.getElementById('subjectsForm').action='subjects.php?action=delete&confirmed=1'; document.getElementById('subjectsForm').submit(); }" class="flex items-center gap-2 px-5 py-2.5 bg-white text-slate-600 font-medium rounded-xl shadow-neumorphic hover:text-red-500 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <?php echo $lngstr['label_action_subjects_delete']; ?>
            </button>
        </div>
    </div>

    <?php writeErrorsWarningsBar(); ?>

    <!-- Main Content Card -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-neumorphic overflow-hidden border border-white/50">
        <form name="subjectsForm" id="subjectsForm" method="post">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-500 text-sm uppercase tracking-wider">
                            <th class="p-4 w-10 text-center">
                                <input type="checkbox" name="toggleAll" onclick="toggleCBs(this);" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            </th>
                            <!-- Dynamic Headers -->
                            <?php 
                            foreach($i_tablefields as $idx => $field) {
                                $sortIcon = '';
                                if($i_order_no == $idx) {
                                    $sortIcon = ($i_direction == 'DESC') ? '↓' : '↑';
                                } else {
                                    $sortIcon = '↓';
                                }
                                $nextDir = ($i_order_no == $idx && $i_direction) ? "ASC" : "DESC";
                                echo '<th class="p-4 font-semibold hover:text-indigo-600 transition-colors cursor-pointer" onclick="window.location=\'subjects.php?order='.$idx.'&direction='.$nextDir.$i_url_limit_addon.'\'">';
                                echo '<div class="flex items-center gap-1">'.$field[0].' <span class="text-xs">'.$sortIcon.'</span></div>';
                                echo '</th>';
                            }
                            ?>
                            <th class="p-4 text-center font-semibold"><?php echo $lngstr['label_hdr_action']; ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php
                        $i_rSet1 = $g_db->SelectLimit("SELECT * FROM ".$srv_settings['table_prefix']."subjects WHERE 1=1".$i_sql_order_addon, $i_limitcount, $i_limitfrom);
                        if(!$i_rSet1) {
                            showDBError(__FILE__, 1);
                        } else {
                            $i_counter = 0;
                            while(!$i_rSet1->EOF) {
                                $rowClass = ($i_counter % 2) ? "bg-slate-50/30" : "bg-white";
                                ?>
                                <tr class="<?php echo $rowClass; ?> hover:bg-indigo-50/50 transition-colors group">
                                    <td class="p-4 text-center">
                                        <input type="checkbox" name="box_subjects[]" value="<?php echo $i_rSet1->fields["subjectid"]; ?>" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onclick="toggleCB(this);">
                                    </td>
                                    <td class="p-4 text-slate-600 font-mono text-sm">
                                        <?php echo $i_rSet1->fields["subjectid"]; ?>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-slate-700 group-hover:text-indigo-700 transition-colors">
                                            <?php echo getTruncatedHTML($i_rSet1->fields["subject_name"]); ?>
                                        </div>
                                    </td>
                                    <td class="p-4 text-slate-500 text-sm">
                                        <?php echo $i_rSet1->fields["subject_description"]; ?>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="subjects.php?subjectid=<?php echo $i_rSet1->fields["subjectid"]; ?>&action=edit" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="<?php echo $lngstr['label_action_subject_edit']; ?>">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <?php if($i_rSet1->fields["subjectid"] > SYSTEM_SUBJECTS_MAX_INDEX) { ?>
                                                <a href="subjects.php?subjectid=<?php echo $i_rSet1->fields["subjectid"].$i_url_limit_addon; ?>&action=delete" onclick="return confirmMessage(this, '<?php echo $lngstr['qst_delete_subject']; ?>')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="<?php echo $lngstr['label_action_subject_delete']; ?>">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </a>
                                            <?php } else { ?>
                                                <span class="p-2 text-slate-200 cursor-not-allowed">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i_counter++;
                                $i_rSet1->MoveNext();
                            }
                            $i_rSet1->Close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($i_limitcount > 0 && $i_recordcount > 0) { ?>
            <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-slate-500">
                    <?php echo sprintf($lngstr['label']['KtoLofN'], $nRecordFrom, $nRecordTo, $i_recordcount); ?>
                </div>
                
                <div class="flex items-center gap-1">
                    <?php
                    $i_url_pages_addon = $i_url_limitto_addon.$i_order_addon;
                    
                    // First & Prev
                    if($i_pageno > 1) {
                        echo '<a href="subjects.php?pageno=1'.$i_url_pages_addon.'" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors" title="'.$lngstr['button_first_page'].'">&laquo;</a>';
                        echo '<a href="subjects.php?pageno='.max(($i_pageno-1), 1).$i_url_pages_addon.'" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors" title="'.$lngstr['button_prev_page'].'">&lsaquo;</a>';
                    } else {
                        echo '<span class="p-2 text-slate-300 cursor-default">&laquo;</span>';
                        echo '<span class="p-2 text-slate-300 cursor-default">&lsaquo;</span>';
                    }

                    // Page Numbers
                    for($i = $nStartPage; $i <= $nEndPage; $i++) {
                        if($i != $i_pageno)
                            echo '<a href="subjects.php?pageno='.$i.$i_url_pages_addon.'" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-600 text-sm transition-colors">'.$i.'</a>';
                        else 
                            echo '<span class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-500 text-white text-sm font-medium shadow-md shadow-indigo-200">'.$i.'</span>';
                    }

                    // Next & Last
                    if($i_pageno < $i_pageno_count) {
                        echo '<a href="subjects.php?pageno='.min(($i_pageno+1), $i_pageno_count).$i_url_pages_addon.'" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors" title="'.$lngstr['button_next_page'].'">&rsaquo;</a>';
                        echo '<a href="subjects.php?pageno='.$i_pageno_count.$i_url_pages_addon.'" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors" title="'.$lngstr['button_last_page'].'">&raquo;</a>';
                    } else {
                        echo '<span class="p-2 text-slate-300 cursor-default">&rsaquo;</span>';
                        echo '<span class="p-2 text-slate-300 cursor-default">&raquo;</span>';
                    }
                    ?>
                </div>
            </div>
            <?php } ?>
        </form>
    </div>
</div>

<?php
displayTemplate('_footer');
?>
