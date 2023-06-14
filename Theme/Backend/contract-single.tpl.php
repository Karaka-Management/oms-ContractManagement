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
 * @var \phpOMS\Views\View                          $this
 * @var \Modules\ContractManagement\Models\Contract $contract
 */
$contract     = $this->data['contract'];
$contractFile = $contract->files;

echo $this->data['nav']->render(); ?>

<div class="tabview tab-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Overview'); ?></label></li>
            <li><label for="c-tab-2"><?= $this->getHtml('Files'); ?></label></li>
            <li><label for="c-tab-3"><?= $this->getHtml('Notes'); ?></label></li>
            <!-- if parrent contract show all parties that use this template/parent contract (e.g. show all customers who have this contract)
            <li><label for="c-tab-4"><?= $this->getHtml('Parties'); ?></label></li>
            -->
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

                            <label class="checkbox" for="iAutoRenewal">
                                <input id="iAutoRenewal" type="checkbox" name="auto_renewal" value="1"<?= $contract->autoRenewal ? ' checked' : ''; ?>>
                                <span class="checkmark"></span>
                                <?= $this->getHtml('AutoRenewal'); ?>
                            </label>

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
    </div>
</div>
