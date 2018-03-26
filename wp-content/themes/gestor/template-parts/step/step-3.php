<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 23/03/18
 * Time: 10:35
 */

global $_form_step;
$page_reserva = get_field( 'page_reserva', 'options' );

$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" and $_POST['step'] == '4') {

	if (empty($_POST["dades-name"])) {
		$nameErr = "Name is required";
	} else {
		$name = test_input($_POST["dades-name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			$nameErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
		}
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



?>

<div class="content">
    <div class="page-title">
        <h2>Dades de facturació</h2>
    </div>
    <form action="<?php echo get_permalink( $page_reserva ); ?>" method="post">

        <input type="hidden" name="action" value="reserva_form">
        <input type="hidden" name="step" value="4">

        <div class="dades-reserva">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dades-name">Nom</label>
                    <input type="text" class="form-control" id="dades-name" placeholder="Nom" value="" >
                    <span class="error">* <?php echo $nameErr;?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="dades-surname">Cognoms</label>
                    <input type="text" class="form-control" id="dades-surname" placeholder="Cognoms" value="" >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dades-nif">NIF/NIE/Passaport</label>
                    <input type="text" class="form-control" id="dades-nif" placeholder="NIF/NIE/Passaport" value="" >
                </div>
                <div class="form-group col-md-6">
                    <label for="dades-email">Email</label>
                    <input type="email" class="form-control" id="dades-email" placeholder="Email" value="" >
                    <span class="error">* <?php echo $emailErr;?></span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dades-phoneNumber">Número de telèfon</label>
                    <input type="tel" class="form-control" id="dades-phoneNumber" placeholder="Número de telèfon" value=""
                           >
                </div>
                <div class="form-group col-md-6">
                    <label for="dades-address">Adreça</label>
                    <input type="text" class="form-control" id="dades-address" placeholder="Adreça" value="" >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dades-postal-code">Codi postal</label>
                    <input type="text" class="form-control" id="dades-postal-code" placeholder="Codi postal" value="" >
                </div>
                <div class="form-group col-md-6">
                    <label for="dades-city">Ciutat</label>
                    <input type="text" class="form-control" id="dades-city" placeholder="Ciutat" value="" >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dades-country">País</label>
                    <input type="text" class="form-control" id="dades-country" placeholder="País" value="" >
                </div>
            </div>
        </div>

        <br>
        <br>

        <div class="page-title">
            <h2>Dades del conductor</h2>
        </div>
        <div class="form-group duplicate-data-container">
            <div class="form-check box-sameDriver">
                <input class="form-check-input" type="checkbox" id="sameDriver">
                <label class="form-check-label" for="sameDriver">
                    Utilitza les dades de facturació
                </label>
            </div>
        </div>

        <div id="conductors">
            <div class="clone hide">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="driver-name">Nom</label>
                        <input type="text" class="form-control" id="driver-clone-name" placeholder="Nom" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="driver-surname">Cognoms</label>
                        <input type="text" class="form-control" id="driver-clone-surname" placeholder="Cognoms" value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="driver-nif">NIF/NIE/Passaport</label>
                        <input type="text" class="form-control" id="driver-clone-nif" placeholder="NIF/NIE/Passaport" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="driver-email">Email</label>
                        <input type="email" class="form-control" id="driver-clone-email" placeholder="Email" value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="driver-phoneNumber">Número de telèfon</label>
                        <input type="tel" class="form-control" id="driver-clone-phoneNumber" placeholder="Número de telèfon" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="driver-licenceNumber">Número de carnet de conduir</label>
                        <input type="text" class="form-control" id="driver-clone-licenceNumber" placeholder="Número de carnet de conduir" value="" >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="driver-licenceExpDate">Data d'expedició del carnet de conduir</label>
                        <input type="text" class="form-control" id="driver-clone-licenceExpDate" placeholder="Data d'expedició del carnet de conduir" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="driver-licenceEndDate">Data de caducitat carnet de conduir</label>
                        <input type="text" class="form-control" id="driver-clone-licenceEndDate" placeholder="Data de caducitat carnet de conduir " value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="driver-address">Adreça</label>
                        <input type="text" class="form-control" id="driver-clone-address" placeholder="Adreça" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="driver-postal-code">Codi postal</label>
                        <input type="text" class="form-control" id="driver-clone-postal-code" placeholder="Codi postal" value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="driver-city">Ciutat</label>
                        <input type="text" class="form-control" id="driver-clone-city" placeholder="Ciutat" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="driver-country">País</label>
                        <input type="text" class="form-control" id="driver-clone-country" placeholder="País" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="driver-birthDate">Data de naixement</label>
                        <input type="text" class="form-control" id="driver-clone-birthDate" placeholder="Data de naixement" value="">
                    </div>
                    <div class="form-group col-md-6">

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <a href="javascript:void(0);" id="driver-clone-removeDriver">Eliminar conductor</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="addDriver">
            <a href="javascript:void(0);" class="add-driver">+ Afegir conductor</a>
        </div>

        <br>

        <div class="form-group">
            <label for="observacions">Observacions</label>
            <textarea class="form-control" id="test-observacions" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-lg button-reserva">PAGAR</button>
		<?php wp_nonce_field( 'post_form_reserva', 'nonce_field' ); ?>

    </form>
</div>
