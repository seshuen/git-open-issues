<?php
  require 'getOpenIssues.php';

  $error_msg = '';
  $display = 0;

if(isset($_POST['getdata'],$_POST['url']))
{
  //Initialize the openissue class we created
  $openissue = new OpenIssue;

  //assign the url to @var url
  $url = $_POST['url'];

  //Date and Time 1 day or 24 hours ago in ISO 8601 Format
  $last24hr = date('Y-m-d\TH:i:s.Z\Z', strtotime('-1 day', time()));

  //Date and Time 1 day or 24 hours ago in ISO 8601 Format
  $last7days = date('Y-m-d\TH:i:s.Z\Z', strtotime('-7 day', time()));

// Get the Total Open Issues
  $result_total = $openissue->getOpenIssue($url);
  $total = $openissue->getJson($result_total);
  if ($total['success'] == 0) {
    $error_msg = $total['data'];
  }else {
    $total_open_issues = $total['data']['open_issues_count'];
  }


// Get Past 24 hours Open Issues
  $result_past24hr = $openissue->getOpenIssue($url,$last24hr);
  $past24hr = $openissue->getJson($result_past24hr);
  $open_issues_past_24 = sizeof($past24hr['data']);

// Get Past 7 days Open Issues
  $result_past7days = $openissue->getOpenIssue($url,$last7days);
  $past7days = $openissue->getJson($result_past7days);
  $open_issues_past_7 = sizeof($past7days['data']);

//Get no of open issues that were opened in 7 days ago except for past 24 hour
  $open_issue_past_week = $open_issues_past_7-$open_issues_past_24;

//Get no of open issues that were opened more than 7 days ago
  $open_issue_more_7_days = $total_open_issues-$open_issues_past_7;

//Set the display value
  $display = 1;
  // echo "<pre>";
  // print_r($open_issues_past_7);
  // echo "</pre>";
}
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GitHub Challenge</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <section class="main">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-lg-offset-3 text-center">
              <div class="panel panel-warning">
                <div class="panel-heading">
                  <h3 class="panel-title">Get your open issues stats on the go</h3>
                </div>
                <div class="panel-body">
                  <form action="" method="POST">
                    <div class="form-group">
                      <input type="text" name="url" class="form-control" placeholder="Full URL of GitHub Repository" size="100">
                      <p class="error-block"></<?php echo $error_msg; ?></p>
                    </div>
                  <input type="submit" class="btn btn-danger" name="getdata">
                  </form>

                  <?php
                  if($display == 1){ ?>
                                      <hr class="star-primary">
                  <div class="row counter-lg text-center">
                	<div class="col-xs-6 col-sm-3">
                		<span class="counter" data-speed="3000" style="color:#59BA41"><?php echo $total_open_issues; ?></span>
                		<h4>Total Open Issues</h4>
                	</div>

                	<div class="col-xs-6 col-sm-3">
                		<span class="counter" data-speed="3000" style="color:#774F38"><?php echo $open_issues_past_24; ?></span>
                		<h4>24 Hours Ago</h4>
                	</div>

                	<div class="col-xs-6 col-sm-3">
                		<span class="counter" data-speed="3000" style="color:#C02942"><?php echo $open_issue_past_week; ?></span>
                		<h4>More than 24 hours ago but less than 7 days ago</h4>
                	</div>

                	<div class="col-xs-6 col-sm-3">
                		<span class="counter" data-speed="3000" style="color:#1693A5"><?php echo $open_issue_more_7_days; ?></span>
                		<h4>More than 7 days ago</h4>
                	</div>
                </div>
                <?php } ?>
                </div>
                <div class="panel-footer">
                  <p>
                    A product by <a href="https://seshuen.in">Seshu En</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>





    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom jQuery -->
    <script>
      jQuery(document).ready(function($) {
          $('.counter').counterUp({
              delay: 10,
              time: 1000
          });
      });
  </script>
  <!-- Counter Jquery -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
  <script src="jquery.counterup.min.js"></script>

  </body>
</html>
