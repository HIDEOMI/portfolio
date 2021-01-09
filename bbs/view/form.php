<?php
/// ログイン状態のチェック ///
require_logined_session();
?>

<div id="main_container">

    <!-- 案件投稿フォーム開始 -->
    <form action="./index.php" method="POST" role="form" id="form_job">
        <table>
            <tbody>
                <tr id="row_job_title" class="form_job_row">
                    <th>
                        <label>案件名</label>
                    </th>
                    <td>
                        <input type="text" name="title" id="input_job_title" class="form_job_input" placeholder="案件名" size="60" required />
                    </td>
                </tr>
                <tr id="row_job_number" class="form_job_row">
                    <th>
                        <label>案件No</label>
                    </th>
                    <td>
                        <input type="text" name="job_id" class="form_job_input" placeholder="案件No" required />
                    </td>
                </tr>
                <tr id="row_job_type" class="form_job_row">
                    <th>
                        <label>雇用タイプ</label>
                    </th>
                    <td>
                        <select name="type" class="form_job_input" size="3" required>
                            <option value="派遣">派遣</option>
                            <option value="紹介予定派遣">紹介予定派遣</option>
                            <option value="正社員・派遣社員">正社員・派遣社員</option>
                        </select>
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>おすすめポイント</label>
                    </th>
                    <td>
                        <textarea name="tips" cols="60" rows="5" class="form_job_input" placeholder="おすすめポイント" required></textarea>
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>給与</label>
                    </th>
                    <td>
                        <input type="text" name="wage" class="form_job_input" placeholder="給与" required />
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>職種</label>
                    </th>
                    <td>
                        <input type="text" name="occupation" class="form_job_input" placeholder="職種" required />
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>業種</label>
                    </th>
                    <td>
                        <input type="text" name="industry" class="form_job_input" placeholder="業種" required />
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>勤務地</label>
                    </th>
                    <td>
                        <textarea name="work_location" cols="40" rows="3" class="form_job_input" placeholder="勤務地" required></textarea>
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>仕事内容</label>
                    </th>
                    <td>
                        <textarea name="description" cols="60" rows="10" class="form_job_input" placeholder="仕事内容" required></textarea>
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>スキル</label>
                    </th>
                    <td>
                        <textarea name="skill" cols="40" rows="3" class="form_job_input" placeholder="スキル" required></textarea>
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>勤務時間</label>
                    </th>
                    <td>
                        <textarea name="hours" cols="40" rows="3" class="form_job_input" placeholder="勤務時間" required></textarea>
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>休日</label>
                    </th>
                    <td>
                        <input type="text" name="holiday" class="form_job_input" placeholder="休日" required />
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>勤務期間</label>
                    </th>
                    <td>
                        <input type="text" name="working_period" class="form_job_input" placeholder="勤務期間" required />
                    </td>
                </tr>
                <tr class="form_job_row">
                    <th>
                        <label>職場について</label>
                    </th>
                    <td>
                        <textarea name="working_info" cols="40" rows="3" class="form_job_input" placeholder="職場について" required></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="btn_job_container">
            <button type="submit" class="btn_job" id="btn_upload" name="event_id" value="saveJobInfo">案件を登録</button>
            <a href="./index.php" class="btn_job" id="btn_cancel">キャンセル</a>
        </div>
    </form>
    <!-- 案件投稿フォーム終了 -->

</div>