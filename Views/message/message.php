<?php if (isset($_SESSION['error']) || isset($error)): ?>
    <?php $error = $_SESSION['error'] ??= $error ??= null ?>
    <?php if (is_string($error)): ?>
        <section class="alert mt-4 alert-danger alert-dismissible fade show" id="alert" role="alert">
            <strong class="text-danger"><?= $error ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </section>
    <?php else: ?>
        <?php foreach ($error as $errorArray): ?>
            <?php foreach ($errorArray as $error):?>
                <section class="alert mt-4 alert-danger alert-dismissible fade show" id="alert" role="alert">
                    <strong class="text-danger"><?= $error ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </section>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php unset($_SESSION['error']) ?>
<?php endif; ?>

<?php if (isset($_SESSION['success']) || isset($success)): ?>
    <?php $success = $_SESSION['success'] ??= $success ??= null ?>
    <section class="alert mt-4 alert-success alert-dismissible fade show" id="alert" role="alert">
        <strong class="text-success"><?= $success ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </section>
    <?php unset($_SESSION['success']) ?>
<?php endif; ?>