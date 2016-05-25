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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FrontController extends Controller{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction($pagination){
        $em = $this->getDoctrine()->getManager()->getRepository('Page');
        $itemsList = $em->getPageItems($pagination);
        return $this->render('DadaCMSBundle::front.html.twig');
    }
}