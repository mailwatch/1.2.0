<?php

/*
 * MailWatch for MailScanner
 * Copyright (C) 2003-2011  Steve Freegard (steve@freegard.name)
 * Copyright (C) 2011  Garrod Alwood (garrod.alwood@lorodoes.com)
 * Copyright (C) 2014-2018  MailWatch Team (https://github.com/mailwatch/1.2.0/graphs/contributors)
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
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class Quarantine_Report
{
    /**
     * @return boolean|string true if requirements are met; else missing requirements as string
     */
    public static function check_quarantine_report_requirements()
    {
        $required_constant = [
            'QUARANTINE_REPORT_DAYS',
            'MAILWATCH_HOSTURL',
            'QUARANTINE_DAYS_TO_KEEP',
            'QUARANTINE_REPORT_FROM_NAME',
            'MAILWATCH_FROM_ADDR',
            'QUARANTINE_REPORT_SUBJECT',
            'MAILWATCH_HOME',
            'MAILWATCH_MAIL_HOST',
            'FROMTO_MAXLEN',
            'SUBJECT_MAXLEN',
            'TIME_ZONE',
            'DATE_FORMAT',
            'TIME_FORMAT',
            'QUARANTINE_FILTERS_COMBINED'
        ];
        $required_constant_missing = '';
        foreach ($required_constant as $constant) {
            if (!defined($constant)) {
                $required_constant_missing .= sprintf(__('message61'), $constant) . "\n";
            }
        }
        if ($required_constant_missing === '') {
            return true;
        }

        return $required_constant_missing;
    }

    private static function get_html_template()
    {
        return '<!DOCTYPE html>
<html>
<head>
 <title>' . __('title61') . '</title>
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
  <td><img src="' . MW_LOGO . '"/></td>
  <td align="center" valign="middle">
   <h2>' . __('text611') . '</h2>
   ' . __('text612') . '
  </td>
 </tr>
 <tr>
  <td colspan="2">%s</td>
 </tr>
</table>
</body>
</html>';
    }

    private static function get_html_table()
    {
        return '<table width="100%%" border="0">
 <tr>
  <td style="background-color: #F7CE4A"><b>' . __('received61') . '</b></td>
  <td style="background-color: #F7CE4A"><b>' . __('to61') . '</b></td>
  <td style="background-color: #F7CE4A"><b>' . __('from61') . '</b></td>
  <td style="background-color: #F7CE4A"><b>' . __('subject61') . '</b></td>
  <td style="background-color: #F7CE4A"><b>' . __('reason61') . '</b></td>
  <td style="background-color: #F7CE4A"><b>' . __('action61') . '</b></td>
 </tr>
%s
</table>';
    }

    private static $html_content = ' <tr>
  <td style="background-color: #EBEBEB">%s</td>
  <td style="background-color: #EBEBEB">%s</td>
  <td style="background-color: #EBEBEB">%s</td>
  <td style="background-color: #EBEBEB">%s</td>
  <td style="background-color: #EBEBEB">%s</td>
  <td style="background-color: #EBEBEB">%s</td>
 </tr>
';

    private static $text_template = 'Quarantine Report for %s

In the last %s day(s) you have received %s e-mails that have been quarantined and are listed below. All messages in the quarantine are automatically deleted %s days after the date that they were received.

%s';


    private static $text_content = 'Received: %s
From: %s
Subject: %s
Reason: %s
Action:
%s

';

    private $users_sql = '
SELECT
 username,
 quarantine_rcpt,
 type
FROM
 users
WHERE
 quarantine_report=1
';

    private static $filters_sql = "
SELECT
 filter
FROM
 user_filters
WHERE
 username=%s
AND
 active='Y'
";

    private static function get_report_sql()
    {
        $report_sql = "
SELECT DISTINCT
a.id AS id,
DATE_FORMAT(timestamp,'" . str_replace('%', '%%', DATE_FORMAT) . ' <br/>' . str_replace('%', '%%', TIME_FORMAT) . "') AS datetime,
a.timestamp AS timestamp,
a.to_address AS to_address,
a.from_address AS from_address,
a.subject AS subject,
a.token AS token,
CASE
 WHEN a.virusinfected>0 THEN '" . __('virus61') . "'
 WHEN a.nameinfected>0 THEN '" . __('badcontent61') . "'
 WHEN a.otherinfected>0 THEN '" . __('infected61') . "'
 WHEN a.ishighspam>0 THEN '" . __('spam61') . "'
 WHEN a.issaspam>0 THEN '" . __('spam61') . "'
 WHEN a.isrblspam>0 THEN '" . __('spam61') . "'
 WHEN a.spamblacklisted>0 THEN '" . __('blacklisted61') . "'
 WHEN a.isspam THEN '" . __('spam61') . "'
 WHEN a.ismcp>0 THEN '" . __('policy61') . "'
 WHEN a.ishighmcp>0 THEN '" . __('policy61') . "'
 WHEN a.issamcp>0 THEN '" . __('policy61') . "'
 WHEN a.mcpblacklisted>0 THEN '" . __('policy61') . "'
 WHEN a.isspam>0 THEN '" . __('spam61') . "'
 ELSE '" . __('unknow61') . "'
END AS reason
FROM
 maillog a
WHERE
 a.quarantined = 1
AND ((to_address =%s) OR (to_domain =%s))
AND
 a.date >= DATE_SUB(CURRENT_DATE(), INTERVAL " . QUARANTINE_REPORT_DAYS . ' DAY)';

        // Hide high spam/mcp from users if enabled
        if (defined('HIDE_HIGH_SPAM') && HIDE_HIGH_SPAM === true) {
            $report_sql .= '
    AND
     ishighspam=0
    AND
     COALESCE(ishighmcp,0)=0';
        }

        if (defined('HIDE_NON_SPAM') && HIDE_NON_SPAM === true) {
            $report_sql .= '
    AND
    isspam>0';
        }

        if (defined('HIDE_UNKNOWN') && HIDE_UNKNOWN === true) {
            $report_sql .= '
    AND
    (
    virusinfected>0
    OR
    nameinfected>0
    OR
    otherinfected>0
    OR
    ishighspam>0
    OR
    isrblspam>0
    OR
    spamblacklisted>0
    OR
    ismcp>0
    OR
    ishighmcp>0
    OR
    issamcp>0
    OR
    isspam>0
    )';
        }

        $report_sql .= '
ORDER BY a.date DESC, a.time DESC';

        return $report_sql;
    }


    /**
     * @param array $usersForReport array containing users for which the reports should be send; if empty reports are send for all users
     * @return false|array if requirements not met; else an associative array counting successfull and failed reports for users
     */
    public function send_quarantine_reports($usersForReport = [])
    {
        if (self::check_quarantine_report_requirements() !== true) {
            return false;
        }
        if (PHP_SAPI === 'cli') {
            ini_set('html_errors', 'off');
            ini_set('display_errors', 'on');
            ini_set('implicit_flush', 'false');
            ini_set('error_reporting', E_ALL);
        }
        date_default_timezone_set(TIME_ZONE);
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 0);

        if (count($usersForReport) > 0) {
            $userConditions = [];
            foreach ($usersForReport as $item) {
                $userConditions[] = ' username=' .  \MailWatch\Sanitize::quote_smart($item);
            }
            $this->users_sql .= ' AND ( ' . implode(' OR ', $userConditions) . ' ) ';
        }
        $result = \MailWatch\Db::query($this->users_sql);
        $rows = $result->num_rows;
        $num_successfull_reports = 0;
        $num_failed_reports = 0;
        if ($rows > 0) {
            while ($user = $result->fetch_object()) {
                self::dbg("\n === Generating report for " . $user->username . ' type=' . $user->type);
                // Work out destination e-mail address
                switch ($user->type) {
                    case 'D':
                        // Type: domain admin - this must be overridden
                        if (!empty($user->quarantine_rcpt)) {
                            $email = $user->quarantine_rcpt;
                        } else {
                            $email = filter_var($user->username, FILTER_VALIDATE_EMAIL);
                        }
                        $to_address = $user->username;
                        if (preg_match('/(\S+)@(\S+)/', $user->username, $split)) {
                            $to_domain = $split[2];
                        } else {
                            $to_domain = $user->username;
                        }
                        break;
                    case 'A':
                    case 'U':
                    default:
                        // Type 'A'dministrator, 'U'ser and everything else just in case...
                        if (!empty($user->quarantine_rcpt)) {
                            $email = $user->quarantine_rcpt;
                        } else {
                            $email = filter_var($user->username, FILTER_VALIDATE_EMAIL);
                        }
                        $to_address = $user->username;
                        $to_domain = $user->username;
                        break;
                }
                // Make sure we have a destination address
                if (!empty($email) && false !== $email) {
                    $sendResult = self::send_reports_for_user($user->username, $user->type, $email, $to_address, $to_domain);
                    if ($sendResult) {
                        $num_successfull_reports++;
                    } else {
                        $num_failed_reports++;
                    }
                } else {
                    self::dbg(' ==== ' . $user->username . ' has empty e-mail recipient address, skipping...');
                }
            }
        }

        return [
            'succ' => $num_successfull_reports,
            'failed' => $num_failed_reports
        ];
    }

    /**
     * @param string $username
     * @param string $type
     * @param string $email
     * @param string $to_address
     * @param string $to_domain
     * @return true if all reports were send successfully; false if one or more reports could not be send
     */
    private static function send_reports_for_user($username, $type, $email, $to_address, $to_domain)
    {
        self::dbg(" ==== Recipient e-mail address is $email");
        // Get any additional reports required
        $filters = array_merge([$to_address], self::return_user_filters($username));
        if (QUARANTINE_FILTERS_COMBINED === false) {
            $sendResult = false;
            foreach ($filters as $filter) {
                if ($type === 'D') {
                    $filter_domain = preg_match('/(\S+)@(\S+)/', $filter, $split) ? $split[2] : $filter;
                    $list_for = $filter_domain;
                } else {
                    $filter_domain = $to_domain;
                    $list_for = $filter;
                }

                self::dbg(" ==== Building list for $list_for");
                $quarantined = self::return_quarantine_list_array($filter, $filter_domain);

                self::dbg(' ==== Found ' . count($quarantined) . ' quarantined e-mails');
                if (count($quarantined) > 0) {
                    $sendResult = self::send_quarantine_email($email, $list_for, $quarantined);
                }
                unset($quarantined);
            }

            return $sendResult;
        } else {

            //combined
            $quarantine_list = [];
            $quarantined = [];

            foreach ($filters as $filter) {
                if ($type === 'D') {
                    $filter_domain = preg_match('/(\S+)@(\S+)/', $filter, $split) ? $split[2] : $filter;
                    $list_for = $filter_domain;
                } else {
                    $filter_domain = $to_domain;
                    $list_for = $filter;
                }

                $quarantine_list[] = $list_for;
                self::dbg(" ==== Building list for $list_for");
                $tmp_quarantined = self::return_quarantine_list_array($filter, $filter_domain);

                self::dbg(' ==== Found ' . count($tmp_quarantined) . ' quarantined e-mails');
                if (count($tmp_quarantined) > 0) {
                    $quarantined[] = $tmp_quarantined;
                }
            }
            $quarantined = array_merge(...$quarantined);
            if (count($quarantined) > 0) {
                $list = implode(', ', $quarantine_list);
                return self::send_quarantine_email($email, $list, self::quarantine_sort($quarantined));
            }
            unset($quarantined, $quarantine_list);

            return false;
        }
    }

    /**
     * @param string $text
     */
    private static function dbg($text)
    {
        if (PHP_SAPI === 'cli') {
            echo $text . "\n";
        } elseif (DEBUG) {
            echo $text . '<br>';
        }
    }

    /**
     * @param string $user
     * @return array
     */
    private static function return_user_filters($user)
    {
        $result = \MailWatch\Db::query(sprintf(self::$filters_sql, \MailWatch\Sanitize::quote_smart($user)));
        $rows = $result->num_rows;
        $array = [];
        if ($rows > 0) {
            while ($row = $result->fetch_object()) {
                $array[] = $row->filter;
            }
        }

        return $array;
    }

    /**
     * @param string $to_address
     * @param string $to_domain
     * @return array
     */
    private static function return_quarantine_list_array($to_address, $to_domain)
    {
        $result = \MailWatch\Db::query(sprintf(self::get_report_sql(), \MailWatch\Sanitize::quote_smart($to_address), \MailWatch\Sanitize::quote_smart($to_domain)));
        $rows = $result->num_rows;
        $array = [];
        if ($rows > 0) {
            while ($row = $result->fetch_object()) {
                $array[] = [
                    'id' => trim($row->id),
                    'datetime' => trim($row->datetime),
                    'to' => trim_output($row->to_address, FROMTO_MAXLEN),
                    'from' => trim_output($row->from_address, FROMTO_MAXLEN),
                    'subject' => trim_output($row->subject, SUBJECT_MAXLEN),
                    'reason' => trim($row->reason),
                    'timestamp' => trim($row->timestamp),
                    'token' => trim($row->token)
                ];
            }
        }

        return $array;
    }

    /**
     * @param array $qitem
     * @return bool
     */
    private static function store_auto_release($qitem)
    {
        $id = $qitem['id'];
        $rand = $qitem['rand'];
        $result = \MailWatch\Db::query("INSERT INTO autorelease (msg_id,uid) VALUES ('$id','$rand')", false);
        if (!$result) {
            self::dbg(' ==== Error generating auto_release....skipping...');
            \MailWatch\Security::audit_log('Quarantine_Report: Error generating auto_release for msg_id ' . $id . ', uid' . $rand);

            return false;
        }

        return true;
    }

    /**
     * @param array $qitem
     * @return string|bool stored uid or false if not found or found too many
     */
    private static function check_auto_release($qitem)
    {
        //function checks if message already has an autorelease entry
        $id = $qitem['id'];
        $result = \MailWatch\Db::query("SELECT * FROM autorelease WHERE msg_id = '$id'", false);
        if (!$result) {
            self::dbg(' === Error checking if msg_id already exists.....skipping....');
        } else {
            if ($result->num_rows === 0) {
                return false;//msg_id not found,
            }

            if ($result->num_rows === 1) {
                $row = $result->fetch_array();

                return $row['uid']; //return the stored uid
            }

            self::dbg('=== Error, msg_id exists more than once....generating new one...');

            return false;
        }

        return false;
    }

    /**
     * @param string $email
     * @param string $filter
     * @param array $quarantined
     * @return boolean true if mail was send; false if error occured
     */
    private static function send_quarantine_email($email, $filter, $quarantined)
    {
        // Setup variables to prevent warnings
        $h1 = '';
        $t1 = '';
        // Build the quarantine list for this recipient
        foreach ($quarantined as $qitem) {
            //Check if auto-release is enabled
            $links = '<a href="' . MAILWATCH_HOSTURL . '/viewmail.php?token=' . $qitem['token'] . '&id=' . $qitem['id'] . '">' . __('view61') . '</a>';
            if (defined('AUTO_RELEASE') && AUTO_RELEASE === true) {
                //Check if email already has an autorelease entry
                $exists = self::check_auto_release($qitem);
                if (!$exists) {
                    $qitem['rand'] = \MailWatch\Security::get_random_string(10);
                    $auto_release = self::store_auto_release($qitem);
                } else {
                    $qitem['rand'] = $exists;
                    $auto_release = true;
                }
                if ($auto_release) {
                    // add auto release link if enabled
                    $links .= '  <a href="' . MAILWATCH_HOSTURL . '/auto-release.php?mid=' . $qitem['id'] . '&r=' . $qitem['rand'] . '">' . __('release61') . '</a>';
                }
            }

            // HTML Version
            $h1 .= sprintf(
                self::$html_content,
                $qitem['datetime'],
                $qitem['to'],
                $qitem['from'],
                $qitem['subject'],
                $qitem['reason'],
                $links
            );
            // Text Version
            $t1 .= sprintf(
                self::$text_content,
                strip_tags($qitem['datetime']),
                $qitem['to'],
                $qitem['from'],
                $qitem['subject'],
                $qitem['reason']
            );
        }

        // HTML
        $h2 = sprintf(self::get_html_table(), $h1);
        $html_report = sprintf(self::get_html_template(), $filter, QUARANTINE_REPORT_DAYS, count($quarantined), QUARANTINE_DAYS_TO_KEEP, $h2);
        if (DEBUG === true) {
            echo '<pre>' . $html_report . '</pre>';
        }

        // Text
        $text_report = sprintf(self::$text_template, $filter, QUARANTINE_REPORT_DAYS, count($quarantined), QUARANTINE_DAYS_TO_KEEP, $t1);
        if (DEBUG === true) {
            echo "<pre>$text_report</pre>\n";
        }

        // Send e-mail
        $isSent = send_email($email, $html_report, $text_report, QUARANTINE_REPORT_SUBJECT);
        if ($isSent === true) {
            self::dbg(" ==== Sent e-mail to $email");

            return true;
        }

        self::dbg(" ==== ERROR sending e-mail to $email " . $isSent);

        return false;
    }

    /**
     * @param array $q
     * @return array
     */
    private static function quarantine_sort($q)
    {
        $key = 'timestamp';
        usort($q, function ($a, $b) use (&$key) {
            return strtotime($a[$key]) - strtotime($b[$key]);
        });

        return array_reverse($q);
    }
}
