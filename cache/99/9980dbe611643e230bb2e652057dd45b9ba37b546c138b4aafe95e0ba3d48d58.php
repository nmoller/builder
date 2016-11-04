<?php

/* layout.html */
class __TwigTemplate_f3d449b24222d05ad54b469e59bb17aa0189fb94a3c5985e4274731e16075f8b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\" />
    <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    ";
        // line 7
        $this->displayBlock('head', $context, $blocks);
        // line 12
        echo "</head>
    <body>
        <div id=\"content\">
            ";
        // line 15
        $this->displayBlock('content', $context, $blocks);
        // line 16
        echo "        </div>

        <div id=\"footer\">
            ";
        // line 19
        $this->displayBlock('footer', $context, $blocks);
        // line 22
        echo "        </div>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.4/foundation.js\"></script>
    </body>
</html>";
    }

    // line 7
    public function block_head($context, array $blocks = array())
    {
        // line 8
        echo "        <link rel=\"stylesheet\" href=\"/assets/style.css\" />
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.4/foundation.css\" />
        <title>";
        // line 10
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
    }

    public function block_title($context, array $blocks = array())
    {
    }

    // line 15
    public function block_content($context, array $blocks = array())
    {
    }

    // line 19
    public function block_footer($context, array $blocks = array())
    {
        // line 20
        echo "            &copy; Copyright 2011 by <a href=\"http://domain.invalid/\">you</a>.
            ";
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function getDebugInfo()
    {
        return array (  79 => 20,  76 => 19,  71 => 15,  61 => 10,  57 => 8,  54 => 7,  47 => 22,  45 => 19,  40 => 16,  38 => 15,  33 => 12,  31 => 7,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\" />
    <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    {% block head %}
        <link rel=\"stylesheet\" href=\"/assets/style.css\" />
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.4/foundation.css\" />
        <title>{% block title %}{% endblock %}</title>
    {% endblock %}
</head>
    <body>
        <div id=\"content\">
            {% block content %}{% endblock %}
        </div>

        <div id=\"footer\">
            {% block footer %}
            &copy; Copyright 2011 by <a href=\"http://domain.invalid/\">you</a>.
            {% endblock %}
        </div>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.4/foundation.js\"></script>
    </body>
</html>", "layout.html", "/home/nmoller/dev/builder/src/views/layout.html");
    }
}
