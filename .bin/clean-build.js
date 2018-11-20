const { join } = require( 'path' );
const rimraf = require( 'rimraf' );

const deleteDir = ( ...relPaths ) => new Promise( ( resolve, reject ) => {
	const dirPath = join( process.cwd(), ...relPaths );
	rimraf( dirPath, ( err ) => {
		if ( err ) {
			reject( err );
		} else {
			resolve();
		}
	} );
} );

( async () => {
	await deleteDir( 'themes', 'hm-base-theme', 'build' );
	await deleteDir( 'mu-plugins', 'blocks', 'build' );
} )();
