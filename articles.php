<?php
include 'admin/db_connect.php';
?>
<style>
    #portfolio .img-fluid {
        width: calc(100%);
        height: 30vh;
        z-index: -1;
        position: relative;
        padding: 1em;
    }

    .gallery-list {
        cursor: pointer;
        border: unset;
        flex-direction: inherit;
    }

    .gallery-img,
    .gallery-list .card-body {
        width: calc(50%)
    }

    .gallery-img img {
        border-radius: 5px;
        min-height: 50vh;
        max-width: calc(100%);
    }

    span.hightlight {
        background: yellow;
    }

    .carousel,
    .carousel-inner,
    .carousel-item {
        min-height: calc(100%)
    }

    .row-items {
        position: relative;
    }

    .masthead {
        min-height: 23vh !important;
        height: 23vh !important;
    }

    .masthead:before {
        min-height: 23vh !important;
        height: 23vh !important;
    }
</style>
<div class="container-fluid mt-5">
    <div class="row h-100 align-items-center justify-content-center text-center">
        <div class="col-lg-8 align-self-end mb-4 page-title">
            <h3 class=" ">Articles</h3>
            <hr class="divider my-4" />
            <!-- <div class="row col-md-12 mb-2 justify-content-center">
                <button class="btn btn-primary btn-block col-sm-4" type="button" id="new_article"><i
                        class="fa fa-plus"></i> Post an Article</button>
            </div> -->
        </div>
    </div>
</div>
<div class="container mt-3 pt-2">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="filter-field"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Filter" id="filter" aria-label="Filter"
                            aria-describedby="filter-field">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary btn-block btn-sm" id="search">Search</button>
                </div>
            </div>

        </div>
    </div>
    <?php
    $articles = $conn->query("SELECT * from articles order by id desc ");
    while ($row = $articles->fetch_assoc()):
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
        $desc = strtr(html_entity_decode($row['content']), $trans);
        $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
        ?>
        <div class="card job-list" data-id="<?php echo $row['id'] ?>">
            <div class='banner'>
                <?php if (!empty($row['banner'])): ?>
                    <img src="admin/assets/uploads/<?php echo ($row['img']) ?>" alt="">
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="row  align-items-center justify-content-center text-center h-100">
                    <div class="">
                        <h3><b class="filter-txt"><?php echo ucwords($row['title']) ?></b></h3>
                        <hr>
                        <larger class="truncate filter-txt"><?php echo strip_tags($desc) ?></larger>
                        <br>
                        <hr class="divider" style="max-width: calc(80%)">
                        <button class="btn btn-primary float-right read_more" data-id="<?php echo $row['id'] ?>">Read
                            More</button>
                    </div>
                </div>
            </div>
            <br>
        <?php endwhile; ?>

    </div>

</div>


<script>
    // $('.card.gallery-list').click(function(){
    //     location.href = "index.php?page=view_gallery&id="+$(this).attr('data-id')
    // })
    $('#new_career').click(function () {
        uni_modal("New Job Hiring", "manage_career.php", 'mid-large')
    })
    $('.read_more').click(function () {
        uni_modal("Career Opportunity", "view_jobs.php?id=" + $(this).attr('data-id'), 'mid-large')
    })
    $('.gallery-img img').click(function () {
        viewer_modal($(this).attr('src'))
    })

    $('#filter').keypress(function (e) {
        if (e.which == 13)
            $('#search').trigger('click')
    })
    $('#search').click(function () {
        var txt = $('#filter').val()
        start_load()
        if (txt == '') {
            $('.job-list').show()
            end_load()
            return false;
        }
        $('.job-list').each(function () {
            var content = "";
            $(this).find(".filter-txt").each(function () {
                content += ' ' + $(this).text()
            })
            if ((content.toLowerCase()).includes(txt.toLowerCase()) == true) {
                $(this).toggle(true)
            } else {
                $(this).toggle(false)
            }
        })
        end_load()
    })

</script>