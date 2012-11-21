HM-Base
=======

Standard WordPress layout for Human Made projects.

### Setup Instructions.

* Clone the repository <code>git clone --recursive git://github.com/humanmade/hm-base.git .</code>
* Remove the hm-base remote. <code>git remote rm origin</code>
* Add the remote for your new project <code>git remote add origin [url]</code>
* Push to the new remote <code>git push origin master</code>

* Add your database settings. 
	* Local site: Duplicate <code>wp-config-sample.php</code> and rename to <code>wp-config-local.php</code>. <code>cp wp-config-sample.php wp-config-local.php</code>, then add your local database settings. 
	* Live site:  Production settings should be added to wp-config.php
	
Done!