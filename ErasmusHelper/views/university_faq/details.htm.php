<?php
/**
 * @var UniversityFaq[] $university_faqs ;
 * @var UniversityFaq $university_faq ;
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\UniversityFaq;

?>
<div class="row">
    <div class="col box">
        <div class="box-header">
            <span class="box-title"><?= $university_faq->question ?></span>
        </div>
        <form method="POST" action="<?= Router::route('university_faq.edit', ["id" => $university_faq->id]) ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Question</div>
                    <input name="question" class="value" type="text" value="<?= $university_faq->question ?>"/>
                </div>
                <div class="field">
                    <div class="label">Reply</div>
                    <textarea name="reply" class="value" rows="5"><?= $university_faq->reply ?></textarea>
                </div>
                <div class="box-content">
                    <div class="field">
                        <div class="label">Order</div>
                        <input name="order" class="value" type="number" min="1"
                               max="<?= isset($university_faqs) ? count($university_faqs) : 1 ?>"
                               value="<?= $university_faq->order ?>">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('university_faqs') ?>" class="button">Cancel</a>
                    <?php if (empty($cities)) { ?>
                        <a onclick="confirm('Confirm the deletion of the FAQ item ?') ? window.location = '<?= Router::route('university_faq.delete', ["id" => $university_faq->id]) ?>' : void(0)"
                           class="button red">Delete</a>
                    <?php } ?>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>