<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head Bloc -->
    <?php require 'includes/head.html'; ?>
    <!-- Head -->
</head>
<body>
<!-- Header Bloc -->
<?php require 'includes/header-noneabsolute.html'; ?><!-- /Header Bloc -->
<!-- Tabs search -->
<div class="hidemobile firstactive">
    <?php require 'includes/tabs.html'; ?>
</div><!-- /Tabs search -->

<!--Main content -->
<div class="geodecode col-xs-12 col-md-12 col-lg-12 col-sm-12 no-padding-left-right no-border greyback ">

    <div class=" col-xs-12 col-md-4 col-lg-4 col-sm-12 no-padding-left-right ">
        <h2 class="ihreverb" dataname-ticket="Details">Ihre Verbindungen</h2>
        <div class="distancebetween">
            <ul>
                <li>Rostock, Neuer Markt</li>
                <li><img src="images/lineppt.png"></li>
                <li>Warnemünde Werft</li>
            </ul>
        </div>
        <div class="geodate padding-left30 date">Mo. 07.08.2017</div>
        <div class="geodate_1 geodate">
            <div class="traget">

                <table>
                    <tr>
                        <td>15:01</td>
                        <td><span class="red">Tram</span></td>
                        <td><img src="images/sortie.png"/></td>
                        <td>15:31</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><span class="red">6</span></td>
                        <td><span class="green">S1</span></td>
                        <td><span class="pluszero pull-left">+0</span></td>
                    </tr>
                </table>
            </div>
            <div class="tragetmoney pull-right">
                <table>
                    <tr>
                        <td><img src="images/clock.png"/> 0:26</td>
                        <td><img src="images/doublef.png"/> 1</td>
                        <td><img src="images/money.png"/> 2,10€</td>
                        <td data-id="1"><a onclick="getticketitem(1)">
                                <div class="icon icon-rsag-round-arrow-1-right "></div>
                            </a></td>
                    </tr>
                </table>


            </div>
        </div>


        <div class="geodate_2 geodate">
            <div class="traget">

                <table>
                    <tr>
                        <td>15:11</td>
                        <td><span class="red">Tram</span></td>
                        <td><img src="images/sortie.png"/></td>
                        <td>15:27</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><span class="red">6</span></td>
                        <td><span class="green">S1</span></td>
                        <td><span class="pluszero pull-left">+0</span></td>
                    </tr>
                </table>
            </div>
            <div class="tragetmoney pull-right">
                <table>
                    <tr>
                        <td><img src="images/clock.png"/> 0:26</td>
                        <td><img src="images/doublef.png"/> 1</td>
                        <td><img src="images/money.png"/> 2,10€</td>
                        <td data-id="2"><a onclick="getticketitem(2)">
                                <div class="icon icon-rsag-round-arrow-1-right "></div>
                            </a></td>
                    </tr>
                </table>


            </div>
        </div>
        <div class="geodate_3 geodate">
            <div class="traget">

                <table>
                    <tr>
                        <td>15:16</td>
                        <td><span class="red">Tram</span></td>
                        <td><img src="images/sortie.png"/></td>
                        <td>15:42</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><span class="red">6</span></td>
                        <td><span class="green">S1</span></td>
                        <td><span class="pluszero pull-left">+0</span></td>
                    </tr>
                </table>
            </div>
            <div class="tragetmoney pull-right">
                <table>
                    <tr>
                        <td><img src="images/clock.png"/> 0:26</td>
                        <td><img src="images/doublef.png"/> 1</td>
                        <td><img src="images/money.png"/> 2,10€</td>
                        <td data-id="3"><a onclick="getticketitem(3)">
                                <div class="icon icon-rsag-round-arrow-1-right "></div>
                            </a></td>
                    </tr>
                </table>


            </div>
        </div>


        <div class="traget">
            <ul>
                <li><a class="btn btn-white  ">Früher</a></li>
                <li><a class="btn btn-white" >Später</a></li>
            </ul>
        </div>
        <div class="itemticket" hidden>
            <div class="bottomlinks">
                <ul class="no-padding-left">
                    <li><a>
                            <div class="icon icon-rsag-round-arrow-1-left "></div>
                            vorherige</a></li>
                    <li><a>
                            <div class="icon icon-rsag-round-print "></div>
                            Druck</a></li>
                    <li><a>
                            <div class="icon icon-rsag-round-print "></div>
                            Export</a></li>
                    <li><a>
                            <div class="icon icon-rsag-round-calendar "></div>
                            nächste</a></li>
                </ul>
            </div>
            <div class="item">
                <div class="pluspicture pull-left"><img src="images/redplus.png"></div>

                <table class="pull-right">
                    <tr>
                        <td class="big">15:01</td>
                        <td>Rostock, Kröpeliner Tor</td>
                        <td>A</td>
                    </tr>
                    <tr class="no-border">
                        <td><span class="red">Tram</span></td>
                        <td class="inline"><span class="red">6</span> <img src="images/fleche.png"/>
                            <span>Neuer Friedhof</span></td>
                        <td></td>
                    </tr>
                    <tr class="no-border">
                        <td></td>
                        <td class="inline"><p>5 Min</p>
                            <p>2 Zwischenhalte</p>
                            <p>Alle 20 Minuten</p>

                        </td>
                        <td></td>
                    </tr>
                    <tr class=" greybackround">
                        <td class="center"><img src="images/info.png"/></td>
                        <td class="inline"> Niederflurfahrzeug</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="big">15:06</td>
                        <td>Rostock, Parkstraße</td>
                        <td>B</td>
                    </tr>
                    <tr>
                        <td class="center"><img src="images/men.png"/></td>
                        <td class="inline"> Fußweg 3 Minuten (186m)</td>
                        <td></td>
                    </tr>
                </table>

            </div>
            <div class="item">
                <div class="pluspicture pull-left"><img src="images/greenplus.png"></div>

                <table class="pull-right">
                    <tr>
                        <td class="big">15:10</td>
                        <td>Rostock, Parkstraße</td>
                        <td>1</td>
                    </tr>
                    <tr class="no-border">
                        <td class="center"><img src="images/s.png"/></td>
                        <td class="inline"><span class="green">S1</span> <img src="images/fleche.png"/>
                            <span>Warnemünde</span></td>
                        <td></td>
                    </tr>
                    <tr class="no-border">
                        <td></td>
                        <td class="inline"><p>15 Min</p>
                            <p>6 Zwischenhalte</p>
                            <p> Alle 7 - 15 Minuten</p>

                        </td>
                        <td></td>

                    </tr>
                    <tr>
                        <td class="big">15:31</td>
                        <td>Warnemünde Werft</td>
                        <td>1</td>
                    </tr>

                </table>

            </div>

            <h4>Ticket | Preisstufe</h4>
            <div class="checkout">
                <ul>
                    <li><a>Einzelfahrtkarte</a></li>
                    <li class="pull-right"><a>2,10 €</a></li>
                </ul>
                <button type="button" class="btn  submit">Ticketübersicht</button>
            </div>

        </div>
    </div>

    <div class=" col-xs-12 col-md-8 col-lg-8 col-sm-12 no-padding-left-right ">

        <div id="dvMap">
        </div>
    </div>


</div>

<!--/Main content -->

<!-- Footer -->
<?php require 'includes/footer.html'; ?><!-- /Footer -->
<!-- javascript files -->
<?php require 'includes/scripts.html'; ?>
</body>
</html>