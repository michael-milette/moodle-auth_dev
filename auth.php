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

        if (!\core\session\manager::is_loggedinas()) {
            return;
        }

        // If id == 0, this is an ordinary logout request. Nothing to do.
        $id = optional_param('id', 0, PARAM_INT);
        if (!$id) {
            return;
        }

        // Only return to a course that actually exists.
        $coursecontext = \context_course::instance($id, IGNORE_MISSING);
        if (!$coursecontext) {
            return;
        }

        // Restore the session of whoever started the emulated session, provided they
        // still hold the capability that let them use 'Log in as' in the first place.
        // Site administrators always pass this check.
        $realuser = \core\session\manager::get_realuser();
        if (!has_capability('moodle/user:loginas', $coursecontext, $realuser)) {
            return;
        }

        complete_user_login($realuser);

        // Return to the course that was being viewed, or to the site home when the
        // emulated session was not inside a course. This mirrors what core does at
        // the end of /course/loginas.php.
        if ($id == SITEID) {
            $SESSION->wantsurl = $CFG->wwwroot . '/?redirect=1';
        } else {
            $SESSION->wantsurl = $CFG->wwwroot . '/course/view.php?id=' . $id;
        }
        redirect($SESSION->wantsurl);
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
