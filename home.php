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
    .event-list, .job-list {
        cursor: pointer;
        margin-bottom: 20px;
    }

    span.hightlight {
        background: yellow;
    }

    .banner {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 26vh;
        width: calc(30%);
    }

    .banner img {
        width: calc(100%);
        height: calc(100%);
        cursor: pointer;
    }

    .event-list {
        cursor: pointer;
        border: unset;
        flex-direction: inherit;
    }

    .event-list .banner {
        width: calc(40%)
    }

    .event-list .card-body {
        width: calc(60%)
    }

    .event-list .banner img {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        min-height: 50vh;
    }

    span.hightlight {
        background: yellow;
    }

    .banner {
        min-height: calc(100%)
    }

    .header {
        margin-top: 3rem;
    }
    
</style>
<div class="header">
    <div class="align-items-center justify-content-center text-center">
        <div class="align-self-end mb-4 page-title">
            <h3 class="">Welcome to <?php echo $_SESSION['system']['name']; ?></h3>
        </div>
    </div>
</div>
</div>
<div class="row justify-content-center " >
    <div class="col-lg-4 mt-3 pt-2" style="position:relative; top:0;">
        <h4 class="text-center ">Upcoming Events</h4>
        <?php
        $event = $conn->query("SELECT * FROM events where date_format(schedule,'%Y-%m%-d') >= '" . date('Y-m-d') . "' order by unix_timestamp(schedule) asc");
        while ($row = $event->fetch_assoc()):
            $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
            unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
            $desc = strtr(html_entity_decode($row['content']), $trans);
            $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
            ?>
            <div class="card event-list" data-id="<?php echo $row['id'] ?>">
                <div class='banner'>
                    <?php if (!empty($row['banner'])): ?>
                        <img src="admin/assets/uploads/<?php echo ($row['banner']) ?>" alt="">
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row  align-items-center justify-content-center text-center h-100">
                        <div class="">
                            <h3><b class="filter-txt"><?php echo ucwords($row['title']) ?></b></h3>
                            <div><small>
                                    <p><b><i class="fa fa-calendar"></i>
                                            <?php echo date("F d, Y h:i A", strtotime($row['schedule'])) ?></b></p>
                                </small></div>
                            <hr>
                            <larger class="truncate filter-txt"><?php echo strip_tags($desc) ?></larger>
                            <br>
                            <hr class="divider" style="max-width: calc(80%)">
                            <button class="btn btn-primary float-right read_more" data-id="<?php echo $row['id'] ?>">Read
                                More</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

    </div>
    <div class="col-lg-4 mt-3 pt-2 ">
        <h4 class="text-center ">Latest Article</h4>
        <?php
        $articles = $conn->query("SELECT * from articles order by id desc ");
        while ($row = $articles->fetch_assoc()):
            $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
            unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
            $desc = strtr(html_entity_decode($row['content']), $trans);
            $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
            $url = $row["content"];
            ?>
            <div class="card job-list"  data-id="<?php echo $row['id'] ?>">
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
                           <h5><?php echo $row['linkname']?></b></h5>

                            <larger class="truncate filter-txt"><?php echo $row['description']  ?></larger>
                          
                            <br>
                            <hr class="divider" style="max-width: calc(80%)">
                            <a href="<?php echo $url; ?>">
                            <button class="btn btn-primary float-right read_more" >Read
                                More</button></a>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <?php endwhile; ?>
    </div>
    <script>
        $('.read_more').click(function () {
            location.href = "index.php?page=view_event&id=" + $(this).attr('data-id')
        })
        $('.banner img').click(function () {
            viewer_modal($(this).attr('src'))
        })
        $('#filter').keyup(function (e) {
            var filter = $(this).val()

            $('.card.event-list .filter-txt').each(function () {
                var txto = $(this).html();
                txt = txto
                if ((txt.toLowerCase()).includes((filter.toLowerCase())) == true) {
                    $(this).closest('.card').toggle(true)
                } else {
                    $(this).closest('.card').toggle(false)

                }
            })
        })
    </script>