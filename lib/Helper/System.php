<?php
/**
 *
 * This software is distributed under the GNU GPL v3.0 license.
 * @author Gemorroj
 * @copyright 2008-2012 http://wapinet.ru
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @link http://wapinet.ru/gmanager/
 * @version 0.8.1 beta
 *
 * PHP version >= 5.2.3
 *
 */


class Helper_System
{
    /**
     * Multibyte basename
     *
     * @param string    $path
     * @param string    $suffix
     * @return string
     */
    public static function basename ($path, $suffix = '')
    {
        $file = explode('/', $path);
        return rtrim(end($file), $suffix);
    }


    /**
     * id2user
     *
     * @param int    $id
     * @return string
     */
    public static function id2user ($id = 0)
    {
        if (Registry::get('sysType') === 'WIN') {
            return '';
        } else {
            if (function_exists('posix_getpwuid') && $name = posix_getpwuid($id)) {
                return $name['name'];
            }

            exec('id -n -u ' . escapeshellarg($id), $outId, $resultId);
            if ($resultId === 0) {
                return trim($outId[0]);
            }

            exec('getent passwd ' . escapeshellarg($id), $outGetent, $resultGetent);
            if ($resultGetent === 0) {
                $tmp = explode(':', $outGetent[0], 2);
                return trim($tmp[0]);
            }

            exec(escapeshellcmd(Config::get('Perl', 'path')) . ' -e \'($login, $pass, $uid, $gid) = getpwuid(' . escapeshellarg($id) . ');print $login;\'', $outPerl, $resultPerl);
            if ($resultPerl === 0) {
                return trim($outPerl);
            }
        }

        return $id;
    }


    /**
     * id2group
     *
     * @param int    $id
     * @return string
     */
    public static function id2group ($id = 0)
    {
        if (Registry::get('sysType') === 'WIN') {
            return '';
        } else {
            if (function_exists('posix_getgrgid') && $name = posix_getgrgid($id)) {
                return $name['name'];
            }
/*
            exec('id -n -u ' . escapeshellarg($id), $outId, $resultId);
            if ($resultId === 0) {
                return trim($outId[0]);
            }
*/
            exec('getent group ' . escapeshellarg($id), $outGetent, $resultGetent);
            if ($resultGetent === 0) {
                $tmp = explode(':', $outGetent[0], 2);
                return trim($tmp[0]);
            }

            exec(escapeshellcmd(Config::get('Perl', 'path')) . ' -e \'print getgrgid(' . escapeshellarg($id) . ');\'', $outPerl, $resultPerl);
            if ($resultPerl === 0) {
                $tmp = explode('*', $outPerl[0], 2);
                return trim($tmp[0]);
            }
        }

        return $id;
    }


    /**
     * getType
     *
     * @param string $f
     * @return string
     */
    public static function getType ($f)
    {
        $type = array_reverse(explode('.', mb_strtoupper($f)));
        if (isset($type[1]) && $type[1] === 'TAR') {
            return $type[1] . '.' . $type[0];
        }

        return $type[0];
    }


    /**
     * clean
     *
     * @param string $dir
     */
    public static function clean ($dir = '')
    {
        $h = @opendir($dir);
        if (!$h) {
            return;
        }

        while (($f = readdir($h)) !== false) {
            if ($f == '.' || $f == '..') {
                continue;
            }

            if (is_dir($dir . '/' . $f)) {
                self::clean($dir . '/' . $f);
            } else {
                unlink($dir . '/' . $f);
            }
        }
        closedir($h);
        rmdir($dir);
    }
}
