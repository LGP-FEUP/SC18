<?php
/** @var Faculty[] $faculties */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Faculty;

?>
<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($faculties) ? 'empty' : '' ?>">
                    <tr>
                        <th>Identifier</th>
                        <th>Name</th>
                        <th>City</th>
                        <th><a class="button" href="<?= Router::route('faculty.create.page') ?>" ><i class="fas fa-plus r"></i>Add a faculty</a></th>
                    </tr>
                    <?php
                    if(!empty($faculties)) {
                        foreach ($faculties as $faculty): ?>
                            <tr>
                                <td><?= $faculty->id; ?></td>
                                <td><?= $faculty->name; ?></td>
                                <td><?= $faculty->getCity()->name; ?></td>
                                <td><a class="button" href="<?= Router::route('faculty', ["id" => $faculty->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>