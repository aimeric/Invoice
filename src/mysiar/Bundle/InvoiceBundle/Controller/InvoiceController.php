<?php

namespace mysiar\Bundle\InvoiceBundle\Controller;

use mysiar\Bundle\InvoiceBundle\Entity\Invoice;
use mysiar\Bundle\InvoiceBundle\Entity\InvoiceElements;
use mysiar\Bundle\InvoiceBundle\Form\InvoiceElementsType;
use mysiar\Bundle\InvoiceBundle\Form\InvoiceNewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Invoice controller.
 * @Security("has_role('ROLE_USER')")
 * @Route("/invoice")
 */
class InvoiceController extends Controller
{
    /**
     * Lists all Invoice entities.
     *
     * @Route("/", name="invoice_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $invoices = $this->getInvoiceRepository()->getAllInvoiceForUser($user);

        return $this->render(
            'invoice/index.html.twig',
            array(
                'invoices' => $invoices,
                'user' => $this->getUser()
            )
        );
    }

    /**
     * Creates a new Invoice entity.
     *
     * @Route("/new", name="invoice_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $invoice = new Invoice();
        $invoice->setInvoiceUser($this->getUser()); // invoice owner !!!

        // initial invoice set
        $invoice->setNewInvoice();

        // setting new Invoice number based on numbers of already issued Invoices
        $invoice->setInvoiceNumber($this->getInvoiceRepository()->generateInvoiceNumber($this->getUser()));

        $form = $this->createForm('mysiar\Bundle\InvoiceBundle\Form\InvoiceType', $invoice);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // update invoice with Client information and store it
            $invoice->updateInvoiceWithClient();

            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('invoice_show', array('id' => $invoice->getId()));
        }

        return $this->render(
            'invoice/new.html.twig',
            array(
                'invoice' => $invoice,
                'form' => $form->createView(),
                'user' => $this->getUser()
            )
        );
    }

    /**
     * Finds and displays a Invoice entity.
     *
     * @Route("/{id}", name="invoice_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $invoice = $this->getInvoiceRepository()->getInvoiceById($id, $this);
        if ($invoice) {
            if ($this->getInvoiceRepository()->invoiceOwner($invoice, $this->getUser())) {
                return $this->render(
                    'invoice/invoice1.tmpl.twig',
                    array(
                        'invoice' => $invoice,
                        'user' => $this->getUser(),
                    )
                );
            }
        }

        return $this->redirectToRoute('invoice_index');
    }

    /**
     * Displays a form to edit an existing Invoice entity.
     *
     * @Route("/{id}/edit", name="invoice_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $invoice = $this->getInvoiceRepository()->getInvoiceById($id, $this);
        if ($invoice) {
            if ($this->getInvoiceRepository()->invoiceOwner($invoice, $this->getUser())) {
                $preEditInvoiceClient = $invoice->getClient();
                $deleteForm = $this->createDeleteForm($invoice);
                $editForm = $this->createForm('mysiar\Bundle\InvoiceBundle\Form\InvoiceEditType', $invoice);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();

                    // if client has been changed in Select of InvoiceEditType - rewrite all client data
                    if ($preEditInvoiceClient != $invoice->getClient()) {
                        $invoice->updateInvoiceWithClient();
                    }
                    $em->persist($invoice);
                    $em->flush();

                    return $this->redirectToRoute('invoice_edit', array('id' => $invoice->getId()));
                }

                return $this->render(
                    'invoice/edit.html.twig',
                    array(
                        'invoice' => $invoice,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
                        'user' => $this->getUser()
                    )
                );
            }
        }

        return $this->redirectToRoute('invoice_index');
    }

    /**
     * Deletes a Invoice entity.
     *
     * @Route("/{id}", name="invoice_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $invoice = $this->getInvoiceRepository()->getInvoiceById($id);
        if ($invoice) {
            if ($this->getInvoiceRepository()->invoiceOwner($invoice, $this->getUser())) {
                $form = $this->createDeleteForm($invoice);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($invoice);
                    $em->flush();
                }
            }
        }

        return $this->redirectToRoute('invoice_index');
    }

    /**
     * Displays final invoice.
     *
     * @Route("/{id}/view", name="invoice_view")
     * @Method({"GET", "POST"})
     */
    public function viewInvoiceAction($id)
    {
        $invoice = $this->getInvoiceRepository()->getInvoiceById($id);

        return $this->render(
            'invoice/invoice1.tmpl.twig',
            array(
                'invoice' => $invoice,
                'user' => $this->getUser(),

            )
        );
    }


    /**
     *  Invoice elements
     *
     * @Route("/{id}/elem", name="invoice_elem")
     * @Method({"GET", "POST"})
     */
    public function elemInvoiceAction(Request $request, $id)
    {
        $user = $this->getUser();
        $invoice = $this->getInvoiceRepository()->getInvoiceById($id);
        if ($invoice) {
            if ($this->getInvoiceRepository()->invoiceOwner($invoice, $this->getUser())) {
                // $products = $this->getProductRepository()->getAllProductsForUser($user);

                $ie = new InvoiceElements();
                $ie->setInvoice($invoice);
                $ie->setAllElements($invoice->getInvoiceElements());

                // kept just for error reporting
                // $form = $this->createForm('mysiar\Bundle\InvoiceBundle\Entity\InvoiceElements', $ie);

                $form = $this->createForm(new InvoiceElementsType(), $ie);



                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();

                    $ie = $form->getData();
                    $invoice->updateInvoiceElements($ie->getElements());
                    //dump($ie);
                    $em->persist($invoice);
                    $em->flush();
                }


                return $this->render(
                    'invoice/invoice_elem.html.twig',
                    array(
                        'invoice' => $invoice,
                        'user' => $this->getUser(),
                        'form' => $form->createView()
                    )
                );



            }
        }
        return new Response("invoice elements");
    }






    /**
     * Creates a form to delete a Invoice entity.
     *
     * @param Invoice $invoice The Invoice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Invoice $invoice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('invoice_delete', array('id' => $invoice->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Gets InvoiceBundle:Invoice repository
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getInvoiceRepository()
    {
        return $this->getDoctrine()->getRepository('InvoiceBundle:Invoice');
    }

    /**
     * Gets InvoiceBundle:Client repository
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getClientRepository()
    {
        return $this->getDoctrine()->getRepository('InvoiceBundle:Client');
    }

    /**
     * Gets InvoiceBundle:InvoiceElement repository
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getInvoiceElementRepository()
    {
        return $this->getDoctrine()->getRepository('InvoiceBundle:InvoiceElement');
    }

    /**
     * Gets InvoiceBundle:Product repository
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getProductRepository()
    {
        return $this->getDoctrine()->getRepository('InvoiceBundle:Product');
    }

}
