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
<?php require 'includes/slider.html'; ?>
<!-- /Slider -->
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
</div>
<!-- /Breadcrumb -->


<!-- Main Content -->
<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-paddingxs-left-right">
    <div class="container ">
        <div class=" bigtitle">
            <h2>Bewerbung online</h2>
            <div class="col-xs-12 col-md-7 col-lg-7 col-sm-12 no-padding-left-right">
                <p>Hier könnte ein kleiner einleitender Text stehen, der diesen Bereich der Seite näher beschreibt.</p>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 no-paddingxs-left-right formBewerbung">
    <div class="container ">
        <form action="">
        <div class="form">
            <h2>Formular</h2>
        </div>
        <div class="row">
                 <h4 class="formBew">Zur Person*</h4>
                    <div class="col-xs-12 col-md-2 col-lg-2 col-sm-2 ">
                        <select class="formBew-controle selectArrow">
                            <option>Anrede </option>
                            <option>Anrede</option>
                            <option>Anrede</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 col-sm-4 ">
                        <input type="text" class="formBew-controle" placeholder="Vorname"/>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 col-sm-4 formInp">
                        <input type="text" class="formBew-controle" placeholder="Nachname"/>
                    </div>
        </div>
        <div class="row">
            <h4 class="formBew">Geburtsdatum*</h4>
            <div class="col-xs-12 col-md-2 col-lg-2 col-sm-2  formInp">
                <input type="text" class="formBew-controle" placeholder="Tag"/>
            </div>
            <div class="col-xs-12 col-md-2 col-lg-2 col-sm-2  formInp">
                <input type="text" class="formBew-controle" placeholder="Monat"/>
            </div>
            <div class="col-xs-12 col-md-2 col-lg-2 col-sm-2 formInp">
                <input type="text" class="formBew-controle" placeholder="Jahr"/>
            </div>
        </div>
        <div class="row">
            <h4 class="formBew">Adresse*</h4>
            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5  formInp">
                <input type="text" class="formBew-controle" placeholder="Straße & Hausnummer"/>
            </div>
            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5  formInp">
                <input type="text" class="formBew-controle" placeholder="PLZ & Ort"/>
            </div>
        </div>
        <div class="row">
            <h4 class="formBew">kontact*</h4>
            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5  formInp">
                <input type="text" class="formBew-controle" placeholder="Telefon"/>
            </div>
            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5  formInp">
                <input type="email" class="formBew-controle" placeholder="E-Mail"/>
            </div>
        </div>
        <div class="row  ">
            <h4 class="formBew">Bewerbung als*</h4>
            <div class="col-xs-10 col-md-10 col-lg-10 col-sm-10  radioArea">
               <div class="row">
                   <div class="col-xs-10 col-md-5 col-lg-5 col-sm-5 ">
                       <input type="radio" id="test1" name="radio-group" checked>
                       <label for="test1">Ausbildung: Fachkraft im Fahrbetrieb (m/w)</label>
                   </div>
                   <div class="col-xs-10 col-md-5 col-lg-5 col-sm-5 col-md-offset-1 ">
                       <input type="radio" id="test2" name="radio-group">
                       <label for="test2">Ausbildung: Kfz-Mechatroniker (m/w)  </label>
                   </div>
               </div>
                <div class="row">
                    <div class="col-xs-10 col-md-5 col-lg-5 col-sm-5 ">
                        <input type="radio" id="test3" name="radio-group">
                        <label for="test3">Ausbildung: Mechatroniker (m/w)  </label>
                    </div>
                    <div class="col-xs-10 col-md-5 col-lg-5 col-sm-5 col-md-offset-1 ">
                        <input type="radio" id="test4" name="radio-group">
                        <label for="test4">Stellenangebote: Ausbildung zum Straßenbahnfahrer (m/w)  </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-10 col-md-5 col-lg-5 col-sm-5 ">
                        <input type="radio" id="test5" name="radio-group">
                        <label for="test5">Stellenangebote: Mitarbeiter Einkauf (m/w)  </label>
                    </div>
                    <div class="col-xs-10 col-md-5 col-lg-5 col-sm-5 col-md-offset-1">
                        <input type="radio" id="test6" name="radio-group">
                        <label for="test6">Ausbildung: Fachkraft im Fahrbetrieb (m/w)</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h4 class="formBew">Anstellung ab*</h4>
            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5 ">
                <select class="formBew-controle selectArrow">
                    <option>Datum </option>
                    <option>Anrede</option>
                    <option>Anrede</option>
                </select>
            </div>
        </div>
        <div class="row">
            <h4 class="formBew">Warum möchten Sie bei der RSAG arbeiten?*</h4>
            <div class="col-xs-12 col-md-10 col-lg-10 col-sm-10 ">
                <textarea class="formBew-controle" rows="5" id="comment"></textarea>
            </div>
        </div>
        <div class="row">

            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5  under">
                <h4 class="formBew">Wie sind Sie auf uns aufmerksam geworden?</h4>
                <select class="formBew-controle selectArrow" id="BewSelect">
                    <option value="grund">Grund </option>
                    <option value="sonstiges">sonstiges</option>
                    <option value="Anrede">Anrede</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5 under " id="hidden" style="display: none">
                <h4 class="formBew">Falls Sie andersweitig auf uns aufmerksam geworden sind:</h4>
                <input type="text" class="formBew-controle" placeholder="Grund"/>
            </div>
        </div>

            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5  under">
                    <h4 class="formBew">Bewerbung: Anschreiben, Lebenslauf (PDF Datei)*</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 col-lg-5 col-sm-5  under">
                    <input type="text" class="formBew-controle image-preview-filename" placeholder="Zur Zeit noch keine Datei vorhanden"/>
                </div>
                <div class="col-xs-5 col-md-5 col-lg-5 col-sm-5  under  image-preview-input">
                    <button type="button" class="btn btn-secondary image-preview-input-title "><span class="buttonTitle"> Datei auswählen</span> </button>
                    <input type="file" name="input-file-preview"/> <!-- rename it -->
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5  under">
                    <h4 class="formBew">Anhang (mehrere Dateien möglich)</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 col-lg-5 col-sm-5  under">
                    <input type="text" class="formBew-controle" placeholder="Zeugnisse.pdf"/>
                </div>
                <div class="col-xs-5 col-md-5 col-lg-5 col-sm-5  under">
                    <button type="button" class="btn btn-secondary"><span class="buttonTitle"> Datei auswählen</span></button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 col-lg-5 col-sm-5  under">
                    <input type="text" class="formBew-controle" placeholder="Praktikum.jpg"/>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12  under">
                        <h4 class="formBew">Datenschutzerklärung*</h4>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12  " >
                       <p>
                           <input type="checkbox"> Ich habe die <span style="color: #005091"> Datenschutzerklärung</span>  zur Kenntnis genommen und erkenne sie an. Mit der Erfassung und Speicherung der erforderlichen Daten bin ich einverstanden.
                       </p>
                    </div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 col-lg-5 col-sm-5">
                    <button type="button" class="btn btn-primary"><span class="buttonTitle">Kontrollieren</span></button>
                </div>
                <div class="col-xs-5 col-md-5 col-lg-5 col-sm-5">
                    <button type="button" class="btn btn-secondary"><span class="buttonTitle"> Verwerfen</span></button>
                </div>
            </div>
            <div class="row">
                <p class="fieldsControl">Die mit Stern (*) markierten Felder müssen ausgefüllt werden.</p>
            </div>




        </form>
    </div>
</div><!-- /Main Content -->

<!-- Footer -->
<?php require 'includes/footer.html'; ?><!-- /Footer -->
<!-- javascript files -->
<?php require 'includes/scripts.html'; ?>
</body>
</html>