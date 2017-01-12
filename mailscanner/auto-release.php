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

/*
 * Mailwatch for Mailscanner Modification
 * Author: Alan Urquhart - ASU Web Services Ltd
 * Version: 1.2
 * Updated: 30-09-2016
 *
 * Requires: Mailwatch 1.2.0
 *
 * Provides the mechanism for one click release of quarantined emails as reported by the quarantine_report.php cron
 *
 * Changelog:
 *
 * V1.2 - 30-09-2016
 * Fixes table definition - GitHub Issue #291 (https://github.com/mailwatch/1.2.0/issues/291)
 *
 * SETUP:
 *
 * Create the following table in the mailscanner database:
 * CREATE TABLE IF NOT EXISTS `autorelease` (
 * `id` bigint(20) NOT NULL AUTO_INCREMENT,
 * `msg_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 * `uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 * PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;
 *
 * Update cron.daily/quarantine_report.php with the modified file
 * Update cron.daily/quarantine_maint.php with the modified file
 *
 */
require_once __DIR__ . '/functions.php';
if (isset($_GET['mid'], $_GET['r'])) {
    dbconn();
    $mid = safe_value($_GET['mid']);
    $token = safe_value($_GET['r']);
    $sql = "SELECT * FROM autorelease WHERE msg_id = '$mid'";
    $result = dbquery($sql);
    if (!$result) {
        dbg('Error fetching from database' . database::$link->error);
        echo __('dberror59');
    }
    if ($result->num_rows === 0) {
        echo '<p>' . __('msgnotfound159') . '</p>';
        echo '<p>' . __('msgnotfound259') . htmlentities($mid) . ' ' . __('msgnotfound359') . '</p>';
    } else {
        $row = $result->fetch_assoc();
        if ($row['uid'] === $token) {
            $list = quarantine_list_items($mid);
            $result = '';
            if (count($list) === 1) {
                $to = $list[0]['to'];
                $result = quarantine_release($list, array(0), $to);
            } else {
                $listCount = count($list);
                for ($i = 0; $i < $listCount; $i++) {
                    if (preg_match('/message\/rfc822/', $list[$i]['type'])) {
                        $result = quarantine_release($list, array($i), $list[$i]['to']);
                    }
                }
            }

            // Display success
            echo '<p>' . __('msgreleased59') . '</p>';
            //cleanup
            $releaseID = $row['id'];
            $query = "DELETE FROM autorelease WHERE id = '$releaseID'";
            $result = dbquery($query);
            if (!$result) {
                dbg('ERROR cleaning up database... ' . database::$link->error);
            }
        } else {
            echo __('tokenmismatch59');
        }
    }
} else {
    echo __('notallowed59');
}
