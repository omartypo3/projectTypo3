var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function(){
   return  gulp.src('typo3conf/ext/softtodo_theme/Resources/Private/Styles/scss/style.scss')
           .pipe(sass().on('error', sass.logError))
           .pipe(gulp.dest('typo3conf/ext/softtodo_theme/Resources/Public/Styles'));
});

gulp.task('watch', function() {
    gulp.watch('typo3conf/ext/softtodo_theme/Resources/Private/Styles/scss/**/*.scss', gulp.parallel('sass'));
});

gulp.task('default', gulp.series('sass', 'watch', function(done) {
    // do more stuff
    done();
}));

