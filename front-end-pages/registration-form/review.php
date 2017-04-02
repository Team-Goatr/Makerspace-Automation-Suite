<?php

require_once dirname(__DIR__).'/resources/StripeAPI.php';

//get_header();

// Things that were POST'ed
$first = $_POST["firstname"];
$last = $_POST["lastname"];
$email = $_POST["email"];
$username = $_POST["username"] . "@decaturmakers.org";
$type = $_POST['type'];
$checked = empty($_POST["autorenew"]) ? "" : "checked";
$password = $_POST["password"];

// TODO: Check G suite if this username already exists. If so, print warning and don't allow user to continue

// Get plan from Stripe
$plan = retrieveStripePlan($type);
if (empty($plan)) {
    echo "Invalid subscription type.";
    die();
}

$planamount = $plan->amount;
$planname = $plan->name;
$plandollars = $planamount/100;

echo <<<END
        
        <br>
        <h3>Registration Confirmation Page</h3>
        
        <div class="container">
            <div class="row">
                <form action="?action=submit" method="POST" class="form-horizonal">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="first" class="control-label">First Name:</label>
                            <input type="text" class="form-control" id="first" name="firstname" value="$first" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="last" class="control-label">Last Name:</label>
                            <input type="text" class="form-control" id="last" name="lastname" value="$last" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="$email" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="username" class="control-label" >Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="$username" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="type" class="control-label" >Membership type:</label>
                            <label>$planname for $plandollars/mo</label>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="autorenew" $checked> Auto-renew Membership</label>
                            </div>
                        </div>

                        <input type="hidden" value="$type" name="type" />
                        <input type="hidden" value="$password" name="password" />

                        <div class="form-group">
END;
                        getStripeCheckout($email, $planamount);
echo <<<END
                        </div>
                    </div>
                </form>
            </div>
        </div>

END;

//get_footer();
?>
