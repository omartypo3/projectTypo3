<?php

class tx_wservice_scheduler_converttask extends tx_scheduler_Task {

    /**
     * servicePartnerRepository
     *
     * @var Tx_WService_Domain_Repository_ServicePartnerRepository
     * @inject
     */
    protected $servicePartnerRepository;

    /**
     * @var Tx_Extbase_Persistence_Manager
     * @inject
     */
    protected $persistenceManager;

    protected $convertIndexLimit;

    public function execute() {

        $limit = $this->convertIndexLimit;

        $objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
        $this->persistenceManager = $objectManager->get('Tx_Extbase_Persistence_Manager');
        $this->servicePartnerRepository = $objectManager->get('Tx_WService_Domain_Repository_ServicePartnerRepository');

        foreach ($this->servicePartnerRepository->findToConvert($limit) as $servicePartner) {

            $address = urlencode($servicePartner->getStreet() . ' ' . $servicePartner->getZip() . ' ' . $servicePartner->getCity(). ' '. $servicePartner->getCountry() . ' ' . $servicePartner->getAdditional() );

            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' .
                $address .
                '&sensor=false'.
                '&key=AIzaSyAdOy5LXKJovNABiA5EQ5Nq-Ywv-JfsduE';

            $response = file_get_contents($url);

            if ($response != false) {

                $response = json_decode($response, true);

                if ($response['status'] == 'OK') {

                    if (isset($response['results'][0]['geometry']['location'])) {

                        // geo location received
                        $latLng = $response['results'][0]['geometry']['location'];

                        $servicePartner->setLat($latLng['lat']);
                        $servicePartner->setLng($latLng['lng']);

                    } else {
                        // no geo data received
                        $servicePartner->setHidden(true);
                    }

                } else if ($response['status'] == 'ZERO_RESULTS'){
                    // no geo data received
                    $servicePartner->setHidden(true);
                } else {

                    // quote limit error?... BREAK!
                    echo "ERROR: " . $response['status'] . ', REQUEST: ' . $url;
                    return TRUE;
                }
            }

            $this->servicePartnerRepository->update($servicePartner);
            $this->persistenceManager->persistAll();

        }

        return TRUE;
    }


    public function getAdditionalInformation() {
        $itemsIndexedPercentage = $this->getProgress();
        return 'Adresses converted: ' . $itemsIndexedPercentage . '%.';
    }

    public function getConvertIndexLimit() {
        return $this->convertIndexLimit;
    }

    public function setConvertIndexLimit($limit) {
        $this->convertIndexLimit = $limit;
    }

    /**
     * Gets the indexing progress.
     *
     * @return float Indexing progress as a two decimal precision float. f.e. 44.87
     */
    private function getProgress() {
        $itemsIndexedPercentage = 0.0;

        $totalItemsCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows(
            'uid',
            'tx_wservice_domain_model_servicepartner',
            'deleted = 0 AND hidden = 0'
        );
        $remainingItemsCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows(
            'uid',
            'tx_wservice_domain_model_servicepartner',
            "(lat = '') AND deleted = 0 AND hidden = 0"
        );

        $itemsIndexedCount = $totalItemsCount - $remainingItemsCount;

        if ($totalItemsCount > 0) {
            $itemsIndexedPercentage = $itemsIndexedCount * 100 / $totalItemsCount;
            $itemsIndexedPercentage = round($itemsIndexedPercentage, 2);
        }

        return $itemsIndexedPercentage;
    }

}

?>