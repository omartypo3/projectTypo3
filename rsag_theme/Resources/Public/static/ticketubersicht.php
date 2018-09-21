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

        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-paddingxs-left-right white-background">
            <div class="container ">
                <div class=" bigtitle">
                    <h2>Ticketübersicht</h2>
                    <div class="col-xs-12 col-md-7 col-lg-7 col-sm-12 no-padding-left-right">
                        <p class="margin-bottom-20">
                            Egal ob Sie gelegentlich oder regelmäßig die RSAG-Verkehrsmittel nutzen, ganz gleich ob Sie aus Rostock kommen oder nur zu Besuch sind: Wir haben den richtigen Fahrschein für Sie.
                        </p>
                        <p class="second-parag margin-bottom30">
                            Wir fahren im Verbund: Mit einem VVW-Ticket fahren Sie nicht nur mit den Bussen und Straßenbahnen der RSAG, sondern auch Fähre, S-Bahn und Regionalbus.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Three Tabs: links -->
        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-paddingxs-left-right">
            <div class="container ">
                <div class="row navigationtabs">
                    <ul class="menu-tabs nav nav-tabs ">
                        <li class="col-xs-4 col-md-4 col-lg-4 col-sm-4">
    <a data-toggle="tab" href="#rostock"><br>Rostock </a>

                        </li>
                        <li class="active col-xs-4 col-md-4 col-lg-4 col-sm-4">
                            <a data-toggle="tab" href="#region" class="regionTop">Region, <br>Rostock & Region</a>
                        </li>
                        <li class="col-xs-4 col-md-4 col-lg-4 col-sm-4">
                            <a data-toggle="tab" href="#gustrow" >Güstrow, <br>Bützow </a>
                        </li>
                        <li class="col-xs-4 col-md-4 col-lg-4 col-sm-4"></li>
                    </ul>
                </div>
            </div>
        </div><!-- /Three Tabs: links -->
        <!-- Three Tabs: contents -->
        <div class="greyback tableau-list">
            <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-paddingsm-left-right">
                <div class=" tab-content ">
                    <!-- tab 1 : rostock -->
                    <div id="rostock" class="tab-pane fade margin-bottom-60 margin-top-15 margin-top-xs-0">

                    </div><!-- /tab 1 : rostock -->
                    <!-- tab 2 : region -->
                    <div id="region" class="tab-pane fade in active margin-bottom-60 margin-top-15 margin-top-xs-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 margin-top-20  margin-bottom-60 padding-smleft-right-15 padding-left-right-7-5">
                                    <div class="col-sm-12 no-padding-left-right">
                                        <p class=" ticketubersicht-title margin-bottom-20 margin-top-20 padding-left-right-7-5">
                                            Rostock und die Region sind in Zonen eingeteilt. Bitte wählen sie Ihre entsprechende Zonenanzahl aus.
                                        </p>
                                    </div>
                                    <div class=" col-sm-12 padding-left-right-7-5">
                                        <select class="col-md-5 col-lg-5 col-xs-12 col-sm-12 form-select padding-left-right-7-5" title="Linie auswählen">
                                            <option value="" selected>1 Zone</option>
                                            <option value="">Line2</option>
                                        </select>
                                    </div>
                                    <div class=" col-sm-12 padding-left-right-7-5 form-fields margin-bottom-60">
                                        <a class="registerbutton  col-md-12 col-lg-12 no-padding-left-right" href="">
                                            <div class="icon icon-rsag-round-arrow-1-right pull-left margin-right10 "></div>
                                            Informationen zu den Zonen
                                        </a>
                                    </div>
                                    <!-- table left -->
                                    <div class="col-xs-12 col-md-6 col-lg-6 col-sm-12 padding-left-right-7-5 ">
                                        <div class="download-item">
                                            <ul>
                                                <!-- table header -->
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Einzelfahrkarten</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-righ">Preis</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        Info
                                                    </a>
                                                </li><!-- /table header -->
                                                <!-- table content -->
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Kurzstrecke</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-righ">1,50 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Einzelkarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-righ">2,00 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Einzalkarte ermäßigt</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-righ">1,40 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Tageskarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-righ">4,20 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Tageskarte ermäßigt</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-righ">2,90 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Gruppen-Tageskarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">12,60 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Fahrradkarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-righ">3,50 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Fahrrad-Tageskarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">6,00 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li><!-- /table content -->
                                            </ul>
                                        </div>
                                    </div><!-- /table left -->
                                    <!-- table right -->
                                    <div class="col-xs-12 col-md-6 col-lg-6 col-sm-12 padding-left-right-7-5 ">
                                        <div class="download-item">
                                            <ul>
                                                <!-- table header -->
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Einzelfahrkarten</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">Preis</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        Info
                                                    </a>
                                                </li><!-- /table header -->
                                                <!-- table content -->
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Wochenkarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">14,20 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Wochenkarte ermäßigt</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">10,70 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Monatskarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">43,00 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Monatskarte ermäßigt</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">32,50 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Monatskarte + Family</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">48,00 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Monatskarte + Bike</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">48,00 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Monatskarte plus</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">51,00 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="col-lg-8 col-md-7 col-sm-7 col-xs-7 no-padding-left-right">Fahrradmonatskarte</a>
                                                    <a href="#" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 no-padding-right">20,00 €</a>
                                                    <a href="#" class="col-lg-2 col-md-2 col-sm-2 col-xs-1 no-paddingxs-left-right">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </a>
                                                </li><!-- /table content -->
                                            </ul>
                                        </div>
                                    </div> <!-- /table right -->
                                    <div class="col-xs-12">
                                        <span class="col-xs-12">Fahrpreise gültig ab 01.02.2017</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Abokarten im Uberblick -->
                        <div class="container-fluid white-background">
                            <div class="container margin-top-60 margin-bottom-60 margin-top-xs-0 ">
                                <div class="row">
                                    <h2 class="title-social-media margin-bottom-20">Abokarten im Überblick</h2>
                                    <!-- Abokarten item -->
                                    <div class="margin-bottom-60 col-xs-12 col-md-6 col-lg-6 col-sm-6 no-padding-left-right padding-left-right-7-5 abokarten">

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="#">
                                                    <div class="icon icon-rsag-clear-student-ticket"></div>
                                                    <h4>Monatskarte*</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="pressemitteilungen.php">
                                                    <div class="icon icon-rsag-clear-monthly-ticket-family"></div>
                                                    <h4>Monatskarte* + Family</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="#">
                                                    <div class="icon icon-rsag-clear-monthly-ticket-bike"></div>
                                                    <h4>Monatskarte* + Bike</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="#">
                                                    <div class="icon icon-rsag-clear-monthly-ticket-plus"></div>
                                                    <h4>Monatskarte*
                                                        plus</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="#">
                                                    <div class="icon icon-rsag-clear-mobil-60"></div>
                                                    <h4>Mobil60- Ticket</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="mediztheklogin.php">
                                                    <div class="icon icon-rsag-clear-mobil-60-bike"></div>
                                                    <h4>Mobil60- Ticket + Bike</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="mediztheklogin.php">
                                                    <div class="icon icon-rsag-clear-student-ticket"></div>
                                                    <h4>Schüler Ticket</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="mediztheklogin.php">
                                                    <div class="icon icon-rsag-clear-semester-ticket"></div>
                                                    <h4>Semester Ticket</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-left-right imageWH-same-50">
                                            <div class="press-item">
                                                <a href="mediztheklogin.php">
                                                    <div class="icon icon-rsag-clear-job-ticket"></div>
                                                    <h4>JobTicket</h4>
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- Abokarten item -->


                                    <div class="margin-bottom-60 col-xs-12 col-md-5 col-lg-5 col-sm-5 col-sm-offset-1 no-padding-left-right padding-left-right-7-5">
                                        <div class=" col-sm-12 padding-left-right-7-5 form-fields margin-bottom-60">
                                            <a class="registerbutton  col-md-12 col-lg-12 no-padding-left-right" href="#">
                                                <div class="icon icon-rsag-round-arrow-1-right pull-left margin-right10 "></div>
                                                Informationen Abo-Online
                                            </a>
                                        </div>
                                        <p class="abokarten-description">
                                            * Für alle ABO-Monatskarten (außer Mobil60) gilt:
                                            12 Monate fahren und nur 10 Montae zahlen.<br><br>

                                            Beim Kauf einer Jahreskarte mit einmaliger Vorauszahlung des Jahresbeitrag gibt es 3% Rabatt auf die Monatskarte.
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div><!-- /Abokarten im Uberblick -->

                        <!-- Sondertarife -->
                        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 ">
                            <div class="container ">
                                <div class="row">
                                    <!-- Pressemitteilungen item -->
                                    <div class="margin-bottom-60 margin-top-60 col-xs-12 col-md-12 col-lg-12 col-sm-12 no-padding-left-right padding-left-right-7-5  no-paddingxs-left-right" id="sondertarife" >
                                        <h2 class="title-social-media margin-bottom-20">Sondertarife</h2>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-top-15 no-paddingxs-left-right padding-left-right-7-5 sondertarife-item">
                                            <div class="col-xs-12 bloc-description">
                                                <h3 class="fledermausnacht"><a href="#">
                                                        InterCombi-Ticket
                                                    </a>  </h3>
                                                <p class="text-description">
                                                    Reisen Sie von Rostock bequem mit Bus und Fähre in das dänische Nykøbing - Mit nur einer Fahrkarte.
                                                </p>
                                                <div class="row">
                                                    <div class="col-xs-1">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </div>
                                                    <a class="col-xs-10 mehr-infos" href="#">
                                                        Mehr Infos
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-top-15 no-paddingxs-left-right padding-left-right-7-5 sondertarife-item">
                                            <div class="col-xs-12 bloc-description">
                                                <h3 class="fledermausnacht"><a href="#">
                                                        RostockCard
                                                    </a>  </h3>
                                                <p class="text-description">
                                                    Die RostockCARD ist das Erlebnisticket für die Hansestadt Rostock und Umgebung.
                                                </p>
                                                <div class="row">
                                                    <div class="col-xs-1">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </div>
                                                    <a class="col-xs-10 mehr-infos" href="#">
                                                        Mehr Infos
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-top-15 no-paddingxs-left-right padding-left-right-7-5 sondertarife-item ">
                                            <div class="col-xs-12 bloc-description">
                                                <h3 class="fledermausnacht"><a href="#">
                                                        KombiTickets
                                                    </a>  </h3>
                                                <p class="text-description">
                                                    Durch Kooperationen gelten spezielle Eintrittskarten oder Ausweise als Fahrausweise.
                                                </p>
                                                <div class="row">
                                                    <div class="col-xs-1">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </div>
                                                    <a class="col-xs-10 mehr-infos" href="#">
                                                        Mehr Infos
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-top-15 no-paddingxs-left-right padding-left-right-7-5 sondertarife-item ">
                                            <div class="col-xs-12 bloc-description">
                                                <h3 class="fledermausnacht"><a href="#">
                                                        FlughafenTicket
                                                    </a>  </h3>
                                                <p class="text-description">
                                                    Mit dem FlughafenTicket geht es ganz bequem direkt zu Ihrem Urlaubsflieger. Lassen Sie Ihr Auto zu Hause!
                                                </p>
                                                <div class="row">
                                                    <div class="col-xs-1">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </div>
                                                    <a class="col-xs-10 mehr-infos" href="#">
                                                        Mehr Infos
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-top-15 no-paddingxs-left-right padding-left-right-7-5 sondertarife-item ">
                                            <div class="col-xs-12 bloc-description">
                                                <h3 class="fledermausnacht"><a href="#">
                                                        SchülerFerienTicket
                                                    </a>  </h3>
                                                <p class="text-description">
                                                    Der Sommerhit für 32 €: Mit einem ganz Mecklenburg-Vorpommern erkunden.
                                                </p>
                                                <div class="row">
                                                    <div class="col-xs-1">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </div>
                                                    <a class="col-xs-10 mehr-infos" href="#">
                                                        Mehr Infos
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-top-15 no-paddingxs-left-right padding-left-right-7-5 sondertarife-item ">
                                            <div class="col-xs-12 bloc-description">
                                                <h3 class="fledermausnacht"><a href="#">
                                                        IKEA-Angebot
                                                    </a>  </h3>
                                                <p class="text-description">
                                                    ÖPNV-Kunden, die bei IKEA einkaufen, können kostenlos ein Elektroauto leihen.
                                                </p>
                                                <div class="row">
                                                    <div class="col-xs-1">
                                                        <div class="icon icon-rsag-round-arrow-1-right"></div>
                                                    </div>
                                                    <a class="col-xs-10 mehr-infos" href="#">
                                                        Mehr Infos
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- /Pressemitteilungen item -->
                                    <p id="loadingpressium"  >
                                        <img src="images/loadingpress.gif" alt="Loading…" />
                                    </p>
                                </div>
                            </div>
                        </div><!-- /Sondertarife -->


                    </div><!-- /tab 2 : region -->
                    <!-- tab 3 : gustrow -->
                    <div id="gustrow" class="tab-pane fade margin-bottom-60 margin-top-15 margin-top-xs-0">

                    </div><!-- /tab 3 : gustrow -->
                </div>
            </div>
        </div>
        <!-- /Three Tabs: contents -->

        <!-- Footer -->
        <?php require 'includes/footer.html'; ?><!-- /Footer -->
        <!-- javascript files-->
        <?php require 'includes/scripts.html'; ?>
    </body>
</html>