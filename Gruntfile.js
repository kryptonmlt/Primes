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
        src: [ '**/*.*' ],
        dest: 'build/',
        options: {
          flatten: false,
          includePath: 'include',
        }
      }
    }
  });

  // Load plugins used by this task gruntfile
  grunt.loadNpmTasks('grunt-includes');
  grunt.loadNpmTasks('grunt-contrib-clean');

  // Task definitions
  grunt.registerTask('build', ['clean', 'includes']);
  grunt.registerTask('default', ['build']);
};
