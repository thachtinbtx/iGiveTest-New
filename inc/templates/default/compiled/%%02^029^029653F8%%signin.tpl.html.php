<?php /* Smarty version 2.6.18, created on 2025-12-02 15:16:38
         compiled from signin.tpl.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="flex items-center justify-center min-h-[80vh] p-4">
  <div class="w-full max-w-4xl flex flex-col md:flex-row gap-8 relative">
    
    <!-- Floating Background Orbs -->
    <div class="absolute -top-32 -left-32 w-64 h-64 bg-gradient-radial from-white/30 to-transparent rounded-full blur-3xl animate-float pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-gradient-radial from-white/30 to-transparent rounded-full blur-3xl animate-float pointer-events-none" style="animation-delay: 2s;"></div>
    
    <!-- Sign In Card -->
    <div class="w-full md:w-1/2 neu-card relative z-10 border border-white/60 shadow-xl">
      <form action="index.php" method="post" name="signinform" class="space-y-6">
        <div class="text-center mb-8">
         <div class="inline-flex items-center justify-center w-16 h-16 bg-white/40 rounded-2xl mb-4 shadow-sm border border-white/50">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>

          <p class="text-slate-600 mt-2 font-medium"><?php echo $this->_tpl_vars['lngstr']['page_signin_box_signin_intro']; ?>
</p>
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-bold text-slate-700 mb-2"><?php echo $this->_tpl_vars['lngstr']['page_signin_box_signin']; ?>
</label>
            <div class="relative">
              <div class="absolute left-4 top-1/2 -translate-y-1/2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <input name="username" class="neu-input pl-12 pr-5 py-3.5 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" type="text" value="<?php echo $this->_tpl_vars['g_vars']['page']['username']; ?>
" placeholder="Username">
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-bold text-slate-700 mb-2"><?php echo $this->_tpl_vars['lngstr']['page_signin_box_password']; ?>
</label>
            <div class="relative">
              <div class="absolute left-4 top-1/2 -translate-y-1/2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <input name="password" class="neu-input pl-12 pr-5 py-3.5 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" type="password" value="<?php echo $this->_tpl_vars['g_vars']['page']['user_password']; ?>
" placeholder="••••••••">
              <input name="gotourl" type="hidden" value="<?php echo $this->_tpl_vars['g_vars']['page']['gotourl']; ?>
">
            </div>
          </div>
        </div>

        <div class="pt-4 space-y-4">
          <button type="submit" name="bsubmit" class="w-full neu-btn neu-btn-primary text-base font-bold py-3.5">
            <?php echo $this->_tpl_vars['lngstr']['button_signin']; ?>

          </button>
          
          <?php if ($this->_tpl_vars['g_vars']['page']['cansigninasguest']): ?>
            <button type="submit" name="bguest" class="w-full neu-btn neu-btn-secondary text-base font-bold py-3.5">
              <?php echo $this->_tpl_vars['lngstr']['button_signin_as_guest']; ?>

            </button>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- Info / Register Card -->
    <div class="w-full md:w-1/2 neu-card flex flex-col justify-center relative z-10 border border-white/60 shadow-xl">
      
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_notifications.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

      <div class="space-y-6 text-muted">
        <div class="text-base leading-relaxed">
          <?php echo $this->_tpl_vars['lngstr']['page_signin_box_intro']; ?>

        </div>

        <?php if ($this->_tpl_vars['g_vars']['page']['can_register']): ?>
          <div class="neu-card p-6 border-l-4 border-accent">
            <div class="flex items-start gap-3">
              <div class="bg-white/20 rounded-xl p-2 flex-shrink-0">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
              </div>
              <div>
                <p class="font-semibold text-accent mb-2"><?php echo $this->_tpl_vars['lngstr']['page_signin_box_register_intro']; ?>
</p>
                <a href="register.php" class="inline-flex items-center text-muted font-bold hover:text-accent transition-colors">
                  Register now →
                </a>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="text-sm text-muted flex items-center gap-2">
          <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span><?php echo $this->_tpl_vars['lngstr']['page_signin_box_lostpassword_intro']; ?>
</span>
          <a href="lostpassword.php" class="text-red-400 hover:text-accent font-semibold underline decoration-red-400/30 underline-offset-2 transition-colors"><p>Recover Password</p></a>
        </div>
      </div>
    </div>

  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
