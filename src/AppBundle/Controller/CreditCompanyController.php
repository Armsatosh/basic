<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Entity\CreditCompany;
use AppBundle\Entity\ArmRegion;
use AppBundle\Entity\ArmAdministrative;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreditCompanyController extends Controller
{
    /**
     * @Route("/{_locale}/credit-companies", name="credit_company_list", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function listAction(Request $request)
    {
        
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $repositoryCreditCompanies = $manager->getRepository('AppBundle:CreditCompany');
        $cerditCompanies = $repositoryCreditCompanies->findAll();
        
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneByPageSlug('credit-companies');
        
        foreach($cerditCompanies as $cerditCompany){
            $cerditCompany->setLocale($locale);
            $manager->refresh($cerditCompany);
        }
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        // replace this example code with whatever you need
        return $this->render('credit-company/list.html.twig', array(
            'page' => $page,
            'creditCompanies' => $cerditCompanies
        ));
    }
    
}
