'use strict'

var gulp = require('gulp'),
    livereload = require('gulp-livereload'),
    compass = require('gulp-compass'),
    cssnano = require('gulp-cssnano'),
    jshint = require('gulp-jshint'),
    stylish = require('jshint-stylish'),
    inject = require('gulp-inject'),
    wiredep = require('wiredep').stream,
    gulpif = require('gulp-if'),
    useref = require('gulp-useref'),
    uglify = require('gulp-uglify'),
    uncss = require('gulp-uncss'),
    clean = require('gulp-clean')

var paths = {
  compass: ['./app/sass/**/*.scss']
}

// Pre-procesa archivos Sass a CSS y recarga los cambios
gulp.task('compass', function(){
  gulp.src(paths.compass)
    .pipe(compass({
      css: './app/css/',
      sass: './app/sass/',
      image: './app/images/',
      font: './app/fonts/'
    }))
    .pipe(gulp.dest('./app/css'))
    .pipe(livereload())
})

// Recarga el navegador cuando hay cambios en el HTML
gulp.task('html', function(){
  gulp.src(['./app/*.html'])
    .pipe(livereload())
})

// Busca errores en el JS y nos los muestra por pantalla
gulp.task('jshint', function(){
  return gulp.src('./app/js/**/*.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jshint.reporter('fail'))
})

// Busca en las carpetas de estilos y javascript los archivos que hayamos creado
// para inyectarlos en el default.html
gulp.task('inject', function(){
  var target = gulp.src('./app/*.html')

  return target.pipe(inject(gulp.src('./app/css/**/*.css', {read: false}), {relative: true}))
    .pipe(inject(gulp.src('./app/js/**/*.js', {read: false}), {relative: true}))
    .pipe(gulp.dest('./app'))
})

// Inyecta las librerias que instalamos vía Bower
gulp.task('wiredep', function(){
  gulp.src('./app/**/*.html')
    .pipe(wiredep({
      directory: './app/lib'
    }))
    .pipe(gulp.dest('./app'))
})

// Comprime los archivos CSS y JS enlazados en el default.html
//  y los minifica
gulp.task('compress', function()  {
  //gulp.src('./app/**/*.html')
  gulp.src('./app/*.html')
    .pipe(useref())
    .pipe(gulpif('*.js',  uglify()))
    //.pipe(gulpif('*.js',  uglify({mangle: false })))
    .pipe(gulpif('*.css', cssnano()))
    .pipe(gulp.dest('./public'))
})

// Elimina el CSS que no es utilizado para reducir el peso del archivo
gulp.task('uncss', ['compress'], function(){
  gulp.src('./public/css/style.min.css')
    .pipe(uncss({
      html: [
        './public/index.html',
      ]
    }))
    .pipe(gulp.dest('./public/css'))
})

// Copia el contenido de los estáticos e default.html al directorio
// de producción sin tags de comentarios
gulp.task('copy', ['uncss'], function(){
  //gulp.src('./app/**/*.html')
  gulp.src('./app/*.html')
    .pipe(useref())
    .pipe(gulp.dest('./public'))
  gulp.src('./app/images/**')
    .pipe(gulp.dest('./public/images'))
  gulp.src('./app/fonts/**')
    .pipe(gulp.dest('./public/fonts'))
  gulp.src('./app/lib/bootstrap/fonts/**')
    .pipe(gulp.dest('./public/fonts'))
})

// Copia el contenido de los estáticos al directorio
// de producción de wp sin tags de comentarios
gulp.task('copywp', function(){
  gulp.src('./public/css/**')
    .pipe(gulp.dest('./wp-content/themes/muni/css'))
  gulp.src('./public/js/**')
    .pipe(gulp.dest('./wp-content/themes/muni/js'))
  gulp.src('./public/images/**')
    .pipe(gulp.dest('./wp-content/themes/muni/images'))
  gulp.src('./public/fonts/**')
    .pipe(gulp.dest('./wp-content/themes/muni/fonts'))
})

gulp.task('watch', function(){
  livereload.listen()
  gulp.watch(['./app/**/*.html'], ['html'])
  gulp.watch(paths.compass, ['compass', 'inject'])
  //gulp.watch(['./app/js/**/*.js'], ['inject'])
  gulp.watch(['./app/js/**/*.js'], ['jshint', 'inject'])
  // gulp.watch(['./bower.json'], ['wiredep'])
})

gulp.task('cleanpublic', function(){
  return gulp.src([
      'public/js',
      'public/css',
      'public/images/',
      'public/fonts',
      'public/*.html'
    ], {read: false})
    .pipe(clean())
})

gulp.task('cleanwp', function(){
  return gulp.src([
    'wp-content/themes/muni/js/app.min.js',
    'wp-content/themes/muni/js/vendor.min.js',
    'wp-content/themes/muni/images',
    'wp-content/themes/muni/fonts',
    'wp-content/themes/muni/css/style.min.css',
    ], {read: false})
    .pipe(clean())
})

gulp.task('default', ['inject', 'watch'])
// gulp.task('default', ['inject', 'wiredep', 'watch'])

gulp.task('dev', ['watch'])
gulp.task('bower', ['wiredep'])

gulp.task('build', ['copy'])
gulp.task('buildwp', ['copywp'])

gulp.task('del', ['cleanpublic', 'cleanwp'])
