<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Command\RegisterAddCommand;
use AppBundle\Command\RegisterUpdateCommand;
use AppBundle\Form\RegisterType;
use AppBundle\Entity\Register;

class ListController extends Controller
{
     /**
     * @Route("/list", name="list_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $lists = $this->getDoctrine()->getRepository('AppBundle:Register')->findAll();
        return $this->render('register/list_index.html.twig', compact('lists'));
    }

    /**
     * @Route("/list/add", name="list_post_add")
     */
    public function addPostAction(Request $request)
    {
        $name = $request->request->get("register")["name"];
        $surname = $request->request->get("register")["name"];

        $register = new Register($name, $surname);

        $form = $this->createForm('AppBundle\Form\RegisterType', $register);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('command_bus')->handle(
                new RegisterAddCommand($name, $surname)
            );

            return new RedirectResponse($this->generateUrl('list_index'));
        }

       return $this->render('register/register_add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("list/edit/{registerId}", name="list_edit")
     */
    public function editAction(Request $request, $registerId)
    {
		$entityManager = $this->getDoctrine()->getManager();
        $register = $entityManager->getRepository('AppBundle:Register')->find($registerId);
        $editForm = $this->createForm('AppBundle\Form\RegisterType', $register);
        $editForm->handleRequest($request);

		$name = $request->get("register")["name"];
		$surname = $request->get("register")["surname"];

        if ($editForm->isSubmitted() && $editForm->isValid()) {

			$this->get('command_bus')->handle(
				new RegisterUpdateCommand($name, $surname, $register)
			);


			return $this->redirectToRoute('list_index', array(
                'id' => $register->getId()
            ));
        }

        return $this->render('register/register_edit.html.twig', array(
            'register' => $register,
            'edit_form' => $editForm->createView()
        ));

    }

    /**
     * @Route("list/remove/{registerId}", name="list_delete")
     */
    public function deleteAction(Request $request, $registerId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Register');
		$register = $repository->find($registerId);
       	$repository->remove($register);

        return new RedirectResponse($this->generateUrl('list_index'));
    }
}
