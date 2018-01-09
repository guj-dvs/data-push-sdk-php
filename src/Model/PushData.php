<?php

namespace Guj\DataPush\Model;

/**
 * Mainmodel for data handling
 *
 * The root data-object for data-push-sdk.
 *
 * @package Guj\DataPush\Model
 */
class PushData extends DataPushModel
{

    const DEFAULT_VERSION = '1.0.0';
    /**
     * @var string
     */
    protected $version = self::DEFAULT_VERSION;
    /**
     * @var string
     */
    protected $producer;
    /**
     * @var string
     */
    protected $client;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $createdAt;
    /**
     * @var string
     */
    protected $appUsage;
    /**
     * @var string
     */
    protected $milestone;
    /**
     * @var UserData
     */
    protected $userData;
    /**
     * @var array
     */
    protected $children = array();
    /**
     * @var array
     */
    protected $newsletter = array();
    /**
     * @var array
     */
    protected $orders = array();
    /**
     * @var array
     */
    protected $optins = array();
    /**
     * @var array
     */
    protected $terms = array();
    /**
     * @var array
     */
    protected $campaigns = array();

    /**
     * @param string $appUsage
     */
    public function setAppUsage($appUsage)
    {
        $this->appUsage = $appUsage;
    }

    /**
     * @param string $milestone
     */
    public function setMilestone($milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * @param Child $child
     */
    public function addChild(Child $child)
    {
        $this->children[] = $child;
    }

    /**
     * @param Newsletter $newsletter
     */
    public function addNewsletter(Newsletter $newsletter)
    {
        $this->newsletter[] = $newsletter;
    }

    /**
     * @param Order $order
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }

    /**
     * @param OptIn $optin
     */
    public function addOptIn(OptIn $optin)
    {
        $this->optins[] = $optin;
    }

    /**
     * @param Term $term
     */
    public function addTerm(Term $term)
    {
        $this->terms[] = $term;
    }

    /**
     * @param Campaign $campaign
     */
    public function addCampaign(Campaign $campaign)
    {
        $this->campaigns[] = $campaign;
    }

    /**
     * @param UserData $userData
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @param array $newsletter
     */
    public function setNewsletter(array $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @param array $orders
     */
    public function setOrders(array $orders)
    {
        $this->orders = $orders;
    }

    /**
     * @param array $optins
     */
    public function setOptins(array $optins)
    {
        $this->optins = $optins;
    }

    /**
     * @param array $terms
     */
    public function setTerms(array $terms)
    {
        $this->terms = $terms;
    }

    /**
     * @param array $campaigns
     */
    public function setCampaigns(array $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @param string $producer
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $this->convertToDate($createdAt);;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

}