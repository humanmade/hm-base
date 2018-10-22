/**
 * The base configuration used for the production build.
 */
const { loaders } = require( './webpack-config-utils' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const UglifyJsPlugin = require( 'uglifyjs-webpack-plugin' );

module.exports = config => ( {
	mode: 'production',
	devtool: 'hidden-source-map',
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
					loaders.js,
					{
						test: /\.scss$/,
						use: [
							// Instead of using style-loader, extract CSS to its own file.
							MiniCssExtractPlugin.loader,
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

	// Clean up build output
	stats: {
		all: false,
		assets: true,
		colors: true,
		errors: true,
		performance: true,
		timings: true,
		warnings: true,
	},

	// Optimize output bundle.
	optimization: {
		minimizer: [ new UglifyJsPlugin( {
			uglifyOptions: {
				output: {
					comments: false,
				},
			},
		} ) ],
		noEmitOnErrors: true,
		nodeEnv: 'production',
	},

	// If any of the above properties conflict, the version from the passed-in config will be used.
	...config,

	// Allow config to add plugins.
	plugins: [
		new MiniCssExtractPlugin( {
			filename: '[name].bundle.css',
		} ),
		...( config.plugins || [] ),
	],
} );
