<?php 
if( !class_exists("Tools") ){
	class Tools{
		public static function getValue( $key, $value='' ){
			return isset($_REQUEST[$key])?$_REQUEST[$key]:$value;
		}
	}
}

if( !defined("PAV_FRAMEWORK_WIDGET_DIR") ){
	define( "PAV_FRAMEWORK_WIDGET_DIR", DIR_SYSTEM. 'pavothemes/widget/' );
}
require_once( DIR_SYSTEM.'pavothemes/form.php' );
require_once( DIR_SYSTEM.'pavothemes/widgetbase.php' );
require_once( DIR_SYSTEM . 'pavothemes/widget.php' );

class PavWidgetHelper{
	public static function loadWidget( $type, $registry ){
		if( file_exists(PAV_FRAMEWORK_WIDGET_DIR.$type.'.php') ){
		//	require_once( PAV_FRAMEWORK_WIDGET_DIR.$type.'.php' );
			$class = "PtsWidget".ucfirst($type);	
			if( class_exists($class) ){
				$obj = new $class( $registry ); 
				PavWidgets::add_widget( $type, array($obj, 'widgetRender') );

				return $obj; 
			}
		}
		return null;
	}

		public static function loadWidgets( $registry ){  
	 
			$wengines = glob( PAV_FRAMEWORK_WIDGET_DIR.'*.php' );
			foreach( $wengines as $w ){

				$t = str_replace( ".php", "", basename($w) );
				$class = "PtsWidget".ucfirst($t);	
				if( class_exists($class) ){
					$o = new $class( $registry ); 
					$widgets[$t] = $o;
				}
			}
			return  $widgets;
			
		}

}


class PavWidgetLoader {
	/**
	 * Base paths to search for class file.
	 *
	 * @var  array
	 */
	protected static $paths = array();

	/**
	 * Register base path to search for class files.
	 *
	 * @param   string  $path    Base path.
	 * @param   string  $prefix  Class prefix.
	 *
	 * @return  void
	 */
	public static function register( $path, $prefix = 'WR_' ) {
		// Allow one base directory associates with more than one class prefix
		if ( ! isset( self::$paths[ $path ] ) ) {
			self::$paths[ $path ] = array( $prefix );
		} elseif ( ! in_array( $prefix, self::$paths[ $path ] ) ) {
			self::$paths[ $path ][] = $prefix;
		}
	}

	/**
	 * Loader for WR Library classes.
	 *
	 * @param   string  $className  Name of class.
	 *
	 * @return  void
	 */
	public static function load( $className ) {   
		// Only autoload class name prefixed with WR_
		if ( 0 === strpos( $className, 'PtsWidget' ) ) { 
 

			// Loop thru base directory to find class declaration file
			foreach ( array_reverse( self::$paths ) AS $base => $prefixes ) {
				// Loop thru all class prefix to find appropriate class declaration file
				foreach ( array_reverse( $prefixes ) as $prefix ) {
					// Check if requested class name match a supported class prefix
					if ( 0 === strpos( $className, $prefix ) ) {
						// Split the class name into parts separated by underscore character
						$path = strtolower( trim( str_replace( $prefix, '', $className ) ) );
					 

						// Check if class file exists
						$file  = $path . '.php';
						$slave = $path . '/' . basename( $path ) . '.php';

						while ( true ) {
							$exists = false;

							// Check if file exists
							if ( @is_file( $base . '/' . $file ) ) {
								$exists = $file;
							}

							if ( $exists ) {
								break;
							}

							// Check if alternative file exists
							if ( @is_file( $base . '/' . $slave ) ) {
								$exists = $slave;
							}

							if ( $exists ) {
								break;
							}

							// If there is no any alternative file, quit the loop
							if ( false === strrpos( $file, '/' ) || 0 === strrpos( $file, '/' ) ) {
								break;
							}

							// Generate further alternative files
							$file  = preg_replace( '#/([^/]+)$#', '-\\1', $file );
							$slave = dirname( $file ) . '/' . substr( basename( $file ), 0, -4 ) . '/' . basename( $file );
						}

						if ( $exists ) {
							return include_once $base . '/' . $exists;
						}
					}
				}
			}
			return false;
		}
	}

	/**
	 * Search a file in registered paths.
	 *
	 * @param   string  $file  Relative file path to search for.
	 *
	 * @return  string
	 */
	public static function get_path( $file ) {
		// Generate alternative file name
		$slave = str_replace( '_', '-', $file );

		// Filter paths to search for file
		self::$paths = apply_filters( 'wr_pb_loader_get_path', self::$paths );

		foreach ( array_reverse( self::$paths ) AS $base => $prefixes ) {
			if ( @is_file( $base . '/' . $slave ) ) {
				return $base . '/' . $slave;
			} elseif ( @is_file( $base . '/' . $file ) ) {
				return $base . '/' . $file;
			}
		}
		return null;
	}
}

// Register class autoloader with PHP
spl_autoload_register( array( 'PavWidgetLoader', 'load' ) );
 // Register base path to look for class file
PavWidgetLoader::register( dirname( __FILE__ ).'/widget', 'PtsWidget' );

?>