<!-- ページソート -->
<div class="job_sort">
    <p class="job_sort_number">
        <?php echo $job_counts; ?><span>件</span>
    </p>
    <form action="./index.php" method="GET" role="form" class="job_sort_form">
        <ul class="job_sort_list">
            <!-- <li class="job_sort_item"> -->
                <!-- <p class="job_sort_label">並び順</p> -->
                <!-- <select class="job_sort_select" name="sort_type" onchange="submit()"> -->
                    <!-- <option value="new" <?php if ($_GET['sort_type'] == "new") echo 'selected'; ?>>新着順</option> -->
                    <!-- <option value="wage" <?php if ($_GET['sort_type'] == "wage") echo 'selected'; ?>>給与順</option> -->
                <!-- </select> -->
            <!-- </li> -->
            <li class="job_sort_item">
                <p class="job_sort_label">表示件数</p>
                <select class="job_sort_select" name="display_count" onchange="submit()">
                    <option value="10" <?php if ($_GET['display_count'] == "10") echo 'selected'; ?>>10件</option>
                    <option value="50" <?php if ($_GET['display_count'] == "50") echo 'selected'; ?>>50件</option>
                    <option value="100" <?php if ($_GET['display_count'] == "100") echo 'selected'; ?>>100件</option>
                </select>
            </li>
        </ul>
    </form>
</div>