<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_dashboard_show')]
    public function dashboard(): Response
    {
        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            return $this->render('main/default/index.html.twig');
        }

        $user = $this->getUser();
        return $this->render('admin/pages/dashboard.html.twig', [
            'user' => $user
        ]);
    }
}