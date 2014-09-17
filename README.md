mumble_widget
=============
By Nicholas Earl - September 2014

A web widget for displaying a Mumble server's channels and logged-in users

This widget queries a local Mumble server and displays each channel and any logged-in users

See it in action:  www.soaseclan.net/blog


***What You Need***

- PHP 5
- A local Mumble server, configured to use Ice
- Ice 3.4 or later, properly installed on your server and integrated with Mumble and PHP


***Installation***

1) Ensure you have Ice properly installed on your server and configured to integrate with Mumble and PHP5.  This is beyond the scope of this widget, but instructions can be found here:  http://wiki.mumble.info/wiki/Ice

2) Add mumblewidget.php somewhere accessible.  The plugin is optimized to run as an iframe, sidebar widget, Drupal block view, etc

3) Ensure you have a Murmur.php file (generated as part of Ice installation in step 1) properly included for PHP, or otherwise in the same folder as mumblewidget.php

4) Include style.css wherever you're displaying the widget or add the styles to whatever stylesheet will be used.  The !important declarations may be needed if you have a stubborn CMS (ie, Drupal), otherwise they can be removed

5) Add the contents of the images folder to your web server's image directory or other accessible location



***Configuration***

In mumblewidget.php, edit these variables in the Config section

- $title  Set a title to be displayed at the top of the widget
- $imgpath  Replace this with the path to the directory containing the images you added in Step 5 of Installation
- $server (Optional) If you have multiple servers, change getServer() to point towards the ID of the server you want to display.  If you only have one server, don't change anything here

***Troubleshooting***

Configuring Ice is a pain in the butt- the instructions on the Mumble wiki can be difficult to follow.  Most issues will likely be related to an incomplete integration of Ice with Mumble and PHP.

- Ensure the proper OS-specific version of Ice 3.4 or later is installed on your server

- Ensure that you've disabled DBUS for Mumble and enabled Ice instead, and that Mumble is listening on the correct ports.  You will need to restart the Mumble server

- Ensure you've created and installed the slice files.  You may need to install slice2php separately http://doc.zeroc.com/display/Ice/slice2php+Command-Line+Options

- Ensure you've added all needed Ice files as an include in PHP.ini (ie, /usr/share/Ice-3.4.2/php/lib) and have restarted PHP

- Ensure mumblewidget.php has access to Murmur.php (generated via slice2php) and Ice.php (set up via PHP includes)

