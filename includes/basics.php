<?php
/**
 * This file is part of
 * Kimai - Open Source Time Tracking // http://www.kimai.org
 * (c) 2006-2009 Kimai-Development-Team
 *
 * Kimai is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; Version 3, 29 June 2007
 *
 * Kimai is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kimai; If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Basic initialization takes place here.
 * From loading the configuration to connecting to the database this all is done
 * here.
 * 
 * What does NOT happen here is including the database dependant functions.
 */
error_reporting(E_ERROR);

if (!defined('WEBROOT'))
    define('WEBROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require(WEBROOT.'includes/5.3.functions.php');

if (!file_exists(WEBROOT.'includes/autoconf.php')) {
  if (preg_match('|core/[^?]*\.php|',$_SERVER['PHP_SELF'])>0)
    header('location:../error.php');
  else
    header('location:error.php');
}
require(WEBROOT.'includes/autoconf.php');
if (!isset($server_hostname)) {
  header('location:installer/index.php');
  exit;
}

require(WEBROOT.'includes/vars.php');

require(WEBROOT.'includes/func.php');
require(WEBROOT."includes/connect_".$kga['server_conn'].".php");

$vars = var_get_data();
if (!empty($vars)) {
  $kga['currency_name']          = $vars['currency_name'];
  $kga['currency_sign']          = $vars['currency_sign'];
  $kga['show_sensible_data']     = $vars['show_sensible_data'];
  $kga['show_update_warn']       = $vars['show_update_warn'];
  $kga['check_at_startup']       = $vars['check_at_startup'];
  $kga['show_daySeperatorLines'] = $vars['show_daySeperatorLines'];
  $kga['show_gabBreaks']         = $vars['show_gabBreaks'];
  $kga['show_RecordAgain']       = $vars['show_RecordAgain'];
  $kga['show_TrackingNr']        = $vars['show_TrackingNr'];
  $kga['date_format'][0]         = $vars['date_format_0'];
  $kga['date_format'][1]         = $vars['date_format_1'];
  $kga['date_format'][2]         = $vars['date_format_2'];
  if ($vars['language'] != '')
    $kga['language']             = $vars['language'];
  else if ($kga['language'] == '')
    $kga['language'] = 'en';

  if ($vars['defaultTimezone'])
    date_default_timezone_set($vars['defaultTimezone']);
}

// load language file
$kga['lang'] = require(WEBROOT.'language/en.php');

if ($kga['language'] != 'en') 
 $kga['lang'] =  array_replace_recursive($kga['lang'],include(WEBROOT."language/${kga['language']}.php"));
?>