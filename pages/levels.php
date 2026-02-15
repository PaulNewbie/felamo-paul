<?php include("components/header.php"); ?>

<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">

<div class="container py-4">

    <h4 class="text-main mb-3">
        <i class="bi bi-layers-fill me-2"></i>Mga Markahan
    </h4>

    <div class="card shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-diagram-3 me-1"></i>Markahan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="antas-table-tbody"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include("components/footer-scripts.php"); ?>
<script src="scripts/levels.js?v=1"></script>
<?php include("components/footer.php"); ?>