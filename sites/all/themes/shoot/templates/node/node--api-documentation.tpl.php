

    <!-- Start Content Block 3-4 -->
    <section id="content-3-4" class="content-block content-3-4" style="padding-top:20px;">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="editContent page-headline" data-selector="Footer">
                        <h2 data-selector="h2" style="padding-top:0px;margin-top:0px;"><?php print($node->title);?></h2>
                    </div>
                    <div class="editContent page-headline-body" data-selector="Footer">
                        <p data-selector="p" style=""><?php print $body[0]['value']; ?></p>
                    </div>
                    <div class="editContent" data-selector="Footer">
                        <p data-selector="p" style="">
                            <?php
                            if (user_has_role(DRUPAL_AUTHENTICATED_RID)) {
                                $view_name = $content['field_api_model'][0]['#title'] . "_methods";
                                print views_embed_view($view_name);
                            }
                            else {
                                global $base_url;
                                print '<a class="btn btn-default" href="' . $base_url . '/user/login">Login to view APIs</a>';
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <div id="accordion1" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color:#f9f9f9">
                                <h4 class="panel-title" data-selector="h4"
                                    style="">
                                    <a class="panel-toggle"
                                       data-toggle="collapse"
                                       data-parent="#accordion1"
                                       href="#content1">
                                        <div class="editContent"
                                             data-selector="Footer">
                                            <span>API Details</span>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <!-- /.panel-heading -->
                            <div id="content1"
                                 class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="editContent"
                                         data-selector="Footer">
                                        <p data-selector="p" style="">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td>API Type</td>
                                                <td><?php print(render($content['field_api_type'][0])) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Version</td>
                                                <td><?php print(render($content['field_api_version'][0])) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Lifecycle Status</td>
                                                <td><?php print(render($content['field_lifecycle_status'][0])) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Support Forum</td>
                                                <td><?php print render($content['field_forum'][0]); ?></td>
                                            </tr>
                                        </table>
                                        </p>
                                    </div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.content -->
                        </div>
                    </div>
                    <!-- /.accordion -->
                </div>
                <!-- /.column -->
            </div>
            <!-- /.row -->
        </div>

		<?php print render($content['comments']); ?>

        <!-- /.container -->
    </section>
    <!--// END Content Block 3-4 -->

