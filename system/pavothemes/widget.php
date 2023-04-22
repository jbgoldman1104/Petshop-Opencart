<?php 
    /******************************************************
     * @package Pav Opencart Theme Framework for Opencart 1.5.x
     * @version 3.0
     * @author http://www.pavothemes.com
     * @copyright   Copyright (C) April 2014 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
     * @license     GNU General Public License version 2
    *******************************************************/


    class PavWidgets {
        
        /**
         *
         */
        static $sds_current_hook; 
        
        /**
         *
         */
        static $static_widget_tags; 

        /**
         *
         */
        public static function  add_widget($tag,$func){
            self::$static_widget_tags[$tag] = $func;
        }
    
        public static function do_widget($content,$hook_name='') {
             
                $widget_tags = self::$static_widget_tags;  
                if (empty($widget_tags) || !is_array($widget_tags))
                        return $content;

                $pattern = self::get_widget_regex();
                
                self::$sds_current_hook = $hook_name;
                
             
                return preg_replace_callback( "/$pattern/s", array( "PavWidgets",'do_widget_tag'), $content );
                
        }

        public static function get_widget_attrs( $content, $hook_name='' ){

            $widget_tags = self::$static_widget_tags;  
                
                if (empty($widget_tags) || !is_array($widget_tags))
                        return $content;

                $pattern = self::get_widget_regex();
                
                self::$sds_current_hook = $hook_name;
                
                if( preg_match("/$pattern/s", $content, $match)){
                    return self::widget_parse_atts( $match[3] );
                }

               return array();

        }

  

        public static function do_widget_tag( $m ) {
                $widget_tags = self::$static_widget_tags;


                if( empty($widget_tags) ){
                    return ;
                }


                // allow [[foo]] syntax for escaping a tag
                if ( $m[1] == '[' && $m[6] == ']' ) {
                        return substr($m[0], 1, -1);
                }
              
                $tag = $m[2]; 
                $attr = self::widget_parse_atts( $m[3] );
         
                if ( isset( $m[5] ) ) {
                        // enclosing tag - extra parameter
                        return $m[1] . call_user_func( $widget_tags[$tag], $attr, $m[5], $tag, self::$sds_current_hook ) . $m[6];
                } else {
                        // self-closing tag
                        return $m[1] . call_user_func( $widget_tags[$tag], $attr, null,  $tag, self::$sds_current_hook ) . $m[6];
                }
        }
        public static function get_widget_regex() {
                
                $tagnames = array_keys(self::$static_widget_tags);
                $tagregexp = join( '|', array_map('preg_quote', $tagnames) );

                return
                          '\\['                              // Opening bracket
                        . '(\\[?)'                           // 1: Optional second opening bracket for escaping widgets: [[tag]]
                        . "($tagregexp)"                     // 2: Widgets name
                        . '(?![\\w-])'                       // Not followed by word character or hyphen
                        . '('                                // 3: Unroll the loop: Inside the opening widget tag
                        .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
                        .     '(?:'
                        .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
                        .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
                        .     ')*?'
                        . ')'
                        . '(?:'
                        .     '(\\/)'                        // 4: Self closing tag ...
                        .     '\\]'                          // ... and closing bracket
                        . '|'
                        .     '\\]'                          // Closing bracket
                        .     '(?:'
                        .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing widget tags
                        .             '[^\\[]*+'             // Not an opening bracket
                        .             '(?:'
                        .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing widget tag
                        .                 '[^\\[]*+'         // Not an opening bracket
                        .             ')*+'
                        .         ')'
                        .         '\\[\\/\\2\\]'             // Closing widget tag
                        .     ')?'
                        . ')'
                        . '(\\]?)';                          // 6: Optional second closing brocket for escaping widgets: [[tag]]
        }
            
        public static function widget_parse_atts($text) {
            $atts = array();
            $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
            $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
            if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
                foreach ($match as $m) {
                    if (!empty($m[1]))
                        $atts[strtolower($m[1])] = stripcslashes($m[2]);
                    elseif (!empty($m[3]))
                        $atts[strtolower($m[3])] = stripcslashes($m[4]);
                    elseif (!empty($m[5]))
                        $atts[strtolower($m[5])] = stripcslashes($m[6]);
                    elseif (isset($m[7]) and strlen($m[7]))
                        $atts[] = stripcslashes($m[7]);
                    elseif (isset($m[8]))
                        $atts[] = stripcslashes($m[8]);
                }
            } else {
                $atts = ltrim($text);
            }
            return $atts;
        }
            
        public static function widget_atts( $pairs, $atts, $widget = '' ) {
            $atts = (array)$atts;
            $out = array();
            foreach($pairs as $name => $default) {
                    if ( array_key_exists($name, $atts) )
                            $out[$name] = $atts[$name];
                    else
                            $out[$name] = $default;
            }            
         //   if ( $widget )
               //     $out = apply_filters( "widget_atts_{$widget}", $out, $pairs, $atts );

            return $out;
        }
            
        public static function strip_widgets( $content ) {
                $widget_tags = self::$static_widget_tags;

                if (empty($widget_tags) || !is_array($widget_tags))
                        return $content;

                $pattern = $this->get_widget_regex();

                return preg_replace_callback( "/$pattern/s", array($this,'strip_widget_tag'), $content );
        }

        public static function strip_widget_tag( $m ) {
                // allow [[foo]] syntax for escaping a tag
                if ( $m[1] == '[' && $m[6] == ']' ) {
                        return substr($m[0], 1, -1);
                }

                return $m[1] . $m[6];
        }
        
        public function parse ($str,$hook_name = '')
        {                   
            return self::do_widget($str,$hook_name);
        } 
        
    }
?>