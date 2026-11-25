<?php
include("../config/database.php");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=students_without_id.xls");

echo "Name\tBranch\tSemester\tYear\n";

$query = mysqli_query($conn,
"SELECT s.* 
 FROM students s
 LEFT JOIN id_card_requests i 
 ON s.id = i.student_id 
 AND i.status='Approved'
 WHERE i.student_id IS NULL"
);

while($row = mysqli_fetch_assoc($query)){
    echo $row['full_name']."\t".
         $row['branch']."\t".
         $row['semester']."\t".
         $row['year']."\n";
}
?>