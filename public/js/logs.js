$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })
    
    function loadContent(page = 1) {
        localStorage.setItem('page', page)

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
    
    $('.page-link').on('click', function () {
        const page = $(this).data('page');
        loadContent(page)
    });
})