<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<main class="form-signin text-center pt-5">
    <form id="loginForm" method="post">
        <?= csrf_field() ?>

        <img class="mb-4" src="/assets/e-degrade.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="d-flex spacing-1 flex-col">
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" value="admin@test.com" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" value="123123" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
        </div>

        <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Sign in</button>
    </form>
</main>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="/js/auth.js"></script>

<?= $this->endSection('content') ?>

