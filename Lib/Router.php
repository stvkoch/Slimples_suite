<?php
namespace Lib;
/**
 * \Lib\Router
 *
 * @category Lib
 * @package  Lib
 * @author   Expect Name <here@sasd.com>
 * @license  MIT license
 * @link     snippet
 */

class Router extends \Lib\Config
{

    protected $path;
    protected $app;


    /**
     * 
     */
    protected function findResourceBetweenMidds(&$resources) {
        foreach ($resources as $key => &$value) {
            if(strpos($value, 'resource:')===0){
                $value = str_replace('resource:', '', $value);
                return $key;
            }
        }
        return false;
    }


    /**
     * 
     */
    protected function addMethodToResource($resources, $resource, $index) {
        $newResources = (array)$resources;
        $newResources[$index] = $newResources[$index].'->'.$resource;
        return $newResources;
    }


    /**
     * foreach resource create a \Lib\Invoker
     */
    protected function mapInvokers( $resources ) {
        return array_map(function($item){
            return is_array($item) ? $item : (
                ($item instanceof \Lib\Invoker) ? $item : new \Lib\Invoker( $item )
            );
        }, $resources );
    }


    public function configApp($file)
    {
        $app = $this->app;
        $folder = $this->path.'/'.$this->app->getMode();

        if(file_exists($folder.'/'.$file)){
            require $this->path.'/'.$file;
        }
        if(file_exists($this->path.'/'.$file)){
            require $this->path.'/'.$file;
        }
        return $this;
    }


    public function routesApp($file)
    {
        $routes = $this->getArray($file);
        // $routes = include $config;
        foreach ($routes as $rawRoute => $resources) {

            list($method, $route) = explode(':', $rawRoute, 2);
            if ( $method == 'resource' ) {

                //find where are resource
                $indexResource = $this->findResourceBetweenMidds($resources);
                if($indexResource===false) throw new Exception("Unrecognize resource");

                $args = $this->mapInvokers( $this->addMethodToResource( $resources, 'listAction' , $indexResource) );
                array_unshift( $args, "${route}");
                call_user_func_array( array($this->app, 'get'), $args );

                $args = $this->mapInvokers( $this->addMethodToResource( $resources, 'createAction' , $indexResource) );
                array_unshift( $args, "${route}");
                call_user_func_array( array($this->app, 'post'), $args );

                $args = $this->mapInvokers( $this->addMethodToResource( $resources, 'showAction' , $indexResource) );
                array_unshift( $args, "${route}/:id");
                call_user_func_array( array($this->app, 'get'), $args );


                $args = $this->mapInvokers( $this->addMethodToResource( $resources, 'updateAction' , $indexResource) );
                array_unshift( $args, "${route}/:id" );
                call_user_func_array( array($this->app, 'put'), $args );
                call_user_func_array( array($this->app, 'patch'), $args );

                $args = $this->mapInvokers( $this->addMethodToResource( $resources, 'deleteAction' , $indexResource) );
                array_unshift( $args, "${route}/:id");
                call_user_func_array( array($this->app, 'delete'), $args );


            } else {

                $args = $this->mapInvokers($resources);
                array_unshift( $args, $route);

                call_user_func_array( array($this->app, $method), $args );
            }
        }

        return $this;
    }
}