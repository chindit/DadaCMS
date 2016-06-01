<?php
/**
 * DadaCMS : Copyright © 2016 Chindit
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * First generated : 05/26/2016 at 11:52
 */

namespace Dada\CMSBundle\Controller;


use Dada\CMSBundle\Entity\Page;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EditorController extends Controller{

    /**
     * @Security("has_role('ROLE_ADMIN')")
     *
     * Controller user to create/edit a page
     * @param Request $request Page submission
     * @param null $page This var contains Page object if it exists (editing)
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $page = null){
        $em =  $this->getDoctrine()->getManager();
        
        $nbCat = $em->getRepository('DadaCMSBundle:Category')->getNbCat();
        if($nbCat == 0){
			$this->get('session')->getFlashBag()->add('danger', 'No category found.  Please create one first');
			return $this->redirectToRoute('dada_cms_homepage'); //Return to homepage if no categ
        }

        //Checking if we're editing or not
        if(is_null($page))
            $page = new Page(); //If not, we create a new page
        else{
            //If yes, we select the page
            $repo = $em->getRepository('DadaCMSBundle:Page');
            $page = $repo->find($page);
            if(is_null($page)){
                //Page is NOT valid
                throw new NotFoundHttpException('Oh no!  The page you\'re looking for doesn\'t exists :(');
            }
        }

        $form = $this->createFormBuilder($page)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class, array('required' => false))
            ->add('category', EntityType::class, array(
                'class' => 'DadaCMSBundle:Category',
                'choice_label' => 'name',
                //'multiple' => true //Disabled because of routing :( (sad, eh?)
            ))
            ->add('access', ChoiceType::class, array(
                'choices' => array(
                    'Everybody' => 'all',
                    'Registered users' => 'ROLE_USER',
                    'Admin only' => 'ROLE_ADMIN'
                ),
                'preferred_choices' => array($this->getParameter('dadacms.default_role'))
            ))
            ->add('save', SubmitType::class)
            ->getForm();

        //Handling request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($page);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Page added!');
            return $this->redirectToRoute('dada_cms_homepage'); //Return to homepage after successfull submission
        }


        return $this->render('DadaCMSBundle::editor.html.twig', ['form' => $form->createView()]);
    }

}
