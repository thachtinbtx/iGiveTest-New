<?php
$g_vars['page']['hide_cpanel'] = true;
if(!isset($G_SESSION['yt_teststop'])) {
	if($G_SESSION['yt_testtime'] > 0) {
 
 $G_SESSION['yt_teststop'] = time() + $G_SESSION['yt_testtime'];
} else {
 
 $G_SESSION['yt_teststop'] = 0;
}
}
 
if(!isset($G_SESSION['yt_pageno']))
 $G_SESSION['yt_pageno'] = 1;
 
 
if($G_SESSION['yt_teststop'] > 0) {
	$g_vars['page']['test_time']['use'] = true;
$i_testtime = readDiffTime(time(),$G_SESSION['yt_teststop']);
$g_vars['page']['test_time']['hours'] = $i_testtime['hours'] > 0 ? $i_testtime['hours'] : 0;
$g_vars['page']['test_time']['minutes'] = $i_testtime['minutes'] > 0 ? $i_testtime['minutes'] : 0;
$g_vars['page']['test_time']['seconds'] = $i_testtime['seconds'] > 0 ? $i_testtime['seconds'] : 0;
} else {
	$g_vars['page']['test_time']['use'] = false;
}
$g_vars['page']['testid'] = $G_SESSION['testid'];
$g_vars['page']['test_name'] = convertTextValue($G_SESSION['yt_name']);
$g_vars['page']['content_protection'] = $G_SESSION['yt_contentprotection'];
 
if($G_SESSION['yt_test_qsperpage'] == 0) {
	$i_questionfrom = 1;
$i_questionto = $G_SESSION['yt_questioncount'];
} else {
	$i_questionfrom = (($G_SESSION['yt_pageno'] - 1) * $G_SESSION['yt_test_qsperpage']) + 1;
$i_questionto = min($i_questionfrom + $G_SESSION['yt_test_qsperpage'] - 1, $G_SESSION['yt_questioncount']);
}
$g_vars['page']['has_feedback'] = ($G_SESSION['yt_state'] == TEST_STATE_QFEEDBACK);
for($i_questionno = $i_questionfrom; $i_questionno <= $i_questionto; $i_questionno++) {
 
	$i_questionno_real = $G_SESSION['yt_questions'][$i_questionno - 1];
$i_questionid = $G_SESSION['yt_questionids'][$i_questionno_real];
 
	readTestQuestion($i_questionno, $i_questionid);
}
$G_SESSION['yt_page_hasfeedback'] = $g_vars['page']['has_feedback'];
if($g_vars['page']['errors_fatal'] && ($G_SESSION['yt_state'] != TEST_STATE_QFEEDBACK))
 unregisterTestData(); 
if(!isset($g_vars['page']['meta'])) $g_vars['page']['meta'] = '';
$g_vars['page']['meta'] .= '<script src="https://cdn.tailwindcss.com"></script>';
$g_vars['page']['meta'] .= '<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.body.classList.add("bg-gradient-to-br", "from-slate-50", "to-indigo-100", "min-h-screen", "text-slate-800");

    // Proctoring Logic
    let lastActiveTime = Date.now();
    let isAway = false;

    function handleVisibilityChange() {
        if (document.hidden) {
            isAway = true;
            lastActiveTime = Date.now();
        } else {
            if (isAway) {
                let now = Date.now();
                let timeAway = Math.round((now - lastActiveTime) / 1000);
                isAway = false;

                // Send time away to backend
                fetch("test-proctor.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "action=log_away&time_away=" + timeAway
                }).finally(() => {
                    alert("Cảnh báo: Em đã rời màn hình kiểm tra: " + timeAway + " giây. Hệ thống đã ghi nhận lại sự việc này!");
                    // window.location.href = "test.php?action=finish&confirmed=1"; // Disabled auto-submit
                });
            }
        }
    }

    document.addEventListener("visibilitychange", handleVisibilityChange);
    window.addEventListener("blur", function() {
        if (!document.hidden) {
             // handleVisibilityChange(); 
        }
    });
  });
</script>';
$g_smarty->assign('g_vars', $g_vars);
displayTemplate('test-questions');
?>