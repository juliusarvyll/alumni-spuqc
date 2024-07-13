<?php include('db_connect.php'); ?>

<style>
.card-header {
    background: #FFD63E;
    border-radius: 20px;
}
</style>

<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header text-dark">
                    <b>List of Alumni</b>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <select id="courseFilter" class="form-control">
                                <option value="">Select Course</option>
                                <?php 
                                $courses = $conn->query("SELECT * FROM courses ORDER BY course ASC");
                                while ($row = $courses->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['course']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="downloadPdf" class="btn btn-primary">Download PDF</button>
                        </div>
                    </div>
                    <table class="table table-condensed table-bordered table-hover table-striped" id="alumniTable">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="">Avatar</th>
                                <th class="">Name</th>
                                <th class="">Course Graduated</th>
                                <th class="">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="alumniList">
                            <?php 
                            $i = 1;
                            $alumni = $conn->query("SELECT a.*, c.course, CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) as name FROM alumnus_bio a INNER JOIN courses c ON c.id = a.course_id ORDER BY CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) ASC");
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    td {
        vertical-align: middle !important;
    }
    td p {
        margin: unset;
    }
    .avatar {
        display: flex;
        border-radius: 100%;
        width: 100px;
        height: 100px;
        align-items: center;
        justify-content: center;
        border: 3px solid;
        padding: 5px;
    }
    .avatar img {
        max-width: calc(100%);
        max-height: calc(100%);
        border-radius: 100%;
    }
</style>

<script>
    $(document).ready(function() {
        $('table').dataTable();
    });

    $('#courseFilter').change(function() {
        var course_id = $(this).val();
        $.ajax({
            url: 'filter_alumni.php',
            method: 'POST',
            data: { course_id: course_id },
            success: function(data) {
                $('#alumniList').html(data);
            }
        });
    });

    $('#downloadPdf').click(function() {
        var course_id = $('#courseFilter').val();
        window.location.href = 'generate_pdf.php?course_id=' + course_id;
    });

    $(document).on('click', '.view_alumni', function() {
        uni_modal("Bio", "view_alumni.php?id=" + $(this).data('id'), 'mid-large');
    });

    $(document).on('click', '.delete_alumni', function() {
        _conf("Are you sure to delete this alumni?", "delete_alumni", [$(this).data('id')]);
    });

    function delete_alumni(id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_alumni',
            method: 'POST',
            data: { id: id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
