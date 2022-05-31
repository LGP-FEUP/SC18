<?php
/**
 * @var Faculty[] $faculties
 * @var Faculty $faculty
 */

use ErasmusHelper\App;
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
                        <th>Code</th>
                        <th>Name</th>
                        <th>City</th>
                        <th><?php if(App::getInstance()->auth->getPrivilegeLevel() <= CITYMODERATORS_PRIVILEGES) { ?><a class="button" href="<?= Router::route('faculty.create.page') ?>" ><i class="fas fa-plus r"></i>Add a faculty</a><?php } ?></th>
                    </tr>
                    <?php
                    if(!empty($faculties)) {
                        foreach ($faculties as $faculty): ?>
                            <tr>
                                <td><?= $faculty->id; ?></td>
                                <td><?= $faculty->code; ?></td>
                                <td><?= $faculty->name; ?></td>
                                <td><?= $faculty->getCity()->name; ?></td>
                                <td><a class="button" href="<?= Router::route('faculty', ["id" => $faculty->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td><?= $faculty->id; ?></td>
                            <td><?= $faculty->code; ?></td>
                            <td><?= $faculty->name; ?></td>
                            <td><?= $faculty->getCity()->name; ?></td>
                            <td><a class="button" href="<?= Router::route('faculty', ["id" => $faculty->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>