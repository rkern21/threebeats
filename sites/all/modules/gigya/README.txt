Authentication In order to properly authenticate users, the gigya module
must be setup. You can configure it through admin->site settings->gigya
Make sure you have the following 
	* Site API Key 
	* Your user private key from gigya 
	* Selected social networks
	
That should be all thats required to setup authentication. You can
further customize the UI by looking at the subsections. If profile
module is enabled, you can select which gigya social network mappings
should be assigned to your local profile settings, and display the
profile category on the user registration page.

Please refer to http://wiki.gigya.com/050_Socialize_Plugins/020_Drupal for more info.


Configure Share UI of Gigya Socialize
Please refer to http://wiki.gigya.com/050_Socialize_Plugins/020_Drupal for more info.

Q: I connected all my social networks to my drupal account, and now when
I connect with socialize and link to drupal, they all disappear! 
A: This is normal operation. Unfortunately you'll have to re-connect 
to your social networks if you use socialize to login rather than drupal
