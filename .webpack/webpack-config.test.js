const {
	filePath,
} = require( './webpack-config-utils' );

test( 'properly generates a file system theme file path', () => {
	expect( filePath() ).toBe( process.cwd() );
	expect( filePath( 'themes/hm-base-theme' ) ).toBe( `${ process.cwd() }/themes/hm-base-theme` );
	expect( filePath( 'themes/hm-base-theme', 'build' ) ).toBe( `${ process.cwd() }/themes/hm-base-theme/build` );
} );
