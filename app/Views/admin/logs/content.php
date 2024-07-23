<?php
$currentPage = $pager->getCurrentPage();

$totalPages = ceil($total / $perPage);

function makeLinks($currentPage, $perPage, $total)
{
    $totalPages = ceil($total / $perPage);
    $html = '<nav aria-label="Page navigation"><ul class="pagination">';

    if ($currentPage > 1) {
        $html .= '<li class="page-item"><button class="page-link" data-page="' . ($currentPage - 1) . '">Previous</button></li>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $html .= '<li class="page-item"><button class="page-link" data-page="' . $i . '">' . $i . '</button></li>';
        }
    }

    if ($currentPage < $totalPages) {
        $html .= '<li class="page-item"><button class="page-link" data-page="' . ($currentPage + 1) . '">Next</button></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }

    $html .= '</ul></nav>';
    return $html;
}

$paginationLinks = makeLinks($currentPage, $perPage, $total);
?>

<div class="container">
    <h1>Logs</h1>
    
    <div class="d-flex justify-content-between py-3">
        <div />

        <div>
            <a href="/" class="btn btn-primary">Listado de productos</a>
        </div>
    </div>

    <table class="table mt-3">
        <thead>
            <tr class="text-center">
                <th>Usuario</th>
                <th>Acción</th>
                <th>Fecha creación</th>
            </tr>
        </thead>
        <tbody id="itemsTable" class="table-tbody">
            <?php foreach ($logs as $item) : ?>
                <tr>
                    <td class="item-title text-center"><?= $item['user']; ?></td>
                    <td class="item-price text-center"><?= $item['action']; ?></td>
                    <td class="item-created text-center"><?= $item['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center table-pagination">
        <?= $paginationLinks ?>
    </div>
</div>

<script src="/js/logs.js"></script>