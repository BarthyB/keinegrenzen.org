<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller {
    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function loginAction() {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            '@App/security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    /**
     * @Route("/checkrole", name="check_role")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function roleAction() {
        $roleArtist = $this->get('security.authorization_checker')->isGranted('ROLE_ART');
        $roleCameraOp = $this->get('security.authorization_checker')->isGranted('ROLE_CAM');

        if ($roleArtist xor $roleCameraOp) {
            return $this->redirectToRoute('planning');
        }

        return $this->redirectToRoute('admin');
    }
}