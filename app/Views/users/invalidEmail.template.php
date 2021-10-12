<?php require_once 'app/Views/partials/header.template.php'; ?>
<body>
<div class="container">
    <div class="row">
        <h2>User with this e-mail already exists</h2>
        <h3 class="errorView">Please try again!</h3>
        <a href="/register" class="btn btn-primary w-25 try-again">Try Again</a>
        <h3 class="errorView">Or sign in!</h3>
        <a href="/login" class="btn btn-primary w-25 try-again">Sign in</a>
    </div>
</div>
</body>
