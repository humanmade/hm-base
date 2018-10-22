/**
 * This file defines the configuration for development and dev-server builds.
 */
const { unlinkSync } = require( 'fs' );
const ManifestPlugin = require( 'webpack-manifest-plugin' );
const onExit = require( 'signal-exit' );

const { config } = require( './config' );
const { devServerPort, filePath, relPath } = require( './webpack-config-utils' );
const devConfig = require( './webpack-config-shared-dev' );

const devServerUri = ( port, path ) => `http://localhost:${ port }/${ path }`;

// cosnt devServerPort = devServerPort();
// Clean up manifest on exit.
onExit( () => {
	config.map( project => filePath( project.path, 'build', 'asset-manifest.json' ) )
	.forEach( path => {
		try {
			unlinkSync( path );
		} catch ( e ) {
			// Silently ignore unlinking errors: so long as the file is gone, that is good.
		}
	} );
} );

const buildTargets = config.map( ( { name, path, entry }, i ) => devConfig( {
	name,
	devServer: {
		port: devServerPort() + i,
	},
	entry,
	context: relPath( path ),
	output: {
		// Add /* filename */ comments to generated require()s in the output.
		pathinfo: true,
		path: filePath( path, 'build' ),
		publicPath: devServerUri( devServerPort() + i, `${path}/build/` ),
		filename: '[name].bundle.js',
	},
	plugins: [
		// Generate a manifest file which contains a mapping of all asset filenames
		// to their corresponding output file so that PHP can pick up their paths.
		new ManifestPlugin( {
			publicPath: devServerUri( devServerPort() + i, `${path}/build/` ),
			fileName: 'asset-manifest.json',
			writeToFileEmit: true,
		} ),
	],
} ) );

// Permit this same config file to be used by a full CLI build or a theme- or
// plugin-specific dev server instance: If run with `webpack --config=...` as
// normal, export all build targets together as a Webpack multi-config array.
// If a specific target is specified with `BUILD_TARGET=blocks` or
// `BUILD_TARGET=theme`, only export that specific build target configuration.
module.exports = buildTargets
	.filter( target => target.name.indexOf( process.env.BUILD_TARGET ) > -1 );
