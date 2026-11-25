<?php
include("../config/database.php");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=attendance_report.xls");

$where="WHERE 1";
if(!empty($_GET['branch']))   $where.=" AND s.branch='".$_GET['branch']."'";
if(!empty($_GET['year']))     $where.=" AND s.year='".$_GET['year']."'";
if(!empty($_GET['semester'])) $where.=" AND s.semester='".$_GET['semester']."'";
if(!empty($_GET['from']) && !empty($_GET['to']))
    $where.=" AND a.date BETWEEN '".$_GET['from']."' AND '".$_GET['to']."'";

$query=mysqli_query($conn,"
SELECT s.full_name,s.branch,s.year,s.semester,
COUNT(a.id) total,
SUM(a.status='Present') present
FROM students s
LEFT JOIN attendance a ON s.id=a.student_id
$where GROUP BY s.id
");

echo "Name\tBranch\tYear\tSemester\tTotal\tPresent\tAbsent\tPercent\n";

while($r=mysqli_fetch_assoc($query)){
    $absent=$r['total']-$r['present'];
    $percent=$r['total']>0?round(($r['present']/$r['total'])*100,2):0;
    echo "{$r['full_name']}\t{$r['branch']}\t{$r['year']}\t{$r['semester']}\t{$r['total']}\t{$r['present']}\t$absent\t$percent%\n";
}
?>
