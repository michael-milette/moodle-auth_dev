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

require_once($CFG->libdir . '/authlib.php');

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
        if (!\core\session\manager::is_loggedinas()) {
            return;
        }

        // If id == 0, this is an ordinary logout request. Nothing to do.
        $id = optional_param('id', 0, PARAM_INT);
        if (!$id) {
            return;
        }

        // The course may have been deleted while the emulated session was open. Fall back to
        // the system context so that a missing course can never strand the user in a full
        // logout, which is the very thing this plugin exists to prevent.
        $coursecontext = \context_course::instance($id, IGNORE_MISSING);
        $capabilitycontext = $coursecontext ? $coursecontext : \context_system::instance();

        // Restore the session of whoever started the emulated session, provided they still
        // hold the capability that let them use 'Log in as' in the first place. Site
        // administrators always pass this check.
        $realuser = \core\session\manager::get_realuser();
        if (!has_capability('moodle/user:loginas', $capabilitycontext, $realuser)) {
            return;
        }

        complete_user_login($realuser);
        redirect($this->get_loginas_return_url($id, $coursecontext));
    }

    /**
     * Work out where to send the user after they exit an emulated session.
     *
     * Preference is given to the page they were actually viewing, so that exiting
     * 'Log in as' does not cost them their place. If the course has been deleted the
     * page they came from is likely broken too, so a safe destination is used instead.
     *
     * @param int $id The course id supplied by /course/loginas.php.
     * @param \context_course|false $coursecontext Course context, or false if the course is gone.
     *
     * @return string The URL to redirect to.
     */
    protected function get_loginas_return_url($id, $coursecontext) {
        global $CFG;

        if ($coursecontext) {
            // The get_local_referer() filters through PARAM_LOCALURL, so an external or absent
            // referer yields an empty string and cannot be used to redirect off site.
            $referer = get_local_referer(false);

            // Never bounce back into the login or 'Log in as' machinery itself.
            $isloginurl = strpos($referer, '/login/') !== false
                || strpos($referer, '/course/loginas.php') !== false;

            if (!empty($referer) && !$isloginurl) {
                return $referer;
            }

            if ($id != SITEID) {
                return $CFG->wwwroot . '/course/view.php?id=' . $id;
            }
        }

        // Matches what core's /course/view.php does for the site course.
        return $CFG->wwwroot . '/?redirect=0';
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
    public function user_login($username, $password) {
        return false;
    }
}
