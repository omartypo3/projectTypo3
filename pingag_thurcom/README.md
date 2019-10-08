# Tipps für Extbase

### Neues Feld hinzufügen (Beispiel firstName für die Bestellung)

##### 1. Im ext_tables.sql das ensprechende Feld erweitern:
`first_name tinytext,`
##### 2. Im Model (Classes/Domain/Model/SubscriptionOrder.php) Property und Getter/Setter Methoden einfügen:
`protected $firstName;`
`public function getFirstName(){return $this->firstName;}`
`public function setFirstName($firstName){$this->firstName = $firstName;}`

##### 3. TCA Erweitern (Configuration/TCA/tx_pingagthurcom_domain_model_subscription_order.php)
`'first_name' => $helper->getInputColumnsConfig('first_name'),`

##### 4. Übersetzungen ergänzen unter Resources/Private/Language/tx_pingagthurcom_domain_model_subscription_order.xlf

##### 5. Install Tool Datenbank updaten + Cache leeren

##### 6. Formular dementsprechend ergänzen


### Plugin erstellen

##### 1. ext_tables.php ergänzen
`$configurePluginWithFlexform('product_consultation', 'Produktberater');`

##### 2. ext_localconf.php ergänzen