<?php
namespace Apigee\Mint;

use Apigee\Util\CacheFactory;
use Apigee\Util\OrgConfig;
use Apigee\Mint\Types\DeveloperTncsActionType;
use Apigee\Mint\DataStructures\DeveloperTnc;
use Apigee\Exceptions\ParameterException;

class TermAndCondition extends Base\BaseObject
{

    private $id;

    private $organization;

    private $startDate;

    private $tncText;

    private $url;

    private $version;

    public function __construct(OrgConfig $config)
    {
        $base_url = '/mint/organizations/' . rawurlencode($config->orgName) . '/tncs';
        $this->init($config, $base_url);

        $this->wrapperTag = 'tnc';
        $this->idField = 'id';
        $this->idIsAutogenerated = true;

        $this->initValues();
    }

    /**
     * @param bool $current
     * @param int $page_size
     * @return TermAndCondition[]
     * @throws ParameterException
     */
    public function getList($current = true, $page_size = 20)
    {
        $url = isset($current) ? '?current=true' : null;
        $cache_manager = CacheFactory::getCacheManager();
        $data = $cache_manager->get('tncs:' . $current, null);
        if (!isset($data)) {
            $this->get($url);
            $data = $this->responseObj;
            $cache_manager->set('tncs:' . $current, $data);
        }
        $objects = array();
        foreach ($data['tnc'] as $tnc_data) {
            $tnc = new TermAndCondition($this->config);
            $tnc->loadFromRawData($tnc_data);
            $objects[] = $tnc;
        }
        return $objects;
    }

    protected function initValues()
    {
        $this->id = null;
        $this->startDate = null;
        $this->version = null;
    }

    public function instantiateNew()
    {
        return new TermAndCondition($this->config);
    }

    public function loadFromRawData($data, $reset = false)
    {
        if ($reset) {
            $this->initValues();
        }

        $excluded_properties = array('organization');

        foreach (array_keys($data) as $property) {
            if (in_array($property, $excluded_properties)) {
                continue;
            }

            // form the setter method name to invoke setXxxx
            $setter_method = 'set' . ucfirst($property);
            if (method_exists($this, $setter_method)) {
                $this->$setter_method($data[$property]);
            } else {
                self::$logger->notice('No setter method was found for property "' . $property . '"');
            }
        }

        // Set objects

        if (isset($data['organization'])) {
            $organization = new Organization($this->config);
            $organization->loadFromRawData($data['organization']);
            $this->organization = $organization;
        }
    }

    public function __toString()
    {
        $obj = array();
        $properties = array_keys(get_object_vars($this));
        $excluded_properties = array_keys(get_class_vars(get_parent_class($this)));
        foreach ($properties as $property) {
            if (in_array($property, $excluded_properties)) {
                continue;
            }
            if (isset($this->$property)) {
                $obj[$property] = $this->$property;
            }
        }
        return json_encode($obj);
    }

    /**
     * @param string $developer_id
     * @param bool $current
     * @return DeveloperTnc[]
     * @throws ParameterException
     */
    public function getAcceptedDevTermsAndConditions($developer_id, $current = false)
    {

        $cache_manager = CacheFactory::getCacheManager();
        $data = $cache_manager->get('developer_accepted_tncs:' . $developer_id, null);
        if (!isset($data)) {
            $url = '/mint/organizations/'
                . rawurlencode($this->config->orgName)
                . '/developers/'
                . rawurlencode($developer_id)
                . '/developer-tncs';
            if ($current) {
                $url .= '?current=true';
            }
            $this->setBaseUrl($url);
            $this->get();
            $this->restoreBaseUrl();
            $data = $this->responseObj;
            $cache_manager->set('developer_accepted_tncs:' . $developer_id, $data);
        }
        $dev_tncs = array();
        foreach ($data['developerTnc'] as $tnc) {
            $dev_tnc = new DeveloperTnc($tnc);
            if (isset($tnc['tnc'])) {
                $tncs = new TermAndCondition($this->config);
                $tncs->loadFromRawData($tnc['tnc']);
                $dev_tnc->setTnc($tncs);
                $dev_tncs[] = $dev_tnc;
            }
        }
        return $dev_tncs;
    }

    public function isAbleToPurchase($developer_id)
    {
        $tncs = $this->getList(false);
        $tncids_and_dates = array();
        $current_date = null;
        foreach ($tncs as $tnc) {
            $timezone = timezone_open($tnc->getOrganization()->getTimezone());
            if ($current_date == null) {
                $current_date = date_create('now', $timezone);
            }

            $start_date = date_create_from_format('Y-m-d', $tnc->getStartDate(), $timezone);

            // Skip TnC if start date is in the future
            if ($start_date > $current_date) {
                //continue;
            }

            // Add to developer should accept TnCs
            $tncids_and_dates[$start_date->getTimestamp()] = $tnc->getId();
        }

        // Sort tncs ASC by start date
        ksort($tncids_and_dates);

        // Get developer accepted tncs
        $dev_tncs = $this->getAcceptedDevTermsAndConditions($developer_id, true);

        // Loop accepted tncs and see if the latest is there and action==ACCEPTED
        foreach ($dev_tncs as $dev_tnc) {
            if ($dev_tnc->getAction() == DeveloperTncsActionType::ACCEPTED
                && in_array($dev_tnc->getTnc()->getId(), $tncids_and_dates)
            ) {
                return true;
            }
        }
        return false;
    }

    public function acceptTermsAndConditions(DeveloperTnc $tnc, $developer_id, $id = null)
    {
        if (is_null($id)) {
            if (is_null($this->id)) {
                throw new ParameterException('Cannot create developerTnc without a TnC\'s Id.');
            } else {
                $id = $this->id;
            }
        }
        $url = '/mint/organizations/'
            . rawurlencode($this->config->orgName)
            . '/developers/'
            . rawurlencode($developer_id)
            . '/tncs/'
            . rawurlencode($id)
            . '/developer-tncs';
        $this->setBaseUrl($url);
        $this->post(null, $tnc->__toString());
        $this->restoreBaseUrl();
        $tnc = new DeveloperTnc($this->responseObj);
        return $tnc;
    }

    public function getId()
    {
        return $this->id;
    }

    // Used in data load invoked by $this->loadFromRawData()
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getFormattedStartDate($format = 'Y-m-d')
    {
        $start_date = date_create_from_format('Y-m-d', $this->startDate);
        return $start_date->format($format);
    }

    public function setStartDate($date)
    {
        $start_date = date_create_from_format('Y-m-d H:i:s', $date);
        if ($start_date !== false) {
            $this->startDate = $start_date->format('Y-m-d');
        } else {
            throw new ParameterException('Date parameter ' . $date . ' could not be parsed.');
        }
    }

    public function getTncText()
    {
        return $this->tncText;
    }

    public function setTncText($tnc_text)
    {
        $this->tncText = $tnc_text;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }
}
