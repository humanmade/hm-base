/**
 * This file defines the base configuration that is used for the production build.
 */
const { filePath, relPath } = require( './webpack-config-utils' );
const prodConfig = require( './webpack-config-shared-prod' );
const { config } = require( './config' );

module.exports = config.map( ({ name, entry, path }) => prodConfig( {
	name,
	entry,
	context: relPath( path ),
	output: {
		pathinfo: true,
		path: filePath( path, 'build' ),
		filename: '[name].bundle.js',
	},
} ) );
