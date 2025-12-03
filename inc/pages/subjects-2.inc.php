<?php
$g_vars['page']['location'] = array('question_bank', 'subjects', 'edit_subject');
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$f_subjectid = (int)readGetVar('subjectid');
$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'subjects-2';
$g_vars['page']['menu_2_items'] = getMenu2Items($g_vars['page']['selected_section']);
writePanel2($g_vars['page']['menu_2_items']);

$i_rSet1 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."subjects WHERE subjectid=$f_subjectid");
if(!$i_rSet1) {
	showDBError(__FILE__, 1);
} else {
	if(!$i_rSet1->EOF) { 
        // Prepare Parent Subjects List
        $i_subjects = array();
        $i_rSet2 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."subjects ORDER BY subject_name");
        if(!$i_rSet2) {
            showDBError(__FILE__, 2);
        } else {
            while(!$i_rSet2->EOF) {
                // Prevent selecting itself as parent
                if($i_rSet2->fields['subjectid'] != $f_subjectid) {
                    $i_subjects[$i_rSet2->fields['subjectid']] = $i_rSet2->fields['subject_name'];
                }
                $i_rSet2->MoveNext();
            }
            $i_rSet2->Close();
        }
?>

<div class="mt-6 max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-slate-700 tracking-tight"><?php echo $lngstr['page_header_subjects_settings']; ?></h2>
            <p class="text-slate-500 mt-1"><?php echo $lngstr['page_subjects_subjectid']; ?>: <span class="font-mono text-indigo-600 font-semibold"><?php echo $i_rSet1->fields['subjectid']; ?></span></p>
        </div>
        <a href="subjects.php" class="text-slate-500 hover:text-indigo-600 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <?php echo $lngstr['button_cancel']; ?>
        </a>
    </div>

    <?php writeErrorsWarningsBar(); ?>

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-neumorphic p-8 border border-white/50">
        <form method="post" action="subjects.php?subjectid=<?php echo $f_subjectid; ?>&action=edit" onsubmit="return validateForm(this);">
            
            <!-- Subject Name -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    <?php echo $lngstr['page_subjects_subjectname']; ?> <span class="text-red-500">*</span>
                </label>
                <input type="text" name="subject_name" value="<?php echo htmlspecialchars($i_rSet1->fields['subject_name']); ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all bg-slate-50 focus:bg-white" required>
            </div>

            <!-- Parent Subject -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Parent Subject
                </label>
                <div class="relative">
                    <select name="subject_parent_subjectid" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all bg-slate-50 focus:bg-white appearance-none cursor-pointer">
                        <option value="0"><?php echo $lngstr['label_none']; ?></option>
                        <?php
                        foreach($i_subjects as $id => $name) {
                            $selected = ($id == $i_rSet1->fields['subject_parent_subjectid']) ? 'selected' : '';
                            echo '<option value="'.$id.'" '.$selected.'>'.htmlspecialchars($name).'</option>';
                        }
                        ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-1">Select a parent subject to organize subjects in a hierarchy.</p>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    <?php echo $lngstr['page_subjects_subjectdescription']; ?>
                </label>
                <textarea name="subject_description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all bg-slate-50 focus:bg-white resize-none"><?php echo htmlspecialchars($i_rSet1->fields['subject_description']); ?></textarea>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                <button type="submit" name="bsubmit" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <?php echo $lngstr['button_update']; ?>
                </button>
                
                <button type="submit" name="bcancel" class="px-6 py-3 bg-white text-slate-600 font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-slate-800 transition-all">
                    <?php echo $lngstr['button_cancel']; ?>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function validateForm(form) {
    if (form.subject_name.value.trim() == "") {
        alert("<?php echo $lngstr['page_subjects_subjectname']; ?> cannot be empty.");
        form.subject_name.focus();
        return false;
    }
    return true;
}
</script>

<?php
	}
	$i_rSet1->Close();
}
displayTemplate('_footer');
?>
