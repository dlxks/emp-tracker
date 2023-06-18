<!-- Alert Banner -->
<?php if (isset($_COOKIE['data_err_message'])) {
?>
    <div class="alert <?= $_COOKIE['data_message_class']; ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_COOKIE['data_err_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
<?php
}
?>
<!-- End Alert Banner -->