#STEP 1

CREATE VIEW timeslots_against_students AS
SELECT std.id
       ,std.forename
       ,std.surname
       ,std.dob
       ,std.dept
       ,std.lvl
       ,std.grp
       ,std.yr
       ,ttbl.ai_id
       ,std.stream_m
       ,std.stream_e
       ,CONCAT(ttbl.day_1hr_m, ttbl.slot_1hr_m) AS maths_1hr
       ,CONCAT(ttbl.day_2hr_m, ttbl.slot_2hr_m) AS maths_2hr
       ,CONCAT(ttbl.day_1hr_e, ttbl.slot_1hr_e) AS eng_1hr
       ,CONCAT(ttbl.day_2hr_e, ttbl.slot_2hr_e) AS eng_2hr
  FROM enrolment_data AS std
  JOIN timetable20_21_em AS ttbl
    ON 1=1
   AND std.dept = ttbl.dept
   AND std.lvl = ttbl.lvl
   AND std.grp = ttbl.grp
   AND std.yr = ttbl.yr



#STEP 2


CREATE VIEW students_per_session AS
SELECT count(maths_2hr) AS stud_per_sess
       ,maths_2hr as session_code
       , "m" as e_or_m
       ,stream_m AS stream
       ,ai_id 
       ,dept
       ,lvl
       ,grp
       ,yr
  FROM timeslots_against_students  
 WHERE 1=1
   AND maths_2hr NOT LIKE "%n%a" 
   AND stream_m != 0 
 GROUP BY maths_2hr, stream_m, ai_id

 UNION ALL

 SELECT count(maths_1hr) AS stud_per_sess
       ,maths_1hr as session_code
       ,"m" as e_or_m
       ,stream_m AS stream
       ,ai_id 
       ,dept
       ,lvl
       ,grp
       ,yr
  FROM timeslots_against_students  
 WHERE 1=1
   AND maths_1hr NOT LIKE "%n%a" 
   AND stream_m != 0 
 GROUP BY maths_1hr, stream_m, ai_id

  UNION ALL

 SELECT count(eng_1hr) AS stud_per_sess
       ,eng_1hr as session_code
       ,"e" as e_or_m
       ,stream_m AS stream
       ,ai_id 
       ,dept
       ,lvl
       ,grp
       ,yr
  FROM timeslots_against_students  
 WHERE 1=1
   AND eng_1hr NOT LIKE "%n%a" 
   AND stream_m != 0 
 GROUP BY eng_1hr, stream_m, ai_id

  UNION ALL

 SELECT count(eng_2hr) AS stud_per_sess
       ,eng_2hr as session_code
       ,"e" as e_or_m
       ,stream_m AS stream
       ,ai_id 
       ,dept
       ,lvl
       ,grp
       ,yr
  FROM timeslots_against_students  
 WHERE 1=1
   AND eng_2hr NOT LIKE "%n%a" 
   AND stream_m != 0 
 GROUP BY eng_2hr, stream_m, ai_id



#STEP 3

 -- enrol students
 -- this shit works

DROP PROCEDURE IF EXISTS enrol_students;
DELIMITER $$
CREATE PROCEDURE enrol_students()
BEGIN
SET @row_number = 0; 

DROP TABLE IF EXISTS student_num_row;
DROP TABLE IF EXISTS student_by_varients;

CREATE TABLE student_num_row 
SELECT 
	(@row_number:=@row_number + 1) AS num
	,id
	,surname
	,forename
	,dob
	,ai_id
	,if(stream_m = 0, 'n/a', if(maths_1hr = 'n/an/a', 0, CONCAT(maths_1hr, stream_m))) AS m1
	,if(stream_m = 0, 'n/a', if(maths_2hr = 'n/an/a', 0, CONCAT(maths_2hr, stream_m))) AS m2
	,if(stream_e = 0, 'n/a', if(eng_1hr = 'n/an/a', 0, CONCAT(eng_1hr, stream_e))) AS e1
	,if(stream_e = 0, 'n/a', if(eng_2hr = 'n/an/a', 0, CONCAT(eng_2hr, stream_e))) AS e2
 FROM timeslots_against_students;

 SET @x = 1;
 SET @xmax = (SELECT MAX(num) FROM student_num_row);
 SET @i = 1;
 CREATE TABLE student_by_varients (
 	id int(9)
 	,ai_id int (5)
 	,d_o_b varchar (10)
 	,m1 varchar(5)
 	,m2 varchar(5)
 	,e1 varchar(5)
 	,e2 varchar(5)
 	);
 ALTER TABLE `student_by_varients` convert to character SET utf8 collate utf8_general_ci;


enrol_students: LOOP


	IF @x >= @xmax THEN
		LEAVE enrol_students;
    END IF;
SET @ai_id = (SELECT ai_id FROM student_num_row WHERE num = @x);
SET @id = (SELECT id FROM student_num_row WHERE num = @x);
SET @dob = (SELECT dob FROM student_num_row WHERE num = @x);
SET @code_m1 = (SELECT m1 FROM student_num_row WHERE num = @x);
SET @tot_m1 = (SELECT COUNT(id) FROM student_by_varients WHERE m1 LIKE CONCAT('%', @code_m1, '%') AND ai_id = @ai_id );
SET @var_m1 = FLOOR(@tot_m1/8 +1);
SET @code_m2 = (SELECT m2 FROM student_num_row WHERE num = @x);
SET @tot_m2 = (SELECT COUNT(id) FROM student_by_varients WHERE m2 LIKE CONCAT('%', @code_m2, '%') AND ai_id = @ai_id );
SET @var_m2 = FLOOR(@tot_m2/8 +1);
SET @code_e1 = (SELECT e1 FROM student_num_row WHERE num = @x);
SET @tot_e1 = (SELECT COUNT(id) FROM student_by_varients WHERE e1 LIKE CONCAT('%', @code_e1, '%') AND ai_id = @ai_id );
SET @var_e1 = FLOOR(@tot_e1/8 +1);
SET @code_e2 = (SELECT e2 FROM student_num_row WHERE num = @x);
SET @tot_e2 = (SELECT COUNT(id) FROM student_by_varients WHERE e2 LIKE CONCAT('%', @code_e2, '%') AND ai_id = @ai_id );
SET @var_e2 = FLOOR(@tot_e2/8 +1);


	SET @m1 = (CONCAT(@code_m1, @var_m1));
	SET @m2 = (CONCAT(@code_m2, @var_m2));
	SET @e1 = (CONCAT(@code_e1, @var_e1));
	SET @e2 = (CONCAT(@code_e2, @var_e2));

	INSERT INTO student_by_varients 
	(id, ai_id, d_o_b, m1, m2, e1, e2)
	VALUES (@id, @ai_id, @dob, @m1, @m2, @e1, @e2);

	SET @x = @x +1;

	END LOOP;

END$$
DELIMITER ;