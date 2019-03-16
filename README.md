# APPideas Wordpress Database Abstraction

A Wordpress plugin that provides a light-weight database abstraction layer. This plugin does not abstract wpdb, but 
instead abstracts PHP's mysqli to connect to a Wordpress database.

Yes, Wordpress already has wpdb, but it's heavy and clunky, and I prefer to use the syntax of the APPideas database 
abstraction layer (AiDB). Additionally, I'm not a fan of Wordpress doing things like checking for schema updates
on every initialization of a plugin (every page load). Using this database abstraction for your plugin can help you
eliminate such overhead and still control schema updates. This is particularly useful for developers of in-house
Wordpress plugins - where you have control of the update process as the site developer.

This plugin is meant for developer use and has no end-user (website maintainer) purpose. If you have this plugin
installed on your website and came here trying to figure out why, it's likely that another one of your plugins depends
on this one.

This is an adaptation of the APPideas database abstraction layer, which was initially developed many years ago, and is in
use in hundreds of live applications. AiDB, is known to process hundreds of millions of requests every day in production
environments. It probably does a lot more than that, but it's been Open Source for a long time too, and people don't
usually send me their stats.

# Installation
Install as any wordpress plugin:
1. Unzip and FTP the appideas-database-abstraction folder into your wp-content/plugins/ directory, or

   Upload the plugin ZIP file through the wp-admin Plugins administration screen
2. Activate the plugin

# Usage
See examples at:

https://appideas.com/database-abstraction-part-1-php/

This is a work in-progress, and updated documentation is coming soon. Documentation and examples are available in the 
docs and examples directories of the source code.

# License
This code is available under the GPLv3, a copy of which is included in the resources directory. The GPL can also be
seen at:
https://www.gnu.org/licenses/gpl.txt


 
