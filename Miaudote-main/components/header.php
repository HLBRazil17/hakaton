<header class="p-4 bg-custom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="texto-header">
                <div class="logo-header">
                    <img src="components/assets/logomiau.svg" alt="Logo" class="logo">
                </div>
            </div>

            <ul class="nav col-12 col-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="home" class="nav-link px-2 <?php echo getActiveClass('home'); ?>">Home</a></li>
                <li><a href="adote" class="nav-link px-2 <?php echo getActiveClass('adote'); ?>">Adote</a></li>
                <li><a href="doe" class="nav-link px-2 <?php echo getActiveClass('doe'); ?>">Doe</a></li>
                <li><a href="contato" class="nav-link px-2 <?php echo getActiveClass('contato'); ?>">Entre em
                        contato</a></li>
            </ul>


            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control form-control-dark bg-custom" placeholder="Procurar..."
                    aria-label="Procurar">
            </form>
        </div>
    </div>
</header>