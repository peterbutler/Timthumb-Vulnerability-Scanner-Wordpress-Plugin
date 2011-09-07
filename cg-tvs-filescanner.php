<?php

class CG_FileScanner {

	public $BaseDir;
	public $Errors;
	public $Inventory;
	public $VulnerableFiles;
	public $SafeFiles;

	function __construct( $base_dir ) {
		if ( is_file( $base_dir ) || is_dir( $base_dir ) ) {
			$this->BaseDir = $base_dir;
		} else {
			die();
		}
	}

  function generate_inventory() {
    $this->Inventory = $this->get_dir_contents( $this->BaseDir, true );
  }

function get_dir_contents( $path ) {
	$inventory = array();
	if ( ! $dir_handle = @opendir( $path ) ) {
		$this->Errors[] = "Couldn't open $path";
		return false;
	}
	while ( $file = readdir( $dir_handle ) ) {
		if ( $file == '.' || $file == '..' ) continue;
		if ( is_dir( $path . '/' . $file ) ) {
			$inventory = array_merge( $inventory, $this->get_dir_contents( $path . '/' . $file ) );
		} else {
			$inventory[] = $path . '/' . $file; 
		}
	}
	closedir( $dir_handle );
	return $inventory;
}

function file_stat( $file ) {
	$file_info['path']  = $file;
	if( is_dir( $file ) ) {
		$file_info['type'] = 'directory';
	}else{
		$file_info['type'] = 'file';
	}

	$file_info['readable'] = is_readable( $file );
	if ( $this->Type == 'structure' ) {
		if ( $file_info['type'] == 'directory' ) {
			$dir_stat = $this->dir_stat( $file );
			$file_info['mtime']       = $dir_stat['mtime'];
			$file_info['child_nodes'] = $dir_stat['child_nodes'];
			$file_info['ctime']       = filectime( $file );
			$file_info['atime']       = fileatime( $file );
			return $file_info;
		} else {
			return '';
		}
	}

	if ( $this->Type != 'index' && $this->Type != 'structure' ) {
		$file_info['mtime'] = filemtime( $file );
		$file_info['ctime'] = filectime( $file );
		$file_info['atime'] = fileatime( $file );
		$file_info['size']  = filesize( $file );
		$file_info['hash']  = md5_file( $file );
	}

	return $file_info;
}

function scan_inventory() {
    $pattern_1 = "TimThumb script created by Tim McDaniels and Darren Hoyt|TimThumb script created by Ben Gillbanks\, originally created by Tim McDaniels and Darren Hoyt|TimThumb by Ben Gillbanks";
	$pattern_2 = 'define\s*\(\'VERSION\',\s*\'[23456789]\.[0-9]';

	foreach( $this->Inventory as $path ) {
		$path_parts = pathinfo( $path );
		// Don't scan this plugin's files
		if( preg_match( '~^' . dirname(__FILE__) . "~", $path ) ) {
			continue;
		}
		if( $path_parts['extension'] == 'php' ) {
			if( $file_handle = @fopen( $path, 'r' ) ) {
				$contents = @fread( $file_handle, filesize( $path ) );
				if ( preg_match( "~$pattern_1~", $contents ) ) {
					// We have a timthumb script.  Now check to see if it is version 2.0 or greater.
					if ( ! preg_match( "~$pattern_2~", $contents ) ) {
						$this->VulnerableFiles[] = $path;
					} else {
						$this->SafeFiles[] = $path;
					}
				}
			}
		}
	}
}

}
?>