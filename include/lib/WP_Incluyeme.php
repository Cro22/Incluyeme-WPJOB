<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */
include 'filters/WP_Filters_Incluyeme.php';

class WP_Incluyeme extends WP_Filters_Incluyeme
{
    const VERSION = '1.8.0';
    public $resultsNumbers = 1;
    
    function searchModifiedIncluyeme($withExtra = false)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $query = "SELECT   {$prefix}users.ID            AS users_id,
       {$prefix}users.user_email,
         {$prefix}users.display_name,
         {$prefix}wpjb_resume.phone,
         {$prefix}wpjb_job.job_title,
         {$prefix}posts.guid,
         {$prefix}usermeta.meta_value AS first_name,
         {$prefix}usermeta.meta_key,
         {$prefix}wpjb_resume.candidate_state,
         {$prefix}wpjb_resume.candidate_location,
         {$prefix}wpjb_resume.id      AS resume_id,
       lVal.meta_value        AS last_name
                FROM   {$prefix}wpjb_resume
                         LEFT JOIN   {$prefix}users
                                   ON   {$prefix}users.ID =   {$prefix}wpjb_resume.user_id
                         LEFT JOIN   {$prefix}wpjb_application
                                   ON   {$prefix}wpjb_resume.user_id =   {$prefix}wpjb_application.user_id
                         LEFT JOIN   {$prefix}wpjb_job
                                   ON   {$prefix}wpjb_application.job_id =   {$prefix}wpjb_job.id
                         LEFT OUTER JOIN   {$prefix}posts
                                         ON   {$prefix}wpjb_resume.post_id =   {$prefix}posts.ID
                         INNER JOIN   {$prefix}usermeta
                                    ON   {$prefix}users.ID =   {$prefix}usermeta.user_id
                                        AND   {$prefix}usermeta.meta_key = 'first_name'
                         LEFT OUTER JOIN   {$prefix}wpjb_company
                                         ON   {$prefix}wpjb_job.employer_id =   {$prefix}wpjb_company.id
                         LEFT OUTER JOIN   {$prefix}usermeta lVal
                                         ON   {$prefix}users.ID = lVal.user_id
                                             AND lVal.meta_key = 'last_name'
                WHERE {$prefix}wpjb_company.user_id = " . self::getUserId();
        if ($this->getSearchPhrase() !== null) {
            $queries = $this->addQueries($query, true);
        } else {
            $queries = $this->addQueries($query);
        }
        $queries = $queries . " LIMIT " . ($this->resultsNumbers - 1) * 10 . ", 10";
        
        $results = $this->executeQueries($queries);
        try {
            if (count($results) !== 0) {
                $response = $this->getCV($results);
                foreach ($response as $key => $search) {
                    $rating = $this->getExtraRating($response[$key]->users_id);
                    if ($rating !== false) {
                        $response[$key]->rating = $rating[0]->rating;
                    } else {
                        if (self::getFavs()) {
                            unset($response[$key]);
                            
                        } else {
                            $response[$key]->rating = false;
                        }
                    }
                }
                if (self::getFavs()) {
                    $response = array_values($response);
                }
                foreach ($response as $key => $search) {
                    $work = $this->getWork($response[$key]->resume_id);
                    $capacities = $this->getCapacities($response[$key]->resume_id);
                    $getStatusUser = $this->getStatusUser($response[$key]->resume_id);
                    $getEducationUser = $this->getEducationUser($response[$key]->resume_id);
                    if ($work !== false) {
                        $response[$key]->contratante = $work[0]->contratante;
                        $response[$key]->puesto = $work[0]->puesto;
                    }
                    if ($capacities !== false) {
                        self::$checkLoginV ? $response[$key]->nValueN = $capacities[0]->nValueN
                            : $response[$key]->discap = $capacities[0]->discap;
                    }
                    if ($getStatusUser !== false) {
                        $response[$key]->applicant_status = $getStatusUser[0]->applicant_status;
                    } else {
                        $response[$key]->applicant_status = 1;
                    }
                    if ($getEducationUser !== false) {
                        $response[$key]->academia = $getEducationUser[0]->academia;
                        $response[$key]->titulo = $getEducationUser[0]->titulo;
                    }
                }
                return $response;
            }
            return $response = [];
        } catch (Exception $e) {
            throw new Exception('Invalid data passing to this function: searchModifiedIncluyeme' . $e);
        }
    }
    
    private function getExtraRating($userId)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $query = 'SELECT
  ' . $prefix . 'wpjb_meta_value.value as rating,
' . $prefix . 'users.ID as users_id
FROM  ' . $prefix . 'wpjb_resume
  INNER JOIN ' . $prefix . 'users
    ON ' . $prefix . 'users.ID = ' . $prefix . 'wpjb_resume.user_id
  LEFT JOIN ' . $prefix . 'wpjb_resume_search
    ON ' . $prefix . 'wpjb_resume.id = ' . $prefix . 'wpjb_resume_search.resume_id
  LEFT JOIN ' . $prefix . 'wpjb_application
    ON ' . $prefix . 'wpjb_resume.user_id = ' . $prefix . 'wpjb_application.user_id
  LEFT JOIN ' . $prefix . 'wpjb_job
    ON ' . $prefix . 'wpjb_application.job_id = ' . $prefix . 'wpjb_job.id
  LEFT JOIN ' . $prefix . 'wpjb_meta_value
    ON (' . $prefix . 'wpjb_application.id = ' . $prefix . 'wpjb_meta_value.object_id)
  LEFT JOIN ' . $prefix . 'wpjb_meta
    ON ' . $prefix . 'wpjb_meta_value.meta_id = ' . $prefix . 'wpjb_meta.id
  LEFT JOIN ' . $prefix . 'wpjb_tagged
    ON ' . $prefix . 'wpjb_resume.id = ' . $prefix . 'wpjb_tagged.id
  LEFT JOIN ' . $prefix . 'posts
    ON ' . $prefix . 'wpjb_resume.post_id = ' . $prefix . 'posts.ID
  LEFT JOIN ' . $prefix . 'usermeta
    ON ' . $prefix . 'users.ID = ' . $prefix . 'usermeta.user_id
  LEFT JOIN ' . $prefix . 'wpjb_company
    ON ' . $prefix . 'wpjb_job.employer_id = ' . $prefix . 'wpjb_company.id
WHERE ' . $prefix . 'wpjb_meta.name = "rating"
  AND ' . $prefix . 'wpjb_company.user_id = ' . self::getUserId() . '
  AND ' . $prefix . 'users.ID = ' . $userId . ' ';
        
        $group = 'GROUP BY ' . $prefix . 'users.user_email,
         ' . $prefix . 'users.display_name,
         ' . $prefix . 'wpjb_resume.phone,
         ' . $prefix . 'wpjb_resume.description,
         ' . $prefix . 'wpjb_application.applicant_name,
         ' . $prefix . 'wpjb_job.job_title,
         ' . $prefix . 'posts.guid,
         ' . $prefix . 'wpjb_meta.name,
         ' . $prefix . 'wpjb_meta_value.value,
         ' . $prefix . 'usermeta.meta_key,
         ' . $prefix . 'usermeta.meta_value,
         ' . $prefix . 'wpjb_resume.candidate_state,
         ' . $prefix . 'wpjb_resume.candidate_location,
          ' . $prefix . 'users.ID  LIMIT 1';
        $query .= $group;
        $result = $this->executeQueries($query);
        try {
            if (count($result) === 0) {
                return false;
            }
            return $result;
        } catch (Exception $e) {
            throw new Exception('Invalid data passing to this function: getExtraData' . $e);
        }
    }
    
    private function getWork($userId)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $workQuery = "SELECT
                      {$prefix}wpjb_resume_detail.resume_id,
                      {$prefix}wpjb_resume_detail.grantor AS contratante,
                      {$prefix}wpjb_resume_detail.detail_title AS puesto
                    FROM {$prefix}wpjb_resume_detail
                      WHERE 1 = {$prefix}wpjb_resume_detail.type
                      AND resume_id = {$userId}
                      LIMIT 1";
        $result = $this->executeQueries($workQuery);
        try {
            if (count($result) === 0) {
                return false;
            }
            return $result;
        } catch (Exception $e) {
            throw new Exception('Invalid data passing to this function: getWork' . $e);
        }
    }
    
    private function getCapacities($userId)
    {
        
        global $wpdb;
        $prefix = $wpdb->prefix;
        if (self::getDisability() !== null && self::$checkLoginV) {
            $query = "SELECT
                      {$prefix}incluyeme_discapacities.discap_name AS nValueN,
                      {$prefix}wpjb_meta_value.value AS discap
                    FROM {$prefix}incluyeme_users_dicapselect
                           INNER JOIN {$prefix}incluyeme_discapacities
                             ON {$prefix}incluyeme_users_dicapselect.discap_id = {$prefix}incluyeme_discapacities.id,
                         {$prefix}wpjb_meta
                           INNER JOIN {$prefix}wpjb_meta_value
                             ON {$prefix}wpjb_meta.id = {$prefix}wpjb_meta_value.meta_id
                             AND {$prefix}wpjb_meta.name = 'tipo_discapacidad'
                    WHERE {$prefix}wpjb_meta_value.object_id = {$userId} AND
                          {$prefix}wpjb_meta_value.value IN (%disability%) OR
      {$prefix}incluyeme_discapacities.discap_name  in ( %disability% ) LIMIT 1";
            $query .= " ";
            $query = self::changePrefix($query, '%disability%', '"' . implode('","', self::getDisability()) . '"');
        } else if (self::getDisability() && !self::$checkLoginV) {
            $query = "SELECT
                      {$prefix}wpjb_meta_value.value AS discap
                    FROM {$prefix}wpjb_meta
                      INNER JOIN {$prefix}wpjb_meta_value
                        ON {$prefix}wpjb_meta.id = {$prefix}wpjb_meta_value.meta_id
                        AND {$prefix}wpjb_meta.name = 'tipo_discapacidad'
                    WHERE {$prefix}wpjb_meta_value.object_id = {$userId} AND {$prefix}wpjb_meta_value.value IN (%disability%) LIMIT 1 ";
            $query = self::changePrefix($query, '%disability%', '"' . implode('","', self::getDisability()) . '"');
        } else {
            $query = "SELECT
                      {$prefix}wpjb_meta_value.value AS discap
                    FROM {$prefix}wpjb_meta
                      INNER JOIN {$prefix}wpjb_meta_value
                        ON {$prefix}wpjb_meta.id = {$prefix}wpjb_meta_value.meta_id
                        AND {$prefix}wpjb_meta.name = 'tipo_discapacidad'
                    WHERE {$prefix}wpjb_meta_value.object_id = {$userId} LIMIT 1 ";
        }
        $result = $this->executeQueries($query);
        try {
            if (count($result) === 0) {
                return false;
            }
            return $result;
        } catch (Exception $e) {
            throw new Exception('Invalid data passing to this function: getWork' . $e);
        }
    }
    
    private function getStatusUser($userId)
    {
        
        global $wpdb;
        $prefix = $wpdb->prefix;
        $query = "SELECT
                  {$prefix}wpjb_application.status as applicant_status
                FROM {$prefix}wpjb_application
                  INNER JOIN {$prefix}wpjb_resume
                    ON {$prefix}wpjb_application.user_id = {$prefix}wpjb_resume.user_id
                  INNER JOIN {$prefix}wpjb_job
                    ON {$prefix}wpjb_application.job_id = {$prefix}wpjb_job.id
                  INNER JOIN {$prefix}wpjb_company
                    ON {$prefix}wpjb_job.employer_id = {$prefix}wpjb_company.id
                    WHERE {$prefix}wpjb_resume.id = {$userId} AND {$prefix}wpjb_company.user_id = " . self::getUserId();
        if (self::getJob() !== null) {
            $query .= " AND {$prefix}wpjb_job.id = " . self::getJob();
        }
        $query .= " LIMIT 1";
        $result = $this->executeQueries($query);
        try {
            if (count($result) === 0) {
                return false;
            }
            return $result;
        } catch (Exception $e) {
            throw new Exception('Invalid data passing to this function: getStatusUser' . $e);
        }
    }
    
    private function getEducationUser($userId)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $workQuery = "SELECT
                      {$prefix}wpjb_resume_detail.resume_id,
                      {$prefix}wpjb_resume_detail.grantor AS academia,
                      {$prefix}wpjb_resume_detail.detail_title AS titulo
                    FROM {$prefix}wpjb_resume_detail
                      WHERE 2 = {$prefix}wpjb_resume_detail.type
                      AND resume_id = {$userId}";
        if (self::getCourse() !== null) {
            $workQuery .= " AND {$prefix}wpjb_resume_detail.detail_title LIKE '%" . self::getCourse() . "%' ";
        }
        
        $workQuery .= "  LIMIT 1";
        $result = $this->executeQueries($workQuery);
        try {
            if (count($result) === 0) {
                return false;
            }
            return $result;
        } catch (Exception $e) {
            throw new Exception('Invalid data passing to this function: getWork' . $e);
        }
    }
}


