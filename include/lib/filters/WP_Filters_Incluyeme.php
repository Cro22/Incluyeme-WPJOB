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
	private static $idioms;
	private static $education;
	private static $description;
	private static $residence;
	private static $letter;
	private static $email;
	
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
		self::$idioms = null;
		self::$education = null;
		self::$description = null;
		self::$residence = null;
		self::$letter = null;
		self::$email = null;
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
	public static function setUserId($user_id): void
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
	public static function setJob($job): void
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
	public static function setDisability($disability): void
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
	public static function setStatus($status): void
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
	public static function setSearchPhrase($searchPhrase): void
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
	public static function setCity($city): void
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
	public static function setCourse($course): void
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
	public static function setName($name): void
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
	public static function setLastName($lastName): void
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
	public static function setOral($oral): void
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
	public static function setIdioms($idioms): void
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
	public static function setEducation($education): void
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
	public static function setDescription($description): void
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
	public static function setResidence($residence): void
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
	public static function setLetter($letter): void
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
	public static function setEmail($email): void
	{
		self::$email = $email;
	}
	
	function searchModifiedIncluyeme()
	{
		global $wpdb;
		$results = $wpdb->get_results('SELECT
  wp_users.user_email,
  wp_users.display_name,
  wp_wpjb_resume.phone,
  wp_wpjb_resume.description,
  wp_wpjb_job.job_title,
  wp_posts.guid,
  wp_usermeta.meta_key,
  wp_usermeta.meta_value,
  wp_wpjb_resume.candidate_state,
  wp_wpjb_resume.candidate_location,
  wp_users.ID AS users_id,
  wp_wpjb_application.id AS application_id,
  wp_wpjb_resume.id AS resume_id
FROM wp_wpjb_resume
  INNER JOIN wp_users
    ON wp_users.ID = wp_wpjb_resume.user_id
  LEFT OUTER JOIN wp_wpjb_resume_search
    ON wp_wpjb_resume.id = wp_wpjb_resume_search.resume_id
  LEFT OUTER JOIN wp_wpjb_application
    ON wp_wpjb_resume.user_id = wp_wpjb_application.user_id
  LEFT OUTER JOIN wp_wpjb_job
    ON wp_wpjb_application.job_id = wp_wpjb_job.id
  LEFT OUTER JOIN wp_wpjb_meta_value
    ON wp_wpjb_resume.id = wp_wpjb_meta_value.object_id
  LEFT OUTER JOIN wp_wpjb_meta
    ON wp_wpjb_meta_value.meta_id = wp_wpjb_meta.id
  LEFT OUTER JOIN wp_wpjb_tagged
    ON wp_wpjb_resume.id = wp_wpjb_tagged.id
  LEFT OUTER JOIN wp_posts
    ON wp_wpjb_resume.post_id = wp_posts.ID
  LEFT OUTER JOIN wp_usermeta
    ON wp_users.ID = wp_usermeta.user_id
  LEFT OUTER JOIN wp_wpjb_company
    ON wp_wpjb_job.employer_id = wp_wpjb_company.id
WHERE wp_usermeta.meta_key = \'first_name\'
AND wp_wpjb_company.user_id = 2
GROUP BY wp_users.ID,
         wp_wpjb_application.id,
         wp_wpjb_resume.id,
         wp_usermeta.meta_key,
         wp_usermeta.meta_value,
         wp_wpjb_resume.candidate_state,
         wp_wpjb_resume.candidate_location');
		
		return $results;
	}
}