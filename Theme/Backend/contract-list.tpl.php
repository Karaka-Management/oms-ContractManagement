<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\ContractManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View                            $this
 * @var \Modules\ContractManagement\Models\Contract[] $contracts
 */
$contracts = $this->getData('contracts') ?? [];

$previous = empty($contracts) ? '{/base}/contract/list' : '{/base}/contract/list?{?}&id=' . \reset($contracts)->id . '&ptype=p';
$next     = empty($contracts) ? '{/base}/contract/list' : '{/base}/contract/list?{?}&id=' . \end($contracts)->id . '&ptype=n';

$now = new \DateTime('now');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Contracts'); ?><i class="lni lni-download download btn end-xs"></i></div>
            <div class="slider">
            <table id="contractList" class="default sticky">
                <thead>
                <tr>
                    <td class="wf-100"><?= $this->getHtml('Title'); ?>
                        <label for="contractList-sort-1">
                            <input type="radio" name="contractList-sort" id="contractList-sort-1">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="contractList-sort-2">
                            <input type="radio" name="contractList-sort" id="contractList-sort-2">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td class="wf-100"><?= $this->getHtml('With'); ?>
                        <label for="contractList-sort-3">
                            <input type="radio" name="contractList-sort" id="contractList-sort-3">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="contractList-sort-4">
                            <input type="radio" name="contractList-sort" id="contractList-sort-4">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td><?= $this->getHtml('End'); ?>
                        <label for="contractList-sort-5">
                            <input type="radio" name="contractList-sort" id="contractList-sort-5">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="contractList-sort-6">
                            <input type="radio" name="contractList-sort" id="contractList-sort-6">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                <tbody>
                <?php foreach ($contracts as $key => $value) :
                    $url = UriFactory::build('{/base}/contract/single?{?}&id=' . $value->id);

                    $type = 'ok';
                    if (($value->end->getTimestamp() < $now->getTimestamp() && $value->end->getTimestamp() + 7776000 > $now->getTimestamp())
                        || ($value->end->getTimestamp() > $now->getTimestamp() && $value->end->getTimestamp() - 7776000 < $now->getTimestamp())
                    ) {
                        $type = 'error';
                    } elseif ($value->end->getTimestamp() < $now->getTimestamp()) {
                        $type = 'info';
                    } elseif ($value->end->getTimestamp() + 7776000 < $now->getTimestamp()) {
                        $type = 'warning';
                    }
                ?>
                <tr tabindex="0" data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('Title'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->title); ?></a>
                    <td data-label="<?= $this->getHtml('Account'); ?>"><a class="content" href="<?= UriFactory::build('{/base}/profile/single?{?}&for=' . $value->account->id); ?>"><?= $this->printHtml($value->account->name1); ?> <?= $this->printHtml($value->account->name2); ?></a>
                    <td data-label="<?= $this->getHtml('End'); ?>"><a href="<?= $url; ?>"><span class="tag <?= $type;  ?>"><?= $value->end !== null ? $value->end->format('Y-m-d') : ''; ?></span></a>
                <?php endforeach; ?>
            </table>
            </div>
            <div class="portlet-foot">
                <a tabindex="0" class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
                <a tabindex="0" class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
            </div>
        </div>
    </div>
</div>
