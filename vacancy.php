<div class="my-5 pt-4">
    <div class="container">
        <div class="col-12">
            <!-- Search Input -->
            <div class="row mx-0 d-flex justify-content-center mb-4">
                <div class="col-12 col-md-6">
                    <div class="input-group shadow-sm rounded-3">
                        <input type="text" id="search" class="form-control rounded-0 border-0 py-2 px-3" placeholder="Search Here" aria-label="Search Here" autocomplete="off">
                        <span class="input-group-text bg-primary text-white border-0 rounded-0">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Vacancy List -->
            <div class="row mx-0 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gx-4 gy-4" id="vacancy_list">
                <?php
                $sql = "SELECT v.*,d.name as dept,dd.name as desg FROM `vacancy_list` v INNER JOIN `designation_list` dd ON v.designation_id = dd.designation_id INNER JOIN `department_list` d ON dd.department_id = d.department_id WHERE v.status = 1 ORDER BY UNIX_TIMESTAMP(date_created) ASC";
                $qry = $conn->query($sql);
                $i = 0;
                while($row = $qry->fetch_assoc()):
                    $row['description'] = strip_tags(html_entity_decode($row['description']));
                    $hired = $conn->query("SELECT COUNT(applicant_id) AS `count` FROM `applicant_list` WHERE vacancy_id IN (SELECT vacancy_id FROM vacancy_list WHERE designation_id = '{$row['designation_id']}') AND `status` = 2")->fetch_assoc()['count'];
                    $hired = $hired > 0 ? $hired : 0;
                ?>
                <div class="item col wow bounceInUp" data-wow-delay="<?php echo ($i > 0) ? $i:''; $i += .5; ?>s">
                    <div class="card shadow-lg border-0 rounded-3 h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-2"><?php echo $row['title'] ?></h5>
                            <hr class="bg-primary opacity-100">
                            <div class="lh-1 mb-2">
                                <small class="text-muted">Position: <span class="fw-bold"><?php echo $row['desg'] ?></span></small> <br>
                                <small class="text-muted">Dept.: <span class="fw-bold"><?php echo $row['dept'] ?></span></small>
                            </div>
                            <p class="truncate-3 fw-light fst-italic lh-1 text-muted"><small><?php echo $row['description'] ?></small></p>
                            <div class="w-100 d-flex justify-content-between mt-3">
                                <div class="col-auto">
                                    <a href="./?page=view_vacancy&id=<?php echo $row['vacancy_id'] ?>" class="btn btn-sm btn-primary bg-gradient rounded-0 py-1">Read More</a>
                                </div>
                                <div>
                                    <span class="text-muted me-2">Slot: </span>
                                    <span class="badge bg-success rounded-circle"><?php echo $row['slots'] - $hired ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#search').on('input',function(){
            var _search = $(this).val().toLowerCase();
            $('#vacancy_list .item').each(function(){
                var _text = $(this).text().toLowerCase();
                if(_text.includes(_search)){
                    $(this).toggle(true);
                }else{
                    $(this).toggle(false);
                }
            });
        });
    });
</script>

<style>
    /* Custom Styles */
    .input-group {
        background-color: #f8f9fa;
        border-radius: 50px;
    }
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 1.25rem;
        color: #007bff;
    }
    .badge {
        font-size: 0.875rem;
    }
    .input-group-text i {
        font-size: 1.2rem;
    }
    .wow {
        opacity: 0;
    }
    .wow.bounceInUp {
        opacity: 1;
        animation: bounceInUp 1s ease-out;
    }
    @keyframes bounceInUp {
        0% {
            transform: translateY(1000px);
            opacity: 0;
        }
        60% {
            transform: translateY(-30px);
            opacity: 1;
        }
        100% {
            transform: translateY(0);
        }
    }
</style>
