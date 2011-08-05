Original Author
---------------
	David Angier (http://angier.co.uk)

Maintainer
----------
  William Roboly (http://openject.com)
	
Drupal 6 version
----------------
	2008-03-10 by Paul Maddern (http://www.arcadegeek.co.uk)

Overview
--------
Bad Behavior is a set of PHP scripts which prevents spambots from
accessing your site by analyzing their actual HTTP requests and
comparing them to profiles from known spambots. It goes far beyond
User-Agent and Referer, however.

The problem: Spammers run automated scripts which read everything on
your web site, harvest email addresses, and if you have a blog, forum
or wiki, will post spam directly to your site. They also put false
referrers in your server log trying to get their links posted through
your stats page.

As the operator of a Web site, this can cause you several
problems. First, the spammers are wasting your bandwidth, which you
may well be paying for. Second, they are posting comments to any form
they can find, filling your web site with unwanted (and unpaid!) ads
for their products. Last but not least, they harvest any email
addresses they can find and sell those to other spammers, who fill
your inbox with more unwanted ads.

Bad Behavior intends to target any malicious software directed at a
Web site, whether it be a spambot, ill-designed search engine bot, or
system crackers.

Requirements
------------
- Drupal 6.x
- PHP 4.3.0 or greater
- BadBehavior 2.0.13
  (http://www.ioerror.us/software/bad-behavior/bad-behavior-download)
 
Installation
------------

1. Extract the tarball into the modules folder of your Drupal install.

2. Download BadBehavior 2.0.13 from
   http://www.ioerror.us/software/bad-behavior/bad-behavior-download/,
   unzip and copy the resulting bad-behavior directory into 
   modules/badbehavior folder.

3. Enable the module as usual from the Drupal admin>>modules page.
 
Configuration
-------------
1. If desired, configure settings under the new
   admin>>settings>>badbehavior menu item.
 
Logs
----
1. View BadBehavior logs at the new admin>>logs>>badbehavior menu
   item.

2. Click on the detail link next to any log item for full details.

Frequently Asked Questions
--------------------------
See: http://www.ioerror.us/software/bad-behavior/bad-behavior-faq/




