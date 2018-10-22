/**
 * This file defines the base configuration that is used for the production build.
 */
const { filePath } = require( './webpack-config-utils' );
const prodConfig = require( './webpack-config-shared-prod' );
const { hmThemeDir, blockPluginDir } = require( './config' );

module.exports = [
	/**
	 * Theme production build configuration.
	 */
	prodConfig( {
		entry: {
			'theme': filePath( hmThemeDir, 'src/theme.js' ),
			'single': filePath( hmThemeDir, 'src/single.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: true,
			path: filePath( hmThemeDir, 'build' ),
			filename: '[name].bundle.js',
		},
	} ),

	/**
	 * Gutenberg block production build configuration.
	 */
	prodConfig( {
		entry: {
			editor: filePath( blockPluginDir, 'src/editor.js' ),
			frontend: filePath( blockPluginDir, 'src/frontend.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: true,
			path: filePath( blockPluginDir, 'build' ),
			filename: '[name].bundle.js',
		},
	} ),
];
