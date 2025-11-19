=== Apply Button Scroll to Top for JetSmartFilters ===
Contributors: runthingsdev
Tags: jetsmartfilters, elementor, scroll, filters, UX
Requires at least: 6.6
Tested up to: 6.8
Stable tag: 0.1.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds smooth scroll-to-top functionality to JetSmartFilters apply button widget in Elementor.

== Description ==
This plugin extends the JetSmartFilters Apply Button widget in Elementor by adding configurable scroll behavior when the apply button is clicked.

When users apply filters, the page can automatically scroll to show the filtered results, improving the user experience by ensuring users see the updated content immediately.

The plugin integrates seamlessly with Elementor's widget controls and requires no coding to configure.

= Features =
* Add scroll-to-top functionality to JetSmartFilters apply button widgets
* Multiple scroll modes: Auto-detect, Window Top, Query ID, or Custom Target
* Auto-detection intelligently finds the listing grid based on JetSmartFilters configuration
* Smooth scrolling animation for better UX
* No alteration to JetSmartFilters or Elementor core functionality
* Per-widget configuration via Elementor's interface
* Lightweight JavaScript implementation

== Installation ==
1. Upload the entire "runthings-jsf-apply-button-scroll-to-top" folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Edit any page with Elementor that contains a JetSmartFilters Apply Button widget.
4. Select the Apply Button widget and look for the "Scroll to top on apply" control in the widget settings.
5. Enable the feature and configure your preferred scroll mode.

== Frequently Asked Questions ==
= How do I enable scroll functionality? =
Edit your page in Elementor, select the JetSmartFilters Apply Button widget, and toggle on "Scroll to top on apply" in the widget settings. Choose your preferred scroll mode.

= What scroll modes are available? =
* **Auto detect**: Automatically detects the target based on Query ID or content provider
* **Window top**: Always scrolls to the top of the page
* **Query ID**: Scrolls to the element with the ID matching this apply button's Query ID
* **Custom target ID**: Scrolls to a specific element ID you specify

= How does Auto mode work? =
Auto mode intelligently cascades through detection methods:
1. First tries to use the Query ID if configured
2. Then attempts to find the listing grid based on the content provider (e.g., jet-engine)
3. Falls back to scrolling to window top if no target is found

= Does this work with AJAX filtering? =
Yes, the plugin works with both AJAX and page reload apply types in JetSmartFilters.

= Does this change any JetSmartFilters functionality? =
No, this plugin only adds scroll behavior. All JetSmartFilters functionality remains unchanged.

= Can I use different scroll settings for different apply buttons? =
Yes, each Apply Button widget can have its own scroll configuration.

= What user capabilities are required? =
Only users who can edit pages in Elementor will see the configuration options. The scroll functionality works for all site visitors.

= I have a feature idea / I've found a bug =
You can post ideas or contribute to the project over at the GitHub repository, which can be found at https://github.com/runthings-dev/runthings-jsf-apply-button-scroll-to-top

== Screenshots ==

1. Elementor widget controls showing scroll configuration options
2. Elementor widget controls showing scroll configuration options for custom fragment

== Changelog ==

= 1.0.0 =
* Initial release
* Multiple scroll modes: Auto detect, Window top, Query ID, Custom target ID
* Auto-detection of listing grids based on JetSmartFilters configuration
* Smooth scroll animation
* Per-widget configuration in Elementor
* Support for jet-engine and jet-woo-builder content providers
* Intelligent fallback behavior when targets are not found
* Lightweight implementation with no dependencies beyond required plugins

== Upgrade Notice ==

= 1.0.0 =
Initial release.

== License ==

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, see [http://www.gnu.org/licenses/gpl-3.0.html](http://www.gnu.org/licenses/gpl-3.0.html).

Logo - up by nakals from <a href="https://thenounproject.com/browse/icons/term/up/" target="_blank" title="up Icons">Noun Project</a> (CC BY 3.0)

