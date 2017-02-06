#!/usr/bin/php -q
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

if (php_sapi_name() !== 'cli') {
    header('Content-type: text/plain');
}

// Edit if you changed webapp directory from default
$pathToFunctions = '/var/www/html/mailscanner/functions.php';

if (!is_file($pathToFunctions)) {
    die('Cannot find functions.php file in "' . $pathToFunctions . '": edit ' . __FILE__ . ' and set the right path on line ' . (__LINE__ - 3) . PHP_EOL);
}

require_once $pathToFunctions;

$link = dbconn();

$mysql_utf8_variant = array(
    'utf8' => array('charset' => 'utf8', 'collation' => 'utf8_unicode_ci'),
    'utf8mb4' => array('charset' => 'utf8mb4', 'collation' => 'utf8mb4_unicode_ci')
);

/**
 * @param string $input
 * @return string
 */
function pad($input)
{
    return str_pad($input, 70, '.', STR_PAD_RIGHT);
}

/**
 * @param string $sql
 */
function executeQuery($sql)
{
    global $link;
    if ($link->query($sql)) {
        echo ' OK' . PHP_EOL;
    } else {
        echo ' ERROR' . PHP_EOL;
        die('Database error: ' . $link->error . " - SQL = '$sql'" . PHP_EOL);
    }
}

/**
 * @param string $table
 * @return bool|mysqli_result
 */
function check_table_exists($table)
{
    global $link;
    $sql = 'SHOW TABLES LIKE "' . $table . '"';

    return ($link->query($sql)->num_rows > 0);
}

/**
 * @param string $table
 * @param string $column
 * @return bool|mysqli_result
 */
function check_column_exists($table, $column)
{
    global $link;
    $sql = 'SHOW COLUMNS FROM `' . $table . '` LIKE "' . $column . '"';

    return ($link->query($sql)->num_rows > 0);
}

/**
 * @return string|bool
 */
function check_database_charset()
{
    global $link;
    $sql = 'SELECT default_character_set_name
            FROM information_schema.schemata
            WHERE schema_name = "' . DB_NAME . '"';
    $result = $link->query($sql);
    $row = $result->fetch_array();
    if (null !== $row && isset($row[0])) {
        return $row[0];
    }

    return false;
}

/**
 * @param string $db
 * @param string $table
 * @param string $utf8variant
 * @return bool
 */
function check_utf8_table($db, $table, $utf8variant = 'utf8')
{
    global $link;
    $sql = 'SELECT c.character_set_name
            FROM information_schema.tables AS t, information_schema.collation_character_set_applicability AS c
            WHERE c.collation_name = t.table_collation
            AND t.table_schema = "' . $link->real_escape_string($db) . '"
            AND t.table_name = "' . $link->real_escape_string($table) . '"';
    $result = $link->query($sql);

    return strtolower(database::mysqli_result($result, 0)) === $utf8variant;
}

/**
 * @param string $table
 * @return array
 */
function getTableIndexes($table)
{
    global $link;
    $sql = 'SHOW INDEX FROM `' . $table . '`';
    $result = $link->query($sql);

    $indexes = array();
    if (false === $result || $result->num_rows === 0) {
        return $indexes;
    }

    while ($row = $result->fetch_assoc()) {
        $indexes[] = $row['Key_name'];
    }

    return $indexes;
}

$errors = false;


// Upgrade mailwatch database
// Test connectivity to the database

echo PHP_EOL;
echo 'MailWatch for MailScanner Database Upgrade to 1.2.0 (RC5-dev)' .  PHP_EOL;
// echo 'MailWatch for MailScanner Database Upgrade to ' . mailwatch_version() .  PHP_EOL;

echo PHP_EOL;
echo pad('Testing connectivity to the database ');

if ($link) {
    echo ' OK' . PHP_EOL;
    // Update schema at this point
    echo PHP_EOL;
    echo 'Updating database schema: ' . PHP_EOL;
    echo PHP_EOL;

    /*
    ** Updates to the schema for 1.2.0
    */

    $server_utf8_variant = 'utf8';

    // Convert database to utf8 if not already utf8mb4 or if other charset
    echo pad(' - Convert database to ' . $server_utf8_variant . '');
    if (check_database_charset() === 'utf8mb4') {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $server_utf8_variant = 'utf8';
        $sql = 'ALTER DATABASE `' . DB_NAME .
            '` CHARACTER SET = ' . $mysql_utf8_variant[$server_utf8_variant]['charset'] .
            ' COLLATE = ' . $mysql_utf8_variant[$server_utf8_variant]['collation'];
        executeQuery($sql);
    }

    echo PHP_EOL;

    // Drop geoip table
    echo pad(' - Drop `geoip_country` table');
    if (false === check_table_exists('geoip_country')) {
        echo ' ALREADY DROPPED' . PHP_EOL;
    } else {
        $sql = 'DROP TABLE IF EXISTS `geoip_country`';
        executeQuery($sql);
    }

    // Drop spamscores table
    echo pad(' - Drop `spamscores` table');
    if (false === check_table_exists('spamscores')) {
        echo ' ALREADY DROPPED' . PHP_EOL;
    } else {
        $sql = 'DROP TABLE IF EXISTS `spamscores`';
        executeQuery($sql);
    }

    // Add autorelease table if not exist (1.2RC2)
    echo pad(' - Add autorelease table to `' . DB_NAME . '` database');
    if (true === check_table_exists('autorelease')) {
        echo ' ALREADY EXIST' . PHP_EOL;
    } else {
        $sql = 'CREATE TABLE IF NOT EXISTS `autorelease` (
            `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
            `msg_id` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
            `uid` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';
        executeQuery($sql);
    }

    echo PHP_EOL;

    // Truncate needed for VARCHAR field used as PRIMARY or FOREIGN KEY when using UTF-8mb4

    // Table audit_log
    echo pad(' - Fix schema for username field in `audit_log` table');
    $sql = "ALTER TABLE `audit_log` CHANGE `user` `user` VARCHAR( 191 ) NOT NULL DEFAULT ''";
    executeQuery($sql);

    // Table blacklist
    echo pad(' - Fix schema for id field in `blacklist` table');
    $sql = "ALTER TABLE `blacklist` CHANGE `id` `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT";
    executeQuery($sql);

    // Table users
    echo pad(' - Fix schema for username field in `users` table');
    $sql = "ALTER TABLE `users` CHANGE `username` `username` VARCHAR( 191 ) NOT NULL DEFAULT ''";
    executeQuery($sql);

    // Table user_filters
    echo pad(' - Fix schema for username field in `user_filters` table');
    $sql = "ALTER TABLE `user_filters` CHANGE `username` `username` VARCHAR( 191 ) NOT NULL DEFAULT ''";
    executeQuery($sql);

    // Table whitelist
    echo pad(' - Fix schema for username field in `whitelist` table');
    $sql = "ALTER TABLE `whitelist` CHANGE `id` `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT";
    executeQuery($sql);

    // Revert back some tables to the right values due to previous errors in upgrade.php

    // Table users
    echo pad(' - Fix schema for password field in `users` table');
    $sql = 'ALTER TABLE `users` CHANGE `password` `password` VARCHAR( 255 ) DEFAULT NULL';
    executeQuery($sql);

    echo pad(' - Fix schema for fullname field in `users` table');
    $sql = "ALTER TABLE `users` CHANGE `fullname` `fullname` VARCHAR( 255 ) NOT NULL DEFAULT ''";
    executeQuery($sql);

    // Table mcp_rules
    echo pad(' - Fix schema for rule_desc field in `mcp_rules` table');
    $sql = "ALTER TABLE `mcp_rules` CHANGE `rule_desc` `rule_desc` VARCHAR( 200 ) NOT NULL DEFAULT ''";
    executeQuery($sql);

    echo PHP_EOL;

    // Add new column and index to audit_log table
    echo pad(' - Add maillog_id field and primary key to `audit_log` table');
    if (true === check_column_exists('audit_log', 'id')) {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $sql = 'ALTER TABLE `audit_log` ADD `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`id`)';
        executeQuery($sql);
    }

    // Add new column and index to inq table
    echo pad(' - Add inq_id field and primary key to `inq` table');
    if (true === check_column_exists('inq', 'inq_id')) {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $sql = 'ALTER TABLE `inq` ADD `inq_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`inq_id`)';
        executeQuery($sql);
    }

    // Add new column and index to maillog table
    echo pad(' - Add maillog_id field and primary key to `maillog` table');
    if (true === check_column_exists('maillog', 'maillog_id')) {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $sql = 'ALTER TABLE `maillog` ADD `maillog_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`maillog_id`)';
        executeQuery($sql);
    }

    // Add new column and index to mtalog table
    echo pad(' - Add mtalog_id field and primary key to `mtalog` table');
    if (true === check_column_exists('mtalog', 'mtalog_id')) {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $sql = 'ALTER TABLE `mtalog` ADD `mtalog_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`mtalog_id`)';
        executeQuery($sql);
    }

    // Add new column and index to outq table
    echo pad(' - Add mtalog_id field and primary key to `outq` table');
    if (true === check_column_exists('outq', 'outq_id')) {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $sql = 'ALTER TABLE `outq` ADD `outq_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`outq_id`)';
        executeQuery($sql);
    }

    // Add new column and index to saved_filters table
    echo pad(' - Add id field and primary key to `saved_filters` table');
    if (true === check_column_exists('saved_filters', 'id')) {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $sql = 'ALTER TABLE `saved_filters` ADD `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`id`)';
        executeQuery($sql);
    }

    // Add new column and index to user_filters table
    echo pad(' - Add mtalog_id field and primary key to `user_filters` table');
    if (true === check_column_exists('user_filters', 'id')) {
        echo ' ALREADY DONE' . PHP_EOL;
    } else {
        $sql = 'ALTER TABLE `user_filters` ADD `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`id`)';
        executeQuery($sql);
    }

    echo PHP_EOL;

    // Convert database to utf8mb4 if MySQL ≥ 5.5.3
    if ($link->server_version >= 50503) {
        $server_utf8_variant = 'utf8mb4';
        echo pad(' - Convert database to ' . $server_utf8_variant . '');
        if (check_database_charset() === 'utf8mb4') {
            echo ' ALREADY DONE' . PHP_EOL;
        } else {
            $sql = 'ALTER DATABASE `' . DB_NAME .
                '` CHARACTER SET = ' . $mysql_utf8_variant[$server_utf8_variant]['charset'] .
                ' COLLATE = ' . $mysql_utf8_variant[$server_utf8_variant]['collation'];
            executeQuery($sql);
        }
    }

    echo PHP_EOL;

    $utf8_tables = array(
        'audit_log',
        'autorelease',
        'blacklist',
        'inq',
        'maillog',
        'mcp_rules',
        'mtalog',
        'mtalog_ids',
        'outq',
        'saved_filters',
        'sa_rules',
        'spamscores',
        'users',
        'user_filters',
        'whitelist',
    );

    // Convert tables to utf8 using $utf8_tables array
    foreach ($utf8_tables as $table) {
        echo pad(' - Convert table `' . $table . '` to ' . $server_utf8_variant . '');
        if (false === check_table_exists($table)) {
            echo ' DO NOT EXISTS' . PHP_EOL;
        } else {
            if (check_utf8_table(DB_NAME, $table, $server_utf8_variant) === false) {
                $sql = 'ALTER TABLE `' . $table .
                    '` CONVERT TO CHARACTER SET ' . $mysql_utf8_variant[$server_utf8_variant]['charset'] .
                    ' COLLATE ' . $mysql_utf8_variant[$server_utf8_variant]['collation'];
                executeQuery($sql);
            } else {
                echo ' ALREADY CONVERTED' . PHP_EOL;
            }
        }
    }

    echo PHP_EOL;

    // Convert tables to innoDB using $utf8_tables array
    foreach ($utf8_tables as $table) {
        echo pad(' - Convert table `' . $table . '` to innoDB');
        if (false === check_table_exists($table)) {
            echo ' DO NOT EXISTS' . PHP_EOL;
        } else {
            if (check_utf8_table(DB_NAME, $table, $server_utf8_variant) === false) {
                $sql = 'ALTER TABLE `' . $table . '` ENGINE = INNODB';
                executeQuery($sql);
            } else {
                echo ' ALREADY CONVERTED' . PHP_EOL;
            }
        }
    }

    // check for missing indexes
    $indexes = array(
        'maillog' => array(
            'maillog_datetime_idx' => array('fields' => '(`date`,`time`)', 'type' => 'KEY'),
            'maillog_id_idx' => array('fields' => '(`id`(20))', 'type' => 'KEY'),
            'maillog_clientip_idx' => array('fields' => '(`clientip`(20))', 'type' => 'KEY'),
            'maillog_from_idx' => array('fields' => '(`from_address`(200))', 'type' => 'KEY'),
            'maillog_to_idx' => array('fields' => '(`to_address`(200))', 'type' => 'KEY'),
            'maillog_host' => array('fields' => '(`hostname`(30))', 'type' => 'KEY'),
            'from_domain_idx' => array('fields' => '(`from_domain`(50))', 'type' => 'KEY'),
            'to_domain_idx' => array('fields' => '(`to_domain`(50))', 'type' => 'KEY'),
            'maillog_quarantined' => array('fields' => '(`quarantined`)', 'type' => 'KEY'),
            'timestamp_idx' => array('fields' => '(`timestamp`)', 'type' => 'KEY'),
            'subject_idx' => array('fields' => '(`subject`)', 'type' => 'FULLTEXT'),
        )
    );

    foreach ($indexes as $table => $indexlist) {
        echo PHP_EOL;
        echo ' - Search for missing indexes......................................... OK';
        echo PHP_EOL;
        $existingIndexes = getTableIndexes($table);
        foreach ($indexlist as $indexname => $indexValue) {
            if (!in_array($indexname, $existingIndexes, true)) {
                echo pad(' - Adding missing index `' . $indexname . '` on table `' . $table . '`');
                $sql = 'ALTER TABLE `' . $table .
                    '` ADD ' . $indexValue['type'] . ' `' . $indexname . '` ' .
                    $indexValue['fields'] .
                    ';';
                executeQuery($sql);
            }
        }
    }
    dbclose();
} else {
    echo ' FAILED' . PHP_EOL;
    $errors[] = 'Database connection failed: ' . $link->error;
}

echo PHP_EOL;

// Check MailScanner settings
echo 'Checking MailScanner.conf settings: ' . PHP_EOL;
echo PHP_EOL;
$check_settings = array(
    'QuarantineWholeMessage' => 'yes',
    'QuarantineWholeMessagesAsQueueFiles' => 'no',
    'DetailedSpamReport' => 'yes',
    'IncludeScoresInSpamAssassinReport' => 'yes',
    'SpamActions' => 'store',
    'HighScoringSpamActions' => 'store',
    'AlwaysLookedUpLast' => '&MailWatchLogging'
);

foreach ($check_settings as $setting => $value) {
    echo pad(" - $setting ");
    if (preg_match('/' . $value . '/', get_conf_var($setting))) {
        echo ' OK' . PHP_EOL;
    } else {
        echo ' WARNING' . PHP_EOL;
        $errors[] = "MailScanner.conf: $setting != $value (=" . get_conf_var($setting) . ')';
    }
}

echo PHP_EOL;

// Check configuration for missing entries
echo 'Checking conf.php configuration entry: ' . PHP_EOL;
echo PHP_EOL;
$missingConfigEntries = checkConfVariables();
if ($missingConfigEntries['needed']['count'] === 0) {
    echo ' - All needed entries are OK' . PHP_EOL;
} else {
    foreach ($missingConfigEntries['needed']['list'] as $missingConfigEntry) {
        echo pad(" - $missingConfigEntry ") . ' WARNING' . PHP_EOL;
        $errors[] = 'conf.php: missing configuration entry "' . $missingConfigEntry . '"';
    }
}

if ($missingConfigEntries['obsolete']['count'] === 0) {
    echo ' - All obsolete entries are already removed' . PHP_EOL;
} else {
    foreach ($missingConfigEntries['obsolete']['list'] as $missingConfigEntry) {
        echo pad(" - $missingConfigEntry ") . ' WARNING' . PHP_EOL;
        $errors[] = 'conf.php: obsolete configuration entry "' . $missingConfigEntry . '" still present';
    }
}

echo PHP_EOL;

// Error messages
if (is_array($errors)) {
    echo '*** ERROR/WARNING SUMMARY ***' . PHP_EOL;
    foreach ($errors as $error) {
        echo $error . PHP_EOL;
    }
    echo PHP_EOL;
}
