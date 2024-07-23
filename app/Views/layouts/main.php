<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.4/sweetalert2.min.css" integrity="sha512-Ls19wNglxCDcP78k23k5MygHFHAamARZWDggNovFF3XM4nFTgJz28wBM3m76/bqxvaGWvLKwsv/toFoLqhF8Gg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('css/main.css'); ?>">
</head>

<body>
    <nav class="navbar navbar-expand-lg px-5">
        <div class="container-fluid px-5">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav w-100 d-space-between">
                    <li class="nav-item">
                        <a class="navbar-brand" href="/">
                            <img src="/assets/e-degrade.svg" alt="" width="30" height="24">
                        </a>
                    </li>
                    <li class="nav-item">
                        <?= session()->has('username') ? '<div class="d-flex align-items-center spacing-05">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#597e8d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                          <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                          <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                        </svg>
                        Bienvenido, ' . session()->get("username") . '</div>' : '<a class="nav-link" aria-current="page" href="/login">Login</a>' ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.4/sweetalert2.min.js" integrity="sha512-Lbwer45RtGISU+efaUoil1EFYFliqkKOaZhUMXG8RoZZ5fdjpK4S/2khwZynw8vyItDeaRZ+IE6XdKA6XCsyxQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>