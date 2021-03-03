<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{
    public function __construct()
    {

    }
    /**
     * @Route("/home", name="home")
     */
//    public function __construct(GiftsService $gifts)
//    {
//        $gifts->gifts=['a', 'b', 'c', 'd'];
//    }

    public function index(GiftsService $gifts, Request $request, SessionInterface $session): Response
    {
//        return $this->json(['username'=>'tmt']);
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
//        exit($request->cookies->get('PHPSESSID'));
//        $session->set('name', 'session value');
//        $session->remove('name');
//        $session->clear();
//        if($session->has('name'))
//        {
//            exit($session->get('name'));
//        }
//        $cookie = new Cookie(
//            'my_cookie', //cookie name
//            'cookie value',
//            time() + (2*365*24*60*60)
//        );
//        $res = new Response();
//        $res->headers->setCookie($cookie);
//        $res->send();

//        $res->headers->clearCookie('my_cookie');
//        $res->send();

//        exit($request->query->get('page','default'));

//        exit($request->server->get('HTTP_HOST'));
//        $request->isXmlHttpRequest(); //is it an Ajax request?
//        $request->request->get('page');
//        $request->files->get('foo');

//        if($users)
//        {
//            throw $this->createNotFoundException('The users do not exits');
//        }


        $this->addFlash(
            'notice',
            'your changes were save'
        );
        return $this->render('default/index.html.twig',[
            'controller_name' => 'DefaultController',
            'users'=>$users,
            'gifts'=>$gifts->gifts,
        ]);
    }
    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     */
    public function index2(): Response
    {
        return new Response("Optional parameters in url and requirements for parameters");
    }
    /**
     * @Route (
     *     "/articles/{_locale}/{year}/{slug}/{category}",
     *     defaults={"category": "computers"},
     *     requirements={
     *          "_locale": "en|fr",
     *          "category": "computes|rtv",
     *          "year": "\d+"
     *     }
     * )
     */
    public function index3()
    {
        return new Response('An advanced route example');
    }

    /**
     * @Route({
     *    "nl": "/over-ons",
     *     "en": "/about-us"
     * }, name="about_us")
     *
     */
    public function index4()
    {
        return new Response('Translate routes');
    }

    /**
     * @Route ("/generate-url/{param?}", name="generate_url")
     *
     */
    public function generate_Url()
    {
        exit($this->generateUrl(
            'generate_url',
            array('param'=>10),
            UrlGeneratorInterface::ABSOLUTE_URL
        ));
    }
    /**
     * @Route ("/download")
     */
    public function download()
    {
        $path = $this->getParameter('download_directory');
        return $this->file($path.'TranManhTuanCV.pdf');
    }

    /**
     * @Route("/redirect_test")
     */
    public function redirectTest()
    {
        return $this->redirectToRoute('route_to_redirect', array('param'=>10));
    }
    /**
     * @Route("/route_to_redirect/{param?}", name="route_to_redirect")
     */
    public function methodToRedirect()
    {
        exit('Test redirection');
    }
    /**
     * @Route("/forwarding-to-controller")
     */
    public function forwardingToController()
    {
        $response = $this->forward(
          'App\Controller\DefaultController::methodToForwardTo',
            array('param'=> '1')
        );
        return $response;
    }
    /**
     * @Route("/url_to_foward_to/{param?}", name="route_to_forward_to")
     */
    public function methodToForwardTo($param)
    {
        exit('Test controller forwarding - '.$param);
    }

    public function mostPopularPosts($number = 3)
    {
        //database call:
        $posts = ['post1', 'post2', 'post3', 'post4'];
        return $this->render('default/most_popular_posts.html.twig',[
            'posts'=>$posts
        ]);
    }
}
