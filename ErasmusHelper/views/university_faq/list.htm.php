<?php
/** @var UniversityFaq[] $university_faqs */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\UniversityFaq;

?>

<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($university_faqs) ? 'empty' : '' ?>">
                    <tr>
                        <th>Question</th>
                        <th>Reply</th>
                        <th>Order</th>
                        <th><a class="button" href="<?= Router::route('university_faq.create.page') ?>"><i
                                        class="fas fa-plus r"></i>Add a FAQ Item</a></th>
                    </tr>
                    <?php
                    if (!empty($university_faqs)) {
                        foreach ($university_faqs as $faq): ?>
                            <tr>
                                <td><?= $faq->question ?></td>
                                <td><?= $faq->reply ?></td>
                                <td><?= $faq->order ?></td>
                                <td><a class="button" href="<?= Router::route('university_faq', ["id" => $faq->id]) ?>"><i
                                                class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>
