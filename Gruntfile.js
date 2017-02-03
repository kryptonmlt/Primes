'use strict';

module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({

    // Remove built directory
    clean: {
      build: ['build/']
    },

    // Build the site using grunt-includes
    includes: {
      build: {
        cwd: 'site',
        src: [ '**/*.html' ],
        dest: 'build/',
        options: {
          flatten: false,
          includePath: 'include',
        }
      }
    },

    copy: {
      main: {
         files: [
            {expand: true, cwd: 'site', src: ['**/*.{jpg,gif,png,ico,xml,php,css,js,json,otf,eot,svg,ttf,woff,woff2}'], dest: 'build/'}
         ]
      }
    },

   rsync: {
      options: {
         args: ['--delete', '-lOcvz'],
         exclude: ['shared'],
			recursive: true,
			ssh: true
      },
      ideas: {
         options: {
            src: './build/',
            dest: '/var/www/PRIMES',
            host: '130.209.251.166'
         }
      },
      test: {
         options: {
            src: './build/',
            dest: '/var/www/PRIMES/test',
            host: '130.209.251.166'
         }
      }
   }
  });

  // Load plugins used by this task gruntfile
  grunt.loadNpmTasks('grunt-includes');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-rsync');

  // Task definitions
  grunt.registerTask('build', ['clean', 'includes', 'copy']);
  grunt.registerTask('default', ['build']);
  grunt.registerTask('deploy', ['build', 'rsync:ideas']);
};
