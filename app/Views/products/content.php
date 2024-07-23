<?php
$currentPage = $pager->getCurrentPage();

$totalPages = ceil($total / $perPage);

function makeLinks($currentPage, $perPage, $total, $url)
{
    $totalPages = ceil($total / $perPage);
    $html = '<nav aria-label="Page navigation"><ul class="pagination">';

    // Botón de anterior
    if ($currentPage > 1) {
        $html .= '<li class="page-item"><button class="page-link" data-page="' . ($currentPage - 1) . '">Previous</button></li>';
    }

    // Enlaces de páginas
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $html .= '<li class="page-item"><button class="page-link" data-page="' . $i . '">' . $i . '</button></li>';
        }
    }

    // Botón de siguiente
    if ($currentPage < $totalPages) {
        $html .= '<li class="page-item"><button class="page-link" data-page="' . ($currentPage + 1) . '">Next</button></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }

    $html .= '</ul></nav>';
    return $html;
}

$url = '';

$paginationLinks = makeLinks($currentPage, $perPage, $total, $url);
?>

<div class="container">
    <h1>Lista de Productos</h1>
    <div class="d-flex justify-content-between py-3">
        <form class="d-flex" id="searchForm">
            <input class="form-control me-2" id="search" type="search" placeholder="Buscar" aria-label="Search">
        </form>

        <div>
            <button class="btn btn-primary logs">Logs de Acciones</button>
            <button class="btn btn-primary add-item">Agregar Producto</button>
        </div>
    </div>
    <table class="table mt-3">
        <thead>
            <tr class="text-center">
                <th>Titulo</th>
                <th>Precio</th>
                <th>Fecha creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="itemsTable" class="table-tbody">
            <?php foreach ($products as $item) : ?>
                <tr data-id="<?= $item['id']; ?>">
                    <td class="item-title text-center"><?= $item['title']; ?></td>
                    <td class="item-price text-center">$<?= $item['price']; ?></td>
                    <td class="item-created text-center"><?= $item['created_at']; ?></td>
                    <td class="text-center">
                        <a class="btn btn-primary edit-item" data-id="<?= $item['id']; ?>" data-title="<?= $item['title']; ?>" data-price="<?= $item['price']; ?>" data-created="<?= $item['created_at']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                        </a>
                        <a class="btn btn-danger delete-item" data-id="<?= $item['id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center table-pagination">
        <?= $paginationLinks ?>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modificar</h5>
                    <button type="button" class="close btn btn-dark close-button" data-dismiss="editModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTitle">Titulo</label>
                        <input type="text" class="form-control" id="editTitle" name="editTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="editPrice">Precio</label>
                        <input type="number" class="form-control" id="editPrice" name="editPrice" required>
                    </div>
                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" id="createdAt" name="createdAt">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-button">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createForm" method="post">
                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Agregar producto</h5>
                    <button type="button" class="close btn btn-dark close-button" data-dismiss="createModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Precio</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-button">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close btn btn-dark close-button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Seguro de que deseas eliminar este producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-button" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/products.js"></script>