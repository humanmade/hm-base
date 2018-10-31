var BASE_URL = casper.cli.get( 'url' );

casper.test.begin( 'Homepage', 2, function suite(test) {

	casper.start( BASE_URL, function() {

		this.viewport( 1024, 768 );
		test.assertExists( 'head' );
		test.assertExists( 'body' );
	} );

	casper.run(function() {
		test.done();
	});
});
