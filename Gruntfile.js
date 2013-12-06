/*jshint node: true*/
/*global module*/

module.exports = function (grunt) {
    "use strict";
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        compress: {
            main: {
                options: {
                    archive: 'Bootstrap-Simple-Uploadform.zip'
                },
                files: [
                    {expand: true, src: ['dist/css/*', 'dist/js/*']}
                ]
            }
        },
        copy: {
            css: {
                expand: true,
                src: ["css/*"],
                dest: 'dist/'
            },
            js: {
                expand: true,
                src: ["js/*"],
                dest: 'dist/'
            }
        },
        cssmin: {
            options: {
                keepSpecialComments: "0"
            },
            combine: {
                files: {
                    'dist/css/Bootstrap-Simple-Uploadform.min.css': ['css/Bootstrap-Simple-Uploadform.css']
                }
            }
        },
        uglify: {
            options: {
                report: 'min'
            },
            uploadform: {
                src: ['js/Bootstrap-Simple-Uploadform.js'],
                dest: 'dist/js/Bootstrap-Simple-Uploadform.min.js'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('dist', ['copy', 'cssmin', 'uglify', 'compress']);
};
