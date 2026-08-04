<img src="pix/logo.png" align="right" />

Exit 'Log In As' for Moodle LMS
===============================

[![Moodle Plugin CI](https://github.com/michael-milette/moodle-auth_dev/actions/workflows/moodle-ci.yml/badge.svg)](https://github.com/michael-milette/moodle-auth_dev/actions/workflows/moodle-ci.yml)
![PHP](https://img.shields.io/badge/PHP-v7.4%20to%20v8.4-blue.svg)
![Moodle](https://img.shields.io/badge/Moodle-v3.11%20to%20v5.2-orange.svg)
[![GitHub Issues](https://img.shields.io/github/issues/michael-milette/moodle-auth_dev.svg)](https://github.com/michael-milette/moodle-auth_dev/issues)
[![Contributions welcome](https://img.shields.io/badge/contributions-welcome-green.svg)](#contributing)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](#license)

# Table of Contents

- [Exit 'Log In As' for Moodle LMS](#exit-log-in-as-for-moodle-lms)
- [Table of Contents](#table-of-contents)
- [Basic Overview](#basic-overview)
- [Requirements](#requirements)
- [Download Exit Log In As](#download-exit-log-in-as)
- [Installation](#installation)
  - [Using Git](#using-git)
  - [The download way](#the-download-way)
- [Updating](#updating)
- [Uninstallation](#uninstallation)
- [Limitations](#limitations)
- [Language Support](#language-support)
- [Troubleshooting](#troubleshooting)
  - [Known Compatibility Issues](#known-compatibility-issues)
- [FAQ](#faq)
  - [Answers to Frequently Asked Questions](#answers-to-frequently-asked-questions)
- [Contributing](#contributing)
  - [Contributors](#contributors)
    - [Michael Milette - Lead Maintainer](#michael-milette---lead-maintainer)
    - [Carlos Escobedo - Original Author](#carlos-escobedo---original-author)
- [Motivation for this plugin](#motivation-for-this-plugin)
- [Further Information](#further-information)
- [License](#license)


# Basic Overview

When you use Moodle LMS's "Log in as" feature to view the site as another user, logging out normally ends your own session along with the emulated one. This is extremely annoying if you need to do it regularly throughout your day.

Exit Log In As changes that: It detects when you're logged in as another user and, instead of a full logout, returns you to your own account and the course you were viewing.

This plugin also provides a second, independent feature: An optional redirect to a specific URL when any user logs out.

To enable Exit Log In As, go to:

    Home ▶ Site administration ▶ Plugins ▶ Authentication ▶ Manage authentication

...and enable "Exit Log In As" in the list of authentication methods.

[(Back to top)](#table-of-contents)

# Requirements

This plugin requires Moodle LMS 3.11 to 5.2 and PHP 7.4 to 8.4. See https://moodle.org/ for Moodle LMS downloads.

[(Back to top)](#table-of-contents)

# Download Exit Log In As

The most recent STABLE release of **Exit Log In As** is available from: https://marketplace.moodle.com/plugins/auth_dev

The most recent public development release can be found at:
https://github.com/michael-milette/moodle-auth_dev

# Installation

## Using Git
- To install it using git, type this command from your Moodle LMS webroot:
```
git clone git@github.com:michael-milette/moodle-auth_dev.git auth/dev
```

## The download way

* Download the zip from <https://github.com/michael-milette/moodle-auth_dev/archive/master.zip>
* Unzip it into the auth/ folder of your Moodle LMS webroot
* Rename the new folder "moodle-auth_dev-master" to "dev"

# Updating

There are no special considerations required for updating the plugin.

For more information on releases since then, see
[CHANGELOG.md](https://github.com/michael-milette/moodle-auth_dev/blob/master/CHANGELOG.md).

[(Back to top)](#table-of-contents)

# Uninstallation

Uninstall the plugin by going into:

    Home ▶ Site administration ▶ Plugins ▶ Manage plugins ▶ Exit Log In As

...and click Uninstall. You may also need to manually delete the following folder if your webserver does not have the required permissions:

    /auth/dev

# Limitations

**Returning to the exact page depends on your browser.** To send you back to the page you were viewing, the plugin reads the referring URL supplied by your browser. Some privacy extensions and stricter referrer policies remove it. When that happens, you are returned to the course home page instead, or to the site home page if you were not in a course. You are never logged out because of it.

**Pages that only the emulated user can see.** If you were viewing something specific to the user you were emulating, you are returned to that page as yourself. Most content is visible to administrators anyway, but you may occasionally see different content than you did a moment earlier, or a permission error.

**A deleted course affects non-administrators differently.** If the course you were viewing is deleted while your emulated session is open, site administrators are still returned to their own account. Users who hold moodle/user:loginas only within a category or a course, such as managers, are logged out completely in that situation, because the capability can no longer be confirmed once the course is gone.

If you run into a limitation not listed here, please let us know through the [Bug Tracker](https://github.com/michael-milette/moodle-auth_dev/issues).

# Language Support

This plugin includes English language strings, which are maintained as part of the plugin. Translations into all other languages are contributed by the Moodle community. You can check the current coverage on the [plugin's translation page](https://marketplace.moodle.com/plugins/auth_dev/translations).

If you need a language that is not yet supported, please feel free to contribute using the Moodle AMOS Translation Toolkit for Moodle LMS at

https://lang.moodle.org/

This plugin has not been tested for right-to-left (RTL) language support. If you want to use this plugin with an RTL language and it doesn't work as-is, feel free to prepare a pull request and submit it to the project page at:

https://github.com/michael-milette/moodle-auth_dev

# Troubleshooting

**Exit Log In As isn't working.**
Confirm the plugin is enabled under Home ▶ Site administration ▶ Plugins ▶ Authentication ▶ Manage authentication. It has no effect while disabled.

**I end up on the course home page instead of the page I was viewing.**
Your browser is not sending the referring URL, so the plugin falls back to the course home page. This is usually caused by a privacy extension or a strict referrer policy. It is a limitation of the information available to the plugin rather than a fault, and you are still returned to your own account.

**I was logged out completely instead of returning to my account.**
This happens if the course you were viewing was deleted during your emulated session and you are not a site administrator. See [Limitations](#limitations). If neither applies, please report it through the [Bug Tracker](https://github.com/michael-milette/moodle-auth_dev/issues).

## Known Compatibility Issues

No compatibility issues have been reported as of August 2026. If you encounter one, please report it through the [Bug Tracker](https://github.com/michael-milette/moodle-auth_dev/issues).

[(Back to top)](#table-of-contents)

# FAQ

## Answers to Frequently Asked Questions

**Who can use Exit Log In As?**
Anyone who is entitled to use "Log in as" in the first place, in other words any user holding the moodle/user:loginas capability. That includes site administrators and, by default, managers. Regular users are unaffected by this behaviour.

**Does this change how normal users log out?**
No, unless you enable the optional logout redirect URL, which applies to all users, including those not using "Log in as".

**Where do I end up after exiting "Log in as"?**
On the page you were viewing when you exited. If your browser does not provide that information, you are returned to the home page of the course you were in, or to the site home page if you were not in a course.

**What happens if the course is deleted while I am logged in as someone?**
You are returned to your own account and sent to the site home page, rather than to an error page. Note the exception for category and course level managers described under [Limitations](#limitations).

**Does this work outside of a course, such as on a user profile or the Dashboard?**
Yes. "Log in as" can be exited from anywhere, not only from within a course.

IMPORTANT: Although we expect everything to work, this release has not been fully tested in every situation. If you find a problem, please help by reporting it in the [Bug Tracker](https://github.com/michael-milette/moodle-auth_dev/issues).

[(Back to top)](#table-of-contents)

# Contributing

If you are interested in helping, please take a look at our [contributing](https://github.com/michael-milette/moodle-auth_dev/blob/master/CONTRIBUTING.md) guidelines for details on our code of conduct and the process for submitting pull requests to us.

## Contributors

### Michael Milette - Lead Maintainer

Michael Milette took over as Lead Maintainer of Exit Log In As in July 2026.

### Carlos Escobedo - Original Author

A big thank you to Carlos for creating and maintaining this really useful plugin for many years. The plugin was originally named **"Auth Development tools"** — hence `auth_dev` — before being renamed to "Exit 'Log In As'" to make it easier for non-developer admins to find and recognize what it actually does. The `auth_dev` component name itself was kept unchanged so existing installs can upgrade seamlessly, without any migration steps. You can find Carlos at:
- <https://x.com/carlosagile>
- <https://coderwall.com/carlosagile>

[(Back to top)](#table-of-contents)

# Motivation for this plugin

The development of this plugin was motivated by our own experience in Moodle development, features requested by our clients and topics discussed in the Moodle forums. The project is sponsored and supported by TNG Consulting Inc.

[(Back to top)](#table-of-contents)

# Further Information

For further information regarding the auth_dev plugin, support or to report a bug, please visit the project page at:

https://github.com/michael-milette/moodle-auth_dev

[(Back to top)](#table-of-contents)

# License

Copyright © 2017-2026 TNG Consulting Inc. - https://www.tngconsulting.ca/

This file is part of Exit 'Log in As' for Moodle - https://moodle.org/

Exit 'Log in As' is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Exit 'Log in As' is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Exit 'Log in As'.  If not, see [https://www.gnu.org/licenses/](https://www.gnu.org/licenses/).

[(Back to top)](#table-of-contents)
