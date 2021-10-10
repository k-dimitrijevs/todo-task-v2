<?php require_once 'app/Views/partials/header.template.php'; ?>
<body>
    <?php require_once 'app/Views/partials/user.template.php'; ?>
    <div class="container">
<!--        <p>--><?php //echo $user->getUsername() ?><!--</p>-->
<!--        <p>--><?php //echo $user->getEmail() ?><!--</p>-->
        <div class="row">
            <h1>Add new task:</h1>
        </div>
        <div class="row">
            <div class="form-group">
                <form action="/tasks" method="post">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control" name="title" placeholder="Add new task to todo-list" /><br>
                    <button type="submit" class="btn btn-primary">Create</button><br><br>
                </form>
            </div>
        </div>
        <a href="/tasks" class="btn btn-primary">BACK</a>
    </div>
</body>
</html>