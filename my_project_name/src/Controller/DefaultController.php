<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\User;
use App\Services\GiftsService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use App\Entity\Video;

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

    /**
     * @Route("/home2", name="defaultHome")
     */
    public function indexHome(Request $request)
    {
//        $entityMangager = $this->getDoctrine()->getManager();
//        $conn = $entityMangager->getC;
//        $sql = 'select * from user u where u.id > :id';
//        $stmt = $conn->prepare($sql);
//        $stmt->excute(['id'=>3]);
//        dump($stmt->fetchAll());
//        $id = 1;
//        $user = $entityMangager->getRepository(User::class)->find($id);
//        if(!$user){
//            throw $this->createNotFoundException('No user found for id' . $id);
//        }
//        $user->setName('New name');
//        $entityMangager->remove($user);
//        $entityMangager->flush();
//        $user = new User();
//        $user->setName('Robert');
//        $entityMangager->persist($user);
//        $entityMangager->flush();
//
//        dump('a new user was saved in the id of ' . $user->getId());

        $repository = $this->getDoctrine()->getRepository(User::class);
//        $user= $repository->find(1);
//        $user= $repository->findOneBy(['name'=>'Robert', 'id'=>5]);
//        $user= $repository->findBy(['name'=>'Robert'],['id'=>'DESC']);
        $user= $repository->findAll();
        dump($user);

        return $this->render('default/index.html.twig',[
            'controller_name' => "DefaultController2"
        ]);
    }
    /**
     * @Route("/home3/{id}", name="defaultHome3")
     */
    public function indexHome2(Request $request, User $user)
    {
        dump($user);
        return $this->render('default/index.html.twig',[
            'controller_name' => "DefaultController2"
        ]);
    }
    /**
     * @Route("/home4", name="defaultHome4")
     */
    public function indexHome4(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName('Robert');
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->render('default/index.html.twig',[
            'controller_name' => "DefaultController2"
        ]);
    }
    /**
     * @Route("/home5", name="defaultHome5")
     */
    public function indexHome5(Request $request)
    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $user = new User();
//        $user->setName('Anna');
//        for($i=1; $i<=3; $i++)
//        {
//            $video = new Video();
//            $video->setTitle('Video title -'. $i);
//            $user->addVideo($video);
//            $entityManager->persist($video);
//        }
//        $entityManager->persist($user);
//        $entityManager->flush();
//        dump($video->getId());
//        dump($user->getId());
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1);
//        foreach ($user->getVideos() as $video)
//        {
//            dump($video->getTitle());
//        }
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->remove($user);
//        $entityManager->flush();
//        dump($user);
        return $this->render('default/index.html.twig',[
            'controller_name' => "DefaultController2"
        ]);
    }
    /**
     * @Route("/home6", name="defaultHome6")
     */
    public function indexHome6(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName('John');
        $address = new Adress();
        $address->setStreet('Cau Giay');
        $address->setNumber(23);
        $user->setAdress($address);
        $entityManager->persist($user);
        //$entityManager->persist($address); //required, if cascade persist is not set
        $entityManager->flush();
        dump($user->getAdress()->getStreet());

        return $this->render('default/index.html.twig',[
            'controller_name' => "DefaultController2"
        ]);
    }
    /**
     * @Route("/home7", name="defaultHome7")
     */
    public function indexHome7(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
//        for ($i=1; $i<=4; $i++)
//        {
//            $user = new User();
//            $user->setName('Robert -' . $i);
//            $entityManager->persist($user);
//        }
//        $entityManager->flush();
        $user1 = $entityManager->getRepository(User::class)->find(4);
        $user2 = $entityManager->getRepository(User::class)->find(5);
        $user3 = $entityManager->getRepository(User::class)->find(6);
        $user4 = $entityManager->getRepository(User::class)->find(7);

//        $user1->addFollowed($user2);
//        $user1->addFollowed($user3);
//        $user1->addFollowed($user4);
//        $entityManager->flush();
        dump($user1->getFollowed()->count());
        dump($user1->getFollowing()->count());
        dump($user4->getFollowing()->count(1));

        return $this->render('default/index.html.twig',[
            'controller_name' => "DefaultController2"
        ]);
    }
    /**
     * @Route("/home8", name="defaultHome8")
     */
    public function indexHome8(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
//        $user = new User();
//        $user->setName('Robert');
//        for($i=1; $i<=3; $i++)
//        {
//            $video = new Video();
//            $video->setTitle('Video title -' .$i);
//            $user->addVideo($video);
//            $entityManager->persist($video);
//        }
//        $entityManager->persist($user);
//        $entityManager->flush();
        $user=$entityManager->getRepository(User::class)->findWithVideos(1);
        dump($user);

        return $this->render('default/index.html.twig',[
            'controller_name' => "DefaultController2"
        ]);
    }
}
