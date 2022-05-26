<?php
/**
 * @var BackOfficeRequest[] $requests
 */

use ErasmusHelper\Models\BackOfficeRequest;

?>
<div class="box col-12">
    <div class="box-content">
        <div class="table-wrapper">
            <table class="table <?= empty($requests) ? 'empty' : '' ?>">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Content</th>
                </tr>
                <?php if(!empty($requests)) {
                    foreach ($requests as $request):
                        if($request->status != 0) {
                        ?>
                        <tr bgcolor="<?php if($request->status == 1) { ?> lightgreen <?php } else { ?> lightgray <?php } ?>">
                            <td><?= $request->title; ?></td>
                            <td><?= $request->author; ?></td>
                            <td><?= date("d-m-Y H:i:s", strtotime($request->date['date'])); ?></td>
                            <td><?= $request->content; ?></td>
                        </tr>
                <?php
                        }
                    endforeach;
                }
                ?>
            </table>
        </div>
    </div>
</div>