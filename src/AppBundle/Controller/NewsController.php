<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends Controller
{

    /**
     * @Route("/{_locale}/news/{paginate}", name="news_list", requirements={
     *         "_locale": "hy|en"})
     */
    public function listAction(int $paginate = 1, $_locale = null){

        if($paginate < 0) $paginate = 1;

        $postsPerPage = 10;
        $paginationTotal = 1;
        $dateNow = new \DateTime();
        $manager = $this->getDoctrine()->getManager();

        $pagesRepository = $this->getDoctrine()->getRepository('AppBundle:Page');
        $newsRepository = $this->getDoctrine()->getRepository('AppBundle:News');

        $page = $pagesRepository->findOneBy(array('pageSlug' => 'news'));

        $offset = $paginate - 1;
        if($paginate !== 1){ $offset = $postsPerPage * $paginate - $postsPerPage; }

        $newsTotalCountQuery = $newsRepository->createQueryBuilder('n')
            ->select('count(n)')
            ->where('n.newsDate < :now')
            ->orderBy('n.newsDate', 'DESC')
            ->setParameter('now', $dateNow)
            ->getQuery()
        ;
        $newsTotalCount = $newsTotalCountQuery->getSingleScalarResult();

        $paginationTotal = ceil($newsTotalCount / $postsPerPage);

        $newsQuery = $newsRepository->createQueryBuilder('n')
            ->where('n.newsDate < :now')
            ->orderBy('n.newsDate', 'DESC')
            ->setParameter('now', $dateNow)
            ->setFirstResult($offset)
            ->setMaxResults($postsPerPage)
            ->getQuery()
        ;
        $news = $newsQuery->getResult();
//        $news = $newsQuery->;

        $page->setLocale($_locale);
        $manager->refresh($page);

        foreach($news as $new){
            $new->setLocale($_locale);
            $manager->refresh($new);
        }



        return $this->render('news/list.html.twig', array(
            'page' => $page,
            'news' => $news,
            'paginate' => $paginate,
            'paginationTotal' => $paginationTotal
        ));

    }


    /**
     * @Route("/{_locale}/news-view/{newsSlug}", name="news_view", requirements={
     *         "_locale": "hy|en"})
     */
    public function viewAction(Request $request, $_locale = null, News $news){

//        dump($_locale); exit();
        $manager = $this->getDoctrine()->getManager();
        if(!$news){ return new NotFoundHttpException(); }

        $translator = $this->get('translator');
//
//        $comment = new Comment();
//
//        $comments = $news->getComments()->filter(function (Comment $comment){
//            return $comment->getCommentIsActive() == true;
//        });
//
//        $form = $this->createFormBuilder($comment)
//                ->add('commentName', TextType::class)
//                ->add('commentWebsite', TextType::class, array(
//                    'required' => false
//                ))
//                ->add('commentEmail', EmailType::class)
//                ->add('commentMessage', TextareaType::class)
//                ->add('send', SubmitType::class, array(
//                    'label' => 'Send'
//                ))
//                ->getForm()
//            ;
//
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()){
//
//            $formData = $form->getData();
//
//            $comment = $formData;
//            $comment->setCommentIsActive(false);
//            $comment->setNews($news);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($comment);
//            $em->flush();
//
//            $this->addFlash(
//                'success',
//                $translator->trans('Thank you for your feedback.')
//            );
//
//            return $this->redirectToRoute('news_view', array(
//                'newsSlug' => $news->getNewsSlug()
//            ));
//
//        }
        $news->setLocale($_locale);
        $manager->refresh($news);
        return $this->render('news/view.html.twig', array(
            'news' => $news,
//            'comments' => $comments,
//            'form' => $form->createView()
        ));

    }

}