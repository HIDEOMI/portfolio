<?php
/// 総ページ数の取得 ///
$total_page = ceil($job_counts / $display_count);
/// ページネーションの数字を取得 ///
$array_pages = [];
if ($total_page <= 5) {
    /// 総ページ数が5ページ以下の場合、全ページをページネーションとして取得 ///
    for ($i = 1; $i <= $total_page; $i++) {
        $array_pages[] = $i;
    }
} else {
    /// 総ページ数が5ページより多い場合 ///
    if ($page < 3) {
        $array_pages = [1, 2, 3, 4, 5];
    } else if (($page >= 3) && ($total_page - $page > 2)) {
        $array_pages = [$page - 2, $page - 1, $page, $page + 1, $page + 2];
    } else {
        $array_pages = [$total_page - 4, $total_page - 3, $total_page - 2, $total_page - 1, $total_page];
    }
}
?>

<!-- ページネイション -->
<form action="./index.php" method="GET" role="form" class="pagination_form">
    <ul class="pagination_list">
        <?php if ($page >= 2) : ?>
            <li class="pagination_item">
                <a class="pagination_link" href="<?php get_requets_of(array('page' => 1)); ?>">最初</a>
            </li>
            <li class="pagination_item">
                <a class="pagination_link" href="<?php get_requets_of(array('page' => $page - 1)); ?>"">前</a>
            </li>
        <?php endif; ?>
        <?php if (($total_page >= 7) && ($page >= 4)) : ?>
            <li class=" pagination_item">
                    <p>...</p>
            </li>
        <?php endif; ?>
        <?php foreach ($array_pages as $target_page) : ?>
            <li class="pagination_item">
                <a <?php if ($target_page == $page) echo "id='pagination_selected'"; ?> class="pagination_link" href="<?php get_requets_of(array('page' => $target_page)); ?>"><?php echo $target_page ?></a>
            </li>
        <?php endforeach; ?>
        <?php if (($total_page >= 7) && ($total_page - $page >= 3)) : ?>
            <li class="pagination_item">
                <p>...</p>
            </li>
        <?php endif; ?>
        <?php if ($total_page - $page >= 1) : ?>
            <li class="pagination_item">
                <a class="pagination_link" href="<?php get_requets_of(array('page' => $page + 1)); ?>">次</a>
            </li>
            <li class=" pagination_item">
                <a class="pagination_link" href="<?php get_requets_of(array('page' => $total_page)); ?>">最後</a>
            </li>
        <?php endif; ?>
    </ul>
</form>