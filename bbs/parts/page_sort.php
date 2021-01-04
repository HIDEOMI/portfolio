<!-- ページソート -->
<div class="job_sort">
    <p class="job_sort_number">
        <?php echo $job_counts; ?>
        <span>件</span>
    </p>
    <ul class="job_sort_list">
        <li class="job_sort_item">
            <p class="job_sort_label">並び順</p>
            <select class="job_sort_select" name="" id="sortType">
                <option value="">新着順</option>
                <option value="">給与順</option>
            </select>
        </li>
        <li class="job_sort_item">
            <p class="job_sort_label">表示件数</p>
            <select class="job_sort_select" name="" id="displayCount">
                <option value="">10件</option>
                <option value="">50件</option>
                <option value="">100件</option>
            </select>
        </li>
    </ul>
</div>
