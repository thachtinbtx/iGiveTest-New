<?php /* Smarty version 2.6.18, created on 2025-12-03 14:42:21
         compiled from signin.tpl.html */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="flex items-center justify-center min-h-[85vh] p-4">
    <div class="w-full max-w-md relative">
        
        <!-- Floating Background Orbs -->
        <div class="absolute -top-40 -left-40 w-72 h-72 bg-gradient-radial from-white/20 to-transparent rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-72 h-72 bg-gradient-radial from-white/20 to-transparent rounded-full blur-3xl animate-float pointer-events-none" style="animation-delay: 2s;"></div>

        <!-- Single Centered Card -->
        <div class="neu-glass-card relative z-10">
            <form action="index.php" method="post" name="signinform">
                <!-- Header -->
                <div class="text-center p-6 border-b border-white/10">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-4 shadow-sm border border-white/30">
                        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500/20 to-purple-500/20 backdrop-blur-sm rounded-2xl border border-blue-400/30 shadow-lg">
                        <p class="text-blue-600 dark:text-blue-300 font-semibold text-base"><?php echo $this->_tpl_vars['lngstr']['page_signin_box_signin_intro']; ?>
</p>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="p-6">
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_notifications.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>

                <!-- Form Inputs -->
                <div class="p-6 pt-0 space-y-5">
                    <div>
                        <div class="inline-block px-4 py-2 mb-2 bg-gradient-to-r from-indigo-500/20 to-blue-500/20 backdrop-blur-sm rounded-xl border-2 border-indigo-400/40 shadow-md">
                            <label class="text-sm font-bold text-indigo-700 dark:text-indigo-300"><?php echo $this->_tpl_vars['lngstr']['page_signin_box_signin']; ?>
</label>
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <input name="username" class="neu-input pl-12 pr-5 py-3.5" type="text" value="<?php echo $this->_tpl_vars['g_vars']['page']['username']; ?>
" placeholder="<?php echo $this->_tpl_vars['lngstr']['page_signin_box_signin']; ?>
">
                        </div>
                    </div>
                    
                    <div>
                        <div class="inline-block px-4 py-2 mb-2 bg-gradient-to-r from-purple-500/20 to-pink-500/20 backdrop-blur-sm rounded-xl border-2 border-purple-400/40 shadow-md">
                            <label class="text-sm font-bold text-purple-700 dark:text-purple-300"><?php echo $this->_tpl_vars['lngstr']['page_signin_box_password']; ?>
</label>
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <input name="password" class="neu-input pl-12 pr-5 py-3.5" type="password" value="<?php echo $this->_tpl_vars['g_vars']['page']['user_password']; ?>
" placeholder="••••••••">
                            <input name="gotourl" type="hidden" value="<?php echo $this->_tpl_vars['g_vars']['page']['gotourl']; ?>
">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="p-6 pt-2 space-y-4">
                    <button type="submit" name="bsubmit" class="w-full relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 text-white text-base font-bold py-4 rounded-2xl border-2 border-blue-500/50 shadow-2xl hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <span class="relative z-10"><?php echo $this->_tpl_vars['lngstr']['button_signin']; ?>
</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/30 to-indigo-500/30 opacity-0 hover:opacity-100 transition-opacity duration-200"></div>
                    </button>
                    
                    <?php if ($this->_tpl_vars['g_vars']['page']['cansigninasguest']): ?>
                        <button type="submit" name="bguest" class="w-full neu-btn neu-btn-secondary text-base font-bold py-3.5">
                            <?php echo $this->_tpl_vars['lngstr']['button_signin_as_guest']; ?>

                        </button>
                    <?php endif; ?>
                </div>

                <!-- Footer Links -->
                <div class="p-6 border-t border-white/10 text-sm text-center space-y-4">
                    <?php if ($this->_tpl_vars['g_vars']['page']['can_register']): ?>
                        <div class="p-4 bg-gradient-to-r from-green-500/10 to-teal-500/10 rounded-xl border-2 border-green-400/30 shadow-md backdrop-blur-sm">
                            <p class="text-green-700 dark:text-green-300 font-medium">
                                <?php echo $this->_tpl_vars['lngstr']['page_signin_box_register_intro']; ?>

                                <a href="register.php" class="font-bold text-green-600 dark:text-green-400 hover:underline underline-offset-2">Register here</a>.
                            </p>
                        </div>
                    <?php endif; ?>
                    <div class="p-4 bg-gradient-to-r from-orange-500/10 to-red-500/10 rounded-xl border-2 border-orange-400/30 shadow-md backdrop-blur-sm">
                        <p class="text-orange-700 dark:text-orange-300 font-medium">
                            <?php echo $this->_tpl_vars['lngstr']['page_signin_box_lostpassword_intro']; ?>

                            <a href="lostpassword.php" class="font-bold text-orange-600 dark:text-orange-400 hover:underline underline-offset-2">Recover password</a>.
                        </p>
                    </div>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>