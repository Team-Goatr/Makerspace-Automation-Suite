<?php
include dirname(__DIR__).'/resources/StripeAPI.php';

//get_header();

//$submitfile = plugins_url('submit.php', __FILE__);
$submitfile = 'submit.php';

// Things that were POST'ed
$first = $_POST["firstname"];
$last = $_POST["lastname"];
$email = $_POST["email"];
$username = $_POST["username"] . "@decaturmakers.org";
$type = $_POST['type'];
$checked = empty($_POST["autorenew"]) ? "" : "checked";

// Get plan from Stripe
$plan = retrieveStripePlan($type);
if (empty($plan)) {
    echo "Invalid subscription type.";
    die();
}

$planamount = $plan->amount;
$planname = $plan->name;
$plandollars = $planamount/100;

//print_r($_POST);

echo <<<END

<html>
    <body>
        <h1>Registration Confirmation Page</h1>
        <div class="row">
            <form action="$submitfile" method="POST" class="form-horizonal">
                <div class="form-group">
                    <label for="first" class="col-md-3 control-label">First Name:</label>
                    <div class="col-sm-10">
                        <input type="text" style="width: 60%" class="form-control" id="first" name="firstname" value="$first" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="last" class="col-md-3 control-label">Last Name:</label>
                    <div class="col-sm-10">
                        <input type="text" style="width: 60%" class="form-control" id="last" name="lastname" value="$last" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" style="width: 60%" class="col-md-6 form-control" id="email" name="email" value="$email" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="col-md-3 control-label" >Username:</label>
                    <div class="col-sm-10">
                        <input type="text" style="width: 60%" class="col-md-6 form-control" id="username" name="username" value="$username" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-md-3 control-label" >Membership type:</label>
                    <div class="col-sm-10">
                        <label>$planname for $plandollars/mo</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label><input type="checkbox" name="autorenew" $checked disabled="disabled"> Auto-renew Membership</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <!--<button type="submit" class="btn btn-primary">Submit</button>-->
END;
                        getStripeCheckout($email, $planamount);
echo <<<END
                    </div>
                </div>
            </form>
        </div>

        <!-- ANGULAR -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

        <!-- BOOTSTRAP -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>


END;

//get_footer();
?>
