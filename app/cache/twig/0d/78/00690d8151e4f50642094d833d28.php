<?php

/* <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8" />
    <title>{{ title }}</title>
  </head>
  <body></body>
  <script {% line 9 %}{{ mthaml_attributes([['src', ('/libs/assets/js/node.js')]], 'html5', 'UTF-8')|raw }}></script>
</html>
 */
class __TwigTemplate_0d7800690d8151e4f50642094d833d28 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"utf8\" />
    <title>";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</title>
  </head>
  <body></body>
  <script ";
        // line 9
        echo MtHaml\Runtime::renderAttributes(array(0 => array(0 => "src", 1 => "/libs/assets/js/node.js")), "html5", "UTF-8");
        echo "></script>
</html>
";
    }

    public function getTemplateName()
    {
        return "<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"utf8\" />
    <title>{{ title }}</title>
  </head>
  <body></body>
  <script {% line 9 %}{{ mthaml_attributes([['src', ('/libs/assets/js/node.js')]], 'html5', 'UTF-8')|raw }}></script>
</html>
";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 9,  34 => 5,  28 => 1,);
    }
}
