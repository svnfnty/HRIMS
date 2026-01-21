<?php
require_once("./DBConnection.php");
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT v.*,d.name as dept,dd.name as desg FROM `vacancy_list` v INNER JOIN `designation_list` dd ON v.designation_id = dd.designation_id INNER JOIN `department_list` d ON dd.department_id = d.department_id WHERE v.vacancy_id = '{$_GET['id']}'");
    foreach($qry->fetch_assoc() as $k => $v){
        $$k = $v;
    }
    $description = html_entity_decode($description);
}
$hired = $conn->query("SELECT count(applicant_id) as `count` FROM `applicant_list` WHERE vacancy_id IN (SELECT vacancy_id FROM vacancy_list WHERE designation_id = '{$designation_id}') AND `status` = 2")->fetch_assoc()['count'];
$hired = $hired > 0 ? $hired : 0;
?>
<div class="container py-5 mt-5">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-light p-4">
            <h5 class="card-title fw-bold"><?php echo $title ?></h5>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <!-- Department and Designation -->
                <div class="col-md-6 wow fadeInLeft">
                    <div class="mb-3">
                        <div class="fs-6 text-muted"><b>Department:</b></div>
                        <div class="fs-5 text-primary ps-4"><?php echo isset($dept) ? $dept : '' ?></div>
                    </div>
                    <div class="mb-3">
                        <div class="fs-6 text-muted"><b>Designation:</b></div>
                        <div class="fs-5 text-primary ps-4"><?php echo isset($desg) ? $desg : '' ?></div>
                    </div>
                </div>

                <!-- Slots and Apply Button -->
                <div class="col-md-6 wow fadeInRight">
                    <div class="mb-3">
                        <div class="fs-6 text-muted"><b>Slots Available:</b></div>
                        <div class="fs-5 ps-4">
                            <span class="badge bg-success rounded-pill"><?php echo isset($slots) ? number_format($slots - $hired) : '' ?></span>
                        </div>
                    </div>
                    <div class="mb-3 pt-3">
                        <button class="btn btn-primary bg-gradient rounded-3 px-4" type="button" id="apply_now">Apply Now</button>
                    </div>
                </div>
            </div>

            <hr class="bg-primary opacity-75">

            <!-- Description Section -->
            <div class="w-100 mb-1 wow fadeInUp">
                <div class="fs-6 ps-4"><?php echo isset($description) ? $description : '' ?></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#apply_now').click(function(){
            uni_modal("Application Form", "application.php?id=<?php echo $vacancy_id ?>", 'large');
        })
    });
</script>

<style>
    /* Custom Styles */
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        border-bottom: 2px solid #ffffff;
    }
    .card-body {
        background-color: #f8f9fa;
    }
    .btn-primary {
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-3px);
    }
    .badge {
        font-size: 1.1rem;
        padding: 0.5em 1em;
    }
    .fs-5 {
        font-size: 1.25rem;
    }
    .fs-6 {
        font-size: 1rem;
    }
    .wow {
        opacity: 0;
    }
    .wow.fadeInLeft {
        animation: fadeInLeft 1s forwards;
    }
    .wow.fadeInRight {
        animation: fadeInRight 1s forwards;
    }
    .wow.fadeInUp {
        animation: fadeInUp 1s forwards;
    }
    @keyframes fadeInLeft {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes fadeInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes fadeInUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
