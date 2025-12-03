<?php /* Smarty version 2.6.18, created on 2025-12-02 14:46:29
         compiled from reports-manager.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'reports-manager.tpl.html', 135, false),array('modifier', 'substr', 'reports-manager.tpl.html', 212, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="min-h-screen p-4 sm:p-6">
  
  <!-- Floating Background Orbs for Scientific Feel -->
  <div class="fixed -top-32 -left-32 w-64 h-64 bg-gradient-radial from-pastel-mint/15 to-transparent rounded-full blur-3xl floating-slow pointer-events-none"></div>
  <div class="fixed top-1/2 -right-32 w-64 h-64 bg-gradient-radial from-pastel-sky/15 to-transparent rounded-full blur-3xl floating pointer-events-none"></div>
  
  <div class="relative z-10">

    <!-- Header Card with Glassmorphic Style -->
    <div class="glass-panel-strong rounded-2xl shadow-neumorphic p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
      <div class="flex items-center gap-4">
        <div class="bg-pastel-sky/20 rounded-2xl p-3 shadow-neumorphic-sm">
          <svg class="w-8 h-8 text-pastel-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <div>
          <h2 class="text-3xl font-bold text-pastel-sky tracking-tight"><?php echo $this->_tpl_vars['g_vars']['page']['header']; ?>
</h2>
          <p class="text-slate-600 mt-1">Comprehensive test results analytics</p>
        </div>
      </div>
      
      <!-- Filter Toggle Button -->
      <button class="btn-neumorphic px-5 py-2.5 flex items-center gap-2" onclick="document.getElementById('filterPanel').classList.toggle('hidden');">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
        </svg>
        <span class="font-semibold">Filter Results</span>
      </button>
    </div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_notifications.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <!-- Filter Panel (Hidden by default) -->
    <div id="filterPanel" class="hidden glass-panel rounded-2xl shadow-neumorphic-sm p-6 mb-6">
      <form action="<?php echo $this->_tpl_vars['g_vars']['page']['filter']['url_addon']; ?>
" method="post">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Test</label>
            <?php echo $this->_tpl_vars['g_vars']['page']['testid_content']; ?>

          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">User</label>
            <?php echo $this->_tpl_vars['g_vars']['page']['user_name_content']; ?>

          </div>
          <div class="flex items-end">
            <input type="submit" name="bsetfilter" value="Apply Filters" class="btn-neumorphic-primary px-6 py-2.5 cursor-pointer font-bold w-full">
          </div>
        </div>
      </form>
    </div>

    <!-- Results Table with Glassmorphic Container -->
    <div class="glass-panel-strong rounded-2xl shadow-neumorphic overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-glass hidden md:table">
          <thead>
            <tr class="border-b border-glass text-pastel-cadet text-sm uppercase tracking-wider">
              <th class="p-4 font-bold hidden md:table-cell">
                <a href="reports-manager.php?order=1&direction=<?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 1 && $this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php echo $this->_tpl_vars['g_vars']['page']['addon_limit']; ?>
" class="flex items-center gap-2 hover:text-white transition-colors group">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  Date
                  <?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 1): ?>
                    <span class="text-pastel-sky"><?php if ($this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>▼<?php else: ?>▲<?php endif; ?></span>
                  <?php else: ?>
                    <span class="text-white/20 group-hover:text-white/50">▼</span>
                  <?php endif; ?>
                </a>
              </th>
              <th class="p-4 font-bold">
                <a href="reports-manager.php?order=2&direction=<?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 2 && $this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php echo $this->_tpl_vars['g_vars']['page']['addon_limit']; ?>
" class="flex items-center gap-2 hover:text-white transition-colors group">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  User
                  <?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 2): ?>
                    <span class="text-pastel-sky"><?php if ($this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>▼<?php else: ?>▲<?php endif; ?></span>
                  <?php else: ?>
                    <span class="text-white/20 group-hover:text-white/50">▼</span>
                  <?php endif; ?>
                </a>
              </th>
              <th class="p-4 font-bold">
                <a href="reports-manager.php?order=3&direction=<?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 3 && $this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php echo $this->_tpl_vars['g_vars']['page']['addon_limit']; ?>
" class="flex items-center gap-2 hover:text-white transition-colors group">
                  Test Name
                  <?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 3): ?>
                    <span class="text-pastel-sky"><?php if ($this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>▼<?php else: ?>▲<?php endif; ?></span>
                  <?php else: ?>
                    <span class="text-white/20 group-hover:text-white/50">▼</span>
                  <?php endif; ?>
                </a>
              </th>
              <th class="p-4 font-bold text-center">
                <a href="reports-manager.php?order=8&direction=<?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 8 && $this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php echo $this->_tpl_vars['g_vars']['page']['addon_limit']; ?>
" class="flex items-center justify-center gap-2 hover:text-white transition-colors group">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                  Score
                  <?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 8): ?>
                    <span class="text-pastel-sky"><?php if ($this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>▼<?php else: ?>▲<?php endif; ?></span>
                  <?php else: ?>
                    <span class="text-white/20 group-hover:text-white/50">▼</span>
                  <?php endif; ?>
                </a>
              </th>
              <th class="p-4 font-bold text-center hidden md:table-cell">
                <a href="reports-manager.php?order=10&direction=<?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 10 && $this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php echo $this->_tpl_vars['g_vars']['page']['addon_limit']; ?>
" class="flex items-center justify-center gap-2 hover:text-white transition-colors group">
                  Time Away
                  <?php if ($this->_tpl_vars['g_vars']['page']['orderno'] == 10): ?>
                    <span class="text-pastel-sky"><?php if ($this->_tpl_vars['g_vars']['page']['direction'] == 'DESC'): ?>▼<?php else: ?>▲<?php endif; ?></span>
                  <?php else: ?>
                    <span class="text-white/20 group-hover:text-white/50">▼</span>
                  <?php endif; ?>
                </a>
              </th>
              <th class="p-4 font-bold text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/20">
            <?php $_from = $this->_tpl_vars['g_vars']['page']['tables']['1']['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
            <tr class="hover:bg-white/30 transition-all">
              <td class="p-4 text-slate-700 hidden md:table-cell"><?php echo $this->_tpl_vars['row']['result_datestart_formatted']; ?>
</td>
              <td class="p-4 text-slate-800 font-medium max-w-[120px] truncate" title="<?php echo $this->_tpl_vars['row']['user_name']; ?>
 (<?php echo $this->_tpl_vars['row']['user_firstname']; ?>
 <?php echo $this->_tpl_vars['row']['user_lastname']; ?>
)">
                <?php echo $this->_tpl_vars['row']['user_name']; ?>
 
                <span class="text-slate-500 text-xs block mt-0.5 truncate">(<?php echo $this->_tpl_vars['row']['user_firstname']; ?>
 <?php echo $this->_tpl_vars['row']['user_lastname']; ?>
)</span>
              </td>
              <td class="p-4 text-pastel-cadet font-semibold max-w-[120px] truncate" title="<?php echo $this->_tpl_vars['row']['test_name']; ?>
"><?php echo $this->_tpl_vars['row']['test_name']; ?>
</td>
              <td class="p-4 text-center">
                <span class="inline-flex items-center justify-center min-w-[60px] px-3 py-1.5 rounded-xl text-sm font-bold shadow-neumorphic-sm <?php if ($this->_tpl_vars['row']['result_score'] >= 80): ?>bg-pastel-mint/30 text-pastel-mint border border-pastel-mint/50<?php elseif ($this->_tpl_vars['row']['result_score'] >= 50): ?>bg-pastel-sky/30 text-pastel-sky border border-pastel-sky/50<?php else: ?>bg-pastel-salmon/30 text-pastel-salmon border border-pastel-salmon/50<?php endif; ?>">
                  <?php echo ((is_array($_tmp=$this->_tpl_vars['row']['result_score'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
%
                </span>
              </td>
              <td class="p-4 text-center hidden md:table-cell">
                <?php if ($this->_tpl_vars['row']['result_time_away'] > 0): ?>
                    <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-sm font-bold bg-rose-100 text-rose-600 border border-rose-200">
                        <?php echo $this->_tpl_vars['row']['result_time_away']; ?>
s
                    </span>
                <?php else: ?>
                    <span class="text-slate-400">-</span>
                <?php endif; ?>
              </td>
              <td class="p-4 text-right space-x-2">
                <!-- View Button -->
                <a href="reports-manager.php?action=viewq&resultid=<?php echo $this->_tpl_vars['row']['resultid']; ?>
" 
                   class="inline-flex items-center justify-center w-9 h-9 rounded-xl glass-card shadow-neumorphic-sm hover:shadow-neumorphic text-pastel-sky transition-all" 
                   title="View Details">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                </a>
                
                <!-- Delete Button (if allowed) -->
                <?php if ($_SESSION['MAIN']['access_reportsmanager'] > 2): ?>
                <a href="reports-manager.php?action=delete&resultid=<?php echo $this->_tpl_vars['row']['resultid']; ?>
" 
                   class="inline-flex items-center justify-center w-9 h-9 rounded-xl glass-card shadow-neumorphic-sm hover:shadow-neumorphic text-pastel-salmon transition-all" 
                   title="Delete" 
                   onclick="return confirm('<?php echo $this->_tpl_vars['lngstr']['qst_delete_record']; ?>
');">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </a>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="7" class="p-12 text-center">
                <div class="flex flex-col items-center gap-3">
                  <div class="bg-pastel-sky/20 rounded-full p-4">
                    <svg class="w-12 h-12 text-pastel-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </div>
                  <p class="text-slate-500 font-medium">No results found.</p>
                </div>
              </td>
            </tr>
            <?php endif; unset($_from); ?>
          </tbody>
        </table>
      </div>

      <!-- Mobile Card View -->
      <div class="md:hidden space-y-4 p-4">
        <?php $_from = $this->_tpl_vars['g_vars']['page']['tables']['1']['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
        <div class="neu-card p-4 relative border border-white/60 shadow-lg">
            <!-- Score Badge (Top Right) -->
            <div class="absolute top-4 right-4">
                <span class="inline-flex items-center justify-center min-w-[60px] px-3 py-1.5 rounded-xl text-sm font-bold shadow-neumorphic-sm <?php if ($this->_tpl_vars['row']['result_score'] >= 80): ?>bg-pastel-mint/30 text-pastel-mint border border-pastel-mint/50<?php elseif ($this->_tpl_vars['row']['result_score'] >= 50): ?>bg-pastel-sky/30 text-pastel-sky border border-pastel-sky/50<?php else: ?>bg-pastel-salmon/30 text-pastel-salmon border border-pastel-salmon/50<?php endif; ?>">
                  <?php echo ((is_array($_tmp=$this->_tpl_vars['row']['result_score'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
%
                </span>
            </div>

            <!-- Test Name & Date -->
            <div class="pr-16 mb-3">
                <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1"><?php echo $this->_tpl_vars['row']['test_name']; ?>
</h3>
                <div class="text-xs text-slate-500 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <?php echo $this->_tpl_vars['row']['result_datestart_formatted']; ?>

                </div>
            </div>

            <!-- User Info (if applicable) -->
            <div class="mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['row']['user_firstname'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 1) : substr($_tmp, 0, 1)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['user_lastname'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 1) : substr($_tmp, 0, 1)); ?>

                </div>
                <div class="text-sm text-slate-700">
                    <span class="font-semibold"><?php echo $this->_tpl_vars['row']['user_name']; ?>
</span>
                </div>
            </div>

            <!-- Time Away Warning -->
            <?php if ($this->_tpl_vars['row']['result_time_away'] > 0): ?>
            <div class="mb-4 p-2 rounded-lg bg-rose-50 border border-rose-100 flex items-center gap-2 text-xs text-rose-700">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Away: <strong><?php echo $this->_tpl_vars['row']['result_time_away']; ?>
s</strong></span>
            </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                <a href="reports-manager.php?action=viewq&resultid=<?php echo $this->_tpl_vars['row']['resultid']; ?>
" class="neu-btn-sm px-4 py-2 text-sm w-full text-center">View Details</a>
                
                <?php if ($_SESSION['MAIN']['access_reportsmanager'] > 2): ?>
                <a href="reports-manager.php?action=delete&resultid=<?php echo $this->_tpl_vars['row']['resultid']; ?>
" 
                   class="ml-2 p-2 text-pastel-salmon hover:bg-rose-50 rounded-lg transition-colors" 
                   onclick="return confirm('<?php echo $this->_tpl_vars['lngstr']['qst_delete_record']; ?>
');">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div class="text-center p-8 text-slate-500">No results found.</div>
        <?php endif; unset($_from); ?>
      </div>
      </div>
      
      <!-- Pagination -->
      <?php if ($this->_tpl_vars['g_vars']['page']['page_count'] > 1): ?>
      <div class="p-4 border-soft-top bg-white/20 flex justify-center items-center gap-3">
        <?php if ($this->_tpl_vars['g_vars']['page']['pageno_current'] > 1): ?>
          <a href="<?php echo $this->_tpl_vars['g_vars']['page']['url']; ?>
&pageno=<?php echo $this->_tpl_vars['g_vars']['page']['pageno_previous']; ?>
" 
             class="btn-neumorphic px-4 py-2 text-sm font-semibold">← Previous</a>
        <?php endif; ?>
        
        <span class="glass-card px-4 py-2 rounded-xl shadow-neumorphic-sm text-slate-700 font-bold">
          Page <?php echo $this->_tpl_vars['g_vars']['page']['pageno_current']; ?>
 of <?php echo $this->_tpl_vars['g_vars']['page']['page_count']; ?>

        </span>
        
        <?php if ($this->_tpl_vars['g_vars']['page']['pageno_current'] < $this->_tpl_vars['g_vars']['page']['page_count']): ?>
          <a href="<?php echo $this->_tpl_vars['g_vars']['page']['url']; ?>
&pageno=<?php echo $this->_tpl_vars['g_vars']['page']['pageno_next']; ?>
" 
             class="btn-neumorphic px-4 py-2 text-sm font-semibold">Next →</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>

    </div>

  </div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>