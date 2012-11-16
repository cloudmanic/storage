<?php

//
// Company: Cloudmanic Labs, http://cloudmanic.com
// By: Spicer Matthews, spicer@cloudmanic.com
// Date: 9/17/2011
// Description: An abstract class for interfacing with different
//							cloudstorage solutions. 
//

namespace Cloudmanic\Storage;

class Storage 
{
	private $_driver = FALSE;
	private $_config = array();
	
	//
	// Constructor, pass in the driver name, and auth info.
	//
	function __construct($driver, $username, $key)
	{
		$this->load_driver($driver, $username, $key);
	}
	
	//
	// Set wich driver we are going to use for this
	// instance of the Storage class.
	//
	function load_driver($driver, $username, $key)
	{
		switch(strtolower($driver))
		{
			case 'amazon-s3': 
				//$this->_CI->load->library('amazon_s3_driver');
				//$this->_driver = 'amazon_s3_driver';
			break;
			
			case 'rackspace-cf':
				$this->_driver = new RackspaceCfDriver($username, $key);
			break;
		}
		
		return 0;
	}
	
	//
	// Create a container.
	//
	function create_container($cont, $acl = 'private')
	{
		return $this->_driver->create_container($cont, $acl);	
	}

	//
	// Delete a container.
	//
	function delete_container($cont)
	{
		return $this->_driver->delete_container($cont);	
	}
	
	//
	// List all containers.
	//
	function list_containers()
	{
		return $this->_driver->list_containers();
	}
	
	//
	// List all files.
	//
	function list_files($cont)
	{
		return $this->_driver->list_files($cont);
	}
	
	//
	// Upload file.
	//
	function upload_file($cont, $path, $name, $type = NULL, $acl = 'private', $metadata = array())
	{
		return $this->_driver->upload_file($cont, $path, $name, $type, $acl, $metadata);
	}
	
	//
	// Delete file.
	//
	function delete_file($container, $file)
	{
		return $this->_driver->delete_file($container, $file);		
	}
	
	//
	// Get private url to a file. This is a url with a session hash.
	// The URL expires after a short period of time.
	//
	function get_authenticated_url($cont, $file, $seconds)
	{
		return $this->_driver->get_authenticated_url($cont, $file, $seconds);
	}
}

/* End File */