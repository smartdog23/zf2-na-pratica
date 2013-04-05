<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;

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
}