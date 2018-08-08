<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"
                        onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-transaction').submit() : false;"><i
                            class="fa fa-trash-o"></i></button>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"
                                       for="input-transaction-id"><?php echo $entry_transaction_id; ?></label>
                                <input type="text" name="filter_transaction_id"
                                       value="<?php echo $filter_transaction_id; ?>"
                                       placeholder="<?php echo $entry_transaction_id; ?>" id="input-transaction-id"
                                       class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>"
                                       placeholder="<?php echo $entry_order_id; ?>" id="input-order-id"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"
                                       for="input-date-added"><?php echo $entry_date_added; ?></label>
                                <div class="input-group date">
                                    <input type="text" name="filter_date_added"
                                           value="<?php echo $filter_date_added; ?>"
                                           placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD"
                                           id="input-date-added" class="form-control"/>
                                    <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                                <select name="filter_status" id="input-status" class="form-control">
                                    <option value="*"></option>
                                    <?php if ($filter_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_complete; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_complete; ?></option>
                                    <?php } ?>
                                    <?php if (!$filter_status && !is_null($filter_status)) { ?>
                                    <option value="0" selected="selected"><?php echo $text_failed; ?></option>
                                    <?php } else { ?>
                                    <option value="0"><?php echo $text_failed; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i
                                        class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                        </div>
                    </div>
                </div>
                <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-transaction">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td style="width: 1px;" class="text-center"><input type="checkbox"
                                                                                   onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"/>
                                </td>

                                <!--<td class="text-right"><?php if ($sort == 'po.bkmexpress_order_id') { ?>
                                  <a href="<?php echo $sort_bkmexpress_order_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_bkmexpress_order_id; ?></a>
                                  <?php } else { ?>
                                  <a href="<?php echo $sort_bkmexpress_order_id; ?>"><?php echo $column_bkmexpress_order_id; ?></a>
                                  <?php } ?></td>-->

                                <td class="text-right"><?php if ($sort == 'po.order_id') { ?>
                                    <a href="<?php echo $sort_order_id; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_order_id; ?>"><?php echo $column_order_id; ?></a>
                                    <?php } ?></td>

                                <td class="text-right"><?php if ($sort == 'po.transaction_id') { ?>
                                    <a href="<?php echo $sort_transaction_id; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_transaction_id; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_transaction_id; ?>"><?php echo $column_transaction_id; ?></a>
                                    <?php } ?></td>

                                <td class="text-right"><?php if ($sort == 'o.total') { ?>
                                    <a href="<?php echo $sort_total; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                                    <?php } ?></td>

                                <td class="text-right"><?php if ($sort == 'po.try_total') { ?>
                                    <a href="<?php echo $sort_try_total; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_try_total; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_try_total; ?>"><?php echo $column_try_total; ?></a>
                                    <?php } ?></td>

                                <td class="text-right"><?php if ($sort == 'po.conversion_rate') { ?>
                                    <a href="<?php echo $sort_conversion_rate; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_conversion_rate; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_conversion_rate; ?>"><?php echo $column_conversion_rate; ?></a>
                                    <?php } ?></td>

                                <td class="text-right"><?php if ($sort == 'po.client_ip') { ?>
                                    <a href="<?php echo $sort_client_ip; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_client_ip; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_client_ip; ?>"><?php echo $column_client_ip; ?></a>
                                    <?php } ?></td>

                                <td class="text-left"><?php if ($sort == 'po.status') { ?>
                                    <a href="<?php echo $sort_status; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'po.date_added') { ?>
                                    <a href="<?php echo $sort_date_added; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                                    <?php } ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($transactions) { ?>
                            <?php foreach ($transactions as $transaction) { ?>
                            <tr>
                                <td class="text-center"><?php if (in_array($transaction['bkmexpress_order_id'], $selected)) { ?>
                                    <input type="checkbox" name="selected[]"
                                           value="<?php echo $transaction['bkmexpress_order_id']; ?>"
                                           checked="checked"/>
                                    <?php } else { ?>
                                    <input type="checkbox" name="selected[]"
                                           value="<?php echo $transaction['bkmexpress_order_id']; ?>"/>
                                    <?php } ?></td>

                                <td class="text-right"><?php echo $transaction['order_id']; ?></td>
                                <td class="text-right"><?php echo $transaction['transaction_id']; ?></td>
                                <td class="text-right"><?php echo $transaction['total']; ?></td>
                                <td class="text-right"><?php echo $transaction['try_total']; ?></td>
                                <td class="text-right"><?php echo $transaction['conversion_rate']; ?></td>
                                <td class="text-right"><?php echo $transaction['client_ip']; ?></td>
                                <td class="text-left"><?php echo $transaction['status']; ?></td>
                                <td class="text-left"><?php echo $transaction['date_added']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="13"><?php echo $text_no_results; ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
        $('#button-filter').on('click', function () {
            url = 'index.php?route=sale/bkmexpress&token=<?php echo $token; ?>';

            var filter_order_id = $('input[name=\'filter_order_id\']').val();

            if (filter_order_id) {
                url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
            }

            var filter_transaction_id = $('input[name=\'filter_transaction_id\']').val();

            if (filter_transaction_id) {
                url += '&filter_transaction_id=' + encodeURIComponent(filter_transaction_id);
            }

            var filter_status = $('select[name=\'filter_status\'] option:selected').val();

            if (filter_status != '*') {
                url += '&filter_status=' + encodeURIComponent(filter_status);
            }

            var filter_client_ip = $('input[name=\'filter_client_ip\']').val();

            if (filter_client_ip) {
                url += '&filter_client_ip=' + encodeURIComponent(filter_client_ip);
            }

            var filter_date_added = $('input[name=\'filter_date_added\']').val();

            if (filter_date_added) {
                url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
            }

            location = url;
        });
        //--></script>
    <script type="text/javascript"><!--
        $('.date').datetimepicker({
            pickTime: false
        });
        //--></script>
</div>
<?php echo $footer; ?> 