SQL Modes: STRICT_TRANS_TABLES ERROR_FOR_DIVISION_BY_ZERO NO_AUTO_CREATE_USER NO_ENGINE_SUBSTITUTION

SELECT SQL_CALC_FOUND_ROWS contact_civireport.sort_name as civicrm_contact_sort_name, contact_civireport.id as civicrm_contact_id, contact_civireport.first_name as civicrm_contact_first_name, contact_civireport.last_name as civicrm_contact_last_name, contact_civireport.job_title as civicrm_contact_job_title, (address_civireport.street_number % 2) as civicrm_address_address_odd_street_number, address_civireport.city as civicrm_address_address_city, address_civireport.state_province_id as civicrm_address_address_state_province_id  
        

FROM civicrm_contact contact_civireport  
                 
  LEFT JOIN civicrm_address address_civireport
                           ON (contact_civireport.id =
                               address_civireport.contact_id)  AND
                               address_civireport.is_primary = 1
 

WHERE ( contact_civireport.is_deceased = 0 ) AND ( contact_civireport.is_deleted = 0 ) AND  contact_civireport.id IN (
                          SELECT DISTINCT cgroup_civireport.contact_id
                          

FROM civicrm_group_contact cgroup_civireport
                          INNER JOIN `civicrm_group` AS `group` ON `group`.id = cgroup_civireport.group_id
                          

WHERE cgroup_civireport.group_id IN (4) AND cgroup_civireport.status = 'Added' 
                           )    

ORDER BY contact_civireport.sort_name ASC  

LIMIT 0, 50