<section id="shop-1-7" class="content-block shop-1-7">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="editContent">
          <p class="lead">
            <div class="pull-right" style="padding-bottom:15px;">
              <a role="button" class="dexp-shortcodes-button btn dexp-btn-icon-left dexp-label-btn dexp-btn-border-grey dexp-btn-small" href="<?php print('/user/me/apps/add')?>">
                <i class="fa fa-plus" style="background-color:#efefef"></i><span>Register New App</span>
              </a>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-striped table-hover cart-table">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>APP NAME</th>
              <th>PRODUCTS</th>
              <th>CREDENTIALS (KEY/SECRET)</th>
              <th>EXPIRY</th>
              <th>STATUS</th>
            </tr>
          </thead>
          <tbody>
            <?php

            function displayNameForProduct ($p) { return $p['displayName']; };
            function apiProductNameForCred ($cred_apiproduct) { return $cred_apiproduct['apiproduct']; }

            $appCount=0;
            if (count($applications) > 0) {
              foreach ($applications as $app) {
                $appCount++;
                // for diagnostics only
                // if ($appCount == 1) {
                //    echo '<pre>' . var_export($app, true) . '</pre>';
                // }

                // DINO - Tuesday, 29 November 2016, 15:53
                // At some point the AbstractApp.php within mgmt-api-sdk was modified to
                // include the credentials in app. This tests for it.
                //
                if (isset($app['credentials'])) {
                  $credCount=0;
                  $numCreds = count($app['credentials']);
                  foreach ($app['credentials'] as $cred) {
                    $credCount++;
                    print('<tr>');

                    if ($credCount == 1) {
                      if (user_access("delete developer apps")) {
                        ?>
                        <td rowspan="<?php print $numCreds;?>">
                          <a href="<?php print base_path() . $app['delete_url']; ?>"
                          class="remove"
                          title="Remove this item"
                          data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a></td>
                        <?php
                      }

                      if (user_access("edit developer apps")) {
                        ?>
                        <td rowspan="<?php print $numCreds;?>">
                          <a href="<?php print base_path() . $app['edit_url']; ?>"
                          class="edit"
                          title="Update this item"
                          data-toggle="tooltip"
                          data-placement="top"><i class="fa fa-pencil-square-o"></i></a></td>
                        <?php
                      }

                      print('<td rowspan="' . $numCreds . '"><a href="' .
                            base_path() . $app['detail_url'] .'">' .$app['app_name'] .'</a></td>');
                    } // $credCount == 1

                    $credStatus = shoot_cred_status_ex($app, $cred);
                    $prodlist = implode("<br/>", array_map(apiProductNameForCred, $cred['apiProducts']));
                    print('<td>' . $prodlist .'</td>');
                    print('<td><div class="app-credential-key">' . $cred['consumerKey'] .
                          '</div><div class="app-credential-secret">' . $cred['consumerSecret'] . '</div></td>');
                    print('<td class="cred-expiry">'. $credStatus['expiry'] .'&nbsp;<span class="cred-expiry-status ' . $credStatus['expiry_status_classes']  . '">' . $credStatus['expiry_status'] . '</span></td>');
                    print('<td>'. _shoot_status_label_callback($credStatus['status'], TRUE) .'</td>');
                    print('</tr>');

                  } // foreach cred
                }
                else { // old behavior - displays one credential per app
                  print('<tr>');
                  $credStatus = shoot_app_status_ex($app);
                  if (user_access("delete developer apps")) {
                    ?>
                    <td>
                      <a href="<?php print base_path() . $app['delete_url']; ?>"
                      class="remove"
                      title="Remove this item"
                      data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a></td>
                    <?php
                  }

                  if (user_access("edit developer apps")) {
                    ?>
                    <td>
                      <a href="<?php print base_path() . $app['edit_url']; ?>"
                      class="edit"
                      title="Update this item"
                      data-toggle="tooltip"
                      data-placement="top"><i class="fa fa-pencil-square-o"></i></a></td>
                    <?php
                  }

                  print('<td><a href="' . base_path() . $app['detail_url'] .'">' .$app['app_name'] .'</a></td>');
                  $prodlist = implode("<br/>", array_map(displayNameForProduct, $app['credential']['apiProducts']));
                  print('<td>' . $prodlist .'</td>');
                  print('<td><div class="app-credential-key">' . $app['credential']['consumerKey'] .
                        '</div><div class="app-credential-secret">' . $app['credential']['consumerSecret'] . '</div></td>');
                  print('<td class="cred-expiry">'. $credStatus['expiry'] .'&nbsp;<span class="cred-expiry-status ' . $credStatus['expiry_status_classes']  . '">' . $credStatus['expiry_status'] . '</span></td>');
                  print('<td>'. _shoot_status_label_callback($credStatus['status'], TRUE) .'</td>');
                  print('</tr>');
                }
              }
            }
            else {
              print('<tr><td colspan="5" align="middle">You have no registered apps.</td></tr>');
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
