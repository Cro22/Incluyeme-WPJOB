<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */
include 'filters/WP_Filters_Incluyeme.php';

class WP_Incluyeme extends WP_Filters_Incluyeme
{
	const VERSION = '1.0.0';
	
	function searchModifiedIncluyeme($withExtra = false)
	{
		$query = "SELECT
  %prefix%users.user_email,
  %prefix%users.display_name,
  %prefix%wpjb_resume.phone,
  %prefix%wpjb_resume.description,
  %prefix%wpjb_job.job_title,
  %prefix%posts.guid,
  %prefix%usermeta.meta_key,
%prefix%wpjb_application.status as applicant_status,
  %prefix%usermeta.meta_value,
  %prefix%wpjb_resume.candidate_state,
  %prefix%wpjb_resume.candidate_location,
  %prefix%users.ID AS users_id,
  %prefix%wpjb_application.id AS application_id,
  %prefix%wpjb_resume.id AS resume_id
FROM %prefix%wpjb_resume
  INNER JOIN %prefix%users
    ON %prefix%users.ID = %prefix%wpjb_resume.user_id
  LEFT OUTER JOIN %prefix%wpjb_resume_search
    ON %prefix%wpjb_resume.id = %prefix%wpjb_resume_search.resume_id
  LEFT OUTER JOIN %prefix%wpjb_application
    ON %prefix%wpjb_resume.user_id = %prefix%wpjb_application.user_id
  LEFT OUTER JOIN %prefix%wpjb_job
    ON %prefix%wpjb_application.job_id = %prefix%wpjb_job.id
  LEFT OUTER JOIN %prefix%wpjb_meta_value
    ON %prefix%wpjb_resume.id = %prefix%wpjb_meta_value.object_id
  LEFT OUTER JOIN %prefix%wpjb_meta
    ON %prefix%wpjb_meta_value.meta_id = %prefix%wpjb_meta.id
  LEFT OUTER JOIN %prefix%wpjb_tagged
    ON %prefix%wpjb_resume.id = %prefix%wpjb_tagged.id
  LEFT OUTER JOIN %prefix%posts
    ON %prefix%wpjb_resume.post_id = %prefix%posts.ID
  LEFT OUTER JOIN %prefix%usermeta
    ON %prefix%users.ID = %prefix%usermeta.user_id
  LEFT OUTER JOIN %prefix%wpjb_company
    ON %prefix%wpjb_job.employer_id = %prefix%wpjb_company.id
WHERE %prefix%usermeta.meta_key = 'first_name'
AND %prefix%wpjb_company.user_id = %userID% ";
		
		$group = 'GROUP BY %prefix%users.ID,
         %prefix%wpjb_application.id,
         %prefix%wpjb_resume.id,
         %prefix%usermeta.meta_key,
         %prefix%usermeta.meta_value,
         %prefix%wpjb_resume.candidate_state,
         %prefix%wpjb_resume.candidate_location';
		$query = $this->addQueries($query);
		$query .= $group;
		$results = $this->executeQueries($this->changePrefix($query));
		try {
			$response = $this->changeObjectReferenceIncluyeme($results, 'meta_value', 'first_name', 'meta_key');
			if ($withExtra && count($response) !== 0) {
				$extraData = [];
				foreach ($response as $item) {
					array_push($extraData, $item->users_id);
				}
				$extraData = $this->getExtraData($extraData);
				if (!$extraData) {
					return $response = [];
				}
				return self::unionObjectsIncluyeme($response, $extraData, 'users_id', 'ID');
			}
			return $response = [];
		} catch (Exception $e) {
			throw new Exception('Invalid data passing to this function: searchModifiedIncluyeme' . $e);
		}
	}
	
	private function getExtraData($userId)
	{
		$query = 'SELECT
  %prefix%wpjb_meta.name,
  %prefix%wpjb_meta_value.value,
  %prefix%usermeta.meta_key,
  %prefix%usermeta.meta_value,
%prefix%users.ID
FROM  %prefix%wpjb_resume
  INNER JOIN %prefix%users
    ON %prefix%users.ID = %prefix%wpjb_resume.user_id
  LEFT JOIN %prefix%wpjb_resume_search
    ON %prefix%wpjb_resume.id = %prefix%wpjb_resume_search.resume_id
  LEFT JOIN %prefix%wpjb_application
    ON %prefix%wpjb_resume.user_id = %prefix%wpjb_application.user_id
  LEFT JOIN %prefix%wpjb_job
    ON %prefix%wpjb_application.job_id = %prefix%wpjb_job.id
  LEFT JOIN %prefix%wpjb_meta_value
    ON %prefix%wpjb_resume.id = %prefix%wpjb_meta_value.object_id
  LEFT JOIN %prefix%wpjb_meta
    ON %prefix%wpjb_meta_value.meta_id = %prefix%wpjb_meta.id
  LEFT JOIN %prefix%wpjb_tagged
    ON %prefix%wpjb_resume.id = %prefix%wpjb_tagged.id
  LEFT JOIN %prefix%posts
    ON %prefix%wpjb_resume.post_id = %prefix%posts.ID
  LEFT JOIN %prefix%usermeta
    ON %prefix%users.ID = %prefix%usermeta.user_id
  LEFT JOIN %prefix%wpjb_company
    ON %prefix%wpjb_job.employer_id = %prefix%wpjb_company.id
WHERE %prefix%wpjb_meta.name = \'tipo_discapacidad\'
AND %prefix%usermeta.meta_key = \'last_name\'
  AND %prefix%wpjb_company.user_id = %userID%
  AND %prefix%users.ID in (%resume%)';
		
		$group = 'GROUP BY %prefix%users.user_email,
         %prefix%users.display_name,
         %prefix%wpjb_resume.phone,
         %prefix%wpjb_resume.description,
         %prefix%wpjb_application.applicant_name,
         %prefix%wpjb_job.job_title,
         %prefix%posts.guid,
         %prefix%wpjb_meta.name,
         %prefix%wpjb_meta_value.value,
         %prefix%usermeta.meta_key,
         %prefix%usermeta.meta_value,
         %prefix%wpjb_resume.candidate_state,
         %prefix%wpjb_resume.candidate_location';
		$query = $this->addQueriesSecondSQL($query);
		$query .= $group;
		$result = $this->executeQueries($this->changePrefix($query, '%resume%', implode(',', $userId)));
		try {
			if (count($result) === 0) {
				return false;
			}
			$result = $this->changeObjectReferenceIncluyeme($result, 'meta_value', 'last_name', 'meta_key');
			$result = $this->changeObjectReferenceIncluyeme($result, 'name', 'type_discap', 'meta_key');
			$result = $this->changeObjectReferenceIncluyeme($result, 'value', 'discap', 'meta_key');
			return $result;
		} catch (Exception $e) {
			throw new Exception('Invalid data passing to this function: getExtraData' . $e);
		}
	}
}