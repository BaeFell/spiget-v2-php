<?php

//
// A simple way to easily access the Spiget.org API
// Created by BaeFell
// All Rights Reserved
//

class SpigetCore {
	
	// external variables
	public static $throw_errors = true;
	public static $return_array = true;
	public static $user_agent = "PHP Class for Spiget.org API (V2) by BaeFell";
	public static $last;

	// internal variables
	protected static $spiget_url = "https://api.spiget.org/v2/";
	protected static $data = array();
	protected static $params = array();
	protected static $request;

	function __construct($user_agent = null) {
		if(!is_null($user_agent)) {
			self::$user_agent = $user_agent;
		}
	}

	function make_request($ending) {
		$options = array('http' => array('user_agent' => self::$user_agent));
		$context = stream_context_create($options);

		$request = self::$spiget_url . $ending;

		$response = @file_get_contents($request, false, $context);
		if(!isset($response) || is_null($response)) {
			if(self::throw_errors) {
				throw new Exception("Response from Spiget.org was not set or null", 1);
			} else {
				return array();
			}
		}
		$this->clear();

		return json_decode($response, self::$return_array);
	}

	public function set($variable, $value) {
		self::$data[$variable] = $value;
	}

	public function param($variable, $value) {
		self::$params[$variable] = $value;
	}

	public function dataGet($variable) {
		return self::$data[$variable];
	}

	public function paramsGet($variable) {
		return self::$params[$variable];
	}

	public function dataDelete($variable) {
		unset(self::$data[$variable]);
	}

	public function paramsDelete($variable) {
		unset(self::$params[$variable]);
	}

	public function clear() {
		self::$data = array();
		self::$params = array();
	}

	public function getData() {
		return self::$data;
	}

	public function getParams() {
		return self::$params;
	}

	public function getLast() {
		return self::$last;
	}

	public function execute() {
		if(empty(self::$data)) {
			if(self::throw_errors) {
				throw new Exception("No request was set (URL ending)", 1);
			} else {
				return array();
			}
		} else {
			$ending = self::$request;
			foreach($this->getData() as $key => $value) {
				$ending .= "/" . $value;
			}

			foreach($this->getParams() as $key => $value) {
				if(!isset($firstdone)) {
					$ending .= "?" . $key . "=" . $value;
					$firstdone = true;
				} else {
					$ending .= "&" . $key . "=" . $value;
				}
			}
			$result = $this->make_request($ending);
			self::$last = $result;
			return $result;
		}
	}

	public function request($request) {
		self::$request = $request;
	}

}
