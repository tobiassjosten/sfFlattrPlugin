<?php

/**
 * Add the javascript loader to response.
 *
 * @package     sfFlattrPlugin
 * @subpackage  filter
 * @author      Tobias Sjösten <tobias.sjosten@gmail.com>
 * @version     SVN: $Id$
 */
class sfFlattrFilter extends sfFilter
{
  /**
   * Insert loader code for applicable web requests.
   *
   * @param  sfFilterChain $filterChain
   */
  public function execute($filterChain)
  {
    $filterChain->execute();

    if (!$this->hasFlattrButton() || !$this->isTrackable())
    {
      return;
    }

    $loader = <<<LOADER
<script type="text/javascript">
//<![CDATA[
    (function() {
        var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];

        s.type = 'text/javascript';
        s.async = true;
        s.src = 'http://api.flattr.com/js/0.5.0/load.js?mode=auto';

        t.parentNode.insertBefore(s, t);
    })();
//]]>
</script>
LOADER;

    $response = $this->context->getResponse();

    $old = $response->getContent();
    $new = str_ireplace('</head>', "\n".$loader."\n</head>", $old);
    $response->setContent($new);
  }
  
  /**
   * Check response content for Flattr buttons.
   *
   * @return  bool
   */
  protected function hasFlattrButton()
  {
    $response = $this->context->getResponse();

    return strpos($response->getContent(), '<a class="FlattrButton') !== FALSE;
  }
  
  /**
   * Test whether the response is trackable.
   * 
   * @return  bool
   */
  protected function isTrackable()
  {
    $request    = $this->context->getRequest();
    $response   = $this->context->getResponse();
    $controller = $this->context->getController();
    
    // don't add analytics:
    // * for XHR requests
    // * if not HTML
    // * if 304
    // * if not rendering to the client
    // * if HTTP headers only
    if ($request->isXmlHttpRequest() ||
        strpos($response->getContentType(), 'html') === false ||
        $response->getStatusCode() == 304 ||
        $controller->getRenderMode() != sfView::RENDER_CLIENT ||
        $response->isHeaderOnly())
    {
      return false;
    }
    else
    {
      return true;
    }
  }
}
