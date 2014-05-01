/* jshint node:true */
module.exports = function( grunt ) {
	// Load all Grunt tasks
	require( 'load-grunt-tasks' )( grunt );

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON( 'package.json' ),
		sass: {
			theme: {
				options: {
					outputStyle: 'expanded'
				},
				files: {
					'src/style.css': 'src/assets/sass/style.scss'
				}
			}
		},
		jshint: {
			options: grunt.file.readJSON( '.jshintrc' ),
			grunt: {
				src: [
					'Gruntfile.js'
				]
			},
			theme: {
				src: [
					'src/js/**/*.js',
					'!src/js/**/*.min.js',
					'!src/js/libs/**/*.js',
					'src/inc/customizer/js/customizer.js',
					'src/inc/builder/core/js/**/*.js',
					'src/inc/builder/sections/js/**/*.js'
				]
			}
		},
		concat: {
			options: {
				banner: '/*! <%= pkg.version %> */\n',
				separator: ';'
			},
			cycle2: {
				src: [
					'src/js/libs/cycle2/jquery.cycle2.js',
					'src/js/libs/cycle2/jquery.cycle2.center.js',
					'src/js/libs/cycle2/jquery.cycle2.swipe.js'
				],
				dest: 'src/js/libs/cycle2/jquery.cycle2.min.js'
			}
		},
		uglify: {
			options: {
				preserveComments: 'some'
			},
			libs: {
				files: {
					// Cycle2 source filename already has '.min' because of concat
					'src/js/libs/cycle2/jquery.cycle2.min.js': ['src/js/libs/cycle2/jquery.cycle2.min.js'],
					'src/js/libs/fitvids/jquery.fitvids.min.js': ['src/js/libs/fitvids/jquery.fitvids.js']
				}
			},
			theme: {
				files: {
					'src/js/global.min.js': ['src/js/global.js']
				}
			},
			customizer: {
				files:{
					'src/inc/customizer/js/customizer-preview.min.js': ['src/inc/customizer/js/customizer-preview.js'],
					'src/inc/customizer/js/customizer-sections.min.js': ['src/inc/customizer/js/customizer-sections.js']
				}
			},
			admin: {
				files:{
					'src/js/admin/edit-page.min.js': ['src/js/admin/edit-page.js'],
					'src/inc/gallery-slider/gallery-slider.min.js': ['src/inc/gallery-slider/gallery-slider.js']
				}
			}
		},
		shell: {
			commit: {
				command: 'git add . --all && git commit -m "Bump to <%= pkg.version %>"'
			},
			tag: {
				command: 'git tag -a <%= pkg.version %> -m "Version <%= pkg.version %>"'
			}
		},
		watch: {
			css: {
				files: 'src/assets/**/*.scss',
				tasks: [ 'sass' ]
			}
		},
		makepot: {
			theme: {
				options: {
					cwd: 'src',
					potFilename: 'make.pot',
					domainPath: '/languages',
					type: 'wp-theme',
					exclude: [],
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = 'https://thethemefoundry.com/support';
						pot.headers['last-translator'] = 'The Theme Foundry';
						pot.headers['language-team'] = 'The Theme Foundry';
						return pot;
					}
				}
			}
		},
		copy: {
			build: {
				files: [
					{
						expand: true,
						cwd: 'src/',
						src: [
							'**/*',
							'!**/.{svn,git}/**',
							'!**/.DS_Store/**'
						],
						dest: 'dist/temp'
					}
				]
			}
		},
		compress: {
			build: {
				options: {
					archive: 'dist/<%= pkg.name %>-<%= pkg.version %>.zip',
					mode: 'zip'
				},
				files: [
					{
						expand: true,
						src: ['**/*'],
						dest: '<%= pkg.name %>',
						cwd: 'dist/temp'
					}
				]
			}
		},
		clean:{
			build: {
				src: [ 'dist/temp' ]
			}
		},
		replace: {
			styleVersion: {
				src: [
					'_assets/sass/_header.scss',
					'src/style.css'
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Version:.*$/m,
					to: ' * Version:     <%= pkg.version %>'
				} ]
			},
			functionsVersion: {
				src: [
					'src/functions.php'
				],
				overwrite: true,
				replacements: [ {
					from: /^define\( 'TTFMAKE_VERSION'.*$/m,
					to: 'define( \'TTFMAKE_VERSION\', \'<%= pkg.version %>\' );'
				} ]
			}
		},
		bump: {
			options: {
				files: [ 'package.json' ],
				updateConfigs: [ 'pkg' ],
				commit: false
			}
		},
		other: {
			changelog: 'src/changelog.md'
		}
	});

	// Top level function to build a new release
	grunt.registerTask( 'release', function( releaseType ) {
		if ( 'minor' !== releaseType && 'major' !== releaseType && 'patch' !== releaseType ) {
			grunt.fail.fatal( 'Please specify the release type (e.g., "grunt release:patch")' );
		} else {
			// Bump the version numbers
			grunt.task.run( 'bumpto:' + releaseType );

			// Check to make sure the log exists
			grunt.task.run( 'log:' + releaseType );

			// Create the .pot file
			grunt.task.run( 'makepot' );

			// Build the SASS and scripts
			grunt.task.run( 'default' );

			// Zip it up
			grunt.task.run( 'package' );

			// Commit and tag version update
			grunt.task.run( 'shell:commit' );
			grunt.task.run( 'shell:tag' );
		}
	} );

	// Default task(s).
	grunt.registerTask( 'default', [ 'sass', 'concat', 'uglify' ] );

	// Bump the version to the specified value; e.g., "grunt bumpto:patch"
	grunt.registerTask( 'bumpto', function( releaseType ) {
		if ( 'minor' !== releaseType && 'major' !== releaseType && 'patch' !== releaseType ) {
			grunt.fail.fatal( 'Please specify the bump type (e.g., "grunt bumpto:patch")' );
		} else {
			grunt.task.run( 'bump-only:' + releaseType );

			// Update the version numbers
			grunt.task.run( 'replace' );
		}
	} );

	// Prompt for the changelog
	grunt.registerTask( 'log', function( releaseType ) {
		var semver = require( 'semver' ),
			changelog,
			newVersion = semver.inc( grunt.config.get( 'pkg' ).version, releaseType),
			regex = new RegExp( '^# ' + newVersion, 'gm' ); // Match the version number (e.g., "# 1.2.3")

		if ( 'minor' !== releaseType && 'major' !== releaseType && 'patch' !== releaseType ) {
			grunt.log.writeln().fail( 'Please choose a valid version type (minor, major, or patch)' );
		} else {
			// Get the new version
			changelog = grunt.file.read( grunt.config.get( 'other' ).changelog );

			if ( changelog.match( regex ) ) {
				grunt.log.ok( 'v' + newVersion + ' changlelog entry found' );
			} else {
				grunt.fail.fatal( 'Please enter a changelog entry for v' + newVersion );
			}
		}
	} );

	// Package a new release
	grunt.registerTask( 'package', [
		'copy:build',
		'compress:build',
		'clean:build'
	] );
};