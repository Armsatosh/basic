<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/5/2018
 * Time: 3:40 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class WidgetController extends Controller
{
    /**
     * @Route("/{_locale}/widget", name="widget_page", requirements={
     *         "_locale": "hy|en"})
     */
    public function listAction($_locale = null){

        $pagesRepository = $this->getDoctrine()->getRepository('AppBundle:Page');
        $page = $pagesRepository->find(15);

        $manager = $this->getDoctrine()->getManager();
        $repositoryBanks = $manager->getRepository('AppBundle:Bank');
        $rates = $repositoryBanks->getLatestRates();
        $connection = $manager->getConnection();

        $statementArq = $connection->prepare("
                SELECT b.bank_logo, b.bank_link,b.`bank_title`,bt.`content` AS bank_trans, TT.* FROM 
                
                (SELECT 
                
                  (SELECT 
                    rr.bank_id 
                  FROM
                    rates_current rr 
                  WHERE rr.rate_buy = T.rate_buy ORDER BY RAND()
                  LIMIT 1) AS bank_id, T.rate_buy, c.currency_symbol
                  
                  FROM
                      (SELECT 
                        MAX(r.rate_buy) AS rate_buy,
                        r.currency_id 
                      FROM
                        rates_current r
                      WHERE r.currency_id IN (1, 10, 51, 57) GROUP BY r.currency_id) T,
                  currencies c  
                  WHERE c.currency_id = T.currency_id
                  )
                  TT, banks b
                  JOIN `bank_translations` bt ON b.`bank_id` = bt.`object_id`
                  
                
                
                  WHERE 
                    bt.`field` = \"bankTitle\"
                  AND   bt.`locale`= \"en\"
                  AND b.bank_id = TT.bank_id 
        ");
        $statementArq->execute();

        $statementVacharq = $connection->prepare("
                  SELECT b.bank_logo, b.bank_link,b.`bank_title`,bt.`content` AS bank_trans,  TT.* FROM (SELECT 
                  (SELECT 
                    rr.bank_id 
                  FROM
                    rates_current rr 
                  WHERE rr.rate_sell = T.rate_sell ORDER BY RAND()
                  LIMIT 1) AS bank_id, T.rate_sell, c.currency_symbol
                FROM
                  (SELECT 
                    MAX(r.rate_sell) AS rate_sell,
                    r.currency_id 
                  FROM
                    rates_current r 
                  WHERE r.currency_id IN (1, 10, 51, 57) GROUP BY r.currency_id) T, currencies c
                  WHERE c.currency_id = T.currency_id) TT, banks b
                  
                  JOIN `bank_translations` bt ON b.`bank_id` = bt.`object_id`
                  
                  WHERE 
                    bt.`field` = \"bankTitle\"
                  AND   bt.`locale`= \"en\"
                  AND b.bank_id = TT.bank_id 
        ");
        $statementVacharq->execute();

        $sellMax = $connection->prepare("
                SELECT 
                    MAX(r.rate_sell) AS rate_sell,
                    
                    r.`rate_update_date` AS r_update_date
                  FROM
                    rates_current r 
                  WHERE r.currency_id IN (1, 10, 51, 57) GROUP BY (r_update_date)") ;




        $sellMax->execute();

        $buyMax = $connection->prepare("
                  SELECT 
                    MAX(r.rate_buy) AS rate_buy,
                    
                    r.`rate_update_date` AS r_update_date
                  FROM
                    rates_current r 
                  WHERE r.currency_id IN (1, 10, 51, 57) GROUP BY (r_update_date)");
        $buyMax->execute();

        $arq         = $statementArq     ->fetchAll();
        $vacharq     = $statementVacharq ->fetchAll();
        $sellMaxDate = $sellMax->fetchAll();
        $buyMaxDate  = $buyMax->fetchAll();


        return $this->render('widget/list.html.twig', array(
            'page' => $page,
            'arqs' => $arq,
            'sellMaxDate' => $sellMaxDate[0],
            'buyMaxDate' => $buyMaxDate[0],
            'vacharqs' => $vacharq
        ));
    }

    /**
     * @Route("/{_locale}/bankinfo-widget/{background_color}/{size_height}/{size_width}", name="widget_viewv", requirements={
     *         "_locale": "hy|en"}
     *     )
     */
    public function viewAction($langCust ,$background_color,$size_height,$size_width){

        $manager = $this->getDoctrine()->getManager();
        $connection = $manager->getConnection();

        $statementArq = $connection->prepare("
                SELECT b.bank_logo, b.bank_link,b.`bank_title`,bt.`content` AS bank_trans, TT.* FROM 
                
                (SELECT 
                
                  (SELECT 
                    rr.bank_id 
                  FROM
                    rates_current rr 
                  WHERE rr.rate_buy = T.rate_buy ORDER BY RAND()
                  LIMIT 1) AS bank_id, T.rate_buy, c.currency_symbol
                  
                  FROM
                      (SELECT 
                        MAX(r.rate_buy) AS rate_buy,
                        r.currency_id 
                      FROM
                        rates_current r
                      WHERE r.currency_id IN (1, 10, 51, 57) GROUP BY r.currency_id) T,
                  currencies c  
                  WHERE c.currency_id = T.currency_id
                  )
                  TT, banks b
                  JOIN `bank_translations` bt ON b.`bank_id` = bt.`object_id`
                  
                
                
                  WHERE 
                    bt.`field` = \"bankTitle\"
                  AND   bt.`locale`= \"en\"
                  AND b.bank_id = TT.bank_id 
        ");
        $statementArq->execute();

        $statementVacharq = $connection->prepare("
                  SELECT b.bank_logo, b.bank_link,b.`bank_title`,bt.`content` AS bank_trans,  TT.* FROM (SELECT 
                  (SELECT 
                    rr.bank_id 
                  FROM
                    rates_current rr 
                  WHERE rr.rate_sell = T.rate_sell ORDER BY RAND()
                  LIMIT 1) AS bank_id, T.rate_sell, c.currency_symbol
                FROM
                  (SELECT 
                    MAX(r.rate_sell) AS rate_sell,
                    r.currency_id 
                  FROM
                    rates_current r 
                  WHERE r.currency_id IN (1, 10, 51, 57) GROUP BY r.currency_id) T, currencies c
                  WHERE c.currency_id = T.currency_id) TT, banks b
                  
                  JOIN `bank_translations` bt ON b.`bank_id` = bt.`object_id`
                  
                  WHERE 
                    bt.`field` = \"bankTitle\"
                  AND   bt.`locale`= \"en\"
                  AND b.bank_id = TT.bank_id 
        ");
        $statementVacharq->execute();

        $sellMax = $connection->prepare("
                SELECT 
                    MAX(r.rate_sell) AS rate_sell,
                    
                    r.`rate_update_date` AS r_update_date
                  FROM
                    rates_current r 
                  WHERE r.currency_id IN (1, 10, 51, 57)");
        $sellMax->execute();

        $buyMax = $connection->prepare("
                  SELECT 
                    MAX(r.rate_buy) AS rate_buy,
                    
                    r.`rate_update_date` AS r_update_date
                  FROM
                    rates_current r 
                  WHERE r.currency_id IN (1, 10, 51, 57)");
        $buyMax->execute();

        $arq         = $statementArq     ->fetchAll();
        $vacharq     = $statementVacharq ->fetchAll();
        $sellMaxDate = $sellMax->fetchAll();
        $buyMaxDate  = $buyMax->fetchAll();

        return $this->render('widget/view.html.twig', array(
            'color_background'  => $background_color,
            'size_height'       => $size_height,
            'size_width'        => $size_width,

            'arqs' => $arq,
            'vacharqs' => $vacharq,

            'sellMaxDate' => $sellMaxDate[0],
            'buyMaxDate' => $buyMaxDate[0],
        ));

    }
    
    public function getWidgetAction()
    {
        return $this->render('widget/get_widget.html.twig');
    }


}