# Dynamic Welcome WordPress Plugin
Dynamic Welcome is a WordPress plugin that personalizes your website's greeting message based on the user and the time of day. It allows you to create a more welcoming and engaging experience for your visitors.

## Features:
- Display personalized greetings for logged-in users, including their display name.
- Customize greetings for different times of day (morning, afternoon, evening).
- Display a generic greeting for non-logged-in users.
- Utilize WordPress core functions and best practices for security and performance.
- Easy to set up and use with clear instructions.

## Benefits:
- Increase user engagement with a more personal touch.
- Enhance the first impression of your website.
- Create a welcoming atmosphere for all visitors.

## Installation
1. Download the "dynamic-welcome" plugin directory.
2. Upload the directory to the `wp-content/plugins/` directory of your WordPress installation.
3. Activate the plugin through the WordPress admin panel.

## Usage
Use the `[dynamic_welcome]` shortcode in your WordPress posts or pages to display personalized greetings message.

## Example usage:

`[dynamic_welcome]`

- If a user is logged in, the plugin will greet them with "Good Morning/Afternoon/Evening,<em>[User's Display Name]!</em>" based on the time of day.
- If a user is not logged in, the plugin will display "Welcome, Guest!".

## Notes
- Requires WordPress version 4.7 or higher.
- Clear any caching plugins after installing or updating the plugin.

## Contribution
We welcome contributions to improve this plugin. Feel free to fork the repository and submit pull requests.

## License
This plugin is licensed under the GNU General Public License (GPLv2 or later).

## Support
For any questions or feedback, please create an issue on the GitHub repository.
