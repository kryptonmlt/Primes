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
            {expand: true, cwd: 'site', src: ['**/*.{jpg,gif,png,pdf,ico,xml,php,css,js,json,otf,eot,svg,ttf,woff,woff2}'], dest: 'build/'}
         ]
      }
    },

   sitemap: {
      dist: {
         siteRoot: 'build',
         pattern: ['build/**/*.{html,pdf,png,jpg,gif}', '!build/**/google*.html'],
         extension: {
            required: true
         }
      }
   },

   htmlmin: {
      dist: {
         options: {
            removeComments: true,
            collapseWhitespace: true,
            keepClosingSlash: true
         },
         files: [{
            expand: true,
            cwd: 'build',
            src: '*.html',
            dest: 'build'
         }]
      }
   },

   'json-minify': {
      build: {
         files: 'build/**/*.json'
      }
   },

   rsync: {
      options: {
         args: ['--delete', '-lOcvz'],
         exclude: ['shared'],
         recursive: true,
         ssh: true
      },
      primes: {
         options: {
            src: './build/',
            dest: '/var/www/html',
            host: '130.209.251.163'
         }
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
  grunt.loadNpmTasks('grunt-contrib-htmlmin');
  grunt.loadNpmTasks('grunt-rsync');
  grunt.loadNpmTasks('grunt-sitemap');
  grunt.loadNpmTasks('grunt-json-minify');

  // Task definitions
  grunt.registerTask('build', ['clean', 'includes', 'copy', 'sitemap']);
  grunt.registerTask('jsonmin', ['json-minify']);
  grunt.registerTask('deploy', ['build', 'htmlmin', 'jsonmin', 'rsync:primes']);
  grunt.registerTask('default', ['build']);
};
