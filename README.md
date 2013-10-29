Kayako Equipment Tracking System
================================

This system is a standalone web-application with the goal of aiding users of the Kayako Fusion service 
software to better regulate the influx of end-user equipment. The software is not a replacement for any 
part of the Kayako Fusion system - it's most standard use case is this:  A user arrives at the Service 
Desk, Help Desk, etc. with her laptop, charger, and a peripheral such as an external hard drive.  All 
this equipment is now the responsibility of the technicians assisting this troubled person.  Unfortunately, 
if this is a frequent occurrence, it would be shocking if something of hers was *not* mixed up, lost, or otherwise. Using our Kayako Equipment Tracking System, the diligent 
service technician pulls up the application, enters the user's information and logs each separate piece 
of equipment she brought.  The system then creates a ticket on the Kayako Fusion server to reflect the 
main issue of the hardware and item each piece of equipment related to that issue. The system then creates 
a barcode with the Kayako Fusion Display ID (e.g. KF-2213-J) and generates a barcode which the technician 
can then print out and affix to the user's equipment.  It can then be scanned directly into the Kayako 
Fusion Software's search function to determine its exact purpose and owner.

It is written using the [CodeIgniter](http://codeigniter.com/) PHP framework.

Installation
------------

The software is now in beta. The installation procedure will be activated the first time you access
the system.

The recommended hosting setup is an Apache server. The following modules are used in my current setup:

* mod_ssl - the site is built to take advantage of cross-site encryption with SSL, recommended but not necessary
* mod_rewrite - see this [Codeigniter Wiki entry](http://codeigniter.com/wiki/mod_rewrite)
* mod_cache - to serve resources faster and more efficiently

You will also need PHP 5 with cURL, MySQL, and MySQLi.

One can find my vhost configuration files under the /etc folder to use as a guide. You should delete these 
from your production environment along with the /installation folder after you get the site set up.

Once you get the files, browse to http://yourservername.com/kayako-equipment-tracker-directory/install and 
enter the items to set up the MySQL database and Codeigniter configuration files.

The installation script now will have you create a user for an "Offline Mode" in case you need to edit the API
details without logging in.  For instance, when you're moving to a new installation of Kayako Fusion.

For now, the system should be at the root of its respective virtual host.  Other configuration is theoretically
possible but has not been tested. -- It should be fine to have the system in a subdirectory now, since I've done
some portability work.  However, some of the links in CSS files will still be broken - the background texture, for
instance.

Once you have finished the installation and verified that it is working, you should delete the /install directory 
and all of its contents.

### Kayako Fusion Settings

If at the time of installation, the API settings are entered incorrectly, one can use the Offline Administrator
created during installation to change the settings on the system.

The API settings are found under the "System" tab of the settings page.

Notes
-----

One can visit the project page on the [Kayako Forge](http://forge.kayako.com/projects/client-equipment-management) for
a more complete wiki, calendar, forum, issue tracking, and roadmap -- in the future.  These things have not been completed.

Note that support *is not* planned in the long term, as hopefully this (or just the concept) can be ported 
directly to a Kayako Fusion module and dropped into an existing server.

Of course one may feel free to clone and change the software - it is licensed under the Open Software License ("OSL") v 3.0.
Fortunately, it should be rather simple for one to go into the source and make aesthetic customizations if you know your way 
around basic CSS and HTML.

[Developer Site](http://www.ratiocaeli.com)
