<?php /* Smarty version 2.6.18, created on 2025-12-02 10:53:44
         compiled from testmanager-questions-import.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'getInTagValue', 'testmanager-questions-import.tpl.html', 14, false),array('function', 'getInputElement', 'testmanager-questions-import.tpl.html', 26, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_menu-2.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['g_vars']['page']['header']; ?>
</h2>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_notifications.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="neumorphic-light rounded-2xl p-6 mb-6">

<div class="mb-4">
    <label class="block text-pastel-cadet font-semibold mb-2"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['document_label']; ?>
</label>
    <textarea name="import_document" class="neumorphic-light-inset w-full h-64 p-4 rounded-xl border border-white/20 bg-white/50 focus:ring-2 focus:ring-pastel-cadet/50 focus:outline-none transition-all font-mono text-sm" placeholder="<?php echo smarty_function_getInTagValue(array('text' => $this->_tpl_vars['lngstr']['page_importtest_ut_import_document_hint']), $this);?>
"></textarea>
    <p class="text-xs text-slate-500 mt-1"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['document_howto']; ?>
</p>
</div>

<div class="mb-4">
    <a class="flex justify-between items-center w-full text-left font-semibold text-pastel-cadet" href="javascript:void(0)" onclick="javascript:toggleSection('div_testmanager_import')">
        <span><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['section_delimiters']; ?>
</span>
        <svg class="w-5 h-5 transform transition-transform" id="div_testmanager_import_icon" style="<?php if ($_COOKIE['div_testmanager_import'] && $_COOKIE['div_testmanager_import'] == 'Y'): ?>transform: rotate(180deg);<?php endif; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </a>
    <div id="div_testmanager_import" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6" style="display:<?php if ($_COOKIE['div_testmanager_import'] && $_COOKIE['div_testmanager_import'] == 'Y'): ?>grid<?php else: ?>none<?php endif; ?>">
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['question_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'question_delimiter','value' => $this->_tpl_vars['g_vars']['page']['question_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['answer_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'answer_delimiter','value' => $this->_tpl_vars['g_vars']['page']['answer_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['answer2_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'answer2_delimiter','value' => $this->_tpl_vars['g_vars']['page']['answer2_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['correct_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'correct_delimiter','value' => $this->_tpl_vars['g_vars']['page']['correct_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['points_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'points_delimiter','value' => $this->_tpl_vars['g_vars']['page']['points_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['type_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'type_delimiter','value' => $this->_tpl_vars['g_vars']['page']['type_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['subject_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'subject_delimiter','value' => $this->_tpl_vars['g_vars']['page']['subject_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['preq_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'preq_delimiter','value' => $this->_tpl_vars['g_vars']['page']['preq_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
        <div class="flex items-center">
            <label class="w-1/3 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['postq_delimiter']; ?>
</label>
            <?php echo smarty_function_getInputElement(array('name' => 'postq_delimiter','value' => $this->_tpl_vars['g_vars']['page']['postq_delimiter'],'class' => "neumorphic-light-inset w-2/3 p-2"), $this);?>

        </div>
    </div>
</div>
<script>
function toggleSection(sectionId) {
    const section = document.getElementById(sectionId);
    const icon = document.getElementById(sectionId + '_icon');
    if (section.style.display === 'none') {
        section.style.display = 'grid';
        icon.style.transform = 'rotate(180deg)';
        document.cookie = sectionId + '=Y; path=/;';
    } else {
        section.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
        document.cookie = sectionId + '=N; path=/;';
    }
}
</script>

<div class="flex justify-center gap-4 mt-6">
    <input class="neumorphic-light px-6 py-3 font-bold rounded-xl" type="submit" name="bsubmit" value=" <?php echo $this->_tpl_vars['lngstr']['button_import']; ?>
 ">
    <input class="neumorphic-light px-6 py-3 font-bold rounded-xl" type="submit" name="bcancel" value=" <?php echo $this->_tpl_vars['lngstr']['button_cancel']; ?>
 ">
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>