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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditorController extends Controller{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request, $page = null){
        $em =  $this->getDoctrine()->getManager();
        if(is_null($page))
            $page = new Page();
        else{
            $repo = $em->getRepository('DadaCMSBundle:Page');
            $page = $repo->find($page);
            if(is_null($page)){
                //Page is NON valid
                throw new NotFoundHttpException('Oh no!  The page you\'re looking for doesn\'t exists :(');
            }
        }

        $form = $this->createFormBuilder($page)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class, array('required' => false))
            ->add('save', SubmitType::class)
            ->getForm();

        //Handling request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($page);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Page added!');
            return $this->redirectToRoute('dada_cms_homepage');
        }


        return $this->render('DadaCMSBundle::editor.html.twig', ['form' => $form->createView()]);
    }

}