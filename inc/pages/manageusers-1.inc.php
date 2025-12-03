<?php
$g_vars['page']['location'] = array('administration', 'users');
$g_vars['page']['selected_section'] = 'administration';
$g_vars['page']['selected_tab'] = 'users';

// --- Filter Logic ---
$i_sql_where_addon = ''; 
$f_user_lastname = readCookieVar('filter_administration_users_user_lastname', readGetVar('user_lastname'));
if(!empty($f_user_lastname)) {
	$i_user_lastname = $g_db->qstr($f_user_lastname, get_magic_quotes_gpc());
    $i_sql_where_addon .= $srv_settings['table_prefix'].'users.user_lastname LIKE '.$i_user_lastname.' AND ';
} 
$f_user_department = readCookieVar('filter_administration_users_user_department', readGetVar('user_department'));
if(!empty($f_user_department)) {
	$i_user_department = $g_db->qstr($f_user_department, get_magic_quotes_gpc());
    $i_sql_where_addon .= $srv_settings['table_prefix'].'users.user_department LIKE '.$i_user_department.' AND ';
} 
if(!empty($i_sql_where_addon))
    $i_sql_where_addon = substr($i_sql_where_addon, 0, strlen($i_sql_where_addon) - 5); 

// --- Sorting Logic ---
$i_direction = '';
$i_order_addon = '';
$i_sql_order_addon = '';
$i_tablefields = array(
	array('text' => $lngstr['label_manageusers_hdr_userid'], 'title' => $lngstr['label_manageusers_hdr_userid_hint'], 'db_field' => $srv_settings['table_prefix'].'users.userid'),
	array('text' => $lngstr['label_manageusers_hdr_user_notes'], 'title' => $lngstr['label_manageusers_hdr_user_notes_hint'], 'db_field' => ''),
	array('text' => $lngstr['label_manageusers_hdr_user_name'], 'title' => $lngstr['label_manageusers_hdr_user_name_hint'], 'db_field' => $srv_settings['table_prefix'].'users.user_name'),
	array('text' => $lngstr['label_manageusers_hdr_user_email'], 'title' => $lngstr['label_manageusers_hdr_user_email_hint'], 'db_field' => $srv_settings['table_prefix'].'users.user_email'),
	array('text' => $lngstr['label_manageusers_hdr_user_firstname'], 'title' => $lngstr['label_manageusers_hdr_user_firstname_hint'], 'db_field' => $srv_settings['table_prefix'].'users.user_firstname'),
	array('text' => $lngstr['label_manageusers_hdr_user_lastname'], 'title' => $lngstr['label_manageusers_hdr_user_lastname_hint'], 'db_field' => $srv_settings['table_prefix'].'users.user_lastname'),
	array('text' => $lngstr['label_manageusers_hdr_user_enabled'], 'title' => $lngstr['label_manageusers_hdr_user_enabled_hint'], 'db_field' => $srv_settings['table_prefix'].'users.user_enabled'),
);

$i_order_no = isset($_GET['order']) ? (int)$_GET['order'] : 0;
if($i_order_no >= count($i_tablefields)) $i_order_no = -1;

if($i_order_no >= 0) {
	$i_direction = "DESC";
	if(isset($_GET['direction']) && $_GET['direction'] == 'ASC') $i_direction = "";
	
    $i_order_addon = '&order='.$i_order_no.'&direction='.($i_direction ? "DESC" : "ASC");
    $i_sql_order_addon = ' ORDER BY '.$i_tablefields[$i_order_no]['db_field'].' '.($i_direction ? "DESC" : "ASC");
} 

// --- Pagination Logic ---
$i_url_limitto_addon = '';
$i_url_pageno_addon = '';
$i_url_limit_addon = '';
$i_pageno = 0;
$i_limitcount = isset($_GET['limitto']) ? (int)$_GET['limitto'] : $G_SESSION['config_itemsperpage'];

if($i_limitcount > 0) {
	$i_recordcount = getRecordCount($srv_settings['table_prefix'].'users', $i_sql_where_addon);
    $i_pageno = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
    if($i_pageno < 1) $i_pageno = 1;
    
    $i_limitfrom = ($i_pageno-1)*$i_limitcount;
    $i_pageno_count = floor(($i_recordcount - 1) / $i_limitcount) + 1;
    
    if($i_limitfrom > $i_recordcount) {
        $i_pageno = $i_pageno_count;
        $i_limitfrom = ($i_pageno-1)*$i_limitcount;
    }
    
    $i_url_limitto_addon .= '&limitto='.$i_limitcount;
    $i_url_pageno_addon .= '&pageno='.$i_pageno;
    $i_url_limit_addon .= $i_url_limitto_addon.$i_url_pageno_addon;
} else {
	$i_url_limitto_addon = '&limitto=';
    $i_url_limit_addon .= $i_url_limitto_addon;
    $i_limitfrom = -1;
    $i_limitcount = -1;
    $i_recordcount = 0; // Default if no limit
    $i_pageno_count = 1;
} 

// --- Prepare Table Headers ---
$arrTableHeaders = array();
$i_url_limit_base = 'users.php?action='.$i_url_limitto_addon;

foreach($i_tablefields as $key => $field) {
    if(empty($field['db_field'])) {
        $arrTableHeaders[] = array(
            'text' => $field['text'],
            'title' => $field['title'],
            'url' => '#',
            'sort_icon' => false
        );
    } else {
        $new_direction = ($i_order_no == $key && $i_direction) ? "ASC" : "DESC";
        $arrTableHeaders[] = array(
            'text' => $field['text'],
            'title' => $field['title'],
            'url' => $i_url_limit_base . '&order=' . $key . '&direction=' . $new_direction,
            'sort_icon' => ($i_order_no == $key),
            'sort_desc' => ($i_order_no == $key && $i_direction) // Pass direction for icon
        );
    }
}

// --- Fetch Users ---
$arrUsers = array();
$i_rSet1 = $g_db->SelectLimit("SELECT userid, user_name, user_email, user_firstname, user_lastname, user_department, user_notes, user_enabled FROM ".$srv_settings['table_prefix']."users".(!empty($i_sql_where_addon) ? ' WHERE '.$i_sql_where_addon : '').$i_sql_order_addon, $i_limitcount, $i_limitfrom);

if(!$i_rSet1) {
	showDBError(__FILE__, 1);
} else {
    while(!$i_rSet1->EOF) {
        $arrUsers[] = array(
            'userid' => $i_rSet1->fields['userid'],
            'user_name' => $i_rSet1->fields['user_name'],
            'user_email' => $i_rSet1->fields['user_email'],
            'user_firstname' => $i_rSet1->fields['user_firstname'],
            'user_lastname' => $i_rSet1->fields['user_lastname'],
            'user_department' => $i_rSet1->fields['user_department'],
            'user_notes' => convertTextValue($i_rSet1->fields['user_notes']),
            'user_enabled' => $i_rSet1->fields['user_enabled'],
            'can_delete' => ($i_rSet1->fields['userid'] > SYSTEM_USER_MAX_INDEX)
        );
        $i_rSet1->MoveNext();
    }
    $i_rSet1->Close();
}

// --- Prepare Pagination Data ---
$arrPagination = array(
    'total_pages' => $i_pageno_count,
    'current_page' => $i_pageno,
    'has_prev' => ($i_pageno > 1),
    'has_next' => ($i_pageno < $i_pageno_count),
    'prev_page' => max(($i_pageno-1), 1),
    'next_page' => min(($i_pageno+1), $i_pageno_count),
    'url_addon' => $i_url_limitto_addon . $i_order_addon,
    'limit_addon' => $i_url_limit_addon,
    'order_addon' => $i_order_addon,
    'summary' => sprintf($lngstr['label']['KtoLofN'], ($i_pageno - 1) * $i_limitcount + 1, ($i_pageno != $i_pageno_count) ? $i_pageno * $i_limitcount : $i_recordcount, $i_recordcount),
    'pages' => array()
);

// Calculate page window
$nPageWindow = IGT_CONFIG_NAVIGATION_WINDOW;
if($i_pageno > floor($nPageWindow/2) + 1 && $i_pageno_count > $nPageWindow)
	$nStartPage = $i_pageno - floor($nPageWindow/2);
else
	$nStartPage = 1; 

if($i_pageno <= $i_pageno_count - floor($nPageWindow/2) && $nStartPage + $nPageWindow-1 <= $i_pageno_count)
	$nEndPage = $nStartPage + $nPageWindow - 1;
else {
	$nEndPage = $i_pageno_count;
    if($nEndPage - $nPageWindow + 1 >= 1)
        $nStartPage = $nEndPage - $nPageWindow + 1;
}

for($i = $nStartPage; $i <= $nEndPage; $i++) {
    $arrPagination['pages'][] = array(
        'number' => $i,
        'is_current' => ($i == $i_pageno)
    );
}

// --- Prepare Filter Data ---
$g_vars['page']['filter_url_addon'] = getURLAddon('?action=filter', array('action'));
$arrFilter = array(
    'is_visible' => (isset($_COOKIE['div_filter_administration_users']) && $_COOKIE['div_filter_administration_users']=='Y'),
    'user_lastname_content' => getInputElement('user_lastname', $f_user_lastname),
    'user_department_content' => getInputElement('user_department', $f_user_department)
);

// --- Assign to Smarty ---
$g_smarty->assign('users', $arrUsers);
$g_smarty->assign('table_headers', $arrTableHeaders);
$g_smarty->assign('pagination', $arrPagination);
$g_smarty->assign('filter', $arrFilter);
$g_smarty->assign('g_vars', $g_vars);

// --- Display Template ---
displayTemplate('manageusers');
?>