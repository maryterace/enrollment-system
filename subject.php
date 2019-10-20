<?php  
include('db.php');
include 'navigation.php';

//UPDATING SUBJECT
if(isset($_POST['ID'])) {
	$ID = $_POST['ID'];
    $subjcode = $_POST['SubjectCode'];
	$subjname = $_POST['SubjectName'];
	$subjlec = $_POST['SubjectLecture'];
	$subjlab = $_POST['SubjectLab'];
	$subjtotal = $subjlec + $subjlab ;
	$subjprereq = $_POST['SubjectPrereq'];
	
	
	$sql = "update Subject set Subject_Code='$subjcode', Subject_Name='$subjname', Subject_Lecture=$subjlec, Subject_Lab=$subjlab, Subject_Total=$subjtotal, Subject_Prereq='$subjprereq' where ID='$ID'";

	if ($conn->query($sql) === TRUE) {
		header('location: /subject.php?updated=true');
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		header('location: /subject.php?updated=false');
	}
	$conn->close();
}

// ADDING SUBJECT
if(isset($_POST['add'])) {
    $subjcode = $_POST['SubjectCode'];
	$subjname = $_POST['SubjectName'];
	$subjlec = $_POST['SubjectLecture'];
	$subjlab = $_POST['SubjectLab'];
	$subjtotal = $subjlec + $subjlab ;
	$subjprereq = $_POST['SubjectPrereq'];

	$sql = "insert into Subject (Subject_Code, Subject_Name, Subject_Lecture, Subject_Lab, Subject_Total, Subject_Prereq) values ('$subjcode', '$subjname',$subjlec,$subjlab,$subjtotal,'$subjprereq')";
	if ($conn->query($sql) === TRUE) {
			header('location: /subject.php?added=true');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('location: /subject.php?added=false');
		}
	$conn->close();

}

// DELETING SUBJECT
if(isset($_GET['delete'])) {
	$sql = "delete from Subject where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /subject.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /subject.php?deleted=false');
    }
    $conn->close();
}

?>

<!DOCTYPE html>
<html>
    <head>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
	<?php
    if (isset($_GET['updated'])) {
		if($_GET['updated'] == 'true') {
			echo '<div class="msg">Subject updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">Subject deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">Subject added!</div>';
		}
	}
	
	?>
<body>

<?php 
if($_SESSION['user'][4] == 'admin') {
?>

<?php 
if(isset($_GET['edit'])) { ?>
	<form method="post" action="subject.php">
    <div class="input-group">
			<label>Subject Code</label>
			<input type="text" name="SubjectCode" value="<?php echo @$_GET['SubjectCode'] ?>">
        </div>
        <div class="input-group">
			<label>Subject Name</label>
			<input type="text" name="SubjectName" value="<?php echo @$_GET['SubjectName'] ?>">
        </div>
		<div class="input-group">
			<label>Subject Lecture</label>
			<input type="text" name="SubjectLecture" value="<?php echo @$_GET['SubjectLecture'] ?>">
        </div>
		<div class="input-group">
			<label>Subject Laboratory</label>
			<input type="text" name="SubjectLab" value="<?php echo @$_GET['SubjectLab'] ?>">
        </div>
		<div class="input-group">
			<label>Subject Prerequisite</label>
			<select class="input-group" name="SubjectPrereq" value="<?php echo $_POST['SubjectPrereq']?>">
                <?php
                $sql = "select * from Subject";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $code = $row['Subject_Code'];
                        ?>
                        <option>
                            <?php echo $code; ?>
                        </option>
                    <?php }} ?>
                </select>
        </div>
        
		<div class="input-group">
			<input type="text" name="ID" value="<?php echo @$_GET['id'] ?>" hidden>
			<button class="btn" type="submit" name="save">UPDATE</button>
		</div>
	</form>

<?php } if(!isset($_GET['edit'])) { ?>

	<form method="post" action="subject.php">
	<div class="input-group">
			<label>Subject Code</label>
			<input type="text" name="SubjectCode">
        </div>
    <div class="input-group">
			<label>Subject Name</label>
			<input type="text" name="SubjectName">
        </div>
		<div class="input-group">
			<label>Subject Lecture</label>
			<input type="text" name="SubjectLecture">
        </div>
		<div class="input-group">
			<label>Subject Laboratory</label>
			<input type="text" name="SubjectLab">
        </div>
		<div class="input-group">
			<label>Subject Prerequisite</label>
			<select class="input-group" name="SubjectPrereq" value="<?php echo $_POST['SubjectPrereq']?>">
			<option>
                None
            </option>
			    <?php
                $sql = "select * from Subject";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $code = $row['Subject_Code'];
                        ?>
                        <option>
                            <?php echo $code; ?>
                        </option>
                    <?php }} ?>
                </select>
        </div>
        <div class="input-group">
			<input type="text" name="add" value="add" hidden>
			<button class="btn" type="submit" name="save">ADD</button>
		</div>
	</form>
	
<?php } ?>
<?php } ?>

<table>
	<thead>
		<tr>
            
			<th>Subject Code</th>
			<th>Subject Name</th>
			<th>Lecture</th>
			<th>Laboratory</th>
			<th>Total</th>
			<th>Prerequisite</th>
			

			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
				<?php } ?>

		</tr>
	</thead>
	
    <?php 
    $sql = "select * from Subject";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
			
			<td><?php echo $row['Subject_Code']; ?></td>
			<td><?php echo $row['Subject_Name']; ?></td>
			<td><?php echo $row['Subject_Lecture']; ?></td>
			<td><?php echo $row['Subject_Lab']; ?></td>
			<td><?php echo $row['Subject_Total']; ?></td>
			<td><?php echo $row['Subject_Prereq']; ?></td>
							
			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<td>
                <a href="subject.php?edit=true&id=<?php echo $row['ID'] ?>&SubjectCode=<?php echo $row['Subject_Code']?>&SubjectName=<?php echo $row['Subject_Name'] ?> &SubjectLecture=<?php echo $row['Subject_Lecture']?>&SubjectLab=<?php echo $row['Subject_Lab']?>&SubjectPrereq=<?php echo $row['Subject_Prereq']?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="subject.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
			<?php } ?>

		</tr>
    <?php }
    } ?>
</table>

    </body>
</html>