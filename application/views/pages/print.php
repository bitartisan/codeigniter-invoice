<?php
tcpdf();

$title = 'F' . $app['data']['invoice']['invoice_no'] . '-' . date('d.m.Y', strtotime($app['data']['invoice']['invoice_date']));

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Remus Florian Boara PDF');
$pdf->SetTitle($title);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 0);
$pdf->AddPage();
ob_start();
?>
<style>
    .invoice {width: 100%; font-size: 9pt; border: 1px solid #ccc;}
    .invoice th, .invoice td {border: 1px solid #eee;}
</style>

<table cellpadding="10" style="border: 3px solid #eee;">
    <tr><td>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
        <tr>
            <td style="width: 40%; line-height: 1.5;"><strong>Furnizor</strong><br/>
                <strong style="color: #777; font-size: 10pt;"><?php echo $app['data']['provider']['provider_name']; ?></strong>
                <div style="font-size: 8pt;"><strong>ORC:</strong> <?php echo $app['data']['provider']['provider_orc']; ?><br/>
                    <strong>CIF:</strong> <?php echo $app['data']['provider']['provider_cui']; ?><br/>
                    <strong>Capital social:</strong> 200 RON<br/>
                    <strong>Sediu:</strong> <?php echo $app['data']['provider']['provider_address']; ?><br/>
                    <strong>Cont:</strong> <?php echo $app['data']['provider']['provider_account']; ?><br/>
                    <strong>Bank:</strong> <?php echo $app['data']['provider']['provider_bank']; ?>
                </div>
            </td>
            <td style="width: 20%;">&nbsp;</td>
            <td style="width: 40%; line-height: 1.5;"><strong>Beneficiar</strong><br/>
                <strong style="color: #777; font-size: 10pt;"><?php echo $app['data']['client']['client_name']; ?></strong>
                <div style="font-size: 8pt;"><?php echo $app['data']['client']['client_address']; ?><br/><br/>
                    <strong>ORC:</strong> <?php echo $app['data']['client']['client_orc']; ?><br/>
                    <strong>CIF:</strong> <?php echo $app['data']['client']['client_cui']; ?><br/>
                    <strong>Cont:</strong> <?php echo $app['data']['client']['client_account']; ?><br/>
                    <strong>Bank:</strong> <?php echo $app['data']['client']['client_bank']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">
                <h1>
                    FACTURA nr. <?php echo $app['data']['invoice']['invoice_no']; ?><br />
                    <small style="color: #777;"><?php echo date('d.m.Y', strtotime($app['data']['invoice']['invoice_date'])); ?></small>
                </h1>
            </td>
        </tr>
    </table>

    <small>Cota TVA 0%</small><br/>
    <table width="99%" class="invoice" cellspacing="2" cellpadding="3">
        <tr>
            <th width="7%"><strong>Nr. Crt.</strong></th>
            <th width="45%"><strong>Denumirea Serviciilor</strong></th>
            <th width="7%"><strong>UM</strong></th>
            <th width="12%"><strong>Cantitate</strong></th>
            <th width="15%"><strong>Pret Unitar (Lei)</strong></th>
            <th width="15%"><strong>Valoarea (Lei)</strong></th>
        </tr>
        <tr>
            <td>0</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5 (3x4)</td>
        </tr>
        <?php
        $total = 0;
        foreach($app['data']['lines'] as $index => $line):
            $total = $total + ($line['price'] * $line['qty']);
            ?>
            <tr>
                <td><?php echo ($index + 1); ?></td>
                <td><?php echo $line['service_name']; ?> conf. ctr. <?php echo $line['contract_no']; ?> / <?php echo date('d.m.Y', strtotime($line['contract_date'])); ?></td>
                <td> - </td>
                <td><?php echo $line['qty']; ?></td>
                <td><?php echo number_format((float) $line['price'], 2, '.', ''); ?></td>
                <td><?php echo number_format((float) ($line['price'] * $line['qty']), 2, '.', ''); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="6" style="text-align: right;"><h4>Total de plata: <?php echo $total; ?> Lei</h4>
            </td>
        </tr>
    </table>

    <br /><br />
    <table width="99%" class="invoice" cellspacing="2" cellpadding="3">
    	<tr>
    		<td valign="top" width="25%" rowspan="5"><strong>Semnatura si stampila
    				furnizorului</strong></td>
    		<td colspan="2"><strong>Date privind expeditia</strong></td>
    		<td valign="top" width="26%" rowspan="5"><strong>Semnatura de primire</strong></td>
    	</tr>
    	<tr>
    		<td width="20%"><strong>Numele delegatului:</strong></td>
    		<td width="30%"><div class="rep_name">Boara Remus Florian</div></td>
    	</tr>
    	<tr>
    		<td><strong>C.I. / CNP:</strong></td>
    		<td><div class="rep_cnp">KX 775486 / 1780124203141</div></td>
    	</tr>
    	<tr>
    		<td><strong>Mijloc de transport:</strong></td>
    		<td><div class="rep_transport">TAXI</div></td>
    	</tr>
    	<tr>
    		<td><strong>Data</strong></td>
    		<td><div class="rep_date">2018-08-29</div></td>
    	</tr>
    </table>
    </td></tr>
</table>

<?php
$content = ob_get_contents();
ob_end_clean();
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output($title . '.pdf', 'I');
