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
 * Registration Class
 *
 * This class handles all the doodlys for the registration
 * stuff in Ampache
 */
class Registration
{
    /**
     * constructor
     * This is what is called when the class is loaded
     */
    public function __construct()
    {
        // Rien a faire

    } // constructor

    /**
      * send_confirmation
     * This sends the confirmation e-mail for the specified user
     */
    public static function send_confirmation($username, $fullname, $email, $password, $validation)
    {
        $mailer = new Mailer();

        // We are the system
        $mailer->set_default_sender();

        $mailer->subject = sprintf(T_("New User Registration at %s"), Config::get('site_title'));

        $mailer->message = sprintf(T_("Thank you for registering\n\n
Please keep this e-mail for your records. Your account information is as follows:
----------------------
Username: %s
Password: %s
----------------------

Your account is currently inactive. You cannot use it until you've visited the following link:

%s

Thank you for registering
"), $username, $password, Config::get('web_path') . "/register.php?action=validate&username=$username&auth=$validation");

        $mailer->recipient = $email;
        $mailer->recipient_name = $fullname;

        $mailer->send();

        // Check to see if the admin should be notified
        if (Config::get('admin_notify_reg')) {
            $mailer->message = sprintf(T_("A new user has registered
The following values were entered.

Username: %s
Fullname: %s
E-mail: %s

"), $username, $fullname, $email);

            $mailer->send_to_group('admins');
        }

        return true;

    } // send_confirmation

    /**
      * show_agreement
     * This shows the registration agreement, /config/registration_agreement.php
     */
    public static function show_agreement()
    {
        $filename = Config::get('prefix') . '/config/registration_agreement.php';

        if (!file_exists($filename)) { return false; }

        /* Check for existance */
        $fp = fopen($filename,'r');

        if (!$fp) { return false; }

        $data = fread($fp,filesize($filename));

        /* Scrub and show */
        echo $data;

    } // show_agreement

} // end registration class
