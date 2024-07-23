<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div id="logsSection" />

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function loadContent(page = 1) {
        $.ajax({
            url: "/api/logs?page=" + page,
            type: 'GET',
            dataType: "json",
            success: function(res) {
                const {
                    content,
                    status,
                } = res

                if (!status) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error al cargar los datos'
                    })
                    return
                }

                $("#logsSection").html(content)
            }
        })
    }

    loadContent()
</script>

<?= $this->endSection() ?>
