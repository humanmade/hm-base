/**
 * Utility methods for use when generating build configuration objects.
 */
const path = require( 'path' );
const autoprefixer = require( 'autoprefixer' );
const postcssFlexbugsFixes = require( 'postcss-flexbugs-fixes' );

const { config } = require( './config' );

/**
 * Return the specified port on which to run the dev server.
 */
const devServerPort = () => parseInt( process.env.PORT, 10 ) || 9090;

/**
 * Return the absolute file system path to a file within the project.
 * @param  {...String} relPaths Strings describing a file relative to the content/ folder.
 * @returns {String} An absolute file system path.
 */
const filePath = ( ...relPaths ) => path.join( process.cwd(), ...relPaths );

/**
 * Return the relative file system path to a file within the project.
 */
const relPath = relPath => path.resolve( process.cwd(), relPath );

/**
 * An array of file system paths in which to find first-party source code.
 * Used to limit Webpack transforms like Babel to just those folders containing our code.
 */
const srcPaths = config.map( ( { path } ) => filePath( path, 'src' ) );

/**
 * Loader configuration objects which can be re-used in the dev and prod build config files.
 */
const loaders = {
	eslint: {
		test: /\.(js|jsx|mjs)$/,
		include: srcPaths,
		enforce: 'pre',
		use: [ {
			options: {
				eslintPath: require.resolve( 'eslint' ),
			},
			loader: require.resolve( 'eslint-loader' ),
		} ],
	},
	url: {
		test: /\.(png|jpg|jpeg|gif|svg|woff|woff2|eot|ttf)$/,
		loader: require.resolve( 'url-loader' ),
		options: {
			limit: 10000,
		},
	},
	js: {
		test: /\.js$/,
		include: srcPaths,
		loader: require.resolve( 'babel-loader' ),
		options: {
			// Cache compilation results in ./node_modules/.cache/babel-loader/
			cacheDirectory: true,
		},
	},
	css: {
		loader: require.resolve( 'css-loader' ),
		options: {
			importLoaders: 1,
		},
	},
	postcss: {
		loader: require.resolve( 'postcss-loader' ),
		options: {
			ident: 'postcss',
			plugins: () => [
				postcssFlexbugsFixes,
				autoprefixer( {
					browsers: [
						'>1%',
						'last 4 versions',
						'Firefox ESR',
						'not ie < 10',
					],
					flexbox: 'no-2009',
				} ),
			],
		},
	},
	sass: require.resolve( 'sass-loader' ),
	file: {
		// Exclude `js`, `html` and `json`, but match anything else.
		exclude: [ /\.js$/, /\.html$/, /\.json$/ ],
		loader: require.resolve( 'file-loader' ),
	},
};

module.exports = {
	devServerPort,
	relPath,
	filePath,
	srcPaths,
	loaders,
};
