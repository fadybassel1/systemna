<?php
$pageTitle = "SYSTEMNA | Requested Letters";
include "../template/header.php";
?>

<br>
<div style="text-align: center;">
    <h1 style="font-family: sans-serif;">All Requests</h1>
</div>
<br><br>
<table id='Display'>
    <tr id='must'>
        <th>#</th>
        <th>Request ID</th>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Status</th>
        <th>Applied for Letter</th>
        <th>Priority</th>
        <th>Salary</th>
        <th colspan="2">Actions</th>
    </tr>

    <?php

    $sql="  SELECT e.fullname,rt.Name,r.Request_id,r.emp_id,r.type_name,r.Status,r.priority,r.salary
        FROM requests r ,employee e, requests_types rt where e.id=r.emp_id and r.Type_name=rt.Name order by r.date asc , r.priority desc ";
    try
    {

        $DB->query($sql);
        $DB->execute();
        $y=0;
        if($DB->numRows()>0)
        {
            for($i=0;$i<$DB->numRows();$i++)
            {
                $x=$DB->getdata();
                $y++;
                $id=$x[$i]->Request_id;
                $emp_id=$x[$i]->emp_id;
                $priority=$x[$i]->priority;
                $salary=$x[$i]->salary;
                $name=$x[$i]->fullname;

                $Boolsalray = "Without Salary";
                $BoolPriority = "Urgent";

                if($salary == 1)
                {
                    $Boolsalray ="With Salary";
                }
                else $Boolsalray ="Without Salary";

                if($priority == 1)
                {
                    $BoolPriority ="Urgent";
                }
                else $BoolPriority="Normal";

                echo  "<tr id='$id'  data-toggle='modal' class='letterstd'  data-target='#exampleModalLong'>";
                echo "<td>{$y}</td>";

                echo "<td>{$id}</td>";
                echo "<td>$emp_id</td>";
                echo "<td>$name</td>";

                if($x[$i]->Status==1){
                    echo "<td style='color:green; font-weight:bold;'>Accepted</td>";}
                else if($x[$i]->Status==0){
                    echo "<td style='color:red; font-weight:bold;' >Rejected</td>";}
                else{
                    echo "<td style='color:#be800d; font-weight:bold;' >Pending</td>";
                }
                echo '<td>'.$x[$i]->type_name.'</td>';

                echo "<td>{$BoolPriority}</td>";
                echo "<td>{$Boolsalray}</td>";

                if($x[$i]->Status==1){
    ?>

    <td colspan="2"><p class="badge badge-primary text-wrap" style=" background-color:#39d029;">accepted</p></td>

    <?php } else if ($x[$i]->Status==0){ ?>

    <td colspan="2"><p class="badge badge-primary text-wrap" style=" background-color:red;">Rejected</p></td>

    <?php } else   { ?>

    <td><a href="../operations/letter_request.php?id=<?php echo $id; ?>&status=1&userid=<?php echo $emp_id; ?>" style="color:white" class="btn btn-success">Accept</a></td>
    <td><a href="../operations/letter_request.php?id=<?php echo $id; ?>&status=0&userid=<?php echo $emp_id; ?>" style="color:white" class="btn btn-danger">Reject</a></td>


    <?php
                    echo "</tr>";
                   }
            }
            
        }
        else {
            echo"<tr><td colspan=8>You have no requests for now ! </td></tr>";
        }
    }
    catch(Exception $e)
    {
        $_SESSION['error'] = 'error in sql';
        error_log("Error while using page letter Requests");
    }

    ?>
</table>

<div class="modal fade bd-example-modal-xl" id="exampleModalLong"  tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div id="body" class="modal-content">
            ...


        </div>
    </div>
</div>

<!--<div class="modal fade " id="exampleModalLong"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div id="body" class="modal-body">
...
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button>
</div>
</div>
</div>
</div>-->

<!--

<script src="../js/bootstrap.min.js"></script>

<link rel="stylesheet" href="../css/bootstrap.min.css">

<script>

</script>
-->
<?php include "../template/footer.php"; ?>
