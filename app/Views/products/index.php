<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div id="productsSection" />

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="/js/products.js"></script>
<script>
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })

        function loadContent(page = 1) {
            const query = localStorage.getItem('query')
            const param = query ? `&q=${query}` : ''

            $.ajax({
                url: "/product?page=" + page + param,
                type: 'GET',
                dataType: "json",
                success: function(res) {
                    const {
                        content,
                        status,
                        message
                    } = res

                    if (!status) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error al cargar los datos'
                        })
                        return
                    }

                    $("#productsSection").html(content)
                }
            })
        }

        loadContent()
    })
</script>

<?= $this->endSection() ?>