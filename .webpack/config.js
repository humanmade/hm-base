const themeDir = 'content/themes';
const muPluginDir = 'content/mu-plugins';

const config = [
	{
		name: 'hm-base-theme',
		path: `${themeDir}/hm-base-theme`,
		entry: {
			theme: './src/js/theme.js',
			single: './src/js/single.js',
			style: './src/scss/style.scss',
		},
	},
	{
		name: 'blocks-plugin',
		path: `${muPluginDir}/blocks`,
		entry: {
			editor: './src/editor.js',
			frontend: './src/frontend.js',
		},
	},
];

module.exports = {
	config,
};
