<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */
require_once $_SERVER["DOCUMENT_ROOT"] . '/wp-load.php';

class WP_Filters_Incluyeme
{
	private static $user_id;
	private static $job;
	private static $disability;
	private static $status;
	private static $searchPhrase;
	private static $city;
	private static $course;
	private static $name;
	private static $lastName;
	private static $oral;
	private static $escrito;
	private static $idioms;
	private static $education;
	private static $description;
	private static $residence;
	private static $letter;
	private static $email;
	private static $incluyemeFilters;
	private static $favs;
	private static $newIdioms;
	private static $checkLoginV;
	
	function __construct()
	{
		self::$user_id = null;
		self::$job = null;
		self::$disability = null;
		self::$status = null;
		self::$searchPhrase = null;
		self::$city = null;
		self::$course = null;
		self::$name = null;
		self::$lastName = null;
		self::$oral = null;
		self::$escrito = null;
		self::$idioms = null;
		self::$education = null;
		self::$description = null;
		self::$residence = null;
		self::$letter = null;
		self::$email = null;
		self::$newIdioms = null;
		self::$checkLoginV = false;
		self::$favs = null;
		self::$incluyemeFilters = 'incluyemeFiltersCV';
	}
	
	/**
	 * @return mixed
	 */
	public static function getFavs()
	{
		return self::$favs;
	}
	
	/**
	 * @param mixed $favs
	 */
	public static function setFavs($favs)
	{
		self::$favs = $favs;
	}
	
	/**
	 * @return mixed
	 */
	public static function getEscrito()
	{
		return self::$escrito;
	}
	
	/**
	 * @param mixed $escrito
	 */
	public static function setEscrito($escrito)
	{
		self::$escrito = $escrito;
	}
	
	/**
	 * @return mixed
	 */
	public static function getnewIdioms()
	{
		return self::$newIdioms;
	}
	
	/**
	 * @param mixed $newIdioms
	 */
	public static function setnewIdioms($newIdioms)
	{
		self::$newIdioms = $newIdioms;
	}
	
	/**
	 * @return mixed
	 */
	public static function getUserId()
	{
		return self::$user_id;
	}
	
	/**
	 * @param mixed $user_id
	 */
	public static function setUserId($user_id)
	{
		self::$user_id = $user_id;
	}
	
	/**
	 * @return mixed
	 */
	public static function getJob()
	{
		return self::$job;
	}
	
	/**
	 * @param mixed $job
	 */
	public static function setJob($job)
	{
		self::$job = $job;
	}
	
	/**
	 * @return mixed
	 */
	public static function getDisability()
	{
		return self::$disability;
	}
	
	/**
	 * @param mixed $disability
	 */
	public static function setDisability($disability)
	{
		self::$disability = $disability;
	}
	
	/**
	 * @return mixed
	 */
	public static function getStatus()
	{
		return self::$status;
	}
	
	/**
	 * @param mixed $status
	 */
	public static function setStatus($status)
	{
		self::$status = $status;
	}
	
	/**
	 * @return mixed
	 */
	public static function getSearchPhrase()
	{
		return self::$searchPhrase;
	}
	
	/**
	 * @param mixed $searchPhrase
	 */
	public static function setSearchPhrase($searchPhrase)
	{
		self::$searchPhrase = $searchPhrase;
	}
	
	/**
	 * @return mixed
	 */
	public static function getCity()
	{
		return self::$city;
	}
	
	/**
	 * @param mixed $city
	 */
	public static function setCity($city)
	{
		self::$city = $city;
	}
	
	/**
	 * @return mixed
	 */
	public static function getCourse()
	{
		return self::$course;
	}
	
	/**
	 * @param mixed $course
	 */
	public static function setCourse($course)
	{
		self::$course = $course;
	}
	
	/**
	 * @return mixed
	 */
	public static function getName()
	{
		return self::$name;
	}
	
	/**
	 * @param mixed $name
	 */
	public static function setName($name)
	{
		self::$name = $name;
	}
	
	/**
	 * @return mixed
	 */
	public static function getLastName()
	{
		return self::$lastName;
	}
	
	/**
	 * @param mixed $lastName
	 */
	public static function setLastName($lastName)
	{
		self::$lastName = $lastName;
	}
	
	/**
	 * @return mixed
	 */
	public static function getOral()
	{
		return self::$oral;
	}
	
	/**
	 * @param mixed $oral
	 */
	public static function setOral($oral)
	{
		self::$oral = $oral;
	}
	
	/**
	 * @return mixed
	 */
	public static function getIdioms()
	{
		return self::$idioms;
	}
	
	/**
	 * @param mixed $idioms
	 */
	public static function setIdioms($idioms)
	{
		self::$idioms = $idioms;
	}
	
	/**
	 * @return mixed
	 */
	public static function getEducation()
	{
		return self::$education;
	}
	
	/**
	 * @param mixed $education
	 */
	public static function setEducation($education)
	{
		self::$education = $education;
	}
	
	/**
	 * @return mixed
	 */
	public static function getDescription()
	{
		return self::$description;
	}
	
	/**
	 * @param mixed $description
	 */
	public static function setDescription($description)
	{
		self::$description = $description;
	}
	
	/**
	 * @return mixed
	 */
	public static function getResidence()
	{
		return self::$residence;
	}
	
	/**
	 * @param mixed $residence
	 */
	public static function setResidence($residence)
	{
		self::$residence = $residence;
	}
	
	/**
	 * @return mixed
	 */
	public static function getLetter()
	{
		return self::$letter;
	}
	
	/**
	 * @param mixed $letter
	 */
	public static function setLetter($letter)
	{
		self::$letter = $letter;
	}
	
	/**
	 * @return mixed
	 */
	public static function getEmail()
	{
		return self::$email;
	}
	
	/**
	 * @param mixed $email
	 */
	public static function setEmail($email)
	{
		self::$email = $email;
	}
	
	protected static function changePrefix($query, $changeData = false, $value = false)
	{
		$change = [];
		if ($changeData && is_string($changeData)) {
			$change[$changeData] = $value;
		}
		return str_replace(array_keys($change), array_values($change), $query);
	}
	
	protected function executeQueries($sql)
	{
		global $wpdb;
		return $wpdb->get_results($sql);
	}
	
	protected function changeObjectReferenceIncluyeme($obj, $property, $rename, $eliminate = false)
	{
		if (!is_string($property) || !is_string($rename) || !is_array($obj)) {
			throw new Exception('Invalid data passing to this function');
		}
		$response = [];
		foreach ($obj as $change) {
			$change->$rename = $change->$property;
			unset($change->$property);
			if ($eliminate) {
				unset($change->$eliminate);
			}
			array_push($response, $change);
		}
		return array_unique($response, SORT_REGULAR);
	}
	
	public static function addQueries($sql, $phrase = false)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		if (self::getJob() !== null) {
			$sql .= "AND " . $prefix . "wpjb_job.id = " . self::getJob() . " ";
		}
		if (self::getName() !== null) {
			$sql .= ' AND ' . $prefix . 'usermeta.meta_value Like "%' . self::getName() . '%" ';
		}
		if (self::getStatus() !== null) {
			$sql .= ' AND ' . $prefix . 'wpjb_application.status in ( %statuses% ) ';
			$sql = self::changePrefix($sql, '%statuses%', implode(',', self::getStatus()));
		}
		if (self::getResidence() !== null) {
			$sql .= ' AND ' . $prefix . 'wpjb_resume.candidate_state Like "%' . self::getResidence() . '%" ';
		}
		if (self::getCity() !== null) {
			$sql .= ' AND ' . $prefix . 'wpjb_resume.candidate_location Like "%' . self::getCity() . '%" ';
		}
		if (self::getName() !== null) {
			$sql .= ' AND ' . $prefix . 'usermeta.meta_value Like "%' . self::getName() . '%" ';
		}
		if (self::getEmail() !== null) {
			$sql .= ' AND ' . $prefix . 'users.user_email = "' . self::getEmail() . '" ';
		}
		if (self::getSearchPhrase() !== null && $phrase) {
			$sql .= ' AND ( ' . $prefix . 'usermeta.meta_value Like  "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR ' . $prefix . 'wpjb_application.status Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR ' . $prefix . 'wpjb_resume.candidate_state Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR ' . $prefix . 'wpjb_resume.candidate_location Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR ' . $prefix . 'usermeta.meta_value  Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR  edu.grantor  Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR edu.detail_title  Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR ' . $prefix . 'wpjb_resume_detail.detail_title  Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR ' . $prefix . 'wpjb_resume_detail.detail_description  Like "%' . self::getSearchPhrase() . '%" ';
			$sql .= ' OR ' . $prefix . 'users.user_email Like "%' . self::getSearchPhrase() . '%" ) ';
		}
		if (self::getLastName() !== null) {
			$sql .= ' AND lVal.meta_value Like "%' . self::getLastName() . '%" ';
		}
		if (self::getCourse() !== null) {
			$sql .= ' AND edu.detail_title Like "%' . self::getCourse() . '%" ';
		}
		if (self::getEducation() !== null) {
			$sql .= ' AND edu.grantor Like "%' . self::getEducation() . '%" ';
		}
		if (self::getDescription() !== null) {
			$sql .= ' AND  edu.detail_description Like "%' . self::getDescription() . '%" ';
		}
		if (self::getIdioms() !== null) {
			
			if (self::getOral() === null && self::getEscrito() === null) {
				$sql .= ' AND idioms.name = "' . self::getIdioms() . '" ';
				$sql .= ' AND idiomsV.value != "No hablo" ';
			}
			
		}
		if (self::$checkLoginV) {
			if (self::getnewIdioms() !== null) {
				$sql .= ' AND  ' . $prefix . 'incluyeme_users_idioms.idioms_id = "' . self::getnewIdioms() . '" ';
			}
			if (self::getOral() !== null) {
				$sql .= ' AND ' . $prefix . 'incluyeme_users_idioms.olevel = "' . self::getOral() . '" ';
			}
			if (self::getEscrito() !== null) {
				$sql .= ' AND ' . $prefix . 'incluyeme_users_idioms.wlevel =  "' . self::getEscrito() . '" ';
			}
		}
		if (self::getDisability() !== null && !self::$checkLoginV) {
			$sql .= ' AND lValue.value in ( %disability% ) ';
			$sql = self::changePrefix($sql, '%disability%', '"' . implode('","', self::getDisability()) . '"');
		}elseif (self::getDisability() !== null && self::$checkLoginV){
			$sql .= ' AND lValue.discap_name  in ( %disability% ) ';
			$sql = self::changePrefix($sql, '%disability%', '"' . implode('","', self::getDisability()) . '"');
		}
		return $sql;
	}
	
	public static function addQueriesSecondSQL($sql, $phrase = false)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		if (self::getLastName() !== null) {
			$sql .= ' AND ' . $prefix . 'usermeta.meta_value Like "%' . self::getLastName() . '%" ';
		}
		if (self::getDisability() !== null) {
			$sql .= ' AND ' . $prefix . 'wpjb_meta_value.value in ( %disability% ) ';
			$sql = self::changePrefix($sql, '%disability%', '"' . implode(',', self::getDisability()) . '"');
		}
		return $sql;
	}
	
	public static function unionObjectsIncluyeme($obj, $mix, $param, $paramMix)
	{
		
		try {
			if (!is_array($obj) || !is_array($mix) || empty($param) || empty($paramMix)) {
				throw new Exception('Invalid data passing to this function: unionObjectsIncluyeme');
			}
			$positions = [];
			for ($i = 0; $i < count($obj); $i++) {
				foreach ($mix as $itemsMix) {
					if ($obj[$i]->$param === $itemsMix->$paramMix) {
						unset($itemsMix->$paramMix);
						foreach ($itemsMix as $key => $value) {
							$obj[$i]->$key = $value;
						}
					}
				}
			}
			return $obj;
		} catch (Exception $e) {
			return $obj;
		}
	}
	
	public function deleteData($obj)
	{
		for ($i = 0; $i < count($obj); $i++) {
			$exists = array_key_exists('discap', get_object_vars($obj[$i]));
			if (!property_exists($obj[$i], 'discap') || property_exists($obj[$i], 'discap') === null || !$exists) {
				unset($obj[$i]);
			}
		}
		$obj = array_merge($obj);
		return $obj;
	}
	
	public function getCV($obj)
	{
		
		$CVS = get_option(self::$incluyemeFilters) ? get_option(self::$incluyemeFilters) : 'certificado-discapacidad';
		$path = wp_upload_dir();
		$basePath = $path['basedir'];
		$baseDir = $path['baseurl'];
		for ($i = 0; $i < count($obj); $i++) {
			$route = $basePath . '/wpjobboard/resume/' . $obj[$i]->resume_id;
			$dir = $baseDir . '/wpjobboard/resume/' . $obj[$i]->resume_id;
			if (file_exists($route)) {
				if (file_exists($route . '/cv/')) {
					$folder = @scandir($route . '/cv/');
					if (count($folder) > 2) {
						$search = opendir($route . '/cv/');
						while ($file = readdir($search)) {
							if ($file != "." and $file != ".." and $file != "index.php") {
								$obj[$i]->CV = $dir . '/cv/' . $file;
							}
						}
					} else {
						$obj[$i]->CV = false;
					}
				} else {
					$obj[$i]->CV = false;
				}
				if (file_exists($route . '/image/')) {
					$folder = @scandir($route . '/image/');
					if (count($folder) > 2) {
						$search = opendir($route . '/image/');
						while ($file = readdir($search)) {
							if ($file != "." and $file != ".." and $file != "index.php") {
								$obj[$i]->img = $dir . '/image/' . $file;
							}
						}
					} else {
						$obj[$i]->img = false;
					}
				} else {
					$obj[$i]->img = false;
				}
				if (file_exists($route . '/' . $CVS . '/')) {
					$folder = @scandir($route . '/' . $CVS . '/');
					if (count($folder) > 2) {
						$search = opendir($route . '/' . $CVS . '/');
						while ($file = readdir($search)) {
							if ($file != "." and $file != ".." and $file != "index.php") {
								$obj[$i]->CUD = $dir . '/' . $CVS . '/' . $file;
							}
						}
					} else {
						$obj[$i]->CUD = false;
					}
				} else {
					$obj[$i]->CUD = false;
				}
			} else {
				$obj[$i]->img = false;
				$obj[$i]->CUD = false;
				$obj[$i]->CV = false;
			}
		}
		return $obj;
	}
	
	public static function unionObjectsRating($obj, $mix, $param, $paramMix)
	{
		
		try {
			if (!is_array($obj) || !is_array($mix) || empty($param) || empty($paramMix)) {
				throw new Exception('Invalid data passing to this function: unionObjectsIncluyeme');
			}
			for ($i = 0; $i < count($obj); $i++) {
				foreach ($mix as $itemsMix) {
					if ($obj[$i]->$param === $itemsMix->$paramMix) {
						unset($itemsMix->$paramMix);
						foreach ($itemsMix as $key => $value) {
							$obj[$i]->$key = $value;
						}
					}
				}
			}
			return $obj;
		} catch (Exception $e) {
			return $obj;
		}
	}
	
	public static function changeStatus($id, $status, $jobs = false)
	{
		global $wpdb;
		$query = false;
		$prefix = $wpdb->prefix;
		if ($jobs !== false) {
			$query = "UPDATE " . $prefix . "wpjb_application
SET status = " . $status . "
WHERE user_id = " . $id . "
AND job_id = " . $jobs;
		} else {
			$query = "UPDATE  " . $prefix . "wpjb_application
SET status = " . $status . "
WHERE user_id = " . $id . "
AND job_id IN (SELECT
     " . $prefix . "wpjb_job.id
  FROM  " . $prefix . "wpjb_job
  LEFT JOIN " . $prefix . "wpjb_company
    ON " . $prefix . "wpjb_job.employer_id = " . $prefix . "wpjb_company.id
WHERE " . $prefix . "wpjb_company.user_id =" . self::getUserId() . ")";
		}
		if ($query) {
			$wpdb->query($query);
		}
		return;
	}
	
	public static function changeFavPub($exist = false, $id = false)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		if ($exist == 1 && $id !== false) {
			$query = "DELETE
  FROM " . $prefix . "wpjb_meta_value
WHERE object_id = (SELECT
    " . $prefix . "wpjb_application.id AS expr1
  FROM " . $prefix . "wpjb_application
    INNER JOIN " . $prefix . "wpjb_resume
      ON " . $prefix . "wpjb_application.user_id = " . $prefix . "wpjb_resume.user_id
  WHERE " . $prefix . "wpjb_resume.id = ".$id.")
  AND meta_id = (SELECT " . $prefix . "wpjb_meta.id FROM " . $prefix . "wpjb_meta WHERE " . $prefix . "wpjb_meta.name = 'rating')";

			$wpdb->query($query);
		} else {
			$query = "INSERT INTO " . $prefix . "wpjb_meta_value (meta_id, object_id, value)
  VALUES ((SELECT " . $prefix . "wpjb_meta.id FROM " . $prefix . "wpjb_meta WHERE " . $prefix . "wpjb_meta.name = 'rating'), (SELECT
   " . $prefix . "wpjb_application.id AS expr1
  FROM " . $prefix . "wpjb_application
    INNER JOIN " . $prefix . "wpjb_resume
      ON " . $prefix . "wpjb_application.user_id = " . $prefix . "wpjb_resume.user_id
  WHERE " . $prefix . "wpjb_resume.id = ". $id." LIMIT 1), 5)";
			error_log(print_r($query, true));
			$wpdb->query($query);
		}
	}
	
	protected static function checkLogin()
	{
		include_once(ABSPATH.'wp-admin/includes/plugin.php');
		self::$checkLoginV = function_exists('incluyeme_requirements_Login_Extension');
		return self::$checkLoginV;
	}
	
}

