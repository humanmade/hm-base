HM Base
=======

Standard WordPress layout for Human Made projects.

### Setup Instructions.

* Create an empty directory for your project. In terminal, navigate to this directory.
* Clone the repository `git clone --recursive git://github.com/humanmade/hm-base.git .`
* Remove the hm-base remote. `git remote rm origin`
* Add the remote for your new project `git remote add origin [url]`
* Push to the new remote `git push origin master`
* Add any submodules that your project requires to the `mu-plugins` directory. Here's some to get you started.

	* **HM Core** `git submodule add https://github.com/humanmade/hm-core.git content/plugins-mu/hm-core`
	* **HM Dev** `git submodule add git://github.com/humanmade/hm-dev.git content/plugins-mu/hm-dev`
	* **WP Thumb** `git submodule add https://github.com/humanmade/WPThumb.git content/plugins-mu/wpthumb`
	* **TLC Transients** `git submodule add https://github.com/markjaquith/WP-TLC-Transients.git content/plugins-mu/tlc-transients`
	* **Custom Meta Boxes** `git submodule add https://github.com/humanmade/Custom-Meta-Boxes.git content/plugins-mu/custom-meta-boxes`
	* **HM Accounts** `git submodule add https://github.com/humanmade/hm-accounts.git content/plugins-mu/hm-accounts`
	* **MinQueue** `git submodule add git@github.com:mattheu/MinQueue.git content/plugins-mu/minqueue`
	* **Term Meta** `git submodule add git@github.com:humanmade/termmeta content/plugins-mu/termmeta`
	* **HM Rewrites** `git submodule add git@github.com:humanmade/hm-rewrite content/plugins-mu/hm-rewrite`


* Add your database settings.

	* Local site: `mv wp-config-sample.php wp-config-local.php`, then add your local database settings.
	* Live site: Production database settings should be added to `wp-config.php`.

Done!

### Notes

* HM Base sets the MU Plugins directory to `plugins-mu` instead of `mu-plugins` for consistency.
