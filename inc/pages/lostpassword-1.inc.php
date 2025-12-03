<?php
$g_vars['page']['hide_cpanel'] = true;
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
$f_username = readPostVar('username');
echo '<div class="max-w-4xl mx-auto mt-10 px-4">';
echo '  <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-slate-100">';

echo '    <!-- Left Column: Form -->';
echo '    <div class="w-full md:w-1/2 p-8 md:p-12">';
echo '      <h2 class="text-2xl font-bold text-slate-800 mb-6">'.$lngstr['page_title_lostpassword'].'</h2>';
echo '      <form action="lostpassword.php" method="post" name="lostpasswordform" class="space-y-6">';
echo '        <div>';
echo '          <label class="block text-sm font-medium text-slate-700 mb-2">'.$lngstr['page_lostpassword_enter_username'].'</label>';
echo '          <input name="username" type="text" value="'.convertTextValue($f_username).'" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-slate-50 focus:bg-white" placeholder="'.$lngstr['login_username'].'">';
echo '        </div>';
echo '        <button type="submit" name="bsubmit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5 active:translate-y-0">'.$lngstr['button_send_new_password'].'</button>';
echo '      </form>';
echo '    </div>';

echo '    <!-- Right Column: Info -->';
echo '    <div class="w-full md:w-1/2 p-8 md:p-12 bg-slate-50 border-t md:border-t-0 md:border-l border-slate-100 flex flex-col justify-center">';
echo '      <div class="space-y-6 text-slate-600">';
echo '        <div class="flex items-start gap-4">';
echo '          <div class="p-3 bg-white rounded-lg shadow-sm text-indigo-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>';
echo '          <div><p class="text-sm leading-relaxed">'.$lngstr['page_signin_box_lostpassword_intro'].'</p></div>';
echo '        </div>';
echo '        <div class="flex items-start gap-4">';
echo '          <div class="p-3 bg-white rounded-lg shadow-sm text-indigo-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg></div>';
echo '          <div><p class="text-sm leading-relaxed">'.$lngstr['page_signin_box_register_intro'].'</p></div>';
echo '        </div>';
echo '      </div>';
echo '      <div class="mt-8 pt-6 border-t border-slate-200 text-center">';
echo '        <a href="index.php" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm hover:underline">'.$lngstr['page_title_signin'].'</a>';
echo '      </div>';
echo '    </div>';
echo '  </div>';
echo '</div>';
writeErrorsWarningsBar();
displayTemplate('_footer');
?>