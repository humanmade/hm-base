const themeDir = 'content/themes';
const muPluginDir = 'content/mu-plugins';

const config = [
	{
		name: 'hm-base-theme',
		path: `${themeDir}/hm-base-theme`,
		entry: {
			theme: './src/theme.js',
			single: './src/single.js',
		}
	},
	{
		name: 'blocks-plugin',
		path: `${muPluginDir}/blocks`,
		entry: {
			editor: './src/editor.js',
			frontend: './src/frontend.js',
		}
	}
];


module.exports = {
	config,
};
