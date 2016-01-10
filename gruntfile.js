module.exports = function(grunt) {

  'use strict';

  require('time-grunt')(grunt);
  require('load-grunt-tasks')(grunt);
  grunt.option('force', true);

  grunt.registerTask('build', ['clean', 'concat', 'less', 'copy']);
  grunt.registerTask('default', ['build', 'watch']);

  var isRelease = false;
  grunt.cli.tasks.forEach(function (ts) {
    if (ts === 'release') {
      isRelease = true;
    }
  });

  grunt.initConfig({
    src: {
      app: {
        js: ['assets/js/app/**/*.js'],
        js_vendor: [
          'assets/vendor/jquery/dist/jquery.js',
          'assets/vendor/bootstrap/dist/js/bootstrap.js',
          'assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js'
        ],
        css_vendor: [
          'assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.css'
        ],
        less: ['assets/less/app.less']
      }
    },

    clean: ['web/build/*'],

    concat: {
      app_js: {
        src: ['<%= src.app.js %>'],
        dest: 'web/build/app.js'
      },
      app_vendor_js: {
        src: '<%= src.app.js_vendor %>',
        dest: 'web/build/app-vendor.js'
      },
      app_vendor_css: {
        src: '<%= src.app.css_vendor %>',
        dest: 'web/build/app-vendor.css'
      }
    },

    copy: {
      fonts: {
        files: [
          { dest: 'web/build/fonts/', cwd: 'assets/fonts/', src: '**', expand: true},
          { dest: 'web/build/fonts/', cwd: 'assets/vendor/bootstrap/dist/fonts/', src: '**', expand: true},
          { dest: 'web/build/fonts/', cwd: 'assets/vendor/fontawesome/fonts/', src: '**', expand: true}
        ]
      },
      jq_map: {
        src: 'assets/vendor/jquery/dist/jquery.min.map',
        dest: 'web/build/jquery.min.map'
      }
    },

    less: {
      app: {
        options: {
          strictImports : true,
          compress: isRelease,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: "app.css.map"
        },
        files: {
          'web/build/app.css': '<%= src.app.less %>'
        }
      }
    },

    uglify: {
      app: {
        src: ['<%= concat.app_js.dest %>'],
        dest: '<%= concat.app_js.dest %>'
      },
      vendor: {
        src: ['<%= concat.app_vendor_js.dest %>'],
        dest: '<%= concat.admin_vendor_js.dest %>'
      }
    },

    removelogging: {
      app: {
        src: "<%= concat.app_js.dest %>",
        dest: "<%= concat.app_js.dest %>"
      }
    },

    watch: {
      js_app: {
        files: ['<%= src.app.js %>'],
        tasks: ['concat:app_js']
      },
      less_app: {
        files: ['<%= src.app.less %>', 'assets/less/app/**/*.less'],
        tasks: ['less:app']
      }
    }

  });
};
