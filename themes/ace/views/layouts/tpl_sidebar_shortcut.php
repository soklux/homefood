<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">

        <?php if (ckacc('report.sale')) { ?>
            <a class="btn btn-success" href="<?= url('report/saleInvoice') ?>">
                <i class="ace-icon fa fa-signal"></i>
            </a>
        <?php } else { ?>
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>
        <?php } ?>

        <?php if (ckacc('employee.read') || ckacc('employee.create') || ckacc('employee.update') || ckacc('employee.delete')) { ?>
            <a class="btn btn-warning" href="<?= url('employee/admin') ?>">
                <i class="ace-icon fa fa-users"></i>
            </a>
        <?php } else { ?>
            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>
        <?php } ?>

        <?php if (ckacc('setting.setting'))  { ?>
            <a class="btn btn-danger" href="<?= url('settings/index') ?>">
                <i class="ace-icon fa fa-cogs"></i>
            </a>
        <?php } else { ?>
            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>
        <?php } ?>


        <?php if (ckacc('sale.read') || ckacc('sale.create') || ckacc('sale.update') || ckacc('sale.delete')) { ?>
            <a class="btn btn-info" href="<?= url('saleItem/create') ?>">
                <i class="ace-icon fa fa-pencil"></i>
            </a>
        <?php } else { ?>
            <button class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </button>
        <?php } ?>

        <!-- /section:basics/sidebar.layout.shortcuts -->
    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>

        <span class="btn btn-info"></span>
    </div>
</div><!-- /.sidebar-shortcuts -->