<?php
namespace restinphp;
/**
 * This class is a representation of HTTP Request
 * @package restinphp
 * @author lorenzo muscariello
 * @version 0.1
 */
class Request
{

    private $method;
    private $body;
    private $contenttype;
    private $requesturi;
    
    public function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);        
        $this->contenttype = strtolower($_SERVER['CONTENT_TYPE']);
        $this->requesturi = $_SERVER['REQUEST_URI'];
    }
    
    /**
     *  Checks if request method is equals to $method
     *  @param string $method HTTP method
     *  @return boolean
     */
    private function checkMethod($method)
    {
        return strcmp(trim($this->method), $method) === 0;
    }
    
    /**
     * Checks if content type is equals to $ctype
     * @param string $ctype Content-Type to check against to
     * @return boolean
     */
    private function checkContentType($ctype)
    {
        return strcmp(trim($this->contenttype),$ctype) === 0;
    }
   
    /**
     * Returns the HTTP method of the specified request
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * Returns Content-type Header
     * @return string
     */
    public function getContentType()
    {
        return $this->contenttype;
    }
    
    /**
     * Returns HTTP Request URI
     * @return string 
     */
    public function getRequestURI()
    {
        return $this->requesturi;
    }
  
    /**
     * Returns true if body is of type application/json
     * @return boolean
     */
    public function isJSONBody()
    {
        return $this->checkContentType("application/json");
    }
    
    /**
     * Returns true if body is of type text/xml
     * @return boolean
     */
    public function isXMLBody()
    {
        return $this->checkContentType("text/xml");
    }
    
    /**
     * Returns true if body is of type multipart/form-data
     * @return boolean 
     */
    public function isFormDataBody()
    {
        return $this->checkContentType("multipart/form-data");
    }
    
    /**
     * Returns true if body is of type application/x-www-form-urlencoded
     * @return boolean
     */
    public function isFormUrlEncodedBody()
    {
        return $this->checkContentType("application/x-www-form-urlencoded");
    }
    
    /**
     * Returns true if request method is POST
     * @return boolean 
     */    
    public function isPost()
    {
        return $this->checkMethod("post");
    }
    
    /**
     * Returns true if request method is GET
     * @return boolean
     */
    public function isGet()
    {
        return $this->checkMethod("get");
    }
    
    /**
     * Returns true if request method is DELETE
     * @return boolean
     */
    public function isDelete()
    {
        return $this->checkMethod("delete");
    }
    
    /**
     * Returns true if request method is HEAD
     * @return boolean
     */
    public function isHead()
    {
        return $this->checkMethod("head");
    }
    
    /**
     * Returns true if request method is OPTIONS
     * @return boolean
     */
    public function isOptions()
    {
        return $this->checkMethod("options");
    }
    
    /**
     * Returns true if request method is PUT
     * @return boolean
     */
    public function isPut()
    {
        return $this->checkMethod("put");
    }
    
    /**
     * Returns an array of query string parameters    
     * @return array
     */
    public function getQueryStringParams()
    {
        return $_GET;
    }
    
    /**
     * Returns query string parameter named $param or null
     * @param string $param query string parameter name
     * @return string parameter value
     */  
    public function getQueryString($param)
    {
        if(array_contains_key($param,$_GET))
        {
            return $_GET[$param];
        }
        return null;
    }
    
    /**
     * Returns body as JSON object; Throws an Exception if content-type is not of type
     * application/json or if body is not a valid json
     * @param boolean $asArray if true returns parsed json as associative array
     * @return object/array
     */
    public function asJSON($asArray = false)
    {
        if($this->isJSONBody()) {
            $raw = file_get_contents("php://input");
            try {
                $rval = json_decode($raw,$asArray);
                if(json_last_error() == JSON_ERROR_NONE) {
                    return $rval;
                }
                else {
                    throw new \Exception("Malformed JSON");
                }
            }catch(Exception $ex) {
                throw new \Exception("Malformed JSON");
            }
        }
        else {
            throw new \Exception("Body is not of type application/json");
        }
    }
    
    /**
     * Returns body as XML document; throws an Exception if content-type is not of
     * type text/xml or if body is not a valid xml document.
     * @return object
     */
    public function asXML()
    {
        throw new \Exception("Not implemented Yet");
    }
    
    /**
     * Returns form data as associative array. Throws an Exception if content-type
     * is invalid.
     * @return array
     */
    public function asFormData()
    {
        if($this->isFormUrlEncodedBody()) {
            if($this->isPOST()) {
                return $_POST;
            }
            else {
                throw new \Exception("Form data in " . $this->getRequestMethod() .
                                   " requests is not supported yet");
            }
        }
        else {
            throw new \Exception("Body content is not form data");
        }
    }
}
