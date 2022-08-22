<?php $pages=get_pages_data(); update_pana_pages($_POST); ?>
<div class="wrap">
    <h1>PANA Pages</h1>
</div>
<style>
    table { width: 80% !important; }
    textarea { width: 100% !important; resize: none;  }
    .pull-right { float: right; }
</style>
<form action="" method="POST">
    <table class="form-table">
        <?php if(!empty($pages)): foreach($pages as $pagesa): ?>
        <tr valign="top">
            <th scope="row">
                <label for="<?=$pagesa['key']?>"><?=$pagesa['label']?></label>
            </th>
            <td>
                <textarea name="<?=$pagesa['key']?>" rows="3"><?=$pagesa['value']?></textarea>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2">
                <input type="submit" name="updatePANAPages" class="button button-primary pull-right" value="Update" />
            </td>
        </tr>
        <?php else: ?>
        <tr><td colspan="2">Pages data not found</td></tr>
        <?php endif; ?>
    </table>
</form>
