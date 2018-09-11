<form name="invoice" id="frm_invoice" method="post" action="<?php echo base_url('/'); ?>index.php/form/save_invoice">
    <div class="row mx-lg-5">
        <div class="col-md-auto mr-auto col-md-3 col-xs-12">
            <h4 class="py-2 border-bottom">Provider</h4>
            <?php $prov = $this->provider->get_provider(1); ?>
            <dl>
                <dt><?php echo $prov['provider_name']; ?></dt>
                <dd>ORC: <?php echo $prov['provider_orc']; ?></dd>
                <dd>CIF: <?php echo $prov['provider_cui']; ?></dd>
                <dd>Capital social: 200 RON</dd>
                <dd>Sediu: <?php echo $prov['provider_address']; ?></dd>
                <dd>Cont: <?php echo $prov['provider_account']; ?></dd>
                <dd>Bank: <?php echo $prov['provider_bank']; ?></dd>
            </dl>
            <input type="hidden" name="provider_id" value="<?php echo $prov['provider_id']; ?>" />
        </div>
        <div class="col-md-auto col-md-3 col-xs-12">
            <h4 class="py-2">Beneficiary</h4>
            <?php $clients = $this->client->get_client(); ?>
            <select name="client_id" id="client_id" class="form-control form-control-sm my-1" onchange="window.location='<?php echo $app['base_url']; ?>index.php/home?client_id=' + this.value;">
                <option value="-1">-- Select Client --</option>
                <?php foreach($clients as $client): ?>
                    <option value="<?php echo $client['client_id']; ?>"<?php echo ($client['client_id'] == $this->input->get('client_id', true) ? ' selected' : ''); ?>><?php echo $client['client_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if ($app['client_id'] != null && $app['client_id'] > 0): ?>
                <?php $cl_arr = $this->client->get_client($app['client_id']); ?>
                <a id="edit_client" href="<?php echo $app['base_url']; ?>index.php/client?id=<?php echo $cl_arr['client_id']; ?>" class="text-danger">
                    <i class="fas fa-edit"></i>
                </a>
                <dl>
                    <dt><?php echo $cl_arr['client_address']; ?></dt>
                    <dd>ORC: <?php echo $cl_arr['client_orc']; ?></dd>
                    <dd>CUI: <?php echo $cl_arr['client_cui']; ?></dd>
                    <dd>Cont: <?php echo $cl_arr['client_account']; ?></dd>
                    <dd>Bank: <?php echo $cl_arr['client_bank']; ?></dd>
                </dl>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mx-lg-5">
        <div class="col-md-3 col-xs-12">
            <!-- contract -->
            <?php if ($app['client_id'] != null): ?>
                <h4 class="my-0">Contract</h4>
                <?php $ctr_arr = $this->contract->get_contract($app['client_id']); ?>
                <select name="contract_id" id="contract_id" class="form-control form-control-sm my-1" onchange="window.location='<?php echo $app['base_url']; ?>index.php/home?client_id=<?php echo $app['client_id']; ?>&amp;contract_id=' + this.value;">
                    <option value="-1"<?php echo (-1 == $this->input->get('contract_id', true) ? ' selected' : ''); ?>>-- Select Contract --</option>
                    <?php foreach($ctr_arr as $ctr): ?>
                        <option value="<?php echo $ctr['contract_id']; ?>"<?php echo ($ctr['contract_id'] == $this->input->get('contract_id', true) ? ' selected' : ''); ?>>#<?php echo $ctr['contract_no']; ?> / <?php echo date($this->config->item('date_format'), strtotime($ctr['contract_date'])); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <!-- invoice -->
            <?php if ($app['client_id'] != null && $app['contract_id'] != null): ?>
                <small class="text-muted">Last invoice: #<?php echo $this->app->get_last_invoice(); ?></small>
                <?php $inv_arr = $this->invoice->get_invoice_by_contract($app['contract_id']); ?>
                <select multiple name="invoice_id" id="invoice_id" size="10" class="form-control form-control-sm my-1" onchange="window.location='<?php echo $app['base_url']; ?>index.php/home?client_id=<?php echo $app['client_id'] ?>&amp;contract_id=<?php echo $app['contract_id'] ?>&amp;invoice_id=' + this.value;">
                    <option value="-1"<?php echo (-1 == $this->input->get('invoice_id', true) ? ' selected' : ''); ?>>-- New Invoice --</option>
                    <?php foreach($inv_arr as $inv): ?>
                        <option value="<?php echo $inv['invoice_id']; ?>"<?php echo ($inv['invoice_id'] == $this->input->get('invoice_id', true) ? ' selected' : ''); ?>>#<?php echo $inv['invoice_no']; ?> / <?php echo date($this->config->item('date_format'), strtotime($inv['invoice_date'])); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div class="col-md-9 col-xs-12">
            <!-- invoice lines -->
            <?php if ($app['contract_id'] != null && $app['invoice_id'] != null): ?>
                <div class="row my-4">
                    <?php $sel_inv = $this->invoice->get_invoice($app['invoice_id']); ?>
                    <div class="offset-md-2 col-md-1 col-xs-12 mt-1">
                        <strong class="text-secondary">Invoice No.</strong>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <input type="text" name="invoice_no" value="<?php echo (is_array($sel_inv) > 0 ? $sel_inv['invoice_no'] : ''); ?>" class="form-control form-control-sm" />
                    </div>
                    <div class="col-md-2 col-xs-12 mt-1">
                        <strong class="text-secondary">From (dd.mm.yyyy)</strong>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <input type="text" name="invoice_date" value="<?php echo (is_array($sel_inv) > 0 ? date('d.m.Y', strtotime($sel_inv['invoice_date'])) : ''); ?>" class="datepicker form-control form-control-sm" />
                    </div>
                </div>

                <table id="table-invoice" class="table table-responsive">
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
                        // check if we're adding a new empty invoice line
                        $add_empty_line = false;
                        if ($this->input->get('add_line')) {
                            $add_empty_line = true;
                        }
                        ?>
                        <?php $lines_arr = $this->invoice->get_invoice_lines($app['invoice_id'], $add_empty_line); ?>
                        <?php
                        $total = 0;
                        foreach($lines_arr as $index => $line):
                            $total = $total + ($line['price'] * $line['qty']);
                            ?>
                            <tr>
                                <td><?php echo $index+1; ?></td>
                                <td>
                                    <?php $services = $this->service->get_service(); ?>
                                    <!-- services -->
                                    <div class="row">
                                        <div class="col-xs-auto">
                                            <select name="invoice_line[service_id][]" class="form-control form-control-sm">
                                                <option value="-1">-- Select Service --</option>
                                                <?php foreach($services as $service): ?>
                                                    <option value="<?php echo $service['service_id'] ?>"<?php echo ($service['service_id'] == $line['service_id'] ? ' selected' : ''); ?>><?php echo $service['service_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-auto ml-2 mt-1">
                                            conf. ctr. #<?php echo $line['contract_no']; ?> / <?php echo date('d.m.Y', strtotime($line['contract_date'])); ?>
                                        </div>
                                    </div>
                                 </td>
                                <td> - </td>
                                <td>
                                    <select name="invoice_line[qty][]" class="qry form-control form-control-sm">
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php echo ($i == $line['qty'] ? ' selected' : ''); ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td><input class="form-control form-control-sm" type="text" name="invoice_line[price][]" value="<?php echo number_format((float) $line['price'], 2, '.', ''); ?>" /></td>
                                <td><?php echo number_format((float) ($line['price'] * $line['qty']), 2, '.', ''); ?></td>
                                <td>
                                    <!-- action buttons -->
                                    <input type="hidden" name="invoice_line[invoice_line_id][]" value="<?php echo $line['invoice_line_id']; ?>" />
                                    <?php if ($index > 0): ?>
                                        <a href="<?php echo base_url(); ?>index.php/form/delete_invoice_line?invoice_line_id=<?php echo $line['invoice_line_id']; ?>&amp;<?php echo $this->invoice->get_url_request(); ?>" onclick="return confirm('Are you sure you want do delete this line?');" class="btn bn-sm btn-danger">
                                            <span class="fas fa-minus"></span>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url(); ?>index.php/home?add_line=1&amp;<?php echo $this->invoice->get_url_request(); ?>" class="btn bn-sm btn-success">
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
                                            <a href="<?php echo base_url(); ?>index.php/home?print&amp;invoice_id=<?php echo $app['invoice_id']; ?>" target="_blank" class="btn btn-sm btn-secondary">
                                                <span class="fas fa-print"></span>
                                                Print
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/form/delete_invoice?<?php echo $this->invoice->get_url_request(); ?>" onclick="return confirm('Are you sure you want do delete this invoice?');" class="btn btn-sm btn-danger">
                                                <span class="fas fa-trash"></span>
                                                Delete
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div id="total" class="col-lg-2 col-xs-12 text-right" style="font-weight: 700;">
                                        Total: <span id="grand-total"><?php echo number_format((float) $total, 2, '.', ''); ?></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </div>
    </div>
</form>
