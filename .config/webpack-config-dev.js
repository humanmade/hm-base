/**
 * This file defines the configuration for development and dev-server builds.
 */
const { unlinkSync } = require( 'fs' );
const ManifestPlugin = require( 'webpack-manifest-plugin' );
const onExit = require( 'signal-exit' );

const { hmThemeDir, blockPluginDir } = require( './config' );
const { devServerPort, filePath } = require( './webpack-config-utils' );
const devConfig = require( './webpack-config-shared-dev' );

// Run the plugin dev server on a separate port to avoid conflicts with theme HMR.
const devServer = {
	theme: {
		port: devServerPort(),
		uri: serverPath => `http://localhost:${ devServer.theme.port }${ serverPath }`,
	},
	plugin: {
		port: devServerPort() + 1,
		uri: serverPath => `http://localhost:${ devServer.plugin.port }${ serverPath }`,
	},
}

// Clean up manifest on exit.
onExit( () => {
	[
		filePath( ...hmThemeDir, 'build', 'asset-manifest.json' ),
		filePath( ...blockPluginDir, 'build', 'asset-manifest.json' ),
	].forEach( path => {
		try {
			unlinkSync( path );
		} catch ( e ) {
			// Silently ignore unlinking errors: so long as the file is gone, that is good.
		}
	} );
} );

const buildTargets = [
	/**
	 * Theme development build configuration.
	 */
	devConfig( {
		name: 'hm-base-theme',
		devServer: {
			port: devServer.theme.port,
		},
		entry: {
			'theme': filePath( hmThemeDir, 'src/theme.js' ),
			'single': filePath( hmThemeDir, 'src/single.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: true,
			path: filePath( hmThemeDir, 'build' ),
			publicPath: devServer.theme.uri( `${hmThemeDir}/build` ),
			filename: '[name].bundle.js',
		},
		plugins: [
			// Generate a manifest file which contains a mapping of all asset filenames
			// to their corresponding output file so that PHP can pick up their paths.
			new ManifestPlugin( {
				publicPath: devServer.theme.uri(  `${hmThemeDir}/build` ),
				fileName: 'asset-manifest.json',
				writeToFileEmit: true,
			} ),
		],
	} ),

	/**
	 * Gutenberg block build configuration.
	 */
	devConfig( {
		name: 'blocks',
		devServer: {
			port: devServer.plugin.port,
		},
		entry: {
			editor: filePath( blockPluginDir, '/src/editor.js' ),
			frontend: filePath( blockPluginDir, '/src/frontend.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: true,
			path: filePath( blockPluginDir, 'build' ),
			publicPath: devServer.plugin.uri( `${blockPluginDir}/build` ),
			filename: '[name].bundle.js',
		},
		plugins: [
			// Generate a manifest file which contains a mapping of all asset filenames
			// to their corresponding output file so that PHP can pick up their paths.
			new ManifestPlugin( {
				publicPath: devServer.plugin.uri( `${blockPluginDir}/build` ),
				fileName: 'asset-manifest.json',
				writeToFileEmit: true,
			} ),
		],
	} ),
];

// Permit this same config file to be used by a full CLI build or a theme- or
// plugin-specific dev server instance: If run with `webpack --config=...` as
// normal, export all build targets together as a Webpack multi-config array.
// If a specific target is specified with `BUILD_TARGET=blocks` or
// `BUILD_TARGET=theme`, only export that specific build target configuration.
module.exports = buildTargets
	.filter( target => target.name.indexOf( process.env.BUILD_TARGET ) > -1 );
