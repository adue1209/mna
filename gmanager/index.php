<?php
/**
 * 
 * This software is distributed under the GNU GPL v3.0 license.
 * @author Gemorroj
 * @copyright 2008-2011 http://wapinet.ru
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @link http://wapinet.ru/gmanager/
 * @version 0.8 beta
 * 
 * PHP version >= 5.2.1
 * 
 */


define('GMANAGER_START', microtime(true));

require 'lib/Config.php';


if (Registry::get('current') == '.') {
    Registry::set('current', Registry::getGmanager()->getcwd() . '/');
    Registry::set('hCurrent', htmlspecialchars(Registry::getGmanager()->getcwd(), ENT_COMPAT) . '/');
    Registry::set('rCurrent', str_replace('%2F', '/', rawurlencode(Registry::getGmanager()->getcwd())));
}


if (Registry::get('currentType') == 'dir') {
    $archive = false;
} else {
    $archive = Registry::getGmanager()->isArchive(Registry::getGmanager()->getType(basename(Registry::get('current'))));
}

$f = 0;
$if = isset($_GET['f']);
$ia = isset($_GET['add_archive']);

Registry::getGmanager()->sendHeader();

echo str_replace('%title%', Registry::get('hCurrent'), Registry::get('top')) . '<div class="w2">' . Language::get('title_index') . '<br/></div>' . Registry::getGmanager()->head() . Registry::getGmanager()->langJS();


if (Config::get('Gmanager', 'addressBar')) {
    echo '<div class="edit"><form action="index.php?" method="get"><div class="bar">';
    if ($ia) {
        echo '<input type="hidden" name="add_archive" value="' . htmlspecialchars($_GET['add_archive']) . '"/><input type="hidden" name="go" value="1"/>';
    }
    echo '<input type="text" name="c" value="' . Registry::get('hCurrent') . '"/> <input type="submit" value="' . Language::get('go') . '"/></div></form></div>';
}

if ($idown = isset($_GET['down'])) {
    $down = '&amp;up';
    $mnem = '&#171;';
} else {
    $down = '&amp;down';
    $mnem = '&#187;';
}

if (!$if) {
    if (!$archive) {

        $itype = '';

        if (isset($_GET['time'])) {
            $itype = 'time';
            echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th><a href="?c=' . Registry::get('rCurrent') . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;type">' . Language::get('type') . '</a></th>' : '') . (Config::get('Display', 'size') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;size">' . Language::get('size') . '</a></th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;chmod">' . Language::get('chmod') . '</a></th>' : '') . (Config::get('Display', 'date') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . '&amp;time' . $down . '">' . Language::get('date') . '</a></th>' : '') . (Config::get('Display', 'uid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;uid">' . Language::get('uid') . '</a></th>' : '') . (Config::get('Display', 'gid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;gid">' . Language::get('gid') . '</a></th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
        } else if (isset($_GET['type'])) {
            $itype = 'type';
            echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th><a href="?c=' . Registry::get('rCurrent') . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . '&amp;type' . $down . '">' . Language::get('type') . '</a></th>' : '') . (Config::get('Display', 'size') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;size">' . Language::get('size') . '</a></th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;chmod">' . Language::get('chmod') . '</a></th>' : '') . (Config::get('Display', 'date') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;time">' . Language::get('date') . '</a></th>' : '') . (Config::get('Display', 'uid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;uid">' . Language::get('uid') . '</a></th>' : '') . (Config::get('Display', 'gid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;gid">' . Language::get('gid') . '</a></th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
        } else if (isset($_GET['size'])) {
            $itype = 'size';
            echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th><a href="?c=' . Registry::get('rCurrent') . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;type">' . Language::get('type') . '</a></th>' : '') . (Config::get('Display', 'size') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . '&amp;size' . $down . '">' . Language::get('size') . '</a></th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;chmod">' . Language::get('chmod') . '</a></th>' : '') . (Config::get('Display', 'date') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;time">' . Language::get('date') . '</a></th>' : '') . (Config::get('Display', 'uid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;uid">' . Language::get('uid') . '</a></th>' : '') . (Config::get('Display', 'gid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;gid">' . Language::get('gid') . '</a></th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
        } else if (isset($_GET['chmod'])) {
            $itype = 'chmod';
            echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th><a href="?c=' . Registry::get('rCurrent') . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;type">' . Language::get('type') . '</a></th>' : '') . (Config::get('Display', 'size') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;size">' . Language::get('size') . '</a></th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . '&amp;chmod' . $down . '">' . Language::get('chmod') . '</a></th>' : '') . (Config::get('Display', 'date') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;time">' . Language::get('date') . '</a></th>' : '') . (Config::get('Display', 'uid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;uid">' . Language::get('uid') . '</a></th>' : '') . (Config::get('Display', 'gid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;gid">' . Language::get('gid') . '</a></th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
        } else if (isset($_GET['uid'])) {
            $itype = 'uid';
            echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th><a href="?c=' . Registry::get('rCurrent') . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;type">' . Language::get('type') . '</a></th>' : '') . (Config::get('Display', 'size') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;size">' . Language::get('size') . '</a></th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;chmod">' . Language::get('chmod') . '</a></th>' : '') . (Config::get('Display', 'date') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;time">' . Language::get('date') . '</a></th>' : '') . (Config::get('Display', 'uid') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . '&amp;uid' . $down . '">' . Language::get('uid') . '</a></th>' : '') . (Config::get('Display', 'gid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;gid">' . Language::get('gid') . '</a></th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
        } else if (isset($_GET['gid'])) {
            $itype = 'gid';
            echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th><a href="?c=' . Registry::get('rCurrent') . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;type">' . Language::get('type') . '</a></th>' : '') . (Config::get('Display', 'size') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;size">' . Language::get('size') . '</a></th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;chmod">' . Language::get('chmod') . '</a></th>' : '') . (Config::get('Display', 'date') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;time">' . Language::get('date') . '</a></th>' : '') . (Config::get('Display', 'uid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;uid">' . Language::get('uid') . '</a></th>' : '') . (Config::get('Display', 'gid') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . '&amp;gid' . $down . '">' . Language::get('gid') . '</a></th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
        } else {
            $itype = '';
            echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . $down . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;type">' . Language::get('type') . '</a></th>' : '') . (Config::get('Display', 'size') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;size">' . Language::get('size') . '</a></th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;chmod">' . Language::get('chmod') . '</a></th>' : '') . (Config::get('Display', 'date') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;time">' . Language::get('date') . '</a></th>' : '') . (Config::get('Display', 'uid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;uid">' . Language::get('uid') . '</a></th>' : '') . (Config::get('Display', 'gid') ? '<th><a href="?c=' . Registry::get('rCurrent') . '&amp;gid">' . Language::get('gid') . '</a></th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
        }
    } else if ($archive != 'GZ') {
        echo '<form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div class="telo"><table><tr><th><input type="checkbox" onclick="Gmanager.check(this.form,\'check[]\',this.checked)"/></th>' . (Config::get('Display', 'name') ? '<th>' . $mnem . ' <a href="?c=' . Registry::get('rCurrent') . $down . '">' . Language::get('name') . '</a></th>' : '') . (Config::get('Display', 'down') ? '<th>' . Language::get('get') . '</th>' : '') . (Config::get('Display', 'type') ? '<th>' . Language::get('type') . '</th>' : '') . (Config::get('Display', 'size') ? '<th>' . Language::get('size') . '</th>' : '') . (Config::get('Display', 'change') ? '<th>' . Language::get('change') . '</th>' : '') . (Config::get('Display', 'del') ? '<th>' . Language::get('del') . '</th>' : '') . (Config::get('Display', 'chmod') ? '<th>' . Language::get('chmod') . '</th>' : '') . (Config::get('Display', 'date') ? '<th>' . Language::get('date') . '</th>' : '') . (Config::get('Display', 'uid') ? '<th>' . Language::get('uid') . '</th>' : '') . (Config::get('Display', 'gid') ? '<th>' . Language::get('gid') . '</th>' : '') . (Config::get('Display', 'n') ? '<th>' . Language::get('n') . '</th>' : '') . '</tr>';
    }
}

if ($archive == 'ZIP') {
    Registry::set('archiveDriver', 'zip');
    if ($if) {
        echo Archive::main()->lookFile(Registry::get('current'), $_GET['f']);
    } else {
        echo Archive::main()->listArchive(Registry::get('current'), $idown);
        $f = 1;
    }
} else if ($archive == 'TAR') {
    Registry::set('archiveDriver', 'tar');
    if ($if) {
        echo Archive::main()->lookFile(Registry::get('current'), $_GET['f']);
    } else {
        echo Archive::main()->listArchive(Registry::get('current'), $idown);
        $f = 1;
    }
} else if ($archive == 'BZ2' && extension_loaded('bz2')) {
    Registry::set('archiveDriver', 'tar');
    if ($if) {
        echo Archive::main()->lookFile(Registry::get('current'), $_GET['f']);
    } else {
        echo Archive::main()->listArchive(Registry::get('current'), $idown);
        $f = 1;
    }
} else if ($archive == 'RAR' && extension_loaded('rar')) {
    Registry::set('archiveDriver', 'rar');
    if ($if) {
        echo Archive::main()->lookFile(Registry::get('current'), $_GET['f']);
    } else {
        echo Archive::main()->listArchive(Registry::get('current'), $idown);
        $f = 1;
    }
} else if ($archive == 'GZ') {
    echo Registry::getGmanager()->gz(Registry::get('current')) . '<div class="ch"><form action="change.php?c=' . Registry::get('rCurrent') . '&amp;go=1" method="post"><div><input type="submit" name="gz_extract" value="' . Language::get('extract_archive') . '"/></div></form></div>';
    $if = true;
} else {
    echo Registry::getGmanager()->look(Registry::get('current'), $itype, $idown);
}

if (Registry::getGmanager()->file_exists(Registry::get('current')) || Registry::get('currentType') == 'link') {
    if ($archive) {
        $d = str_replace('%2F', '/', rawurlencode(dirname(Registry::get('current'))));
        $found = '<div class="rb">' . Language::get('create') . ' <a href="change.php?go=create_file&amp;c=' . $d . '">' . Language::get('file') . '</a> / <a href="change.php?go=create_dir&amp;c=' . $d . '">' . Language::get('dir') . '</a><br/></div><div class="rb"><a href="change.php?go=upload&amp;c=' . $d . '">' . Language::get('upload') . '</a><br/></div><div class="rb"><a href="change.php?go=mod&amp;c=' . $d . '">' . Language::get('mod') . '</a><br/></div>';
    } else {
        $found = '<form action="' . $_SERVER['PHP_SELF'] . '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_COMPAT, 'UTF-8') . '" method="post"><div><input name="limit" value="' . Registry::get('limit') . '" type="text" onkeypress="return Gmanager.number(event)" class="pinput"/><input type="submit" value="' . Language::get('limit') . '"/></div></form><div class="rb">' . Language::get('create') . ' <a href="change.php?go=create_file&amp;c=' . Registry::get('rCurrent') . '">' . Language::get('file') . '</a> / <a href="change.php?go=create_dir&amp;c=' . Registry::get('rCurrent') . '">' . Language::get('dir') . '</a><br/></div><div class="rb"><a href="change.php?go=upload&amp;c=' . Registry::get('rCurrent') . '">' . Language::get('upload') . '</a><br/></div><div class="rb"><a href="change.php?go=mod&amp;c=' . Registry::get('rCurrent') . '">' . Language::get('mod') . '</a><br/></div>';
    }
} else {
    $found = '<div class="red">' . Language::get('not_found') . '(' . Registry::get('hCurrent') . ')' . '<br/></div>';
}


$tm = '<div class="rb">' . round(microtime(true) - GMANAGER_START, 4) . ' / ' . Registry::getGmanager()->formatSize(memory_get_peak_usage()) . '<br/></div>';

if (!$if && !$f && !$ia) {
    echo '</table><div class="ch"><input onclick="return Gmanager.checkForm(document.forms[1],\'check[]\');" type="submit" name="full_chmod" value="' . Language::get('chmod') . '"/> <input onclick="return (Gmanager.checkForm(document.forms[1],\'check[]\') &amp;&amp; Gmanager.delNotify());" type="submit" name="full_del" value="' . Language::get('del') . '"/> <input onclick="return Gmanager.checkForm(document.forms[1],\'check[]\');" type="submit" name="full_rename" value="' . Language::get('change') . '"/> <input onclick="return Gmanager.checkForm(document.forms[1],\'check[]\');" type="submit" name="fname" value="' . Language::get('rename') . '"/> <input onclick="return Gmanager.checkForm(document.forms[1],\'check[]\');" type="submit" name="create_archive" value="' . Language::get('create_archive') . '"/></div></div></form>' . $found . $tm . Registry::get('foot');
} else if ($f) {
    echo '</table><div class="ch"><input onclick="return Gmanager.checkForm(document.forms[1],\'check[]\');" type="submit" name="full_extract" value="' . Language::get('extract_file') . '"/> <input type="submit" name="mega_full_extract" value="' . Language::get('extract_archive') . '"/>';
    if ($archive != 'RAR') {
        echo ' <input type="submit" name="add_archive" value="' . Language::get('add_archive') . '"/> <input onclick="return (Gmanager.checkForm(document.forms[1],\'check[]\') &amp;&amp; Gmanager.delNotify());" type="submit" name="del_archive" value="' . Language::get('del') . '"/>';
    }
    echo '</div></div></form>' . $found . $tm . Registry::get('foot');
} else if ($ia) {
    echo '</table><div class="ch"><input type="hidden" name="add_archive" value="' . rawurlencode($_GET['add_archive']) . '"/><input onclick="return Gmanager.checkForm(document.forms[1],\'check[]\');" type="submit" name="name" value="' . Language::get('add_archive') . '"/></div></div></form>' . $found . $tm . Registry::get('foot');
} else {
    echo $found . $tm . Registry::get('foot');
}

?>
