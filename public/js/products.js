$(document).ready(function () {
    let deleteId = null;

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })
    $('#search').val(localStorage.getItem('query'))

    function loadContent(page = 1, query) {
        localStorage.setItem('page', page)
        const param = query ? `&q=${query}` : ''

        $.ajax({
            url: "/product?page=" + page + param,
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

                $("#productsSection").html(content)
            }
        })
    }

    function checkUserLoggedIn() {
        const token = localStorage.getItem('token');

        if(token){
            return true;
        }

        Swal.fire({
            title: '<strong>Acceso denegado</strong>',
            html: 'No tiene permisos para realizar esta accion',
            icon: 'error',
            showConfirmButton: false,
            allowOutsideClick: false,
            footer:`<a class="btn btn-primary" href="/login">Ingresar</a>`,
        });
        return false;
    }
    
    $('.logs').on('click', function () {
        const loggedIn = checkUserLoggedIn()

        if(loggedIn){
            location.replace('/logs')
        }
    });

    $('.page-link').on('click', function () {
        const page = $(this).data('page');
        const query = $('#search').val();
        loadContent(page, query)
    });

    $('.close-button').on('click', function () {
        $('#editModal').modal('hide');
        $('#createModal').modal('hide');
        $('#confirmDeleteModal').modal('hide');
    });

    $('.delete-item').on('click', function () {
        checkUserLoggedIn()

        deleteId = $(this).data('id');
        $('#confirmDeleteModal').modal('show');
    });

    $('.logs').on('click', function () {
        checkUserLoggedIn()

    });

    $('.edit-item').on('click', function () {
        checkUserLoggedIn()

        const id = $(this).data('id');
        const title = $(this).data('title');
        const price = $(this).data('price');
        const created = $(this).data('created');

        $('#editId').val(id);
        $('#editTitle').val(title);
        $('#editPrice').val(price);
        $('#createdAt').val(created);

        $('#editModal').modal('show');
    });

    $('.add-item').on('click', function () {
        checkUserLoggedIn()
      
        $('#createModal').modal('show');
    });

    $('#confirmDeleteButton').on('click', function () {
        if (deleteId !== null) {
            $.ajax({
                url: 'product-delete',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: deleteId,
                },
                success: function (res) {
                    const {
                        status,
                    } = res
    
                    if (!status) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error al eliminar'
                        })
                        return
                    }

                    $('#confirmDeleteModal').modal('hide');
                    $('tr[data-id="' + deleteId + '"]').remove();
                    Toast.fire({
                        icon: 'success',
                        title: 'Eliminado con exito'
                    })
                },
            });
        }
    });

    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#editId').val();
        const title = $('#editTitle').val();
        const price = $('#editPrice').val();
        const created = $('#createdAt').val();

        $.ajax({
            url: '/product',
            type: 'PUT',
            data: {
                id: id,
                title: title,
                price: price,
                created_at: created
            },
            dataType: 'json',
            success: function (res) {
                const {
                    status,
                } = res

                if (!status) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error al editar'
                    })
                    return
                }

                const row = $('tr[data-id="' + id + '"]');
                row.find('.item-title').text(title);
                row.find('.item-price').text('$' + price);

                row.find('.edit-item').data('title', title);
                row.find('.edit-item').data('price', price);

                Toast.fire({
                    icon: 'success',
                    title: 'Actualizado con exito'
                })

                $('#editModal').modal('hide');
            },
            error: function (error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Ocurrió un error inesperado'
                })
            }
        });
    });

    $('#createForm').on('submit', async function (e) {
        e.preventDefault();
        const title = $('#title').val();
        const price = $('#price').val();

        try {
            const res = await $.ajax({
                url: '/product',
                type: 'POST',
                dataType: 'json',
                data: {
                    title: title,
                    price: price
                },
            });
    
            const { status } = res
    
            if (!status) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al agregar el producto'
                })
                return;
            }
    
            Toast.fire({
                icon: 'success',
                title: 'Agregado con exito'
            })
    
            const currentPage = localStorage.getItem('page');

            $('#createModal').modal('hide');

            loadContent(currentPage)
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ocurrio un error inesperado'
            })
        } 
    });

    $('#searchForm').on('submit', function (e) {
        e.preventDefault();

        const query = $('#search').val();

        localStorage.setItem('query', query);

        loadContent(1, query);
    });
});