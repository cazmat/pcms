<?php
/**
 * Pagination Partial Template
 *
 * Displays pagination controls for both frontend and admin.
 * Expects $pagination array with pagination data from getPaginationData()
 */

// Only show pagination if there's more than one page
if (!isset($pagination) || $pagination['total_pages'] <= 1) {
    return;
}
?>

<nav class="pagination" aria-label="Pagination">
    <ul class="pagination-list">
        <!-- Previous Button -->
        <?php if ($pagination['has_prev']): ?>
            <li>
                <a href="<?php echo e($pagination['base_url']); ?>?page=<?php echo $pagination['prev_page']; ?>"
                   class="pagination-link" aria-label="Previous page">
                    &laquo; Previous
                </a>
            </li>
        <?php else: ?>
            <li>
                <span class="pagination-link pagination-disabled" aria-disabled="true">
                    &laquo; Previous
                </span>
            </li>
        <?php endif; ?>

        <!-- First Page + Ellipsis -->
        <?php if ($pagination['show_first']): ?>
            <li>
                <a href="<?php echo e($pagination['base_url']); ?>?page=1"
                   class="pagination-link">
                    1
                </a>
            </li>
            <?php if ($pagination['start_page'] > 2): ?>
                <li><span class="pagination-ellipsis">...</span></li>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php for ($i = $pagination['start_page']; $i <= $pagination['end_page']; $i++): ?>
            <li>
                <?php if ($i == $pagination['current_page']): ?>
                    <span class="pagination-link pagination-current" aria-current="page">
                        <?php echo $i; ?>
                    </span>
                <?php else: ?>
                    <a href="<?php echo e($pagination['base_url']); ?>?page=<?php echo $i; ?>"
                       class="pagination-link">
                        <?php echo $i; ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endfor; ?>

        <!-- Ellipsis + Last Page -->
        <?php if ($pagination['show_last']): ?>
            <?php if ($pagination['end_page'] < $pagination['total_pages'] - 1): ?>
                <li><span class="pagination-ellipsis">...</span></li>
            <?php endif; ?>
            <li>
                <a href="<?php echo e($pagination['base_url']); ?>?page=<?php echo $pagination['total_pages']; ?>"
                   class="pagination-link">
                    <?php echo $pagination['total_pages']; ?>
                </a>
            </li>
        <?php endif; ?>

        <!-- Next Button -->
        <?php if ($pagination['has_next']): ?>
            <li>
                <a href="<?php echo e($pagination['base_url']); ?>?page=<?php echo $pagination['next_page']; ?>"
                   class="pagination-link" aria-label="Next page">
                    Next &raquo;
                </a>
            </li>
        <?php else: ?>
            <li>
                <span class="pagination-link pagination-disabled" aria-disabled="true">
                    Next &raquo;
                </span>
            </li>
        <?php endif; ?>
    </ul>

    <div class="pagination-info">
        Showing page <?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?>
        (<?php echo $pagination['total_items']; ?> total <?php echo $pagination['total_items'] == 1 ? 'item' : 'items'; ?>)
    </div>
</nav>

<style>
.pagination {
    margin: 30px 0;
    text-align: center;
}

.pagination-list {
    list-style: none;
    padding: 0;
    margin: 0 0 10px 0;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 5px;
}

.pagination-list li {
    display: inline-block;
}

.pagination-link {
    display: inline-block;
    padding: 8px 12px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #333;
    text-decoration: none;
    transition: all 0.2s;
    min-width: 40px;
    text-align: center;
}

.pagination-link:hover:not(.pagination-disabled):not(.pagination-current) {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.pagination-current {
    background: #667eea;
    color: white;
    border-color: #667eea;
    font-weight: bold;
}

.pagination-disabled {
    background: #f5f5f5;
    color: #999;
    cursor: not-allowed;
}

.pagination-ellipsis {
    padding: 8px 4px;
    color: #999;
}

.pagination-info {
    font-size: 14px;
    color: #666;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pagination-link {
        padding: 6px 10px;
        font-size: 14px;
        min-width: 35px;
    }

    .pagination-list {
        gap: 3px;
    }
}
</style>
