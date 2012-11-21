HM-Base
=======

Standard project layout for Human Made Projects.

### Setup Instructions.

* Clone the repository <code>git clone git://github.com/humanmade/hm-base.git .</code>
* Initialize all the submodules <code>git submodule update --init --recursive</code>
* Remove the HM-Base remote. <code>git remote rm origin</code>
* Add the remote for your new project <code>git remote add origin [url]</code>
* Push to the new remote <code>git push origin master</code>

* Add your database settings. 
	* Local site: Duplicate <code>wp-config-sample.php</code> and rename to <code>wp-config-local.php</code>. <code>cp wp-config-sample.php wp-config-local.php</code>, then add your local database settings. 
	* Live site:  Production settings should be added to wp-config.php
	
Done!