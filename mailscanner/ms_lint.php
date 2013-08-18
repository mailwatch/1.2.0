<?php

/*
 MailWatch for MailScanner
 Copyright (C) 2003-2011  Steve Freegard (steve@freegard.name)
 Copyright (C) 2011  Garrod Alwood (garrod.alwood@lorodoes.com)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once("./functions.php");

session_start();
require('login.function.php');

html_start("MailScanner Lint",0,false,false);


if(!$fp = popen('sudo /usr/sbin/MailScanner --lint 2>&1','r')) {
 die("Cannot open pipe");
} else {
 audit_log('Run MailScanner lint');
}

echo '<table class="mail" cellspacing="1" width="100%">'."\n";
echo ' <tr>'."\n";
echo '  <th colspan="2">MailScanner Lint</th>'."\n";
echo ' </tr>'."\n";

// Start timer
$start = get_microtime();
$last = false;
while($line = fgets($fp,2096)) {

 $line = preg_replace("/\n/i","",$line);
 if($line !== "" && $line !== " ") {
  $timer = get_microtime();
  $linet = $timer-$start;
  if(!$last) { $last = $linet; }

  echo '<!-- Timer: '.$timer.', Line Start: '.$linet.' -->'."\n";

  echo '    <tr>'."\n";

  echo '     <td>'.$line.'</td>'."\n";
  $thisone = $linet-$last;
  $last = $linet;
  if($thisone>=2) {
   echo  '     <td class="lint_5">'.round($thisone,5).'</td>'."\n";
  } elseif($thisone>=1.5) {
    echo '     <td class="lint_4">'.round($thisone,5).'</td>'."\n";
  } elseif($thisone>=1) {
    echo '     <td class="lint_3">'.round($thisone,5).'</td>'."\n";
  } elseif($thisone>=0.5) {
    echo '     <td class="lint_2">'.round($thisone,5).'</td>'."\n";
  } elseif($thisone<0.5) {
    echo '     <td class="lint_1">'.round($thisone,5).'</td>'."\n";
  }
  echo '    </tr>'."\n";
 }
}
pclose($fp);
echo '   <tr>'."\n";
echo '    <td><b>Finish - Total Time</b></td>'."\n";
echo '    <td align="right"><b>'.round(get_microtime()-$start,5).'</b></td>'."\n";
echo '   </tr>'."\n";
echo '</table>'."\n";

// Add the footer
html_end();
// close the connection to the Database
dbclose();
?>

