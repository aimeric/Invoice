<?php

namespace mysiar\Bundle\InvoiceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * InvoiceElementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InvoiceElementRepository extends EntityRepository
{
    public function getAllElementsForInvoice($invoice)
    {
        return $this->_em->getRepository($this->_entityName)
            ->findBy(
                array( 'invoice' => $invoice),
                array( 'id' => 'ASC')
            );
    }

}
