# Paginator
Simple but powerful PHP pagination class

# Usage
$rowsCount = Number of Rows from the Query.
$endPath = URL of the page you want the pagination to work.
$rowsPerPage = Number of rows per page.

$pagination = new Paginator($rowsCount,$endPath,$rowsPerPage);  // Create Pagination object.

$pagination->getOffset(); // Gets the offset for MySQL Query.

$pagination->hasPages(); // True if you have more rows count than rows per page.


Sample PHP Code after setting up pagination object.

<?php $elements = $paginator->getPagingElements(); ?>
<nav class="app-pagination" aria-label="...">
    <ul class="pagination justify-content-center">
        <?php if ($paginator->onFirstPage()) { ?>
            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
        <?php } else { ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $paginator->previousPageUrl(); ?>" tabindex="-1" aria-disabled="false">Previous</a>
            </li>
        <?php }
        foreach ($elements as $element) {
            if (is_string($element)) { ?>
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)" aria-disabled="true"><?php echo $element; ?></a>
                </li>
            <?php }
            if (is_array($element)) {
                if ($element['page'] == $paginator->currentPage()) { ?>
                    <li class="page-item active">
                        <a class="page-link" href="javascript:void(0)" aria-disabled="true"><?php echo $element['page']; ?></a>
                    </li>
                <?php } else { ?>
                    <li class="page-item ">
                        <a class="page-link" href="<?php echo $element["link"];?>"><?php echo $element["page"];?></a>
                    </li>
                <?php }
            }
        }
        if ($paginator->hasMorePages()) { ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $paginator->nextPageUrl(); ?>" tabindex="-1" aria-disabled="false">Next</a>
            </li>
        <?php } else { ?>
            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">Next</a>
            </li>
        <?php } ?>
    </ul>
</nav>

