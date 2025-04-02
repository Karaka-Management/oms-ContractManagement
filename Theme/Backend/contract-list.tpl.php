<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\ContractManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View                            $this
 * @var \Modules\ContractManagement\Models\Contract[] $contracts
 */
$contracts = $this->data['contracts'] ?? [];

$previous = empty($contracts) ? '{/base}/contract/list' : '{/base}/contract/list?{?}&offset=' . \reset($contracts)->id . '&ptype=p';
$next     = empty($contracts) ? '{/base}/contract/list' : '{/base}/contract/list?{?}&offset=' . \end($contracts)->id . '&ptype=n';

$now = new \DateTime('now');

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Contracts'); ?>
            <a class="button end-xs save" href="<?= UriFactory::build('{/base}/contract/create'); ?>"><?= $this->getHtml('New', '0', '0'); ?></a>
        </div>
            <div class="slider">
            <table id="contractList" class="default sticky">
                <thead>
                <tr>
                    <td class="wf-100"><?= $this->getHtml('Title'); ?>
                        <label for="contractList-sort-1">
                            <input type="radio" name="contractList-sort" id="contractList-sort-1">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="contractList-sort-2">
                            <input type="radio" name="contractList-sort" id="contractList-sort-2">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('With'); ?>
                        <label for="contractList-sort-3">
                            <input type="radio" name="contractList-sort" id="contractList-sort-3">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="contractList-sort-4">
                            <input type="radio" name="contractList-sort" id="contractList-sort-4">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('End'); ?>
                        <label for="contractList-sort-5">
                            <input type="radio" name="contractList-sort" id="contractList-sort-5">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="contractList-sort-6">
                            <input type="radio" name="contractList-sort" id="contractList-sort-6">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                <tbody>
                <?php
                $count = 0;
                foreach ($contracts as $key => $value) :
                    ++$count;
                    $url = UriFactory::build('{/base}/contract/view?{?}&id=' . $value->id);

                    $type = 'ok';
                    if ($value->end !== null) {
                        if (($value->end->getTimestamp() < $now->getTimestamp() && $value->end->getTimestamp() + 7776000 > $now->getTimestamp())
                            || ($value->end->getTimestamp() > $now->getTimestamp() && $value->end->getTimestamp() - 7776000 < $now->getTimestamp())
                        ) {
                            $type = 'error';
                        } elseif ($value->end->getTimestamp() < $now->getTimestamp()) {
                            $type = 'info';
                        } elseif ($value->end->getTimestamp() + 7776000 < $now->getTimestamp()) {
                            $type = 'warning';
                        }
                    }
                ?>
                <tr tabindex="0" data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('Title'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->title); ?></a>
                    <td data-label="<?= $this->getHtml('Account'); ?>"><a class="content" href="<?= UriFactory::build('{/base}/profile/view?{?}&for=' . $value->account->id); ?>"><?= $this->printHtml($value->account->name1); ?> <?= $this->printHtml($value->account->name2); ?></a>
                    <td data-label="<?= $this->getHtml('End'); ?>">
                        <?php if ($value->end !== null) : ?>
                        <a href="<?= $url; ?>"><span class="tag <?= $type;  ?>"><?= $value->end !== null ? $value->end->format('Y-m-d') : ''; ?></span></a>
                        <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                    <?php endif; ?>
            </table>
            </div>
            <!--
            <div class="portlet-foot">
                <a tabindex="0" class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
                <a tabindex="0" class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
            </div>
            -->
        </section>
    </div>
</div>
