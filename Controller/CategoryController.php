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
 * First generated : 05/29/2016 at 12:21
 */

namespace Dada\CMSBundle\Controller;


use Dada\CMSBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller{

    /**
     * @Security("has_role('ROLE_ADMIN')")
     *
     * Controller used to create a new Category
     * @param Request $request Form submit
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request){
        $category = new Category();
        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Category added');
            return $this->redirectToRoute('dada_cms_homepage');
        }

        return $this->render('DadaCMSBundle::createCategory.html.twig', array('form' => $form->createView()));
    }
}