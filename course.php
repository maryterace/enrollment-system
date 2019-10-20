<?php  
include('db.php');
include 'navigation.php';

//UPDATING COURSE
if(isset($_POST['ID'])) {
	$ID = $_POST['ID'];
	$code = $_POST['Code'];
	$coursedes = $_POST['Course_Description'];
	$department = $_POST['Department'];
	
	$sql = "update Course set Code='$code',Course_Description='$coursedes', Department='$department' where ID='$ID'";

	if ($conn->query($sql) === TRUE) {
		header('location: /course.php?updated=true');
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		header('location: /course.php?updated=false');
	}
	$conn->close();
}

// ADDING COURSE
if(isset($_POST['add'])) {
	$code = $_POST['Code'];
	$coursedes = $_POST['Course_Description'];
	$dept = $_POST['Department'];

	$sql = "insert into Course (Code, Course_Description, Department) values ('$code','$coursedes','$dept')";
	if ($conn->query($sql) === TRUE) {
			header('location: /course.php?added=true');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('location: /course.php?added=false');
		}
	$conn->close();

}
// DELETING COURSE
if(isset($_GET['delete'])) {
	$sql = "delete from Course where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /course.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /course.php?deleted=false');
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
			echo '<div class="msg">Course updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">Course deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">Course added!</div>';
		}
	}
	
	?>
<body>


<?php 
	if($_SESSION['user'][4] == 'admin') {
?>

<?php 
if(isset($_GET['edit'])) { ?>
	<form method="post" action="course.php">
		<div class="input-group">
			<label>Code</label>
			<input type="text" name="Code" value="<?php echo @$_GET['Code'] ?>">
		</div>
		<div class="input-group">
			<label>Course Description </label>
			<input type="text" name="Course_Description" value="<?php echo @$_GET['Course_Description'] ?>">
		</div>
        <div class="input-group">
			<label>Department</label>
			<select class="input-group" name="Department" id="exampleFormControlSelect1" value="<?php echo $_POST['gender']?>">
                <?php
                $sql = "select * from Department";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
						$code = $row['Code'];
                        ?>
                        <option <?php if ($_GET['Department'] == $code) echo 'selected'; ?>>
                            <?php echo $code;?>
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

	<form method="post" action="course.php">
		<div class="input-group">
			<label>Code</label>
			<input type="text" name="Code">
		</div>
		<div class="input-group">
			<label>Course Description </label>
			<input type="text" name="Course_Description">
		</div>
        <div class="input-group">
			<label>Department</label>
			<select class="input-group" name="Department" value="<?php echo $_POST['Department']?>">
                <?php
                $sql = "select * from Department";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $code = $row['Code'];
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
           
			<th>Code</th>
			<th>Course Description</th>
			<th>Department</th>

			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
				<?php } ?>

		</tr>
	</thead>
	
    <?php 
    $sql = "select * from Course";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
		
			<td><?php echo $row['Code']; ?></td>
			<td><?php echo $row['Course_Description']; ?></td>
			<td><?php echo $row['Department']; ?></td>
					
			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<td>
                <a href="course.php?edit=true&id=<?php echo $row['ID'] ?>&Code=<?php echo $row['Code'] ?>&Course_Description=<?php echo $row['Course_Description'] ?>&Department=<?php echo $row['Department'] ?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="course.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
				<?php } ?>
		</tr>
    <?php }
    } ?>
</table>
    </body>
</html>