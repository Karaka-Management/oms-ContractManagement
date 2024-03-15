<?php
/**
 * Jingga
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
 * @var \phpOMS\Views\View                          $this
 * @var \Modules\ContractManagement\Models\Contract $contract
 */
$contract = $this->data['contract'];

echo $this->data['nav']->render(); ?>

<div class="tabview tab-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Overview'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Files'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('Notes', 'Editor', 'Backend'); ?></label>
            <li><label for="c-tab-4"><?= $this->getHtml('Attributes', 'Attribute', 'Backend'); ?></label>
            <li><label for="c-tab-5"><?= $this->getHtml('Parties'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-1' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Contract'); ?></div>
                        <div class="portlet-body">
                            <div class="form-group">
                                <label for="iId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                                <input type="text" id="iId" name="id" value="<?= $contract->id; ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="iTitle"><?= $this->getHtml('Title'); ?></label>
                                <input type="text" id="iTitle" name="title" value="<?= $this->printHtml($contract->title); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="iType"><?= $this->getHtml('Type'); ?></label>
                                <select id="iType" name="type" data-tpl-text="/type" data-tpl-value="/type">
                                    <?php
                                    $types = $this->data['contractTypes'] ?? [];
                                    foreach ($types as $type) : ?>
                                        <option value="<?= $type->id; ?>" <?= $type->id === $contract->type->id ? ' selected' : ''; ?>><?= $this->printHtml($type->getL11n()); ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="iDescription"><?= $this->getHtml('Description'); ?></label>
                                <pre id="iDescription" class="textarea contenteditable" name="description" contenteditable="true"><?= $this->printHtml($contract->description); ?></pre>
                            </div>

                            <div class="form-group">
                                <label for="iStart"><?= $this->getHtml('Start'); ?></label>
                                <input type="datetime-local" id="iStart" name="start" value="<?= $this->printHtml($contract->start->format('Y-m-d\TH:i:s')); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iEnd"><?= $this->getHtml('End'); ?></label>
                                <input type="datetime-local" id="iEnd" name="end" value="<?= $this->printHtml($contract->end->format('Y-m-d\TH:i:s')); ?>">
                            </div>

                            <div class="form-group">
                                <label class="checkbox" for="iAutoRenewal">
                                    <input id="iAutoRenewal" type="checkbox" name="auto_renewal" value="1"<?= $contract->autoRenewal ? ' checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    <?= $this->getHtml('AutoRenewal'); ?>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="iTermination"><?= $this->getHtml('Termination'); ?></label>
                                <input type="number" min="0" step="1" id="iTermination" name="termination" value="<?= $this->printHtml((string) $contract->renewal); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iCosts"><?= $this->getHtml('Costs'); ?></label>
                                <input type="number" id="iCosts" name="Costs" value="<?= $contract->costs === null ? '0' : $this->getCurrency($contract->costs, symbol: ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iUnit"><?= $this->getHtml('Unit'); ?></label>
                                <select id="iUnit" name="unit">
                                    <option value="">
                                    <?php
                                    $units = $this->data['units'] ?? [];
                                    foreach ($units as $unit) : ?>
                                        <option value="<?= $unit->id; ?>"<?= $contract->unit->id === $unit->id ? ' selected' : ''; ?>><?= $this->printHtml($unit->name); ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="portlet-foot">
                            <input type="Submit" value="<?= $this->getHtml('Save', '0', '0'); ?>">
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-2" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-2' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <?= $this->data['media-upload']->render('contract-file', 'files', '', $contract->files); ?>
        </div>

        <input type="radio" id="c-tab-3" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-3' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <?= $this->data['note']->render('contract-note', 'notes', $contract->notes); ?>
        </div>

        <input type="radio" id="c-tab-4" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-4' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <div class="row">
                <?= $this->data['attributeView']->render(
                    $contract->attributes,
                    $this->data['attributeTypes'] ?? [],
                    $this->data['units'] ?? [],
                    '{/api}contract/attribute',
                    $contract->id
                    );
                ?>
            </div>
        </div>

        <input type="radio" id="c-tab-5" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-5' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Contracts'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <div class="slider">
                        <table id="contractList" class="default sticky">
                            <thead>
                            <tr>
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
                            <tbody>
                            <?php
                            $count = 0;
                            $now   = new \DateTime('now');
                            foreach ($this->data['children'] as $key => $value) :
                                ++$count;
                                $url = UriFactory::build('{/base}/contract/view?{?}&id=' . $value->id);

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
                                <td data-label="<?= $this->getHtml('End'); ?>"><a href="<?= $url; ?>"><span class="tag <?= $type;  ?>"><?= $value->end !== null ? $value->end->format('Y-m-d') : ''; ?></span></a>
                                <td data-label="<?= $this->getHtml('Account'); ?>"><a class="content" href="<?= UriFactory::build('{/base}/profile/view?{?}&for=' . $value->account->id); ?>"><?= $this->printHtml($value->account->name1); ?> <?= $this->printHtml($value->account->name2); ?></a>
                                <td data-label="<?= $this->getHtml('Title'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->title); ?></a>
                            <?php endforeach; ?>
                            <?php if ($count === 0) : ?>
                            <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                            <?php endif; ?>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
