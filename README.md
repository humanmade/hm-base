<table width="100%">
	<tr>
		<td align="left" width="70">
			<strong>HM Base</strong><br />
			Standard WordPress layout for Human Made projects.
		</td>
		<td rowspan="2" width="20%">
			<img src="https://hmn.md/content/themes/hmnmd/assets/images/hm-logo.svg" width="100" />
		</td>
	</tr>
	<tr>
		<td>
			 A Human Made project.
		</td>
	</tr>
</table>

Standard WordPress layout for Human Made projects.

**Replace this readme in your project; you can use [the readme generator](https://humanmade.github.io/readme-creator/) for this.**

## Setup Instructions.

```sh
# Clone this repository:
git clone --recursive git://github.com/humanmade/hm-base.git your-project-name

# Navigate to the new directory.
cd your-project-name

# Update hm-platform
cd content/hm-platform
git checkout master
cd ../..
git add content/hm-platform
git commit -m 'Update hm-platform to latest'

# Update WordPress.
cd wordpress
git checkout 4.9.8
cd ..
git add wordpress
git commit -m 'Update WordPress to 4.9.8'

# Remove the hm-base remote:
git remote rm origin

# Add the remote for your new project:
git remote add origin git@github.com:humanmade/your-project-name.git

# Push to the new remote
git push origin master

# Add a local config:
cp wp-config-local-sample.php wp-config-local.php
```

## Structure

HM Base follows the [standard structure](https://engineering.hmn.md/standards/structure/) for HM projects.

## Contribution guidelines ##

see https://github.com/humanmade/hm-base/blob/master/CONTRIBUTING.md
