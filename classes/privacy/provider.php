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
 * Privacy Subsystem implementation for auth_dev.
 *
 * @package   auth_dev
 * @copyright 2026 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @author    Michael Milette
 * @copyright 2014-2026 Carlos Escobedo <http://www.twitter.com/carlosagile>)
 * @author    Carlos Escobedo <http://www.twitter.com/carlosagile>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace auth_dev\privacy;

/**
 * Privacy Subsystem for auth_dev implementing null_provider.
 *
 * @copyright  2026 TNG Consulting Inc. <www.tngconsulting.ca>
 * @copyright  2018 Carlos Escobedo <carlos@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\null_provider {
    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
