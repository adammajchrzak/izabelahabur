<?php

/*
 * indexController
 *
 * @author Adam Majchrzak
 * @jusee.pl
 */

class indexController extends Engine_Controller
{
    public function __construct($engine)
    {
        parent::__construct($engine);

        $this->_cms     = IndexModel::Instance();
        $this->_slider  = SliderModel::Instance();
        $this->_gallery = GalleryModel::Instance();

        $this->_head->addStyleFile('reset.css', 'screen', true, '/css/');
        $this->_head->addStyleFile('bootstrap.min.css', 'screen', true, '/css/');
        $this->_head->addStyleFile('style.css', 'screen', true, '/css/');

        $this->_head->title = $this->_config->meta_data->title;
        $this->_head->keywords = $this->_config->meta_data->keywords;
        $this->_head->description = $this->_config->meta_data->description;
        $this->_head->metascripts = '';
    }

    
    public function index()
    {
        $this->_view->submenu = $this->_gallery->getGalleryCategoryList('pl', 1);
        
        if (is_numeric($this->_router->getItemSegments(2))) {
            $page_details = $this->_cms->getPageContent((int) $this->_router->getItemSegments(2), $this->_config->current_locale);

            if ($page_details['_redirect'] != '') {
                $this->_engine->addHttpHeader("Location: " . $page_details['_redirect']);
                exit();
            }

            $parent_page = $this->_cms->getPageRoot((int) $this->_router->getItemSegments(2), $this->_config->current_locale);

            $this->_view->parent_page = $parent_page;
            $this->_view->breadcrumb = $this->_cms->getPageBreadcrumb((int) $this->_router->getItemSegments(2), $this->_config->current_locale);

            if ($page_details['_metatitle'] != '') {
                $this->_head->title = $page_details['_metatitle'];
            }
            if ($page_details['_metakeywords'] != '') {
                $this->_head->keywords = $page_details['_metakeywords'];
            }
            if ($page_details['_metadescription'] != '') {
                $this->_head->description = $page_details['_metadescription'];
            }
            if ($page_details['_metascripts'] != '') {
                $this->_head->metascripts = $page_details['_metascripts'];
            }

            $this->_view->page_details = $page_details;
            $page_items = $this->_cms->getNodeItems((int) $page_details['node_id']);
            $page_content = '';

            foreach ($page_items as $key => $value) {
                // $item_details = $this->_cms->getNodeItem((int)$value['node_id']);
                switch ($value['module_id']) { // do sparametryzowania w ramach pliku konfiguracyjnego
                    case "1": // text
                        $item_content = $this->_cms->getTextContent((int) $value['object_id']);
                        $this->_view->item_details = $item_details;
                        $this->_view->item_content = $item_content;
                        $page_content .= $this->_view->render('modules/index/site/templates/view.node.item.tpl');
                        break;
                    case "2": // gallery
                        $this->_view->picture_list = $this->_gallery->getPictureForGalleryList((int) $value['object_id']);
                        $page_content .= $this->_view->render('modules/gallery/site/templates/view.node.item.tpl');
                        break;
                }
            }

            $this->_view->page_content = $page_content;
            if (!empty($page_details['_template'])) {
                $this->_engine->setToRender($page_details['_template']);
            } else {
                $this->_engine->setToRender('view.tpl'); // default template
            }
        } else {
            
            // strona główna 
            $this->_view->slider = $this->_slider->getSliderList('pl', 1);
            
            $this->_engine->_templateFile = 'site_index';
            $this->_engine->setToRender('index.tpl');
        }
    }
    
    
    public function portfolio ()
    {
        
        $page_details = array('node_code' => 'portfolio');
        
        $this->_view->submenu = $this->_gallery->getGalleryCategoryList('pl', 1);
        
        if ($this->_router->getItemSegments(2)) {           
            
            $code = $this->_router->getItemSegments(2);
            
            $page_details['_code'] = $code;
            
            $this->_view->page_details = $page_details;
            
            if($code === 'tags') {
                
                $this->_view->list = $this->_gallery->getRandomPictureFromTags(strtoupper($this->_router->getItemSegments(3)));
                $this->_view->category = array(
                    '_title' => $this->_config->const->_page_header->_value, 
                    '_description' => $this->_config->const->_page_description->_description
                );
                $this->_engine->setToRender('portfolio.tpl');
            } else if ($code === 'latest')  {
                $this->_view->list = $this->_gallery->getRandomPictureFromLatest(strtoupper($this->_router->getItemSegments(3)));
                $this->_view->category = array(
                    '_title' => $this->_config->const->_page_header->_value, 
                    '_description' => $this->_config->const->_page_description->_description
                );
                $this->_engine->setToRender('portfolio.tpl');
                
            } else if ($code === 'featured')  {
                $this->_view->list = $this->_gallery->getRandomPictureFromFeatured(strtoupper($this->_router->getItemSegments(3)));
                $this->_view->category = array(
                    '_title' => $this->_config->const->_page_header->_value, 
                    '_description' => $this->_config->const->_page_description->_description
                );
                $this->_engine->setToRender('portfolio.tpl');
                
            } else {
            
                if($this->_router->getItemSegments(3)) {
                    $gallery = $this->_gallery->getGalleryDetailsByCode($this->_router->getItemSegments(3));
                    $this->_view->gallery = $gallery;
                    $this->_view->list = $this->_gallery->getPictureForGalleryList($gallery['gallery_id']);

                    $category = $this->_gallery->getCategoryDetailsByCode($this->_router->getItemSegments(2));
                    $this->_view->category = $category;
                    $this->_view->galleries = $this->_gallery->getGalleryListForCategory($category['category_id']);
                    $this->_view->keywords	= $this->_gallery->getKeywordsForGallery($gallery['gallery_id']);

                    $this->_engine->setToRender('session.tpl');
                } else {
                    $category = $this->_gallery->getCategoryDetailsByCode($code);
                    $this->_view->category = $category;
                    $this->_view->list = $this->_gallery->getRandomPictureFromCategory($category['category_id']);

                    $this->_engine->setToRender('portfolio.tpl');
                }
            }
        } else {
            
            $this->_view->list = $this->_gallery->getPictureFromLevel1();
            $this->_view->category = array(
                '_title' => $this->_config->const->_page_header->_value, 
                '_description' => $this->_config->const->_page_description->_description
            );
            
            $this->_engine->setToRender('portfolio.tpl');
        }
    }
}
