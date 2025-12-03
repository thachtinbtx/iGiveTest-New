<?php /* Smarty version 2.6.18, created on 2025-12-02 15:44:17
         compiled from reports-manager-details.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'reports-manager-details.tpl.html', 84, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="min-h-screen p-4 sm:p-6">
  
    <div class="relative z-10">

        <!-- Header Card -->
        <div class="neu-card mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-accent tracking-tight"><?php echo $this->_tpl_vars['g_vars']['page']['header']; ?>
</h2>
                    <a href="reports-manager.php" class="text-sm font-semibold text-muted hover:text-accent transition-colors">← Back to All Results</a>
                </div>
            </div>
        </div>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_notifications.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <?php if ($this->_tpl_vars['g_vars']['page']['can_access']): ?>
            <!-- Proctoring Warning Card -->
            <?php if ($this->_tpl_vars['g_vars']['page']['time_away'] > 0): ?>
                <div class="neu-card border-l-4 border-red-400 p-4 mb-6">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                      </svg>
                    </div>
                    <div class="ml-3">
                      <p class="text-sm text-red-600">
                        <span class="font-bold">Proctoring Warning:</span> The user was away from the test screen for a total of <span class="font-bold"><?php echo $this->_tpl_vars['g_vars']['page']['time_away_formatted']; ?>
</span>.
                      </p>
                    </div>
                  </div>
                </div>
            <?php endif; ?>

            <!-- Results Details Table -->
            <div class="neu-card overflow-hidden mt-6 p-0">
                <div class="overflow-x-auto">
                    <table class="neu-table w-full">
                        <thead>
                            <tr>
                                <?php $_from = $this->_tpl_vars['g_vars']['page']['table_headers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header']):
?>
                                    <th class="whitespace-nowrap <?php echo $this->_tpl_vars['header']['class']; ?>
">
                                        <?php if ($this->_tpl_vars['header']['sortable']): ?>
                                            <a href="<?php echo $this->_tpl_vars['header']['sort_url']; ?>
" class="group flex items-center gap-1 hover:text-accent transition-colors">
                                                <?php echo $this->_tpl_vars['header']['text']; ?>

                                                <?php echo $this->_tpl_vars['header']['sort_icon']; ?>

                                            </a>
                                        <?php else: ?>
                                            <?php echo $this->_tpl_vars['header']['text']; ?>

                                        <?php endif; ?>
                                    </th>
                                <?php endforeach; endif; unset($_from); ?>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $_from = $this->_tpl_vars['g_vars']['page']['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <tr class="hover:bg-white/30 transition-colors">
                                    <td class="text-sm text-main font-medium min-w-[120px] max-w-[120px] md:max-w-xs truncate" title="<?php echo $this->_tpl_vars['row']['question_text_full']; ?>
"><?php echo $this->_tpl_vars['row']['question_text']; ?>
</td>
                                    <td class="text-sm text-main font-medium min-w-[120px] max-w-[120px] md:max-w-xs truncate" title="<?php echo $this->_tpl_vars['row']['answer_text_full']; ?>
"><?php echo $this->_tpl_vars['row']['answer_text']; ?>
</td>
                                    <td class="text-sm text-muted text-right font-bold"><?php echo $this->_tpl_vars['row']['points']; ?>
</td>
                                    <td class="text-center">
                                        <?php echo $this->_tpl_vars['row']['is_correct_icon']; ?>

                                    </td>
                                    <td class="text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="<?php echo $this->_tpl_vars['row']['view_url']; ?>
" class="p-2 text-accent hover:bg-white/50 rounded-lg transition-colors" title="View Answer Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <?php if ($this->_tpl_vars['g_vars']['page']['can_edit_questions']): ?>
                                                <a href="<?php echo $this->_tpl_vars['row']['edit_url']; ?>
" class="p-2 text-muted hover:bg-white/50 rounded-lg transition-colors" title="Edit Original Question">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="<?php echo count($this->_tpl_vars['g_vars']['page']['table_headers']); ?>
" class="px-6 py-8 text-center text-muted italic"><?php echo $this->_tpl_vars['lngstr']['inf_no_records_found']; ?>
</td>
                                </tr>
                            <?php endif; unset($_from); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>