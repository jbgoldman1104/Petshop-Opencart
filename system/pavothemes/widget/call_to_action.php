<?php

class PtsWidgetCall_to_action extends PtsWidgetPageBuilder {

        /**
         *
         */
        protected $max_image_size = 1048576;

        /**
         *
         */
        public $name = 'call_to_action';
        public $group = 'others';

        /**
         *
         */
        public static function getWidgetInfo()
        {
            return array('label' =>  ('Call To Action'), 'explain' => 'Create a block call to action', 'group' => 'others'  );
        }

        /**
         *
         */
        public function renderForm($args=null, $data)
        {
            $key = time();

            $helper = $this->getFormHelper();

            $this->fields_form[1]['form'] = array(
                'legend' => array(
                    'title' => $this->l('Widget Form.'),
                ),
                'input' => array(
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Icon File'),
                        'name'  => 'iconfile',
                        'class' => 'imageupload',
                        'default'=> '',
                        'id'     => 'iconfile'.$key,
                        'desc'  => 'Put image folder in the image folder ROOT_SHOP_DIR/image/'
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Icon Class'),
                        'name'  => 'iconclass',
                        'class' => 'image',
                        'default'=> '',
                        'desc'  => $this->l('Example: fa-umbrella fa-2 radius-x')
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
                        'name' => 'htmlcontent',
                        'cols' => 40,
                        'rows' => 10,
                        'value' => '',
                        'lang'  => true,
                        'default'=> '',
                        'autoload_rte' => true,
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Text Link 1'),
                        'name'  => 'text_link_1',
                        'default'=> '',
                        'lang'  => true,
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Link 1'),
                        'name'  => 'link_1',
                        'class' => 'link',
                        'default'=> '',
                        'lang'  => true,
                        'desc'  => $this->l('Enter url if you want')
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Text Link 2'),
                        'name'  => 'text_link_2',
                        'default'=> '',
                        'lang'  => true,
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Link 2'),
                        'name'  => 'link_2',
                        'class' => 'link',
                        'default'=> '',
                        'lang'  => true,
                        'desc'  => $this->l('Enter url if you want')
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l( 'Styles' ),
                        'name' => 'style',
                        'desc'  => 'Select image alignment',
                        'options' => array(  'query' => array(
                            array('id' => 'light-style', 'name' => $this->l('Light style')),
                            array('id' => 'call-to-action-v2', 'name' => $this->l('Call to action v2')),
                            array('id' => 'call-to-action-v3', 'name' => $this->l('Call to action v3')),
                            array('id' => 'call-to-action-v4 light-style', 'name' => $this->l('Call to action v4')),
                            array('id' => '', 'name' => $this->l('default')),
                        ),
                        'id' => 'id',
                        'name' => 'name' ),
                        'default' => "",
                    ),
                ),
                 'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'button'
                 )
            );

            $default_lang = (int)$this->config->get('config_language_id');

            $helper->tpl_vars = array(
                    'fields_value' => $this->getConfigFieldsValues( $data ),
                    'languages' => $this->config->get('config_language_id'),
                    'id_language' => $default_lang
            );

           $this->load->model('tool/image');
            $this->model_tool_image->resize('no_image.png', 100, 100);
            $placeholder  = $this->model_tool_image->resize('no_image.png', 100, 100);
        //  d( $this->token );
            $string = '



                     <script type="text/javascript">
                        $(".imageupload").WPO_Gallery({key:"'.$key.'",gallery:false,placehold:"'.$placeholder.'",baseurl:"'.HTTP_CATALOG . 'image/'.'" } );
                    </script>

            ';
            return  '<div id="imageslist'.$key.'">'.$helper->generateForm( $this->fields_form ) .$string."</div>" ;
        }


        /**
         *
         */
        public function renderContent($args, $setting)
        {
            $t  = array(
                'name'=> '',
                'iconfile'  => '',
                'iconclass' => '',
                'text_link_1' => '',
                'link_1' => '',
                'text_link_2' => '',
                'link_2' => '',
                'style' => '',
                'htmlcontent' => ''
            );

            $url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? HTTPS_SERVER : HTTP_SERVER;
            $url .= 'image/';

            $setting = array_merge( $t, $setting );

            $languageID =  $this->config->get('config_language_id');

            $setting['htmlcontent'] = isset($setting['htmlcontent_'.$languageID])?($setting['htmlcontent_'.$languageID]): '';
            $setting['text_link_1'] = isset($setting['text_link_1_'.$languageID])?($setting['text_link_1_'.$languageID]): '';
            $setting['link_1'] = isset($setting['link_1_'.$languageID])?($setting['link_1_'.$languageID]): '';
            $setting['text_link_2'] = isset($setting['text_link_2_'.$languageID])?($setting['text_link_2_'.$languageID]): '';
            $setting['link_2'] = isset($setting['link_2_'.$languageID])?($setting['link_2_'.$languageID]): '';

            if(!empty($setting['iconfile'])){
                $setting['iconurl'] = $url.$setting['iconfile'];
            }
            //d($setting);

            $output = array('type'=>'call_to_action','data' => $setting );

            return $output;
        }


    }
?>