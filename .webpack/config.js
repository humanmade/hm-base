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
		name: 'hm-blocks-plugin',
		path: `${muPluginDir}/hm-blocks`,
		entry: {
			editor: './src/editor.js',
			style: './src/style.scss',
		},
	},
];

module.exports = {
	config,
};
