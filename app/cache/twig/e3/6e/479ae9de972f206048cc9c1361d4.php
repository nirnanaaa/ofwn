<?php

/* <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8" />
    <title>{{ title }}</title>
  </head>
  <body></body>
</html>
 */
class __TwigTemplate_e36e479ae9de972f206048cc9c1361d4 extends Twig_Template
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
</html>
";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 5,  27 => 1,);
    }
}
