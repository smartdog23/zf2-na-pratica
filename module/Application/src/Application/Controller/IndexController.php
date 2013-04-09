<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

/**
 * Controlador que gerencia os posts
 * 
 * @category Application
 * @package Controller
 * @author  Elton Minetto <eminetto@coderockr.com>
 */
class IndexController extends ActionController
{
//     /**
//      * Mostra os posts cadastrados
//      * @return void
//      */
//     public function indexAction()
//     {
//         return new ViewModel(array(
//             'posts' => $this->getTable('Application\Model\Post')
//         					->fetchAll()
//         					->toArray()
//         ));
//     }
    
    /**
     * Mostra os posts cadastrados
     * @return void
     */
    public function indexAction()
    {
    	$post = $this->getTable('Application\Model\Post');
    	$sql = $post->getSql();
    	$select = $sql->select();
    
    	$paginatorAdapter = new PaginatorDbSelectAdapter($select, $sql);
    	$paginator = new Paginator($paginatorAdapter);
    	$paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
    	$paginator->setItemCountPerPage(10);
    
    	return new ViewModel(array(
    			'posts' => $paginator
    	));
    }
    
//     /**
//      * Retorna os comentários de um post
//      * @return Zend\Http\Response
//      */
//     public function commentsAction()
//     {
//         $id = (int) $this->params()->fromRoute('id', 0);
//         if ($id == 0) {
//             throw new \Exception("Código obrigatório");
//         }
//         $format = $this->params()->fromRoute('format', 'json');

//         $where = array('post_id' => $id);
//         $comments = $this->getTable('Application\Model\Comment')
//                          ->fetchAll(null, $where)
//                          ->toArray();

//         $serializer = new Serializer(
//             array(new GetSetMethodNormalizer()), 
//             array(
//                 'xml' => new XmlEncoder(),
//                 'json' => new JsonEncoder()
//             )
//         );
//         if ($format == 'json') {
//             $content = $serializer->serialize($comments, 'json');
//         }
//         if ($format == 'xml') {
//             $content = $serializer->serialize($comments, 'xml');
//         }

//         $response = $this->getResponse();
//         $response->setStatusCode(200);
//         $response->setContent($content);
//         $response->getHeaders()->addHeaderLine('Content-Type', 'application/' . $format);
//         return $response;
//     }

    /**
     * Retorna os comentários de um post
     * @return Zend\Http\Response
     */
    public function commentsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $where = array('post_id' => $id);
        $comments = $this->getTable('Application\Model\Comment')
                        ->fetchAll(null, $where)
                        ->toArray();
        $result = new ViewModel(array(
                'comments' => $comments
            )
        );
        $result->setTerminal(true);
        return $result;
    }
}