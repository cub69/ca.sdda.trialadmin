/* This sql is used only for SDDA where they custom fields are added.  Needs execution only once upon install of the extension

INSERT INTO civicrm_trial_admin (event_id, hosting_club, Requester, Requester_RP, Requester_Name, Requester_lastname, Requester_email, Location_name, Street_address, Location_city, Location_province, Location_country, trial_chairperson, trial_secretary, venue_description, space_for_containers, space_for_interior, space_for_exterior, staging_and_crating, space_for_secretary, space_for_judge, confirm_square_footage, confirm_judge_contacted  )

SELECT event.id, details.hosting_club_70, (select id from civicrm_contact where details.requester_name_72 = first_name and details.requester_last_name_73 = last_name limit 1),details.requester_rp__71, details.requester_name_72, details.requester_last_name_73, details.requester_email_74, details.location_75, details.street_address_76, details.city_77, details.province_78, details.country_79, (select id from civicrm_contact where details.trial_chairperson_80 = display_name limit 1),(select id from civicrm_contact where details.trial_secretary_81 = display_name limit 1),
details.venue_description_86, details.space_for_containers_87, details.space_for_interior_searches_88, details.space_for_exterior_searches_89, details.staging_and_crating_90, details.secretary_area_91, details.judge_area_92, details.confirm_square_footage_93, details.confirm_judge_contacted_94
FROM civicrm_event event   
LEFT JOIN civicrm_value_trial_application_details_9 details ON details.entity_id = event.id
*/
