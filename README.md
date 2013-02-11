HM-Base
=======

Standard WordPress layout for Human Made projects.

### Setup Instructions.

* Clone the repository <code>git clone --recursive git://github.com/humanmade/hm-base.git .</code>
* Remove the hm-base remote. <code>git remote rm origin</code>
* Add the remote for your new project <code>git remote add origin [url]</code>
* Push to the new remote <code>git push origin master</code>

* Add any submodules that your project requires to the MU plugins directory. Here's some to get you started.
	* <strong>HM Core</strong> <code>git submodule add https://github.com/humanmade/hm-core.git content/plugins-mu/hm-core</code>
	* <strong>HM Dev</strong> <code>git submodule add git://github.com/humanmade/hm-dev.git content/plugins-mu/hm-dev</code>
	* <strong>WPThumb</strong> <code>git submodule add https://github.com/humanmade/WPThumb.git content/plugins-mu/wpthumb</code>
	* <strong>TLC Transients</strong> <code>git submodule add https://github.com/markjaquith/WP-TLC-Transients.git content/plugins-mu/tlc-transients</code>
	* <strong>Custom Meta Boxes</strong> <code>git submodule add https://github.com/humanmade/Custom-Meta-Boxes.git content/plugins-mu/custom-meta-boxes</code>
	* <strong>HM Accounts</strong> <code>git submodule add https://github.com/humanmade/hm-accounts.git content/plugins-mu/hm-accounts</code>

* Add your database settings.
	* Local site: Rename <code>wp-config-sample.php</code> to <code>wp-config-local.php</code>. <code>mv wp-config-sample.php wp-config-local.php</code>, then add your local database settings.
	* Live site:  Production settings should be added to wp-config.php

Done!


TODO

edit files false.
define file