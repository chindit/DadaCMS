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
 * First generated : 05/25/2016 at 16:25
 */

namespace Dada\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FrontController extends Controller{

    /**
     * 
     * Front controller… doesn't do a lot.  Just showing a bunch of links and last generated pages
     *
     * @param $page (int)Page number (to view older pages)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page){
        $em = $this->getDoctrine()->getManager()->getRepository('DadaCMSBundle:Page');
        $pagesList = $em->getPageItems($page, $this->getParameter('dadacms.items_page'));
        $totalPages = $em->getNbPages($this->getParameter('dadacms.items_page'));
        return $this->render('DadaCMSBundle::front.html.twig', array('pages' => $pagesList, 'pathName' => 'dada_cms_homepage', 'pagination' => array('current' => $page, 'total' => $totalPages)));
    }

    /**
     * Default controller to render a page
     *
     * @param $category
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($category, $slug){ //$category is useless
        $page = $this->getPageBySlug($slug);
        //Checking authorizations
        if($page->getAccess() != 'all'){
            //If «all» we don't have to check access
            if(is_null($this->getUser()) || !in_array($page->getAccess(), $this->getUser()->getRoles()))
                throw new AccessDeniedException('Oh no!  You don\t have enough privileges to view this page! :(');
        }
        return $this->render('DadaCMSBundle::viewPage.html.twig', array('page' => $page, 'dadacms_history' => $this->getParameter('dadacms.history')));
    }


    /**
     * ACCESS CONTROLLER
     * Use this function to get a page easily
     *
     * @param $slug
     * @return mixed
     */
    public function getPageBySlug($slug){
        $em = $this->getDoctrine()->getManager()->getRepository('DadaCMSBundle:Page');
        $page = $em->findOneBySlug($slug);
        if(is_null($page))
            throw new NotFoundHttpException('Oh no!  The page you\'re looking for doesn\'t exists :(');
        return $page;
    }

    /**
     * ACCESS CONTROLLER
     * Use this function to get a page easily
     *
     * @param $id
     * @return object
     */
    public function getPageById($id){
        $em = $this->getDoctrine()->getManager()->getRepository('DadaCMSBundle:Page');
        $page = $em->find($id);
        if(is_null($page))
            throw new NotFoundHttpException('Oh no!  The page you\'re looking for doesn\'t exists :(');
        return $page;
    }

}
