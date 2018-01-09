<?php

namespace Guj\DataPush\Model;

/**
 * Order model
 *
 * @package Guj\DataPush\Model
 */
class Order extends DataPushModel
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $orderId;
    /**
     * @var string
     */
    protected $orderDate;
    /**
     * @var string
     */
    protected $orderValue;
    /**
     * @var string
     */
    protected $lifetimeValue;
    /**
     * @var string
     */
    protected $purchaseDevice;
    /**
     * @var string
     */
    protected $discountName;
    /**
     * @var string
     */
    protected $discountValue;
    /**
     * @var string
     */
    protected $categoryName0;
    /**
     * @var string
     */
    protected $categoryName1;
    /**
     * @var string
     */
    protected $categoryName3;
    /**
     * @var string
     */
    protected $paperFormat;

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @param string $orderDate
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $this->convertToDate($orderDate, false);
    }

    /**
     * @param string $orderValue
     */
    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }

    /**
     * @param string $lifetimeValue
     */
    public function setLifetimeValue($lifetimeValue)
    {
        $this->lifetimeValue = $lifetimeValue;
    }

    /**
     * @param string $purchaseDevice
     */
    public function setPurchaseDevice($purchaseDevice)
    {
        $this->purchaseDevice = $purchaseDevice;
    }

    /**
     * @param string $discountName
     */
    public function setDiscountName($discountName)
    {
        $this->discountName = $discountName;
    }

    /**
     * @param string $discountValue
     */
    public function setDiscountValue($discountValue)
    {
        $this->discountValue = $discountValue;
    }

    /**
     * @param string $categoryName0
     */
    public function setCategoryName0($categoryName0)
    {
        $this->categoryName0 = $categoryName0;
    }

    /**
     * @param string $categoryName1
     */
    public function setCategoryName1($categoryName1)
    {
        $this->categoryName1 = $categoryName1;
    }

    /**
     * @param string $categoryName3
     */
    public function setCategoryName3($categoryName3)
    {
        $this->categoryName3 = $categoryName3;
    }

    /**
     * @param string $paperFormat
     */
    public function setPaperFormat($paperFormat)
    {
        $this->paperFormat = $paperFormat;
    }
}