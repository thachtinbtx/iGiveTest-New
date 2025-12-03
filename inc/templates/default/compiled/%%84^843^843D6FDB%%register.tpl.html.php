<?php /* Smarty version 2.6.18, created on 2025-12-02 11:08:28
         compiled from register.tpl.html */ ?>
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

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_notifications.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <h2 class="mt-6 text-center text-3xl font-extrabold text-pastel-sky"><?php echo $this->_tpl_vars['lngstr']['page_register']['header_register']; ?>
</h2>
    <p class="mt-2 text-center text-sm text-slate-600">
      <?php echo $this->_tpl_vars['g_vars']['page']['intro']; ?>

    </p>
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
    <div class="neumorphic-light rounded-2xl py-8 px-4 sm:px-10">
      <form method="post" action="register.php">
        
        <!-- Account Information -->
        <div class="mb-8">
            <h3 class="text-lg leading-6 font-medium text-pastel-cadet mb-4 border-soft-bottom pb-2">Account Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php echo $this->_tpl_vars['g_vars']['page']['items']['username']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['password']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['confirmpassword']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['email']; ?>

            </div>
        </div>

        <!-- Personal Information -->
        <div class="mb-8">
            <h3 class="text-lg leading-6 font-medium text-pastel-cadet mb-4 border-soft-bottom pb-2">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php echo $this->_tpl_vars['g_vars']['page']['items']['title']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['firstname']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['lastname']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['middlename']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['gender']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['birthday']; ?>

            </div>
        </div>

        <!-- Contact Information -->
        <div class="mb-8">
            <h3 class="text-lg leading-6 font-medium text-pastel-cadet mb-4 border-soft-bottom pb-2">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php echo $this->_tpl_vars['g_vars']['page']['items']['address']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['city']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['state']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['zip']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['country']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['phone']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['mobile']; ?>

            </div>
        </div>

        <!-- Other Information -->
        <div class="mb-8">
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php echo $this->_tpl_vars['g_vars']['page']['items']['fax']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['pager']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['ipphone']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['webpage']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['icq']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['msn']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['aol']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['husbandwife']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['children']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['trainer']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['photo']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['company']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cposition']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['department']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['coffice']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['caddress']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['ccity']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cstate']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['czip']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['ccountry']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cphone']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cfax']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cmobile']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cpager']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cipphone']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cwebpage']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['cphoto']; ?>

             </div>
        </div>

        <!-- Custom Fields -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield1']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield2']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield3']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield4']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield5']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield6']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield7']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield8']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield9']; ?>

                <?php echo $this->_tpl_vars['g_vars']['page']['items']['userfield10']; ?>

            </div>
        </div>

        <?php echo $this->_tpl_vars['g_vars']['page']['items']['groupid_input']; ?>

        <?php echo $this->_tpl_vars['g_vars']['page']['items']['testid_input']; ?>


        <div class="mt-6">
          <button type="submit" name="bsubmit" class="neumorphic-light w-full py-3 text-base">
            <?php echo $this->_tpl_vars['lngstr']['button_register']; ?>

          </button>
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