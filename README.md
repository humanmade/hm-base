HM-Base
=======

Standard project layout for Human Made Projects.

### Setup Instructions.

* Clone the repository <code>git clone git://github.com/humanmade/HM-Base.git .</code>
* Initialize all the submodules <code>git submodule update --init --recursive</code>
* Remove the HM-Base remote. <code>git remote rm origin</code>
* Add the remote for your new project <code>git remote add origin [url]</code>
* Add your database settings. 
	* Duplicate <code>wp-config-sample.php</code> and add your database settings. 
	* Production settings are added to wp-config.php
	
Done!