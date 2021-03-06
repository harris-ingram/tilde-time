<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

class TildeDocument
{
	private $className = 'document';
    private static $instance;
	private $tables;
	private $html_title;
	private $settings;
	private $_parts;
	private $_template;
	private $_template_tags;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }


    private function __construct()
    {
		$this->settings = TildeFactory::getSettings();
		$this->html_title = $this->settings->sitename;
		$this->_parts = array();
    }

    private function __clone()
    {
    }

 
    private function __wakeup()
    {
    }
	public function buildDocument(){
		$this->checkForRequest();
		$this->setCSSFiles($this->settings->template_path.'bootstrap/css/bootstrap.css');
		$this->setCSSFiles($this->settings->template_path.'bootstrap/css/bootstrap-theme.css');
		$this->setCSSFiles($this->settings->template_path.'css/template.css');
		$this->setCSSFiles($this->settings->template_path.'chosen/chosen.css');
		$this->setJSFiles('https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js');
		$this->setJSFiles($this->settings->template_path.'bootstrap/js/bootstrap.js');
	}
	public function setCKEditor(){
		$this->setJSFiles($this->settings->template_path.'ckeditor/ckeditor.js');
		//$this->setJSInline(' CKEDITOR.replace( \'message\' );');
	}
	public function setChosenSelect(){
		$this->setJSFiles($this->settings->template_path.'chosen/chosen.jquery.js');
		$this->setJSInline('jQuery(".chosen-select").chosen();');
	}
	private $cssFiles = array();
	private $cssInline = array();
	public function setCSSFiles($relPath){
		$this->cssFiles[$relPath] = $relPath;
		
	}
	public function setCSSInline($source){
		if(!in_array($source, $this->cssInline))
			$this->cssInline[] = $source;
	}
	public function makeStyle($source){
		return "\r\n".'<style>'.$source.'</style>';
	}
	public function getCSS(){
		$output = '';
		if(count($this->cssFiles)){
			foreach($this->cssFiles as $href){
				$output .= $this->makeLink($href, 'stylesheet');
			}
		}
		if(count($this->cssInline)){
			foreach($this->cssInline as $source){
				$output .= $this->makeStyle($source);
			}
		}
		return $output;
		
	}
	public function makeLink($href, $rel){
		$linkOut = 'href="'.$href.'"';
		if(!empty($rel))
			$linkOut .= ' rel="'.$rel.'"';
		
		return "\r\n".'<link '.$linkOut.'>';
	}
	private $jsFiles = array();
	private $jsInline = array();
	public function setJSFiles($relPath){
		$this->jsFiles[$relPath] = $relPath;
	}
	public function setJSInline($source){
		if(!in_array($source, $this->jsInline))
			$this->jsInline[] = $source;
	}
	public function makeScript($src,$content = ''){
		if(!empty($src))
			return "\r\n".'<script src="'.$src.'"></script>';
		
		return "\r\n".'<script>'.$content.'</script>';
		
	}
	public function getJS(){
		$output = '';
		if(count($this->jsFiles)){
			foreach($this->jsFiles as $src){
				$output .= $this->makeScript($src);
			}
		}
		if(count($this->jsInline)){
			foreach($this->jsInline as $source){
				$output .= $this->makeScript(null,$source);
			}
		}
		return $output;
		
	}
	private $fontFiles = array();
	public function getHeader(){
		$parts = new stdClass();
		$parts->js = $this->getJS();
		$parts->css = $this->getCSS();
		$this->_parts['header'] = $this->includeFile('header',$parts);
		return $this;
	}
	public function getFooter(){
		$parts = new stdClass();
		$this->_parts['footer'] = $this->includeFile('footer',$parts);
		return $this;
		
	}
	public function getContent(){
		$this->_parts['content'] = $this->includeFile('content');
		return $this;
		
	}
	public function getNavigation(){
		$this->_parts['navigation'] = $this->includeFile('navigation');
		return $this;
		
	}
	private function includeFile($fileName,$parts=null){
		$filePath = TILDE_PATH_TEMPLATE.'/'.$this->className.'/'.$fileName.'.php';
		if(file_exists($filePath)){
			ob_start();
			include($filePath);
			return ob_get_clean();
		}
		$filePath = TILDE_PATH_LIBRARIES.'/'.$this->className.'/'.$fileName.'.php';
		if(file_exists($filePath)){
			ob_start();
			include($filePath);
			return ob_get_clean();
		}else{
			echo 'Missing Required File for:'.$filePath;
		}
	}
	public function Redirect($url, $requestCode=302){
		$session_string = (isset($_GET['test']))?'&test=1':'';
		if(headers_sent()){
			ob_start();
			?>
			<script>
				window.location.replace("<?=$url.'&httpreq='.$requestCode.$session_string; ?>");
			</script>
			<?php
			return ob_get_clean();
		}else{
			$this->settings = TildeFactory::getSettings();
			header("Location: ".$this->settings->uri.'index.php?view=error'.$session_string,true,$requestCode);
		}
	}
	private function checkForRequest(){
		if(isset($_GET['httpreq'])&&!empty($_GET['httpreq'])){
			$session_string = (isset($_GET['test']))?'&test=1':'';
			$this->settings = TildeFactory::getSettings();
			//if($this->httpGetBuilder(array('httpreq'))!=$this->httpGetBuilder)
			$request = "Location: ".$this->settings->uri.'index.php?'.$this->httpGetBuilder(array('httpreq','test')).$session_string.'&HFGDG=1';
			header($request,true,$_GET['httpreq']);
		}
	}

	public function httpGetBuilder($exclude=array(),$include=array()){
		if(!is_array($exclude))$exclude = array( 0 => $exclude);
		$outString = array();
		if(empty($include)){
			foreach($_GET as $key => $val){
				if(!in_array($key,$exclude)){
					$outString[] = $key.'='.$val;
				}
			}
		}else{
			foreach($_GET as $key => $val){
				if(in_array($key,$include)&&!in_array($key,$exclude)){
					$outString[] = $key.'='.$val;
				}
			}
		}
		if(count($outString)==0)return '';
		return implode('&',$outString);
	}
	public function getPart($section_name){
		if(method_exists($this,'get'.ucfirst($section_name))){
			return $this->{'get'.ucfirst($section_name)}();
		}
		return '';
	}
	public function displayDocument(){
		ob_start();
			require_once TILDE_PATH_TEMPLATE.'/index.php';
		$this->_template = ob_get_clean();
		$this->_parseTemplate();
		//print_r($this->_template_tags);
		return $this->_renderTemplate();
	}
	protected function _renderTemplate(){
		$replace = array();
		$with = array();
		foreach($this->_template_tags as $docPart => $type){
			$this->getPart($type);
			
			$replace[] = $docPart;
			$with[] = $this->_parts[$type];
		}
		return str_replace($replace, $with, $this->_template);
	}
	protected function _parseTemplate()
	{
		$matches = array();

		if (preg_match_all('#<document:include\ type="([^"]+)"(.*)\/>#iU', $this->_template, $matches))
		{
			$this->_template_tags = array();

			// Step through the jdocs in reverse order.
			for ($i = count($matches[0]) - 1; $i >= 0; $i--)
			{
				$type = $matches[1][$i];

				$this->_template_tags[$matches[0][$i]] = $type;
				
			}

		}

		return $this;
	}
}
