module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		
		pkg: grunt.file.readJSON('package.json'),
		
		watch: {
			styles: {
				files: [ 
					'<%= pkg.themeDirectory %>/assets/css/src/*.scss' 
				],
				options: {
					nospawn: true,
				},
				tasks: [ 'sass' ]
			},
			scripts: {
				files: [ 
					'<%= pkg.themeDirectory %>/assets/js/src/*.js' 
				],
				options: {
					nospawn: true,
				},
				tasks: [ 'concat', 'uglify' ]
			}
		},

		concat: {
			options: {
				separator: '\n\n'
			},
			dist: {
				src: [
					'<%= pkg.themeDirectory %>/assets/js/src/file1.js', 
					'<%= pkg.themeDirectory %>/assets/js/src/file2.js'
				],
				dest: '<%= pkg.themeDirectory %>/assets/js/<%= pkg.name %>.js'
			}
		},

		uglify: {

			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
		
			themeScripts: {
      			files: {
        			'<%= pkg.themeDirectory %>/assets/js/<%= pkg.name %>.min.js' : ['<%= pkg.themeDirectory %>/assets/js/<%= pkg.name %>.js']
      			}
    		}		
		},

		sass: {
			theme: {
				dist: {
					options: {
						style: 'compressed'
					},
					files: {
						'<%= pkg.themeDirectory %>/assets/css/<%= pkg.name %>.min.css': '<%= pkg.themeDirectory %>/assets/css/src/style.scss',
					}
				},
				dev: {
					options: {
						style: 'expanded',
						debugInfo: true,
						lineNumbers: true
					},
					files: {
						'<%= pkg.themeDirectory %>/assets/css/<%= pkg.name %>.css': '<%= pkg.themeDirectory %>/assets/css/src/style.scss',
					}
				}
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task(s).
	grunt.registerTask( 'default', ['concat', 'uglify', 'sass' ] );

	grunt.registerTask( 'build-live', ['concat', 'uglify'] );


};