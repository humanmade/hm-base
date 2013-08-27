module.exports = function( grunt ) {

	'use strict';

	// Project configuration
	grunt.initConfig( {

		pkg:    grunt.file.readJSON( 'package.json' ),

		// JS Minification & Concatenation
		uglify: {

			dev: {
				options: {
					preserveComments: true,
					sourceMap: function( dest ) { return dest + '.map' },
					sourceMappingURL: function( dest ) { return dest.replace(/^.*[\\\/]/, '') + '.map' },
					sourceMapRoot: '/',
					beautify: true
				},
				files: {
					'<%= pkg.themesDir %>/hm-base-theme/assets/js/theme.js': ['<%= pkg.themesDir %>/hm-base-theme/assets/js/src/script1.js']
				}
			},

			prod: {
				options: {
					preserveComments: false,
					banner: '/* <%= pkg.homepage %> * Copyright (c) <%= grunt.template.today("yyyy") %> */\n',
					mangle: { except: ['jQuery'] }
				},
				files: {
					'<%= pkg.themesDir %>/hm-base-theme/assets/js/theme.min.js': ['<%= pkg.themesDir %>/hm-base-theme/assets/js/src/script1.js']
				}
			}

		},

		// Compile SASS
		sass: {

			compile: {
				files: {
					'<%= pkg.themesDir %>/hm-base-theme/assets/css/theme.css' : '<%= pkg.themesDir %>/hm-base-theme/assets/css/scss/theme.scss'
				}
			}

		},

		// Minify CSS
		cssmin: {

			theme: {

				options: {
					banner: '/* <%= pkg.homepage %> * Copyright (c) <%= grunt.template.today("yyyy") %> */\n'
				},

				files: {
					'<%= pkg.themesDir %>/hm-base-theme/assets/css/theme.min.css': ['<%= pkg.themesDir %>/hm-base-theme/assets/css/theme.css']
				}

			}

		},

		// Watch for changes
		watch:  {

			sass: {
				files: ['<%= pkg.themesDir %>/hm-base-theme/assets/css/*/**/*.scss'],
				tasks: ['sass', 'cssmin'],
				options: {
					debounceDelay: 500,
					livereload: true
				}
			},

			scripts: {
				files: ['<%= pkg.themesDir %>/hm-base-theme/assets/js/*/**/*.js'],
				tasks: ['uglify'],
				options: {
					debounceDelay: 500
				}
			}

		}
	} );

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task.
	grunt.registerTask( 'default', ['uglify', 'sass', 'cssmin'] );

	grunt.util.linefeed = '\n';

};