<?php

namespace mysiar\Bundle\InvoiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateInterval;

/**
 * Invoice
 *
 * @ORM\Table(name="invoices")
 * @ORM\Entity(repositoryClass="mysiar\Bundle\InvoiceBundle\Repository\InvoiceRepository")
 */
class Invoice
{

    /**
     * @ORM\ManyToOne(targetEntity="InvoiceUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $invoiceUser;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceElement", mappedBy="invoice")
     */
    private $invoiceElements;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="invoice_number", type="integer")
     */
    private $invoiceNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice_number_prefix", type="string", length=255, nullable=true)
     */
    private $invoiceNumberPrefix;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_issue", type="date")
     */
    private $dateOfIssue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_sell", type="date")
     */
    private $dateOfSell;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_due", type="date")
     */
    private $paymentDue;

    /**
     * @var string
     *
     * @ORM\Column(name="client_name", type="string", length=255)
     */
    private $clientName;


    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=255)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="vat_id", type="string", length=255)
     */
    private $vatId;

    /**
     * @var string
     *
     * @ORM\Column(name="address_street", type="string", length=255)
     */
    private $addressStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="address_house", type="string", length=255, nullable=true)
     */
    private $addressHouse;

    /**
     * @var string
     *
     * @ORM\Column(name="address_flat", type="string", length=255, nullable=true)
     */
    private $addressFlat;

    /**
     * @var string
     *
     * @ORM\Column(name="address_zip", type="string", length=255)
     */
    private $addressZip;

    /**
     * @var string
     *
     * @ORM\Column(name="address_city", type="string", length=255)
     */
    private $addressCity;

    /**
     * @var string
     *
     * @ORM\Column(name="address_country", type="string", length=255, nullable=true)
     */
    private $addressCountry;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set invoiceNumber
     *
     * @param string $invoiceNumber
     * @return Invoice
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Set dateOfIssue
     *
     * @param \DateTime $dateOfIssue
     * @return Invoice
     */
    public function setDateOfIssue($dateOfIssue)
    {
        $this->dateOfIssue = $dateOfIssue;

        return $this;
    }

    /**
     * Get dateOfIssue
     *
     * @return \DateTime
     */
    public function getDateOfIssue()
    {
        return $this->dateOfIssue;
    }

    /**
     * Set dateOfSell
     *
     * @param \DateTime $dateOfSell
     * @return Invoice
     */
    public function setDateOfSell($dateOfSell)
    {
        $this->dateOfSell = $dateOfSell;

        return $this;
    }

    /**
     * Get dateOfSell
     *
     * @return \DateTime
     */
    public function getDateOfSell()
    {
        return $this->dateOfSell;
    }

    /**
     * Set paymentDue
     *
     * @param \DateTime $paymentDue
     * @return Invoice
     */
    public function setPaymentDue($paymentDue)
    {
        $this->paymentDue = $paymentDue;

        return $this;
    }

    /**
     * Get paymentDue
     *
     * @return \DateTime
     */
    public function getPaymentDue()
    {
        return $this->paymentDue;
    }

    /**
     * @return string
     */
    public function getInvoiceNumberPrefix()
    {
        return $this->invoiceNumberPrefix;
    }

    /**
     * @param string $invoiceNumberPrefix
     * @return Invoice
     */
    public function setInvoiceNumberPrefix($invoiceNumberPrefix)
    {
        $this->invoiceNumberPrefix = $invoiceNumberPrefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     * @return Invoice
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return Invoice
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return string
     */
    public function getVatId()
    {
        return $this->vatId;
    }

    /**
     * @param string $vatId
     * @return Invoice
     */
    public function setVatId($vatId)
    {
        $this->vatId = $vatId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressStreet()
    {
        return $this->addressStreet;
    }

    /**
     * @param string $addressStreet
     * @return Invoice
     */
    public function setAddressStreet($addressStreet)
    {
        $this->addressStreet = $addressStreet;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressHouse()
    {
        return $this->addressHouse;
    }

    /**
     * @param string $addressHouse
     * @return Invoice
     */
    public function setAddressHouse($addressHouse)
    {
        $this->addressHouse = $addressHouse;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressFlat()
    {
        return $this->addressFlat;
    }

    /**
     * @param string $addressFlat
     * @return Invoice
     */
    public function setAddressFlat($addressFlat)
    {
        $this->addressFlat = $addressFlat;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressZip()
    {
        return $this->addressZip;
    }

    /**
     * @param string $addressZip
     * @return Invoice
     */
    public function setAddressZip($addressZip)
    {
        $this->addressZip = $addressZip;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * @param string $addressCity
     * @return Invoice
     */
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * @param string $addressCountry
     * @return Invoice
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Set new Invoice for InvoiceType form
     * requires first invoiceUser to be set
     */
    public function setNewInvoice()
    {
        $this->invoiceNumberPrefix = $this->invoiceUser->getInvoiceNumberPrefix();

        $today = new \DateTime();
        $payment = new \DateTime();
        $payment_time = $this->invoiceUser->getPayment();
        if (!$payment_time)
        {
            $payment_time = 0;
        }
        $payment->add(new DateInterval('P'.$payment_time.'D'));
        $this->dateOfIssue = $today;
        $this->dateOfSell = $today;
        $this->paymentDue = $payment;

    }

    /**
     * Updates Invoice object when new Invoice is created
     * and InvoiceType form is submitted
     */
    public function updateInvoiceWithClient()
    {
        if(isset($this->client))
        {
            $this->clientName = $this->client->getClientName();
            $this->companyName = $this->client->getCompanyName();
            $this->vatId = $this->client->getVatId();
            $this->addressStreet = $this->client->getAddressStreet();
            $this->addressHouse = $this->client->getAddressHouse();
            $this->addressFlat = $this->client->getAddressFlat();
            $this->addressZip = $this->client->getAddressZip();
            $this->addressCity = $this->client->getAddressCity();
            $this->addressCountry = $this->client->getAddressCountry();
        }
    }






    /*
     *
     *  BELOW CODE IS GENERATED by doctrine:generate:entities
     *
     */

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceElements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add invoiceElements
     *
     * @param \mysiar\Bundle\InvoiceBundle\Entity\InvoiceElement $invoiceElements
     * @return Invoice
     */
    public function addInvoiceElement(\mysiar\Bundle\InvoiceBundle\Entity\InvoiceElement $invoiceElements)
    {
        $this->invoiceElements[] = $invoiceElements;

        return $this;
    }

    /**
     * Remove invoiceElements
     *
     * @param \mysiar\Bundle\InvoiceBundle\Entity\InvoiceElement $invoiceElements
     */
    public function removeInvoiceElement(\mysiar\Bundle\InvoiceBundle\Entity\InvoiceElement $invoiceElements)
    {
        $this->invoiceElements->removeElement($invoiceElements);
    }

    /**
     * Get invoiceElements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoiceElements()
    {
        return $this->invoiceElements;
    }

    /**
     * Set invoiceUser
     *
     * @param \mysiar\Bundle\InvoiceBundle\Entity\InvoiceUser $invoiceUser
     *
     * @return Invoice
     */
    public function setInvoiceUser(\mysiar\Bundle\InvoiceBundle\Entity\InvoiceUser $invoiceUser = null)
    {
        $this->invoiceUser = $invoiceUser;

        return $this;
    }

    /**
     * Get invoiceUser
     *
     * @return \mysiar\Bundle\InvoiceBundle\Entity\InvoiceUser
     */
    public function getInvoiceUser()
    {
        return $this->invoiceUser;
    }

    /**
     * Set client
     *
     * @param \mysiar\Bundle\InvoiceBundle\Entity\Client $client
     *
     * @return Invoice
     */
    public function setClient(\mysiar\Bundle\InvoiceBundle\Entity\Client $client = null)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get client
     *
     * @return \mysiar\Bundle\InvoiceBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }


}
