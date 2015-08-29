<?php

class IndexModel extends Engine_Model
{
    public static $_instance = null;
    private $_pages_tree = array();
    private $_breadcrumb = array();
    private $_locales;

    public function __construct()
    {
        parent::__construct();

        $this->_locales = $this->getSiteLocaleList();
    }

    public static function Instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getSiteStructure($mPageParentId = '1')
    {
        $select = $this->_db->select()->from(
                array('s' => 'site_structure'),
                array('*'))->joinLeft(
                        array('cp' => 'site_page'),
                        's.page_id = cp.page_id',
                        array('*')
                        )
                        ->where('s.parent_id= ?', (int) $mPageParentId)
                        ->order('s.page_order');

        $result = $this->_db->fetchAll($select);

        if ($result) {
            for ($i = 0; $i < count($result); ++$i) {
                $this->_pages_tree[$result[$i]['page_id']] = $result[$i];
                $this->getSiteStructure($result[$i]['page_id']);
            }
        }

        return $this->_pages_tree;
    }

    public function getPageRoot($pageId, $_lang)
    {
        $query_string = "SELECT ss.page_id, ss.parent_id, spc.page_name, spc._active AS page_active_global, sn.node_title
						FROM site_structure AS ss, site_page AS spc, site_node AS sn
						WHERE (ss.page_id = '".$pageId."' OR spc.page_id = '".$pageId."')
						AND sn.page_id = ss.page_id
						AND sn.lang_code = '".$_lang."'
						AND spc.page_id = ss.page_id";
        $result = $this->_db->fetchRow($query_string);

        if (!in_array('N', array($result['page_active_global']))) {
            array_unshift($this->_pages_tree, array(
                    'page_title' => $result['page_name'],
                    'node_title' => $result['node_title'],
                    'page_id' => $result['page_id'],
            ));
        }

        if ($result['parent_id'] != 0) {
            $this->getPageRoot($result['parent_id'], $_lang);
        }

        return $this->_pages_tree[0];
    }

    public function getPageBreadcrumb($page_id, $_lang)
    {
        $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                    )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                    )
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.page_id = ?', (int) $page_id);

        $result = $this->_db->fetchRow($select);

        if (!in_array('N', array($result['_active']))) {
            array_unshift($this->_breadcrumb, array(
                    'node_title' => $result['node_title'],
                    'page_id' => $result['page_id'],
                    '_lang' => $result['lang_code'],
            ));
        }

        if ($result['parent_id'] != 0) {
            $this->getPageBreadcrumb($result['parent_id'], $_lang);
        }

        return $this->_breadcrumb;
    }

    public function getMenuItem($page_id, $lang_code)
    {
        $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('*'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cn.lang_code = ?', $lang_code)
                                    ->where('s.parent_id= ?', (int) $page_id)
                                    ->order('s.page_order');

        $result = $this->_db->fetchAll($select);

        return $result;
    }

    public function getPageMenu($page_id, $root = '', $_lang)
    {
        $menu = array();
        $p_m = array();
        $list = array();
        $page_level = '1';
        $page_title = '';

        if (empty($root)) {
            $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id', 'page_level'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cp._active = ?', '1')
                                    ->where('cn._active = ?', '1')
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.page_id = ?', (int) $page_id)
                                    ->order('s.page_order');

            $result = $this->_db->fetchRow($select);

            if ($result) {
                $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id', 'page_level'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cp._active = ?', '1')
                                    ->where('cn._active = ?', '1')
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.parent_id = ?', (int) $result['page_id'])
                                    ->order('s.page_order');
                $p_m = $this->_db->fetchAll($select);

                /*	oznaczenie pozycji podmenu wybranej strony jako niewybranych	*/
                foreach ($p_m as $key => $value) {
                    if ($p_m[$key]['node_code'] == $page_id || $p_m[$key]['page_id'] == $page_id) {
                        $p_m[$key]['page_checked'] = 'T';
                    } else {
                        $p_m[$key]['page_checked'] = 'N';
                    }
                }

                $parent_id = $result['parent_id'];
                $page_level = $result['page_level'];

                for ($i = 1; $i <= 4; ++$i) {
                    $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cp._active = ?', '1')
                                    ->where('cn._active = ?', '1')
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.page_id = ?', (int) $page_id)
                                    ->order('s.page_order');

                    $row = $this->_db->fetchRow($select);

                    $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cp._active = ?', '1')
                                    ->where('cn._active = ?', '1')
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.parent_id = ?', (int) $row['parent_id'])
                                    ->where('s.parent_id != ?', '0')
                                    ->order('s.page_order');

                    $list = $this->_db->fetchAll($select);
                    if (count($list) != '0') {
                        foreach ($list as $key => $value) {
                            if ($list[$key]['node_code'] == $page_id || $list[$key]['page_id'] == $page_id) {
                                $list[$key]['page_checked'] = 'T';
                                $list[$key]['page_submenu'] = $p_m;
                            } else {
                                $list[$key]['page_checked'] = 'N';
                            }
                        }

                        /*
                        $query_string = "SELECT page_id, page_title FROM ".CMS_PAGES_CONTENT." WHERE page_id='".$result['page_parent_id']."' AND page_lang_code='".$_SESSION['lang']."'";
                        $result_title = $this->db->fetchRow($query_string);

                        $pageId = $result['page_parent_id'];
                        $page_title = $result_title['page_title'];
                        $page_id = $result_title['page_id'];
                        */

                        $page_id = $row['parent_id'];
                        $p_m = $list;
                    } else {

                        /*	oznaczenie pozycji podmenu wybranej strony jako niewybranych	*/
                        foreach ($p_m as $key => $value) {
                            if ($p_m[$key]['node_code'] == $result['page_id'] || $p_m[$key]['page_id'] == $result['page_id']) {
                                $p_m[$key]['page_checked'] = 'T';
                            } else {
                                $p_m[$key]['page_checked'] = 'N';
                            }
                        }

                        $list = $p_m;

                        /*
                        $query_string = "SELECT page_id, page_title FROM ".CMS_PAGES_CONTENT." WHERE (page_id='".$pageId."' OR page_code = '".$pageId."' AND page_lang_code='".$_SESSION['lang']."')";
                        $result_title = $this->db->fetchRow($query_string);

                        $page_title = $result_title['page_title'];
                        $page_id = $result_title['page_id'];
                        */
                    }
                }
            }
        } else {
            $query_string = '	SELECT st.page_id, sp.page_title, spc.page_code FROM '.CMS_PAGES_STRUCTURE.' st, '.CMS_PAGES.' sp, '.CMS_PAGES_CONTENT." spc
										WHERE st.page_parent_id='".$root."'
										AND sp.page_id=st.page_id
										AND sp.page_active='T'
										AND sp.page_show_menu='T'
										AND sp.page_template != '0'
										AND spc.page_active='T'
										AND spc.page_id=st.page_id
										AND spc.page_lang_code = '".$_SESSION['lang']."'
										AND (sp.page_date_from <= NOW() OR sp.page_date_from = '0000-00-00 00:00:00')
						 				AND (sp.page_date_to >= NOW() OR sp.page_date_to = '0000-00-00 00:00:00')
										ORDER BY st.page_order";

            $list = $this->db->fetchAll($query_string);

            foreach ($list as $key => $value) {
                if ($list[$key]['page_code'] == $pageId || $list[$key]['page_id'] == $pageId) {
                    $list[$key]['page_checked'] = 'T';
                    $list[$key]['page_submenu'] = $p_m;
                } else {
                    $list[$key]['page_checked'] = 'N';
                }
            }
        }

        $menu = array($list, $page_level, $page_title);
        
        return $list;
    }

    public function getPageMenuRoot($page_id, $root = '', $_lang)
    {
        $menu = array();
        $p_m = array();
        $list = array();
        $page_level = '1';
        $page_title = '';

        if (empty($root)) {
            $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id', 'page_level'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.page_id = ?', (int) $page_id)
                                    ->order('s.page_order');

            $result = $this->_db->fetchRow($select);

            if ($result) {
                $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id', 'page_level'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.parent_id = ?', (int) $result['page_id'])
                                    ->order('s.page_order');
                $p_m = $this->_db->fetchAll($select);

                /*	oznaczenie pozycji podmenu wybranej strony jako niewybranych	*/
                foreach ($p_m as $key => $value) {
                    $p_m[$key]['page_checked'] = 'N';
                }

                $parent_id = $result['parent_id'];
                $page_level = $result['page_level'];

                for ($i = 1; $i <= 4; ++$i) {
                    $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.page_id = ?', (int) $page_id)
                                    ->order('s.page_order');

                    $row = $this->_db->fetchRow($select);

                    $select = $this->_db->select()
                                    ->from(array('s' => 'site_structure'), array('page_id', 'parent_id'))
                                    ->joinLeft(
                                        array('cp' => 'site_page'),
                                        's.page_id = cp.page_id',
                                        array('*')
                                        )
                                    ->joinLeft(
                                        array('cn' => 'site_node'),
                                        's.page_id = cn.page_id',
                                        array('*')
                                        )
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('s.parent_id = ?', (int) $row['parent_id'])
                                    ->where('s.parent_id != ?', '0')
                                    ->order('s.page_order');

                    $list = $this->_db->fetchAll($select);
                    if (count($list) != '0') {
                        foreach ($list as $key => $value) {
                            if ($list[$key]['node_code'] == $page_id || $list[$key]['page_id'] == $page_id) {
                                $list[$key]['page_checked'] = 'T';
                                $list[$key]['page_submenu'] = $p_m;
                            } else {
                                $list[$key]['page_checked'] = 'N';
                            }
                        }

                        /*
                        $query_string = "SELECT page_id, page_title FROM ".CMS_PAGES_CONTENT." WHERE page_id='".$result['page_parent_id']."' AND page_lang_code='".$_SESSION['lang']."'";
                        $result_title = $this->db->fetchRow($query_string);

                        $pageId = $result['page_parent_id'];
                        $page_title = $result_title['page_title'];
                        $page_id = $result_title['page_id'];
                        */

                        $p_m = $list;
                    } else {
                        $list = $p_m;
                        /*
                        $query_string = "SELECT page_id, page_title FROM ".CMS_PAGES_CONTENT." WHERE (page_id='".$pageId."' OR page_code = '".$pageId."' AND page_lang_code='".$_SESSION['lang']."')";
                        $result_title = $this->db->fetchRow($query_string);

                        $page_title = $result_title['page_title'];
                        $page_id = $result_title['page_id'];
                        */
                    }
                }
            }
        } else {
            $query_string = '	SELECT st.page_id, sp.page_title, spc.page_code FROM '.CMS_PAGES_STRUCTURE.' st, '.CMS_PAGES.' sp, '.CMS_PAGES_CONTENT." spc
										WHERE st.page_parent_id='".$root."'
										AND sp.page_id=st.page_id
										AND sp.page_active='T'
										AND sp.page_show_menu='T'
										AND sp.page_template != '0'
										AND spc.page_active='T'
										AND spc.page_id=st.page_id
										AND spc.page_lang_code = '".$_SESSION['lang']."'
										AND (sp.page_date_from <= NOW() OR sp.page_date_from = '0000-00-00 00:00:00')
						 				AND (sp.page_date_to >= NOW() OR sp.page_date_to = '0000-00-00 00:00:00')
										ORDER BY st.page_order";

            $list = $this->db->fetchAll($query_string);

            foreach ($list as $key => $value) {
                if ($list[$key]['page_code'] == $pageId || $list[$key]['page_id'] == $pageId) {
                    $list[$key]['page_checked'] = 'T';
                    $list[$key]['page_submenu'] = $p_m;
                } else {
                    $list[$key]['page_checked'] = 'N';
                }
            }
        }

        $menu = array($list, $page_level, $page_title);
        //return $menu;
        return $list;
    }

    public function getPageList()
    {
    }

    public function getPageContent($page_id, $_lang)
    {
        $select = $this->_db->select()
                                    ->from(array('cp' => 'site_page'))
                                    ->joinLeft(
                                                array('cn' => 'site_node'),
                                                'cn.page_id = cp.page_id',
                                                array('*')
                                                )
                                    ->where('cn.lang_code = ?', $_lang)
                                    ->where('cp.page_id = ?', (int) $page_id);

        $this->_cSelect->setTags(array('index', 'getPageContent', 'page_'.(int) $page_id));
        $result = $this->_cSelect->fetch($select);

        return $result;
    }

    public function getNodeItems($node_id)
    {
        $select = $this->_db->select()
                                    ->from(array('sni' => 'site_node_item'))
                                    ->joinLeft(
                                                array('sm' => 'site_module'),
                                                'sni.module_id = sm.type_id',
                                                array('*')
                                                )
                                    ->order('sni._order')
                                    ->where('sni.node_id = ?', (int) $node_id);
        $result = $this->_db->fetchAll($select);

        return $result;
    }

    public function getPageContentList($node_id)
    {
        $select = $this->_db->select()
                                    ->from(array('sc' => 'site_content'))
                                    /*
                                    ->joinLeft(
                                                array('cn' => 'site_node'),
                                                'cn.object_id = cp.page_id AND cn.type_id = 1',
                                                array('*')
                                                )
                                    */
                                    ->where('sc.item_id = ?', (int) $node_id);

        $result = $this->_db->fetchAll($select);

        return $result;
    }

    /*	CMS FUNCTION	*/

    public static function ToSlug($string, $maxLength = 255, $separator = '-')
    {
        $url = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
        $url = preg_replace('/[^a-zA-Z0-9 -]/', '', $url);
        $url = trim(substr(strtolower($url), 0, $maxLength));
        //$url = preg_replace('/[' . $separator . ']+/', $separator, $url);
        $url = preg_replace('/\s+/', $separator, $url);

        return $url;
    }

    public function getTemplateList()
    {
        $select = $this->_db->select()
                                    ->from(array('ct' => 'site_templates'))
                                    ->order('ct.template_id');

        $result = $this->_db->fetchAll($select);

        return $result;
    }

    public function getPageDetails($page_id)
    {
        $select = $this->_db->select()
                                    ->from(array('cp' => 'site_page'))
                                    ->where('cp.page_id = ?', (int) $page_id);

        $result = $this->_db->fetchRow($select);

        return $result;
    }

    public function getNodeDetails($page_id, $lang_code)
    {
        $select = $this->_db->select()
                                    ->from(array('cp' => 'site_page'))
                                    ->joinLeft(
                                                array('cn' => 'site_node'),
                                                "cn.page_id = cp.page_id AND lang_code = '".$lang_code."'",
                                                array('*')
                                                )
                                    ->where('cp.page_id = ?', (int) $page_id);

        $result = $this->_db->fetchRow($select);

        return $result;
    }

    public function getNodeItem($item_id)
    {
        $select = $this->_db->select()
                                    ->from(array('sni' => 'site_node_item'))
                                    ->joinLeft(
                                                array('cn' => 'site_node'),
                                                'sni.node_id = cn.node_id',
                                                array('lang_code')
                                                )
                                    ->joinLeft(
                                                array('sn' => 'site_node'),
                                                'sn.node_id = sni.node_id',
                                                array('page_id')
                                                )
                                    ->where('sni.item_id = ?', (int) $item_id);

        $result = $this->_db->fetchRow($select);

        return $result;
    }

    public function getTextContent($content_id)
    {
        $select = $this->_db->select()
                                    ->from(array('sc' => 'site_content'))
                                    ->where('sc.content_id = ?', (int) $content_id);

        $result = $this->_db->fetchRow($select);

        return $result;
    }

    public function activePage($data)
    {
        $page = $this->getPageDetails($data['page_id']);

        $page['_active'] == '1' ? $active = '0' : $active = '1';

        $update = array(
                '_active' => $active,
                '_changed' => date('Y-m-d H:i:s'),
        );

        $this->_db->update('site_page', $update, "page_id = '".(int) $data['page_id']."'");

        return true;
    }

    public function addPageDetails($data)
    {
        $insert = array(
                'page_name' => $data['page_name'],
                '_template' => $data['_template'],
                '_start' => $data['_start'],
                '_stop' => $data['_stop'],
                '_active' => @(int) $data['_active'],
                '_created' => date('Y-m-d H:i:s'),
                '_changed' => date('Y-m-d H:i:s'),
        );

        $this->_db->insert('site_page', $insert);

        $page_id = $this->_db->lastInsertId();

        foreach ($this->_locales as $key => $value) {
            in_array($value['lang_code'], $data['lang_code']) ? $active = '1' : $active = '0';

            $insert = array(
                    'page_id' => $page_id,
                    'lang_code' => $value['lang_code'],
                    'node_code' => $this->ToSlug($data['page_name'].'-'.$value['lang_code']),
                    'node_title' => $data['page_name'].'-'.$value['lang_code'],
                    '_active' => $active,
                    '_redirect' => $data['content_redirect'],
                    '_metatitle' => $data['content_metatitle'],
                    '_metakeywords' => $data['content_metakeywords'],
                    '_metadescription' => $data['content_metadescription'],
                    '_metascripts' => $data['_metascripts'],
            );

            $this->_db->insert('site_node', $insert);
            $node_id = $this->_db->lastInsertId();

            $insert = array(
                    '_title' => '',
                    '_text' => '',
                    '_created' => date('Y-m-d H:i:s'),
            );

            $this->_db->insert('site_content', $insert);
            $object_id = $this->_db->lastInsertId();

            $insert = array(
                    'node_id' => $node_id,
                    'module_id' => '1',
                    'object_id' => $object_id,
                    '_active' => '1',
                    '_order' => '1',
            );

            $this->_db->insert('site_node_item', $insert);
        }

        if ($data['parent_id'] == '0') {
            $page_level = '1';
        } else {
            $query_string = $this->_db->select()->from('site_structure', array('page_order', 'page_level'))->where("page_id='".(int) $data['parent_id']."'");
            $result = $this->_db->fetchRow($query_string);
            $page_level = $result['page_level'] + 1;
        }
        $query_string = $this->_db->select()->from('site_structure', 'MAX(page_order) as page_order')->where("parent_id='".(int) $data['parent_id']."'");
        $result = $this->_db->fetchRow($query_string);
        $page_order = round($result['page_order'] + 10, -1);

        $insert = array(
                'page_id' => $page_id,
                'parent_id' => (int) $data['parent_id'],
                'page_order' => $page_order,
                'page_level' => $page_level,
        );

        $this->_db->insert('site_structure', $insert);

        return true;
    }

    public function savePageDetails($data)
    {
        $update = array(
                'page_name' => $data['page_name'],
                '_template' => $data['_template'],
                '_start' => $data['_start'],
                '_stop' => $data['_stop'],
                '_active' => @(int) $data['page_active'],
                '_changed' => date('Y-m-d H:i:s'),
        );

        $this->_db->update('site_page', $update, "page_id = '".(int) $data['page_id']."'");

        return true;
    }

    public function saveNodeDetails($data)
    {
        $update = array(
                'node_code' => $data['_code'],
                'node_title' => $data['node_title'],
                '_active' => @(int) $data['_active'],
                '_redirect' => $data['_redirect'],
                '_metatitle' => $data['_metatitle'],
                '_metakeywords' => $data['_metakeywords'],
                '_metadescription' => $data['_metadescription'],
                '_metascripts' => $data['_metascripts'],
        );

        $this->_db->update('site_node', $update, "node_id = '".(int) $data['node_id']."'");

        return true;
    }

    public function saveNodeItem($data)
    {
        if ((int) $data['object_id'] == '0') {
            $object_id = $this->saveContentDetails($data);
        } else {
            $this->saveContentDetails($data);
        }

        if ((int) $data['item_id'] == '0') {
            $insert = array(
                    'node_id' => (int) $data['node_id'],
                    'module_id' => $data['module_id'],
                    'object_id' => $object_id,
                    '_active' => @(int) $data['_active'],
                    '_order' => '1',
            );
            $this->_db->insert('site_node_item', $insert);
            $node_id = $this->_db->lastInsertId();
        } else {
            $update = array(
                    'node_id' => (int) $data['node_id'],
                    'module_id' => $data['module_id'],
                    'object_id' => $data['object_id'],
                    '_active' => @(int) $data['_active'],
                    '_order' => '1',
            );
            $this->_db->update('site_node_item', $update, "item_id = '".(int) $data['item_id']."'");
        }

        return true;
    }

    public function deleteNodeItem($data)
    {
        $item = $this->getNodeItem($data['item_id']);
        $this->_db->delete('site_node_item', "item_id 	= '".(int) $item['item_id']."'");
        if ($item['module_id'] == '1') {
            $this->deleteTextContent($item['object_id']);
        }

        return true;
    }

    public function addItemDetails($data)
    {
        $object_id = $data['object_id'];

        switch ($data['module_id']) {
            case '1':
                $object_id = $this->saveTextContent(array('_title' => 'tytuł bloku tekstowego', '_text' => 'zawartość bloku tekstowego'));
                break;
            case '2':
                $object_id = '0';
                break;
            default:
                break;
        }

        $insert = array(
                    'node_id' => $data['node_id'],
                    'module_id' => $data['module_id'],
                    'object_id' => $object_id,
                    '_active' => (int) $data['_active'],
                    '_order' => '1',
        );

        $this->_db->insert('site_node_item', $insert);

        return $result;
    }

    public function saveItemDetails($data)
    {
        switch ($data['module_id']) {
            case '1':
                $object_id = $data['content_id'];
                $this->saveTextContent($data);
                break;
            case '2':
                $object_id = $data['gallery_id'];
                break;
            default:
                break;
        }

        $update = array(
                    'module_id' => $data['module_id'],
                    'object_id' => $object_id,
                    '_active' => (int) $data['_active'],
                    '_order' => '1',
        );

        $this->_db->update('site_node_item', $update, "item_id = '".(int) $data['item_id']."'");

        return $result;
    }

    public function saveTextContent($data)
    {
        $row = array(
                '_title' => $data['_title'],
                '_text' => $data['_text'],
                '_changed' => date('Y-m-d H:i:s'),
        );

        if ((int) $data['item_id'] == '0') {
            $row['_created'] = date('Y-m-d H:i:s');
            $this->_db->insert('site_content', $row);
            $object_id = $this->_db->lastInsertId();
        } else {
            $this->_db->update('site_content', $row, "content_id = '".(int) $data['content_id']."'");
            $object_id = (int) $data['item_id'];
        }

        return $object_id;
    }

    public function deleteTextContent($content_id)
    {
        $this->_db->delete('site_content',    "content_id 	= '".(int) $content_id."'");

        return true;
    }

    public function movePageInStructure($data)
    {
        $query_string = '	SELECT p1.page_id as page_id, p1.parent_id as parent_id FROM site_structure p1, site_structure p2';
        $query_string .= "	WHERE p2.page_id='".$data['page_id']."'
							AND p1.parent_id=p2.parent_id
							AND p1.page_level=p2.page_level
							ORDER BY p1.page_order ";

        $result = $this->_db->fetchAll($query_string);
        $y = '0';

        $beforePage = array();
        $afterPage = array();

        foreach ($result as $key => $value) {
            if ($result[$key]['page_id'] == $data['page_id']) {
                $y = 1;
                $parent_id = $result[$key]['parent_id'];
            } elseif ($y == '0') {
                array_push($beforePage, $result[$key]['page_id']);
            } else {
                array_push($afterPage, $result[$key]['page_id']);
            }
        }

        if ($data['direction'] == 'UP') {
            array_unshift($afterPage, array_pop($beforePage));
        } else {
            array_push($beforePage, array_shift($afterPage));
        }

        array_push($beforePage, $data['page_id']);
        $pagesList = array_merge($beforePage, $afterPage);

        $page_order = 10;
        foreach ($pagesList as $key => $value) {
            $this->_db->update('site_structure', array('page_order' => $page_order), "page_id='".$value."' AND parent_id='".$parent_id."'");
            $page_order += 10;
        }

        return true;
    }

    public function deletePage($data)
    {
        $this->_db->delete('site_page',        "page_id 	= '".(int) $data['item_id']."'");
        $this->_db->delete('site_node',        "page_id 	= '".(int) $data['item_id']."'");
        //$this->_db->delete("site_content", 		"object_id 	= '".(int)$node_id."'");
        $this->_db->delete('site_structure',    "page_id 	= '".(int) $data['item_id']."'");
        $this->_db->update('site_structure', array('parent_id' => '0'), "parent_id = '".(int) $data['item_id']."'");

        return true;
    }

    public function deletePageContent($data)
    {
        $this->_db->delete('site_content',        "content_id = '".(int) $content_id."'");

        return true;
    }
}
