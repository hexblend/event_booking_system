<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">South Venues</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item pt-2 mr-1 text-light">Welcome back,</li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?=$_SESSION['logged_in']?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <form action="features/login_sys/logout.php" method="POST">
                            <button type="submit" class="dropdown-item btn btn-block">Log out</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>


