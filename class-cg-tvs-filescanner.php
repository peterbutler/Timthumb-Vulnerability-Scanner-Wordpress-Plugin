<?php

class CG_FileScanner {

	public $base_dir;
	public $errors;
	public $inventory;
	public $instances;
	public $suspicious_files;

	function __construct( $base_dir ) {
		if ( is_file( $base_dir ) || is_dir( $base_dir ) ) {
			$this->base_dir = $base_dir;
		} else {
			die();
		}
	}

  function generate_inventory() {
    $this->inventory = $this->get_dir_contents( $this->base_dir, true );
  }

	function get_dir_contents( $path ) {
		$inventory = array();
		if ( ! $dir_handle = @opendir( $path ) ) {
			$this->errors[] = "Couldn't open $path";
			return false;
		}
		while ( $file = readdir( $dir_handle ) ) {
			if ( $file == '.' || $file == '..' ) continue;
			if ( is_dir( $path . '/' . $file ) ) {
				$inventory = @array_merge( $inventory, $this->get_dir_contents( $path . '/' . $file ) );
			} else {
				$inventory[] = $path . '/' . $file; 
			}
		}
		closedir( $dir_handle );
		return $inventory;
	}


	function scan_inventory_timthumb() {	
		foreach( $this->inventory as $path ) {
			$path_parts = pathinfo( $path );
			// Don't scan this plugin's files
			if( preg_match( '~^' . dirname(__FILE__) . "~", $path ) ) {
				continue;
			}
			if( $path_parts['extension'] == 'php' ) {
				if( $file_handle = @fopen( $path, 'r' ) ) {
					$contents = @fread( $file_handle, filesize( $path ) );
					if ( preg_match( "~TimThumb script created by Tim McDaniels and Darren Hoyt|TimThumb script created by Ben Gillbanks\, originally created by Tim McDaniels and Darren Hoyt|TimThumb by Ben Gillbanks~", $contents ) ) {
						// We have a timthumb script.  Now check to see what version it is.
						preg_match( "~define\s*\(\s*[\'|\"]VERSION[\'|\"],\s*[\'|\"]([^\'|\"]*)~", $contents, $matches );
						$instance['path']    = $path;
						if(!empty($matches[1])){
  						$instance['version'] = $matches[1];
            }else{
  						$instance['version'] = 0;
            }
						$this->instances[] = $instance;
						unset($instance);
				  }
				}
			}
		}
	}
	
	function check_for_intrusion_files(){
		// This is far from foolproof.  All we're going to do is
		// look at each copy of timthumb, and check for a cache folder in the same directory
		// then look for php files inside of that.
		// This could be improved to try to actually read the DIRECTORY_CACHE constant
		// from each timthumb file, assuming they haven't already been altered.
		// I don't know how common it is to actually alter this value.
		if(!empty($this->instances)){
  		foreach($this->instances as $instance){
  			if(is_dir(dirname($instance['path']).'/cache')){
  				// We have a cache dir.  Run through the cache files
  				// to see if we have any php files.
  				$cache_files = $this->get_dir_contents(dirname($instance['path']).'/cache');
  				foreach($cache_files as $cache_file){
  					$path_parts = pathinfo($cache_file);
  					if($path_parts['extension'] == 'php' && $path_parts['basename'] != 'index.php'){
  						$this->suspicious_files[] = $cache_file;
  						echO "FOUND SUSPICIOUS FILE";						
  					}
  				}
  			}
  		}
    }
	}

}
?>