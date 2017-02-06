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

/* languages/en.php */
/* v0.3.10 */

return array(
    // 01-login.php
    'username' => 'User:',
    'password' => 'Password:',
    'mwloginpage01' => 'MailWatch Login Page',
    'mwlogin01' => 'MailWatch Login',
    'badup01' => 'Bad Username or Password',
    'emptypassword01' => 'Password cannot be empty',
    'errorund01' => 'An undefined error occurred',
    'login01' => 'Login',

    // 03-functions.php
    'jumpmessage03' => 'Go to message:',
    'cuser03' => 'User',
    'cst03' => 'System Time',
    'colorcodes03' => 'Color Codes',
    'badcontentinfected03' => 'Bad Content/Infected',
    'whitelisted03' => 'Whitelisted',
    'blacklisted03' => 'Blacklisted',
    'notverified03' => 'Not Verified',
    'mailscanner03' => 'Mailscanner:',
    'none03' => 'None',
    'yes03' => 'YES',
    'no03' => 'NO',
    'status03' => 'Status',
    'message03' => 'Message',
    'tries03' => 'Tries',
    'last03' => 'Last',
    'loadaverage03' => 'Load Average:',
    'mailqueue03' => 'Mail Queues',
    'inbound03' => 'Inbound:',
    'outbound03' => 'Outbound:',
    'clean03' => 'Clean',
    'topvirus03' => 'Top Virus:',
    'freedspace03' => 'Free Disk Space',
    'todaystotals03' => 'Today\'s Totals',
    'processed03' => 'Processed:',
    'cleans03' => 'Clean:',
    'viruses03' => 'Viruses:',
    'blockedfiles03' => 'Blocked Files:',
    'others03' => 'Other:',
    'spam03' => 'Spam:',
    'spam103' => 'Spam',
    'hscospam03' => 'High Score Spam:',
    'hscomcp03' => 'High Score MCP:',
    'recentmessages03' => 'Recent Messages',
    'lists03' => 'Black and White Lists',
    'quarantine03' => 'Quarantine',
    'datetime03' => 'Date/Time',
    'from03' => 'From',
    'to03' => 'To',
    'size03' => 'Size',
    'subject03' => 'Subject',
    'sascore03' => 'SA Score',
    'mcpscore03' => 'MCP Score',
    'found03' => 'found',
    'highspam03' => 'High Spam',
    'mcp03' => 'MCP',
    'highmcp03' => 'High MCP',
    'reports03' => 'Search and Reports',
    'toolslinks03' => 'Tools and Links',
    'softwareversions03' => 'Software Versions',
    'documentation03' => 'Documentation',
    'logout03' => 'Logout',
    'pggen03' => 'Page generated in',
    'seconds03' => 'seconds',
    'disppage03' => 'Displaying page',
    'of03' => 'of',
    'records03' => 'Records',
    'to0203' => 'to',
    'score03' => 'Score',
    'matrule03' => 'Matching Rule',
    'description03' => 'Description',
    'footer03' => 'MailWatch for MailScanner v',
    'mailwatchtitle03' => 'MailWatch for Mailscanner',
    'radiospam203' => 'S',
    'radioham03' => 'H',
    'radioforget03' => 'F',
    'radiorelease03' => 'R',
    'clear03' => 'Clear</a> all',
    'spam203' => 'S</b> = Spam',
    'ham03' => 'H</b> = Ham',
    'forget03' => 'F</b> = Forget',
    'release03' => 'R</b> = Released',
    'learn03' => 'Learn',
    'ops03' => 'Options',
    'or03' => 'or',
    'mwfilterreport03' => 'MailWatch Filter Report:',
    'mwforms03' => 'MailWatch for Mailscanner - ',
    'dieerror03' => 'Error:',
    'dievirus03' => 'You are running MailWatch in distributed mode therefore MailWatch cannot read your MailScanner configuration files to acertain your primary virus scanner - please edit functions.php and manually set the VIRUS_REGEX constant for your primary scanner.',
    'diescanner03' => 'Unable to select a regular expression for your primary virus scanner ($scanner) - please see the examples in functions.php to create one.',
    'diedbconn103' => 'Could not connect to database:',
    'diedbconn203' => 'Could not select db:',
    'diedbquery03' => 'Error executing query:',
    'dieruleset03' => 'Cannot open ruleset file',
    'dienomsconf03' => 'Cannot open MailScanner configuration file',
    'dienoconfigval103' => 'Cannot find configuration value:',
    'dienoconfigval203' => 'in',
    'ldpaauth103' => 'Could not connect to',
    'ldpaauth203' => 'Could not search',
    'ldpaauth303' => 'Could not get entries',
    'ldapgetconfvar103' => 'Error: could not connect to LDAP directory on:',
    'ldapgetconfvar203' => 'Error: unable to bind to LDAP directory',
    'ldapgetconfvar303' => 'Error: cannot find configuration value',
    'ldapgetconfvar403' => 'in LDAP directory.',
    'dietranslateetoi03' => 'Cannot open MailScanner ConfigDefs file:',
    'diequarantine103' => 'Message ID',
    'diequarantine203' => 'not found.',
    'diequarantine303' => 'Cannot open quarantine dir:',
    'diereadruleset03' => 'Cannot open MailScanner ruleset file',
    'hostfailed03' => '(Hostname lookup failed)',
    'clientip03' => 'Client IP',
    'host03' => 'Host',
    'date03' => 'Date',
    'time03' => 'Time',
    'releaseerror03' => 'Release: error',
    'releasemessage03' => 'Release: message released to',
    'releaseerrorcode03' => 'Release: error code',
    'returnedfrom03' => 'returned from Sendmail:',
    'salearn03' => 'SA Learn',
    'salearnerror03' => 'SA Learn: error code',
    'salearnreturn03' => 'returned from sa-learn:',
    'badcontent03' => 'Bad Content',
    'otherinfected03' => 'Other',
    'and03' => 'and',
    'ldapresultset03' => 'LDAP: The returned result-set contains more than one person. So we can not be sure that the user',
    'ldapisunique03' => 'is unique',
    'ldapresults03' => 'in LDAP results',
    'ldapno03' => 'no',
    'ldapnobind03' => 'Could not bind to server %s. Returned Error was: [%s] %s',
    'ldapnoresult03' => 'LDAP: The server returned no result-set for user',
    'ldapresultnodata03' => 'LDAP: The returned result set contains no data for user',
    'virus03' => 'Virus',
    'sql03' => 'SQL:',
    'norowfound03' => 'No rows retrieved!',
    'auditlogreport03' => 'Ran report',
    'auditlogquareleased03' => 'Quarantined message (%s) released to',
    'auditlogspamtrained03' => 'SpamAssassin was trained and reported on message %s as',
    'spamerrorcode0103' => 'SpamAssassin: error code',
    'spamerrorcode0203' => 'returned from SpamAssassin:',
    'spamassassin03' => 'SpamAssassin:',
    'auditlogdelqua03' => 'Deleted file from quarantine:',
    'auditlogdelerror03' => 'Delete: error deleting file',
    'auditlogupdatepassword03' => 'Updated password field length from %s to 191',
    'auditlogupdateuser03' => 'Updated password for user',
    'verifyperm03' => 'Please verify read permissions on',
    'count03' => 'Count',
    '1minute03' => '1 min.:',
    '5minutes03' => '5 min.:',
    '15minutes03' => '15 min.:',
    'saspam03' => 'Spam',
    'sanotspam03' => 'Not spam',
    'colon03' => ':',

    // 04-detail.php
    'receivedon04' => 'Received on:',
    'receivedby04' => 'Received by:',
    'receivedfrom04' => 'Received from:',
    'receivedvia04' => 'Received Via:',
    'msgheaders04' => 'Message Headers:',
    'from04' => 'From:',
    'to04' => 'To:',
    'size04' => 'Size:',
    'subject04' => 'Subject:',
    'hdrantivirus04' => 'Anti-Virus/Dangerous Content Protection',
    'blkfile04' => 'Blocked File:',
    'otherinfec04' => 'Other Infection:',
    'hscospam04' => 'High Score Spam:',
    'listedrbl04' => 'Listed in RBL:',
    'spamwl04' => 'SPAM Whitelisted:',
    'spambl04' => 'SPAM Blacklisted:',
    'saautolearn04' => 'Spamassassin Autolearn:',
    'sascore04' => 'Spamassassin Score:',
    'spamrep04' => 'Spam Report:',
    'hdrmcp04' => 'Message Content Protection (MCP)',
    'highscomcp04' => 'High Scoring MCP:',
    'mcpwl04' => 'MCP Whitelisted:',
    'mcpbl04' => 'MCP Blacklisted:',
    'mcpscore04' => 'MCP Score:',
    'mcprep04' => 'MCP Report:',
    'ipaddress04' => 'IP Address',
    'country04' => 'Country',
    'all04' => 'All',
    'addwl04' => 'Add to Whitelist',
    'addbl04' => 'Add to Blacklist',
    'release04' => 'Release',
    'delete04' => 'Delete',
    'salearn04' => 'SA Learn',
    'file04' => 'File',
    'type04' => 'Type',
    'path04' => 'Path',
    'dang04' => 'Dangerous',
    'altrecip04' => 'Alternate Recipient(s):',
    'submit04' => 'Submit',
    'actions04' => 'Action(s):',
    'quarcmdres04' => 'Quarantine Command Results',
    'resultmsg04' => 'Result Messages',
    'id04' => 'ID:',
    'virus04' => 'Virus:',
    'spam04' => 'Spam:',
    'spamassassinspam04' => 'SpamAssassin Spam:',
    'quarantine04' => 'Quarantine',
    'messdetail04' => 'Message Detail',
    'dieid04' => 'Message ID',
    'dienotfound04' => 'not found!',
    'asham04' => 'As Ham',
    'aspam04' => 'As Spam',
    'forget04' => 'Forget',
    'spamreport04' => 'As Spam+Report',
    'spamrevoke04' => 'As Ham+Revoke',
    'geoipfailed04' => '(GeoIP lookup failed)',
    'reversefailed04' => '(Reverse Lookup Failed)',
    'privatenetwork04' => '(Private Network)',
    'localhost04' => '(Localhost)',
    'hostname04' => 'Hostname',
    'yes04' => 'Y',
    'no04' => 'N',
    'relayinfo04' => 'Relay Information:',
    'errormess04' => 'Error Messages:',
    'error04' => 'Error:',
    'auditlog04' => 'Viewed message detail',

    // 05-status.php
    'recentmsg05' => 'Recent Messages',
    'last05' => 'Last',
    'messages05' => 'Messages',
    'refevery05' => 'Refreshing every',
    'seconds05' => 'seconds',

    // 06-viewmail.php
    'msgviewer06' => 'Message Viewer',
    'releasemsg06' => 'Release this message',
    'deletemsg06' => 'Delete this message',
    'actions06' => 'Actions:',
    'date06' => 'Date:',
    'from06' => 'From:',
    'to06' => 'To:',
    'subject06' => 'Subject:',
    'nomessid06' => 'No input Message ID',
    'mess06' => 'Message',
    'notfound06' => 'not found',
    'error06' => 'Error:',
    'errornfd06' => 'Error: file not found',
    'mymetype06' => 'MIME Type:',
    'auditlog06' => 'Quarantined message (%s) body viewed',
    'nonameattachment06' => 'Attachment without name',
    'colon06' => ':',

    // 07-lists.php
    'addwlbl07' => 'Add to Whitelist/Blacklist',
    'from07' => 'From:',
    'to07' => 'To:',
    'list07' => 'List:',
    'action07' => 'Action:',
    'wl07' => 'Whitelist',
    'bl07' => 'Blacklist',
    'reset07' => 'Reset',
    'add07' => 'Add',
    'delete07' => 'Delete',
    'wblists07' => 'Whitelist/Blacklist',
    'errors07' => 'Errors:',
    'error071' => 'You must select a list to create the entry.',
    'error072' => 'You must enter a from address (user@domain, domain or IP).',
    'noentries07' => 'No entries found.',
    'auditlogadded07' => 'Added entry [%s] for %s in the %s',
    'auditlogremoved07' => 'Removed entry [%s] for %s in the %s',

    // 08-quarantine.php
    'folder08' => 'Folder:',
    'folder_0208' => 'Folder',
    'items08' => 'items',
    'qviewer08' => 'Quarantine Viewer',
    'dienodir08' => 'No quarantine directories found',
    'colon08' => ':',

    // 09-filter.inc.php
    'activefilters09' => 'Active Filters',
    'addfilter09' => 'Add Filter',
    'loadsavef09' => 'Load/Save Filter',
    'tosetdate09' => 'To set date you must use YYYY-mm-dd format',
    'oldrecord09' => 'Oldest record:',
    'newrecord09' => 'Newest record:',
    'messagecount09' => 'Message count:',
    'stats09' => 'Statistics (Filtered)',
    'add09' => 'Add',
    'load09' => 'Load',
    'save09' => 'Save',
    'delete09' => 'Delete',
    'none09' => 'None',
    'equal09' => 'is equal to',
    'notequal09' => 'is not equal to',
    'greater09' => 'is greater than',
    'greaterequal09' => 'is greater than or equal to',
    'less09' => 'is less than',
    'lessequal09' => 'is less than or equal to',
    'like09' => 'contains',
    'notlike09' => 'does not contain',
    'regexp09' => 'matches the regular expression',
    'notregexp09' => 'does not match the regular expression',
    'isnull09' => 'is null',
    'isnotnull09' => 'is not null',
    'date09' => 'Date',
    'headers09' => 'Headers',
    'id09' => 'Message ID',
    'size09' => 'Size (bytes)',
    'fromaddress09' => 'From',
    'fromdomain09' => 'From Domain',
    'toaddress09' => 'To',
    'todomain09' => 'To Domain',
    'subject09' => 'Subject',
    'clientip09' => 'Received from (IP Address)',
    'isspam09' => 'is Spam (>0 = TRUE)',
    'ishighspam09' => 'is High Scoring Spam (>0 = TRUE)',
    'issaspam09' => 'is Spam according to SpamAssassin (>0 = TRUE)',
    'isrblspam09' => 'is Listed in one or more RBL\'s (>0 = TRUE)',
    'spamwhitelisted09' => 'is Whitelisted (>0 = TRUE)',
    'spamblacklisted09' => 'is Blacklisted (>0 = TRUE)',
    'sascore09' => 'SpamAssassin Score',
    'spamreport09' => 'Spam Report',
    'ismcp09' => 'is MCP (>0 = TRUE)',
    'ishighmcp09' => 'is High Scoring MCP (>0 = TRUE)',
    'issamcp09' => 'is MCP according to SpamAssassin (>0 = TRUE)',
    'mcpwhitelisted09' => 'is MCP Whitelisted (>0 = TRUE)',
    'mcpblacklisted09' => 'is MCP Blacklisted (>0 = TRUE)',
    'mcpscore09' => 'MCP Score',
    'mcpreport09' => 'MCP Report',
    'virusinfected09' => 'contained a Virus (>0 = TRUE)',
    'nameinfected09' => 'contained an Unacceptable Attachment (>0 = TRUE)',
    'otherinfected09' => 'contained other infections (>0 = TRUE)',
    'report09' => 'Virus Report',
    'hostname09' => 'MailScanner Hostname',
    'remove09' => 'Remove',
    'reports09' => 'Reports',

    // 10-other.php
    'tools10' => 'Tools',
    'toolslinks10' => 'Tools and Links',
    'usermgnt10' => 'User Management',
    'avsophosstatus10' => 'Sophos Status',
    'avfsecurestatus10' => 'F-Secure Status',
    'avclamavstatus10' => 'ClamAV Status',
    'avmcafeestatus10' => 'McAfee Status',
    'avfprotstatus10' => 'F-Prot Status',
    'mysqldatabasestatus10' => 'MySQL Database Status',
    'viewconfms10' => 'View MailScanner Configuration',
    'editmsrules10' => 'Edit MailScanner Rulesets',
    'spamassassinbayesdatabaseinfo10' => 'SpamAssassin Bayes Database Info',
    'updatesadesc10' => 'Update SpamAssassin Rule Descriptions',
    'updatemcpdesc10' => 'Update MCP Rule Descriptions',
    'updategeoip10' => 'Update GeoIP Database',
    'links10' => 'Links',

    // 11-sf_versions.php
    'softver11' => 'Software Versions',
    'nodbdown11' => 'No database downloaded',
    'version11' => 'Version:',

    // 12-user_manager.php
    'usermgnt12' => 'User Management',
    'username12' => 'Username',
    'fullname12' => 'Full Name',
    'type12' => 'Type',
    'spamcheck12' => 'Spam Check',
    'spamscore12' => 'Spam Score',
    'spamhscore12' => 'High Spam Score',
    'action12' => 'Actions',
    'edit12' => 'Edit',
    'delete12' => 'Delete',
    'filters12' => 'Filters',
    'newuser12' => 'New User',
    'forallusers12' => 'For all users other than Administrator you must use an email address for the username',
    'username0212' => 'Username:',
    'name12' => 'Name:',
    'password12' => 'Password:',
    'usertype12' => 'User Type:',
    'user12' => 'User',
    'domainadmin12' => 'Domain Administrator',
    'admin12' => 'Administrator',
    'quarrep12' => 'Quarantine Report:',
    'senddaily12' => 'Send Daily Report',
    'quarreprec12' => 'Quarantine Report Recipient:',
    'overrec12' => 'Override quarantine report recipient?<BR>(uses your username if blank)',
    'scanforspam12' => 'Scan for Spam:',
    'scanforspam212' => 'Scan e-mail for Spam',
    'pontspam12' => 'Spam Score:',
    'hpontspam12' => 'High Spam Score:',
    'usedefault12' => 'Use Default',
    'action_0212' => 'Action:',
    'reset12' => 'Reset',
    'areusuredel12' => 'Are you sure you want to delete user',
    'errorpass12' => 'Password mismatch',
    'edituser12' => 'Edit User',
    'create12' => 'Create',
    'userregex12' => 'User (Regexp)',
    'update12' => 'Update',
    'userfilter12' => 'User Filters for',
    'filter12' => 'Filter',
    'add12' => 'Add',
    'active12' => 'Active',
    'yes12' => 'Yes',
    'no12' => 'No',
    'questionmark12' => '?',
    'toggle12' => 'Activate/Deactivate',
    'sure12' => 'Are you sure?',
    'unknowtype12' => 'Unknown Type',
    'yesshort12' => 'Y',
    'noshort12' => 'N',
    'auditlog0112' => 'New',
    'auditlog0212' => 'created',
    'auditlog0312' => 'User type changed for user',
    'auditlogfrom12' => 'from',
    'auditlogto12' => 'to',
    'auditlog0412' => 'User %s deleted',
    'auditlog0512' => 'User [%s] updated their own account',
    'erroreditnodomainforbidden12' => 'Error: You don\'t have the permissions, to edit users without domain',
    'erroreditdomainforbidden12' => 'Error: You don\'t have the permissions, to edit users of domain %s',
    'errortonodomainforbidden12' => 'Error: You don\'t have the permissions, to remove the domain of users',
    'errortodomainforbidden12' => 'Error: You don\'t have the permissions, to assign users to domain %s',
    'errortypesetforbidden12' => 'Error: You don\'t have the permissions, to assign admin rights to users',
    'errordeletenodomainforbidden12' => 'Error: You don\'t have the permissions, to delete users without domain',
    'errordeletedomainforbidden12' => 'Error: You don\'t have the permissions, to delete users of domain %s',
    'errorcreatenodomainforbidden12' => 'Error: You don\'t have the permissions, to add users without domain',
    'errorcreatedomainforbidden12' => 'Error: You don\'t have the permissions, to add users of domain %s',
    'retypepassword12' => 'Confirm Password:',
    'userexists12' => 'User already exists with username %s',

    // 13-sa_rules_update.php
    'input13' => 'Run Now',
    'updatesadesc13' => 'Update SpamAssassin Rule Descriptions',
    'message113' => 'This utility is used to update the SQL database with up-to-date descriptions of the SpamAssassin rules which are displayed on the Message Detail screen.',
    'message213' => 'This utility should generally be run after a SpamAssassin update, however it is safe to run at any time as it only replaces the existing values and inserts only new values in the table (therefore preserving descriptions from potentially deprecated or removed rules).',
    'saruldesupdate13' => 'SpamAssassin Rule Description Update',
    'rule13' => 'Rule',
    'description13' => 'Description',
    'auditlog13' => 'Ran SpamAssassin Rules Description Update',

    // 14-reports.php
    'messlisting14' => 'Message Listing',
    'messop14' => 'Message Operations',
    'messdate14' => 'Total Messages by Date',
    'topmailrelay14' => 'Top Mail Relays',
    'topvirus14' => 'Top Viruses',
    'virusrepor14' => 'Virus Report',
    'topsendersqt14' => 'Top Senders by Quantity',
    'topsendersvol14' => 'Top Senders by Volume',
    'toprecipqt14' => 'Top Recipients by Quantity',
    'toprecipvol14' => 'Top Recipients by Volume',
    'topsendersdomqt14' => 'Top Sender Domains by Quantity',
    'topsendersdomvol14' => 'Top Sender Domains by Volume',
    'toprecipdomqt14' => 'Top Recipient Domains by Quantity',
    'toprecipdomvol14' => 'Top Recipient Domains by Volume',
    'assassinscoredist14' => 'SpamAssassin Score Distribution',
    'assassinrulhit14' => 'SpamAssassin Rule Hits',
    'auditlog14' => 'Audit Log',
    'mrtgreport14' => 'MRTG Style Report',
    'mcpscoredist14' => 'MCP Score Distribution',
    'mcprulehit14' => 'MCP Rule Hit',
    'reports14' => 'Reports',

    // 15-geoip_update.php
    'input15' => 'Run Now',
    'updategeoip15' => 'Update GeoIP Database',
    'message115' => 'This utility is used to download the GeoIP database files (which are updated on the first Tuesday of each month) from',
    'message215' => 'which is used to work out the country of origin for any given IP address and is displayed on the Message Detail page.',
    'downfile15' => 'Downloading file, please wait...',
    'geoipv415' => 'GeoIP IPv4 data file',
    'geoipv615' => 'GeoIP IPv6 data file',
    'downok15' => 'successfully downloaded',
    'downbad15' => 'Error occurred while downloading',
    'downokunpack15' => 'Download complete, unpacking files...',
    'message315' => 'Unable to download GeoIP data file (tried CURL and fsockopen).',
    'message415' => 'Install either cURL extension (preferred) or enable fsockopen in your php.ini',
    'unpackok15' => 'successfully unpacked',
    'extractnotok15' => 'Unable to extract',
    'extractok15' => 'successfully extracted',
    'message515' => 'Unable to extract GeoIP data file.',
    'message615' => 'Enable Zlib in your PHP installation or install gunzip executable.',
    'processok15' => 'Process completed!',
    'norread15' => 'Unable to read or write to the',
    'message715' => 'Files still exist for some reason.',
    'message815' => 'Delete them manually from',
    'directory15' => 'directory',
    'geoipupdate15' => 'GeoIP Database Update',
    'dieproxy15' => 'Proxy type should be either "HTTP" or "SOCKS5", check your configuration file',
    'auditlog15' => 'Ran GeoIP update',
    'colon15' => ':',

    // 16-rep_message_listing.php
    'messlisting16' => 'Message Listing',

    // 17-rep_message_ops.php
    'messageops17' => 'Message Operations',
    'messagelisting17' => 'Message Listing',

    // 18-bayes_info.php
    'spamassassinbayesdatabaseinfo18' => 'SpamAssassin Bayes Database Info',
    'bayesdatabaseinfo18' => 'Bayes Database Information',
    'nbrspammessage18' => 'Number of Spam Messages:',
    'nbrhammessage18' => 'Number of Ham Messages:',
    'nbrtoken18' => 'Number of Tokens:',
    'oldesttoken18' => 'Oldest Token:',
    'newesttoken18' => 'Newest Token:',
    'lastjournalsync18' => 'Last Journal Sync:',
    'lastexpiry18' => 'Last Expiry:',
    'lastexpirycount18' => 'Last Expiry Reduction Count:',
    'tokens18' => 'tokens',
    'auditlog18' => 'Viewed SpamAssassin Bayes Database Info',

    // 19-clamav_status.php
    'avclamavstatus19' => 'ClamAV Status',
    'auditlog19' => 'Non-admin user attemped to view ClamAV Status page',

    // 20-docs.php
    'doc20' => 'Documentation',
    'message20' => 'This page does require authentication, so you can put links to your site documentation here and allow your users to access it if you wish.',

    // 21-do_message_ops.php
    'opresult21' => 'Operation Results',
    'spamlearnresult21' => 'Spam Learn Results',
    'diemnf21' => 'Message not found in quarantine.',
    'back21' => 'Back',
    'messageid21' => 'Message ID',
    'result21' => 'Operation',
    'message21' => 'Message',

    // 22-f-prot_status.php
    'fprotstatus22' => 'F-Prot Status',

    // 23-f-secure_status.php
    'fsecurestatus23' => 'F-Secure Status',

    // 24-mailq.php
    'mqviewer24' => 'Mail Queue Viewer',
    'diemq24' => 'No queue specified',

    // 25-mcafee_status.php
    'mcafeestatus25' => 'McAfee Status',

    // 26-mcp_rules_update.php
    'mcpruledesc26' => 'MCP Rule Description Update',
    'auditlog26' => 'Ran MCP Rules Description Update',
    'message0126' => 'This utility is used to update the SQL database with up-to-date descriptions of the MCP rules which are displayed on the Message Detail screen.',
    'message0226' => 'This utility should generally be run after an update to your MCP rules, however it is safe to run at any time as it only replaces the existing values and inserts only new values in the table (therefore preserving descriptions from potentially deprecated or removed rules).',
    'input26' => 'Run Now',
    'rule26' => 'Rule',
    'description26' => 'Description',

    // 27-msconfig.php
    'config27' => 'Configuration',
    'msconfig27' => 'MailScanner Configuration',
    'auditlog27' => 'Viewed MailScanner configuration',

    // 28-ms_lint.php
    'mailscannerlint28' => 'MailScanner Lint',
    'diepipe28' => 'Cannot open pipe',
    'message28' => 'The variable MS_EXECUTABLE_PATH is empty. Please set a value in conf.php.',
    'auditlog28' => 'Ran MailScanner lint',
    'finish28' => 'Finish - Total Time',
    'message28' => 'Message',
    'time28' => 'Time',

    // 29-msre_index.php
    'rulesetedit29' => 'Ruleset Editor',
    'auditlog29' => 'Non-admin user attempted to view MailScanner Rule Editor Page',

    // 30-msrule.php
    'rules30' => 'Rules',

    // 31-mysql_status.php
    'mysqlstatus31' => 'MySQL Status',
    'notauthorized31' => 'Not Authorized',
    'auditlog31' => 'Viewed MySQL Status',

    // 32-postfixmailq.php
    'mqviewer32' => 'Mail Queue Viewer',
    'mqcombined32' => 'Combined mail queue (Inbound and Outbound)',

    // 33-rep_audit_log.php
    'auditlog33' => 'Audit Log',
    'datetime33' => 'Date/Time',
    'user33' => 'User',
    'ipaddress33' => 'IP Address',
    'action33' => 'Action',
    'filter33' => 'Filter',
    'applyfilter33' => 'apply',
    'startdate33' => 'Start date',
    'enddate33' => 'End date',


    // 34-rep_mcp_rule_hits.php
    'mcprulehits34' => 'MCP Rule Hits',
    'rule34' => 'Rule',
    'des34' => 'Description',
    'total34' => 'Total',
    'clean34' => 'Clean',
    'mcp34' => 'MCP',

    // 35-rep_mcp_score_dist.php
    'mcpscoredist35' => 'MCP Score Distribution',
    'die35' => 'Error: Needs 2 or more rows of data to be retrieved from database',
    'scorerounded35' => 'Score (rounded)',
    'nbmessages35' => 'No. of messages',
    'score35' => 'Score',
    'count35' => 'Count',

    // 36-rep_mrtg_style.php
    'mrtgstyle36' => 'MRTG Style Mail Report',
    'die36' => 'Error: Needs 2 or more rows of data to be retrieved from database',

    // 37-rep_sa_rule_hits.php
    'sarulehits37' => 'SpamAssassin Rule Hits',
    'rule37' => 'Rule',
    'desc37' => 'Description',
    'score37' => 'Score',
    'total37' => 'Total',
    'ham37' => 'Ham',
    'spam37' => 'Spam',

    // 38-rep_sa_score_dist.php
    'sascoredist38' => 'SpamAssassin Score Distribution',
    'scorerounded38' => 'Score (rounded)',
    'nbmessage38' => 'No. of messages',
    'score38' => 'Score',
    'count38' => 'Count',
    'die38' => 'Error: Needs 2 or more rows of data to be retrieved from database',

    // 39-rep_top_mail_relays.php
    'topmailrelays39' => 'Top Mail Relays',
    'top10mailrelays39' => 'Top 10 Mail Relays',
    'hostname39' => 'Hostname',
    'ipaddresses39' => 'IP Address',
    'country39' => 'Country',
    'messages39' => 'Messages',
    'viruses39' => 'Viruses',
    'spam39' => 'Spam',
    'volume39' => 'Volume',
    'geoipfailed39' => '(GeoIP lookup failed)',
    'hostfailed39' => '(Hostname lookup failed)',

    // 40-rep_top_recipient_domains_by_quantity.php
    'toprecipdomqt40' => 'Top Recipients Domains by Quantity',
    'top10recipdomqt40' => 'Top 10 Recipients Domains by Volume',
    'domain40' => 'Domain',

    // 41-rep_top_recipient_domains_by_volume.php
    'toprecipdomvol41' => 'Top Recipients Domains by Volume',
    'top10recipdomvol41' => 'Top 10 Recipient Domains by Volume',
    'domain41' => 'Domain',

    // 42-rep_top_recipients_by_quantity.php
    'toprecipqt42' => 'Top Recipients by Quantity',
    'top10recipqt42' => 'Top 10 Recipients by Quantity',
    'email42' => 'E-mail Address',

    // 43-rep_top_recipients_by_volume.php
    'toprecipvol43' => 'Top Recipients by Volume',
    'top10recipvol43' => 'Top 10 Recipients by Volume',
    'email43' => 'E-mail Address',

    // 44-rep_top_sender_domains_by_quantity.php
    'topsenderdomqt44' => 'Top Sender Domains by Quantity',
    'top10senderdomqt44' => 'Top 10 Sender Domains by Quantity',
    'domain44' => 'Domain',
    'count44' => 'Count',
    'size44' => 'Size',

    // 45-rep_top_sender_domains_by_volume.php
    'topsenderdomvol45' => 'Top Sender Domains by Volume',
    'top10senderdomvol45' => 'Top 10 Sender Domains by Volume',
    'domain45' => 'Domain',

    // 46-rep_top_senders_by_quantity.php
    'topsendersqt46' => 'Top Senders by Quantity',
    'top10sendersqt46' => 'Top 10 Senders by Quantity',
    'email46' => 'E-mail Address',

    // 47-rep_top_senders_by_volume.php
    'topsendersvol47' => 'Top Senders by Volume',
    'top10sendersvol47' => 'Top 10 Senders by Volume',
    'email47' => 'E-mail Address',
    
    // 48-rep_top_viruses.php
    'topvirus48' => 'Top Viruses',
    'top10virus48' => 'Top 10 Viruses',
    'nodata48' => 'Not enough data to generate a graph.',
    'virus48' => 'Virus',
    'count48' => 'Count',

    // 49-rep_total_mail_by_date.php
    'totalmaildate49' => 'Total Mail by Date',
    'totalmailprocdate49' => 'Total Mail Processed by Date',
    'volume49' => 'Volume',
    'nomessages49' => 'No. of messages',
    'date49' => 'Date',
    'barmail49' => 'Mail',
    'barvirus49' => 'Viruses',
    'barspam49' => 'Spam',
    'barmcp49' => 'MCP',
    'barvolume49' => 'Volume',
    'total49' => 'Total<br>Mail',
    'clean49' => 'Clean',
    'lowespam49' => 'Low Spam',
    'highspam49' => 'High Spam',
    'blocked49' => 'Blocked',
    'virus49' => 'Virus',
    'mcp49' => 'MCP',
    'unknoweusers49' => 'Unknown<br>Users',
    'resolve49' => 'Can\'t<br>Resolve',
    'rbl49' => 'RBL',
    'totals49' => 'Totals',

    // 50-rep_viruses.php
    'virusreport50' => 'Virus Report',
    'virus50' => 'Virus',
    'scanner50' => 'Scanner',
    'firstseen50' => 'First Seen',
    'count50' => 'Count',

    // 51-sa_lint.php
    'salint51' => 'SpamAssassin Lint',
    'diepipe51' => 'Cannot open pipe',
    'finish51' => 'Finish - Total Time',
    'auditlog51' => 'Ran SpamAssassin lint',
    'message51' => 'Message',
    'time51' => 'Time',

    // 52-sf_version.php
    'mwandmsversion52' => 'MailWatch and MailScanner Version information',
    'auditlog52' => 'Non-admin user attemped to view Software Version Page',
    'downloaddate52' => 'download date',

    // 53-sophos_status.php
    'sophos53' => 'Sophos',

    // 54-mailscanner_relay.php
    'diepipe54' => 'Cannot open pipe',

    // 55-msre_edit.php
    'diefnf55' => 'File not found:',
    'auditlog55' => 'Non-admin user attempted to view MailScanner Rule Editor Page',

    // 56-mtalogprocessor.inc.php
    'diepipe56' => 'Cannot open pipe',

    // 57-quarantine_action.php
    'dienoid57' => 'Error: No Message ID',
    'dienoaction57' => 'Error: No action',
    'diemnf57' => 'Error: Message not found in quarantine',
    'dieuaction57' => 'Unknown action:',
    'closewindow57' => 'Close Window',
    'mailwatchtitle57' => 'MailWatch for Mailscanner',
    'result57' => 'Result',
    'delete57' => 'Delete: Are you sure?',
    'yes57' => 'Yes',
    'no57' => 'No',

    // 58-viewpart.php
    'nomessid58' => 'No input Message ID',
    'mess58' => 'Message',
    'notfound58' => 'not found',
    'error58' => 'Error:',
    'errornfd58' => 'Error: file not found',
    'part58' => 'Part',

    // 59-auto-release.php
    'msgnotfound159' => 'Message not found.  You may have already released this message or the link may have expired.',
    'msgnotfound259' => 'Please contact your Mail Administrator and provide him with this message ID: ',
    'msgnotfound393' => 'if you need this message released',
    'msgreleased59' => 'Message released<br>It may take a few minutes to appear in your Inbox.',
    'tokenmismatch59' => 'Error releasing message - token mismatch',
    'notallowed59' => 'You are not allowed to be here!',
    'dberror59' => 'Something went wrong - please contact support',
    'arview059' => 'View',
    'arrelease59' => 'Release',

    // 60-rpcserver.php
    'paratype160' => 'Parameter type',
    'paratype260' => 'mismatch expected type.',
    'notfile60' => 'is not a file.',
    'permdenied60' => 'permission denied.',
    'client160' => 'Client',
    'client260' => 'is not authorized to connect.',
    'colon60' => ':',

    // 61-quarantine_report.php
    'view61' => 'View',
    'received61' => 'Received',
    'to61' => 'To',
    'from61' => 'From',
    'subject61' => 'Subject',
    'reason61' => 'Reason',
    'action61' => 'Action',
    'title61' => 'Message Quarantine Report',
    'message61' => 'The variable %s is empty, please set a value in conf.php.',
    'text611' => 'Quarantine Report for %s',
    'text612' => 'In the last %s day(s) you have received %s e-mails that have been quarantined and are listed below. All messages in the quarantine are automatically deleted %s days after the date that they were received.',
    'release61' => 'Release',
    'virus61' => 'Virus',
    'badcontent61' => 'Bad Content',
    'infected61' => 'Infected',
    'spam61' => 'Spam',
    'blacklisted61' => 'Blacklisted',
    'policy61' => 'Policy',
    'unknow61' => 'UNKNOWN',

    // 62-quarantine_maint.php
    'message62' => 'The variable %s is empty, please set a value in conf.php.',
    'error62' => 'Error:',

    // 99 - General
    // Space rule for colon. Change it according to your langage typographical rule.
    'colon99' => ':',
    'diemysql99' => 'Error: No rows retrieved from database.',
    'message199' => 'File isn\'t readable. Please make sure that',
    'message299' => 'is readable and writable by MailWatch',
    'mwlogo99' => 'MailWatch Logo',
    'mslogo99' => 'MailScanner Logo',
    'i18_missing' => 'No translation in English',
    'cannot_read_conf' => 'Cannot read conf.php - please create it by copying conf.php.example and modifying the parameters to suit.',
    'missing_conf_entries' => 'The following conf.php entries are missing, check compare your conf.php with conf.php.example',
);
