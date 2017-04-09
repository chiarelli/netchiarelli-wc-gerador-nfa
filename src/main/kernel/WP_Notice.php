<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace net\chiarelli\wp\plugin\gnfa\kernel;

/**
 * Description of WP_Notice
 * 
 * Dispara noticies no painel do administrador através do hook 'admin_notices'
 * 
 * É uma classe fachada. A classe que é verdadeiramente instanciada é 
 * net\chiarelli\wp\plugin\gnfa\kernel\inner\WP_Notice_real
 *
 * @author raphael
 */
abstract class WP_Notice {
    
    protected $notice;

    protected function __construct() { }
    
    static function getInstance() {
        return new inner\WP_Notice_inner();        
    }
            
    function success($msg_s, $title = '', $dismissible = true) {
        $this->buildNotice($msg_s, $title, 'notice-success', $dismissible);
    }
    
    function warning($msg_s, $title = '', $dismissible = true) {
        $this->buildNotice($msg_s, $title, 'notice-warning', $dismissible);
    }
    
    function error($msg_s, $title = '', $dismissible = true) {
         $this->buildNotice($msg_s, $title, 'notice-error', $dismissible);         
    }
    
    abstract function buildNotice($msg, $title, $class_css, $dismissible = true);
    
}

namespace net\chiarelli\wp\plugin\gnfa\kernel\inner;

use Assert\Assertion;
use net\chiarelli\wp\plugin\gnfa\hook\filter\HooksFilterManager;
use net\chiarelli\wp\plugin\gnfa\kernel\WP_Notice;
use Noodlehaus\Config;

/**
 * Description of WP_Notice_real
 * 
 * Classe auxiliar que é realmente instanciado ao cliente; porém a classe 
 * net\chiarelli\wp\plugin\gnfa\kernel\WP_Notice é uma Fachada.
 * 
 * 
 * @internal Classe interna. Somente para ser associada à classe WP_Notice.
 *
 * @author raphael
 */
class WP_Notice_inner extends WP_Notice {
    
    protected function __construct() {
        parent::__construct();
        add_action( 'admin_notices', array($this, 'registerNotice') );        
    }
   
    function registerNotice() {
        echo $this->notice;
    }
    
    function buildNotice($msg_s, $title, $class_css, $dismissible = true) {
            
        $class_dismiss = $dismissible ? 'is-dismissible' : '';
        $classes = array('notice', $class_css, $class_dismiss);
        $title_esc = esc_html($title);
        $_title = empty($title_esc) ? '' : "<h4>{$title_esc}</h4>";

        $this->notice = sprintf( 
                '<div class="%1$s"> %2$s %3$s</div>', 
                    esc_attr(implode(' ', $classes) ),
                    $_title,
                    $this->concatMsgs($msg_s)
        ); 
        
    }
    
    protected function concatMsgs($msg_s) {
        
        if(!is_array($msg_s)) {
            Assertion::string($msg_s);
            
            $msg_s = array($msg_s);
        }
        
        $rows = '';
        
        
        foreach ($msg_s as $msg) {
            
            Assertion::string($msg);
            
            $format = '<p>%1$s</p>';
            
            HooksFilterManager::REGISTER_gnfa_notice_row_msg_error(array(static::class, 'renderMsgNoticeError'), 10, 3);
            
            /**
             * gnfa_notice_row_msg_error hook
             * 
             * Esse filtro é para mudar a forma como as mensagens de notices 
             * são renderizadas
             * 
             * @package \net\chiarelli\wp\plugin\gnfa\hook\filter
             */
            $row = (string) apply_filters( 'gnfa_notice_row_msg_error', 
                    sprintf( $format, esc_html( $msg ) ), 
                    $format,
                    $msg
            );   
                        
            $rows .= $row; 
            $rows .= "\n\r"; 
        }
        
        return $rows;
    }
    
    static function renderMsgNoticeError($rendered, $format, $msg) {
        
        $conf = Config::load(GNFA_SRC_ASSETS.'/strings/errors.yml');
        
        $data = explode('|', $msg);        
        $key = array_shift($data);        
        $msg_format = $conf->get($key.'.value', $key);
        $msg_translate = __($msg_format, 'wc_gnfa');
        
        $msg_rendered = vsprintf($msg_translate, $data);
        
        return sprintf($format, $msg_rendered);
    }
    
}