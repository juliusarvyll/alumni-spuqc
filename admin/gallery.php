<?php include('db_connect.php');?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-article">
				<div class="card">
					<div class="card-header">
						    Create Article
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label for="" class="control-label">Title</label>
								<input type="text" class="form-control" name="title" required>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Image</label>
								<input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
							</div>
							<div class="form-group">
								<img src="<?php echo is_file('assets/uploads/articles/img_') ?>" alt="" id="cimg">
							</div>
							<div class="form-group">
								<label class="control-label">Content</label>
								<textarea class="form-control" name='content' rows="10" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">linkname</label>
								<input type="" name='linkname' rows="10" required></textarea>
							</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-article').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Article List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Title</th>
									<th class="text-center">Image</th>
									<th class="text-center">Content</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$img = array();
                          		$fpath = 'assets/uploads/articles';
								$files= is_dir($fpath) ? scandir($fpath) : array();
								foreach($files as $val){
									if(!in_array($val, array('.','..'))){
										$n = explode('_',$val);
										$img[$n[0]] = $val;
									}
								}
								$articles = $conn->query("SELECT * FROM articles order by id asc");
while ($row = $articles->fetch_assoc()):
?>
<tr>
    <td class="text-center"><?php echo $i++ ?></td>
    <td><?php echo $row['title'] ?></td>
    <td class="text-center">
        <img src="<?php echo is_file($row['img']) ? $row['img'] : '' ?>" class="aimg" alt="Image Unavailable">
    </td>
	<td><p><a href="<?php echo $row['content']; ?>" target="_blank"><?php echo $row['linkname']; ?></a></p></td>
    <td class="text-center">
        <button class="btn btn-sm btn-primary edit_article" type="button" data-id="<?php echo $row['id'] ?>" data-title="<?php echo $row['title'] ?>" data-content="<?php echo $row['content'] ?>" data-src="<?php echo is_file($row['img']) ? $row['img'] : '' ?>" >Edit</button>
        <button class="btn btn-sm btn-danger delete_article" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
    </td>
</tr>
<?php endwhile ?>;
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	
</div>

<style>
	td {
		vertical-align: middle !important;
	}
	img#cimg {
		max-height: 23vh;
		max-width: calc(100%);
	}
	.aimg {
		max-height: 15vh;
		max-width: 10vw;
	}
</style>

<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#cimg').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#manage-article').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_article',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Article successfully added", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				} else if (resp == 2) {
					alert_toast("Article successfully updated", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				}
			}
		})
	})
	$('.edit_article').click(function() {
		start_load()
		var cat = $('#manage-article')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='title']").val($(this).attr('data-title'))
		cat.find("[name='content']").val($(this).attr('data-content'))
		cat.find("[name='linkname']").val($(this).attr('data-linkname'))
		cat.find("img").attr('src', $(this).attr('data-src'))
		end_load()
	})
	$('.delete_article').click(function() {
		_conf("Are you sure to delete this article?", "delete_article", [$(this).attr('data-id')])
	})
	function delete_article($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_article',
			method: 'POST',
			data: {id: $id},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Article successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				}
			}
		})
	}
	$('table').dataTable()
</script>
