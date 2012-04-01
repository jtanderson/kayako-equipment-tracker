Kayako Equipment Tracking System
================================

This system is a standalone web-application with the goal
of aiding users of the Kayako Fusion service software to better regulate the influx of end-user equipment.
The software is not a replacement for any part of the Kayako Fusion system - it's most standard use case is
this:  A user arrives at the Service Desk, Help Desk, etc. with her laptop, charger, and a peripheral such
as an external hard driver.  All this equipment is now the responsibility of the technicians assisting this
troubled person.  Unfortunately, if this is a frequent occurrence, it would be shocking if somethings of
hers was *not* mixed up with somebody else equipment, lost, or otherwise.  Using our Kayako Equipment
Tracking System, the diligent service technician pulls up the application, enters the user's information and
logs each separate piece of equipment she brought.  The system then creates a ticket on the Kayako Fusion
server to reflect the main issue of the hardware and item each piece of equipment related to that issue.
The system then creates a barcode with the Kayako Fusion Display ID (e.g. KF-2213-J) and generates a barcode
which the technician can then print out and affix to the user's equipment.  It can then be scanned directly
into the Kayako Fusion Software's search function to determine its exact purpose and owner.

It is written using the [CodeIgniter](http://codeigniter.com/) PHP framework.

Installation
------------

This is still in an "Alpha" state, as all planned features have not been implemented.  However, installation should
be possible. Later, a more streamlined and portable installation script is planned.

The recommended hosting setup is an Apache server. The following modules are used in my current setup:

* mod_ssl - the site is built to take advantage of cross-site encryption with SSL, recommended but not necessary
* mod_rewrite - see this [Codeigniter Wiki entry](http://codeigniter.com/wiki/mod_rewrite)
* mod_cache - to serve resources faster and more efficiently

You will also need PHP 5 with cURL, and MySQL.

One can find my vhost configuration files under the /etc folder to use as a guide. You should delete these from your production 
environment along with the /installation folder after you get the site set up.

Once you get the files, browse to http://yourservername.com/install and enter the items to set up the MySQL database.

For now, the system should be at the root of its respective virtual host.  Other configuration is theoretically
possible but has not been tested.

Once you have finished the installation and verified that it is working, you should delete the /install directory and all of its contents.

### Kayako Fusion Settings

For the moment, you must enter the settings for your Kayako Fusion server by hand into the MySQl database.
Using phpMyadmin, command-line, or whatever, enter your API Key, Secret Key, and SWIFT URL (just the main URL
of the Kayako Server into the "Value" field of the appropriate setting on the TB_APISetting table).  This should
later be integrated into the install script.  One must log into the system and be validated by the Kayako server
at least once to be able to log in without proper Kayako API settings.

Notes
-----

One can visit the project page on the [Kayako Forge](http://forge.kayako.com/projects/client-equipment-management) for
a more complete wiki, calendar, forum, issue tracking, and roadmap.

Note that support *is not* planned in the far future, as hopefully this (or just the concept) can be ported 
directly to a Kayako Fusion module and dropped into an existing server.

[Developer Site](http://www.ratiocaeli.com)