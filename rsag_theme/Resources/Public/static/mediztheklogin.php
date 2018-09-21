<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Head Bloc -->
        <?php require 'includes/head.html'; ?>
        <!-- Head -->
    </head>
    <body>
        <!-- Header Bloc -->
        <?php require 'includes/header.html'; ?><!-- /Header Bloc -->
        <!-- Slider -->
        <?php require 'includes/slider.html'; ?><!-- /Slider -->
        <!-- Tabs search -->
        <div class="hidemobile">
            <?php require 'includes/tabs.html'; ?>
        </div><!-- /Tabs search -->
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <div class="container">
                <div class="icon icon-rsag-round-arrow-1-right pull-left "></div>
                <ul>
                    <li><a href="pressebereich.php">Unternehmen</a></li>
                    <li><a href="pressebereich.php"> Presse</a></li>
                </ul>
            </div>
        </div><!-- /Breadcrumb -->

        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-paddingxs-left-right ">
            <div class="container ">
                <div class=" bigtitle">
                    <h2>Mediathek</h2>
                    <div class="col-xs-12 col-md-7 col-lg-7 col-sm-12 no-padding-left-right">
                        <p>Hier könnte ein kleiner einleitender Text stehen, der diesen Bereich der Seite näher beschreibt.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mediatheck">
            <div class="container margin-top-60  margin-top-xs-20 margin-bottom-60">
                <div class="row">
                    <form class="col-xs-12 col-md-5 col-lg-5 col-sm-12 form-fields ">
                        <h2>Login</h2>
                        <p class="col-md-10 col-sm-12 col-xs-12 no-padding-left-right">Um diesen Bereich betreten zu können, müssen sie sich einloggen. </p>
                        <div class="form-group margin-top-30">

                            <input type="email" class="form-control" placeholder="E-Mail"/>
                        </div>
                        <div class="form-group">

                            <input type="password" class="form-control" placeholder="Passwort">
                        </div>
                        <button class="btn btn-primary submit">Einloggen</button>
                        <div class="form-group">
                            <a class="registerbutton" href="">
                                <span class="icon icon-rsag-round-arrow-1-right pull-left margin-right10 "></span>
                                <span>Registrieren</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <?php require 'includes/footer.html'; ?><!-- /Footer -->
        <!-- javascript files -->
        <?php require 'includes/scripts.html'; ?>
    </body>
</html>