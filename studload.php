<?php  
include('db.php');
include 'navigation.php';

if(isset($_POST['studid'])) {
    $studid = $_POST['studid'];
    $schedcode = $_POST['schedcode'];
    $subjcode = $_POST['subject'];
    $time = $_POST['time'];
    $schedId = $_POST['schedId'];

    $sql="select * from Schedule where ID=$schedId";
    $res=$conn->query($sql);
    while($row=$res->fetch_assoc()){
        $semester = $row['Semester'];
        $term = $row['Term'];
        $sql = "insert into StudentLoad (Student, Schedule_Code, Subject_Code, Time, Semester, Term) values 
        ('$studid', '$schedcode','$subjcode', '$time', '$semester','$term')";
        if ($conn->query($sql) === TRUE) {
                header('location: /studentload.php?added=true');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                header('location: /studentload.php?added=false');
            }
    }
	$conn->close();
}

//delete
if(isset($_POST['delete'])) {
	$sql = "delete from StudentLoad where Load_ID=".$_POST['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /studentload.php?deleted=true');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        //header('location: /studentload.php?deleted=false');
    }
    $conn->close();
}
?>
<html>
<div class="form-group" id="studInfo">
    <input type="text" name="id" value="<?php echo @$_GET['id'] ?>" disabled>
    <input type="text" name="firstname" value="<?php echo @$_GET['firstname'] ?>" disabled>
    <input type="text" name="lastname" value="<?php echo @$_GET['lastname'] ?>" disabled>
</div>
<button class="btn btn-primary float-right btn-lg" type="button" onclick="printData()">Print</button>
<br>
    <form action="./studload.php" method="get">
            <div class="form-group">
                <input type="text" name="search" class="form-control" value="<?php echo @$_GET['search'] ?>" placeholder="Search Subject">
                <input type="text" name="id" value="<?php echo @$_GET['id'] ?>" hidden>
                <input type="text" name="firstname" value="<?php echo @$_GET['firstname'] ?>" hidden>
                <input type="text" name="lastname" value="<?php echo @$_GET['lastname'] ?>" hidden>  
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <?php 
        if(isset($_GET['search'])) {
            ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Schedule Code</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Time</th>
                    <th scope="col">Semester</th>
                </tr>
            </thead>
            <tbody>
        <?php
            }
        ?>
        <?php
        if(isset($_GET['search'])) {
            include_once "./db.php";
            $student = $_GET['search'];
            $sql = "select * from Schedule where Subject like '%$student%'";
            $result = $conn->query($sql);
            $res = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                    <th scope="row"><?php echo $row['Code'] ?></th>
                    <td><?php echo $row['Subject'] ?></td>
                    <td><?php echo $row['Time'] ?></td>
                    <td><?php echo $row['Semester'] ?></td>
                    <form action="./studload.php" method="post">
                        <input type="text" name="schedId" value="<?php echo $row['ID'] ?>" hidden/>
                        <input type="text" name="studid" value="<?php echo $_GET['id'] ?>" hidden/>
                        <input type="text" name="schedcode" value="<?php echo $row['Code'] ?>" hidden/>
                        <input type="text" name="subject" value="<?php echo $row['Subject'] ?>" hidden/>
                        <input type="text" name="time" value="<?php echo $row['Time'] ?>" hidden/>
                        <input type="text" name="semester" value="<?php echo $row['Semester'] ?>" hidden/>
                        <!-- <input type="text" name="loadrow" value="1" hidden> -->
                        <td><button type="submit" class="btn btn-success"><i class="fas fa-plus"></i></button></td>
                    </form>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        <table class="table" id="studLoad">
                <thead>
                    <tr>
                        <th scope="col">Load ID</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Schedule Code</th>
                        <th scope="col">Subject Code</th>
                        <th scope="col">Time</th>
                        <th scope="col">Semester</th>
                        <th scope="col">term</th>
                </thead>
                <tbody>
                <?php
					if(isset($_GET['id'])) {
						include_once "./db.php";
						$studentid = $_GET['id'];
						$sql = "select * from StudentLoad where Student=$studentid";
						$result = $conn->query($sql);
						$res = array();
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								?>
								<tr>
								<th scope="row"><?php echo $row['Load_ID'] ?></th>
								<td><?php echo $row['Student'] ?></td>
								<td><?php echo $row['Schedule_Code'] ?></td>
								<td><?php echo $row['Subject_Code'] ?></td>
								<td><?php echo $row['Time'] ?></td>
								<td><?php echo $row['Semester'] ?></td>
								<td><?php echo $row['Term'] ?></td>
								<form action="./studload.php" method="post">
									<input type="text" name="delete" value="<?php echo $row['Load_ID'] ?>" hidden/>
									<td><button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>
								</form>
								</tr>
								<?php
							}
                        }
                    }
					?>
                </tbody>
            </table>
            <script>
                function printData() {
                        var divToPrint=document.getElementById("studLoad");
                        var divToPrint2=document.getElementById("studInfo");
                        newWin= window.open("");
                        newWin.document.write(divToPrint2.outerHTML);
                        newWin.document.write(divToPrint.outerHTML);
                        newWin.print();
                        newWin.close();
                    }
            </script>
</html>