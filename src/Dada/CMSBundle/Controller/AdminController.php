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
 * First generated : 05/26/2016 at 22:59
 */

namespace Dada\CMSBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Dada\CMSBundle\Entity\Page;

class AdminController extends Controller{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Page $page, Request $request){
        //We show an alert to the admin
        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('delete', CheckboxType::class, array('label' => "Yes, I swear, I want to delete this page!", 'required' => false))
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if($form->getData()['delete']){
                $em = $this->getDoctrine()->getManager();
                $em->remove($page);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Page was successfully deleted');
                return $this->redirectToRoute('dada_cms_homepage');
            }
        }
        return $this->render('DadaCMSBundle::delete.html.twig', array('page' => $page, 'form' => $form->createView()));
    }

}