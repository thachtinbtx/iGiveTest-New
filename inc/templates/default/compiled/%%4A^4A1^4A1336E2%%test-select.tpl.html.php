<?php /* Smarty version 2.6.18, created on 2025-12-03 14:42:24
         compiled from test-select.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'test-select.tpl.html', 19, false),array('function', 'getPrintF', 'test-select.tpl.html', 82, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="min-h-screen p-4 sm:p-6 font-sans text-main">

  <!-- Header Card -->
  <div class="neu-card mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
    <div>
      <h2 class="text-3xl font-bold text-accent tracking-tight"><?php echo $this->_tpl_vars['g_vars']['page']['header']; ?>
</h2>
      <?php if ($this->_tpl_vars['g_vars']['page']['header2']): ?>
        <p class="text-muted mt-2"><?php echo $this->_tpl_vars['g_vars']['page']['header2']; ?>
</p>
      <?php endif; ?>
    </div>
    
    <!-- User Score / Points -->
    <?php if ($this->_tpl_vars['g_vars']['page']['user_points_max'] > 0): ?>
    <div class="neu-card px-6 py-3 flex items-center gap-3 !p-3">
       <div class="text-sm text-accent font-medium">Your Score</div>
       <div class="text-2xl font-bold text-main"><?php echo ((is_array($_tmp=$this->_tpl_vars['g_vars']['page']['user_score'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
%</div>
    </div>
    <?php endif; ?>
  </div>

  <!-- Tests Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    
    <?php $_from = $this->_tpl_vars['g_vars']['page']['test']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i_testno'] => $this->_tpl_vars['test']):
?>
      <?php if ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['visible']): ?>
        <div class="neu-card group flex flex-col overflow-hidden relative !p-0 border border-white/60 shadow-lg hover:shadow-xl transition-all duration-300">
          
          <!-- Status Badge -->
          <div class="absolute top-4 right-4 z-10">
             <?php if ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['status'] == IGT_TEST_STATUS_INPROGRESS): ?>
                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider shadow-sm">
                   <?php echo $this->_tpl_vars['lngstr']['page_panel_status_inprogress']; ?>

                </span>
             <?php elseif ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['status'] == IGT_TEST_STATUS_AVAILABLE): ?>
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider shadow-sm">
                   Available
                </span>
             <?php else: ?>
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider shadow-sm">
                   Locked
                </span>
             <?php endif; ?>
          </div>

          <div class="p-6 flex-grow">
             <div class="text-xs font-bold text-accent mb-2 uppercase tracking-wide">Test ID: <?php echo $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['testid']; ?>
</div>
             
             <h3 class="text-xl font-bold text-main mb-3 leading-tight group-hover:text-accent transition-colors">
                <?php echo $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['name']; ?>

             </h3>
             
             <?php if ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['description']): ?>
               <p class="text-muted text-sm line-clamp-3 mb-4">
                 <?php echo $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['description']; ?>

               </p>
             <?php endif; ?>

             <div class="text-sm text-muted mt-auto pt-4 border-t border-slate-100/20">
                <?php if ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['status_label']): ?>
                   <div class="flex items-center gap-2">
                      <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                      <?php echo $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['status_label']; ?>

                   </div>
                <?php endif; ?>
             </div>
          </div>

          <!-- Action Button -->
             <div class="p-4 bg-slate-50/50 border-t border-slate-100/80">
                <?php if ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['status']): ?>
                   <?php if ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['test_purchased']): ?>
                      <a class="neu-btn neu-btn-primary w-full text-base font-bold py-3" 
                         <?php if ($this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['content_protection']): ?>href="javascript:void(0)" onClick="showDialog('test.php?testid=<?php echo $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['testid']; ?>
', 800, 600)"<?php else: ?>href="test.php?testid=<?php echo $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['testid']; ?>
"<?php endif; ?>>
                         <?php echo $this->_tpl_vars['lngstr']['page_panel_get_test_link']; ?>

                      </a>
                   <?php else: ?>
                      <a class="neu-btn neu-btn-success w-full text-base font-bold py-3" 
                         href="buy.php?action=checkout&testid=<?php echo $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['testid']; ?>
">
                         <?php echo $this->_tpl_vars['lngstr']['page_takeatest']['buy_test']; ?>
 (<?php echo smarty_function_getPrintF(array('text' => $this->_tpl_vars['lngstr']['language']['currency'],'var1' => $this->_tpl_vars['g_vars']['page']['test'][$this->_tpl_vars['i_testno']]['test_price']), $this);?>
)
                      </a>
                   <?php endif; ?>
                <?php else: ?>
                   <button disabled class="neu-btn w-full text-base font-bold py-3">
                      <?php echo $this->_tpl_vars['lngstr']['page_panel_get_test_link']; ?>

                   </button>
                <?php endif; ?>
             </div>

        </div>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

  </div>

  <?php if ($this->_tpl_vars['g_vars']['page']['test_count'] == 0): ?>
    <div class="neu-card p-10 text-center text-muted">
       <svg class="w-16 h-16 mx-auto opacity-50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
       <p class="text-lg"><?php echo $this->_tpl_vars['lngstr']['err_no_tests']; ?>
</p>
    </div>
  <?php endif; ?>

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>