<?php  
include('db.php');
include 'navigation.php';

//UPDATING DEPARTMENT
if(isset($_POST['ID'])) {
	$ID = $_POST['ID'];
	$code = $_POST['Code'];
	$deptdes = $_POST['Dept_Description'];
	$depthead = $_POST['Dept_Head'];
	
	$sql = "update Department set Code='$code',Dept_Description='$deptdes', Dept_Head='$depthead' where ID='$ID'";

	if ($conn->query($sql) === TRUE) {
		header('location: /dept.php?updated=true');
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		header('location: /dept.php?updated=false');
	}
	$conn->close();
}

// ADDING DEPARTMENT
if(isset($_POST['add'])) {
	$code = $_POST['Code'];
	$deptdes = $_POST['Dept_Description'];
	$depthead = $_POST['Dept_Head'];

	$sql = "insert into Department (Code, Dept_Description, Dept_Head) values ('$code','$deptdes','$depthead')";
	if ($conn->query($sql) === TRUE) {
			header('location: /dept.php?added=true');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('location: /dept.php?added=false');
		}
	$conn->close();

}
// DELETING DEPARTMENT
if(isset($_GET['delete'])) {
	$sql = "delete from Department where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /dept.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /dept.php?deleted=false');
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
			echo '<div class="msg">Department updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">Department deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">Department added!</div>';
		}
	}
	
	?>
<body>


<?php 
	if($_SESSION['user'][4] == 'admin') {
?>

<?php 
if(isset($_GET['edit'])) { ?>
	<form method="post" action="dept.php">
		<div class="input-group">
			<label>Code</label>
			<input type="text" name="Code" value="<?php echo @$_GET['Code'] ?>">
		</div>
		<div class="input-group">
			<label>Department Description </label>
			<input type="text" name="Dept_Description" value="<?php echo @$_GET['Dept_Description'] ?>">
		</div>
        <div class="input-group">
			<label>Department Head</label>
			<input type="text" name="Dept_Head" value="<?php echo @$_GET['Dept_Head'] ?>">
		</div>
		<div class="input-group">
			<input type="text" name="ID" value="<?php echo @$_GET['id'] ?>" hidden>
			<button class="btn" type="submit" name="save">UPDATE</button>
		</div>
	</form>

<?php } if(!isset($_GET['edit'])) { ?>

	<form method="post" action="dept.php">
		<div class="input-group">
			<label>Code</label>
			<input type="text" name="Code">
		</div>
		<div class="input-group">
			<label>Department Description </label>
			<input type="text" name="Dept_Description">
		</div>
        <div class="input-group">
			<label>Department Head</label>
			<input type="text" name="Dept_Head">
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
			<th>Department Description</th>
			<th>Department Head</th>

			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
				<?php } ?>

		</tr>
	</thead>
	
    <?php 
    $sql = "select * from Department";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
			
			<td><?php echo $row['Code']; ?></td>
			<td><?php echo $row['Dept_Description']; ?></td>
			<td><?php echo $row['Dept_Head']; ?></td>
				
			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<td>
                <a href="dept.php?edit=true&id=<?php echo $row['ID'] ?>&Code=<?php echo $row['Code'] ?>&Dept_Description=<?php echo $row['Dept_Description'] ?>&Dept_Head=<?php echo $row['Dept_Head'] ?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="dept.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
				<?php } ?>

		</tr>
    <?php }
    } ?>
</table>
    </body>
</html>