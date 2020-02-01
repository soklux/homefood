<?php
$this->breadcrumbs=array(
	'About Us'=>array('about'),
);
?>
<div class="row">
        <div class="col-xs-8">
                <div class="widget-box">
                        <div class="widget-header widget-header-flat">
                                <h4 class="smaller">
                                        <i class="icon-quote-left smaller-80"></i>
                                        Vision & Mission
                                </h4>
                        </div>

                        <div class="widget-body">
                                <div class="widget-main">
                                        <div class="row-fluid">
                                                <blockquote class="pull-right">
                                                        <p>
                                                            <?= bizVision(); ?>
                                                        </p>

                                                        <small>
                                                                Simply
                                                                <cite title="Source Title">The Best</cite>
                                                        </small>
                                                </blockquote>
                                        </div>

                                        <div class="row-fluid">
                                                <blockquote>
                                                        <p><?= bizNameFirstUpper() ?></p>

                                                        <small>
                                                                Success 
                                                                <cite title="Source Title">Through The Art of Giving</cite>
                                                        </small>
                                                </blockquote>
                                        </div>

                                        <hr />
                                        <address>
                                                <strong>
                                                    <a href="<?= bizWebsite() ?>" target="_blank" title="Digital Nomad">
                                                        <img src="https://cdn.shopify.com/s/files/1/0070/7032/files/digital_nomad_hero.jpg?v=1512654236" width="370">
                                                    </a>
                                                </strong>

                                                <br />
                                                <!--
                                                #70F,St. Fortune,
                                                <br />
                                                Ratana Plazza, Khan Sensok, Phnom Penh.-->
                                                <i class="ace-icon fa fa-map-marker"></i> Working From Anywhere with <a href="http://www.peedor.com/" target="_blank">peedor.com</a>
                                                <br />
                                                <abbr title="Phone">Mobile Number:</abbr>
                                                <span class="badge badge-primary"><strong> (078) 777-775 </strong></span>
                                                <br />

                                        </address>

                                        <address>
                                                <strong><?= bizNameFirstUpper() ?>  Solution</strong>

                                                <br />
                                                <a href="mailto:#">sales@peedor.com</a>
                                                <br />
                                        </address>
                                </div>
                        </div>
                </div>
        </div>
   </div><!--/.row-fluid-->
</div><!--/.page-content-->