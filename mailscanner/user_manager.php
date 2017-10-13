<?php

/*
 MailWatch for MailScanner
 Copyright (C) 2003-2011  Steve Freegard (steve@freegard.name)
 Copyright (C) 2011  Garrod Alwood (garrod.alwood@lorodoes.com)
 Copyright (C) 2014-2017  MailWatch Team (https://github.com/mailwatch/1.2.0/graphs/contributors)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 In addition, as a special exception, the copyright holder gives permission to link the code of this program
 with those files in the PEAR library that are licensed under the PHP License (or with modified versions of those
 files that use the same license as those files), and distribute linked combinations including the two.
 You must obey the GNU General Public License in all respects for all of the code used other than those files in the
 PEAR library that are licensed under the PHP License. If you modify this program, you may extend this exception to
 your version of the program, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your version.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/lib/password.php';

require __DIR__ . '/login.function.php';

html_start(__('usermgnt12'), 0, false, false);

/**
 * @param string $value
 * @param string $type
 * @return string
 */
function getHtmlMessage($value, $type)
{
    switch ($type) {
        case 'error':
            return '<h1 class="center error">' . $value . '</h1>';

        case 'success':
            return '<h1 class="center success">' . $value . '</h1>';

        default:
            return $value;
    }
}

/**
 * @param string $username
 * @param string $method
 */
function testSameDomainMembership($username, $method)
{
    $ar = explode('@', $username);
    $sql = "SELECT filter FROM user_filters WHERE username = '" . $_SESSION['myusername'] . "'";
    $result = dbquery($sql);
    $filter_domain = array();
    for ($i=0;$i<$result->num_rows;$i++) {
        $filter = $result->fetch_row();
        $filter_domain[] = $filter[0];
    }
    if ($_SESSION['user_type'] === 'D' && count($ar) === 1 && $_SESSION['domain'] !== '') {
        return getHtmlMessage(__('error'.$method.'nodomainforbidden12'), 'error');
    } elseif ($_SESSION['user_type'] === 'D' && count($ar) === 2 && ($ar[1] !== $_SESSION['domain'] && in_array($ar[1], $filter_domain, true) === false)) {
        return getHtmlMessage(sprintf(__('error'.$method.'domainforbidden12'), $ar[1]), 'error');
    }
}

/**
 * @param string $username
 * @param string $userType
 * @param string $oldUserType
 */
function testPermissions($username, $userType, $oldUserType)
{
    if (($_SESSION['user_type'] !== 'A' && $oldUserType === 'A')|| $_SESSION['user_type'] === 'D' && $_SESSION['myusername'] !== $username && $userType !== 'U' && (!defined('ENABLE_SUPER_DOMAIN_ADMINS') || ENABLE_SUPER_DOMAIN_ADMINS === false)) {
        return getHtmlMessage(__('erroradminforbidden12'), 'error');
    } elseif ($_SESSION['user_type'] === 'D' && $userType === 'A') {
        return getHtmlMessage(__('errortypesetforbidden12'), 'error');
    }
}

/**
 * @param string $username
 * @param string $usertype
 * @param string $oldUsername
 */
function testValidUser($username, $usertype, $oldUsername)
{
    if ($usertype !== 'A' && validateInput($username, 'email') === false && (!defined('ALLOW_NO_USER_DOMAIN') || ALLOW_NO_USER_DOMAIN === false)) {
        return getHtmlMessage(__('forallusers12'), 'error');
    } elseif ($_POST['password'] === '') {
        return getHtmlMessage(__('errorpwdreq12'), 'error');
    } elseif ($_POST['password'] !== $_POST['password1']) {
        return getHtmlMessage(__('errorpass12'), 'error');
    } elseif ($username === '') {
        return getHtmlMessage(__('erroruserreq12'), 'error');
    } elseif ($oldUsername !== $username && checkForExistingUser($username)) {
        return getHtmlMessage(sprintf(__('userexists12'), sanitizeInput($username)), 'error');
    }
}

function testtoken()
{
    if (isset($_POST['token'])) {
        if (false === checkToken($_POST['token'])) {
            return getHtmlMessage(__('dietoken99'), 'error');
        }
    } else {
        if (false === checkToken($_GET['token'])) {
            return getHtmlMessage(__('dietoken99'), 'error');
        }
    }
}

function getUserById($userid, $additionalFields = false)
{
    if (!isset($userid) || ($id = deepSanitizeInput($userid, 'num')) < -1) {
        return getHtmlMessage(__('dievalidate99'), 'error');
    }
    $sql = "SELECT id, username, type " . ($additionalFields ? ", fullname, quarantine_report, quarantine_rcpt, spamscore, highspamscore, noscan, login_timeout, last_login " : "") . "FROM users WHERE id='" . $id . "'";
    $result = dbquery($sql);
    if ($result->num_rows === 0) {
        audit_log(sprintf(__('auditlogunknownuser12'), $_SESSION['myusername'], $id));
        return getHtmlMessage(__('accessunknownuser12'), 'error');
    }
    return $result->fetch_object();
}

function storeUser($n_username, $n_type, $id, $oldUsername = '', $oldType = '')
{
    $n_fullname = deepSanitizeInput($_POST['fullname'], 'string');
    if (!validateInput($n_fullname, 'general')) {
        $n_fullname = '';
    }
    $n_password = safe_value(password_hash($_POST['password'], PASSWORD_DEFAULT));

    if (!validateInput($n_type, 'type')) {
        $n_type = 'U';
    }
    $spamscore = deepSanitizeInput($_POST['spamscore'], 'float');
    if (!validateInput($spamscore, 'float')) {
        $spamscore = '0';
    }
    $highspamscore = deepSanitizeInput($_POST['highspamscore'], 'float');
    if (!validateInput($highspamscore, 'float')) {
        $highspamscore = '0';
    }
    $timeout = deepSanitizeInput($_POST['timeout'], 'num');
    if (!validateInput($timeout, 'timeout')) {
        $timeout = '-1';
    }
    $n_quarantine_report = '1';
    if (!isset($_POST['quarantine_report'])) {
        $n_quarantine_report = '0';
    }
    $noscan = '0';
    if (!isset($_POST['noscan'])) {
        $noscan = '1';
    }
    $quarantine_rcpt = deepSanitizeInput($_POST['quarantine_rcpt'], 'string');
    if (!validateInput($quarantine_rcpt, 'user')) {
        $quarantine_rcpt = '';
    }

    $type = array();
    $type['A'] = __('admin12', true);
    $type['D'] = __('domainadmin12', true);
    $type['U'] = __('user12', true);
    $type['R'] = __('user12', true);
    if ($id === -1) {//new user
        $sql = "INSERT INTO users (username, fullname, password, type, quarantine_report, login_timeout, spamscore, highspamscore, noscan, quarantine_rcpt)
                        VALUES ('$n_username','$n_fullname','$n_password','$n_type','$n_quarantine_report','$timeout','$spamscore','$highspamscore','$noscan','$quarantine_rcpt')";
        dbquery($sql);
        audit_log(__('auditlog0112', true) . ' ' . $type[$n_type] . " '" . $n_username . "' (" . $n_fullname . ') ' . __('auditlog0212', true));
        return getHtmlMessage(sprintf(__('usercreated12'), $n_username), 'success');
    } else {
        if ($_POST['password'] !== 'XXXXXXXX') {// Password reset required
            $sql = "UPDATE users SET username='$n_username', fullname='$n_fullname', password='$n_password', type='$n_type', quarantine_report='$n_quarantine_report', spamscore='$spamscore', highspamscore='$highspamscore', noscan='$noscan', quarantine_rcpt='$quarantine_rcpt', login_timeout='$timeout' WHERE id='$id'";
        } else {
            $sql = "UPDATE users SET username='$n_username', fullname='$n_fullname', type='$n_type', quarantine_report='$n_quarantine_report', spamscore='$spamscore', highspamscore='$highspamscore', noscan='$noscan', quarantine_rcpt='$quarantine_rcpt', login_timeout='$timeout' WHERE id='$id'";
        }
        dbquery($sql);
        // Update user_filters if username was changed
        if ($oldUsername !== $n_username) {
            $sql = "UPDATE user_filters SET username='$n_username' WHERE username = '$oldUsername'";
            dbquery($sql);
        }
        if ($oldType !== $n_type) {
            audit_log(
                __('auditlog0312', true) . " '" . $n_username . "' (" . $n_fullname . ') ' . __('auditlogfrom12', true) . ' ' . $type[$oldType] . ' ' . __('auditlogto12', true) . ' ' . $type[$n_type]
            );
        }
        return getHtmlMessage(sprintf(__('useredited12'), $oldUsername), 'success');
    }
}

function newUser()
{
    if (is_string($tokentest = testToken())) {
        return $tokentest;
    }

    if (!isset($_POST['submit'])) {
        echo '<div id="formerror" class="hidden"></div>';
        echo '<FORM METHOD="POST" ACTION="user_manager.php" ONSUBMIT="return validateForm();" AUTOCOMPLETE="off">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="submit" VALUE="true">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="action" VALUE="new">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="token" VALUE="' . $_SESSION['token'] . '">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="formtoken" VALUE="' . generateFormToken('/user_manager.php new form token') . '">' . "\n";
        echo '<TABLE CLASS="mail" BORDER="0" CELLPADDING="1" CELLSPACING="1">' . "\n";
        echo ' <TR><TD CLASS="heading" COLSPAN="2" ALIGN="CENTER">' . __('newuser12') . '</TD></TR>' . "\n";
        echo ' <TR><TD CLASS="message" COLSPAN="2" ALIGN="CENTER">' . __('forallusers12') . '</TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('username0212') . ' <BR></TD><TD><INPUT TYPE="TEXT" ID="username" NAME="username"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('name12') . '</TD><TD><INPUT TYPE="TEXT" NAME="fullname"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('password12') . '</TD><TD><INPUT TYPE="PASSWORD" ID="password" NAME="password"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('retypepassword12') . '</TD><TD><INPUT TYPE="PASSWORD" ID="retypepassword" NAME="password1"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('usertype12') . '</TD>
<TD><SELECT NAME="type">
<OPTION VALUE="U">' . __('user12') . '</OPTION>
<OPTION VALUE="D">' . __('domainadmin12') . '</OPTION>
<OPTION VALUE="A">' . __('admin12') . "</OPTION>
</SELECT></TD></TR>\n";
        echo ' <TR><TD CLASS="heading">' . __('usertimeout12') . '</TD><TD><INPUT TYPE="TEXT" NAME="timeout" VALUE="" size="5"> <span class="font-1em">' . __('empty12') . '=' . __('usedefault12') . '</span></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('quarrep12') . '</TD><TD><INPUT TYPE="CHECKBOX" NAME="quarantine_report"> <span class="font-1em">' . __('senddaily12') . '</span></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('quarreprec12') . '</td><TD><INPUT TYPE="TEXT" NAME="quarantine_rcpt"><br><span class="font-1em">' . __('overrec12') . '</span></TD>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('scanforspam12') . '</TD><TD><INPUT TYPE="CHECKBOX" NAME="noscan" CHECKED> <span class="font-1em">' . __('scanforspam212') . '</span></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('pontspam12') . '</TD><TD><INPUT TYPE="TEXT" NAME="spamscore" VALUE="0" size="4"> <span class="font-1em">0=' . __('usedefault12') . '</span></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('hpontspam12') . '</TD><TD><INPUT TYPE="TEXT" NAME="highspamscore" VALUE="0" size="4"> <span class="font-1em">0=' . __('usedefault12') . '</span></TD></TR>' . "\n";
        echo '<TR><TD CLASS="heading">' . __('action_0212') . '</TD><TD><INPUT TYPE="RESET" VALUE="' . __('reset12') . '">&nbsp;&nbsp;<INPUT TYPE="SUBMIT" VALUE="' . __('create12') . '"></TD></TR>' . "\n";
        echo '</TABLE></FORM><BR>' . "\n";
    } else {
        if (false === checkFormToken('/user_manager.php new form token', $_POST['formtoken'])) {
            echo getHtmlMessage(__('dietoken99'), 'error');
            return;
        }
        $username = html_entity_decode(deepSanitizeInput($_POST['username'], 'string'));
        if ($username === false || !validateInput($username, 'user')) {
            $username = '';
        }

        $n_type = deepSanitizeInput($_POST['type'], 'url');
        if (is_string($membertest = testSameDomainMembership($username, 'create'))) {
            return $membertest;
        } elseif (is_string($permissiontest = testPermissions($username, $n_type, ''))) {
            return $permissiontest;
        } elseif (is_string($validuser = testValidUser($username, $n_type, ''))) {
            return $validuser;
        } else {
            $n_username = safe_value($username);
            return storeUser($n_username, $n_type, -1, '', '');
        }
    }
}

function editUser()
{
    if (is_string($tokentest = testToken())) {
        return $tokentest;
    }
    // if editing user is domain admin check if he tries to edit a user from the same domain. if we do the update we also have to check the new username
    // Validate id
    if (isset($_POST['id'])) {
        $user = getUserById($_POST['id'], true);
    } else {
        $user = getUserById($_GET['id'], true);
    }
    if (is_string($user)) {
        return $user;
    }

    if (is_string($membertest = testSameDomainMembership($user->username, 'edit'))) {
        return $membertest;
    } elseif (!isset($_POST['submit'])) {
        $quarantine_report = '';
        if ((int)$user->quarantine_report === 1) {
            $quarantine_report = 'checked="checked"';
        }
        $noscan = '';
        if ((int)$user->noscan === 0) {
            $noscan = 'checked="checked"';
        }
        if ($user->login_timeout === "-1") {
            $timeout = '';
        } else {
            $timeout = $user->login_timeout;
        }

        $s = array();
        $s['A'] = '';
        $s['D'] = '';
        $s['U'] = '';
        $s['R'] = '';

        $timestamp = (int)$user->last_login;
        if (defined('DATE_FORMAT')) {
            $dateformat = preg_replace('/%/', '', DATE_FORMAT);
        } else {
            $dateformat = 'm/d/y';
        }
        if (defined('TIME_FORMAT')) {
            $timeformat = preg_replace('/%/', '', TIME_FORMAT);
        } else {
            $timeformat = 'H:i:s';
        }

        $s[$user->type] = 'SELECTED';
        echo '<div id="formerror" class="hidden"></div>';
        echo '<FORM METHOD="POST" ACTION="user_manager.php" ONSUBMIT="return validateForm();" AUTOCOMPLETE="off">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="id" VALUE="' . $user->id . '">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="action" VALUE="edit">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="token" VALUE="' . $_SESSION['token'] . '">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="submit" VALUE="true">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="formtoken" VALUE="' . generateFormToken('/user_manager.php edit token') . '">' . "\n";
        echo '<TABLE CLASS="mail" BORDER=0 CELLPADDING=1 CELLSPACING=1>' . "\n";
        echo ' <TR><TD CLASS="heading" COLSPAN=2 ALIGN="CENTER">' . __('edituser12') . ' ' . $user->username . '</TD></TR>' . "\n";
        if ($timestamp < 0) {
            echo ' <TR><TD CLASS="heading">' . __('lastlogin12') . '</TD><TD>' . __('never12') . '</TD></TR>' . "\n";
        } else {
            echo ' <TR><TD CLASS="heading">' . __('lastlogin12') . '</TD><TD>' . date($dateformat . ' ' . $timeformat, $timestamp) . '</TD></TR>' . "\n";
        }
        echo ' <TR><TD CLASS="heading">' . __('username0212') . '</TD><TD><INPUT TYPE="TEXT" NAME="username" VALUE="' . $user->username . '"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('name12') . '</TD><TD><INPUT TYPE="TEXT" NAME="fullname" VALUE="' . $user->fullname . '"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('password12') . '</TD><TD><INPUT TYPE="PASSWORD" ID="password" NAME="password" VALUE="XXXXXXXX"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('retypepassword12') . '</TD><TD><INPUT TYPE="PASSWORD" ID="retypepassword" NAME="password1" VALUE="XXXXXXXX"></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('usertype12') . '</TD>
<TD><SELECT NAME="type">
<OPTION ' . $s['A'] . ' VALUE="A">' . __('admin12') . '</OPTION>
<OPTION ' . $s['D'] . ' VALUE="D">' . __('domainadmin12') . '</OPTION>
<OPTION ' . $s['U'] . ' VALUE="U">' . __('user12') . '</OPTION>
<OPTION ' . $s['R'] . ' VALUE="R">' . __('userregex12') . "</OPTION>
</SELECT></TD></TR>\n";
        echo ' <TR><TD CLASS="heading">' . __('usertimeout12') . '</TD><TD><INPUT TYPE="TEXT" NAME="timeout" VALUE="' . $timeout . '" size="5"> <span class="font-1em">' . __('empty12') . '=' . __('usedefault12') . '</span></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('quarrep12') . '</TD><TD><INPUT TYPE="CHECKBOX" NAME="quarantine_report" ' . $quarantine_report . '> <span class="font-1em">' . __('senddaily12') . '</span> <button type="submit" name="action" value="sendReportNow">' . __('sendReportNow12') . '</button></td></tr>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('quarreprec12') . '</TD><TD><INPUT TYPE="TEXT" NAME="quarantine_rcpt" VALUE="' . $user->quarantine_rcpt . '"><br><span class="font-1em">' . __('overrec12') . '</span></TD>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('scanforspam12') . '</TD><TD><INPUT TYPE="CHECKBOX" NAME="noscan" ' . $noscan . '> <span class="font-1em">' . __('scanforspam212') . '</span></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('pontspam12') . '</TD><TD><INPUT TYPE="TEXT" NAME="spamscore" VALUE="' . $user->spamscore . '" size="4"> <span class="font-1em">0=' . __('usedefault12') . '</span></TD></TR>' . "\n";
        echo ' <TR><TD CLASS="heading">' . __('hpontspam12') . '</TD><TD><INPUT TYPE="TEXT" NAME="highspamscore" VALUE="' . $user->highspamscore . '" size="4"> <span class="font-1em">0=' . __('usedefault12') . '</span></TD></TR>' . "\n";
        echo '<TR><TD CLASS="heading">' . __('action_0212') . '</TD><TD><INPUT TYPE="RESET" VALUE="' . __('reset12') . '">&nbsp;&nbsp;<INPUT TYPE="SUBMIT" VALUE="' . __('update12') . '"></TD></TR>' . "\n";
        echo "</TABLE></FORM><BR>\n";
        return;
    } else {
        if (false === checkFormToken('/user_manager.php edit token', $_POST['formtoken'])) {
            return getHtmlMessage(__('dietoken99'), 'error');
        }
        // Do update
        $username = html_entity_decode(deepSanitizeInput($_POST['username'], 'string'));
        if (!validateInput($username, 'user')) {
            $username = '';
        }
        $n_type = deepSanitizeInput($_POST['type'], 'url');
        if (is_string($membertest = testSameDomainMembership($username, 'to'))) {
            return $membertest;
        } elseif (is_string($permissiontest = testPermissions($username, $n_type, $user->type))) {
            return $permissiontest;
        } elseif (is_string($validusertest = testValidUser($username, $n_type, $user->username))) {
            return $validusertest;
        } else {
            return storeUser($username, $n_type, $user->id, $user->username, $user->type);
        }
    }
}

function deleteUser()
{
    if (is_string($tokentest = testToken())) {
        return $tokentest;
    }

    $user = getUserById($_GET['id']);
    if (is_string($user)) {
        return $user;
    }

    if (is_string($membertest = testSameDomainMembership($user->username, 'delete'))) {
        return $membertest;
    } elseif ($_SESSION['user_type'] === 'D' && $user->type !== 'U') {
        return getHtmlMessage(__('erroradminforbidden12'), 'error');
    } elseif ($_SESSION['myusername'] === $user->username) {
        return getHtmlMessage(__('errordeleteself12'), 'error');
    } else {
        $sql = "DELETE u,f FROM users u LEFT JOIN user_filters f ON u.username = f.username WHERE u.username='" . safe_value($user->username) . "'";
        dbquery($sql);
        audit_log(sprintf(__('auditlog0412', true), $user->username));
        return getHtmlMessage(sprintf(__('userdeleted12'), $user->username), 'success');
    }
}

function userFilter()
{
    if (is_string($tokentest = testToken())) {
        return $tokentest;
    }

    if (isset($_POST['id'])) {
        $user = getUserById($_POST['id']);
    } else {
        $user = getUserById($_GET['id']);
    }
    if (is_string($user)) {
        return $user;
    } elseif (is_string($membertest = testSameDomainMembership($user->username, 'filter'))) {
        return $membertest;
    } elseif (is_string($permissiontest = testPermissions($user->username, $user->type, ''))) {
        return $permissiontest;
    }

    $id = $user->id;

    $getFilter = '';
    if (isset($_POST['filter'])) {
        if (false === checkFormToken('/user_manager.php filter token', $_POST['formtoken'])) {
            return getHtmlMessage(__('dietoken99'), 'error');
        }
        $getFilter = deepSanitizeInput($_POST['filter'], 'url');
        if (!validateInput($getFilter, 'email') && !validateInput($getFilter, 'host')) {
            $getFilter = '';
        }
    }

    if (isset($_POST['new']) && $getFilter !== '') {
        $getActive = deepSanitizeInput($_POST['active'], 'url');
        if (!validateInput($getActive, 'yn')) {
            return getHtmlMessage(__('dievalidate99'), 'error');
        }
        $sql = "INSERT INTO user_filters (username, filter, active) VALUES ('" . safe_value($user->username) . "','" . safe_value($getFilter) . "','" . safe_value($getActive) . "')";
        dbquery($sql);
        if (DEBUG === true) {
            echo $sql;
        }
    }

    if (isset($_GET['delete'], $_GET['filter'])) {
        $getFilter = deepSanitizeInput($_GET['filter'], 'url');
        if (!validateInput($getFilter, 'email') && !validateInput($getFilter, 'host')) {
            return getHtmlMessage(__('dievalidate99'), 'error');
        }
        $sql = "DELETE FROM user_filters WHERE username='" . safe_value($user->username) . "' AND filter='" . safe_value($getFilter) . "'";
        dbquery($sql);
        if (DEBUG === true) {
            echo $sql;
        }
    }
    if (isset($_GET['change_state'], $_GET['filter'])) {
        $getFilter = deepSanitizeInput($_GET['filter'], 'url');
        if (!validateInput($getFilter, 'email') && !validateInput($getFilter, 'host')) {
            return getHtmlMessage(__('dievalidate99'), 'error');
        }
        $sql = "SELECT active FROM user_filters WHERE username='" . safe_value($user->username) . "' AND filter='" . safe_value($getFilter) . "'";
        $result = dbquery($sql);
        $active = $result->fetch_row();
        $active = $active[0];
        if ($active === 'Y') {
            $sql = "UPDATE user_filters SET active='N' WHERE username='" . safe_value($user->username) . "' AND filter='" . safe_value($getFilter) . "'";
            dbquery($sql);
        } else {
            $sql = "UPDATE user_filters SET active='Y' WHERE username='" . safe_value($user->username) . "' AND filter='" . safe_value($getFilter) . "'";
            dbquery($sql);
        }
    }
    $sql = "SELECT filter, CASE WHEN active='Y' THEN '" . __('yes12') . "' ELSE '" . __('no12') . "' END AS active, CONCAT('<a href=\"javascript:delete_filter\(\'" . safe_value($id) . "\',\'',filter,'\'\)\">" . __('delete12') . "</a>&nbsp;&nbsp;<a href=\"javascript:change_state(\'" . safe_value($id) . "\',\'',filter,'\')\">" . __('toggle12') . "</a>') AS actions FROM user_filters WHERE username='" . safe_value($user->username) . "'";
    $result = dbquery($sql);
    echo '<FORM METHOD="POST" ACTION="user_manager.php">' . "\n";
    echo '<INPUT TYPE="HIDDEN" NAME="action" VALUE="filters">' . "\n";
    echo '<INPUT TYPE="HIDDEN" NAME="token" VALUE="' . $_SESSION['token'] . '">' . "\n";
    echo '<INPUT TYPE="HIDDEN" NAME="id" VALUE="' . $id . '">' . "\n";
    echo '<INPUT TYPE="HIDDEN" NAME="formtoken" VALUE="' . generateFormToken('/user_manager.php filter token') . '">' . "\n";

    echo '<INPUT TYPE="hidden" NAME="new" VALUE="true">' . "\n";
    echo '<TABLE CLASS="mail" BORDER="0" CELLPADDING="1" CELLSPACING="1">' . "\n";
    echo ' <TR><TH COLSPAN=3>' . __('userfilter12') . ' ' . $user->username . '</TH></TR>' . "\n";
    echo ' <TR><TH>' . __('filter12') . '</TH><TH>' . __('active12') . '</TH><TH>' . __('action12') . '</TH></TR>' . "\n";
    while ($row = $result->fetch_object()) {
        echo ' <TR><TD>' . $row->filter . '</TD><TD>' . $row->active . '</TD> ';
        if ($_SESSION['user_type'] === 'D' && $user->username === $_SESSION['myusername']) {
            echo '<TD>' . __('nofilteraction12') . '</TD></TR>' . "\n";
        } else {
            echo '<TD>' . $row->actions . '</TD></TR>' . "\n";
        }
    }
    // Prevent domain admins from altering their own filters
    if ($_SESSION['user_type'] === 'A' || ($_SESSION['user_type'] === 'D' && $user->username !== $_SESSION['myusername'])) {
        echo ' <TR><TD><INPUT TYPE="text" NAME="filter"></TD><TD><SELECT NAME="active"><OPTION VALUE="Y">' . __('yes12') . '<OPTION VALUE="N">' . __('no12') . '</SELECT></TD><TD><INPUT TYPE="submit" VALUE="' . __('add12') . '"></TD></TR>' . "\n";
    }
    echo '</TABLE><BR>' . "\n";
    echo '</FORM>' . "\n";
}

function sendReport()
{
    include_once __DIR__ . '/quarantine_report.inc.php';
    $requirementsCheck = Quarantine_Report::check_quarantine_report_requirements();
    if ($requirementsCheck !== true) {
        error_log('Requirements for sending quarantine reports not met: ' . $requirementsCheck);
        return getHtmlMessage(__('checkReportRequirementsFailed12'), 'error');
    } else {
        $user = getUserById($_POST['id']);
        if (is_string($user)) {
            return $user;
        }

        if (is_string($membertest = testSameDomainMembership($username, 'report'))) {
            return $membertest;
        } else {
            $quarantine_report = new Quarantine_Report();
            $reportResult = $quarantine_report->send_quarantine_reports(array($user->username));
            if ($reportResult['succ'] >= 0) {
                return getHtmlMessage(__('quarantineReportSend12'), 'success');
            } else {
                return getHtmlMessage(__('quarantineReportFailed12'), 'success');
            }
        }
    }
}

function logoutUser()
{
    if (is_string($tokentest = testToken())) {
        return $tokentest;
    }

    $user = getUserById($_GET['id']);
    if (is_string($user)) {
        return $user;
    }

    if (is_string($membertest = testSameDomainMembership($user->username, 'logout'))) {
        return $membertest;
    } elseif (is_string($permissiontest = testPermissions($user->username, $usre->type, ''))) {
        return $permissiontest;
    } elseif (is_string($validuser = testValidUser($user->username, $user->type, ''))) {
        return $validuser;
    }

    $sql = "UPDATE users SET login_expiry='-1' WHERE id='$user->id'";
    dbquery($sql);
    if (DEBUG === true) {
        echo $sql;
    }

    return getHtmlMessage(sprintf(__('userloggedout12'), $user->username), 'success');
}
?>
<script>
   function checkPasswords() {
       var pass0 = document.getElementById("password");
       var pass1 = document.getElementById("retypepassword");
       pass0.classList.remove("inputerror");
       pass1.classList.remove("inputerror");
       if(pass0.value !== pass1.value) {
           var errorDiv = document.getElementById("formerror");
           var errormsg = errorDiv.innerHTML;
           errorDiv.innerHTML = errormsg+"<?php echo __('errorpass12');?><br>";
           errorDiv.classList.remove("hidden");
           pass0.classList.add("inputerror");
           pass1.classList.add("inputerror");
           return false;
       } else {
           return true;
       }
   }

   function requiredFields() {
       var valid = true;
       var error = "";
       var username = document.getElementById("username");
       var pass0 = document.getElementById("password");
       username.classList.remove("inputerror");
       pass0.classList.remove("inputerror");
       if(username.value === "") {
           error = error+"<?php echo __('erroruserreq12');?><br>";
           username.classList.add("inputerror");
           valid = false;
       }
       if (pass0.value === "") {
           error = error+"<?php echo __('errorpwdreq12');?><br>";
           pass0.classList.add("inputerror");
           valid = false;
       }
       if (valid === false) {
           var errorDiv = document.getElementById("formerror");
           var errormsg = errorDiv.innerHTML;
           errorDiv.innerHTML = errormsg + error;
           errorDiv.classList.remove("hidden");
       }
       return valid;
   }


   function validateForm() {
       var errorDiv = document.getElementById("formerror");
       errorDiv.innerHTML = "";
       errorDiv.classList.add("hidden");
       var required = requiredFields();
       var checkpwd = checkPasswords();
       return !(checkpwd === false || required === false);
   }

</script>
<?php
if ($_SESSION['user_type'] === 'A' || $_SESSION['user_type'] === 'D') {
    ?>
    <script type="text/javascript">
        <!--
        function delete_user(id, name) {
            var yesno = confirm("<?php echo ' ' . __('areusuredel12') . ' '; ?>" + name + "<?php echo __('questionmark12'); ?>");
            if (yesno === true) {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>" + "&action=delete&id=" + id;
            } else {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>";
            }
        }

        function delete_filter(id, filter) {
            var yesno = confirm("<?php echo __('sure12'); ?>");
            if (yesno === true) {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>" + "&action=filters&id=" + id + "&filter=" + filter + "&delete=true";
            } else {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>" + "&action=filters&id=" + id;
            }
        }

        function change_state(id, filter) {
            var yesno = confirm("<?php echo __('sure12'); ?>");
            if (yesno === true) {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>" + "&action=filters&id=" + id + "&filter=" + filter + "&change_state=true";
            } else {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>" + "&action=filters&id=" + id;
            }
        }

        function logout_user(id, name) {
            var yesno = confirm("<?php echo ' ' . __('logout12') . ' '; ?>" + name + "<?php echo __('questionmark12'); ?>");
            if (yesno === true) {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>" + "&action=logout&id=" + id;
            } else {
                window.location = "?token=" + "<?php echo $_SESSION['token']; ?>";
            }
        }
        -->
    </script>
    <?php
    if (isset($_POST['action'])) {
        $action = deepSanitizeInput($_POST['action'], 'url');
    } elseif (isset($_GET['action'])) {
        $action = deepSanitizeInput($_GET['action'], 'url');
    }
    if (isset($action)) {
        if ($action !== 'sendReportNow' && !validateInput($action, 'action')) {
            die(getHtmlMessage(__('dievalidate99'), 'error'));
        }
        switch ($action) {
            case 'new':
                echo newUser();
                break;
            case 'edit':
                echo editUser();
                break;
            case 'delete':
                echo deleteUser();
                break;
            case 'filters':
                echo userFilter();
                break;
            case 'sendReportNow':
                echo sendReport();
                break;
            case 'logout':
                echo logoutUser();
                break;
        }
    }

    echo '<a href="?token=' . $_SESSION['token'] . '&amp;action=new">' . __('newuser12') . '</a>'."\n";
    echo '<br><br>'."\n";

    $domainAdminUserDomainFilter = '';
    if ($_SESSION['user_type'] === 'D') {
        if ($_SESSION['domain'] === '') {
            //if the domain admin has no domain set we assume he should see only users that has no domain set (no mail as username)
            $domainAdminUserDomainFilter = 'WHERE username NOT LIKE "%@%" AND type <> "A"';
        } else {
            $sql = "SELECT filter FROM user_filters WHERE username = '" . $_SESSION['myusername'] . "'";
            $result = dbquery($sql);
            $domainAdminUserDomainFilter = 'WHERE (username LIKE "%@' . $_SESSION['domain'] . '" AND type <> "A")';
            for ($i=0;$i<$result->num_rows;$i++) {
                $filter = $result->fetch_row();
                $domainAdminUserDomainFilter .= ' OR (username LIKE "%@' . $filter[0] . '" AND type = "U")';
            }
        }
    }

    $sql = "
        SELECT
          username AS '" . safe_value(__('username12')) . "',
          fullname AS '" . safe_value(__('fullname12')) . "',
        CASE
          WHEN type = 'A' THEN '" . __('admin12') . "'
          WHEN type = 'D' THEN '" . __('domainadmin12') . "'
          WHEN type = 'U' THEN '" . __('user12') . "'
          WHEN type = 'R' THEN '" . __('userregex12') . "'
        ELSE
          '" . __('unknowtype12') . "'
        END AS '" . safe_value(__('type12')) . "',
        CASE
          WHEN noscan = 1 THEN '" . __('noshort12') . "'
          WHEN noscan = 0 THEN '" . __('yesshort12') . "'
        ELSE
          '" . __('yesshort12') . "'
        END AS '" . safe_value(__('spamcheck12')) . "',
          spamscore AS '" . safe_value(__('spamscore12')) . "',
          highspamscore AS '" . safe_value(__('spamhscore12')) . "',
        CASE
          WHEN login_expiry > " . time() . " OR login_expiry = 0 THEN '" . safe_value(__('yes12')) . "'
        ELSE 
          '" . safe_value(__('no12')) . "'
        END AS '" . safe_value(__('loggedin12')) . "',
        CASE
WHEN login_expiry > " . time() . " OR login_expiry = 0 THEN CONCAT('<a href=\"?token=" . $_SESSION['token'] . "&amp;action=edit&amp;id=',id,'\">" . safe_value(__('edit12')) . "</a>&nbsp;&nbsp;<a href=\"javascript:delete_user(\'',id,'\',\'',username,'\')\">" . safe_value(__('delete12')) . '</a>&nbsp;&nbsp;<a href="?token=' . $_SESSION['token'] . "&amp;action=filters&amp;id=',id,'\">" . safe_value(__('filters12')) . "</a>&nbsp;&nbsp;<a href=\"javascript:logout_user(\'',id,'\',\'',username,'\')\">" . safe_value(__('logout12')) . "</a>')
        ELSE
          CONCAT('<a href=\"?token=" . $_SESSION['token'] . "&amp;action=edit&amp;id=',id,'\">" . safe_value(__('edit12')) . "</a>&nbsp;&nbsp;<a href=\"javascript:delete_user(\'',id,'\',\'',username,'\')\">" . safe_value(__('delete12')) . '</a>&nbsp;&nbsp;<a href="?token=' . $_SESSION['token'] . "&amp;action=filters&amp;id=',id,'\">" . safe_value(__('filters12')) . "</a>')
        END AS '" . safe_value(__('action12')) . "'
        FROM
          users " . $domainAdminUserDomainFilter . ' 
        ORDER BY
          username';
    dbtable($sql, __('usermgnt12'));
} else {
    if (!isset($_POST['submit'])) {
        $sql = "SELECT id, username, fullname, type, quarantine_report, spamscore, highspamscore, noscan, quarantine_rcpt FROM users WHERE username='" . safe_value($_SESSION['myusername']) . "'";
        $result = dbquery($sql);
        $row = $result->fetch_object();
        $quarantine_report = '';
        if ((int)$row->quarantine_report === 1) {
            $quarantine_report = 'checked="checked"';
        }

        $noscan='';
        if ((int)$row->noscan === 0) {
            $noscan = 'checked="checked"';
        }
        $s[$row->type] = 'selected';
        echo '<div id="formerror" class="hidden"></div>';
        echo '<form method="post" action="user_manager.php" onsubmit="return checkPasswords();">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="token" VALUE="' . $_SESSION['token'] . '">' . "\n";
        echo '<input type="hidden" name="action" value="edit">' . "\n";
        echo '<input type="hidden" name="id" value="' . $row->id . '">' . "\n";
        echo '<input type="hidden" name="submit" value="true">' . "\n";
        echo '<INPUT TYPE="HIDDEN" NAME="formtoken" VALUE="' . generateFormToken('/user_manager.php user token') . '">' . "\n";
        echo '<table class="mail useredit" border="0" cellpadding="1" cellspacing="1">' . "\n";
        echo ' <tr><td class="heading" colspan=2 align="center">' . __('edituser12') . ' ' . $row->username . '</td></tr>' . "\n";
        echo ' <tr><td class="heading">' . __('username0212') . '</td><td>' . $_SESSION['myusername'] . '</td></tr>' . "\n";
        echo ' <tr><td class="heading">' . __('name12') . '</td><td>' . $_SESSION['fullname'] . '</td></tr>' . "\n";
        if ($_SESSION['user_ldap'] !== true) {
            echo ' <tr><td class="heading">' . __('password12') . '</td><td><input type="password" id="password" name="password" value="xxxxxxxx" AUTOCOMPLETE="off"></td></tr>' . "\n";
            echo ' <tr><td class="heading">' . __('retypepassword12') . '</td><td><input type="password" id="retypepassword" name="password1" value="xxxxxxxx" AUTOCOMPLETE="off"></td></tr>' . "\n";
        }
        echo ' <tr><td class="heading">' . __('quarrep12') . '</td><td><input type="checkbox" name="quarantine_report" value="on" ' . $quarantine_report . '> <span class="font-1em">' . __('senddaily12') . '</span> <button type="submit" name="action" value="sendReportNow">' . __('sendReportNow12') . '</button></td></tr>' . "\n";
        echo ' <tr><td class="heading">' . __('quarreprec12') . '</td><td><input type="text" name="quarantine_rcpt" value="' . $row->quarantine_rcpt . '"><br><span class="font-1em">' . __('overrec12') . '</span></td>' . "\n";
        echo ' <tr><td class="heading">' . __('scanforspam12') . '</td><td><input type="checkbox" name="noscan" value="on" ' . $noscan . '> <span class="font-1em">' . __('scanforspam212') . '</span></td></tr>' . "\n";
        echo ' <tr><td class="heading">' . __('pontspam12') . '</td><td><input type="text" name="spamscore" value="' . $row->spamscore . '" size="4"> <span class="font-1em">0=' . __('usedefault12') . '</span></td></tr>' . "\n";
        echo ' <tr><td class="heading">' . __('hpontspam12') . '</td><td><input type="text" name="highspamscore" value="' . $row->highspamscore . '" size="4"> <span class="font-1em">0=' . __('usedefault12') . '</span></td></tr>' . "\n";
        echo '<tr><td class="heading">' . __('action_0212') . '</td><td><input type="reset" value="' . __('reset12') . '">&nbsp;&nbsp;<input type="submit" name="action" value="' . __('update12') . '"></td></tr>' . "\n";
        echo '</table></form><br>' . "\n";
        $sql = "SELECT filter, active FROM user_filters WHERE username='" . $row->username . "'";
        $result = dbquery($sql);
    } else {
        if (false === checkToken($_POST['token'])
              || false === checkFormToken('/user_manager.php user token', $_POST['formtoken'])) {
            die(getHtmlMessage(__('dietoken99'), 'error'));
        }
        if (!isset($_POST['action'])) {
            echo getHtmlMessage(__('formerror12'), 'error');
        } elseif ($_POST['action'] === 'sendReportNow') {
            include_once __DIR__ . '/quarantine_report.inc.php';
            $requirementsCheck = Quarantine_Report::check_quarantine_report_requirements();
            if ($requirementsCheck !== true) {
                echo getHtmlMessage(__('checkReportRequirementsFailed12'), 'error');
                error_log('Requirements for sending quarantine reports not met: ' . $requirementsCheck);
            } elseif (!isset($_POST['quarantine_report'])) {
                echo getHtmlMessage(__('noReportsEnabled12'), 'error');
            } else {
                $quarantine_report = new Quarantine_Report();
                $reportResult = $quarantine_report->send_quarantine_reports(array($_SESSION['myusername']));
                if ($reportResult['succ'] === 1) {
                    echo getHtmlMessage(__('quarantineReportSend12'), 'error');
                } else {
                    echo getHtmlMessage(__('quarantineReportFailed12'), 'error');
                }
            }
        } elseif (isset($_POST['password'], $_POST['password1']) && ($_POST['password'] !== $_POST['password1'])) {
            echo getHtmlMessage(__('errorpass12'), 'error');
        } else {
            $username = safe_value($_SESSION['myusername']);
            if (isset($_POST['password'])) {
                $n_password = safe_value($_POST['password']);
            }
            $spamscore = deepSanitizeInput($_POST['spamscore'], 'float');
            if (!validateInput($spamscore, 'float')) {
                $spamscore = '0';
            }
            $highspamscore = deepSanitizeInput($_POST['highspamscore'], 'float');
            if (!validateInput($highspamscore, 'float')) {
                $highspamscore = '0';
            }
            $n_quarantine_report = '1';
            if (!isset($_POST['quarantine_report'])) {
                $n_quarantine_report = '0';
            }
            $noscan = '0';
            if (!isset($_POST['noscan'])) {
                $noscan = '1';
            }
            $quarantine_rcpt = deepSanitizeInput($_POST['quarantine_rcpt'], 'string');
            if ($quarantine_rcpt !== '' && !validateInput($quarantine_rcpt, 'user')) {
                die(getHtmlMessage(__('dievalidate99'), 'error'));
            }

            if (isset($_POST['password']) && $_POST['password'] !== 'XXXXXXXX') {
                // Password reset required
                $password = password_hash($n_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password='" . $password . "', quarantine_report='$n_quarantine_report', spamscore='$spamscore', highspamscore='$highspamscore', noscan='$noscan', quarantine_rcpt='$quarantine_rcpt' WHERE username='$username'";
                dbquery($sql);
            } else {
                $sql = "UPDATE users SET quarantine_report='$n_quarantine_report', spamscore='$spamscore', highspamscore='$highspamscore', noscan='$noscan', quarantine_rcpt='$quarantine_rcpt' WHERE username='$username'";
                dbquery($sql);
            }

            // Audit
            audit_log(sprintf(__('auditlog0512', true), $username));
            echo getHtmlMessage(__('savedsettings12'), 'success');
        }
    }
}
// Add footer
html_end();
// Close any open db connections
dbclose();
