<?php require_once 'app/Views/partials/header.template.php'; ?>
<body>
    <div class="container">
        <h1 class="center">Tasks:</h1>
            <?php require_once 'app/Views/partials/user.template.php'; ?>
        <div class="row todos">
            <a href="/tasks/create" class="btn btn-primary w-50 create">CREATE</a>
        </div>
        <div class="row todo-list">
            <?php foreach ($tasks->getTasks() as $task): ?>
            <h5><?php echo "{$task->getTitle()} <small>({$task->getCreatedAt()})</small>" ?></h5>
                <form method="post" action="/tasks/<?php echo $task->getId() ?>" class="btnForm">
                    <button type="submit" class="btn btn-warning btnDelete">DELETE</button>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>