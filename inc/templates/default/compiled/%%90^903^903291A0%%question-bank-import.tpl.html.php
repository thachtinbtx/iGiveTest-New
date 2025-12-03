<?php /* Smarty version 2.6.18, created on 2025-12-02 10:54:38
         compiled from question-bank-import.tpl.html */ ?>
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

<p><form method=post action="question-bank.php?action=import">
<input type="hidden" name="action_type" value="preview">

<div class="neumorphic-light rounded-2xl p-6 mb-6">
    <h3 class="text-xl font-bold text-pastel-cadet mb-4">Instructions (Simple Format)</h3>
    <div class="bg-white/40 rounded-xl p-4 mb-4 text-slate-700 text-sm">
        <p class="mb-2"><strong>Format:</strong></p>
        <ul class="list-disc pl-5 space-y-1">
            <li><strong>Line 1:</strong> Question text</li>
            <li><strong>Next lines:</strong> Answers</li>
            <li><strong>Correct Answer:</strong> Add a <code>*</code> before the correct answer (e.g., <code>*Hanoi</code>)</li>
            <li><strong>Separator:</strong> Leave a blank line between questions</li>
        </ul>
        <p class="mt-4 mb-2"><strong>Example:</strong></p>
        <pre class="bg-slate-800 text-slate-200 p-3 rounded-lg font-mono text-xs">
Question: What is the capital of Vietnam?
Ho Chi Minh City
*Hanoi
Da Nang

Question: 2 + 2 = ?
3
*4
5
</pre>
    </div>

    <div class="mb-4">
        <label class="block text-pastel-cadet font-semibold mb-2">Select Subject / Chọn chủ đề:</label>
        <select name="import_subject" class="w-full p-3 rounded-xl border border-white/20 bg-white/50 focus:ring-2 focus:ring-pastel-cadet/50 focus:outline-none transition-all">
            <?php $_from = $this->_tpl_vars['g_vars']['page']['subjects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subjectid'] => $this->_tpl_vars['subject_name']):
?>
                <option value="<?php echo $this->_tpl_vars['subjectid']; ?>
" <?php if ($this->_tpl_vars['subjectid'] == $this->_tpl_vars['g_vars']['page']['default_subject']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['subject_name']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
        </select>
        <p class="text-xs text-slate-500 mt-1">All imported questions will be assigned to this subject</p>
    </div>

    <div class="mb-4">
        <label class="block text-pastel-cadet font-semibold mb-2"><?php echo $this->_tpl_vars['lngstr']['page_testmanager_import']['document_label']; ?>
</label>
        <textarea name="import_document" class="w-full h-64 p-4 rounded-xl border border-white/20 bg-white/50 focus:ring-2 focus:ring-pastel-cadet/50 focus:outline-none transition-all font-mono text-sm" placeholder="Paste your questions here..."></textarea>
    </div>

    <div class="flex justify-center gap-4">
        <button type="submit" name="bsubmit" class="neumorphic-light px-6 py-3 font-bold rounded-xl">Preview Import</button>
        <button type="submit" name="bcancel" class="neumorphic-light px-6 py-3 font-bold rounded-xl text-slate-600">Cancel</button>
    </div>
</div>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>