
<?php 
include_once("db.php");

$query = "SELECT * FROM `user`";
$SQL   = mysqli_query($conn,$query);

?>

 <!DOCTYPE html>
 <html>
 <head>
    <title>DIGITAL LIBRARY</title></head>
</head>
<body>
 
<table class="table"> 
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Contact</th>
        <th>Status</th>
        <th></th>
    </tr>
    <div>
    <tr class="tdhv">
        <?php while($row = mysqli_fetch_array($SQL))  {?>
            <td><?=$row["user_id"]?></td>
            <td><?=$row["user_name"]?></td>
            <td><?=$row["user_email"]?></td>
            <td><?=$row["user_password"]?></td>
            <td><?=$row["user_contact"]?></td>
            <td><?=$row["user_status"]?></td>
            <td><a name="" href="edit.php?id=<?=$row['user_id']?>" id="" class="editbtn">EDIT</a></td>
    </tr>
 <?php  }?>
    </div>
 </table>
</div>
</div>
 </html>