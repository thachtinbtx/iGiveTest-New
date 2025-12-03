<?php /* Smarty version 2.6.18, created on 2025-12-03 15:10:08
         compiled from manageusers.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'manageusers.tpl.html', 18, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!-- Floating orbs -->
<div class="fixed -top-32 -left-32 w-64 h-64 bg-gradient-radial from-pastel-sky/15 to-transparent rounded-full blur-3xl floating-slow pointer-events-none"></div>
<div class="fixed top-1/2 -right-32 w-64 h-64 bg-gradient-radial from-pastel-lavender/15 to-transparent rounded-full blur-3xl floating pointer-events-none"></div>

<div class="flex flex-col gap-8">

    <!-- Page Header & Toolbar -->
    <div class="neumorphic-light rounded-2xl p-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-pastel-sky/20 rounded-2xl p-3">
                    <svg class="w-8 h-8 text-pastel-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-pastel-sky tracking-tight"><?php echo $this->_tpl_vars['lngstr']['page_header_manageusers']; ?>
</h1>
                    <p class="text-slate-600 mt-1"><?php echo ((is_array($_tmp=$this->_tpl_vars['lngstr']['tooltip_users'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="users.php?action=create" class="neumorphic-light px-6 py-3 flex items-center gap-2 font-semibold hover:text-pastel-sky">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <?php echo $this->_tpl_vars['lngstr']['label_action_create_user']; ?>

                </a>
                
                <button onclick="document.usersForm.action='users.php?action=groups';document.usersForm.submit();" class="neumorphic-light px-4 py-3 flex items-center gap-2 text-slate-600 font-medium hover:text-pastel-sky">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <?php echo $this->_tpl_vars['lngstr']['label_action_groups']; ?>

                </button>
                
                <button onclick="if(confirm('<?php echo $this->_tpl_vars['lngstr']['qst_delete_users']; ?>
')) { document.usersForm.action='users.php?action=delete&confirmed=1';document.usersForm.submit(); }" class="neumorphic-light px-4 py-3 flex items-center gap-2 text-pastel-salmon font-medium hover:text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <?php echo $this->_tpl_vars['lngstr']['label_action_users_delete']; ?>

                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glassmorphic-light rounded-2xl p-6">
        <div class="flex justify-between items-center cursor-pointer" onclick="toggleSection('div_filter_administration_users')">
            <h3 class="text-lg font-semibold text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-pastel-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <?php echo $this->_tpl_vars['lngstr']['label_filter_header']; ?>

            </h3>
            <svg id="icon_div_filter_administration_users" class="w-5 h-5 text-slate-400 transform transition-transform duration-200 <?php if ($this->_tpl_vars['filter']['is_visible']): ?>rotate-180<?php endif; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
        
        <div id="div_filter_administration_users" class="mt-4 <?php if (! $this->_tpl_vars['filter']['is_visible']): ?>hidden<?php endif; ?>">
            <form name="filterForm" method="post" action="users.php<?php echo $this->_tpl_vars['g_vars']['page']['filter_url_addon']; ?>
">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2"><?php echo $this->_tpl_vars['lngstr']['label_lastname']; ?>
</label>
                        <?php echo $this->_tpl_vars['filter']['user_lastname_content']; ?>

                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2"><?php echo $this->_tpl_vars['lngstr']['label_department']; ?>
</label>
                        <?php echo $this->_tpl_vars['filter']['user_department_content']; ?>

                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <input class="neumorphic-light px-6 py-2 cursor-pointer hover:text-pastel-sky font-semibold" type="submit" name="bsetfilter" value="<?php echo $this->_tpl_vars['lngstr']['button_set_filter']; ?>
">
                    <input class="neumorphic-light px-6 py-2 cursor-pointer opacity-70 hover:opacity-100 hover:text-pastel-salmon" type="submit" name="bremovefilter" value="<?php echo $this->_tpl_vars['lngstr']['button_remove_filter']; ?>
">
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <form name="usersForm" method="post" class="w-full">
        <div class="glassmorphic-light rounded-2xl overflow-hidden shadow-neumorphic">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-3 w-10 text-center">
                                <input type="checkbox" name="toggleAll" onclick="toggleCBs(this);" class="rounded border-slate-300 text-pastel-sky focus:ring-pastel-sky cursor-pointer">
                            </th>
                            <?php $_from = $this->_tpl_vars['table_headers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header']):
?>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                    <a href="<?php echo $this->_tpl_vars['header']['url']; ?>
" title="<?php echo $this->_tpl_vars['header']['title']; ?>
" class="hover:text-pastel-sky transition-colors flex items-center gap-1">
                                        <?php echo $this->_tpl_vars['header']['text']; ?>

                                        <?php if ($this->_tpl_vars['header']['sort_icon']): ?>
                                            <?php if ($this->_tpl_vars['header']['sort_desc']): ?>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            <?php else: ?>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>
                                </th>
                            <?php endforeach; endif; unset($_from); ?>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider text-center"><?php echo $this->_tpl_vars['lngstr']['label_hdr_action']; ?>
</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['userlist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['userlist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['user']):
        $this->_foreach['userlist']['iteration']++;
?>
                            <tr class="hover:bg-white/40 transition-colors duration-150 group border-b border-slate-50 last:border-0">
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" name="box_users[]" value="<?php echo $this->_tpl_vars['user']['userid']; ?>
" onclick="toggleCB(this);" class="rounded border-slate-300 text-pastel-sky focus:ring-pastel-sky cursor-pointer">
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 font-mono"><?php echo $this->_tpl_vars['user']['userid']; ?>
</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="javascript:void(0)" onClick="showDialog('users.php?userid=<?php echo $this->_tpl_vars['user']['userid']; ?>
&action=notes', 300, 200)" class="text-slate-400 hover:text-pastel-sky transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-700"><?php echo $this->_tpl_vars['user']['user_name']; ?>
</td>
                                <td class="px-6 py-4 text-sm text-slate-500"><?php echo $this->_tpl_vars['user']['user_email']; ?>
</td>
                                <td class="px-6 py-4 text-sm text-slate-600"><?php echo $this->_tpl_vars['user']['user_firstname']; ?>
</td>
                                <td class="px-6 py-4 text-sm text-slate-600"><?php echo $this->_tpl_vars['user']['user_lastname']; ?>
</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="users.php?userid=<?php echo $this->_tpl_vars['user']['userid']; ?>
<?php echo $this->_tpl_vars['pagination']['order_addon']; ?>
<?php echo $this->_tpl_vars['pagination']['limit_addon']; ?>
&action=enable&set=<?php if ($this->_tpl_vars['user']['user_enabled']): ?>0<?php else: ?>1<?php endif; ?>">
                                        <?php if ($this->_tpl_vars['user']['user_enabled']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition-colors">Active</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 hover:bg-rose-200 transition-colors">Inactive</span>
                                        <?php endif; ?>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="users.php?userid=<?php echo $this->_tpl_vars['user']['userid']; ?>
&action=groups" class="p-2 rounded-lg hover:bg-pastel-sky/10 text-slate-400 hover:text-pastel-sky transition-colors" title="<?php echo $this->_tpl_vars['lngstr']['label_action_manageusers_groups']; ?>
">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </a>
                                        <a href="users.php?userid=<?php echo $this->_tpl_vars['user']['userid']; ?>
&action=edit" class="p-2 rounded-lg hover:bg-pastel-sky/10 text-slate-400 hover:text-pastel-sky transition-colors" title="<?php echo $this->_tpl_vars['lngstr']['label_action_manageusers_edit']; ?>
">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <?php if ($this->_tpl_vars['user']['can_delete']): ?>
                                            <a href="users.php?userid=<?php echo $this->_tpl_vars['user']['userid']; ?>
&action=delete" onclick="return confirmMessage(this, '<?php echo $this->_tpl_vars['lngstr']['qst_delete_user']; ?>
')" class="p-2 rounded-lg hover:bg-rose-50 text-slate-400 hover:text-rose-500 transition-colors" title="<?php echo $this->_tpl_vars['lngstr']['label_action_manageusers_delete']; ?>
">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($this->_tpl_vars['pagination']['total_pages'] > 1): ?>
                <div class="p-4 border-t border-slate-200 bg-slate-50/50 flex justify-between items-center">
                    <div class="text-sm text-slate-500">
                        <?php echo $this->_tpl_vars['pagination']['summary']; ?>

                    </div>
                    <div class="flex gap-1">
                        <?php if ($this->_tpl_vars['pagination']['has_prev']): ?>
                            <a href="users.php?pageno=1<?php echo $this->_tpl_vars['pagination']['url_addon']; ?>
" class="p-2 rounded-lg hover:bg-white text-slate-500 hover:text-pastel-sky transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg></a>
                            <a href="users.php?pageno=<?php echo $this->_tpl_vars['pagination']['prev_page']; ?>
<?php echo $this->_tpl_vars['pagination']['url_addon']; ?>
" class="p-2 rounded-lg hover:bg-white text-slate-500 hover:text-pastel-sky transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>
                        <?php endif; ?>
                        
                        <?php $_from = $this->_tpl_vars['pagination']['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
                            <?php if ($this->_tpl_vars['page']['is_current']): ?>
                                <span class="px-3 py-2 rounded-lg bg-pastel-sky text-white font-medium shadow-sm"><?php echo $this->_tpl_vars['page']['number']; ?>
</span>
                            <?php else: ?>
                                <a href="users.php?pageno=<?php echo $this->_tpl_vars['page']['number']; ?>
<?php echo $this->_tpl_vars['pagination']['url_addon']; ?>
" class="px-3 py-2 rounded-lg hover:bg-white text-slate-600 hover:text-pastel-sky transition-colors"><?php echo $this->_tpl_vars['page']['number']; ?>
</a>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                        
                        <?php if ($this->_tpl_vars['pagination']['has_next']): ?>
                            <a href="users.php?pageno=<?php echo $this->_tpl_vars['pagination']['next_page']; ?>
<?php echo $this->_tpl_vars['pagination']['url_addon']; ?>
" class="p-2 rounded-lg hover:bg-white text-slate-500 hover:text-pastel-sky transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                            <a href="users.php?pageno=<?php echo $this->_tpl_vars['pagination']['total_pages']; ?>
<?php echo $this->_tpl_vars['pagination']['url_addon']; ?>
" class="p-2 rounded-lg hover:bg-white text-slate-500 hover:text-pastel-sky transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>