// package.json
// "engines": {
//    "node": "0.11.15",
//    "npm": "2.2.0"
// }

module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON("package.json"),
		banner: "/*!\n" + " * <%= pkg.title || pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today(\"yyyy-mm-dd\") %>\n" + 
		    "<%= pkg.homepage ? \" * \" + pkg.homepage + \"\\n\" : \"\\n\" %>" + " *\n" + 
		    " * Copyright (c) <%= grunt.template.today(\"yyyy\") %> <%= pkg.author %>;" + 
		    //" Licensed <%= _.pluck(pkg.licenses, \"type\").join(\", \") %> */\n"
		    " Licensed <%= pkg.license %>\n" + 
		    " */\n\n",
		    
		files: {
			less: {
				app: ["assets/less/app.less"],
				
				watch: ["assets/less/**/*.less", "assets/less/*.less"]
			},
			
			js: {
				top: [
				      "assets/js/top.js"
				],
				app: [
				      //"bower_components/jquery/dist/jquery.js", // ~2.1.1 does not support Internet Explorer 6, 7, or 8
				      "bower_components/jquery/dist/jquery.js", // ~1.11.1
				      //"bower_components/jquery/jquery.js", // ~1.10.x
				      "bower_components/jquery-migrate/jquery-migrate.min.js", // use if you are upgrading from pre-1.9 versions
				      "bower_components/jquery-easing-original/jquery.easing.js", // con 'min' da errore	
				      "bower_components/bootstrap/js/transition.js",
				      "bower_components/bootstrap/js/collapse.js",
				      "bower_components/bootstrap/js/alert.js",
				      //"bower_components/bootstrap/js/tab.js",
				      "bower_components/bootstrap/js/tooltip.js",
				      "bower_components/bootstrap/js/modal.js", // depends on transition
				      "assets/js/app.js"
				]
			}
		},
		
		sprite: {
			all: {
				src: 'assets/sprite/**/*.png',
				dest: '../../../public_html/assets/img/sprite/custom.png',
				destCss: 'assets/less/sprite/mixins.generated.less',
				cssFormat: 'less',
				imgPath: '../img/sprite/custom.png',
				algorithm: 'binary-tree',
		        //cssVarMap: (sprite) ->
		        //sprite.name = 'sprite-' + sprite.name,
				cssOpts: {
					cssClass: function(item) {
						return ".sprite-" + item.name;
					}
				}
			}
		},		
	
		imagemin: {
		  dynamic: {
		    files: [
		      {
		        expand: true,
		        cwd: 'assets/imagemin/',
		        src: ['**/*.{png,jpg,gif}'],
		        dest: '../../../public_html/assets/img'
		      }
		    ]
		  }
		},
		
		concat_sourcemap: {
			options: {
				sourcesContent: true
			},
			top: {
				src: ["<%= files.js.top %>"],
				dest: "assets/js/generated/top.js"
			},
			app: {
				src: ["<%= files.js.app %>"],
				dest: "assets/js/generated/app.js"
			}
		},
		
		watch: {
			top: {
				files: ["<%= files.js.top %>"],
				tasks: ["concat_sourcemap:top", "uglify:top", "growl:watch"]
			},
			app: {
				files: ["<%= files.js.app %>"],
		        tasks: ["concat_sourcemap:app", "uglify:app", "growl:watch"]
			},
			less: {
		        files: ["<%= files.less.watch %>"],
		        tasks: ["less:dist", "usebanner:all", "growl:watch"]
			}
		},
		
		less: {
			options: {
				ieCompat: false
			},
			dev: {
				src: [
				      "<%= files.less.app %>"
				],
				dest: "../../../public_html/assets/css/app.css"
			},
			dist: {
				options: {
					cleancss: true,
					compress: true
				},
				src: [
				      "<%= files.less.app %>"
				],
				dest: "../../../public_html/assets/css/app.min.css"
			}
		},
		    
		uglify: {
			options: {
				banner: "<%= banner %>",
		        mangle: false, // Use if you want the names of your functions and variables unchanged
		        preserveComments: "false" // false 'all' 'some'
		        //compress: false, // con 'false' viene compresso comunque; con 'true' vengono modificate alcune funzioni 
				//sequences: true,
				//properties: true,
				//dead_code: true,
				//drop_debugger: true,
				//unsafe: false,
				//unsafe_comps: false,
				//conditionals: true,
				//comparisons: true,
				//evaluate: true,
				//booleans: true,
				//loops: true,
				//unused: true,
				//hoist_funs: true,
				//keep_fargs: false,
				//hoist_vars: false,
				//if_return: true,
				//join_vars: true,
				//cascade: true,
				//side_effects: true,
				//pure_getters: false,
				//pure_funcs: null,
				//negate_iife: true,
				//screw_ie8: false,
				//drop_console: true, // default: false
				//angular: false,
				//warnings: true,
				//global_defs: {}
			},
			top: {
		        sourceMapIn: "assets/js/generated/top.js.map",
		        sourceMap: "assets/js/generated/top.js.map",
		        src: "<%= concat_sourcemap.top.dest %>", // input from the concat_sourcemap process
		        dest: "../../../public_html/assets/js/top.min.js"
			},
			app: {
		        sourceMapIn: "assets/js/generated/app.js.map",
		        sourceMap: "assets/js/generated/app.js.map",
		        src: "<%= concat_sourcemap.app.dest %>",
		        dest: "../../../public_html/assets/js/app.min.js"
			}
		},
		    
		usebanner: {
			all: {
				options: {
					position: 'top',
					banner: "<%= banner %>",
					linebreak: false // già presente in 'banner'
		        },
		        files: {
		        	src: [
		        	      "../../../public_html/assets/css/app.min.css"
		        	]
		        }
			}
		},
		
		cssmetrics: {
			dev: {
				src: ['../../../public_html/assets/css/*.css']
				/*,
		        options: {
		            quiet: false,
		            maxSelectors: 4096, // IE <= 9
		            maxFileSize: 10240000
		        }*/
			}
		},
		
		pot: {
			options: {
				text_domain: "messages",
		        dest: "../locale/",
		        keywords: ['gettext', '_'],
		        msgmerge: true,
		        msgid_bugs_address: '<%= pkg.bugs.email %>',
		        encoding: 'UTF-8'
			},
		    files: {
		    	src: [
		    	      "../app/**/*.php"
		    	],
		    	expand: true
		    }
		},
		
	    growl : {
	    	less : {
	          title   : 'less',
	          message : 'Completed successfully'
	        },
	        watch : {
	          title   : 'watch',
	          message : 'Completed successfully'
	        }
	    }
	});
		  
	grunt.loadTasks("tasks");	
	
	require('matchdep').filterAll('grunt-*').forEach(grunt.loadNpmTasks);

	grunt.registerTask("default", ["less:dist", "growl:less", "concat_sourcemap", "uglify", "usebanner:all", "growl:watch", "watch"]);
};
