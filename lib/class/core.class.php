<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2013 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

/**
 * Core Class
 *
 * This is really just a namespace class, it's full of static functions
 * would be replaced by a namespace library once that exists in php
 *
 */
class Core
{
    /**
     * constructor
     * This doesn't do anything
     */
    private function __construct()
    {
        return false;

    } // construction

    /**
     * autoload
     *
     * This function automatically loads any missing classes as they are
     * needed so that we don't use a million include statements which load
     * more than we need.
     */
    public static function autoload($class)
    {
        // Ignore class with namespace, not used by Ampache
        if (strpos($class, '\\') === false) {
            $file = Config::get('prefix') . '/lib/class/' .
                strtolower($class) . '.class.php';

            if (Core::is_readable($file)) {
                require_once $file;

                // Call _auto_init if it exists
                $autocall = array($class, '_auto_init');
                if (is_callable($autocall)) {
                    call_user_func($autocall);
                }
            } else {
                debug_event('autoload', "'$class' not found!", 1);
            }
        }
    }

    /**
     * form_register
     * This registers a form with a SID, inserts it into the session
     * variables and then returns a string for use in the HTML form
     */
    public static function form_register($name, $type = 'post')
    {
        // Make ourselves a nice little sid
        $sid =  md5(uniqid(rand(), true));
        $window = Config::get('session_length');
        $expire = time() + $window;

        // Register it
        $_SESSION['forms'][$sid] = array('name' => $name, 'expire' => $expire);
        debug_event('Core', "Registered $type form $name with SID $sid and expiration $expire ($window seconds from now)", 5);

        switch ($type) {
            default:
            case 'post':
                $string = '<input type="hidden" name="form_validation" value="' . $sid . '" />';
            break;
            case 'get':
                $string = $sid;
            break;
        } // end switch on type

        return $string;

    } // form_register

    /**
     * form_verify
     *
     * This takes a form name and then compares it with the posted sid, if
     * they don't match then it returns false and doesn't let the person
     * continue
     */
    public static function form_verify($name, $type = 'post')
    {
        switch ($type) {
            case 'post':
                $sid = $_POST['form_validation'];
            break;
            case 'get':
                $sid = $_GET['form_validation'];
            break;
            case 'cookie':
                $sid = $_COOKIE['form_validation'];
            break;
            case 'request':
                $sid = $_REQUEST['form_validation'];
            break;
        }

        if (!isset($_SESSION['forms'][$sid])) {
            debug_event('Core', "Form $sid not found in session, rejecting request", 2);
            return false;
        }

        $form = $_SESSION['forms'][$sid];
        unset($_SESSION['forms'][$sid]);

        if ($form['name'] == $name) {
            debug_event('Core', "Verified SID $sid for $type form $name", 5);
            if ($form['expire'] < time()) {
                debug_event('Core', "Form $sid is expired, rejecting request", 2);
                return false;
            }

            return true;
        }

        // OMG HAX0RZ
        debug_event('Core', "$type form $sid failed consistency check, rejecting request", 2);
        return false;

    } // form_verify

    /**
     * image_dimensions
    * This returns the dimensions of the passed song of the passed type
    * returns an empty array if PHP-GD is not currently installed, returns
    * false on error
    */
    public static function image_dimensions($image_data)
    {
        if (!function_exists('ImageCreateFromString')) { return false; }

        $image = ImageCreateFromString($image_data);

        if (!$image) { return false; }

        $width = imagesx($image);
        $height = imagesy($image);

        if (!$width || !$height) { return false; }

        return array('width'=>$width,'height'=>$height);

    } // image_dimensions

    /*
     * is_readable
     *
     * Replacement function because PHP's is_readable is buggy:
     * https://bugs.php.net/bug.php?id=49620
     */
    public static function is_readable($path)
    {
        if (is_dir($path)) {
            $handle = opendir($path);
            if ($handle === false) {
                return false;
            }
            closedir($handle);
            return true;
        }

        $handle = fopen($path, 'rb');
        if ($handle === false) {
            return false;
        }
        fclose($handle);
        return true;
    }

} // Core
