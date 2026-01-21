<style>
   header#cover {
    height: 65vh;
    position: relative;
}

header:before {
    height: 65vh;
    background-image: url(./images/banner.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    position: fixed;
    width: 100%;
    left: 0;
    top: 0;
    z-index: -1;
    content: "";
}

nav.onTransparent {

}

#topNavBar * {
    color: var(--bs-light) !important;
    text-shadow: 2px 2px #0000006b;
}

#topNavBar .dropdown-item {
    color: var(--bs-dark) !important;
    text-shadow: none !important;
}

.btn-explore {
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    border: none;
    color: #fff;
    font-size: 1.2rem;
    padding: 15px 30px;
    border-radius: 50px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.btn-explore:hover {
    background: linear-gradient(135deg, #2575fc 0%, #6a11cb 100%);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    transform: translateY(-3px);
}

header#cover .btn-container {
    animation: fadeInUp 1.5s ease-in-out;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    header#cover .btn-container {
        padding: 10px;
    }
}

</style>
<div class="w-100 h-100">
    <header id="cover">
        <div class="container-fluid h-100 d-flex justify-content-end align-items-end">
            <div class="w-100 py-3 pb-5 d-flex justify-content-center btn-container">
                <a href=".?page=vacancy" class="btn btn-explore wow slideInLeft">Explore Job Vacancies</a>
            </div>
        </div>
    </header>

    <div class="flex-grow-1 bg-light mb-0">
        <section class="wow slideInRight" data-wow-delay=".5s" data-wow-duration="1.5s">
            <div class="container">
                <?php echo html_entity_decode(file_get_contents('./welcome.html')) ?>
            </div>
        </section>
        <section class="bg-dark bg-gradient text-light wow bounceInUp">
            <div class="container py-3">
                <h3 class="text-center">About Us</h3>
                <div>
                    <?php echo html_entity_decode(file_get_contents('./about.html')) ?>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    $(document).scroll(function() { 
        $('#topNavBar').removeClass('bg-transaparent bg-dark')
        if($(window).scrollTop() === 0) {
           $('#topNavBar').addClass('bg-transaparent')
        }else{
           $('#topNavBar').addClass('bg-dark')
        }
    });
    $(function(){
        $(document).trigger('scroll')
    })
</script>