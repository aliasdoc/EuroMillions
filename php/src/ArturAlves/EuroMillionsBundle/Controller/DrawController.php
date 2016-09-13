<?php

namespace ArturAlves\EuroMillionsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ArturAlves\EuroMillionsBundle\Entity\Draw;
use ArturAlves\EuroMillionsBundle\Form\DrawType;

/**
 * Draw controller.
 *
 */
class DrawController extends Controller
{

    /**
     * Lists all Draw entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $draws = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw')->findAll();

        return $this->render('ArturAlvesEuroMillionsBundle:Draw:index.html.twig', array(
            'draws' => $draws,
        ));
    }

    /**
     * Creates a new Draw entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Draw();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aa_draw_show', array('id' => $entity->getId())));
        }

        return $this->render('ArturAlvesEuroMillionsBundle:Draw:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Draw entity.
    *
    * @param Draw $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Draw $entity)
    {
        $form = $this->createForm(new DrawType(), $entity, array(
            'action' => $this->generateUrl('aa_draw_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Draw entity.
     *
     */
    public function newAction()
    {
        $entity = new Draw();
        $form   = $this->createCreateForm($entity);

        return $this->render('ArturAlvesEuroMillionsBundle:Draw:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Draw entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Draw entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ArturAlvesEuroMillionsBundle:Draw:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Draw entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Draw entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ArturAlvesEuroMillionsBundle:Draw:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Draw entity.
    *
    * @param Draw $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Draw $entity)
    {
        $form = $this->createForm(new DrawType(), $entity, array(
            'action' => $this->generateUrl('aa_draw_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Draw entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Draw entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aa_draw_edit', array('id' => $id)));
        }

        return $this->render('ArturAlvesEuroMillionsBundle:Draw:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Draw entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Draw entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aa_draw'));
    }

    /**
     * Creates a form to delete a Draw entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aa_draw_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
