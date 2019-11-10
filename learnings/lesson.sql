CREATE VIEW v_user_login AS
  SELECT
    `user_login`.`id`,
    `user_login`.`user_id`,
    `user`.`name`,
    INET_NTOA(`user_login`.`ip_address`) AS `ip_address_integer`,
    `user_login`.`login_dt`
  FROM `user_login`
  INNER JOIN `user`
  ON 1=1
    AND `user_login`.`id` = `user`.`id`
  WHERE 1=1
    AND `user_login`.`deleted_flag` = 0
  ORDER BY
    'user_login'.`id` DESC; 
