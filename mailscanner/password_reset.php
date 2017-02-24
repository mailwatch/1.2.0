<?php
/*
 * MailWatch for MailScanner
 * Copyright (C) 2003-2011  Steve Freegard (steve@freegard.name)
 * Copyright (C) 2011  Garrod Alwood (garrod.alwood@lorodoes.com)
 * Copyright (C) 2014-2017  MailWatch Team (https://github.com/mailwatch/1.2.0/graphs/contributors)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * In addition, as a special exception, the copyright holder gives permission to link the code of this program with
 * those files in the PEAR library that are licensed under the PHP License (or with modified versions of those files
 * that use the same license as those files), and distribute linked combinations including the two.
 * You must obey the GNU General Public License in all respects for all of the code used other than those files in the
 * PEAR library that are licensed under the PHP License. If you modify this program, you may extend this exception to
 * your version of the program, but you are not obligated to do so.
 * If you do not wish to do so, delete this exception statement from your version.
 *
 * As a special exception, you have permission to link this program with the JpGraph library and distribute executables,
 * as long as you follow the requirements of the GNU GPL in regard to all of the software in the executable aside from
 * JpGraph.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once __DIR__ . '/functions.php';

//Check if LDAP is enabled, if so, prevent usage
if (USE_LDAP === true) {
    die(__('pwdresetldap63'));
}

// Load in the required PEAR modules
require_once MAILWATCH_HOME . '/lib/pear/Mail.php';
require_once MAILWATCH_HOME . '/lib/pear/Mail/smtp.php';
require_once MAILWATCH_HOME . '/lib/pear/Mail/mime.php';
date_default_timezone_set(TIME_ZONE);

$showpage = false;
$fields = '';
$errors = '';
$message = '';
$link = dbconn();

if (defined('PWD_RESET') && PWD_RESET === true) {
    if (isset($_POST['Submit']) && $_POST['Submit'] === __('requestpwdreset63')) {
        //check email add registered user and password reset is allowed
        $email = $link->real_escape_string($_POST['email']);
        $sql = "SELECT * FROM users WHERE username = '$email'";
        $result = dbquery($sql);
        if ($result->num_rows !== 1) {
            //user not found
            $errors = '<p class="pwdreseterror">' . __('usernotfound63') . '</p>';
            audit_log(sprintf(__('auditlogunf63'), $email));
            $showpage = true;
        } else {
            //user found, now check type of user
            $row = $result->fetch_assoc();
            if ($row['type'] === 'U') {
                //user type is user, password reset allowed
                $rand = get_random_string(16);
                $resetexpire = time() + 60 * 60 * RESET_LINK_EXPIRE;
                $sql = "UPDATE users SET resetid = '$rand', resetexpire = '$resetexpire' WHERE username = '$email'";
                $result = dbquery($sql);
                if (!$result) {
                    die(__('errordbupdate63'));
                }
                $html = '<!DOCTYPE html>
<html>
<head>
 <title>' . __('title63') . '</title>
 <style type="text/css">
 <!--
  body, td, tr {
  font-family: sans-serif;
  font-size: 8pt;
 }
 -->
 </style>
</head>
<body style="margin: 5px;">

<!-- Outer table -->
<table width="100%" border="0">
 <tr>
  <td><img src="' . MW_LOGO . '" alt="' . __('mwlogo99') . '"/></td>
  <td align="center" valign="middle">
   <h2>' . __('passwdresetrequest63') . '</h2>
   <p>' . sprintf(__('p1email63'), $email) . '</p>
    <a href="' . MAILWATCH_HOSTURL . '/password_reset.php?stage=2&user=' . $email . '&uid=' . $rand . '"><button>' . __('button63') . '</button></a></p>
  </td>
 </tr>
 </table>
</body>
</html>';
                $text = sprintf(__('01emailplaintxt63'), $email) . MAILWATCH_HOSTURL . '/password_reset.php?stage=2&user=' . $email . '&uid=' . $rand;

                //Send email
                $subject = __('passwdresetrequest63');
                $isSent = send_email($email, $html, $text, $subject, true);
                if ($isSent !== true) {
                    die('Error Sending email: ' .$isSent);
                } else {
                    $message = '<p>' . __('01emailsuccess63') . '</p>';
                    $showpage = true;
                    audit_log(sprintf(__('auditlogreserreqested63'), $email));
                }
            } else {
                //password reset not allowed
                audit_log(sprintf(__('auditlogresetdenied63'), $email));
                $errors = '<p class="pwdreseterror">' . __('resetnotallowed63') . '</p>';
                $showpage = true;
               // die(__('resetnotallowed63'));
            }
        }
    } elseif (isset($_POST['Submit']) && $_POST['Submit'] === __('button63')) {
        //check passwords match, update password in database, update password last changed date, increase password reset counter, email user to inform of password reset
        $email = $link->real_escape_string($_POST['email']);
        $uid = $link->real_escape_string($_POST['uid']);
        if ($_POST['pwd1'] === $_POST['pwd2']) {
            //passwords match, now we need to store them
            //first, check form hasn't been modified
            $sql = "SELECT resetid FROM users WHERE username = '$email'";
            $result = dbquery($sql);
            $row = $result->fetch_array();
            if ($row['resetid'] === $_POST['uid']) {
                require_once MAILWATCH_HOME . '/lib/password.php';
                $password = $link->real_escape_string(password_hash($_POST['pwd1'], PASSWORD_DEFAULT));
                $lastreset = time();
                $sql = "UPDATE users SET password = '$password', resetid = '', resetexpire = '0', lastreset ='$lastreset' WHERE username ='$email'";
                $result = dbquery($sql);

                //now send email telling user password has been updated.
                $html = '<!DOCTYPE html>
<html>
<head>
 <title>' . __('pwdresetsuccess63') . '</title>
 <style type="text/css">
 <!--
  body, td, tr {
  font-family: sans-serif;
  font-size: 8pt;
 }
 -->
 </style>
</head>
<body style="margin: 5px;">

<!-- Outer table -->
<table width="100%%" border="0">
 <tr>
  <td><img src="' . MW_LOGO . '" alt="' . __('mwlogo99') . '"/></td>
  <td align="center" valign="middle">
   <h2>' . __('pwdresetsuccess63') . '</h2>
   <p>' . sprintf(__('03pwdresetemail63'), $email) . '</p>
  </td>
 </tr>
 </table>
</body>
</html>';
                $text = sprintf(__('04pwdresetemail63'), $email);

                //Send email
                $subject = __('pwdresetsuccess63');
                send_email($email, $html, $text, $subject, true);
                $message = '<p>' . __('pwdresetsuccess63') . '<br/>
<a href="login.php"><button>' . __('login01') . '</button></a></p>';
                $showpage = true;
            } else {
                die(__('pwdresetidmismatch63'));
            }
        } else {
            $errors = '<p class="pwdreseterror">' . __('pwdmismatch63');
            $fields = 'stage2';
            $showpage = true;
        }
    } elseif (isset($_GET['stage']) && $_GET['stage'] === '1') {
        //first stage, need to get email address
        $fields = 'stage1';
        $showpage = true;
    } elseif (isset($_GET['stage']) && $_GET['stage'] === '2') {
        //need to check if reset allowed, and reset password
        if (isset($_GET['user']) && isset($_GET['uid'])) {
            //check that uid is correct
            $email = $link->real_escape_string($_GET['user']);
            $uid = $link->real_escape_string($_GET['uid']);
            $sql = "SELECT * FROM users WHERE username = '$email'";
            $result = dbquery($sql);
            if ($result->num_rows !== 1) {
                echo __('usernotfound63');
            } else {
                $row = $result->fetch_array();
                if ($row['resetid'] === $uid) {
                    //reset id matches - check if link expired
                    if ($row['resetexpire'] < time()) {
                        echo __('resetexpired63') . '<a href="password_reset.php?stage=1">' . __('button63') . '</a>';
                    } else {
                        $fields = 'stage2';
                        $showpage = true;
                    }
                } else {
                    echo __('pwdresetidmismatch63');
                }
            }
        } else {
            //no matches - deny
            die(__('brokenlink63'));
        }
    }

    if ($showpage) {
        ?>
        <!doctype html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?php echo __('title63'); ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="shortcut icon" href="images/favicon.png">
            <link rel="stylesheet" href="style.css" type="text/css">
        </head>
        <body class="pwdreset">
        <div class="pwdreset">
            <img src="<?php echo MAILWATCH_HOSTURL . IMAGES_DIR . MW_LOGO; ?>" alt="<?php echo __('mwlogo99'); ?>">
            <div class="border-rounded">
                <h1><?php echo __('title63'); ?></h1>
                <?php if (file_exists('conf.php')) {
            if ($fields !== '') {
                ?>
                        <form name="pwdresetform" class="pwdresetform" method="post"
                              action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <fieldset>
                                <?php if (isset($_GET['error']) || $errors !== '') {
                    ?>
                                    <p class="pwdreseterror">
                                        <?php echo $errors; ?>
                                    </p>
                                    <?php

                }

                if ($fields === 'stage1') {
                    ?>
                                    <p><label><?php echo __('emailaddress63'); ?></label></p>
                                    <p><input name="email" type="text" id="email" autofocus></p>
                                    <p><input type="submit" name="Submit"
                                              value="<?php echo __('requestpwdreset63'); ?>"></p>
                                    <?php

                }
                if ($fields === 'stage2') {
                    ?>
                                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                                    <p><label><?php echo __('01pwd63'); ?></label></p>
                                    <p><input name="pwd1" type="password" id="pwd1" autofocus></p>
                                    <p><label><?php echo __('02pwd63'); ?></label></p>
                                    <p><input name="pwd2" type="password" id="pwd2"></p>
                                    <p><input type="submit" name="Submit" value="<?php echo __('button63'); ?>"></p>
                                    <?php

                } ?>

                            </fieldset>
                        </form>
                        <?php

            } elseif ($message !== '') {
                echo $message;
            } elseif ($errors !== '') {
                echo $errors;
            }
        } else {
            ?>
                    <p class="error">
                        <?php echo __('cannot_read_conf'); ?>
                    </p>
                    <?php

        } ?>
            </div>
        </div>

        </body>
        </html>
        <?php

    }
} else {
    die(__('conferror63'));
}
