<?php
namespace HabrProxy\Core;

use DiDom\Document;

class Proxy
{
    private $Document;

    private $DomainToProxy = "https://habr.com";
    private $ListDomainToReplace = array("http://habrahabr.ru/", "http://habr.com/", "https://habrahabr.ru/", "https://habr.com/");

    private $LengthTextToModifie = 6;
    private $AdditionalLinkAttribute = "™";

    public function getPage(){
        $url = $_SERVER["PATH_INFO"];
        $this->Document = new Document($this->DomainToProxy . $url, true);
        $this->recursionSearch($this->Document->find('body')[0]);
        $this->replaceHabrHost();
        return $this->Document;
    }

    private function recursionSearch(&$parent){
        foreach ($parent->children() as $key => &$child){
            if ($child->hasChildren()){
                $this->recursionSearch($child);
            }else{
                $child->setValue($this->addParametrText($child->text()));
            }
        }

    }

    private function addParametrText($text){
        return preg_replace(
            "/\b(\w{".$this->LengthTextToModifie."})\b/ui",
            "$1".$this->AdditionalLinkAttribute,
            $text);
    }

    private function replaceHabrHost(){
        foreach ($this->Document->find('a') as $link){
            $link->attr('href',
                str_replace(
                    $this->ListDomainToReplace,
                    $_SERVER['SCRIPT_NAME']."/",
                    $link->getAttribute('href')
                )
            );
        }
    }
}