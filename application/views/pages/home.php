<?php
$form_attr = [
    'name' => 'invoice',
    'id' => 'frm_invoice',
];
?>

<?=form_open('form/save_invoice', $form_attr);?>
    <div class="row mx-lg-5">
        <div class="col-md-auto mr-auto col-md-3 col-xs-12">
            <h4 class="py-2">Provider</h4>
            <dl>
                <dt><?=$app['provider']['provider_name'];?></dt>
                <dd>ORC: <?=$app['provider']['provider_orc'];?></dd>
                <dd>CIF: <?=$app['provider']['provider_cui'];?></dd>
                <dd>Capital social: 200 RON</dd>
                <dd>Sediu: <?=$app['provider']['provider_address'];?></dd>
                <dd>Cont: <?=$app['provider']['provider_account'];?></dd>
                <dd>Bank: <?=$app['provider']['provider_bank'];?></dd>
            </dl>
            <?=form_hidden('provider_id', $app['provider']['provider_id']); ?>
        </div>
        <div class="col-md-auto col-md-3 col-xs-12">
            <h4 class="py-2">Beneficiary</h4>
            <?php
            $client_attr = [
                'id' => 'client_id',
                'class' => 'form-control form-control-sm my-1',
                'onchange' => 'window.location=\'' . $app['base_url'] . 'index.php/home?client_id=\' + this.value;',
            ];
            ?>

            <?=form_dropdown('client_id', $app['clients'], $app['client_id'], $client_attr);?>
            <?php if ($app['client_id'] != null && $app['client_id'] > 0): ?>
                <a id="edit_client" href="<?= $app['base_url']; ?>index.php/client?id=<?= $app['client_id']; ?>" class="text-success">
                    <i class="fas fa-edit"></i>
                </a>
                <dl>
                    <dt><?=$app['client_arr']['client_address'];?></dt>
                    <dd>ORC: <?=$app['client_arr']['client_orc'];?></dd>
                    <dd>CUI: <?=$app['client_arr']['client_cui'];?></dd>
                    <dd>Cont: <?=$app['client_arr']['client_account'];?></dd>
                    <dd>Bank: <?=$app['client_arr']['client_bank'];?></dd>
                </dl>
            <?php endif; ?>
        </div>
    </div>

    <hr/>

    <div class="row mx-lg-5">
        <div class="col-md-3 col-xs-12">
            <!-- contract -->
            <?php if ($app['client_id'] != null): ?>
                <h4 class="my-0">Contract</h4>
                <?php
                $contract_attr = [
                    'id' => 'contract_id',
                    'class' => 'form-control form-control-sm my-1',
                    'onchange' => 'window.location=\'' . $app['base_url'] . 'index.php/home?client_id=' . $app['client_id'] . '&amp;contract_id=\' + this.value;',
                ]; ?>
                <?=form_dropdown('contract_id', $app['contracts'], $app['contract_id'], $contract_attr);?>
            <?php endif; ?>

            <!-- invoice -->
            <?php if ($app['client_id'] != null && $app['contract_id'] != null): ?>
                <small class="text-muted">Last invoice: <?= $app['last_invoice']; ?></small>
                <?php
                $invoice_attr = [
                    'id' => 'invoice_id',
                    'class' => 'form-control form-control-sm my-1',
                    'size' => 10,
                    'onchange' => 'window.location=\'' . $app['base_url'] . 'index.php/home?' . get_url_request($app['client_id'], $app['contract_id'], false) . '&amp;invoice_id=\' + this.value;',
                ];
                ?>
                <?=form_multiselect('invoice_id', $app['invoice'], $app['invoice_id'], $invoice_attr);?>
            <?php endif; ?>
        </div>
        <div class="col-md-9 col-xs-12">
            <!-- invoice lines -->
            <?php if ($app['contract_id'] != null && $app['invoice_id'] != null): ?>
                <div class="row my-4">
                    <?php $sel_inv = $app['sel_invoice']; ?>
                    <div class="offset-md-2 col-md-1 col-xs-12 mt-1">
                        <strong class="text-secondary">Invoice No.</strong>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <?=form_input('invoice_no', (is_array($sel_inv) > 0 ? $sel_inv['invoice_no'] : ''), ['class' => 'form-control form-control-sm']);?>
                    </div>
                    <div class="col-md-2 col-xs-12 mt-1">
                        <strong class="text-secondary">From (dd.mm.yyyy)</strong>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <?=form_input('invoice_date', (is_array($sel_inv) > 0 ? date('d.m.Y', strtotime($sel_inv['invoice_date'])) : ''), ['class' => 'datepicker form-control form-control-sm']);?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="table-invoice" class="table">
                        <thead>
                            <tr>
                                <th width="7%">Nr. Crt.</th>
                                <th>Denumirea Serviciilor</th>
                                <th width="7%">UM</th>
                                <th width="7%">Cantitate</th>
                                <th width="15%">Preţ Unitar</th>
                                <th width="20%">Valoarea (Lei)</th>
                                <th>&nbsp;</th>
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5 (3x4)</td>
                                <td>&nbsp;</td>
                            </tr>
                        </thead>
                        <tbody class="invoice-body">
                            <?php
                            $total = 0;
                            foreach($app['lines_arr'] as $index => $line):
                                $total = $total + ($line['price'] * $line['qty']);
                                ?>
                                <tr>
                                    <td><?=$index+1; ?></td>
                                    <td>
                                        <!-- services -->
                                        <div class="row">
                                            <div class="col-xs-auto">
                                                <?=form_dropdown('invoice_line[service_id][]', $app['services'], $line['service_id'], ['class' => 'form-control form-control-sm']);?>
                                            </div>
                                            <div class="col-xs-auto ml-2 mt-1">
                                                conf. ctr. <?=$line['contract_no']; ?> / <?=date('d.m.Y', strtotime($line['contract_date'])); ?>
                                            </div>
                                        </div>
                                     </td>
                                    <td> - </td>
                                    <td>
                                        <?php $count_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'); ?>
                                        <?=form_dropdown('invoice_line[qty][]', $count_arr, $line['qty'], ['class' => 'form-control form-control-sm']);?>
                                    </td>
                                    <td><?=form_input('invoice_line[price][]', number_format((float) $line['price'], 2, '.', ''), ['class' => 'form-control form-control-sm']);?></td>
                                    <td><?=number_format((float) ($line['price'] * $line['qty']), 2, '.', ''); ?></td>
                                    <td>
                                        <!-- action buttons -->
                                        <?=form_hidden('invoice_line[invoice_line_id][]', $line['invoice_line_id']);?>
                                        <?php if ($index > 0): ?>
                                            <a href="<?=base_url(); ?>index.php/form/delete_invoice_line?invoice_line_id=<?=$line['invoice_line_id']; ?>&amp;<?= get_url_request(); ?>" onclick="return confirm('Are you sure you want do delete this line?');" class="btn bn-sm btn-danger">
                                                <span class="fas fa-minus"></span>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?=base_url(); ?>index.php/home?add_line=1&amp;<?= get_url_request(); ?>" class="btn bn-sm btn-success">
                                            <span class="fas fa-plus"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="row m-0">
                                        <div class="col-lg-10 col-xs-12">
                                            <button type="submit" name="submit_invoice" class="btn btn-sm btn-success">
                                                <span class="fas fa-save"></span>
                                                Save
                                            </button>
                                            <?php if ($app['invoice_id'] > 0): ?>
                                                <a href="<?=base_url(); ?>index.php/print?invoice_id=<?=$app['invoice_id']; ?>" target="_blank" class="btn btn-sm btn-secondary">
                                                    <span class="fas fa-print"></span>
                                                    Print
                                                </a>
                                                <a href="<?=base_url(); ?>index.php/form/delete_invoice?<?= get_url_request(); ?>" onclick="return confirm('Are you sure you want do delete this invoice?');" class="btn btn-sm btn-danger">
                                                    <span class="fas fa-trash"></span>
                                                    Delete
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div id="total" class="col-lg-2 col-xs-12 text-right" style="font-weight: 700;">
                                            Total: <span id="grand-total"><?=number_format((float) $total, 2, '.', ''); ?> Lei</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?=form_close(); ?>
