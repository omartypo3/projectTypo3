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

<!--Main content -->
<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-paddingxs-left-right">
    <div class="container ">
        <div class="bigtitle">
            <h2>Fahrpläne</h2>
            <div class="col-xs-12 col-md-7 col-lg-7 col-sm-12 no-padding-left-right">
                <p>Hier könnte noch ein kleiner einleitender Text stehen, der diesen Bereich ein wenig ausschmückt.</p>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 ">
    <div class="container ">
        <div class="row navigationtabs">
            <ul class="menu-tabs nav nav-tabs ">
                <li class="col-xs-6 col-md-6 col-lg-6 col-sm-6 active">
                    <a data-toggle="tab" href="#linie" aria-expanded="true">Linie</a>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-6 col-sm-6">
                    <a data-toggle="tab" href="#haltestelle" aria-expanded="false">Haltestelle</a>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-6 col-sm-6"></li>

            </ul>
        </div>
    </div>
</div>
<div class="greyback">
    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-padding-left-right">

        <div class=" tab-content">
            <!-- tab 1 : Linie-->
            <div id="linie" class="tab-pane fade in active margin-bottom-60 margin-top-60 margin-top-sm-15 ">
                <div class="container ">
                    <div class="row">

                        <div class="col-xs-12 col-lg-5 col-md-5 col-sm-12 padding-bottom15 ">
                            <form class="form-fields ">
                                <div class="input-group date datetimepicker width-100 margin-bottom-15 ">
                                    <input type="text" class="form-control"/>
                                    <span class="input-group-addon-1">
                                        <div class="icon icon-rsag-clear-calendar"></div>
                                    </span>
                                </div>
                                <div class="optionline ">
                                    <div class="icon icon-rsag-clear-tram pull-left"></div>
                                    <label hidden > Straßenbahn </label>
                                </div>
                                <div class="optionline ">
                                    <div class="icon icon-rsag-clear-bus pull-left"></div>
                                    <label hidden > Bus </label>
                                </div>
                                <div class="optionline ">
                                    <div class="icon icon-rsag-clear-bus-taxi pull-left"></div>
                                    <label hidden >  Taxi </label>
                                </div>
                                <div class="optionline ">
                                    <div class="icon icon-rsag-clear-ferry pull-left"></div>
                                    <label hidden > Ferry </label>
                                </div>


                                <label class="label">Linie</label>
                                <select class="selectpicker" title="Linie auswählen">
                                    <option value="" selected>Line1</option>
                                    <option value="">Line2</option>
                                </select>
                                <label class="label">Richtung</label>
                                <select class="margin-bottom-15 selectpicker " title="Linie auswählen">
                                    <option value="" selected>Mecklenburger Allee</option>
                                    <option value="">Mecklenburger1 Allee</option>
                                </select>
                                <button class="btn btn-primary">plan anzeigen</button>
                            </form>

                        </div>

                        <div class="col-xs-12 col-lg-6 col-md-6 col-sm-12  pull-right">
                            <div class="white-background direction">
                                <div class="titledirection">
                                    <span class="red">Tram</span>
                                    <span class="red">1</span>
                                    <h3>Mecklenburger Allee</h3>
                                </div>
                                <ul>
                                    <li><a>HP Dierkow</a></li>
                                    <li><a>Katerweg</a></li>
                                    <li><a> Dierkow-Zentrum</a></li>
                                    <li><a> Dierkower Kreuz</a></li>
                                    <li><a> Dierkower Damm</a></li>
                                    <li><a> Petridamm</a></li>
                                    <li><a> Stadthafen</a></li>
                                    <li><a> Gerberbruch</a></li>
                                    <li><a> Dierkower Kreuz</a></li>
                                    <li><a> Dierkower Damm</a></li>
                                    <li><a>Petridamm</a></li>
                                    <li><a>Stadthafen</a></li>
                                    <li><a>Gerberbruch</a></li>
                                    <li><a> Dierkower Kreuz</a></li>
                                    <li><a> Dierkower Damm</a></li>
                                    <li><a> Petridamm</a></li>
                                    <li><a> Stadthafen</a></li>
                                    <li><a> Gerberbruch</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /tab 1 : Linie-->
            <!-- tab 2 : Haltestelle-->
            <div id="haltestelle" class="tab-pane  margin-bottom-60 margin-top-60 margin-top-sm-15 ">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
                            <p>
                                Geben Sie das Dateum und Ihre gewünschte Haltestelle ein, oder suchen Sie diese in der
                                alphabetisch sortierten Auflistung.
                            </p>
                            <form class="form-fields ">
                                <div class="input-group date datetimepicker width-100 margin-bottom-15 ">
                                    <input type="text" class="form-control"/>
                                    <span class="input-group-addon-1">
                                        <div class="icon icon-rsag-clear-calendar"></div>
                                    </span>
                                </div>
                                <input type='text' class="form-control" placeholder="Haltestelle"/>
                                <a class="registerbutton margin-bottom-15 " href="">
                                    <div class="icon icon-rsag-round-arrow-1-right pull-left margin-right10 "></div>
                                    Haltestellenliste
                                </a>
                                <button class="btn btn-primary">plan anzeigen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- /tab 2 : Haltestelle-->

        </div>

    </div>
</div>


<!-- /Main content -->

<!-- Footer -->
<?php require 'includes/footer.html'; ?><!-- /Footer -->
<!-- javascript files -->
<?php require 'includes/scripts.html'; ?>
</body>
</html>