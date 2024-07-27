<?php
include('db_connect.php');

// Collect filters
$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$batch = isset($_POST['batch']) ? $_POST['batch'] : '';
$employed = isset($_POST['employed']) ? $_POST['employed'] : '';

// Debugging: Print filter values
error_log("Filters - Course ID: $course_id, Gender: $gender, Batch: $batch, Employed: $employed");

// Build query
$query = "SELECT a.*, c.course, CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) as name 
          FROM alumnus_bio a 
          INNER JOIN courses c ON c.id = a.course_id 
          WHERE 1=1";

$params = [];
$types = '';

if ($course_id) {
    $query .= " AND a.course_id = ?";
    $params[] = $course_id;
    $types .= 'i';
}
if ($gender) {
    $query .= " AND a.gender = ?";
    $params[] = $gender;
    $types .= 's';
}
if ($batch) {
    $query .= " AND a.batch = ?";
    $params[] = $batch;
    $types .= 's';
}
if ($employed !== '') {
    $query .= " AND a.employed = ?";
    $params[] = $employed;
    $types .= 'i';
}

$query .= " ORDER BY CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) ASC";

// Debugging: Print constructed query and parameters
error_log("Constructed Query: $query");
error_log("Parameters: " . implode(', ', $params));

// Prepare and execute query
$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
    // Debugging: Print parameter types and values
    error_log("Parameter Types: $types");
    error_log("Bound Parameters: " . implode(', ', $params));
}
$stmt->execute();
$alumni = $stmt->get_result();

// Debugging: Check number of rows returned
error_log("Number of rows returned: " . $alumni->num_rows);

if ($alumni->num_rows > 0) {
    $i = 1;
    while ($row = $alumni->fetch_assoc()):
        // Debugging: Print each row data
        error_log("Row Data: " . print_r($row, true));
?>
<tr>
    <td class="text-center"><?php echo $i++; ?></td>
    <td class="text-center">
    <div class="avatar">
                                        <?php 
                                        // Debugging: Check the length of the image data
                                        if (!empty($row['img'])) {
                                            echo '<img src="data:image/png;base64,'.base64_encode($row['img']).'" alt="Avatar">'; 
                                        } else {
                                            echo 'No image available'; // Debugging message
                                        }
                                        ?>
                                    </div>
    </td>
    <td>
        <p><b><?php echo ucwords($row['name']); ?></b></p>
    </td>
    <td>
        <p><b><?php echo $row['course']; ?></b></p>
    </td>
    <td>
        <p><b><?php echo $row['batch']; ?></b></p>
    </td>
    <td>
        <p><b><?php echo $row['email']; ?></b></p>
    </td>
    <td>
        <p><b><?php echo $row['mobileNumber']; ?></b></p>
    </td>
    <td class="text-center">
        <?php if ($row['currentlyEmployed'] == 1): ?>
            <span class="badge badge-primary">Employed</span>
            <p><b><?php echo $row['occupation']; ?></b></p>
            <p><b><?php echo $row['company']; ?></b></p>
        <?php else: ?>
            <span class="badge badge-secondary">Unemployed</span>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <button class="btn btn-sm btn-primary view_alumni" type="button" data-id="<?php echo $row['id']; ?>">View</button>
        <button class="btn btn-sm btn-danger delete_alumni" type="button" data-id="<?php echo $row['id']; ?>">Delete</button>
    </td>
</tr>
<?php
    endwhile;
} else {
    echo "<tr><td colspan='9' class='text-center'>No data available</td></tr>";
}
?>