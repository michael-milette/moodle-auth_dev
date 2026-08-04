<?php
// This file is part of Exit Log In As - https://moodle.org/
//
// Exit Log In As is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Exit Log In As is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Exit Log In As - Uses to developers and main admins.
 *
 * @package   auth_dev
 * @copyright 2026 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @author    Michael Milette
 * @copyright 2017-2026 Carlos Escobedo <http://www.twitter.com/carlosagile>)
 * @author    Carlos Escobedo <http://www.twitter.com/carlosagile>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');

/**
 * Exit Log In As plugin.
 *
 * @package   auth_dev
 * @copyright 2026 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @author    Michael Milette
 * @copyright 2017-2026 Carlos Escobedo <http://www.twitter.com/carlosagile>)
 * @author    Carlos Escobedo <http://www.twitter.com/carlosagile>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class auth_plugin_dev extends auth_plugin_base {
    /**
    * The name of the component. Used by the configuration.
    */
    const COMPONENT_NAME = 'auth_dev';

    /**
     * Constructor.
     */
    public function __construct() {
        $this->authtype = 'dev';
        $this->config = get_config(self::COMPONENT_NAME);
    }

    /**
     * Hook for overriding behaviour of pre logout page.
     */
    public function prelogout_hook() {
        global $CFG, $SESSION;

        if (\core\session\manager::is_loggedinas()) {
            $id = optional_param('id', 0, PARAM_INT);
            // IF ID==0 then logout request, notthing to do.
            if ($id) {
                $realuser = \core\session\manager::get_realuser();
                // Check is siteadmin.
                // Only siteadmins can use this tool.
                if (is_siteadmin($realuser)) {
                    complete_user_login($realuser);
                    $SESSION->wantsurl = "$CFG->wwwroot/course/view.php?id=".$id;
                    redirect($SESSION->wantsurl);
                }
            }
        }
    }

    /**
     * Hook for overriding behaviour of logout page.
     * This method is called from login/logout.php page for all enabled auth plugins.
     */
    public function logoutpage_hook() {
        global $redirect; // Can be used to override redirect after logout.

        if (!empty($this->config->enablelogouturl)) {
            if (!empty($this->config->logouturl)) {
                $redirect = $this->config->logouturl;
            }
        }
    }

    /**
     * Returns false to avoid a wrong username error.
     *
     * @param string $username The username (without system magic quotes)
     * @param string $password The password (without system magic quotes)
     *
     * @return bool Authentication success or failure.
     */
    function user_login($username, $password) {
        return false;
    }
}
