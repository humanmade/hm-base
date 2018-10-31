/**
 * This file defines the configuration for development and dev-server builds.
 */
const { unlinkSync } = require( 'fs' );
const ManifestPlugin = require( 'webpack-manifest-plugin' );
const onExit = require( 'signal-exit' );
const webpack = require( 'webpack' );

const { config } = require( './config' );
const { devServerPort, filePath, relPath, loaders, wpExternalScripts } = require( './webpack-config-utils' );

/**
 * Merge in the default dev server configuration options.
 *
 * `webpack-dev-server` does not yet support Webpack 4's "extends" property,
 * so we provide a method to augment a simple configuration object with
 * shared properties in lieu of exporting an object.
 *
 * @param {Object} config A basic Webpack configuration object.
 * @returns {Object} A complete Webpack configuration object.
 */
const devConfig = config => ( {
	mode: 'development',
	devtool: 'cheap-module-source-map',
	context: process.cwd(),
	module: {
		strictExportPresence: true,
		rules: [
			// First, run the linter before Babel processes the JS.
			loaders.eslint,
			{
				// "oneOf" will traverse all following loaders until one will
				// match the requirements. If no loader matches, it will fall
				// back to the "file" loader at the end of the loader list.
				oneOf: [
					// Inline any assets below a specified limit as data URLs to avoid requests.
					loaders.url,
					// Process JS with Babel.
					{
						// Use a custom cache directory.
						...loaders.js,
						options: {
							cacheDirectory: filePath( `node_modules/.cache/${ config.name }/babel-loader` ),
						},
					},
					{
						test: /\.scss$/,
						use: [
							require.resolve( 'style-loader' ),
							// Process SASS into CSS.
							loaders.css,
							loaders.postcss,
							loaders.sass,
						],
					},
					// "file" loader makes sure any non-matching assets still get served.
					// When you `import` an asset you get its filename.
					loaders.file,
				],
			},
		],
	},

	// Optimize output bundle.
	optimization: {
		nodeEnv: 'development',
	},

	// If any of the above properties conflict, the version from the passed-in config will be used.
	...config,

	// Allow config to override shared devServer properties.
	devServer: {
		headers: {
			'Access-Control-Allow-Origin': '*',
		},
		hotOnly: true,
		stats: {
			all: false,
			assets: true,
			colors: true,
			errors: true,
			performance: true,
			timings: true,
			warnings: true,
		},
		watchOptions: {
			aggregateTimeout: 300,
		},
		...( config.devServer || {} ),
	},

	// Allow config to add plugins.
	plugins: [
		new webpack.HotModuleReplacementPlugin(),
		new HardSourceWebpackPlugin( {
			cacheDirectory: filePath( `node_modules/.cache/${ config.name }/hard-source/[confighash]` ),
			info: {
				level: 'warn',
			},
			cachePrune: {
				// Only delete caches older than two days.
				maxAge: 2 * 24 * 60 * 60 * 1000,
				// Only delete caches if cache folder is > 50mb.
				sizeThreshold: 50 * 1024 * 1024,
			},
		} ),
		...( config.plugins || [] ),
	],
} );


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
		filename: '[name].js',
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
	externals: wpExternalScripts,
} ) );

// Permit this same config file to be used by a full CLI build or a theme- or
// plugin-specific dev server instance: If run with `webpack --config=...` as
// normal, export all build targets together as a Webpack multi-config array.
// If a specific target is specified with `BUILD_TARGET=blocks` or
// `BUILD_TARGET=theme`, only export that specific build target configuration.
module.exports = buildTargets
	.filter( target => target.name.indexOf( process.env.BUILD_TARGET ) > -1 );
