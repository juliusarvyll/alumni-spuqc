<?php
include('db_connect.php');

$course_id = $_POST['course_id'];
$where = $course_id ? "WHERE a.course_id = '$course_id'" : '';

$query = "SELECT a.*, c.course, CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) as name FROM alumnus_bio a INNER JOIN courses c ON c.id = a.course_id $where ORDER BY CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) ASC";
$alumni = $conn->query($query);
$i = 1;

while ($row = $alumni->fetch_assoc()):
?>
<tr>
    <td class="text-center"><?php echo $i++; ?></td>
    <td class="text-center">
        <div class="avatar">
            <img src="assets/uploads/<?php echo $row['avatar']; ?>" alt="">
        </div>
    </td>
    <td>
        <p><b><?php echo ucwords($row['name']); ?></b></p>
    </td>
    <td>
        <p><b><?php echo $row['course']; ?></b></p>
    </td>
    <td class="text-center">
        <?php if ($row['status'] == 1): ?>
            <span class="badge badge-primary">Verified</span>
        <?php else: ?>
            <span class="badge badge-secondary">Not Verified</span>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <button class="btn btn-sm btn-primary view_alumni" type="button" data-id="<?php echo $row['id']; ?>">View</button>
        <button class="btn btn-sm btn-danger delete_alumni" type="button" data-id="<?php echo $row['id']; ?>">Delete</button>
    </td>
</tr>
<?php endwhile; ?>
