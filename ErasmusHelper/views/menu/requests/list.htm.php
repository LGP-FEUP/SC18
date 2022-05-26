<?php

use ErasmusHelper\Controllers\Router; ?>
<div class="box col-12">
    <div class="box-content">
        <div class="table-wrapper">
            <table class="table <?= empty($requests) ? 'empty' : '' ?>">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th><a class="button" onclick="genHistoryModal();"><i class="far fa-eye r"></i>History</a></th>
                </tr>
                <?php if(!empty($requests)) {
                    foreach ($requests as $request):
                        if($request->status == 0) {
                            ?>
                        <tr>
                            <td><?= $request->title; ?></td>
                            <td><?= $request->author; ?></td>
                            <td><?= date("d-m-Y H:i:s", strtotime($request->date['date'])); ?></td>
                            <td><a class="button" onclick='genDetailsModal("<?= $request->id ?>");'><i class="far fa-eye r"></i>Details</a></td>
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

<script type="text/javascript">
    let detailsModal;
    let historyModal;

    function genDetailsModal(requestId) {
        detailsModal = new Modal({
            view_url: '<?= Router::route('menu.request') ?>',
            view_data: requestId,
            title: requestId
        });
        detailsModal.build();
        detailsModal.show();
    }
    function genHistoryModal() {
        if(historyModal === undefined) {
            historyModal = new Modal({
                view_url: '<?= Router::route('menu.request.history') ?>',
                title: 'Requests History'
            });
            historyModal.build();
        }
        historyModal.show();
    }
</script>
